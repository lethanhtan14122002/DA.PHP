<?php
// Kết nối đến cơ sở dữ liệu
@include 'config.php';

// Kiểm tra xem người dùng đã nhấn nút "Thêm" chưa
if (isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Upload hình ảnh vào thư mục images (cần tạo thư mục nếu chưa có)
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Thêm món ăn vào cơ sở dữ liệu
    $sql = "INSERT INTO menu_items (name, price, image) VALUES ('$name', '$price', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm món ăn thành công!";
        header('location:admin_show.php');
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    // Đóng kết nối
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
