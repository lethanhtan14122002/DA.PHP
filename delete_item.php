<?php
// Kết nối đến cơ sở dữ liệu
@include 'config.php';

// Kiểm tra nếu có tham số id truyền vào từ URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Thực hiện truy vấn cập nhật giá trị deleted thành 1
    $sql = "UPDATE menu_items SET deleted = 1 WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa món ăn thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    // Đóng kết nối
    $conn->close();

    // Chuyển hướng về trang quản lý sau khi xóa
    header('location:admin_show.php');
    exit();
} else {
    // Nếu không có id được truyền vào, hiển thị thông báo lỗi
    echo "Lỗi: Không tìm thấy id để xóa!";
}
?>
