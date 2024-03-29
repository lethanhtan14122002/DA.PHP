<?php
session_start();
include 'config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Truy vấn để lấy thông tin giỏ hàng của người dùng
$sql = "SELECT cart_items.item_id, menu_items.name, menu_items.price, menu_items.image, cart_items.quantity
        FROM cart_items
        INNER JOIN menu_items ON cart_items.item_id = menu_items.id
        WHERE cart_items.user_id = $user_id";

$result = $conn->query($sql);

// Khởi tạo biến tổng số lượng hàng và tổng số tiền
$totalQuantity = 0;
$totalAmount = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn</title>
    <style>
        .quaylai {
            margin-top: 20px;
            padding: 10px 40px;
            background: #0062cc;
            color: white;
            font-size: 20px;

        }

        .quaylai:hover {
            background: aqua;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Hóa đơn</h1>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $subtotal = $row['price'] * $row['quantity']; // Tính thành tiền cho từng sản phẩm
                            $totalQuantity += $row['quantity']; // Cộng số lượng vào tổng số lượng hàng
                            $totalAmount += $subtotal; // Cộng thành tiền vào tổng số tiền

                            echo '<tr>';
                            echo '<td><img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" class="img-thumbnail" width="100"></td>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . number_format($row['price'], 0, ',', '.') . ' VNĐ</td>';
                            echo '<td>' . $row['quantity'] . '</td>';
                            echo '<td>' . number_format($subtotal, 0, ',', '.') . ' VNĐ</td>'; // Hiển thị thành tiền
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='5'>Giỏ hàng của bạn đang trống.</td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td>Tổng số lượng: <?php echo $totalQuantity; ?></td>
                        <td>Tổng tiền: <?php echo number_format($totalAmount, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                </tfoot>
            </table>
            <form method="post" action="process_order.php">
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="note">Nội dung:</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                </div>
                <input type="hidden" name="email" value="<?php echo $_SESSION['user_email']; ?>">
                <!-- Thêm nút Submit để gửi đơn hàng -->
                <button type="submit" name="submit_order" class="btn btn-primary">Đặt hàng</button>
            </form>
            <form method="post" action="cart.php">
                <button type="submit" name="back_to_user" class="quaylai">Quay lại trang</button>
            </form>
        </div>
    </div>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</body>

</html>

<?php
$conn->close();
?>