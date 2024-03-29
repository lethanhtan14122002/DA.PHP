<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    // Kiểm tra sự tồn tại của các key trong $_POST
    if (isset($_POST['user_id'], $_POST['item_id'], $_POST['quantity'])) {
        include 'config.php';

        $user_id = $_POST['user_id'];
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];

        // Sử dụng prepared statement để tránh SQL Injection
        $check_sql = "SELECT * FROM cart_items WHERE user_id = ? AND item_id = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ii", $user_id, $item_id);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Nếu hàng đã tồn tại, cập nhật số lượng
            $update_sql = "UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND item_id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("iii", $quantity, $user_id, $item_id);
            $stmt->execute();
        } else {
            // Nếu hàng chưa tồn tại, thêm mới vào giỏ hàng
            $insert_sql = "INSERT INTO cart_items (user_id, item_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("iii", $user_id, $item_id, $quantity);
            $stmt->execute();
        }

        // Đóng kết nối và điều hướng người dùng
        $stmt->close();
        $conn->close();

        header("Location: user_page.php");
        exit();
    } else {
        // Nếu không tồn tại thông tin đúng từ form, điều hướng người dùng
        header("Location: register_form.php");
        exit();
    }
} else {
    // Nếu không có action 'add_to_cart' được gửi từ form, điều hướng người dùng
    header("Location: login_form.php");
    exit();
}
?>
