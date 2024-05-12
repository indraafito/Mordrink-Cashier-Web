<?php include("inc_header.php")?>
<?php
$sukses = "";
$error = "";
$op = isset($_GET['op']) ? $_GET['op'] : ''; 
if($op == 'delete'){
    $id = $_GET['id']; 
    $sql1 = "DELETE FROM products WHERE id_produk = '$id'"; // Perbaikan di sini
    $q1 = mysqli_query($conn, $sql1);
    if($q1){
        $sukses = "Data berhasil dihapus";
    }else{
        $error = "Data gagal dihapus";
    }
}
?>
<h1>Data Produk</h1>
<p>
    <a href="input page.php" class="btn btn-primary">Tambahkan Produk</a>
</p>
<?php if($sukses): ?>
<div class="alert alert-success" role="alert">
    <?php echo $sukses ?>
</div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-1">Nomor</th>
            <th>Gambar</th>
            <th>Produk</th>
            <th>Harga</th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $limit = 5; // Perubahan di sini
        $sql = "SELECT * FROM products"; // Perbaikan di sini
        $page = isset($_GET['page'])?(int)$_GET['page'] : 1;
        $mulai = ($page>1) ? ($page*$limit)-$limit : 0; // Perbaikan di sini
        $result = mysqli_query($conn, $sql);
        $total = mysqli_num_rows($result);
        $pages = ceil($total/$limit);
        $nomor = $mulai + 1; // Perbaikan di sini
        $sql1 = $sql . " ORDER BY id_produk DESC LIMIT $mulai, $limit"; // Perbaikan di sini
        $result = mysqli_query($conn, $sql1); // Perbaikan di sini
        while($row = mysqli_fetch_array($result)){
        ?>
        <tr>
            <td><?php echo $nomor++?></td>
            <td><img src="<?php echo $row['gambar'] ?>" alt="Gambar Produk" style="max-width: 100px;"></td>
            <td><?php echo $row['produk']?></td>
            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.')?></td>
            <td>
                <a href="input page.php?op=edit&id=<?php echo $row['id_produk']?>" class="badge bg-warning text-dark"
                    style="text-decoration: none;">Edit</a>
                <a href="admin_page.php?op=delete&id=<?php echo $row['id_produk']?>" class="badge bg-danger"
                    onclick="return confirm('Apakah yakin menghapus data?')" style="text-decoration: none;">Delete</a>
            </td>
        </tr>
        <?php 
        } 
        ?>
    </tbody>
</table>
<nav arial-label="Page navigation example">
    <ul class="pagination">
        <?php
        for($i = 1; $i <= $pages; $i++) {
            ?>
        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
            <a class="page-link" href="admin_page.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
        <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php")?>
