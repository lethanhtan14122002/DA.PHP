<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Món Ăn</title>
    <link rel="stylesheet" href="./css/head.css">
    <link rel="stylesheet" href="./css/search.css">
    <link rel="stylesheet" href="./css/user.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <did class="head">
        <nav class="navbar">
            <ul class="nav-list">
                <li><a href="user_page.php" class="logo"><img src="images/Group 7.png" alt="Logo"></a></li>
                <li><a href="user_page.php">Trang Chủ</a></li>
                <li><a href="monnuong.php">Món Nướng</a></li>
                <li><a href="monchien.php">Món Chiên</a></li>
                <li><a href="monhap.php">Món Hấp</a></li>
                <li><a href="monxao.php">Món Xào</a></li>
                <li><a href="orders.php">Đơn hàng</a></li>
                <li><a href="thongtinkh.php">Thông Tin Tài Khoản</a></li>
                <li><a href="logout.php">Đăng Xuất</a></li>
            </ul>
        </nav>
    </did>
    <div class="logo1">
        <a href="favorites.php"><img src="anh/heart.png" alt="Heart" class="logo"></a>
    </div>
    <div class="logo2">
        <a href="cart.php"><img src="anh/shopping-cart.png" alt="shop" class="logo"></a>
    </div>
    <form id="searchForm" action="search.php" method="GET">
        <input type="text" placeholder="Tìm kiếm món ăn..." name="search" required>
        <img src="anh/search.png" alt="Tìm kiếm" class="logo" onclick="submitForm()">

    </form>
    <script>
        function submitForm() {
            document.getElementById("searchForm").submit();
        }
    </script>
    <br>
    <div id="banner">
        <div class="box-left">
            <h2>
                <span>THỨC ĂN</span>
                <br>
                <span>THƯỢNG HẠNG</span>
            </h2>
            <p>Chuyên cung cấp các món ăn đảm bảo dinh dưỡng
                hợp vệ sinh đến người dùng,phục vụ người dùng 1 cái
                hoàn hảo nhất</p>
            <button>Mua ngay</button>
        </div>
        <div class="box-right">
            <img src="images/img_1.png" alt="sh">
            <img src="images/img_2.png" alt="sh">
            <img src="images/img_3.png" alt="sh">
        </div>
        <div class="to-bottom">
            <a href="">
                <img src="images/banner.png" alt="sh">
            </a>
        </div>
    </div>

    <div class="nuong">
        <?php
        session_start(); // Bắt đầu session

        // Kiểm tra nếu chưa đăng nhập (chưa lưu user_id vào session) thì chuyển hướng đến trang đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: login_form.php");
            exit();
        }

        include 'config.php'; // Đảm bảo rằng file config.php đã kết nối đến cơ sở dữ liệu

        $userId = $_SESSION['user_id'];

        // Câu truy vấn SQL để đếm số lượng mỗi loại món ăn
        $sql = "
SELECT
    (SELECT COUNT(*) FROM menu_items WHERE deleted = 0 AND description LIKE '%nướng%') AS SoMonNuong,
    (SELECT COUNT(*) FROM menu_items WHERE deleted = 0 AND description LIKE '%chiên%') AS SoMonChien,
    (SELECT COUNT(*) FROM menu_items WHERE deleted = 0 AND description LIKE '%xào%') AS SoMonXao,
    (SELECT COUNT(*) FROM menu_items WHERE deleted = 0 AND description LIKE '%hấp%') AS SoMonHap
