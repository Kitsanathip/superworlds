<?php
session_start();
include_once("connectdb.php");
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ตะกร้าสินค้า - SUPERWORLDS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .cart-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .product-name { font-size: 1.1rem; color: #333; }
        .empty-cart-icon { font-size: 5rem; color: #dee2e6; margin-bottom: 20px; }
    </style>
</head>
<body class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0"><i class="fas fa-shopping-cart me-2"></i>ตะกร้าสินค้าของคุณ</h2>
            <a href="index.php" class="btn btn-outline-dark rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>เลือกซื้อสินค้าต่อ
            </a>
        </div>

        <div class="card cart-card p-4">
            <?php
            $total_price = 0;
            if (!empty($_SESSION['cart'])): 
            ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">สินค้า</th>
                            <th class="text-center py-3">ราคา</th>
                            <th class="text-center py-3">จำนวน</th>
                            <th class="text-center py-3">รวม</th>
                            <th class="text-center py-3">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['cart'] as $id => $qty) {
                            $sql = "SELECT * FROM products WHERE p_id = '$id'";
                            $res = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_array($res);
                            
                            $sum = $row['p_price'] * $qty;
                            $total_price += $sum;
                        ?>
                        <tr>
                            <td>
                                <div class="product-name fw-bold"><?php echo $row['p_name']; ?></div>
                                <small class="text-muted">รหัสสินค้า: #<?php echo $id; ?></small>
                            </td>
                            <td class="text-center">฿<?php echo number_format($row['p_price']); ?></td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <a href="cart_action.php?id=<?php echo $id; ?>&action=reduce" class="btn btn-white border">-</a>
                                    <span class="btn btn-white border disabled fw-bold" style="width: 50px;"><?php echo $qty; ?></span>
                                    <a href="cart_action.php?id=<?php echo $id; ?>&action=add_more" class="btn btn-white border">+</a>
                                </div>
                            </td>
                            <td class="text-center fw-bold text-dark">฿<?php echo number_format($sum); ?></td>
                            <td class="text-center">
                                <a href="cart_action.php?id=<?php echo $id; ?>&action=remove" class="btn btn-light text-danger btn-sm rounded-circle p-2" title="ลบสินค้า">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="row mt-4 align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <a href="cart_action.php?action=clear" class="text-muted small text-decoration-none" onclick="return confirm('คุณต้องการล้างตะกร้าสินค้าทั้งหมดใช่หรือไม่?')">
                        <i class="fas fa-eraser me-1"></i>ล้างตะกร้าทั้งหมด
                    </a>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <h3 class="fw-bold mb-3">ราคารวมทั้งสิ้น: <span class="text-danger">฿<?php echo number_format($total_price); ?></span></h3>
                    <a href="checkout.php" class="btn btn-danger btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg w-100 w-md-auto">
                        ไปหน้าชำระเงิน <i class="fas fa-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>

            <?php else: ?>
            <div class="text-center py-5">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <h4 class="text-muted">ไม่มีสินค้าในตะกร้าของคุณ</h4>
                <p class="text-muted mb-4 small">คุณยังไม่ได้เลือกสินค้าใดๆ ลงในตะกร้า</p>
                <a href="index.php" class="btn btn-dark btn-lg rounded-pill px-5 shadow">
                    <i class="fas fa-shopping-cart me-2"></i>เริ่มเลือกซื้อสินค้า
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>