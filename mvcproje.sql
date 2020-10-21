-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 22 Haz 2020, 12:32:06
-- Sunucu sürümü: 10.4.10-MariaDB
-- PHP Sürümü: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `mvcproje`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adresler`
--

DROP TABLE IF EXISTS `adresler`;
CREATE TABLE IF NOT EXISTS `adresler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uyeid` int(11) NOT NULL,
  `adres` text COLLATE utf8_turkish_ci NOT NULL,
  `varsayilan` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `adresler`
--

INSERT INTO `adresler` (`id`, `uyeid`, `adres`, `varsayilan`) VALUES
(1, 10, 'php sokak. mvc mahallesi. olcay apt. no:55 istanbul', 1),
(2, 10, 'array sokak. class mahallesi extends plaza no:850  Alsancak/ İzmir', 0),
(11, 16, 'array sokak. class mahallesi extends plaza no:850  Alsancak/ İzmir', 1),
(20, 16, 'asdasd', 0),
(17, 16, 'deneme', 0),
(16, 16, 'hhashakdaddfsd', 0),
(21, 18, 'hahahah', 1),
(22, 21, 'kütahya\r\n', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `alt_kategori`
--

DROP TABLE IF EXISTS `alt_kategori`;
CREATE TABLE IF NOT EXISTS `alt_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cocuk_kat_id` int(11) NOT NULL,
  `ana_kat_id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `alt_kategori`
--

INSERT INTO `alt_kategori` (`id`, `cocuk_kat_id`, `ana_kat_id`, `ad`) VALUES
(1, 1, 1, 'Tişört'),
(2, 1, 1, 'Pantolon'),
(3, 1, 1, 'Ceket'),
(4, 1, 1, 'Gömlek'),
(5, 2, 1, 'Atlet'),
(6, 2, 1, 'Boxer'),
(10, 3, 1, 'Klasik'),
(9, 3, 1, 'Spor'),
(11, 4, 2, 'Çamaşır'),
(12, 4, 2, 'İçlik'),
(13, 5, 2, 'Deri'),
(14, 5, 2, 'Kumaş'),
(15, 6, 2, 'Spor'),
(16, 6, 2, 'Klasik'),
(17, 6, 2, 'Deri Kordon'),
(18, 7, 3, 'Işıklı'),
(19, 7, 3, 'Spor'),
(20, 7, 3, 'İlk Adım'),
(21, 8, 3, 'Araba'),
(22, 8, 3, 'Bebek'),
(23, 8, 3, 'Tren'),
(24, 9, 3, 'Zıbın'),
(25, 9, 3, 'Tişört'),
(26, 9, 3, 'Pantolon');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ana_kategori`
--

DROP TABLE IF EXISTS `ana_kategori`;
CREATE TABLE IF NOT EXISTS `ana_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ana_kategori`
--

INSERT INTO `ana_kategori` (`id`, `ad`) VALUES
(1, 'ERKEK'),
(2, 'KADIN'),
(3, 'ÇOCUK');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

DROP TABLE IF EXISTS `ayarlar`;
CREATE TABLE IF NOT EXISTS `ayarlar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sloganUst1` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `sloganAlt1` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `sloganUst2` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `sloganAlt2` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `sloganUst3` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `sloganAlt3` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `title` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  `sayfaAciklama` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `anahtarKelime` text COLLATE utf8_turkish_ci NOT NULL,
  `uyelerGoruntuAdet` int(11) NOT NULL,
  `uyelerAramaAdet` int(11) NOT NULL,
  `uyelerYorumAdet` int(11) NOT NULL,
  `urunlerGoruntuAdet` int(11) NOT NULL,
  `urunlerAramaAdet` int(11) NOT NULL,
  `urunlerKategoriAdet` int(11) NOT NULL,
  `ArayuzurunlerGoruntuAdet` int(11) NOT NULL,
  `uyeYorumAdet` int(11) NOT NULL,
  `bultenGoruntuAdet` int(11) NOT NULL,
  `bakimzaman` datetime NOT NULL DEFAULT current_timestamp(),
  `yedekzaman` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `sloganUst1`, `sloganAlt1`, `sloganUst2`, `sloganAlt2`, `sloganUst3`, `sloganAlt3`, `title`, `sayfaAciklama`, `anahtarKelime`, `uyelerGoruntuAdet`, `uyelerAramaAdet`, `uyelerYorumAdet`, `urunlerGoruntuAdet`, `urunlerAramaAdet`, `urunlerKategoriAdet`, `ArayuzurunlerGoruntuAdet`, `uyeYorumAdet`, `bultenGoruntuAdet`, `bakimzaman`, `yedekzaman`) VALUES
(1, 'DB-Üst Slogan 1', 'DB-Alt Slogan 1', 'DB-Üst Slogan  2', 'DB-Alt Slogan 2', 'DB-Üst Slogan 3', 'DB-Alt Slogan 3', 'MVC E-TİCARET UYGULAMASI', 'MVC E-ticaret Uygulaması', 'eğitim, eticaret,anahtar,kelimeler,buraya,virgüller,koyularak,yazilacak', 11, 11, 11, 11, 11, 11, 3, 11, 66, '2020-06-22 05:06:25', '2020-06-22 05:06:25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bankabilgileri`
--

