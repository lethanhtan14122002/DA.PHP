<?php
session_start();
include 'config.php';

// Lấy tất cả đơn hàng từ cơ sở dữ liệu
$sql_all_orders = "SELECT * FROM orders";
$result_all_orders = $conn->query($sql_all_orders);

// Biến tổng số tiền của tất cả các đơn hàng
$totalAllOrders = 0;

// Bắt đầu hiển thị các đơn hàng và biểu mẫu tìm kiếm
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .body{
            background-image: url('https://img2.thuthuatphanmem.vn/uploads/2018/12/14/hinh-hoa-bi-ngan-do-ruc-ro_111158350.jpg');
        }
        /* Custom styles */
        .container {
            margin-top: 20px;
        }
        .total-amount {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Quản lý đơn hàng</h2>
        <!-- Bảng hiển thị tất cả các đơn hàng -->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Ghi chú</th>
                    <th scope="col">Mã giao dịch</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col">Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
HTML;

// Hiển thị tất cả các đơn hàng
if ($result_all_orders && $result_all_orders->num_rows > 0) {
    while ($row = $result_all_orders->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['address'] . "</td>";
        echo "<td>" . $row['note'] . "</td>";
        echo "<td>" . $row['transaction_id'] . "</td>";
        echo "<td>" . $row['total_quantity'] . "</td>";
        echo "<td>" . number_format($row['total_amount'], 2, ',', '.') . " VND</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";

        // Tính tổng số tiền của tất cả các đơn hàng
        $totalAllOrders += $row['total_amount'];
    }
} else {
    echo "<tr><td colspan='9'>Không có đơn hàng nào.</td></tr>";
}
echo "<div class='total-amount'>";
echo "Tổng tiền của tất cả đơn hàng: " . number_format($totalAllOrders, 2, ',', '.') . " VND";
echo "</div>";
echo "<br>";
// Kết thúc bảng hiển thị tất cả các đơn hàng
echo <<<HTML
            </tbody>
        </table>

        <!-- Biểu mẫu tìm kiếm theo ngày -->
        <form method="post" class="form-inline mb-4">
            <div class="form-group mr-2">
                <label for="search_date">Tìm kiếm theo ngày:</label>
                <input type="date" class="form-control mx-sm-3" id="search_date" name="search_date">
            </div>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        <!-- Hiển thị kết quả tìm kiếm theo ngày (nếu có) -->
HTML;

// Nếu có yêu cầu tìm kiếm theo ngày, thực hiện và hiển thị kết quả
if (isset($_POST['search_date'])) {
    $search_date = $_POST['search_date'];
    // Chuyển định dạng ngày từ "mm/dd/yyyy" sang "yyyy-mm-dd"
    $search_date_formatted = date("Y-m-d", strtotime($search_date));
    // Thực hiện truy vấn để lấy dữ liệu đơn hàng theo ngày
    $sql_search_orders = "SELECT * FROM orders WHERE DATE(created_at) = '$search_date_formatted'";
    $result_search_orders = $conn->query($sql_search_orders);

    // Biến tổng số tiền của các đơn hàng tìm kiếm
    $totalSearchOrders = 0;

    // Hiển thị kết quả tìm kiếm
    echo <<<HTML
        <h2>Kết quả tìm kiếm theo ngày $search_date</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Ghi chú</th>
                    <th scope="col">Mã giao dịch</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col">Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
HTML;

    if ($result_search_orders && $result_search_orders->num_rows > 0) {
        while ($row = $result_search_orders->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['note'] . "</td>";
            echo "<td>" . $row['transaction_id'] . "</td>";
            echo "<td>" . $row['total_quantity'] . "</td>";
            echo "<td>" . number_format($row['total_amount'], 2, ',', '.') . " VND</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "</tr>";

            // Tính tổng số tiền của các đơn hàng tìm kiếm
            $totalSearchOrders += $row['total_amount'];
        }
    } else {
        echo "<tr><td colspan='9'>Không có đơn hàng nào được tìm thấy trong ngày $search_date.</td></tr>";
    }

    // Kết thúc bảng hiển thị kết quả tìm kiếm
    echo "</tbody></table>";

    // Hiển thị tổng số tiền của các đơn hàng tìm kiếm
    echo "<div class='total-amount'>";
    echo "Tổng tiền của đơn hàng trong ngày $search_date: " . number_format($totalSearchOrders, 2, ',', '.') . " VND";
    echo "</div>";
}

// Hiển thị tổng số tiền của tất cả các đơn hàng


// Kết thúc trang HTML
echo <<<HTML
    </div>
</body>
</html>
HTML;

// Đóng kết nối với cơ sở dữ liệu
$conn->close();
?>
