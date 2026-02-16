<?php
include_once("connectdb.php");

if (isset($_POST['query'])) {
    // 1. รับค่ามาแล้วตัดช่องว่างหัว-ท้าย และเปลี่ยนช่องว่างระหว่างคำให้เป็น % เพื่อให้ค้นหาได้ยืดหยุ่น
    $raw_search = trim($_POST['query']);
    $search = mysqli_real_escape_string($conn, $raw_search);
    
    // แทนที่ช่องว่างด้วย % เพื่อให้พิมพ์ "AirSpeed" ก็เจอ "Air Max Speed"
    $flexible_search = str_replace(' ', '%', $search);

    // 2. ปรับ SQL ให้ค้นหาแบบกว้างขึ้น
    $sql = "SELECT * FROM products 
            WHERE p_name LIKE '%$flexible_search%' 
            OR p_brand LIKE '%$flexible_search%' 
            LIMIT 5";
            
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo '
            <a href="product_detail.php?id='.$row['p_id'].'" class="list-group-item list-group-item-action d-flex align-items-center border-0 border-bottom">
                <img src="'.$row['p_image'].'" style="width: 45px; height: 45px; object-fit: cover;" class="me-3 rounded shadow-sm" onerror="this.src=\'https://placehold.co/50x50\'">
                <div class="overflow-hidden">
                    <div class="fw-bold small text-dark text-truncate">'.$row['p_name'].'</div>
                    <div class="text-danger small fw-bold">฿'.number_format($row['p_price']).'</div>
                </div>
            </a>';
        }
    } else {
        echo '<div class="list-group-item small text-muted text-center py-3">ไม่พบสินค้าที่คุณต้องการ</div>';
    }
}
?>