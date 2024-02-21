-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2024 at 05:39 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `AlbumID` int(11) NOT NULL,
  `NamaAlbum` varchar(255) NOT NULL,
  `Deskripsi` text NOT NULL,
  `TanggalDibuat` date NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`AlbumID`, `NamaAlbum`, `Deskripsi`, `TanggalDibuat`, `UserId`) VALUES
(19, 'otomotif', 'otomotif motor', '2024-02-20', 4),
(25, 'sekolah', 'sekolah terfavorite di Jawa Barat', '2024-02-16', 8),
(27, 'mm', 'mmm', '2024-02-20', 4),
(28, 'kenangan smk', 'kerandoman anak anak', '2024-02-19', 4),
(29, 'manusia', 'manusia', '2024-02-20', 11);

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `fotoid` int(11) NOT NULL,
  `judulfoto` varchar(255) NOT NULL,
  `deskripsifoto` text NOT NULL,
  `tanggalunggah` date NOT NULL,
  `lokasifile` varchar(255) NOT NULL,
  `albumid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`fotoid`, `judulfoto`, `deskripsifoto`, `tanggalunggah`, `lokasifile`, `albumid`, `userid`) VALUES
(13, 'komputer', '  komputer canggih', '2024-02-19', '2008755560-komputer.jpg', 19, 4),
(60, 'sekolah', 'sekolah', '2024-02-19', 'ccc.jpg', 25, 4),
(63, 'SMKN 1 BANJAR', 'salah satu sekolah terfovorite', '2024-02-20', '1168265286-coba.JPG', 19, 8),
(65, 'zuxxy', 'btr', '2024-02-20', '1824906334-ya.jpg', 19, 4),
(66, 'chesya', 'anak gila', '2024-02-20', 'uu.jpg', 29, 11);

-- --------------------------------------------------------

--
-- Table structure for table `komentarfoto`
--

CREATE TABLE `komentarfoto` (
  `KomentarID` int(11) NOT NULL,
  `FotoID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `IsiKomentar` text NOT NULL,
  `TanggalKomentar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `komentarfoto`
--

INSERT INTO `komentarfoto` (`KomentarID`, `FotoID`, `UserID`, `IsiKomentar`, `TanggalKomentar`) VALUES
(1, 13, 4, ',,,,', '0000-00-00'),
(2, 60, 4, 'sekolah yang asri dan indah', '0000-00-00'),
(3, 13, 4, 'canggih sekali', '0000-00-00'),
(4, 63, 8, 'wow asri sekali sekolahnya', '0000-00-00'),
(5, 13, 11, 'mejanya bagus', '0000-00-00'),
(6, 60, 11, 'sekolah daerah mana ini?', '0000-00-00'),
(7, 63, 11, 'dulu bukan nya namanya bukan ini ya', '0000-00-00'),
(8, 65, 8, 'siapa ituu', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `likefoto`
--

CREATE TABLE `likefoto` (
  `LikeID` int(11) NOT NULL,
  `FotoID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TanggalLike` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likefoto`
--

INSERT INTO `likefoto` (`LikeID`, `FotoID`, `UserID`, `TanggalLike`) VALUES
(72, 13, 4, '2024-02-19'),
(73, 13, 8, '2024-02-19'),
(76, 60, 4, '2024-02-19'),
(77, 63, 8, '2024-02-20'),
(78, 63, 4, '2024-02-20'),
(80, 60, 8, '2024-02-20'),
(81, 65, 8, '2024-02-20'),
(82, 65, 4, '2024-02-20');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `NamaLengkap` varchar(255) NOT NULL,
  `Alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Password`, `Email`, `NamaLengkap`, `Alamat`) VALUES
(4, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin@gmail.com', 'admin', 'indonesia'),
(8, 'user', '24b59ae3f1c997f69705fc55edee7679', 'user@gmail.com', 'user', 'indonesia'),
(11, 'caca', 'd93591bdf7860e1e4ee2fca799911215', 'chesyasalsabil102@gmail.com', 'chesya salsabila', 'banjar');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`AlbumID`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`fotoid`),
  ADD KEY `AlbumID` (`albumid`),
  ADD KEY `UserID` (`userid`);

--
-- Indexes for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD PRIMARY KEY (`KomentarID`),
  ADD KEY `FotoID` (`FotoID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD PRIMARY KEY (`LikeID`),
  ADD KEY `FotoID` (`FotoID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `AlbumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `fotoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  MODIFY `KomentarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `likefoto`
--
ALTER TABLE `likefoto`
  MODIFY `LikeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`AlbumID`) REFERENCES `album` (`albumID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD CONSTRAINT `komentarfoto_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentarfoto_ibfk_2` FOREIGN KEY (`FotoID`) REFERENCES `foto` (`FotoID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD CONSTRAINT `likefoto_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likefoto_ibfk_2` FOREIGN KEY (`FotoID`) REFERENCES `foto` (`FotoID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
