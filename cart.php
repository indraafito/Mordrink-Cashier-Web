<?php
require'admin/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lakukan koneksi ke database jika belum dilakukan

    // Ambil data yang dikirimkan dari formulir
    $id_produk = $_POST['id_produk'];
    $action = $_POST['action'];
    $jumlah = $_POST['jumlah'];

    // Lakukan operasi penambahan atau pengurangan jumlah sesuai dengan aksi
    if ($action === 'increment') {
        // Eksekusi query untuk menambah jumlah
        $query = "UPDATE pesanan SET jumlah = jumlah + 1 WHERE id_produk = '$id_produk'";
        mysqli_query($conn, $query);
    } elseif ($action === 'decrement') {
        // Eksekusi query untuk mengurangi jumlah
        $query = "UPDATE pesanan SET jumlah = jumlah - 1 WHERE id_produk = '$id_produk' AND jumlah > 0";
        mysqli_query($conn, $query);
    } elseif ($action === 'remove') {
            // Eksekusi query untuk menghapus produk dari pesanan
        $query = "DELETE FROM pesanan WHERE id_produk = '$id_produk'";
        mysqli_query($conn, $query);
    } elseif($action === 'continue') {
        if ($jml_produk = mysqli_query($conn,"SELECT COUNT(id_produk) AS jumlah_produk from pesanan;")){
            $jml=mysqli_fetch_assoc($jml_produk);
            $row = $jml['jumlah_produk'];
            if($row == 0 ){
                $sql = mysqli_query($conn,"DELETE FROM bayar");
                header("Location: cart.php");
            }else{
                $check_query = "SELECT COUNT(id_cust) AS id FROM bayar";
                $check_result = mysqli_query($conn, $check_query);
                $row = mysqli_fetch_assoc($check_result);
                $total = $row['id'];

                if ($total == 0) {
                    $query = "INSERT INTO bayar (id_cust) VALUES (0) ";
                    mysqli_query($conn,$query);
                
                    header("Location: checkout.php");
                    exit();
                }else {
                    $query = "UPDATE bayar SET id_cust = 0";
                    mysqli_query($conn,$query);
                
                    header("Location: checkout.php");
                    exit();
                }
            }
            
        }
        
        
    }

    if($jumlah == 0) {
        $query = "DELETE FROM pesanan WHERE jumlah = 0";
        mysqli_query($conn,$query);
    }



    // Redirect kembali ke halaman keranjang belanja atau halaman lain yang sesuai
    header("Location: cart.php");
    exit;
}

?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== FLATICON ===============-->
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-straight/css/uicons-regular-straight.css" />

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


    <!-- =============== CSS =============== -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="icon" href="adminimage/logo2.png" type="image/x-icon" />
    <link rel="shortcut icon" href="admin/image/logo2.png" type="image/x-icon" />

    <!-- /*=============== CART ===============*/ -->
    <style>
       /* CSS Responsif untuk Smartphone */
        @media only screen and (max-width: 600px) {
            .table__cell:nth-child(1) {
              width: 150px;
            }

            .table__cell:nth-child(2) {
              width: 150px;
            }

            .table__cell:nth-child(3) {
              width: 150px;
            }

            .table__cell:nth-child(4) {
              width: 150px;
            }

            .table__cell:nth-child(5) {
              width: 150px;
            }

            .table__cell:nth-child(6) {
              width: 150px;
            }
            form {
                padding: 10px;
            }
            .table__cell.table__remove {
                display: flex;
            }
            
            .table__cell.table__qty {
                margin-top: -20px; /* Menyesuaikan margin atas */
            }

            input[type="text"],
            select {
                font-size: 14px;
            }
            .table__cell {
                text-align: center;
                font-size: 10px;
            }
            .table__cell.table__image img {
                max-width: 40px; /* Adjust the max-width to your preference */
                height: auto;
            }
        }
    </style>
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
                    <li class="nav__item">
                        <a href="shop.php" class="nav__link">Shop</a>
                    </li>
                </ul>
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
                <li><a href="shop.php" class="breadcrumb__link">Shop</a></li>
                <li><span class="breadcrumb__link">></span></li>
                <li><span class="breadcrumb__link">Cart</span></li>
            </ul>
        </section>

        <!--=============== CART ===============-->
        <section class="cart section--lg container">
            <div class="table__container" x-data="products">
                <table class="table">
                    <div class="table__container">
                        <div class="table">
                            <div class="table__row table__header">
                                <div class="table__cell">Image</div>
                                <div class="table__cell">Name</div>
                                <div class="table__cell">Price</div>
                                <div class="table__cell">Quantity</div>
                                <div class="table__cell">Subtotal</div>
                                <div class="table__cell">Remove</div>
                            </div>
                            <div class="table">
                                <?php
              $sql = "SELECT * FROM pesanan p INNER JOIN products pr ON p.id_produk = pr.id_produk where id_cust = 0 order by p.id_produk asc; ";
              $result = mysqli_query($conn, $sql);
              $nomor = 1;
              while($row = mysqli_fetch_array($result)){
              ?>
                                <div class="table__row table__product">
                                    <div class="table__cell table__image">
                                        <img src="admin/<?php echo $row['gambar'] ?>" alt=""
                                            class="product__img default" />
                                    </div>
                                    <div class="table__cell table__name">
                                        <?php echo $row['produk'] ?>
                                    </div>
                                    <div class="table__cell table__price">
                                        <?php echo 'Rp'.number_format($row['harga'], 0, ',', '.') ?>
                                    </div>
                                    <div class="table__cell table__qty">
                                        <form method="POST">
                                            <input type="hidden" name="id_produk"
                                                value="<?php echo $row['id_produk']; ?>">
                                            <button type="submit" name="action" value="decrement">-</button>
                                            <?php echo $row['jumlah'] ?>
                                            <button type="submit" name="action" value="increment">+</button>
                                        </form>
                                    </div>
                                    <div class="table__cell table__subtotal">
                                        <?php echo 'Rp'.number_format($row['sub_total'], 0, ',', '.') ?>
                                    </div>
                                    <div class="table__cell table__remove">
                                        <form method="POST">
                                            <input type="hidden" name="id_produk"
                                                value="<?php echo $row['id_produk']; ?>">
                                            <button type="submit" name="action" value="remove"
                                                onclick="return confirm('Are you sure you want to remove this item?')">
                                                <a href=""><img src="assets/img/trash.svg" alt="" /></button></a>
                                                
                                        </form><!-- Tambahkan tombol hapus jika diperlukan -->
                                    </div>
                                </div>
                                <?php 
                                $nomor++;
                                } 
                                ?>
                            </div>
                        </div>
                </table>
            </div>

            <form method="POST">
                <div class="cart__actions">
                    <a class="btn flex btn--">
                        <input type="hidden" name="id_cust" id="id_cust" value="<?php echo $row['id_cust']; ?>">
                        <button type="submit" name="action" value="continue"><i class="fi-rs-shopping-bag"></i> Checkout
                            Now
                        </button>
                    </a>
                </div>
            </form>

        </section>
    </main>

    <!--=============== FOOTER ===============-->

    <!--=============== SWIPER JS ===============-->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="assets/js/main.js"></script>
</body>

</html>