<?php
// Kết nối đến cơ sở dữ liệu
@include 'config.php';

// Kiểm tra người dùng đã nhấn nút "Lưu" chưa
if (isset($_POST['save_item'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Kiểm tra và xử lý hình ảnh
    if (!empty($image)) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image = $_POST['old_image']; // Sử dụng ảnh cũ nếu không có ảnh mới
    }

    // Cập nhật thông tin món ăn trong cơ sở dữ liệu
    $sql = "UPDATE menu_items SET name='$name', price='$price', image='$image' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Cập nhật món ăn thành công!";
        header('location:admin_show.php');
        exit();
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
}

// Lấy thông tin món ăn cần chỉnh sửa từ cơ sở dữ liệu
$id = $_GET['id'];
$sql_select = "SELECT * FROM menu_items WHERE id=$id";
$result = $conn->query($sql_select);
$item = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Món Ăn</title>
    <link rel="stylesheet" href="./css/edit.css">
</head>
<body>
    <div class="container">
        <h1>Chỉnh Sửa Món Ăn</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
            <input type="hidden" name="old_image" value="<?php echo $item['image']; ?>">
            <label for="name">Tên Món Ăn:</label>
            <input type="text" id="name" name="name" value="<?php echo $item['name']; ?>" required><br>
            <label for="price">Giá (VNĐ):</label>
            <input type="number" id="price" name="price" value="<?php echo $item['price']; ?>" required><br>
            <label for="image">Hình Ảnh:</label>
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event);"><br>
            <img id="preview" src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="200"><br>
            <input type="submit" name="save_item" value="Lưu">
        </form>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('preview');
                preview.src = reader.result;
            }
            
            if (event.target.files.length > 0) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                preview.src = "images/<?php echo $item['image']; ?>"; // Hiển thị lại ảnh cũ
            }
        }
    </script>
</body>
</html>
