<?php
// Kiểm tra xem yêu cầu có phải là GET và có tồn tại tham số id không
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Kết nối đến cơ sở dữ liệu MySQL
    include 'config.php';

    // Lấy ID của bình luận từ tham số id
    $commentId = $_GET["id"];

    // Chuẩn bị câu lệnh SQL để xóa bình luận dựa trên ID
    $sql = "DELETE FROM comments WHERE id = $commentId";

    // Thực thi câu lệnh SQL
    if ($conn->query($sql) === TRUE) {
        // Trả về mã HTTP 200 để cho biết thành công
        http_response_code(200);
        echo "Comment deleted successfully.";
    } else {
        // Trả về mã HTTP 500 để cho biết có lỗi xảy ra
        http_response_code(500);
        echo "Error deleting comment: " . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
} else {
    // Trả về mã HTTP 400 nếu yêu cầu không hợp lệ
    http_response_code(400);
    echo "Invalid request.";
}
?>
