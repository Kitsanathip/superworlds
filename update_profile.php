<?php
include_once("connectdb.php");
session_start();
$user_id = $_SESSION['user_id'] ?? 1;

if(isset($_POST['Update'])){
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "UPDATE users SET 
            fullname = '$name', 
            phone = '$phone', 
            address = '$address' 
            WHERE id = '$user_id'";

    if(mysqli_query($conn, $sql)){
        // ใช้ SweetAlert2 แทน alert แบบเดิม
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            setTimeout(function() {
                Swal.fire({
                    title: 'อัปเดตข้อมูลสำเร็จ!',
                    text: 'ข้อมูลโปรไฟล์ของคุณได้รับการบันทึกแล้ว',
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#1a1a1a'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'profile.php';
                    }
                });
            }, 100);
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>