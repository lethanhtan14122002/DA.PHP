<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_id'])) {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['user_id'])) {
        echo "Vui lòng đăng nhập để thêm món ăn vào danh sách yêu thích.";
        exit();
    }

    $userId = $_SESSION['user_id'];
    $itemId = $_POST['item_id'];

    // Kiểm tra xem món ăn đã có trong danh sách yêu thích của người dùng chưa
    $checkSql = "SELECT * FROM user_favorites WHERE user_id = $userId AND item_id = $itemId";
    $checkResult = $conn->query($checkSql);

    if ($checkResult && $checkResult->num_rows > 0) {
        echo "Sản phẩm đã có trong danh sách yêu thích của bạn.";
        header('location: user_page.php');
    } else {
        // Thêm món ăn vào danh sách yêu thích
        $insertSql = "INSERT INTO user_favorites (user_id, item_id) VALUES ($userId, $itemId)";
        if ($conn->query($insertSql) === TRUE) {
            echo "Thêm sản phẩm vào yêu thích thành công.";
            header('location: user_page.php');
        } else {
            echo "Lỗi khi thêm vào yêu thích: " . $conn->error;
        }
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}

$conn->close();
?>
<script>
    $(document).ready(function() {
        $('.add_to_favorites').on('click', function() {
            var item_id = $(this).data('id');
            $.ajax({
                url: 'add_to_favorites.php',
                type: 'POST',
                data: {item_id: item_id},
                success: function(response) {
                    alert('Món ăn đã được thêm vào danh sách yêu thích.');
                },
                error: function(xhr, status, error) {
                    alert('Có lỗi xảy ra: ' + error);
                }
            });
        });
    });
</script>
