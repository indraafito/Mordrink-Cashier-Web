<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "mordrink";

    $conn = mysqli_connect($host, $user, $pass, $db);
    if(!$conn){
        die("Gagal terkoneksi");
    }else{
        echo "";
    }
?>