<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login_form.php');
    exit();
}

if (isset($_GET['item_id'])) {
    $itemId = $_GET['item_id'];
    $userId = $_SESSION['user_id'];

    // Thực hiện truy vấn xóa mặt hàng yêu thích của người dùng
    $sql = "DELETE FROM user_favorites WHERE user_id = $userId AND item_id = $itemId";
    if ($conn->query($sql) === TRUE) {
        echo "Đã xóa mặt hàng yêu thích thành công.";
        header('location: favorites.php');
    } else {
        echo "Lỗi: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Không tìm thấy item_id.";
}
?>
