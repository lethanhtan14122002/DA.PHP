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
                <li><a href="#mon-xao">Đơn hàng</a></li>
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
    <div class="container mt-5">
        <h1 class="mb-4">Danh Sách Món Xào</h1>
        <div class="row">
            <?php
            session_start(); // Bắt đầu session
            // Kiểm tra nếu chưa đăng nhập (chưa lưu user_id vào session) thì chuyển hướng đến trang đăng nhập
            if (!isset($_SESSION['user_id'])) {
                header("Location: login_form.php");
                exit();
            }

            include 'config.php';

            $userId = $_SESSION['user_id'];

            $sql = "SELECT * FROM menu_items WHERE deleted = 0 AND name LIKE '%xào%'";
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

</body>

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
</html>