";

        $result = $conn->query($sql);

        if ($result) {
            $totals = $result->fetch_assoc();
            echo '<div class="sl1">Số món nướng: ' . $totals['SoMonNuong'] . '</div>';
            echo '<div class="sl2">Số món chiên: ' . $totals['SoMonChien'] . '</div>';
            echo '<div class="sl3">Số món xào: ' . $totals['SoMonXao'] . '</div>';
            echo '<div class="sl4">Số món hấp: ' . $totals['SoMonHap'] . '</div>';
        } else {
            echo "0 kết quả";
        }

        $conn->close();
        ?>
    </div>
    <div class="nuong2">
        <a href="http://localhost:8080/login%20system/login%20system/monnuong.php">
            <img src="images/banner.png">
        </a>

        <a href="http://localhost:8080/login%20system/login%20system/monchien.php">
            <img src="images/banner.png">
        </a>

        <a href="http://localhost:8080/login%20system/login%20system/monxao.php">
            <img src="images/banner.png">
        </a>

        <a href="http://localhost:8080/login%20system/login%20system/monhap.php">
            <img src="images/banner.png">
        </a>
    </div>

    <div class="container mt-5">
        <h1 class="mb-4">Danh Sách Món Ăn</h1>
        <div class="row">
            <?php

            if (!isset($_SESSION['user_id'])) {
                header("Location: login_form.php");
                exit();
            }

            include 'config.php';

            $userId = $_SESSION['user_id'];

            $sql = "SELECT * FROM menu_items WHERE deleted = 0 AND description NOT LIKE '%nướng%' AND description NOT LIKE '%xào%' AND description NOT LIKE '%chiên%' AND description NOT LIKE '%hấp%'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" class="tan" style="width: 100% , height: 30%;">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                    echo '<p class="card-text">' . (strlen($row['description']) > 20 ? substr($row['description'], 0, 20) . '...' : $row['description']) . '</p>';
                    echo '<a href="product_detail.php?id=' . $row['id'] . '">Chi tiết</a>';
                    echo '<p class="card-text">Giá: ' . number_format($row['price'], 0, ',', '.') . ' VNĐ</p>';
                    // Form để thêm vào danh sách yêu thích
                    echo '<form method="post" action="add_to_favorites.php">';
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="add_to_favorites" class="yeuthich">Yêu thích</button>';
                    echo '</form>';
                    // Form để thêm vào giỏ hàng
                    echo '<form method="post" action="add_to_cart.php">';
                    echo '<input type="hidden" name="user_id" value="' . $userId . '">'; // Thêm user_id ẩn vào form
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<input type="number" name="quantity" value="1" min="1" max="1000">'; // Chọn số lượng sản phẩm
                    echo '<button type="submit" name="add_to_cart" class="giohang">Giỏ hàng</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='col'><p>Không có món ăn nào.</p></div>";
            }
            $totalFavoritesByUser = []; // Mảng để lưu trữ tổng số lượng sản phẩm yêu thích cho mỗi user_id

            // Truy vấn để lấy tổng số lượng sản phẩm yêu thích cho mỗi user_id cùng giá trị với user_id từ session
            $sql = "SELECT user_id, COUNT(*) AS total_favorites FROM user_favorites WHERE user_id = $userId GROUP BY user_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $totalFavoritesByUser[$row['user_id']] = $row['total_favorites'];
                }
            }

            foreach ($totalFavoritesByUser as $user => $totalFavorites) {
                echo "<div class='total-favorites'>$totalFavorites</div>";
            }
            $totalQuantityInCart = 0;
            $sql = "SELECT SUM(quantity) AS total_quantity FROM cart_items WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalQuantityInCart = $row['total_quantity'];
            }
            echo "<div class='tong'>$totalQuantityInCart</div>";
            ?>

        </div>
    </div>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br>
</body>

</html>
<?php


include 'config.php';

// Kiểm tra nếu chưa đăng nhập (chưa lưu user_id vào session) thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Thay đổi câu truy vấn SQL để chỉ lấy những món có chứa từ khóa "nướng" trong tên
$sql = "SELECT * FROM menu_items WHERE deleted = 0 AND name LIKE '%nướng%' LIMIT 3";
$result = $conn->query($sql);

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
    <div id="banner">
        <div class="box-left">
            <h2>
                <span>THỨC ĂN</span>
                <br>
                <span>THƯỢNG HẠNG</span>
            </h2>
            <p>Chuyên cung cấp các món ăn đảm bảo dinh dưỡng
                hợp vệ sinh đến người dùng,phục vụ người dùng 1 cái
                hoàn hảo nhất</p>
            <button>Mua ngay</button>
        </div>
        <div class="box-right">
            <img src="images/img_1.png" alt="sh">
            <img src="images/img_2.png" alt="sh">
            <img src="images/img_3.png" alt="sh">
        </div>
        <div class="to-bottom">
            <a href="">
                <img src="anh/s-cach-lam-4-loai-sot-cham-mon-nuong-ngon-chuan-vi-nha-hang-ban-co-the-tu-tay-lam-tai-nha-1.jpg" alt="sh">
            </a>
        </div>
    </div>
    <div class="container mt-5">
        <h1 class="mb-4">Danh Sách Món Nướng</h1>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" class="tan" style="width: 100% , height: 30%;">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                    echo '<p class="card-text">' . (strlen($row['description']) > 20 ? substr($row['description'], 0, 20) . '...' : $row['description']) . '</p>';
                    echo '<a href="product_detail.php?id=' . $row['id'] . '">Chi tiết</a>';
                    echo '<p class="card-text">Giá: ' . number_format($row['price'], 0, ',', '.') . ' VNĐ</p>';
                    // Form để thêm vào danh sách yêu thích
                    echo '<form method="post" action="add_to_favorites.php">';
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="add_to_favorites" class="yeuthich">Yêu thích</button>';
                    echo '</form>';
                    // Form để thêm vào giỏ hàng
                    echo '<form method="post" action="add_to_cart.php">';
                    echo '<input type="hidden" name="user_id" value="' . $userId . '">'; // Thêm user_id ẩn vào form
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<input type="number" name="quantity" value="1" min="1" max="1000">'; // Chọn số lượng sản phẩm
                    echo '<button type="submit" name="add_to_cart" class="giohang">Giỏ hàng</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='col'><p>Không có món ăn nào.</p></div>";
            }
            ?>
            <div class="text-center mt-3">
                <button class="btn btn-primary" onclick="window.location.href = 'monnuong.php';">Xem thêm</button>
            </div>
            <br>
        </div>
    </div>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br>
