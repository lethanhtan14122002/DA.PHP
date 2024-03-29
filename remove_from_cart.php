<?php
session_start();
include 'config.php';

if (isset($_GET['item_id'])) {
    // Lấy item_id từ URL
    $item_id = $_GET['item_id'];
    
    // Lấy user_id từ session
    $user_id = $_SESSION['user_id'];

    // Xóa sản phẩm từ giỏ hàng của người dùng
    $delete_sql = "DELETE FROM cart_items WHERE user_id = $user_id AND item_id = $item_id";
    $conn->query($delete_sql);

    // Đóng kết nối và điều hướng người dùng về trang giỏ hàng
    $conn->close();
    header("Location: cart.php");
    exit();
} else {
    // Nếu không có item_id được gửi, điều hướng người dùng về trang giỏ hàng
    header("Location: cart.php");
    exit();
}
?>
