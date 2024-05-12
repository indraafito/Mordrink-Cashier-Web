<?php include("inc_header.php")?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan</title>
</head>

<body>
    <div>
        <section class="cart section--lg container">
            <div class="table__container" x-data="products">
                <table class="table">
                    <thead>
                        <tr class="table__row table__header">
                            <th class="table__cell">Id</th>
                            <th class="table__cell">Name</th>
                            <th class="table__cell">No</th>
                            <th class="table__cell">Title</th>
                            <th class="table__cell">Price</th>
                            <th class="table__cell">Quantity</th>
                            <th class="table__cell">Subtotal</th>
                            <th class="table__cell">Total Price</th>
                            <th class="table__cell">Method</th>
                            <th class="table__cell">Cash</th>
                            <th class="table__cell">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM riwayat";
                        $result = mysqli_query($conn, $sql);
                        $prev_id = null;
                        $prev_nama = null;
                        $prev_no = null;
                        $prev_payment = null;
                        $prev_method = null;
                        $prev_cash = null;
                        $prev_date = null;
                        while($row = mysqli_fetch_array($result)) {
                            if ($row['id_cust'] != $prev_id || $row['nama_cust'] != $prev_nama || $row['no_meja'] != $prev_no || $row['total_bayar'] != $prev_payment || $row['metode'] != $prev_method || $row['jml_bayar'] != $prev_cash || $row['tgl_pesan'] != $prev_date ) {
                                echo "<tr class='table__row table__product'>";
                                echo "<td class='table__cell table__name'>" . $row['id_cust'] . "</td>";
                                echo "<td class='table__cell table__name'>" . $row['nama_cust'] . "</td>";
                                if ($row['no_meja'] == 0) {
                                    echo "<td class='table__cell table__no'>"."Takeaway". "</td>";
                                }else{
                                    echo "<td class='table__cell table__no'>" . $row['no_meja'] . "</td>";
                                }
                                echo "<td class='table__cell table__name'>" . $row['produk'] . "</td>";
                                echo "<td class='table__cell table__price'>" . number_format($row['harga'], 0, ',', '.') . "</td>";
                                echo "<td class='table__cell table__qty'>" . $row['jumlah'] . "</td>";
                                echo "<td class='table__cell table__subtotal'>" . number_format($row['sub_total'], 0, ',', '.') . "</td>";
                                echo "<td class='table__cell table__subtotal'>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>";
                                echo "<td class='table__cell table__method'>" . $row['metode'] . "</td>";
                                echo "<td class='table__cell table__cash'>" . number_format($row['jml_bayar'], 0, ',', '.') . "</td>";
                                echo "<td class='table__cell table__date'>" . $row['tgl_pesan'] . "</td>";
                                echo "</tr>";
                            } else {
                                echo "<tr class='table__row table__product'>";
                                echo "<td class='table__cell table__name'></td>";
                                echo "<td class='table__cell table__name'></td>";
                                echo "<td class='table__cell table__no'></td>";
                                echo "<td class='table__cell table__name'>" . $row['produk'] . "</td>";
                                echo "<td class='table__cell table__price'>" . number_format($row['harga'], 0, ',', '.') . "</td>";
                                echo "<td class='table__cell table__qty'>" . $row['jumlah'] . "</td>";
                                echo "<td class='table__cell table__subtotal'>" . number_format($row['sub_total'], 0, ',', '.') . "</td>";
                                echo "<td class='table__cell table__subtotal'></td>";
                                echo "<td class='table__cell table__method'></td>";
                                echo "<td class='table__cell table__cash'></td>";
                                echo "<td class='table__cell table__date'></td>";
                                echo "</tr>";
                            }
                            $prev_id = $row['id_cust'];
                            $prev_nama = $row['nama_cust'];
                            $prev_no = $row['no_meja'];
                            $prev_payment = $row['total_bayar'];
                            $prev_method = $row['metode'];
                            $prev_cash = $row['jml_bayar'];
                            $prev_date = $row['tgl_pesan'];
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>



</html>