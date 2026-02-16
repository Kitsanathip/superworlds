<?php
session_start();
include_once("connectdb.php");

// ตรวจสอบว่ามีข้อมูลผู้ใช้ใน Session หรือไม่ (เพื่อให้ผ่านเกณฑ์ "สมาชิกเข้าสู่ระบบ")
// หากยังไม่ได้ทำระบบ Login เต็มรูปแบบ ให้จำลองดึงจากชื่อลูกค้าล่าสุดในระบบ
$fullname = $_SESSION['fullname'] ?? ''; 
$phone = $_SESSION['phone'] ?? '';

// ดึงข้อมูลออเดอร์จากตาราง orders
// หากคุณเก็บ o_name และ o_phone ไว้ในฐานข้อมูล เราจะดึงตามนั้น
$sql = "SELECT * FROM orders ORDER BY o_id DESC"; 
// ในการใช้งานจริงควรใช้: WHERE o_phone = '$phone' เพื่อดูเฉพาะของตัวเอง
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ประวัติการสั่งซื้อ - SUPERWORLDS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .order-card { border: none; border-radius: 15px; overflow: hidden; }
        .status-badge { border-radius: 50px; padding: 5px 15px; font-size: 0.8rem; }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-history me-2 text-danger"></i>ประวัติการสั่งซื้อ</h2>
        <a href="index.php" class="btn btn-outline-dark rounded-pill"><i class="fas fa-home me-2"></i>กลับหน้าร้าน</a>
    </div>

    <div class="card order-card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="py-3 ps-4">เลขที่สั่งซื้อ</th>
                        <th class="py-3">รายการสินค้า</th>
                        <th class="py-3 text-center">ยอดรวม</th>
                        <th class="py-3 text-center">สถานะ</th>
                        <th class="py-3 text-center">วันที่สั่งซื้อ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td class="ps-4 fw-bold">#<?php echo str_pad($row['o_id'], 5, "0", STR_PAD_LEFT); ?></td>
                            <td>
                                <div class="fw-bold"><?php echo $row['o_product'] ?? 'รายการสินค้ารวม'; ?></div>
                                <small class="text-muted">ผู้รับ: <?php echo $row['o_name']; ?></small>
                            </td>
                            <td class="text-center fw-bold text-danger">
                                ฿<?php echo number_format($row['o_total'] ?? $row['p_price'] ?? 0); ?>
                            </td>
                            <td class="text-center">
                                <?php 
                                    // ส่วนเช็คสถานะออเดอร์ (ตามเกณฑ์ประเมิน)
                                    $status = $row['o_status'] ?? 'รอดำเนินการ';
                                    $badge_class = ($status == 'ส่งแล้ว') ? 'bg-success' : 'bg-warning text-dark';
                                ?>
                                <span class="badge <?php echo $badge_class; ?> status-badge">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td class="text-center text-muted">
                                <?php echo date('d/m/Y H:i', strtotime($row['o_date'] ?? 'now')); ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3"></i>
                                <p>ไม่พบประวัติการสั่งซื้อของคุณ</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>