<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | TOKO ARSIWA</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>

<body id="bg-login">
    <div class="box-login">
        <div class="row">
            <h2>Login</h2>
            <form action="" method="POST">
                <input type="text" name="user" placeholder="Username" class="input-control">
                <input type="password" name="pass" placeholder="Password" class="input-control">
                <input type="submit" name="submit" value="Login" class="btn">
            </form>
            <?php
            if (isset($_POST['submit'])) {

                $user = mysqli_real_escape_string($conn, $_POST['user']);
                $pass = mysqli_real_escape_string($conn, $_POST['pass']);
                $cek = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username = '" . $user . "' AND password = '" . MD5($pass) . "'");
                if (mysqli_num_rows($cek) > 0) {
                    $d = mysqli_fetch_object($cek);
                    $_SESSION['status_login'] = true;
                    $_SESSION['a_global'] = $d;
                    $_SESSION['id'] = $d->admin_id;
                    echo '<script>window.location="dashboard.php"</script>';
                } else {
                    echo '<script>alert("Username atau password salah")</script>';
                }
            }
            ?>
        </div>
    </div>
</body>

</html>