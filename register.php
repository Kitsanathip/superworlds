<?php include_once("connectdb.php"); ?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>สมัครสมาชิก - SUPERWORLDS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <h2 class="text-center fw-bold mb-4">สมัครสมาชิก</h2>
                        <form action="save_register.php" method="post">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">ชื่อ-นามสกุล</label>
                                <input type="text" name="fullname" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control" maxlength="10" pattern="[0-9]{10}" required>
                            </div>
                            <button type="submit" name="Submit" class="btn btn-dark w-100 rounded-pill py-2">ลงทะเบียน</button>
                        </form>
                        <div class="text-center mt-3 small">
                            เป็นสมาชิกอยู่แล้ว? <a href="login.php" class="text-decoration-none">เข้าสู่ระบบ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>