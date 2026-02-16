<?php
include_once("connectdb.php");
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';
$res = mysqli_query($conn, "SELECT * FROM products WHERE p_id = '$id'");
$row = mysqli_fetch_array($res);
if(!$row) { header("Location: index.php"); exit; }
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title><?php echo $row['p_name']; ?> | รายละเอียดสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .main-img { width: 100%; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .price-big { color: #e12128; font-size: 2.5rem; font-weight: bold; }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <a href="index.php" class="btn btn-outline-dark mb-4 rounded-pill">← กลับหน้าหลัก</a>
        
        <div class="row g-5 bg-white p-4 rounded-4 shadow-sm">
            <div class="col-md-6">
                <img src="<?php echo $row['p_image']; ?>" class="main-img">
            </div>
            <div class="col-md-6">
                <h4 class="text-muted"><?php echo $row['p_brand']; ?></h4>
                <h1 class="fw-bold mb-3"><?php echo $row['p_name']; ?></h1>
                <p class="price-big">฿<?php echo number_format($row['p_price']); ?></p>
                <hr>
                
                <form action="save_order.php" method="post">
                    <input type="hidden" name="product_name" value="<?php echo $row['p_name']; ?>">
                    <div class="mb-4">
                        <label class="form-label fw-bold">เลือกไซส์ที่ต้องการ</label>
                        <select name="order_size" class="form-select form-select-lg" required>
                            <?php 
                            $sizes = !empty($row['p_size']) ? $row['p_size'] : "38,39,40,41,42";
                            foreach(explode(',', $sizes) as $s) {
                                echo "<option value='".trim($s)."'>Size: ".trim($s)."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">ชื่อผู้รับ</label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">เบอร์โทรศัพท์ (10 หลัก)</label>
                        <input type="text" name="phone" class="form-control" maxlength="10" pattern="[0-9]{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                    </div>
                    <button type="submit" name="Submit" class="btn btn-danger btn-lg w-100 py-3 shadow">ยืนยันการสั่งซื้อ</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>