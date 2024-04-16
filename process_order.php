<?php
session_start();
include 'config.php';

if (isset($_POST['submit_order'])) {
    // Lấy thông tin từ form
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $user_id = $_SESSION['user_id'];

    // Tính toán tổng tiền từ các sản phẩm trong giỏ hàng
    $totalAmount = 0; // Khởi tạo biến tổng tiền
    $cart_sql = "SELECT item_id, quantity FROM cart_items WHERE user_id = '$user_id'";
    $cart_result = $conn->query($cart_sql);

    if ($cart_result->num_rows > 0) {
        while ($row = $cart_result->fetch_assoc()) {
            $item_id = $row['item_id'];
            $quantity = $row['quantity'];

            // Lấy giá của sản phẩm từ bảng menu_items để tính thành tiền
            $price_sql = "SELECT price FROM menu_items WHERE id = '$item_id'";
            $price_result = $conn->query($price_sql);
            if ($price_result->num_rows > 0) {
                $price_row = $price_result->fetch_assoc();
                $price = $price_row['price'];

                // Tính thành tiền cho từng sản phẩm
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal; // Cộng vào tổng tiền
            }
        }

        // Thêm thông tin đơn hàng vào bảng orders
        $insert_order_sql = "INSERT INTO orders (user_id, order_date, email, phone, address, note, total_amount)
                            VALUES ('$user_id', NOW(), '$email', '$phone', '$address', '$note', '$totalAmount')";
        $conn->query($insert_order_sql);

        // Lấy order_id của đơn hàng vừa thêm vào
        $order_id = $conn->insert_id;

        // Reset biến tổng tiền
        $totalAmount = 0;

        // Lấy thông tin chi tiết đơn hàng từ giỏ hàng và thêm vào bảng order_details
        $cart_result = $conn->query($cart_sql);
        if ($cart_result->num_rows > 0) {
            while ($row = $cart_result->fetch_assoc()) {
                $item_id = $row['item_id'];
                $quantity = $row['quantity'];

                // Lấy giá của sản phẩm từ bảng menu_items để tính thành tiền
                $price_sql = "SELECT price FROM menu_items WHERE id = '$item_id'";
                $price_result = $conn->query($price_sql);
                if ($price_result->num_rows > 0) {
                    $price_row = $price_result->fetch_assoc();
                    $price = $price_row['price'];

                    // Tính thành tiền cho từng sản phẩm
                    $subtotal = $price * $quantity;
                    $totalAmount += $subtotal; // Cộng vào tổng tiền

                    // Thêm thông tin chi tiết đơn hàng vào bảng order_details
                    $insert_detail_sql = "INSERT INTO order_details (order_id, item_id, quantity, price, subtotal)
                                          VALUES ('$order_id', '$item_id', '$quantity', '$price', '$subtotal')";
                    $conn->query($insert_detail_sql);
                }
            }

            // Xóa giỏ hàng sau khi đặt hàng thành công
            $delete_cart_sql = "DELETE FROM cart_items WHERE user_id = '$user_id'";
            $conn->query($delete_cart_sql);

            echo "Đặt hàng thành công!";
        } else {
            echo "Không có sản phẩm trong giỏ hàng!";
        }
    } else {
        echo "Không có sản phẩm trong giỏ hàng!";
    }
}

$conn->close();
?>
