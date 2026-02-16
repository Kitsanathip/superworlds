<?php
session_start();
include_once("connectdb.php");

$id = isset($_GET['id']) ? $_GET['id'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($id != "" && ($action == 'add' || $action == 'add_more')) {
    // ถ้ายังไม่มีตะกร้า ให้สร้าง Array ว่างขึ้นมาก่อน
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // ถ้ามีสินค้านี้อยู่ในตะกร้าแล้ว ให้บวกจำนวนเพิ่ม
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        // ถ้ายังไม่มี ให้เริ่มที่ 1 ชิ้น
        $_SESSION['cart'][$id] = 1;
    }

    // ใช้ SweetAlert2 แจ้งเตือนสวยๆ แล้วเด้งไปหน้า cart.php
    echo "<html><head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body>";
    echo "<script>
        Swal.fire({
            title: 'เพิ่มลงตะกร้าแล้ว!',
            icon: 'success',
            timer: 1200,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'cart.php';
        });
    </script></body></html>";
}
?>