<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="./css/adminbl.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /* Add some padding to the top of the page */
        body {
            padding-top: 5rem;
        }

        /* Style the sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 1rem;
            background-color: #f5f5f5;
            width: 200px;
        }

        /* Style the main content area */
        .main-content {
            padding: 2rem;
            margin-left: 200px;
        }

        /* Style the navigation bar */
        .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 200px;
            z-index: 100;
            padding: 0.5rem;
            background-color: #f5f5f5;
        }

        /* Style the navigation links */
        .navbar-nav .nav-link {
            color: #333;
        }

        /* Style the active navigation link */
        .navbar-nav .nav-link.active {
            font-weight: bold;
        }
    </style>
</head>

<body>
<?php
// Kết nối đến cơ sở dữ liệu
@include 'config.php';
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
   header("Location: login_form.php");
   exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT name FROM user_form WHERE id = $user_id";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
   $row_user = $result_user->fetch_assoc();
   $_SESSION['user_name'] = $row_user['name'];
}
?>
    <div class="tren">
        <a class="navbar-brand" href="logout.php"><img src="./anh/logout.png" alt="no"></a>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0 bg-light">
                <div class="sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <img src="https://img4.thuthuatphanmem.vn/uploads/2020/12/26/hinh-anh-con-cua-tim_051242792.jpg" alt="no">
                            <br>
                            <a class="navbar-brand" href="#">Admin : </a>
                            <h3><span><?php echo $_SESSION['user_name'] ?></span></h3>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Customers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sizes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="binhluanadmin.php">comment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Orders</a>
                        </li>
                    </ul>
                </div>
            </div>    
        </div>
    </div>
    <div class="binhluan">
        <?php
        include 'binhluanadmin.php';
        ?>
    </div>
</body>

</html>