<?php
// Kết nối đến cơ sở dữ liệu MySQL
include 'config.php';

// Kiểm tra xem dữ liệu từ form đã được gửi đi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $comment = $_POST['comment'];
    $emoji = $_POST['emoji'];

    // Kiểm tra xem biến session chứa ID của người dùng đã được đặt chưa
    session_start(); // Bắt đầu session
    if (isset($_SESSION['user_id'])) {
        // Lấy ID của người dùng từ biến session
        $user_id = $_SESSION['user_id'];

        // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng comments
        $sql = "INSERT INTO comments (user_id, comment, emoji, created_at) VALUES ('$user_id', '$comment', '$emoji', NOW())";

        // Thực thi câu lệnh SQL và kiểm tra kết quả
        if ($conn->query($sql) === TRUE) {
            echo "Comment added successfully";
            header('location: user_page.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Nếu không tìm thấy ID của người dùng trong biến session, xử lý theo nhu cầu của bạn, ví dụ chuyển hướng đến trang đăng nhập
        header('location: login.php');
    }
}

// Đóng kết nối
$conn->close();
?>
