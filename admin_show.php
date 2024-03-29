<?php
// Kết nối đến cơ sở dữ liệu
@include 'config.php';
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
   header("Location: login_form.php");
   exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT name FROM user_form WHERE id = $user_id";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
   $row_user = $result_user->fetch_assoc();
   $_SESSION['user_name'] = $row_user['name'];
}

// Lấy danh sách món ăn từ cơ sở dữ liệu (chỉ lấy các món ăn chưa bị xóa)
$sql = "SELECT * FROM menu_items WHERE deleted = 0";
$result = $conn->query($sql);

// Biến đếm ID
$counter = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Page</title>
   <link rel="stylesheet" href="./css/admin.css">
</head>

<body>

   <div class="container">
      <div class="content">
         <h3>Welcome, <span><?php echo $_SESSION['user_name'] ?></span></h3>
         <div class="actions">
            <a href="logout.php">Logout</a>
         </div>
         <h1>Menu Management</h1>
         <div class="menu-table">
            <table>
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Price</th>
                     <th>Image</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php while ($row = $result->fetch_assoc()) : ?>
                     <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</td>
                        <td><img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="100"></td>
                        <td>
                           <a href="delete_item.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                           <a href="edit_item.php?id=<?php echo $row['id']; ?>">Edit</a>
                           <a href="add_item.php">Add</a>
                        </td>
                     </tr>
                  <?php endwhile; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>