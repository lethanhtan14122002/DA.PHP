<?php
session_start();
include 'config.php';

if (isset($_POST['submit_order'])) {
    $user_id = $_SESSION['user_id'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $email = $_POST['email'];
    $total_amount = $totalAmount; // Sử dụng tổng tiền đã tính trong trang hiển thị giỏ hàng

    // Insert thông tin đơn hàng vào bảng orders
    $insert_order_sql = "INSERT INTO orders (user_id, phone, address, note, email, total_amount) 
                         VALUES ('$user_id', '$phone', '$address', '$note', '$email', '$total_amount')";

    if ($conn->query($insert_order_sql) === TRUE) {
        // Lấy id của đơn hàng vừa thêm vào
        $order_id = $conn->insert_id;

        // Duyệt từng sản phẩm trong giỏ hàng để thêm vào bảng order_details
        foreach ($_SESSION['cart'] as $item) {
            $item_id = $item['item_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            // Insert từng sản phẩm vào bảng order_details
            $insert_detail_sql = "INSERT INTO order_details (order_id, item_id, quantity, price) 
                                  VALUES ('$order_id', '$item_id', '$quantity', '$price')";
            $conn->query($insert_detail_sql);
        }
        // Xóa giỏ hàng sau khi đã đặt hàng thành công
        unset($_SESSION['cart']);
        header("Location: order_success.php"); // Chuyển hướng đến trang thông báo đặt hàng thành công
        exit();
    } else {
        echo "Error: " . $insert_order_sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>