<?php
session_start();
include 'config.php';

// Kiểm tra nếu người dùng chưa đăng nhập thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_form WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['name'];
    $user_email = $row['email'];
    // Các thông tin khác của người dùng nếu cần
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="./css/thongtin.css"> <!-- Đường dẫn đến file CSS của bạn -->
</head>

<body>
    <div class="snowfall"></div> <!-- Chỗ để rơi tuyết -->
    <div class="container">
        <div class="content">
            <h3>User Information</h3>
            <p>Name: <?php echo $user_name; ?></p>
            <p>Email: <?php echo $user_email; ?></p>
            <!-- Thêm các thông tin khác của người dùng tại đây nếu cần -->
            <div class="actions">
                <a href="logout.php">Logout</a>
            </div>
            <a href="user_page.php">Quay lại</a> <!-- Liên kết để quay lại trang user_page.php -->
        </div>
    </div>
</body>

</html>
