<?php
require'admin/connect.php';
$sql = "SELECT r1.*, (r1.jml_bayar - r1.total_bayar) AS kembalian
        FROM riwayat r1
        JOIN (SELECT MAX(id_cust) AS max_id FROM riwayat) r2
        ON r1.id_cust = r2.max_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        /*  */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .receipt-info {
            margin-bottom: 20px;
        }
        .receipt-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        tbody{
            font-size:13px;
            text-align: center;
        }
        th, td {
            padding: 5px;
            border-bottom: 1px solid #ccc;
        }
        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
        .total span {
            font-size: 14px;
        }
        .thx{
            font-size: 10px;
            text-align:center;
            padding-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mordrink</h1>
        </div>
        <div class="receipt-info">
            <?php
      if ($row['no_meja'] == 0) {
        echo "<p> Take away </p>";
      } else {
        echo "<p>" . "NO." . $row['no_meja'] . "</p>";
      }
      ?>
            
        </div>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result)) {
                        ?>
                    <tr>
                        <td><?php echo $row['produk']; ?></td>
                        <td>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['jumlah']; ?></td>
                        <td>Rp. <?php echo number_format($row['sub_total'], 0, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="total">
            <?php 
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);?>
                <span>Method: <?php echo $row['metode'];?></span><br>
                <span>Total : Rp. <?php echo number_format($row['total_bayar'], 0, ',', '.'); ?></span><br>
                <span>Cash  : Rp. <?php echo number_format($row['jml_bayar'], 0, ',', '.'); ?></span><br>
                <span>Change: Rp. <?php echo number_format($row['kembalian'], 0, ',', '.'); ?></span><br>
            <?php?>
        </div>
        <div class ="thx">
        <?php
        $sql = "SELECT * FROM riwayat WHERE id_cust = (SELECT MAX(id_cust) FROM riwayat)";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
              if ($row) { 
                  echo "<h2>" . $row['nama_cust'] . ", Thanks For Order</h2>";
              } 
              ?>
        </div>
    </div>
    <script type="text/javascript">window.print();</script>
</body>
</html>