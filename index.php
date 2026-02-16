<?php 
session_start(); // เพิ่ม session_start เพื่อให้ระบบนับจำนวนสินค้าทำงานได้
include_once("connectdb.php"); 

$cat = isset($_GET['cat']) ? $_GET['cat'] : '';
$search = isset($_GET['q']) ? $_GET['q'] : '';

// ส่วนนับจำนวนสินค้าในตะกร้า
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty) {
        $cart_count += $qty;
    }
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SUPER WORLDS | อุปกรณ์กีฬาระดับมืออาชีพ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root { --ss-red: #e12128; --ss-dark: #1a1a1a; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f4f4; }
        .navbar { background-color: var(--ss-dark) !important; }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop');
            background-size: cover; background-position: center; height: 300px;
            display: flex; align-items: center; color: white;
        }
        .product-card { border: none; transition: 0.3s; border-radius: 12px; overflow: hidden; background: #fff; }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .product-img { height: 220px; width: 100%; object-fit: cover; background: #f8f8f8; cursor: pointer; }
        .category-btn { border-radius: 50px; padding: 8px 20px; margin: 5px; font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s; }
        .price-tag { color: var(--ss-red); font-weight: bold; font-size: 1.1rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">SUPER<span class="text-danger">WORLDS</span></a>
        
<form class="d-flex mx-auto w-50 position-relative" action="index.php" method="get">
    <input class="form-control me-2 rounded-pill" type="search" name="q" id="search_input" 
           placeholder="ค้นหาชื่อสินค้า..." autocomplete="off">
    <button class="btn btn-outline-light rounded-pill" type="submit"><i class="fas fa-search"></i></button>
    
    <div id="search_results" class="list-group position-absolute w-100 shadow-lg" 
         style="top: 45px; z-index: 1000; display: none;">
    </div>
</form>

        <div class="d-flex align-items-center gap-3 ms-3">
            <a href="cart.php" class="text-white position-relative text-decoration-none">
                <i class="fas fa-shopping-basket fa-lg"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                    <?php echo $cart_count; // แสดงจำนวนสินค้าจริง ?>
                </span>
            </a>

            <div class="dropdown">
                <a href="#" class="text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle fa-lg"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>โปรไฟล์ของฉัน</a></li>
                    <li><a class="dropdown-item" href="order_history.php"><i class="fas fa-history me-2"></i>ประวัติการสั่งซื้อ</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-primary" href="admin_orders.php"><i class="fas fa-user-shield me-2"></i>ระบบหลังบ้าน</a></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>ออกจากระบบ</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<header class="hero-section">

    <div class="container text-center">
        <h1 class="display-4 fw-bold">SUPER WORLDS STORE</h1>
        <p class="lead">อุปกรณ์กีฬาระดับมืออาชีพสำหรับคุณ</p>
    </div>
</header>

<div class="container my-5">
    <div class="text-center mb-5">
        <a href="index.php" class="category-btn btn <?php echo ($cat == '') ? 'btn-dark' : 'btn-outline-dark'; ?>">ทั้งหมด</a>
        <a href="?cat=รองเท้า" class="category-btn btn <?php echo ($cat == 'รองเท้า') ? 'btn-dark' : 'btn-outline-dark'; ?>">รองเท้า</a>
        <a href="?cat=เสื้อผ้า" class="category-btn btn <?php echo ($cat == 'เสื้อผ้า') ? 'btn-dark' : 'btn-outline-dark'; ?>">เสื้อผ้า</a>
        <a href="?cat=อุปกรณ์กีฬา" class="category-btn btn <?php echo ($cat == 'อุปกรณ์กีฬา') ? 'btn-dark' : 'btn-outline-dark'; ?>">อุปกรณ์กีฬา</a>
    </div>

    <?php if($search): ?>
        <div class="alert alert-light border mb-4">ผลการค้นหาสำหรับ: <strong>"<?php echo htmlspecialchars($search); ?>"</strong></div>
    <?php endif; ?>

    <div class="row g-4">
        <?php
        $sql = "SELECT * FROM products WHERE 1";
        if ($search) { $sql .= " AND (p_name LIKE '%$search%' OR p_brand LIKE '%$search%')"; }
        if ($cat) { $sql .= " AND p_category = '$cat'"; }
        $sql .= " ORDER BY p_id DESC";
        
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                $sizes = !empty($row['p_size']) ? $row['p_size'] : "S,M,L,XL";
        ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card product-card h-100 shadow-sm text-dark">
                    <a href="product_detail.php?id=<?php echo $row['p_id']; ?>">
                        <img src="<?php echo $row['p_image']; ?>" class="product-img card-img-top" onerror="this.src='https://placehold.co/400x400?text=No+Image'">
                    </a>
                    <div class="card-body">
                        <p class="text-muted mb-1 small"><?php echo $row['p_brand']; ?></p>
                        <h5 class="card-title h6 fw-bold"><?php echo $row['p_name']; ?></h5>
                        <p class="price-tag mb-0">฿<?php echo number_format($row['p_price']); ?></p>

                        <div class="d-grid gap-2 mt-3">
                            <a href="cart_action.php?id=<?php echo $row['p_id']; ?>&action=add" class="btn btn-dark btn-sm rounded-pill">
                                <i class="fas fa-cart-plus me-1"></i> หยิบใส่ตะกร้า
                            </a>
                            <a href="product_detail.php?id=<?php echo $row['p_id']; ?>" class="btn btn-outline-dark btn-sm rounded-pill">
                                รายละเอียด
                            </a>
                        </div>
                    </div>
                </div>
            </div> <?php 
            }
        } else {
            echo '<div class="col-12 text-center py-5"><h4>ไม่พบสินค้าที่คุณต้องการ</h4></div>';
        }
        ?>
    </div> </div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <p class="mb-0">© 2026 Focus Sport Store. All Rights Reserved.</p>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function(){
        // เมื่อมีการพิมพ์ข้อมูลในช่องที่มี id="search_input"
        $('#search_input').keyup(function(){
            let query = $(this).val();
            if (query != "") {
                $.ajax({
                    url: "fetch_search.php", // ส่งค่าไปประมวลผลที่ไฟล์นี้
                    method: "POST",
                    data: {query: query},
                    success: function(data) {
                        $('#search_results').fadeIn(); // แสดงกล่องผลลัพธ์
                        $('#search_results').html(data); // นำข้อมูลจากฐานข้อมูลมาใส่
                    }
                });
            } else {
                $('#search_results').fadeOut(); // ถ้าช่องว่างให้ซ่อนกล่อง
            }
        });

        // ปิดกล่องผลลัพธ์เมื่อคลิกไปที่ส่วนอื่นของหน้าจอ
        $(document).click(function(e) {
            if (!$(e.target).closest('.position-relative').length) {
                $('#search_results').fadeOut();
            }
        });
    });
    </script>
</body>
</html>

