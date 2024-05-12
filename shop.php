<?php
require 'admin/connect.php';
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$success_message = '';


$total_count=0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_cart'])) {
        // Tangkap nilai id_produk dari form
        $id_produk = $_POST['id_produk'];
        $jumlah = 1; 


        // Lakukan pengecekan apakah id_produk sudah ada dalam pesanan
        $check_query = "SELECT COUNT(*) AS total FROM pesanan WHERE id_produk = '$id_produk'";
        $check_result = mysqli_query($conn, $check_query);
        $row = mysqli_fetch_assoc($check_result);
        $total = $row['total'];

        // Jika id_produk belum ada dalam pesanan, tambahkan ke pesanan
        if ($total == 0) {
            $sql = "INSERT INTO pesanan(id_produk, jumlah) 
                        VALUES ('$id_produk', '$jumlah')";
            mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE pesanan SET jumlah = jumlah + 1 WHERE id_produk = '$id_produk'";
            mysqli_query($conn, $sql);
        }

    }

   
}

$count_query = "SELECT COUNT(id_produk) AS count FROM pesanan";
$count_result = mysqli_query($conn, $count_query);
    
// Periksa apakah query berhasil dijalankan
if (!$count_result) {
    die("Error: " . mysqli_error($conn));
}
$count_row = mysqli_fetch_assoc($count_result);
$total_count = $count_row['count'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== FLATICON ===============-->
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-straight/css/uicons-regular-straight.css" />

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="icon" href="admin/image/logo2.png" type="image/x-icon" />
    <link rel="shortcut icon" href="admin/image/logo2.png" type="image/x-icon" />
    <title>Mordrink</title>
</head>

<body>
    <!--=============== HEADER ===============-->
    <header class="header" x-data>
        <nav class="nav container">
            <a class="nav__logo">
                <img src="admin/image/logo.png" alt="" class="nav__logo-img" />
            </a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="index.php" class="nav__link">Home</a>
                    </li>
                    <li class="nav__item" name>
                        <a href="shop.php" class="nav__link active-link">Shop</a>
                    </li>
                </ul>
            </div>



            <div class="header__user-actions">
                <a href="cart.php" class="header__action-btn">
                    <img src="assets/img/cart.svg" alt="" />
                    <span class="count"><?php echo $total_count?></span>
                </a>
            </div>
        </nav>
    </header>

    <!--=============== MAIN ===============-->
    <main class="main">
        <!--=============== BREADCRUMB ===============-->
        <section class="breadcrumb">
            <ul class="breadcrumb__list flex container">
                <li><a href="index.php" class="breadcrumb__link">Home</a></li>
                <li><span class="breadcrumb__link">></span></li>
                <li><span class="breadcrumb__link">Shop</span></li>
            </ul>
        </section>

        <!--=============== PRODUCTS ===============-->
        <section class="products section container" id="cart">
            <div class="tab__items">
                <div class="tab__item active-tab" content id="minuman" x-data="products">
                    <div class="products__container grid">
                        <?php
                        $nomor = 1;
                        while($row = mysqli_fetch_array($result)){
                        ?>
                        <div class="product__item">
                            <div class="product__banner">
                                <a class="product__images">
                                    <img src="admin/<?php echo $row['gambar'] ?>" alt="" class="product__img default" />
                                    <img src="admin/<?php echo $row['gambar'] ?>" alt="" class="product__img hover" />
                                </a>
                            </div>
                            <div class="product__content">
                                <a>
                                    <h3 class="product__title"><?php echo $row['produk'] ?></h3>
                                </a>
                                <div class="product_price flex">
                                    <span class="new__price">Rp
                                        <?php echo number_format($row['harga'], 0, ',', '.') ?></span>
                                </div>
                                <form method="post">
                                    <!-- Tambahkan input hidden untuk menyimpan id_produk -->
                                    <input type="hidden" name="id_produk" id="id_produk"
                                        value="<?php echo $row['id_produk']; ?>">

                                    <!-- Ubah tombol submit -->
                                    <button type="submit" class="action__btn cart__btn" name="submit_cart"
                                        aria-label="Add To Cart">
                                        <img src="assets/img/cart.svg" alt="" />
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php 
                        $nomor++;
                        } 
                        ?>

                    </div>
                </div>
            </div>
        </section>

        <!--=============== NEWSLETTER ===============-->
    </main>

    <!--=============== FOOTER ===============-->
    <!--=============== SWIPER JS ===============-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="assets/js/main.js"></script>
</body>

</html>