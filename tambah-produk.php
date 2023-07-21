<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}
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
            <h3>Tambah Data Produk</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="data-produk" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM tbl_category ORDER BY category_id DESC");
                        while ($r = mysqli_fetch_array($kategori)) {
                        ?>
                            <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                        <?php } ?>
                    </select>

                    <input type="text" name="nama" class="input-control" placeholder="Nama Produk" required>
                    <input type="text" name="harga" class="input-control" placeholder="Harga" required>
                    <input type="file" name="gambar" class="input-control" required>
                    <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"></textarea><br>
                    <select class="input-control" name="status">
                        <option value="">-- Pilih Status --</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <input type="submit" name="submit" value="Tambah" class="btn">
                </form>
                <?php
                if (isset($_POST['submit'])) {

                    //print r($_FILES['gambar']);
                    //menampung input dari form
                    $kategori   = $_POST['data-produk'];
                    $nama       = $_POST['nama'];
                    $harga      = $_POST['harga'];
                    $deskripsi  = $_POST['deskripsi'];
                    $status     = $_POST['status'];

                    //menampung data file yang diupload
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];

                    $newimage = 'produk' . time() . '.' . $type2;

                    //menampung data format file yang diizinkan
                    $tipe_izin = array('.jpg', '.jpeg', '.png', '.gif');

                    //membuat validasi format file
                    if (in_array($type2, $tipe_izin)) {
                        //jika format array tidak sesuai atau tidak ada
                        echo '<script>alert("Format file tidak diizinkan")</script>';
                    } else {
                        //jika format array sesuai
                        //proses upload file sekaligus insert database
                        move_uploaded_file($tmp_name, './produk/' . $newimage);

                        $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES (
                                                    null,
                                                    '" . $kategori . "',
                                                    '" . $nama . "',
                                                    '" . $harga . "',
                                                    '" . $deskripsi . "',
                                                    '" . $newimage . "',
                                                    '" . $status . "',
                                                    null) ");

                        if ($insert) {
                            echo '<script>alert("Tambah produk berhasil")</script>';
                            echo '<script>window.location="data-produk.php"</script>';
                        } else {
                            echo 'Gagal menambah produk' . mysqli_error($conn);
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
    <script>
        CKEDITOR.replace('deskripsi');
    </script>
</body>

</html>