<!-- Connection -->
<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

$produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '" . $_GET['id'] . "' ");
$p = mysqli_fetch_object($produk);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TOKO ARSIWA</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
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
            <h3>Transaksi</h3>
            <div class="box">
                <form action="" method="POST">

                    <label for="nama">Nama Produk</label>
                    <input type="text" name="nama" class="input-control" placeholder="Nama Produk" value="<?php echo $p->product_name ?>">
                    <label for="hargabarang">Harga Barang</label>
                    <input type="text" name="hargabarang" class="input-control" placeholder="Harga" value="<?php echo $p->product_price ?>">
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="text" name="jumlah" class="input-control" placeholder="Harga" value="1" required>
                    <!-- <label for="harga">Harga Total</label>
                    <input type="text" name="harga" class="input-control" placeholder="Harga" value="<?php echo $p->product_price * $jumlah ?>"> -->

                    <img src="produk/<?php echo $p->product_image ?>" width="120px">
                    <br>
                    <input type="submit" name="submit" value="Beli" class="btn">
                </form>
                <?php
                if (isset($_POST['submit'])) {

                    //data include form
                    $user = $_SESSION['id'];
                    // $user = mysqli_query("SELECT * FROM tb_user WHERE user_id = '" . $_SESSION['id'] . "' ");
                    $nama = $p->product_name;
                    $produk = $p->product_id;
                    $hargabarang = $p->product_price;
                    $jumlah = $_POST['jumlah'];
                    $harga = $hargabarang * $jumlah;

                    //query update data produk
                    $insert = mysqli_query($conn, "INSERT INTO tb_transaction VALUES(
                        null,
                        '" . $user . "',
                        '" . $produk . "',
                        null,
                        '" . $jumlah . "',
                        '" . $harga . "')");
                    if ($insert) {
                        echo '<script>alert("Transaksi berhasil")</script>';
                        echo '<script>window.location="index.php"</script>';
                    } else {
                        echo 'Gagal ubah produk' . mysqli_error($conn);
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
    <script>
        CKEDITOR.replace('deskripsi');
    </script>
</body>

</html>