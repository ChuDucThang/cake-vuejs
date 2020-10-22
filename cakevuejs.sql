-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2020 at 10:08 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cakeuikit`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `del_flg` tinyint(100) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `del_flg`, `created_at`, `updated_at`) VALUES
(1, 'Cây giống', 0, NULL, NULL),
(2, 'Thực phẩm', 0, NULL, NULL),
(3, 'Phân bón', 0, NULL, NULL),
(4, 'Động vật', 0, NULL, NULL),
(5, 'Thực vật', 0, NULL, NULL),
(6, 'Sản phẩm', 0, NULL, NULL),
(7, 'Quy hoạch', 0, NULL, NULL),
(8, 'Vật tư', 0, NULL, NULL),
(9, 'Thức ăn', 0, NULL, NULL),
(10, 'Chữa bệnh', 0, NULL, NULL),
(11, 'Hàng tồn kho', 0, NULL, NULL),
(12, 'Sinh học', 0, NULL, NULL),
(13, 'Tiềm năng', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `commodities`
--

CREATE TABLE `commodities` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img_path` varchar(100) DEFAULT NULL,
  `date_export` varchar(50) NOT NULL,
  `amount` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `quantity_use` int(11) DEFAULT NULL,
  `quantity_inventory` int(11) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` varchar(50) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `commodities`
--

INSERT INTO `commodities` (`id`, `category_id`, `name`, `img_path`, `date_export`, `amount`, `quantity`, `quantity_use`, `quantity_inventory`, `note`, `del_flg`, `created_at`, `updated_at`) VALUES
(1, 1, 'San pham 1', '', '15/10/2020', 42424200, 23, 32, 32, 'thhfhfth', 0, '2020-10-21 21:37:03', NULL),
(2, 1, 'San pham 2', '', '01/10/2020', 2600000, 20, 15, 5, 'test', 0, '2020-10-21 21:37:03', NULL),
(3, 2, 'San pham 3', '', '23/10/2020', 250000, 20, 10, 10, '', 0, '16/10/2020', NULL),
(4, 1, 'San pham 4', '', '20/10/2020', 120000, 24, 10, 14, '', 1, '16/10/2020', NULL),
(5, 1, 'San pham 5', '5f90ee3258644.jpeg', '31/10/2020', 2500000, 25, 15, 10, 'Test', 0, '01/10/2020', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `account_code` varchar(6) NOT NULL,
  `password` varchar(100) NOT NULL,
  `birth_date` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `avatar_path` varchar(100) DEFAULT NULL,
  `role_type` tinyint(4) NOT NULL,
  `del_flg` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `account_code`, `password`, `birth_date`, `email`, `phone`, `address`, `avatar_path`, `role_type`, `del_flg`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'Admin', 'ADMIN', 'e10adc3949ba59abbe56e057f20f883e', '2020/02/20', 'admin@gmail.com', '0123456789', 'HN', '5efb870b337f4.png', 0, 0, NULL, NULL),
(2, 'Chu Duc', 'Thang', 'CDT', 'e10adc3949ba59abbe56e057f20f883e', '22/06/2020', 'thang95.tk@gmail.com', '0123456789', 'Ha Nam', '5f1b02bedcd8d.jpeg', 0, 0, NULL, NULL),
(3, 'Nguyen Van', 'Anh', 'NVA', '$2y$10$eN9KNO0mZn8nGRd.pPPJ8OsdHrf2PlEsKLF1R1riRROKFk1AC3U9.', NULL, 'nguyenvananh@gmail.com', NULL, NULL, '', 1, 0, NULL, NULL),
(4, 'Nguyen Van', 'Tung', 'NVT', '$2y$10$db0uAn8WNKwA8/NCgLHAwegd7Nyk.NrcRIGY8BvAM2SW/4ZgfmGAa', '2020-06-25', 'nguyenvantung@gmail.com', '0923728332', NULL, '', 1, 0, NULL, NULL),
(5, 'Nguyen Van', 'Tung', 'NVT', '$2y$10$kGb3IVCMrOx163FP49qEkeyOzO5y1omO8quJH19BkuKIfIl7iPCv2', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(7, 'Nguyen Van', 'Thanh', 'NVT', '$2y$10$/BbNM1NyFG0E2iJwq4YdW.jdTlX0xDBM.5PVcPbSL7rJBg30gv0Ua', NULL, NULL, NULL, NULL, ' ', 1, 1, NULL, NULL),
(8, 'Nguyen Van', 'Thanh', 'NVT', '$2y$10$1d7RP.lfRkFDMJKNzWNbyuZm.xTWW3YQsFdVaOUHAYJrtIGUI6JJq', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(19, 'Nguyen Dinh', 'Phong', 'NDP01', '$2y$10$.D2KlgwnXSG6KZRZl3.1HOgSr90edLF2xKgVMLeLg1n7R8oK06l3C', '', '', '', '', '', 1, 1, NULL, NULL),
(20, 'Staff', 'One', 'STAFF1', '$2y$10$xmk5ZGj/UX07Izd89EDfqeAIdmG2xwTsrBDY.yDsA7qTN7PyGyHM2', '', 'staff_one@gmail.com', '', '', '5f8ff5af4e00f.jpeg', 1, 0, NULL, NULL),
(21, 'Staff', 'Two', 'STAFF2', '$2y$10$nnR0e/afEYjzjwT0XUqEyuPtVfEsdutQxRP3gxaIqHeVURmpY7dny', '', 'stafftwo@gmail.com', '', '', '5f19c3fcc128d.png', 1, 0, NULL, NULL),
(22, 'vdvd', 'vdvd', 'vdv', '$2y$10$LqsPnp/VYUYPHgMSLZw2WustwV.4FsxIC/SChzNWgbM4zVVyo4fvu', '', 'dv@gmail.com', '', '', '', 1, 1, NULL, NULL),
(23, 'test', 'anh', '000000', '$2y$10$JLKKqiJOvtFz7mxpGXwm1umOcWxU92vrA2LOHsVLEfWAM8oEqEV8G', '10/07/2020', 'anh@gmail.com', '', '', '5f03277e7a140.png', 1, 1, NULL, NULL),
(24, 'Test', 'Loading', '000000', '$2y$10$besXIpEd3xg3EApxGLeU..0F6P0YZZY0vH2NswE6yFjLTxTWOpH9G', '', 'testloading@gmail.com', '', '', '5eff74a27d550.png', 1, 1, NULL, NULL),
(25, 'test', 'loading', '00000', '$2y$10$4csieyy1bWaUMg5IBwxeCerLvNm6ZgZ4srYET.GFIPOxiWRiWxkC.', '', 'dtsjd@gmail.com', '', '', '5eff7cd6d1497.png', 1, 1, NULL, NULL),
(26, 'Staff ', 'Four', 'F0000F', '$2y$10$eL2JISNYBNySg5rTHTvrCODtMDm025R8zYPayj8zcsw./ehT/XRZS', '', 'stafffour@gmail.com', '', '', '', 1, 0, NULL, NULL),
(27, 'Nguyen Hoang', 'Linh', 'NHL001', '$2y$10$UIP3VaAYNAKHHqc9isNssuNCFSGTz2lyycXIK459mGtjERpwl3Uzq', '30/07/2020', 'nguyenhl@gmail.com', '', '', '', 1, 0, NULL, NULL),
(28, 'grgt', 'grgr', 'grggrf', '$2y$10$zpe2hV8uFUqe6ppVNt9T7.VjVXJ5jDoBxwIh9N3m52BWH9nWeuNby', '', 'dghj@gmaill.com', '', '', '5f1898f6268f6.jpeg', 1, 1, NULL, NULL),
(29, 'test', 'test', 'test12', '$2y$10$fWwdCzGgYHXvxzeUxQA6O.6fdBc9/GMnAwc1L1l3TutnbJY0fRXoa', '', 'test@gmail.com', '', '', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABVYAAAMACAYAAADPPjzCAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjw', 1, 1, NULL, NULL),
(30, 'test 2', 'test', 'test22', '$2y$10$kx51EtUBKQqYWBtrmllQJOXYYbMiKuWtHoa6Dng64Mm6Xt1a8KFde', '', 'test222@gmail.com', '', '', '5f19900caba9d.png', 1, 1, NULL, NULL),
(31, 'test3', 'test3', 'dsdsđ', '$2y$10$sr6zzrXUFVL5UARFFr3B7eCEew8F/LdNySvPR5r/2XehY0KyQtRIK', '', 'fdsd@gmail.com', '', '', '5f1992d997854.png', 1, 1, NULL, NULL),
(32, 'test', 'test', 'test22', '$2y$10$cJlYBXRLlz54Lcny91EdJ.cegdUrEvODR3L4gjjagL9MV52.XMTXe', '', 'test22@gmail.com', '', '', '', 1, 0, NULL, NULL),
(33, 'Nguyễn Văn', 'Thanh', 'NVT002', '$2y$10$5j5cQd/Esqgyw/kpjd8EtOSTfqiD.GEHuGO/mLBK3z04OejXm2scy', '13/07/2020', 'nvt0022@gmail.com', '', '', '', 1, 0, NULL, NULL),
(34, 'Nguyễn Hoàng ', 'Phong', 'NPHUIK', '$2y$10$QJbZBiuO7Xo3vM3vdNK.BOzj/OKtZM6oQ0rGEwWCjarNpaMRZBW26', '', 'nhp@gmail.com', '', '', '5f19ca306a5e2.png', 1, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commodities`
--
ALTER TABLE `commodities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `commodities`
--
ALTER TABLE `commodities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
