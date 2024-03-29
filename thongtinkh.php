<?php
session_start(); // Bắt đầu session

// Kiểm tra nếu chưa đăng nhập (chưa lưu user_id vào session) thì chuyển hướng đến trang đăng nhập
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login_form.php");
//     exit();
// }
if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];
} else {
    // Nếu không có email trong phiên, có thể chuyển hướng người dùng đến trang khác hoặc xử lý khác
    exit('Email not found in session!');
}
include 'config.php';

$userId = $_SESSION['user_id'];

// Truy vấn để lấy thông tin khách hàng từ cơ sở dữ liệu
$sql = "SELECT email, name FROM user_form WHERE id = $userId";
$result = $conn->query($sql);

$userInfo = $result->fetch_assoc(); // Lấy thông tin khách hàng từ kết quả truy vấn

// Hiển thị thông tin khách hàng trên trang
if ($userInfo) {
    $email = $userInfo['email'];
    $name = $userInfo['name'];
} else {
    // Xử lý trường hợp không tìm thấy thông tin khách hàng
    $email = "Không xác định";
    $name = "Không xác định";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Món Ăn</title>
    <link rel="stylesheet" href="./css/user.css">
</head>

<body>
    <!-- Code HTML của bạn -->
    <div class="container mt-5">
        <h1 class="mb-4">Danh Sách Món Ăn</h1>
        <!-- Hiển thị tên và email của khách hàng -->
        <div>
            <p>Tên khách hàng: <?php echo $name; ?></p>
            <p>Email: <?php echo $email; ?></p>
        </div>
        <!-- Code HTML khác của bạn -->
    </div>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
