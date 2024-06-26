<?php
@include 'config.php';

session_start();

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = "SELECT id, user_type FROM user_form WHERE email = '$email' AND password = '$pass'";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);
      

      if ($row['user_type'] == 'admin') {
         $_SESSION['admin_name'] = $row['name'];
         // header('location: admin_show.php');
         header('location: admin_show.php');
         exit();
      } elseif ($row['user_type'] == 'user') {
         // Giữ nguyên thông tin admin, chỉ chuyển user sang $_SESSION['user_id']
         $_SESSION['user_id'] = $row['id']; // Chỉ chuyển user sang $_SESSION['user_id']
         $_SESSION['user_name'] = $row['name'];
         header('location: thongtinkh.php');
         // header('location: user_page.php');
         exit();
      }
   } else {
      $error[] = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <div class="form-container">

      <form action="" method="post">
         <h3>Login Now</h3>
         <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
         <input type="email" name="email" required placeholder="Enter your email">
         <input type="password" name="password" required placeholder="Enter your password">
         <input type="submit" name="submit" value="Login Now" class="form-btn">
         <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
      </form>

   </div>

</body>

</html>