DROP TABLE IF EXISTS `bankabilgileri`;
CREATE TABLE IF NOT EXISTS `bankabilgileri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banka_ad` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `hesap_ad` varchar(70) COLLATE utf8_turkish_ci NOT NULL,
  `hesap_no` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `iban_no` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `bankabilgileri`
--

INSERT INTO `bankabilgileri` (`id`, `banka_ad`, `hesap_ad`, `hesap_no`, `iban_no`) VALUES
(1, 'İŞ BANKASI', 'İŞ BANKASI HESABI', '5645654', 'TR00 0000 0000 0000 0000 0000 14'),
(2, 'AKBANK', 'AKBANK HESABI', '654646', 'TR00 0000 0000 0000 0000 0000 19'),
(3, 'GARANTİ', 'GARANTİ BANKASI HESABI', '451454', 'TR00 0000 0000 0000 0000 0000 80');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bulten`
--

DROP TABLE IF EXISTS `bulten`;
CREATE TABLE IF NOT EXISTS `bulten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailadres` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `bulten`
--

INSERT INTO `bulten` (`id`, `mailadres`, `tarih`) VALUES
(1, 'dasdas@gmail.com', '18-05-2019'),
(2, 'ahmet@hotmail.com', '18-05-2019'),
(3, 'zimba@hotmail.com', '20-05-2019'),
(4, 'asda@gmail.com', '20-05-2019'),
(5, 'indexten@gmail.com', '20-05-2019'),
(6, '22hakan@hotmail.com', '25-05-2019'),
(7, 'dasdas@gmail.com', '18-05-2019'),
(8, 'ahmet@hotmail.com', '18-05-2019'),
(9, 'zimba@hotmail.com', '20-05-2019'),
(10, 'asda@gmail.com', '20-05-2019'),
(11, 'indexten@gmail.com', '20-05-2019'),
(12, '22hakan@hotmail.com', '25-05-2019'),
(13, 'dasdas@gmail.com', '18-05-2019'),
(14, 'ahmet@hotmail.com', '18-05-2019'),
(15, 'zimba@hotmail.com', '20-05-2019'),
(16, 'asda@gmail.com', '20-05-2019'),
(17, 'indexten@gmail.com', '20-05-2019'),
(18, '22hakan@hotmail.com', '25-05-2019'),
(19, 'dasdas@gmail.com', '18-05-2019'),
(20, 'ahmet@hotmail.com', '18-05-2019'),
(21, 'zimba@hotmail.com', '20-05-2019'),
(22, 'asda@gmail.com', '20-05-2019'),
(23, 'indexten@gmail.com', '20-05-2019'),
(24, '22hakan@hotmail.com', '25-05-2019'),
(25, 'dasdas@gmail.com', '18-05-2019'),
(26, 'ahmet@hotmail.com', '18-05-2019'),
(27, 'zimba@hotmail.com', '20-05-2019'),
(28, 'asda@gmail.com', '20-05-2019'),
(29, 'indexten@gmail.com', '20-05-2019'),
(30, '22hakan@hotmail.com', '25-05-2019'),
(31, 'dasdas@gmail.com', '18-05-2019'),
(32, 'ahmet@hotmail.com', '18-05-2019'),
(33, 'zimba@hotmail.com', '20-05-2019'),
(34, 'asda@gmail.com', '20-05-2019'),
(35, 'indexten@gmail.com', '20-05-2019'),
(36, '22hakan@hotmail.com', '25-05-2019'),
(37, 'dasdas@gmail.com', '18-05-2019'),
(38, 'ahmet@hotmail.com', '18-05-2019'),
(39, 'zimba@hotmail.com', '20-05-2019'),
(40, 'asda@gmail.com', '20-05-2019'),
(41, 'indexten@gmail.com', '20-05-2019'),
(42, '22hakan@hotmail.com', '25-05-2019'),
(43, 'dasdas@gmail.com', '18-05-2019'),
(44, 'ahmet@hotmail.com', '18-05-2019'),
(45, 'zimba@hotmail.com', '20-05-2019'),
(46, 'asda@gmail.com', '20-05-2019'),
(47, 'indexten@gmail.com', '20-05-2019'),
(48, '22hakan@hotmail.com', '25-05-2019'),
(49, 'dasdas@gmail.com', '18-05-2019'),
(50, 'ahmet@hotmail.com', '18-05-2019'),
(51, 'zimba@hotmail.com', '20-05-2019'),
(52, 'asda@gmail.com', '20-05-2019'),
(53, 'indexten@gmail.com', '20-05-2019'),
(54, '22hakan@hotmail.com', '25-05-2019'),
(55, 'dasdas@gmail.com', '18-05-2019'),
(56, 'ahmet@hotmail.com', '18-05-2019'),
(57, 'zimba@hotmail.com', '20-05-2019'),
(58, 'asda@gmail.com', '20-05-2019'),
(59, 'indexten@gmail.com', '20-05-2019'),
(60, '22hakan@hotmail.com', '25-05-2019'),
(61, 'dasdas@gmail.com', '18-05-2019'),
(62, 'ahmet@hotmail.com', '18-05-2019'),
(63, 'zimba@hotmail.com', '20-05-2019'),
(64, 'asda@gmail.com', '20-05-2019'),
(65, 'indexten@gmail.com', '20-05-2019'),
(66, '22hakan@hotmail.com', '25-05-2019'),
(67, 'dasdas@gmail.com', '18-05-2019'),
(68, 'ahmet@hotmail.com', '18-05-2019'),
(69, 'zimba@hotmail.com', '20-05-2019'),
(70, 'asda@gmail.com', '20-05-2019'),
(71, 'indexten@gmail.com', '20-05-2019'),
(72, '22hakan@hotmail.com', '25-05-2019'),
(73, 'dasdas@gmail.com', '18-05-2019'),
(74, 'ahmet@hotmail.com', '18-05-2019'),
(75, 'zimba@hotmail.com', '20-05-2019'),
(76, 'asda@gmail.com', '20-05-2019'),
(77, 'indexten@gmail.com', '20-05-2019'),
(78, '22hakan@hotmail.com', '25-05-2019'),
(79, 'dasdas@gmail.com', '18-05-2019'),
(80, 'ahmet@hotmail.com', '18-05-2019'),
(81, 'zimba@hotmail.com', '20-05-2019'),
(82, 'asda@gmail.com', '20-05-2019'),
(83, 'indexten@gmail.com', '20-05-2019'),
(84, '22hakan@hotmail.com', '25-05-2019'),
(85, 'dasdas@gmail.com', '18-05-2019'),
(86, 'ahmet@hotmail.com', '18-05-2019'),
(87, 'zimba@hotmail.com', '20-05-2019'),
(88, 'asda@gmail.com', '20-05-2019'),
(89, 'indexten@gmail.com', '20-05-2019'),
(90, '22hakan@hotmail.com', '25-05-2019'),
(91, 'dasdas@gmail.com', '18-05-2019'),
(92, 'ahmet@hotmail.com', '18-05-2019'),
(93, 'zimba@hotmail.com', '20-05-2019'),
(94, 'asda@gmail.com', '20-05-2019'),
(95, 'indexten@gmail.com', '20-05-2019'),
(96, '22hakan@hotmail.com', '25-05-2019');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cocuk_kategori`
--

