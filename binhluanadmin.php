<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Comment Section</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Emoji</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Kết nối đến cơ sở dữ liệu MySQL
                    include 'config.php';

                    // Chuẩn bị câu lệnh SQL để lấy các bình luận từ bảng
                    $sql = "SELECT comments.*, user_form.name AS user_name 
                            FROM comments 
                            INNER JOIN user_form ON comments.user_id = user_form.id 
                            ORDER BY comments.created_at DESC";

                    // Thực thi câu lệnh SQL
                    $result = $conn->query($sql);

                    // Hiển thị các bình luận trong bảng
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['user_name'] . "</td>";
                            echo "<td>" . $row['comment'] . "</td>";
                            echo "<td>" . $row['created_at'] . "</td>";
                            echo "<td>";
                            if (!empty($row['emoji'])) {
                                echo '<i class="fas ' . $row['emoji'] . '"></i>';
                            }
                            echo "</td>";
                            echo '<td><button class="btn btn-danger delete-btn" data-comment-id="' . $row['id'] . '">Delete</button></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo '<tr><td colspan="5">No comments yet.</td></tr>';
                    }

                    // Đóng kết nối
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript để xử lý việc xóa bình luận -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var deleteButtons = document.querySelectorAll(".delete-btn");

            // Lặp qua từng nút xóa và thêm sự kiện click
            deleteButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var commentId = this.getAttribute("data-comment-id");
                    // Gửi yêu cầu AJAX để xóa bình luận với ID tương ứng
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                            // Xóa dòng bình luận khỏi bảng
                            var row = button.closest("tr");
                            row.parentNode.removeChild(row);
                        }
                    };
                    xhr.open("GET", "delete_comment.php?id=" + commentId, true);
                    xhr.send();
                });
            });
        });
    </script>

</body>

</html>
