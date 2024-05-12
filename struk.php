<?php
require'admin/connect.php';
$sql = "SELECT r1.*, (r1.jml_bayar - r1.total_bayar) AS kembalian
        FROM riwayat r1
        JOIN (SELECT MAX(id_cust) AS max_id FROM riwayat) r2
        ON r1.id_cust = r2.max_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_bayar = 0; 
if ($row) {
    $total_bayar = $row['total_bayar']; 
}

if($_SERVER['REQUEST_METHOD']== "POST"){
  $action=$_POST['action'];

  if($action === 'back') {
    $query="DELETE pesanan, bayar FROM pesanan
              INNER JOIN bayar ON pesanan.id_cust = bayar.id_cust";
    mysqli_query($conn,$query);

  header('Location: index.php');
  exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>struk</title>

    <!--=============== FLATICON ===============-->
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/2.3.0/uicons-regular-straight/css/uicons-regular-straight.css" />

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- =============== CSS =============== -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="icon" href="admin/image/logo2.png" type="image/x-icon" />
    <link rel="shortcut icon" href="admin/image/logo2.png" type="image/x-icon" />
    <!-- Tambahkan CSS atau link ke file CSS di sini -->
</head>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.nomor {
    margin-top: 20px;
}

.nomor h1 {
    font-size: 24px;
    color: #FF7F00;
    margin-bottom: 10px;
}

.cust {
}

.cust h2 {
    font-size: 18px;
    color: #333;
    margin-bottom: 20px;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.product__img {
    max-width: 100px;
    height: auto;
}

.payment {
    text-align: center;
    font-size: 24px;
    color: #FF7F00;
    margin-top: 20px;
}

.pay{
    text-align: center;
    font-size: 24px;
    margin-top: 10px;
    margin-bottom: 20px;
}



.cart__actions {
    margin-right: 250px;
    margin-top: 70px;
    padding-bottom: 100px;
    /* Menyesuaikan jarak ke tombol "Payment" */
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
.print-link {
    display: inline-block;
    margin-left: 20px; /* Adjust as needed */
}

.print-link a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #FF7F00;
    color: #fff;
    text-decoration: none; /* Remove underline */
    border-radius: 5px;
    transition: background-color 0.3s, box-shadow 0.3s;
}

.print-link a:hover {
    background-color: rgba(255, 127, 0, 0.8);
    box-shadow: 0 0 10px rgba(255, 127, 0, 0.8);
}

/* Additional CSS for the left-info and right-info layout */
.transaction {
    display: flex;
    justify-content: space-between;
    align-items: center; /* Menggunakan align-items agar konten di dalam .transaction berada di tengah vertikal */
    margin-top: 10px;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
}

.left-info,
.right-info {
    flex: 1;
}

.left-info {
    text-align: left;
}

.right-info {
    text-align: right;
    margin-right: auto; /* Menggeser .right-info ke kanan agar berada di tengah */
}

.method,
.cash,
.change {
    font-size: 16px;
    color: #333;
    margin-bottom: 10px;
}

.method-value,
.cash-value,
.change-value {
    font-size: 16px;
    color: #666;
    margin-bottom: 10px;
}
@media (min-width: 320px) and (max-width: 767px) {
    .container {
        padding: 10px;
    }
    .cart__actions button,
    .print-link a {
        margin-top: 10px;
    }
    .table__cell {
        text-align: center;
        font-size: 13px;
    }
    .cart__actions {
        margin-right: 20px;
    }
    
}
@media (min-width: 768px) and (max-width: 1024px) {
    .container {
        padding: 10px;
    }
    .cart__actions button,
    .print-link a {
        margin-top: 10px;
    }
    .table__cell {
        text-align: center;
        font-size: 13px;
    }
    .cart__actions {
        margin-right: 30px;
    }
    
}

</style>

<body>
    
    <form>

    <section class="cart section--lg container">
        <div class="nomor">
            <?php
          if ($row['no_meja'] == 0) {
            echo "<h1> Take away </h1>";
          } else {
            echo "<h1>" . "NO." . $row['no_meja'] . "</h1>";
          }
          ?>
        </div>
        <div class="cust">
            <?php
          if ($row) { 
              echo "<h2>" . $row['nama_cust'] . ", Thanks For Order</h2>";
          }
          ?>
        </div>
        <hr>
        <div class="payment">Total Price</div>
        <div class="pay">
            <?php
              echo "Rp.".number_format($total_bayar, 0, ',', '.');
              ?>
        </div>
            <div class="table__container">
                <table class="table">
                    <thead>
                        <tr class="table__row table__header">
                            <th class="table__cell">Title</th>
                            <th class="table__cell">Price</th>
                            <th class="table__cell">Quantity</th>
                            <th class="table__cell">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_array($result)) {
                            ?>
                        <tr class="table__row table__product">
                            <td class="table__cell table__name"><?php echo $row['produk']; ?></td>
                            <td class="table__cell table__price"><?php echo number_format($row['harga'], 0, ',', '.'); ?>
                            </td>
                            <td class="table__cell table__qty"><?php echo $row['jumlah']; ?></td>
                            <td class="table__cell table__subtotal">
                                <?php echo number_format($row['sub_total'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <hr>
            </div>
                            
            <div class="transaction">
                <?php
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>
                <div class="left-info">
                    <div class="method">Method</div>
                    <div class="cash">Cash</div>
                    <div class="change">Change</div>
                </div>
                <div class="right-info">
                    <div class="method-value"><?php echo $row['metode']; ?></div>
                    <div class="cash-value"><?php echo number_format($row['jml_bayar'], 0, ',', '.'); ?></div>
                    <div class="change-value"><?php echo number_format($row['kembalian'], 0, ',', '.'); ?></div>
                </div>
            </div>
    </section>

    </form>
    <form method="POST">

    <div class="cart__actions">
        <div class="print-link">
            <a target="_blank" href="print.php">Print</a>
        </div>
        <button type="submit" name="action" value="back">BACK</button>
            
    </div>


    </form>
    
</body>

</html>