DROP TABLE IF EXISTS `cocuk_kategori`;
CREATE TABLE IF NOT EXISTS `cocuk_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ana_kat_id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `cocuk_kategori`
--

INSERT INTO `cocuk_kategori` (`id`, `ana_kat_id`, `ad`) VALUES
(1, 1, 'Dış Giyim'),
(2, 1, 'İç Giyim'),
(3, 1, 'Ayakkabı'),
(4, 2, 'İç Giyim'),
(5, 2, 'Çanta'),
(6, 2, 'Saat'),
(7, 3, 'Ayakkabı'),
(8, 3, 'Oyuncak'),
(9, 3, 'Giyim');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iletisim`
--

DROP TABLE IF EXISTS `iletisim`;
CREATE TABLE IF NOT EXISTS `iletisim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `mail` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `konu` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `mesaj` text COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `iletisim`
--

INSERT INTO `iletisim` (`id`, `ad`, `mail`, `konu`, `mesaj`, `tarih`) VALUES
(1, 'Yusuf dsadasd', 'olcay@hotmail.com', 'deneme Konu', 'Mesajıızı deniyoruz fdsflködslfksdmlfjds', '20-05-2019');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

DROP TABLE IF EXISTS `siparisler`;
CREATE TABLE IF NOT EXISTS `siparisler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siparis_no` int(11) NOT NULL,
  `adresid` int(11) NOT NULL,
  `uyeid` int(11) NOT NULL,
  `urunad` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `urunadet` int(11) NOT NULL,
  `urunfiyat` int(11) NOT NULL,
  `toplamfiyat` int(11) NOT NULL,
  `kargodurum` int(11) NOT NULL DEFAULT 0,
  `odemeturu` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `siparisler`
--

INSERT INTO `siparisler` (`id`, `siparis_no`, `adresid`, `uyeid`, `urunad`, `urunadet`, `urunfiyat`, `toplamfiyat`, `kargodurum`, `odemeturu`, `durum`, `tarih`) VALUES
(32, 13290820, 1, 10, 'Tahta', 3, 169, 507, 2, 'Nakit', 0, '2020-06-18 23:57:25'),
(31, 13290820, 1, 10, 'Işıklı', 3, 140, 420, 2, 'Nakit', 0, '2020-06-18 23:57:25'),
(30, 13290820, 1, 10, 'X MODEL', 3, 147, 441, 2, 'Nakit', 0, '2020-06-18 23:57:25'),
(36, 99503320, 21, 18, 'Sarı Tişört', 1, 270, 270, 0, 'Nakit', 0, '2020-06-18 23:57:25'),
(37, 99503320, 21, 18, 'Benekli', 1, 169, 169, 0, 'Nakit', 0, '2020-06-18 23:57:25'),
(49, 94219847, 22, 21, 'Sarı Tişört', 1, 270, 270, 0, 'Nakit', 2, '2020-06-18 23:57:25'),
(50, 94219847, 22, 21, 'Kırmızı Atlet', 2, 90, 180, 0, 'Nakit', 2, '2020-06-18 23:57:25'),
(53, 32634162, 22, 21, 'Yazlık Gömlek', 1, 270, 270, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(52, 42782722, 22, 21, 'Beyaz Tişört', 3, 380, 1140, 0, 'Nakit', 0, '2020-06-18 23:57:25'),
(54, 32634162, 22, 21, 'Çamaşır-1', 1, 90, 90, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(55, 4064079, 22, 21, 'Kot Pantolon', 1, 90, 90, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(56, 4064079, 22, 21, 'Y MODEL', 2, 169, 338, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(57, 25019232, 11, 16, 'Çamaşır-1', 1, 90, 90, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(58, 25019232, 11, 16, '3-6 Yaş', 1, 169, 169, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(59, 66575999, 22, 21, 'Sarı', 1, 140, 140, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(60, 66575999, 22, 21, 'Yazlık Gömlek', 1, 270, 270, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(61, 66575999, 22, 21, 'Bez', 1, 169, 169, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(62, 12360224, 22, 21, 'Sarı', 1, 140, 140, 0, 'Nakit', 2, '2020-06-22 00:00:00'),
(63, 12360224, 22, 21, 'Yazlık Gömlek', 1, 270, 270, 0, 'Nakit', 2, '2020-06-22 00:00:00'),
(64, 12360224, 22, 21, 'Bez', 1, 169, 169, 0, 'Nakit', 2, '2020-06-22 00:00:00'),
(65, 63973760, 22, 21, 'Kırmızı Atlet', 1, 90, 90, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(66, 63973760, 22, 21, 'Tahta', 1, 169, 169, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(67, 63973760, 22, 21, 'Xml içlik', 1, 11, 11, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(68, 20340334, 22, 21, 'Tahta', 1, 169, 169, 0, 'Nakit', 0, '2020-06-22 00:00:00'),
(69, 20340334, 22, 21, 'Xml içlik', 1, 11, 11, 0, 'Nakit', 0, '2020-06-22 00:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teslimatbilgileri`
--

