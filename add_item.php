<?php
session_start();
include 'config.php';

// Kiểm tra khi người dùng nhấn nút "ADD"
if (isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $description = $_POST['description']; // Lấy thông tin mô tả

    // Upload hình ảnh vào thư mục images (cần tạo thư mục nếu chưa có)
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Thêm thông tin sản phẩm vào giỏ hàng
    $_SESSION['cart'][] = array(
        'name' => $name,
        'price' => $price,
        'image' => $image,
        'description' => $description // Thêm thông tin mô tả vào giỏ hàng
    );

    // Thêm sản phẩm vào cơ sở dữ liệu
    $sql = "INSERT INTO menu_items (name, price, image, description) VALUES (?, ?, ?, ?)";

    // Sử dụng prepared statement để thêm sản phẩm vào cơ sở dữ liệu
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $price, $image, $description);

    if ($stmt->execute()) {
        echo "Thêm món ăn vào giỏ hàng và cơ sở dữ liệu thành công!";
        header('location: admin_show.php'); // Chuyển hướng về trang hiển thị danh sách món ăn
        exit();
    } else {
        echo "Lỗi khi thêm món ăn vào cơ sở dữ liệu: " . $stmt->error;
        exit();
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Món Ăn</title>
    <link rel="stylesheet" href="./css/add.css">
</head>

<body>
    <h1>Thêm Món Ăn</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Tên Món Ăn:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="price">Giá (VNĐ):</label>
        <input type="number" id="price" name="price" required><br><br>
        <label for="description">Mô Tả:</label>
        <textarea id="description" name="description" required></textarea><br><br>
        <label for="image">Hình Ảnh:</label>
        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event);" required><br><br>
        <img id="preview" src="#" alt="Ảnh xem trước" width="200" style="display: none;"><br><br>
        <input type="submit" name="add_item" value="ADD">
    </form>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>