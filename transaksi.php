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
                <form action="" method="POST" enctype="multipart/form-data">

                    <label for="nama">Nama Produk</label>
                    <input type="text" name="nama" class="input-control" placeholder="Nama Produk" value="<?php echo $p->product_name ?>">
                    <label for="hargabarang">Harga Barang</label>
                    <input type="text" name="hargabarang" class="input-control" placeholder="Harga" value="<?php echo $p->product_price ?>">
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="text" name="jumlah" class="input-control" placeholder="Harga" value="1" required>
                    <label for="harga">Harga Total</label>
                    <input type="text" name="harga" class="input-control" placeholder="Harga" value="<?php echo $p->product_price ?>">

                    <img src="produk/<?php echo $p->product_image ?>" width="120px">
                    <br>
                    <input type="submit" name="submit" value="Beli" class="btn">
                </form>
                <?php
                if (isset($_POST['submit'])) {

                    //data include form
                    $nama       = $_POST['nama'];
                    $harga      = $_POST['harga'];
                    $status     = $_POST['status'];
                    $foto       = $_POST['foto'];

                    //menampung data gambar baru
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];

                    $newimage = 'produk' . time() . '.' . $type2;

                    //data format file yang diizinkan
                    $tipe_izin = array('.jpg', '.jpeg', '.png', '.gif');

                    //jika admin ganti gambar
                    if ($filename != '') {

                        //membuat validasi format file
                        if (in_array($type2, $tipe_izin)) {
                            //jika format array tidak sesuai atau tidak ada
                            echo '<script>alert("Format file tidak diizinkan")</script>';
                        } else {
                            unlink('./produk/' . $foto);
                            move_uploaded_file($tmp_name, './produk/' . $newimage);
                            $namagambar = $newimage;
                        }
                    } else {
                        //jika admin tidak ganti gambar
                        $namagambar = $foto;
                    }

                    //query update data produk
                    $update = mysqli_query($conn, "UPDATE tb_product SET
                                                category_id = '" . $kategori . "', 
                                                product_name = '" . $nama . "', 
                                                product_price = '" . $harga . "',
                                                product_description = '" . $deskripsi . "',
                                                product_image = '" . $namagambar . "', 
                                                product_status = '" . $status . "' 
                                                WHERE product_id = '" . $p->product_id . "' ");
                    if ($update) {
                        echo '<script>alert("Ubah produk berhasil")</script>';
                        echo '<script>window.location="data-produk.php"</script>';
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