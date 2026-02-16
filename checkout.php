<?php
session_start();
include_once("connectdb.php");

// ดึงข้อมูลผู้ใช้มาแสดงในแบบฟอร์ม (ถ้า Login อยู่)
$uid = $_SESSION['user_id'] ?? 1;
$res_user = mysqli_query($conn, "SELECT * FROM users WHERE id = '$uid'");
$user = mysqli_fetch_array($res_user);

$total_price = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $res = mysqli_query($conn, "SELECT p_price FROM products WHERE p_id = '$id'");
    $row = mysqli_fetch_array($res);
    $total_price += ($row['p_price'] * $qty);
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ชำระเงิน - SUPERWORLDS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-5 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary fw-bold">สรุปคำสั่งซื้อ</span>
                    <span class="badge bg-primary rounded-pill"><?php echo count($_SESSION['cart']); ?> รายการ</span>
                </h4>
                <ul class="list-group mb-3 shadow-sm">
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <span class="fw-bold">ยอดชำระสุทธิ</span>
                        <strong class="text-danger">฿<?php echo number_format($total_price); ?></strong>
                    </li>
                </ul>
            </div>
            
            <div class="col-md-7">
                <h4 class="mb-3 fw-bold">ข้อมูลการจัดส่ง</h4>
                <div class="card p-4 shadow-sm border-0 rounded-4">
                    <form action="save_order.php" method="POST">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">ชื่อ-นามสกุล ผู้รับ</label>
                                <input type="text" name="fullname" class="form-control" value="<?php echo $user['fullname'] ?? ''; ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo $user['phone'] ?? ''; ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">ที่อยู่สำหรับการจัดส่ง</label>
                                <textarea name="address" class="form-control" rows="3" required><?php echo $user['address'] ?? ''; ?></textarea>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h5 class="mb-3">วิธีการชำระเงิน</h5>
                        <div class="form-check mb-3">
                            <input type="radio" name="payment" class="form-check-input" checked required>
                            <label class="form-check-label">โอนผ่านธนาคาร / QR Code</label>
                        </div>
                        <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">
                        <button class="w-100 btn btn-danger btn-lg rounded-pill fw-bold" type="submit">ยืนยันการสั่งซื้อ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>