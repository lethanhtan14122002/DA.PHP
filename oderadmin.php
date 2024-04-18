<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/amin2.css">
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
                            <a class="nav-link" href="adminbl.php">comment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="QLdonhang.php">Orders</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 p-4 main-content">
                <?php
                include 'QLdonhang.php'
                ?>
            </div>
        </div>
    </div>
</body>

</html>