<?php
session_start();
require 'config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Truy vấn để lấy dữ liệu đơn hàng của khách hàng
$sql = "SELECT * FROM orders WHERE user_id = $user_id";
$result = $conn->query($sql);

// Kiểm tra xem truy vấn đã thành công hay không
if ($result !== false && $result->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Danh sách đơn hàng</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body{
                background-image: url('https://phunugioi.com/wp-content/uploads/2021/01/hinh-anh-bau-troi.jpg');
            }
        </style>
    </head>
    <body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Danh sách đơn hàng</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Mã giao dịch</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['note'] . "</td>";
                        echo "<td>" . $row['transaction_id'] . "</td>";
                        echo "<td>" . $row['total_quantity'] . "</td>";
                        echo "<td>" . number_format($row['total_amount'], 2) . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="user_page.php" class="btn-back">Quay lại trang chủ</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
} else {
    // Hiển thị thông báo khi không có dữ liệu
    echo "Không có đơn hàng nào.";
}

// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>
