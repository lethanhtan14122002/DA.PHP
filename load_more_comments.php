<?php
// Kết nối đến cơ sở dữ liệu MySQL
include 'config.php';

// Số lượng bình luận cần hiển thị (được truyền từ JavaScript)
$count = $_GET['count'];

// Chuẩn bị câu lệnh SQL để lấy các bình luận từ bảng, giới hạn số lượng bình luận bằng $count
$sql = "SELECT comments.*, user_form.name AS user_name 
        FROM comments 
        INNER JOIN user_form ON comments.user_id = user_form.id 
        ORDER BY comments.created_at DESC LIMIT $count, 3";

// Thực thi câu lệnh SQL
$result = $conn->query($sql);

// Hiển thị các bình luận
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['user_name']; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['created_at']; ?></h6>
                <p class="card-text"><?php echo $row['comment']; ?></p>
                <?php
                // Hiển thị biểu tượng mặt cười tương ứng
                if (!empty($row['emoji'])) {
                    echo '<i class="fas ' . $row['emoji'] . '"></i>'; // Sử dụng class của Font Awesome
                }
                ?>
            </div>
        </div>
        <?php
    }
} else {
    echo 'No more comments.';
}

// Đóng kết nối
$conn->close();
?>