</body>

</html>

<?php


include 'config.php';

// Kiểm tra nếu chưa đăng nhập (chưa lưu user_id vào session) thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Thay đổi câu truy vấn SQL để chỉ lấy những món có chứa từ khóa "nướng" trong tên
$sql = "SELECT * FROM menu_items WHERE deleted = 0 AND name LIKE '%chiên%' LIMIT 3";
$result = $conn->query($sql);

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
    <div id="banner">
        <div class="box-left">
            <h2>
                <span>THỨC ĂN</span>
                <br>
                <span>THƯỢNG HẠNG</span>
            </h2>
            <p>Chuyên cung cấp các món ăn đảm bảo dinh dưỡng
                hợp vệ sinh đến người dùng,phục vụ người dùng 1 cái
                hoàn hảo nhất</p>
            <button>Mua ngay</button>
        </div>
        <div class="box-right">
            <img src="images/img_1.png" alt="sh">
            <img src="images/img_2.png" alt="sh">
            <img src="images/img_3.png" alt="sh">
        </div>
        <div class="to-bottom">
            <a href="">
                <img src="anh/images.jpg" alt="sh">
            </a>
        </div>
    </div>
    <div class="container mt-5">
        <h1 class="mb-4">Danh Sách Món Chiên</h1>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" class="tan" style="width: 100% , height: 30%;">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                    echo '<p class="card-text">' . (strlen($row['description']) > 20 ? substr($row['description'], 0, 20) . '...' : $row['description']) . '</p>';
                    echo '<a href="product_detail.php?id=' . $row['id'] . '">Chi tiết</a>';
                    echo '<p class="card-text">Giá: ' . number_format($row['price'], 0, ',', '.') . ' VNĐ</p>';
                    // Form để thêm vào danh sách yêu thích
                    echo '<form method="post" action="add_to_favorites.php">';
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="add_to_favorites" class="yeuthich">Yêu thích</button>';
                    echo '</form>';
                    // Form để thêm vào giỏ hàng
                    echo '<form method="post" action="add_to_cart.php">';
                    echo '<input type="hidden" name="user_id" value="' . $userId . '">'; // Thêm user_id ẩn vào form
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<input type="number" name="quantity" value="1" min="1" max="1000">'; // Chọn số lượng sản phẩm
                    echo '<button type="submit" name="add_to_cart" class="giohang">Giỏ hàng</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='col'><p>Không có món ăn nào.</p></div>";
            }
            ?>
            <div class="text-center mt-3">
                <button class="btn btn-primary" onclick="window.location.href = 'monchien.php';">Xem thêm</button>
            </div>
        </div>
    </div>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br>
</body>

</html>

<?php


include 'config.php';

