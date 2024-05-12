<?php
require'admin/connect.php';


$total_count=0;
$count_query = "SELECT COUNT(id_produk) AS count FROM pesanan";
$count_result = mysqli_query($conn, $count_query);
    
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
        <form method="POST">
            <input type="hidden" name="action" value="nav">
            <nav class="nav container">
                <a class="nav__logo">
                    <img src="admin/image/logo.png" alt="" class="nav__logo-img" />
                </a>
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="index.php" class="nav__link active-link">Home</a>
                        </li>
                        <li class="nav__item">
                            <a href="#about" class="nav__link">About</a>
                        </li>
                        <li class="nav__item">
                            <a href="shop.php" class="nav__link">Shop</a>
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
            </input>
        </form>

    </header>

    <!--=============== MAIN ===============-->
    <main class="main">
        <!--=============== HOME ===============-->
        <section class="home section--lg">
            <div class="home__container container grid">
                <div class="home__content">
                    <h1 class="home__title">Welcome to <span>Mordrink</span></h1>
                    <p class="home__description">Jelajahi ragam rasa yang memikat</p>
                    <a href="shop.php" class="btn">Order Now</a>
                </div>
                <img src="admin/image/homenew.png" alt="" class="home__img" />
            </div>

            <!--=============== ABOUT ===============-->
            <section id="about" class="about section home__about">
                <div class="about">
                    <div class="about__main">
                        <div class="image">
                            <img src="admin/image/About.png" alt="" />
                        </div>
                        <div class="about__text">
                            <h1><span>About</span>Us</h1>
                            <h3>Why Choose us?</h3>
                            <p>
                                Mordrink didirikan pada tahun 2022 oleh sekelompok pecinta
                                minuman dengan visi untuk menciptakan minuman yang menyegarkan
                                dan menginspirasi. Misi kami adalah memberikan pengalaman
                                minum luar biasa kepada pelanggan kami dengan minuman
                                berkualitas tinggi dan inovatif. Kami memprioritaskan kualitas
                                dalam setiap minuman kami dan berkomitmen untuk praktik bisnis
                                yang ramah lingkungan. Mari temukan kegembiraan dalam setiap
                                tegukan bersama Mordrink! Bersama, kita menciptakan pengalaman
                                minum yang tak terlupakan.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!--=============== BEST SELLER ===============-->
            <section class="categories container section" x-data="best_seller">
                <h3 class="section__title"><span>Best</span> Seller</h3>
                <div class="categories__container swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $sql = "SELECT * FROM products ORDER BY RAND() ";
                        $result = mysqli_query($conn,$sql);
                        $count = 0;
            
                        if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            ?>

                        <a href="javascript:void(0)" class="category__item swiper-slide">
                            <img src="admin/<?php echo $row['gambar']; ?>" alt="" class="category__img" />
                            <h3 class="category__title"><?php echo $row['produk']; ?></h3>
                        </a>
                        <?php
                      $count++;
                      if ($count >= 8) {
                        break;
                      }
                  }
              } else{
                echo "Tidak ada produk yang ditemukan.";
              }
              ?>
                    </div>

                    <div class="swiper-button-next">
                        <i class="fi fi-rs-angle-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="fi fi-rs-angle-left"></i>
                    </div>
                </div>
            </section>

            <!--=============== PRODUCTS ===============-->
            <section class="products section container" id="cart">
                <div class="tab__btns">
                    <span class="tab__btn active-tab" data-target="#minuman">Minuman</span>
                    <span class="tab__btn" data-target="#makanan">Makanan</span>
                </div>
                <div class="tab__items">
                    <div class="tab__item active-tab" content id="minuman" x-data="products">
                        <div class="products__container grid">
                            <?php
                            $sql = "SELECT * FROM products WHERE id_produk LIKE 'A%' ORDER BY produk ASC";
                            $result = mysqli_query($conn, $sql);
                            $nomor = 1;
                            while($row = mysqli_fetch_array($result)){
                            ?>
                            <div class="product__item">
                                <div class="product__banner">
                                    <a href="shop.php" class="product__images">
                                        <img src="admin/<?php echo $row['gambar'] ?>" alt=""
                                            class="product__img default" />
                                        <img src="admin/<?php echo $row['gambar'] ?>" alt=""
                                            class="product__img hover" />
                                    </a>
                                </div>
                                <div class="product__content">
                                    <a href="shop.php">
                                        <h3 class="product__title"><?php echo $row['produk'] ?></h3>
                                    </a>
                                    <div class="product_price flex">
                                        <span class="new__price">Rp
                                            <?php echo number_format($row['harga'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            $nomor++;
                            } 
                            ?>

                        </div>
                    </div>
                    <div class="tab__item" content id="makanan" x-data="product">
                        <div class="products__container grid">
                            <?php
                            $sql = "SELECT * FROM products WHERE id_produk LIKE 'B%' ORDER BY produk ASC";
                            $result = mysqli_query($conn, $sql);
                            $nomor = 1;
                            while($row = mysqli_fetch_array($result)){
                            ?>
                            <div class="product__item">
                                <div class="product__banner">
                                    <a href="shop.php" class="product__images">
                                        <img src="admin/<?php echo $row['gambar'] ?>" alt=""
                                            class="product__img default" />
                                        <img src="admin/<?php echo $row['gambar'] ?>" alt=""
                                            class="product__img hover" />
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

            <!--=============== FOOTER ===============-->
            <footer class="footer container">
                <div class="footer__container grid">
                    <div class="footer__content">
                        <a class="footer__logo">
                            <img src="admin/image/logo2.png" alt="" class="footer__logo-img" />
                        </a>
                        <h4 class="footer__subtitle">Contact</h4>
                        <p class="footer__description">
                            <span>Alamat:</span> Jl. Candi 6 Karang besuki
                        </p>
                        <p class="footer__description">
                            <span>Telepon:</span> +62 815 1520 1815
                        </p>
                        <p class="footer__description">
                            <span>Jam buka:</span> 10:00 - 18.00, Setiap hari
                        </p>
                        <div class="footer__social">
                            <h3 class="footer__title">Pembayaran</h3>
                            <img src="admin/image/Pembayaran.png" alt="" class="payment__img" />
                        </div>
                    </div>
                    <div class="footer__content2">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3951.3689284111347!2d112.6177141750069!3d-7.960772192063938!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zN8KwNTcnMzguOCJTIDExMsKwMzcnMTMuMCJF!5e0!3m2!1sid!2sid!4v1714099090303!5m2!1sid!2sid"
                            width="400" height="250" style="border: 0" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </footer>

            <!--=============== SWIPER JS ===============-->
            <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

            <!--=============== MAIN JS ===============-->
            <script src="assets/js/main.js"></script>
        </section>
    </main>
</body>

</html>