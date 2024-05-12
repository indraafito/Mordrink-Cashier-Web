<?php 
include("connect.php");
include("inc_header.php");

$id_produk ="";
$produk = "";
$gambar = "";
$harga = "";
$error = "";
$sukses = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    $id = "";
}

if($id !=""){
    $sql1 = "SELECT * FROM products WHERE id_produk = ?";
    $stmt = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $r1 = mysqli_fetch_array($result);
    
    if($r1){
        $id_produk = $r1['id_produk'];
        $gambar = $r1['gambar'];
        $produk = $r1['produk'];
        $harga = $r1['harga'];
    } else {
        $error = "Data tidak ditemukan";
    }
}

if(isset($_POST['simpan'])){
    $id_produk = $_POST['id_produk'];
    $produk = $_POST['produk'];
    $harga = $_POST['harga'];
    
    if(isset($_FILES['gambar'])){
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_path = "image/".$gambar_name;
        move_uploaded_file($gambar_tmp, $gambar_path);
    }

    if(empty($error)){
        if($id !=""){
            $sql1 = "UPDATE products SET gambar=?, produk=?, harga=?, tgl_isi=now() WHERE id_produk=?";
            $stmt = mysqli_prepare($conn, $sql1);
            mysqli_stmt_bind_param($stmt, "ssds", $gambar_path, $produk, $harga, $id_produk);
        } else {
            $sql1 = "INSERT INTO products (id_produk, gambar, produk, harga, tgl_isi) VALUES (?, ?, ?, ?, now())";
            $stmt = mysqli_prepare($conn, $sql1);
            mysqli_stmt_bind_param($stmt, "ssds", $id_produk, $gambar_path, $produk, $harga);
        }

        $result = mysqli_stmt_execute($stmt);

        if($result){
            $sukses = "Berhasil memasukkan data";
            $id_produk ="";
            $produk = "";
            $harga = "";
        } else {
            $error = "Gagal memasukkan data";
        }
    }
}
?>

<div class="mt-2 mb-2 row">
    <div class="col">
        <a href="admin_page.php" class="btn btn-primary btn-sm">Back</a>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger" role="alert">
    <?php echo $error ?>
</div>
<?php endif; ?>

<?php if ($sukses): ?>
<div class="alert alert-primary" role="alert">
    <?php echo $sukses ?>
</div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="id_produk" class="col-sm-2 col-form-label">ID Produk</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="id_produk" placeholder="Masukkan ID produk" name="id_produk"
                value="<?php echo $id_produk ?>" />
        </div>
    </div>
    <div class="mb-3 row">
        <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
        <div class="col-sm-10">
            <?php if ($gambar): ?>
            <div style="margin-bottom: 20px;">
                <img src="<?php echo $gambar; ?>" style="max-height: 100px; max-width: 100px;" />
            </div>
            <?php endif; ?>
            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" />
        </div>
    </div>
    <div class="mb-3 row">
        <label for="produk" class="col-sm-2 col-form-label">Nama Produk</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="produk" placeholder="Masukkan nama produk" name="produk"
                value="<?php echo $produk ?>" />
        </div>
    </div>
    <div class="mb-3 row">
        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="harga" placeholder="Masukkan harga produk" name="harga"
                value="<?php echo $harga ?>" />
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="simpan" value="Simpan data" class="btn btn-primary" />
        </div>
    </div>
</form>

<?php include("inc_footer.php")?>