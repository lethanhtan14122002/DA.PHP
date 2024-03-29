<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Món Yêu Thích</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .thumbnail {
            max-width: 100px;
            height: auto;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mb-4">Danh Sách Món Yêu Thích</h1>
        <?php
        session_start();
        include 'config.php';

        if (!isset($_SESSION['user_id'])) {
            header('Location: login_form.php');
            exit();
        }

        $userId = $_SESSION['user_id'];

        $totalFavorites = 0; // Biến đếm tổng số lượng sản phẩm yêu thích

        // Truy vấn để lấy danh sách mặt hàng yêu thích của người dùng
        $sql = "SELECT menu_items.id, menu_items.name, menu_items.price, menu_items.image
                FROM user_favorites
                INNER JOIN menu_items ON user_favorites.item_id = menu_items.id
                WHERE user_favorites.user_id = $userId";
        $result = $conn->query($sql);

        // Hiển thị danh sách mặt hàng yêu thích trong bảng
        if ($result->num_rows > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Tên Mặt Hàng</th>';
            echo '<th>Ảnh</th>';
            echo '<th>Giá</th>';
            echo '<th>Xóa</th>'; // Thêm cột Xóa vào bảng
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $count = 1; // Biến đếm ID bắt đầu từ 1

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                // Sử dụng biến đếm làm ID
                echo '<td>' . $count . '</td>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td><img src="images/' . $row['image'] . '" alt="' . $row['name'] . '" class="thumbnail"></td>';
                echo '<td>' . number_format($row['price']) . ' VNĐ</td>';
                // Thêm nút Xóa với tham số item_id để xác định mặt hàng cần xóa
                echo '<td><a href="remove_favorite.php?item_id=' . $row['id'] . '" class="btn btn-danger">Xóa</a></td>';
                echo '</tr>';
                $count++; // Tăng biến đếm sau mỗi hàng
                $totalFavorites++; // Tăng tổng số lượng sản phẩm đã yêu thích
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p class="text-muted">Không có mặt hàng nào trong danh sách yêu thích.</p>';
        }

        echo '<p>Tổng số lượng sản phẩm đã yêu thích: ' . $totalFavorites . '</p>';
        
        // Đóng kết nối
        $conn->close();
        
        ?>

        <!-- Nút quay lại trang đăng nhập -->
        <button id="backToLoginBtn" class="btn btn-primary mt-3">Quay lại trang sản phẩm </button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // JavaScript để xử lý sự kiện click cho nút quay lại
        document.getElementById("backToLoginBtn").addEventListener("click", function() {
            window.location.href = "user_page.php"; // Chuyển hướng đến trang đăng nhập
        });
    </script>
</body>

</html>