<?php
// Kết nối đến CSDL và khởi tạo session (nếu cần)
include 'config.php';

// Kiểm tra nếu ID sản phẩm được truyền từ URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Truy vấn CSDL để lấy thông tin chi tiết sản phẩm
    $sql = "SELECT * FROM menu_items WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row['name'];
        $product_price = $row['price'];
        $product_description = $row['description'];
        $product_image = $row['image'];
    } else {
        echo "Không tìm thấy sản phẩm.";
        exit();
    }
} else {
    echo "Thiếu ID sản phẩm.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link rel="stylesheet" href="./css/chitiet.css"> <!-- Đường dẫn đến file CSS của bạn -->
</head>

<body>
    <h1>Chi Tiết Sản Phẩm</h1>
    <div class="product-details">
        <h2><?php echo $product_name; ?></h2>
        <p>Giá: <?php echo number_format($product_price, 0, ',', '.'); ?> VNĐ</p>
        <p class="card-text"><?php echo $product_description; ?></p>
        <img src="images/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>">
        <a href="user_page.php">Quay lại</a>
    </div>
</body>

</html>
