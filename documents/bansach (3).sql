-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 28, 2023 at 09:43 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bansach`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `Username` text NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Username`, `Password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_giohang`
--

DROP TABLE IF EXISTS `chitiet_giohang`;
CREATE TABLE IF NOT EXISTS `chitiet_giohang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_giohang` int NOT NULL,
  `id_sanpham` int DEFAULT NULL,
  `soluong` int NOT NULL,
  `gia` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_giohang` (`id_giohang`,`id_sanpham`),
  KEY `id_sanpham` (`id_sanpham`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chitiet_giohang`
--

INSERT INTO `chitiet_giohang` (`id`, `id_giohang`, `id_sanpham`, `soluong`, `gia`) VALUES
(6, 1, 3, 1, 50000),
(7, 2, 3, 1, 50000),
(8, 2, 4, 2, 80000);

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

DROP TABLE IF EXISTS `giohang`;
CREATE TABLE IF NOT EXISTS `giohang` (
  `id_gh` int NOT NULL AUTO_INCREMENT,
  `tennguoidat` text NOT NULL,
  `sodienthoai` text NOT NULL,
  `diachi` text NOT NULL,
  `ghichu` text NOT NULL,
  `tongtien` text NOT NULL,
  PRIMARY KEY (`id_gh`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `giohang`
--

INSERT INTO `giohang` (`id_gh`, `tennguoidat`, `sodienthoai`, `diachi`, `ghichu`, `tongtien`) VALUES
(1, 'Nguyễn Xuân An', '0379644470', '02/Bùi Điền', '', '50000'),
(2, 'Nguyễn Xuân An', '0379644470', '02/Bùi Điền', '', '130000');

-- --------------------------------------------------------

--
-- Table structure for table `giohangtemp`
--

DROP TABLE IF EXISTS `giohangtemp`;
CREATE TABLE IF NOT EXISTS `giohangtemp` (
  `name` text NOT NULL,
  `id_sanpham` int NOT NULL,
  `soluong` int NOT NULL,
  `gia` int NOT NULL,
  KEY `giohangtemp_ibfk_1` (`id_sanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `giohangtemp`
--

INSERT INTO `giohangtemp` (`name`, `id_sanpham`, `soluong`, `gia`) VALUES
('test', 3, 3, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `khoanh`
--

DROP TABLE IF EXISTS `khoanh`;
CREATE TABLE IF NOT EXISTS `khoanh` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_sanpham` int NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_sanpham` (`id_sanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `id_sp` int NOT NULL AUTO_INCREMENT,
  `ten_sp` text NOT NULL,
  `soluong` int NOT NULL,
  `hinh_sp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `tentacgia` text NOT NULL,
  `gia` text NOT NULL,
  `chitiet` text NOT NULL,
  `theloai` int NOT NULL,
  PRIMARY KEY (`id_sp`),
  KEY `theloai` (`theloai`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id_sp`, `ten_sp`, `soluong`, `hinh_sp`, `tentacgia`, `gia`, `chitiet`, `theloai`) VALUES
(1, 'Sách giáo khoa', 0, NULL, 'Nguyễn Khoa Điềm', '20000', 'Sách cho cấp 3', 1),
(2, 'Sach', 0, 'images/333.jpg', '113', '111', 'adfn', 1),
(3, 'Sách lịch sử', 1, NULL, 'Nguyễn Văn A', '50000', 'Sách về lịch sử Việt Nam', 1),
(4, 'Tiểu thuyết', 2, 'images/444.jpg', 'Kim Thanh', '80000', 'Tiểu thuyết tình yêu', 2),
(5, 'Sách kỹ năng sống', 10, NULL, 'Nguyễn Văn B', '35000', 'Sách hướng dẫn kỹ năng sống', 1),
(6, 'Truyện tranh', 8, 'images/555.jpg', 'Trần Thanh', '60000', 'Truyện tranh hài hước', 3),
(7, 'Sách kinh tế', 4, NULL, 'Lê Thị C', '45000', 'Sách về kinh tế học', 2),
(8, 'Văn học cổ điển', 2, 'images/666.jpg', 'Phạm Văn D', '70000', 'Tác phẩm văn học cổ điển', 4),
(9, 'Sách tham khảo', 6, NULL, 'Lê Văn E', '55000', 'Sách tham khảo cho học sinh', 1),
(10, 'Sách khoa học', 3, 'images/777.jpg', 'Nguyễn Thị F', '90000', 'Sách khoa học tổng quát', 5),
(11, 'Tiểu thuyết lịch sử', 1, NULL, 'Trần Văn G', '75000', 'Tiểu thuyết lịch sử Việt Nam', 2),
(12, 'Sách ngoại ngữ', 4, 'images/888.jpg', 'Lê Văn H', '60000', 'Sách học ngoại ngữ', 5);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

DROP TABLE IF EXISTS `taikhoan`;
CREATE TABLE IF NOT EXISTS `taikhoan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tendangnhap` text NOT NULL,
  `matkhau` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`id`, `tendangnhap`, `matkhau`, `email`) VALUES
(1, 'test', '1', 'nguyenvana@gmail.com'),
(2, 'test1', '1', '123@gmail.com'),
(3, 'admin2', '1', '123@gmail.com'),
(4, 't', '1', '123@gmail.com'),
(5, 't1', '1', '123@gmail.com'),
(6, 't11', '1', '123'),
(7, 'q', 'q', '123@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `theloai`
--

DROP TABLE IF EXISTS `theloai`;
CREATE TABLE IF NOT EXISTS `theloai` (
  `id_theloai` int NOT NULL AUTO_INCREMENT,
  `ten` text NOT NULL,
  PRIMARY KEY (`id_theloai`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `theloai`
--

INSERT INTO `theloai` (`id_theloai`, `ten`) VALUES
(1, 'Sách giáo khoa'),
(2, 'Tiểu thuyết'),
(3, 'Truyện tranh'),
(4, 'Văn học cổ điển'),
(5, 'Sách khoa học');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitiet_giohang`
--
ALTER TABLE `chitiet_giohang`
  ADD CONSTRAINT `chitiet_giohang_ibfk_1` FOREIGN KEY (`id_giohang`) REFERENCES `giohang` (`id_gh`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitiet_giohang_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id_sp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `giohangtemp`
--
ALTER TABLE `giohangtemp`
  ADD CONSTRAINT `giohangtemp_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id_sp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `khoanh`
--
ALTER TABLE `khoanh`
  ADD CONSTRAINT `khoanh_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id_sp`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`theloai`) REFERENCES `theloai` (`id_theloai`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
