<?php
require 'admin/connect.php';
$sql = "SELECT * FROM pesanan ps INNER JOIN products p ON ps.id_produk = p.id_produk 
        INNER JOIN bayar b ON ps.id_cust = b.id_cust WHERE ps.id_cust = 0 ORDER BY p.id_produk ASC";
$total_price = mysqli_query($conn, $sql);
$result = mysqli_query($conn, $sql);
$res = mysqli_query($conn,$sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'checkout') {
        $nama_cust = $_POST['nama_cust'];
        $no_meja = $_POST['no_meja'];
        $metode = $_POST['metode'];
        $jml_bayar = $_POST['jml_bayar'];
        $row = mysqli_fetch_array($res);
        $total_bayar = $row['total_bayar'];


        if ($jml_bayar >= $total_bayar) {
            $sql = "CALL insert_cust('$nama_cust','$no_meja','$metode','$jml_bayar')";
            mysqli_query($conn,$sql);

            $query = " INSERT INTO riwayat (id_cust, nama_cust, no_meja, produk, harga, jumlah, sub_total, total_bayar,metode,jml_bayar,tgl_pesan)
                        SELECT c.id_cust,c.nama_cust,c.no_meja,p.produk,p.harga,ps.jumlah,ps.sub_total,b.total_bayar,b.metode,b.jml_bayar,now()
                            FROM customer c
                            INNER JOIN pesanan ps ON c.id_cust = ps.id_cust
                            INNER JOIN products p ON ps.id_produk = p.id_produk
                            INNER JOIN bayar b ON c.id_cust = b.id_cust";
            mysqli_query($conn,$query);

            header("Location: struk.php");
            exit;
        }else {
            echo  mysqli_error($conn);
            header("Location: checkout.php");
            exit;
        }   
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Tambahkan CSS atau link ke file CSS di sini -->
</head>
<!--=============== FLATICON ===============-->
<link rel="stylesheet"
    href="https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-straight/css/uicons-regular-straight.css" />

<!--=============== SWIPER CSS ===============-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- =============== CSS =============== -->
<link rel="stylesheet" href="assets/css/style.css" />
<link rel="icon" href="admin/image/logo2.png" type="image/x-icon" />
<link rel="shortcut icon" href="admin/image/logo2.png" type="image/x-icon" />

<head>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #fff;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
    }

    form {
        max-width: 1000px;
        margin: 0 auto 40px auto;
        padding: 5px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],input[type="number"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
/* Style untuk select dropdown */
    select {
      width: 100%;
      padding: 0.5em;
      font-size: 1em;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      
    }

    option {
      font-size: 1em;
    }

    .total_bayar {
        margin-top: 10px;
        text-align: right;
        font-weight: bold;
    }

    .cart__actions {
        text-align: center;
        margin-top: 0;
    }

    .cart__actions button {
        padding: 10px 20px;
        background-color: #FF7F00;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
        /* Efek transisi untuk hover */
    }

    .cart__actions button:hover {
        background-color: rgba(255, 127, 0, 0.8);
        box-shadow: 0 0 10px rgba(255, 127, 0, 0.8);
        /* Efek glow */
    }
     /* Responsive Styling */
    @media only screen and (max-width: 600px) {
        form {
            padding: 10px;
        }
    
        input[type="text"],
        select {
            font-size: 14px;
        }
        .table__cell {
            text-align: center;
        }
        .table__cell.table__image img {
            max-width: 50px; /* Adjust the max-width to your preference */
            height: auto;
        }
        .table__cell {
            font-size: 12px; /* Adjust the font size for product checkout */
        }
        .total_bayar {
            margin-top: 0; /* Adjusted margin-top */
            margin-bottom: 5px; /* Adjusted margin-bottom */
        }
        .cart {
            padding-bottom: 10px;
        }
    }
    </style>
</head>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Tambahkan bagian head di sini -->
</head>

<body>
    <h1>Checkout</h1>
    <form method="POST">
        <label for="nama_cust">Nama Pelanggan:</label><br>
        <input type="text" id="nama_cust" name="nama_cust" required><br><br>

        <label for="no_meja">Nomor Meja:</label><br>
        <select id="no_meja" name="no_meja">
          <option value="0">Take Away</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
        </select><br><br>

        <label for="metode">Payment Method</label>
        <select name="metode" id="metode">
            <option value="qris">Qris</option>
            <option value="cash">Cash</option>
        </select><br><br>

        <label for="jml_bayar">Cash</label>
        <input type="number" id="jml_bayar" name="jml_bayar" required><br><br>


        <!-- Detail Pesanan -->
        <section class="cart section--lg container">
            <div class="table__container" x-data="products">
                <table class="table">
                    <thead>
                        <tr class="table__row table__header">
                            <th class="table__cell">Image</th>
                            <th class="table__cell">Name</th>
                            <th class="table__cell">Price</th>
                            <th class="table__cell">Quantity</th>
                            <th class="table__cell">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        while($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr class="table__row table__product">
                            <td class="table__cell table__image">
                                <img src="admin/<?php echo $row['gambar']; ?>" alt="" class="product__img default" />
                            </td>
                            <td class="table__cell table__name"><?php echo $row['produk']; ?></td>
                            <td class="table__cell table__price">
                                <?php echo 'Rp'.number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td class="table__cell table__qty"><?php echo $row['jumlah']; ?></td>
                            <td class="table__cell table__subtotal">
                                <?php echo 'Rp'.number_format($row['sub_total'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="total_bayar">Total Price<br>
            <?php
              $row = mysqli_fetch_array($total_price);
              echo 'Rp'.number_format($row['total_bayar'], 0, ',', '.');
              
            ?>
        </section>

        <!-- Tombol Checkout -->
        <div class="cart__actions">
            <button type="submit" name="action" value="checkout">Checkout</button>
        </div>
    </form>
</body>

</html>