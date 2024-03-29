<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .success-message {
            text-align: center;
            font-size: 24px;
            color: #28a745;
            margin-bottom: 30px;
        }

        .btn-back {
            display: block;
            margin: 0 auto;
            width: 200px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Đặt hàng thành công</h1>
        <div class="success-message">
            <p>Cảm ơn bạn đã đặt hàng của chúng tôi!</p>
            <p>Đơn hàng của bạn đã được ghi nhận.</p>
        </div>
        <a href="index.php" class="btn-back">Quay lại trang chủ</a>
    </div>
</body>

</html>
