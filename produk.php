<?php
error_reporting(0);
include 'koneksi.php';
$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tbl_admin WHERE admin_id = 1");
$a = mysqli_fetch_object($kontak);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TOKO ARSIWA</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="index.php">TOKO ARSIWA</a></h1>
            <ul>
                <li><a href="produk.php">Produk</a></li>
            </ul>
        </div>
    </header>

    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="Cari Produk" value="<?php echo $_GET['search'] ?>">
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>">
                <input type="submit" name="cari" value="Search">
            </form>
        </div>
    </div>

    <!-- new product -->
    <div class="container">
        <h3>Produk</h3>
        <div class="row">
            <?php
            if ($_GET['search'] != '' || $_GET['kat'] != '') {
                $where = "AND product_name LIKE '%" . $_GET['search'] . "%' AND category_id LIKE '%" . $_GET['kat'] . "%' ";
            }

            $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 $where ORDER BY product_id DESC");
            if (mysqli_num_rows($produk) > 0) {
                while ($p = mysqli_fetch_array($produk)) {
            ?>
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="produk/<?php echo $p['product_image'] ?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo substr($p['product_name'], 0, 30) ?></h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Beli</button>
                                    </div>
                                    <small class="text-muted">Rp. <?php echo $p['product_price'] ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <p>Produk tidak ada</p>
            <?php } ?>
        </div>
    </div>

    <!-- footer -->
    <div class="footer">
        <div class="container">
            <h4>Alamat</h4>
            <p><?php echo $a->admin_address ?></p>

            <h4>Email</h4>
            <p><?php echo $a->admin_email ?></p>

            <h4>No.Hp</h4>
            <p><?php echo $a->admin_telp ?></p>
            <small>Copyright &copy; 2023 - Toko Arsiwa</small>
        </div>
    </div>
</body>

</html>