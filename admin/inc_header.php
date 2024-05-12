<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['user_name'])){
}else{
    header("Location: login.php");
    exit();
}
?>
<?php
include("connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="icon" href="image/logo.png" type="image/x-icon" />
    <link rel="shortcut icon" href="image/logo.png" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>

<body class="container">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <img src="image/logo.png" alt="" class="nav__logo-img" width="80" height="80" />
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="admin_page.php">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data_penjualan.php">Data Penjualan</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">Pembelian</a>
                        </li> -->
                    </ul>
                    <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <img src="../assets/img/box-arrow-right.svg" alt="Logout" class="nav-icon"
                                    style="width: 30px; height: 30px;">
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </header>
    <main>