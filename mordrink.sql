-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2024 at 08:12 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web`
--

-- DELIMITER $$
-- --
-- -- Procedures
-- --
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_cust` (IN `nama_cust` VARCHAR(255), IN `no_meja` INT(2), IN `metode` VARCHAR(255), IN `jml_bayar` DECIMAL(10,2))   BEGIN
--     DECLARE new_id INT;
-- 	ALTER TABLE customer AUTO_INCREMENT = 1;
--     INSERT INTO customer (nama_cust, no_meja) VALUES (nama_cust, no_meja);
--     SELECT MAX(id_cust) INTO new_id FROM customer;
--     UPDATE pesanan SET id_cust = new_id WHERE id_cust = 0;
--     UPDATE bayar SET id_cust = new_id , metode = metode , jml_bayar = jml_bayar 
--     WHERE id_cust = 0;
-- END$$

-- DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user_name`, `password`, `name`) VALUES
(1, 'admin', '123', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bayar`
--

CREATE TABLE `bayar` (
  `id_cust` int(3) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `jml_bayar` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `bayar`
--
-- DELIMITER $$
-- CREATE TRIGGER `total_bayar` BEFORE INSERT ON `bayar` FOR EACH ROW BEGIN
--     DECLARE total_bayar DECIMAL(10,2);
--     SELECT SUM(ps.sub_total) INTO total_bayar
--     FROM pesanan ps
--     WHERE ps.id_cust = new.id_cust;
--     SET NEW.total_bayar = total_bayar;
-- END
-- $$
-- DELIMITER ;
-- DELIMITER $$
-- CREATE TRIGGER `up_total_bayar` BEFORE UPDATE ON `bayar` FOR EACH ROW BEGIN
--     DECLARE total_bayar DECIMAL(10,2);
--     SELECT SUM(ps.sub_total) INTO total_bayar
--     FROM pesanan ps
--     WHERE ps.id_cust = new.id_cust;
--     SET NEW.total_bayar = total_bayar;
-- END
-- $$
-- DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_cust` int(3) NOT NULL,
  `nama_cust` varchar(255) NOT NULL,
  `no_meja` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--


-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_cust` int(9) NOT NULL,
  `id_produk` varchar(3) NOT NULL,
  `jumlah` int(9) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `pesanan`
--
-- DELIMITER $$
-- CREATE TRIGGER `insert_sub_total` BEFORE INSERT ON `pesanan` FOR EACH ROW BEGIN
--  	DECLARE sub_total DECIMAL(10,2);
--     
--     -- Hitung subtotal
--     SELECT p.harga * NEW.jumlah INTO sub_total
--     FROM products p
--     WHERE p.id_produk = NEW.id_produk;
--     
--     -- Atur nilai subtotal pada baris yang dimasukkan
--     SET NEW.sub_total = sub_total;

-- END
-- $$
-- DELIMITER ;
-- DELIMITER $$
-- CREATE TRIGGER `update_sub_total` BEFORE UPDATE ON `pesanan` FOR EACH ROW BEGIN
--     DECLARE sub_total DECIMAL(10,2);
--     
--     SELECT p.harga * NEW.jumlah INTO sub_total
--     FROM products p
--     WHERE p.id_produk = NEW.id_produk;
--     
--     SET NEW.sub_total = sub_total;

-- END
-- $$
-- DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_produk` varchar(3) NOT NULL,
  `produk` varchar(50) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `tgl_isi` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_produk`, `produk`, `gambar`, `harga`, `tgl_isi`) VALUES
('A1', 'Red Velvet', 'image/Produk_1.png', 12000.00, '2024-05-01 05:21:02'),
('A10', 'Milo', 'image/Produk_10.png', 12000.00, '2024-05-02 11:02:28'),
('A2', 'Taro', 'image/Produk_2.png', 12000.00, '2024-05-01 08:12:56'),
('A3', 'Mango Yakult', 'image/Produk_3.png', 10000.00, '2024-05-01 05:21:02'),
('A4', 'Strawberry Tea', 'image/Produk_4.png', 8000.00, '2024-05-01 05:21:02'),
('A5', 'Cotton Candy', 'image/Produk_5.png', 12000.00, '2024-05-01 05:21:02'),
('A6', 'Thai Tea', 'image/Produk_6.png', 12000.00, '2024-05-01 05:21:02'),
('A7', 'Matcha', 'image/Produk_7.png', 12000.00, '2024-05-01 05:21:02'),
('A8', 'Ovaltine', 'image/Produk_8.png', 12000.00, '2024-05-01 05:21:02'),
('A9', 'Lychee Yakult', 'image/Produk_9.png', 10000.00, '2024-05-01 05:21:02'),
('B1', 'Kukus Susu', 'image/Produk_11.jpg', 20000.00, '2024-05-01 05:21:02'),
('B10', 'Maryam Bluberry', 'image/Produk_20.jpg', 15000.00, '2024-05-01 05:42:20'),
('B2', 'Kukus Coklat', 'image/Produk_13.jpg', 20000.00, '2024-05-01 05:21:02'),
('B3', 'Kukus Keju', 'image/Produk_15.jpg', 20000.00, '2024-05-01 05:21:02'),
('B4', 'Kukus Strawberry', 'image/Produk_17.jpg', 20000.00, '2024-05-01 05:21:02'),
('B5', 'Kukus Blueberry', 'image/Produk_19.jpg', 20000.00, '2024-05-01 10:30:01'),
('B6', 'Maryam Susu', 'image/Produk_12.jpg', 15000.00, '2024-05-01 05:21:02'),
('B7', 'Maryam Coklat', 'image/Produk_14.jpg', 15000.00, '2024-05-01 05:21:02'),
('B8', 'Maryam Keju', 'image/Produk_16.jpg', 15000.00, '2024-05-01 05:21:02'),
('B9', 'Maryam Strawberry', 'image/Produk_18.jpg', 15000.00, '2024-05-01 05:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id_cust` int(9) NOT NULL,
  `nama_cust` varchar(255) NOT NULL,
  `no_meja` int(3) NOT NULL,
  `produk` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jumlah` int(9) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `jml_bayar` decimal(10,2) NOT NULL,
  `tgl_pesan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat`
--
--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_cust`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_cust` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;