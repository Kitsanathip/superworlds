<?php
include_once("connectdb.php");
session_start();

// จำลอง user_id สำหรับทดสอบ (หากมีระบบ Login แล้วให้ใช้ $_SESSION['user_id'])
if(!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; 
}

$uid = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$uid'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_array($result);

// หากไม่พบข้อมูลในตาราง users ให้แจ้งเตือน
if(!$user) {
    die("Error: ไม่พบข้อมูลสมาชิก กรุณารันคำสั่ง SQL สร้างตารางและเพิ่มข้อมูลตัวอย่างก่อน");
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>โปรไฟล์ของฉัน - SUPERWORLDS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .card { border: none; border-radius: 15px; }
        .form-control { border-radius: 10px; padding: 10px; }
    </style>
</head>
<body class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4 text-center"><i class="fas fa-user-circle me-2"></i>ข้อมูลส่วนตัวของคุณ</h4>
                        <form action="update_profile.php" method="post">
                            <div class="mb-3">
                                <label class="form-label fw-bold small">ชื่อ-นามสกุล</label>
                                <input type="text" name="fullname" class="form-control" value="<?php echo $user['fullname']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo $user['phone']; ?>" maxlength="10" pattern="[0-9]{10}" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold small">ที่อยู่จัดส่ง</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="ระบุที่อยู่ปัจจุบันของคุณ"><?php echo $user['address']; ?></textarea>
                            </div>
                            <button type="submit" name="Update" class="btn btn-dark w-100 rounded-pill py-2 fw-bold">บันทึกการเปลี่ยนแปลง</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-3"><i class="fas fa-box-open me-2"></i>สถานะการสั่งซื้อ</h5>
                        <p class="text-muted small">คุณสามารถติดตามรายการสั่งซื้อล่าสุดได้ที่นี่</p>
                        <hr>
                        <div class="alert alert-secondary py-2 small">
                            รอดำเนินการ: ยังไม่มีข้อมูลการสั่งซื้อ
                        </div>
                        <a href="index.php" class="btn btn-link text-decoration-none text-muted small">กลับหน้าหลัก</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>