DROP TABLE IF EXISTS `teslimatbilgileri`;
CREATE TABLE IF NOT EXISTS `teslimatbilgileri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siparis_no` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `soyad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `mail` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `telefon` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `teslimatbilgileri`
--

INSERT INTO `teslimatbilgileri` (`id`, `siparis_no`, `ad`, `soyad`, `mail`, `telefon`) VALUES
(28, 32634162, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(29, 4064079, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(38, 20340334, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(32, 7583505, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(33, 17766199, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(34, 5691352, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(35, 66575999, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(11, 13290820, 'olcay', 'Kalyon', 'olcayrewr@gmail.com', '0555178786'),
(37, 63973760, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(13, 99503320, 'ayse', 'fatma', 'fatma@hotmail.com', '35245226'),
(14, 94219847, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(16, 42782722, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133'),
(36, 12360224, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', '5544120133');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

DROP TABLE IF EXISTS `urunler`;
CREATE TABLE IF NOT EXISTS `urunler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ana_kat_id` int(11) NOT NULL,
  `cocuk_kat_id` int(11) NOT NULL,
  `katid` int(11) NOT NULL,
  `urunad` varchar(80) CHARACTER SET utf8 NOT NULL,
  `res1` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `res2` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `res3` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0,
  `aciklama` text COLLATE utf8_turkish_ci NOT NULL,
  `kumas` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `urtYeri` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `renk` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` float NOT NULL,
  `stok` int(11) NOT NULL,
  `ozellik` text COLLATE utf8_turkish_ci NOT NULL,
  `ekstraBilgi` text COLLATE utf8_turkish_ci NOT NULL,
  `satisadet` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `ana_kat_id`, `cocuk_kat_id`, `katid`, `urunad`, `res1`, `res2`, `res3`, `durum`, `aciklama`, `kumas`, `urtYeri`, `renk`, `fiyat`, `stok`, `ozellik`, `ekstraBilgi`, `satisadet`) VALUES
