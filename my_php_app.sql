-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2021 年 7 月 27 日 10:52
-- サーバのバージョン： 5.7.35
-- PHP のバージョン: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `my_php_app`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `company` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state/province` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `customers`
--

INSERT INTO `customers` (`id`, `company`, `phone`, `fax`, `address_1`, `address_2`, `city`, `state/province`, `zip_code`, `first_name`, `last_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '丸一商事株式会社', '111-111-1111', '111-111-1112', '千代田1-1', NULL, '千代田区', '東京都', '100-8111', '一代', '丸一', '2021-07-27 10:13:00', '2021-07-27 10:13:00', NULL),
(2, '二葉工業', '222-222-2222', '222-222-2223', '中央区大阪城1-1', NULL, '大阪市', '大阪府', '540-0002', '昌次', '難波', '2021-07-27 10:13:00', '2021-07-27 10:13:00', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `stock`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'はさみ', 200, 100, '2021-07-27 09:57:19', '2021-07-27 09:57:19', NULL),
(2, 'カッターナイフ', 100, 50, '2021-07-27 09:57:51', '2021-07-27 09:57:51', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`id`, `first_name`, `last_name`, `password`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '一平', '田中', '1111', 1, '2021-07-27 10:01:08', '2021-07-27 10:01:08', NULL),
(2, '浩二', '山田', '2222', 0, '2021-07-27 10:01:08', '2021-07-27 10:01:08', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `stock_in_histories`
--

CREATE TABLE `stock_in_histories` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `stock_in_histories`
--

INSERT INTO `stock_in_histories` (`id`, `item_id`, `quantity`, `member_id`, `created_at`, `updated_at`) VALUES
(1, 1, 50, 1, '2021-07-27 12:02:27', '2021-07-27 12:02:27'),
(2, 2, 20, 2, '2021-07-27 13:02:27', '2021-07-27 13:02:27');

-- --------------------------------------------------------

--
-- テーブルの構造 `stock_out_histories`
--

CREATE TABLE `stock_out_histories` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `stock_out_histories`
--

INSERT INTO `stock_out_histories` (`id`, `item_id`, `quantity`, `member_id`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 1, 1, '2021-07-27 12:17:33', '2021-07-27 12:17:33'),
(2, 2, 30, 2, 2, '2021-07-27 13:17:33', '2021-07-27 13:17:33');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `stock_in_histories`
--
ALTER TABLE `stock_in_histories`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `stock_out_histories`
--
ALTER TABLE `stock_out_histories`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `stock_in_histories`
--
ALTER TABLE `stock_in_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `stock_out_histories`
--
ALTER TABLE `stock_out_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
