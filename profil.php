<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

$query = mysqli_query($conn, "SELECT * FROM tb_account WHERE id = '" . $_SESSION['id'] . "' ");
$d = mysqli_fetch_object($query);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TOKO ARSIWA</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">TOKO ARSIWA</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="data-kategori.php">Data Kategori</a></li>
                <li><a href="data-produk.php">Data Produk</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Profil</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" value="<?php echo $d->name ?>" required>
                    <input type="text" name="email" placeholder="Email" class="input-control" value="<?php echo $d->email ?>" required>
                    <input type="text" name="alamat" placeholder="Alamat" class="input-control" value="<?php echo $d->address ?>" required>
                    <input type="email" name="phone" placeholder="No. Hp" class="input-control" value="<?php echo $d->phone ?>" required>
                    <input type="submit" name="submit" value="Ubah Profil" class="btn">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    $nama = ucwords($_POST['nama']);
                    $email = $_POST['email'];
                    $alamat = ucwords($_POST['alamat']);
                    $hp = $_POST['phone'];

                    $update = mysqli_query($conn, "UPDATE tb_account SET
                            name = '" . $name . "',
                            phone = '" . $hp . "',
                            email = '" . $email . "',
                            address = '" . $alamat . "' WHERE id = '" . $d->id . "' ");
                    if ($update) {
                        echo '<script>alert("Ubah profil berhasil")</script>';
                        echo '<script>window.location="profil.php"</script>';
                    } else {
                        echo 'Ubah profil gagal' . mysqli_error($conn);
                    }
                }
                ?>
            </div>
            <h3>Ubah Password</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" name="pass1" placeholder="Password Baru" class="input-control" required>
                    <input type="password" name="pass2" placeholder="Confirm Password Baru" class="input-control" required>
                    <input type="submit" name="ubah_password" value="Ubah Password" class="btn">
                </form>
                <?php
                if (isset($_POST['ubah_password'])) {
                    $pass1 = $_POST['pass1'];
                    $pass2 = $_POST['pass2'];

                    if ($pass2 != $pass1) {
                        echo '<script>alert("Password baru tidak sesuai")</script>';
                    } else {
                        $update_password = mysqli_query($conn, "UPDATE tb_account SET 
                                password = '" . MD5($pass1) . "' 
                                WHERE admin_id = '" . $d->admin_id . "' ");
                        if ($update_password) {
                            echo '<script>alert("Password berhasil diganti")</script>';
                            echo '<script>window.location="profil.php"</script>';
                        } else {
                            echo 'Gagal mengganti password' . mysqli_error($conn);
                        }
                    }
                }
                ?>
            </div>

        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2023 - Toko Arsiwa</small>
        </div>
    </footer>
</body>

</html>