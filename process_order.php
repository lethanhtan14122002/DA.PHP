<?php
session_start();
require 'config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];

// Lấy thông tin từ form gửi qua POST
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$note = mysqli_real_escape_string($conn, $_POST['note']);

// Truy vấn để lấy thông tin giỏ hàng của người dùng
$sql = "SELECT cart_items.item_id, menu_items.name, menu_items.price, menu_items.image, cart_items.quantity
        FROM cart_items
        INNER JOIN menu_items ON cart_items.item_id = menu_items.id
        WHERE cart_items.user_id = $user_id";

$result = $conn->query($sql);

// Khởi tạo biến tổng số lượng hàng và tổng số tiền
$totalQuantity = 0;
$totalAmount = 0;

// Mảng chứa thông tin các sản phẩm trong giỏ hàng
$items = array();

// Kiểm tra xem có dữ liệu trong kết quả truy vấn hay không
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subtotal = $row['price'] * $row['quantity'];
        $totalQuantity += $row['quantity'];
        $totalAmount += $subtotal;

        // Thêm thông tin sản phẩm vào mảng
        $item = array(
            'name' => $row['name'],
            'price' => $row['price'],
            'quantity' => $row['quantity']
        );
        $items[] = $item;
    }
} else {
    echo "Giỏ hàng của bạn đang trống.";
    exit();
}

// Lưu thông tin đơn hàng vào cơ sở dữ liệu
$insertOrderSql = "INSERT INTO orders (user_id, email, phone, address, note, total_quantity, total_amount) 
                    VALUES ('$user_id', '$email', '$phone', '$address', '$note', '$totalQuantity', '$totalAmount')";
if ($conn->query($insertOrderSql) === TRUE) {
    // Xóa giỏ hàng sau khi đặt hàng thành công
    $deleteCartItemsSql = "DELETE FROM cart_items WHERE user_id = $user_id";
    if ($conn->query($deleteCartItemsSql) === TRUE) {
        echo "Đơn hàng của bạn đã được đặt thành công.";
        header('location: order_success.php');
    } else {
        echo "Có lỗi xảy ra khi xóa giỏ hàng: " . $conn->error;
    }
} else {
    echo "Có lỗi xảy ra khi lưu đơn hàng vào cơ sở dữ liệu: " . $conn->error;
}

$conn->close();
?>
