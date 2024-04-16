<?php
session_start();
include 'config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Cập nhật trạng thái is_deleted của giỏ hàng thành 1
$update_sql = "UPDATE cart_items SET is_deleted = 1 WHERE user_id = $user_id";
$conn->query($update_sql);

// Đóng kết nối database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS styles here */
    </style>
</head>

<body>
    <div class="container">
        <h1>Đặt hàng thành công</h1>
        <div class="success-message">
            <p>Cảm ơn bạn đã đặt hàng của chúng tôi!</p>
            <p>Đơn hàng của bạn đã được ghi nhận.</p>
        </div>
        <a href="user_page.php" class="btn-back">Quay lại trang chủ</a>
    </div>
</body>

</html>

