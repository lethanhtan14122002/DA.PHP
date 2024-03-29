<?php
session_start();
include 'config.php';

if (isset($_POST['update_quantity'], $_POST['cart_item_id'], $_POST['new_quantity'])) {
    $cart_item_id = $_POST['cart_item_id'];
    $new_quantity = $_POST['new_quantity'];

    // Kiểm tra new_quantity có giá trị hợp lệ (lớn hơn 0) không
    if ($new_quantity > 0) {
        // Cập nhật số lượng sản phẩm trong giỏ hàng
        $update_sql = "UPDATE cart_items SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ii", $new_quantity, $cart_item_id);
        if ($stmt->execute()) {
            // Cập nhật thành công, điều hướng về trang giỏ hàng
            $stmt->close();
            $conn->close();
            header("Location: cart.php");
            exit();
        } else {
            // Có lỗi xảy ra trong quá trình cập nhật
            echo "Có lỗi xảy ra. Vui lòng thử lại sau.";
        }
    } else {
        // Số lượng mới không hợp lệ
        echo "Số lượng mới không hợp lệ.";
    }
} else {
    // Không có dữ liệu hợp lệ được gửi từ form
    header("Location: cart.php");
    exit();
}
?>