(1, 1, 1, 1, 'Beyaz Tişört', '1.png', '2.png', '3.png', 2, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Beyaz', 380, 9997, 'Beyaz Tişört için özellikler', 'Beyaz Tişört için ekstra bilgi', 10),
(2, 1, 1, 1, 'Sarı Tişört', '4.png', '5.png', '6.png', 2, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Sarı', 270, 10000, 'Sarı Tişört için özellikler', 'Sarı Tişört için ekstra bilgi', 2),
(3, 1, 1, 2, 'Kumaş Pantolon', '7.png', '8.png', '9.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 9998, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 5),
(4, 1, 1, 2, 'Kot Pantolon', '10.png', '11.png', '12.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 99, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 8),
(5, 1, 1, 3, 'Keten Ceket', '13.png', '14.png', '15.png', 2, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 9),
(6, 1, 1, 3, 'Kumaş Ceket', '16.png', '17.png', '18.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 9998, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(9, 1, 3, 9, 'Mor Tişört', 'p9.jpg', 'l1.jpg', 'p9.jpg', 1, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Mor', 157, 10000, 'Mor Tişört için özellikler', 'Mor Tişört için ekstra bilgi', 0),
(10, 1, 1, 4, 'Keten Gömlek', '19.png', '20.png', '21.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Beyaz', 380, 9996, 'Beyaz Tişört için özellikler', 'Beyaz Tişört için ekstra bilgi', 0),
(11, 1, 1, 4, 'Yazlık Gömlek', '22.png', '23.png', '24.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Sarı', 270, 9996, 'Sarı Tişört için özellikler', 'Sarı Tişört için ekstra bilgi', 0),
(12, 1, 2, 5, 'Beyaz Atlet', '25.png', '26.png', '27.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(13, 1, 2, 5, 'Kırmızı Atlet', '28.png', '29.png', '30.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 9999, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(14, 1, 2, 6, 'Keten Ceket', '31.png', '32.png', '33.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(15, 1, 2, 6, 'Kumaş Ceket', '34.png', '35.png', '36.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(16, 1, 3, 10, 'Sarı', '37.png', '38.png', '39.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 9995, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(17, 1, 3, 10, 'Kahverengi', '40.png', '41.png', '42.png', 2, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(18, 1, 3, 9, 'Nike-Beyaz', '43.png', '44.png', '45.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(19, 1, 3, 9, 'Adidas-Mavi', '46.png', '47.png', '48.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(20, 2, 5, 11, 'Çamaşır-1', '49.png', '50.png', '51.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(21, 2, 5, 11, 'Çamaşır-1', '52.png', '53.png', '54.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 9993, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(22, 2, 5, 12, 'X MODEL', '55.png', '56.png', '57.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(23, 2, 5, 12, 'Y MODEL', '58.png', '59.png', '60.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 9999, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(24, 2, 6, 13, 'Timsah Derisi', '61.png', '62.png', '63.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(25, 2, 6, 13, 'Sinek Derisi', '64.png', '65.png', '66.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(26, 2, 6, 14, 'Keten', '67.png', '68.png', '69.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 189, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(27, 2, 5, 14, 'Bez', '70.png', '71.png', '72.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(28, 2, 6, 15, 'Kırmızı', '73.png', '74.png', '75.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(29, 2, 6, 15, 'Turkuaz', '76.png', '77.png', '78.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(30, 2, 6, 16, 'X MODEL', '79.png', '80.png', '81.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(31, 2, 6, 16, 'Y MODEL', '82.png', '83.png', '84.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(32, 2, 6, 17, 'Yerli Üretim', '85.png', '86.png', '87.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(33, 2, 6, 17, 'İthal', '88.png', '89.png', '90.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(34, 3, 7, 18, 'Mavi', '91.png', '92.png', '93.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(35, 3, 7, 18, 'Kırmızı', '94.png', '95.png', '96.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(36, 3, 7, 19, 'Işıklı', '97.png', '98.png', '99.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(37, 3, 7, 19, 'Normal', '100.png', '101.png', '102.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(38, 3, 7, 20, '0-3 Yaş', '103.png', '104.png', '105.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(39, 3, 7, 20, '3-6 Yaş', '106.png', '107.png', '108.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(40, 3, 8, 21, 'Metal', '109.png', '110.png', '111.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(41, 3, 8, 21, 'Tahta', '112.png', '113.png', '114.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 9999, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(42, 3, 8, 22, 'Barby', '115.png', '116.png', '117.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(43, 3, 8, 22, 'Benekli', '118.png', '119.png', '120.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(44, 3, 8, 23, 'Kara Tren', '121.png', '122.png', '123.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(45, 3, 8, 23, 'Tahta Tren', '124.png', '125.png', '126.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(46, 3, 9, 24, 'Yeni Doğan', '127.png', '128.png', '129.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(47, 3, 9, 24, 'Pamuklu', '130.png', '131.png', '132.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(48, 3, 9, 25, 'Polo', '133.png', '134.png', '135.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(49, 3, 9, 25, 'Pamuk', '136.png', '137.png', '138.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(50, 2, 2, 24, 'Kot Pantolon', '139.png', '140.png', '141.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(60, 1, 2, 6, 'Xml içlik', 'icerires1.png', 'icerires2.png', 'icerires3.png', 0, 'Xml ürün 1 açıklamasıdır', 'Keten', 'Zambiya', 'beyaz', 10.9, 249, 'gayet ferah ekstra bilgi 1', 'ekstra bilgi 1', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uye_panel`
--

DROP TABLE IF EXISTS `uye_panel`;
CREATE TABLE IF NOT EXISTS `uye_panel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `soyad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `telefon` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `uye_panel`
--

INSERT INTO `uye_panel` (`id`, `ad`, `soyad`, `mail`, `sifre`, `telefon`, `durum`) VALUES
(18, 'ayse', 'fatma', 'fatma@hotmail.com', 'q5ijvc1oY5DRFhOD8E1sDPw/mXIA', '35245226', 1),
(17, 'dilek', 'dilek', 'dilek@gmail.com', 'q5ijvc1oW5CRiVHYJjYG3kQmAwA=', '5321521212', 1),
(10, 'olcay', 'Kalyon', 'olcayrewr@gmail.com', 'q5ijvc1oU5CRUcAmNgZuecbfAA==', '0555178786', 0),
(16, 'hande', 'meşeli', 'hande.meseli@meseli.net', 'q5ijvc1oY5DRFhOD8E1sDPw/mXIA', '53429381881', 1),
(20, 'sena', 'karaaslan', 'senakrsln44@gmail.com', 'q5ijvc1oY5CRiZFZ4CY2Bv6bTKkA', '05555474142', 1),
(21, 'tuğberk', 'ulucan', 'tugberk@ulucan.net', 'q5ijvc1oW5CRiVHYJjYG3kQmAwA=', '5544120133', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetim`
--

DROP TABLE IF EXISTS `yonetim`;
CREATE TABLE IF NOT EXISTS `yonetim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `yetki` int(11) NOT NULL,
  `siparisYonetim` int(11) NOT NULL DEFAULT 0,
  `kategoriYonetim` int(11) NOT NULL DEFAULT 0,
  `uyeYonetim` int(11) NOT NULL DEFAULT 0,
  `urunYonetim` int(11) NOT NULL DEFAULT 0,
  `muhasebeYonetim` int(11) NOT NULL DEFAULT 0,
  `yoneticiYonetim` int(11) NOT NULL DEFAULT 0,
  `bultenYonetim` int(11) NOT NULL DEFAULT 0,
  `sistemayarYonetim` int(11) NOT NULL DEFAULT 0,
  `sistembakimYonetim` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yonetim`
--

INSERT INTO `yonetim` (`id`, `ad`, `sifre`, `yetki`, `siparisYonetim`, `kategoriYonetim`, `uyeYonetim`, `urunYonetim`, `muhasebeYonetim`, `yoneticiYonetim`, `bultenYonetim`, `sistemayarYonetim`, `sistembakimYonetim`) VALUES
(16, 'hande', 'q5ijvc1oY5DRFhOD8E1sDPw/mXIA', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(19, 'tuğberk', 'q5ijvc1oY5DRFhODsE1sDPxvmTIA', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(21, 'sena', 'q5ijvc1oW5CRiVHYJjYG3kQmAwA=', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(20, 'ataberk', 'q5ijvc1oY5DRFhOD0E1sDPyfmbIA', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

DROP TABLE IF EXISTS `yorumlar`;
CREATE TABLE IF NOT EXISTS `yorumlar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uyeid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `ad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `icerik` text COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `uyeid`, `urunid`, `ad`, `icerik`, `tarih`, `durum`) VALUES
(6, 16, 4, 'aaaaaa', 'İyi ürün', '17-05-2019', 1),
(11, 16, 6, 'DSF', 'Gayet güzel 3454345', '17-05-2019', 1),
(10, 16, 6, 'fdg', 'Düzelttik\n', '17-05-2019', 1),
(13, 16, 4, 'olcay', 'İsimden sonra yorum deneme', '23-05-2019', 1),
(40, 16, 6, 'fdg', 'Düzelttik\r\n', '17-05-2019', 1),
(41, 16, 4, 'olcay', 'İsimden sonra yorum deneme', '23-05-2019', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
