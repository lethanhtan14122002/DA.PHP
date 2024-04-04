<?php
session_start();
include 'config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Truy vấn để lấy thông tin giỏ hàng của người dùng (chỉ lấy các hàng chưa bị xóa)
$sql = "SELECT cart_items.id, cart_items.item_id, menu_items.name, menu_items.price, menu_items.image, cart_items.quantity
        FROM cart_items
        INNER JOIN menu_items ON cart_items.item_id = menu_items.id
        WHERE cart_items.user_id = $user_id"; // Áp dụng điều kiện is_deleted = 0

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="./css/update.css">
    
</head>

<body>
    <div class="container mt-5">
        <h1>Giỏ hàng của bạn</h1>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Sửa số lượng</th>
                        <th>Xóa sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td><img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" class="img-thumbnail" width="100"></td>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . number_format($row['price'], 0, ',', '.') . ' VNĐ</td>';
                            echo '<td>' . $row['quantity'] . '</td>';
                            echo '<td>';
                            echo '<form method="post" action="update_cart_item.php">';
                            echo '<input type="hidden" name="cart_item_id" value="' . $row['id'] . '">';
                            echo '<input type="number" name="new_quantity" value="' . $row['quantity'] . '" min="1" max="1000">';
                            echo '<button type="submit" name="update_quantity" class="tan">Cập nhật</button>';
                            echo '</form>';
                            echo '</td>';
                            echo '<td><a href="remove_from_cart.php?item_id=' . $row['item_id'] . '" class="btn btn-danger">Xóa</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='6'>Giỏ hàng của bạn đang trống.</td></tr>";
                    }
                    if (!($result->num_rows == 0)) {
                        echo '<form method="post" action="checkout.php">';
                        echo '<button type="submit" name="checkout" class="thanhtoan">Thanh toán</button>';
                        echo '</form>';
                    } else {
                        echo '<p class="text-danger">Giỏ hàng của bạn đang trống, không thể thanh toán!</p>';
                    }
                    ?>
                </tbody>
            </table>
            
            <form method="post" action="user_page.php">
                <button type="submit" name="back_to_user" class="quaylai">Quay lại trang</button>
            </form>
            <!-- Nút Thanh toán -->
            
        </div>
    </div>
</body>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</html>

<?php
$conn->close();
?>
