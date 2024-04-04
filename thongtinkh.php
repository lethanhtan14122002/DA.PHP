<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['user_id'])) {
   header("Location: login_form.php");
   exit();
}

// Lấy thông tin người dùng từ session
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Page</title>
   <link rel="stylesheet" href="css/style.css"> <!-- Đường dẫn đến file CSS của bạn -->
</head>
<body>

   <div class="container">
      <div class="content">
         <h3>Welcome, <?php echo $user_name; ?></h3>
         <p>Email: <?php echo $user_email; ?></p>
         <div class="actions">
            <a href="logout.php">Logout</a>
         </div>
         <h1>User Page</h1>
         <!-- Thêm nội dung HTML của bạn tại đây -->
         <p>This is the user page content.</p>
         <a href="user_page.php">Quay lại</a> <!-- Liên kết để quay lại trang user_page.php -->
      </div>
   </div>

</body>
</html>
