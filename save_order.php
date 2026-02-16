<?php
session_start();
include_once("connectdb.php");

// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าและป้องกัน SQL Injection
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
    
    // เตรียมส่วนหัว HTML และเรียกใช้ SweetAlert2
    echo "<!DOCTYPE html>
    <html lang='th'>
    <head>
        <meta charset='UTF-8'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <style>body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }</style>
    </head>
    <body>";

    // 1. บันทึกข้อมูลการสั่งซื้อหลักลงตาราง orders
    $sql_order = "INSERT INTO orders (o_name, o_phone, o_address, o_total) 
                  VALUES ('$fullname', '$phone', '$address', '$total_amount')";
    
    if (mysqli_query($conn, $sql_order)) {
        // 2. หากบันทึกสำเร็จ ให้ล้างข้อมูลในตะกร้าสินค้า (Session)
        unset($_SESSION['cart']);

        // 3. แสดงการแจ้งเตือนสำเร็จในหน้านี้
        echo "<script>
            Swal.fire({
                title: 'สั่งซื้อสินค้าสำเร็จ!',
                text: 'ขอบคุณที่เลือกใช้บริการ SUPERWORLDS',
                icon: 'success',
                confirmButtonColor: '#e12128',
                confirmButtonText: 'กลับไปหน้าหลัก',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
        </script>";
    } else {
        // หากเกิดข้อผิดพลาดในการบันทึกข้อมูลลงฐานข้อมูล
        $error_msg = mysqli_error($conn);
        echo "<script>
            Swal.fire({
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถบันทึกข้อมูลได้: $error_msg',
                icon: 'error',
                confirmButtonText: 'ลองใหม่อีกครั้ง'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }
    echo "</body></html>";
} else {
    // หากไม่ได้เข้าถึงผ่านการ POST ฟอร์ม (เช่น พิมพ์ URL ตรงๆ) ให้ส่งกลับไปหน้าแรก
    header("Location: index.php");
    exit();
}
?>