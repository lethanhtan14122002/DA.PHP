<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <link rel="stylesheet" href="./css/comment.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Thêm Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="text-center">Comment Section</h2>
                    </div>
                    <div class="card-body">
                        <form action="process_comment.php" method="POST">
                            <div class="form-group">
                                <textarea class="form-control" name="comment" placeholder="Enter your comment..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="emoji">Choose Emoji:</label>
                                <select class="form-control" name="emoji">
                                    <option value="fa-sad-tear">&#xf5b4; Sad Tear</option>
                                    <option value="fa-smile">&#xf118; Smile</option>
                                    <option value="fa-thumbs-up">&#xf164; Thumbs Up</option>
                                    <option value="fa-sad-cry">&#xf5b3; Sad Cry</option>
                                    <option value="fa-grin">&#xf580; Grin</option>
                                    <!-- Thêm các biểu tượng khác nếu cần -->
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="commentSection">
                    <!-- Hiển thị mỗi bình luận trong một card của Bootstrap -->
                    <!-- Hiển thị mỗi bình luận trong một card của Bootstrap -->
                    <?php
                    // Kết nối đến cơ sở dữ liệu MySQL
                    include 'config.php';

                    // Kiểm tra xem biến session/cookie chứa thông tin về người dùng đăng nhập đã được đặt chưa
                    if (isset($_SESSION['user_id'])) {
                        // Lấy ID của người dùng từ biến session/cookie
                        $user_id = $_SESSION['user_id'];

                        // Chuẩn bị câu lệnh SQL để lấy tên của người dùng dựa trên ID
                        $user_sql = "SELECT name FROM user_form WHERE id = $user_id";

                        // Thực thi câu lệnh SQL
                        $user_result = $conn->query($user_sql);

                        // Kiểm tra xem câu lệnh SQL có lấy được kết quả không
                        if ($user_result && $user_result->num_rows > 0) {
                            // Lấy thông tin người dùng từ kết quả truy vấn
                            $user_row = $user_result->fetch_assoc();
                            // Lưu tên của người dùng vào biến
                            $user_name = $user_row['name'];
                        } else {
                            // Nếu không có kết quả, gán tên người dùng là "Unknown"
                            $user_name = "Unknown";
                        }
                    } else {
                        // Nếu biến session/cookie không tồn tại, gán tên người dùng là "Unknown"
                        $user_name = "Unknown";
                    }

                    // Chuẩn bị câu lệnh SQL để lấy các bình luận từ bảng
                    $sql = "SELECT comments.*, user_form.name AS user_name 
                            FROM comments 
                            INNER JOIN user_form ON comments.user_id = user_form.id 
                            ORDER BY comments.created_at DESC LIMIT 3";

                    // Thực thi câu lệnh SQL
                    $result = $conn->query($sql);

                    // Hiển thị các bình luận
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $user_name; ?></h5> <!-- Hiển thị tên người đăng nhập -->
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
                        echo 'No comments yet.';
                    }

                    // Đóng kết nối
                    $conn->close();
                    ?>


                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" id="loadMoreBtn">Xem Thêm Bình Luận</button>
        <button class="btn btn-primary" id="loadMoreBtn2">Ẩn Bớt Bình Luận</button>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var loadMoreBtn = document.getElementById("loadMoreBtn");
            var commentSection = document.getElementById("commentSection");
            var commentCount = commentSection.childElementCount; // Số lượng bình luận ban đầu

            loadMoreBtn.addEventListener("click", function() {
                // Tạo yêu cầu AJAX để lấy thêm bình luận
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        // Thêm bình luận mới vào cuối phần tử commentSection
                        commentSection.innerHTML += this.responseText;
                        // Cập nhật số lượng bình luận
                        commentCount = commentSection.childElementCount;
                        // Nếu không còn bình luận nào để hiển thị, ẩn nút "Xem Thêm Bình Luận"
                        if (commentCount % 3 !== 0) {
                            loadMoreBtn.style.display = "none";
                        }
                    }
                };
                xhr.open("GET", "load_more_comments.php?count=" + commentCount, true);
                xhr.send();
            });
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var loadMoreBtn = document.getElementById("loadMoreBtn");
            var loadMoreBtn2 = document.getElementById("loadMoreBtn2");
            var commentSection = document.getElementById("commentSection");

            // Số lượng bình luận ban đầu
            var commentCount = commentSection.childElementCount;

            loadMoreBtn.addEventListener("click", function() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        commentSection.innerHTML += this.responseText;
                        commentCount = commentSection.childElementCount;

                        // Nếu số lượng bình luận vừa thêm vào không chia hết cho 3, ẩn nút "Xem Thêm Bình Luận"
                        if (commentCount % 3 !== 0) {
                            loadMoreBtn.style.display = "none";
                        }

                        // Hiển thị lại nút "Ẩn Bớt Bình Luận" nếu đã ẩn trước đó
                        loadMoreBtn2.style.display = "inline-block";
                    }
                };
                xhr.open("GET", "load_more_comments.php?count=" + commentCount, true);
                xhr.send();
            });

            loadMoreBtn2.addEventListener("click", function() {
                // Số lượng bình luận cần ẩn bớt (3 bình luận mỗi lần hoặc số bình luận còn lại nếu nhỏ hơn)
                var countToHide = Math.min(3, commentCount);

                // Lặp qua từng thẻ card và ẩn đi countToHide thẻ từ cuối danh sách
                for (var i = commentCount - 1; i >= commentCount - countToHide; i--) {
                    if (commentSection.children[i]) {
                        commentSection.children[i].style.display = "none";
                    }
                }

                // Giảm số lượng bình luận còn lại sau khi ẩn bớt
                commentCount -= countToHide;

                // Nếu không còn bình luận nào để ẩn, ẩn nút "Ẩn Bớt Bình Luận"
                if (commentCount <= 3) {
                    loadMoreBtn2.style.display = "none";
                }

                // Hiển thị lại nút "Xem Thêm Bình Luận" nếu đã ẩn trước đó
                loadMoreBtn.style.display = "inline-block";
            });
        });
    </script>



</body>

</html>