// Kiểm tra nếu chưa đăng nhập (chưa lưu user_id vào session) thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Thay đổi câu truy vấn SQL để chỉ lấy những món có chứa từ khóa "nướng" trong tên
$sql = "SELECT * FROM menu_items WHERE deleted = 0 AND name LIKE '%Hấp%' LIMIT 3";
$result = $conn->query($sql);

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
    <div id="banner">
        <div class="box-left">
            <h2>
                <span>THỨC ĂN</span>
                <br>
                <span>THƯỢNG HẠNG</span>
            </h2>
            <p>Chuyên cung cấp các món ăn đảm bảo dinh dưỡng
                hợp vệ sinh đến người dùng,phục vụ người dùng 1 cái
                hoàn hảo nhất</p>
            <button>Mua ngay</button>
        </div>
        <div class="box-right">
            <img src="images/img_1.png" alt="sh">
            <img src="images/img_2.png" alt="sh">
            <img src="images/img_3.png" alt="sh">
        </div>
        <div class="to-bottom">
            <a href="">
                <img src="anh/images (1).jpg" alt="sh">
            </a>
        </div>
    </div>
    <div class="container mt-5">
        <h1 class="mb-4">Danh Sách Món Hấp</h1>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" class="tan" style="width: 100% , height: 30%;">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                    echo '<p class="card-text">' . (strlen($row['description']) > 20 ? substr($row['description'], 0, 20) . '...' : $row['description']) . '</p>';
                    echo '<a href="product_detail.php?id=' . $row['id'] . '">Chi tiết</a>';
                    echo '<p class="card-text">Giá: ' . number_format($row['price'], 0, ',', '.') . ' VNĐ</p>';
                    // Form để thêm vào danh sách yêu thích
                    echo '<form method="post" action="add_to_favorites.php">';
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="add_to_favorites" class="yeuthich">Yêu thích</button>';
                    echo '</form>';
                    // Form để thêm vào giỏ hàng
                    echo '<form method="post" action="add_to_cart.php">';
                    echo '<input type="hidden" name="user_id" value="' . $userId . '">'; // Thêm user_id ẩn vào form
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<input type="number" name="quantity" value="1" min="1" max="1000">'; // Chọn số lượng sản phẩm
                    echo '<button type="submit" name="add_to_cart" class="giohang">Giỏ hàng</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='col'><p>Không có món ăn nào.</p></div>";
            }
            ?>
            <div class="text-center mt-3">
                <button class="btn btn-primary" onclick="window.location.href = 'monhap.php';">Xem thêm</button>
            </div>
        </div>
    </div>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br>
</body>

</html>

<?php


include 'config.php';

// Kiểm tra nếu chưa đăng nhập (chưa lưu user_id vào session) thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Thay đổi câu truy vấn SQL để chỉ lấy những món có chứa từ khóa "nướng" trong tên
$sql = "SELECT * FROM menu_items WHERE deleted = 0 AND name LIKE '%xào%' LIMIT 3";
$result = $conn->query($sql);

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
    <div id="banner">
        <div class="box-left">
            <h2>
                <span>THỨC ĂN</span>
                <br>
                <span>THƯỢNG HẠNG</span>
            </h2>
            <p>Chuyên cung cấp các món ăn đảm bảo dinh dưỡng
                hợp vệ sinh đến người dùng,phục vụ người dùng 1 cái
                hoàn hảo nhất</p>
            <button>Mua ngay</button>
        </div>
        <div class="box-right">
            <img src="images/img_1.png" alt="sh">
            <img src="images/img_2.png" alt="sh">
            <img src="images/img_3.png" alt="sh">
        </div>
        <div class="to-bottom">
            <a href="">
                <img src="anh/images (2).jpg" alt="sh">
            </a>
        </div>
    </div>
    <div class="container mt-5">
        <h1 class="mb-4">Danh Sách Món Xào</h1>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" class="tan" style="width: 100% , height: 30%;">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                    echo '<p class="card-text">' . (strlen($row['description']) > 20 ? substr($row['description'], 0, 20) . '...' : $row['description']) . '</p>';
                    echo '<a href="product_detail.php?id=' . $row['id'] . '">Chi tiết</a>';
                    echo '<p class="card-text">Giá: ' . number_format($row['price'], 0, ',', '.') . ' VNĐ</p>';
                    // Form để thêm vào danh sách yêu thích
                    echo '<form method="post" action="add_to_favorites.php">';
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="add_to_favorites" class="yeuthich">Yêu thích</button>';
                    echo '</form>';
                    // Form để thêm vào giỏ hàng
                    echo '<form method="post" action="add_to_cart.php">';
                    echo '<input type="hidden" name="user_id" value="' . $userId . '">'; // Thêm user_id ẩn vào form
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
                    echo '<input type="number" name="quantity" value="1" min="1" max="1000">'; // Chọn số lượng sản phẩm
                    echo '<button type="submit" name="add_to_cart" class="giohang">Giỏ hàng</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='col'><p>Không có món ăn nào.</p></div>";
            }
            ?>
            <div class="text-center mt-3">
                <button class="btn btn-primary" onclick="window.location.href = 'monxao.php';">Xem thêm</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br>

</body>

</html>

</html>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <?php
    include 'binhluannhai.php'
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="">

<head>
    <title>User Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/forder.css">
</head>

<body>

    <?php

    include 'forder.php';
    ?>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>