-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2021 at 03:26 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounting_apps`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_or_banks`
--

CREATE TABLE `accounts_or_banks` (
  `id` int(11) NOT NULL,
  `account_category_id` int(11) NOT NULL DEFAULT 0 COMMENT 'account_category_id',
  `name` varchar(255) NOT NULL COMMENT 'required',
  `account_id` varchar(55) DEFAULT NULL COMMENT 'optional',
  `description` text DEFAULT NULL COMMENT 'optional',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'added by admin id',
  `is_editable` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no,yes-1',
  `payment_method` varchar(10) NOT NULL DEFAULT 'B'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts_or_banks`
--

INSERT INTO `accounts_or_banks` (`id`, `account_category_id`, `name`, `account_id`, `description`, `is_active`, `created_at`, `updated_at`, `admin_id`, `is_editable`, `payment_method`) VALUES
(1, 3, 'Cash on Hands', NULL, '', 1, NULL, NULL, 0, 0, 'C'),
(2, 3, 'Bank of Baroda', '36', 'varachha branch', 1, '2021-01-27 06:31:11', '2021-01-27 07:52:58', 2, 1, 'B'),
(3, 3, 'Bank of India', '25', 'yogi chowk branch', 1, '2021-01-27 06:42:05', '2021-01-27 06:42:05', 2, 1, 'B'),
(4, 3, 'SBI Bank 90', '90', 'varachha branch 90', 1, '2021-02-02 06:47:21', '2021-02-09 08:48:04', 2, 1, 'B'),
(5, 3, 'BOB of vickky', '8597556698', 'BOB of vickky', 1, '2021-02-04 07:46:19', '2021-02-04 07:46:19', 2, 1, 'B'),
(6, 4, 'SBI Credit Card', '56', NULL, 1, '2021-02-06 10:02:07', '2021-02-08 09:56:26', 2, 1, 'B'),
(7, 5, 'Bi', '56', NULL, 1, '2021-02-06 11:39:51', '2021-02-06 11:39:51', 2, 1, 'B'),
(8, 5, 'Vi bank 09', '89', NULL, 1, '2021-02-09 08:18:29', '2021-02-09 08:18:29', 2, 1, 'B'),
(9, 3, 'VB io', NULL, NULL, 1, '2021-02-09 08:48:24', '2021-02-09 08:48:24', 2, 1, 'B'),
(10, 3, 'NNNN one', NULL, NULL, 1, '2021-03-30 12:14:58', '2021-03-30 12:14:58', 2, 1, 'B'),
(11, 3, 'MMMM one', NULL, NULL, 1, '2021-03-30 12:15:07', '2021-03-30 12:15:07', 2, 1, 'B');

-- --------------------------------------------------------

--
-- Table structure for table `account_category`
--

CREATE TABLE `account_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `level` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-main category, 1- subcategory',
  `path_to` int(11) NOT NULL DEFAULT 0,
  `is_editable` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no,yes-1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_category`
--

INSERT INTO `account_category` (`id`, `name`, `details`, `is_active`, `created_at`, `updated_at`, `level`, `path_to`, `is_editable`) VALUES
(1, 'Assets', 'Assets', 1, '2021-01-25 08:10:44', '2021-01-25 08:10:44', 0, 0, 0),
(2, 'Liabilities & Credit Cards', 'Liabilities & Credit Cards', 1, '2021-01-25 08:10:44', '2021-01-25 08:10:44', 0, 0, 0),
(3, 'Cash and Bank', 'Cash and Bank', 1, '2021-01-24 18:30:00', '2021-01-25 08:11:45', 1, 1, 0),
(4, 'Credit Card', 'Credit Card', 1, '2021-01-24 18:30:00', '2021-01-25 08:11:45', 1, 2, 0),
(5, 'Money in Transit', 'Money in Transit', 1, '2021-01-24 18:30:00', '2021-01-25 08:11:45', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'required',
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1-active,0-deactive, 2- deleted',
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'S' COMMENT 'A-SuperAdmin/MainAdmin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fullname`, `email`, `mobile`, `password`, `is_active`, `role`, `created_at`, `updated_at`, `otp`) VALUES
(2, 'Developer', 'abc@gmail.com', '9878897889', '$2y$10$WCU9ZtfjM.u3wz.leOloTum2D665Pg9YxvwDJZ9nu0lM9c1edNfKS', 1, 'S', '2021-01-27 06:23:01', '2021-02-09 11:59:04', '394526'),
(3, 'Vickky Kumar', 'vickky@mail.co', '08990899089', '$2y$10$ioPA2PzKlR6l9ArYxQivEOjyWraGeJDWHOiWpBte89FSXDim1ezOi', 1, 'S', '2021-02-09 11:01:15', '2021-02-09 11:03:49', NULL),
(5, 'vishall', 'vishal.technomads@gmail.com', NULL, '$2y$10$x28.x4lEAqY8S7PU5YGBJe3Znsb22Xz9rXMVoxVbX7gk8L2bQ/Qfi', 1, 'S', '2021-02-09 12:11:05', '2021-02-09 12:20:20', '628351');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL DEFAULT 0 COMMENT 'vendor_id',
  `bill_notes` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `bill_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `bill_date` datetime DEFAULT NULL COMMENT 'required',
  `payment_due_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'added by admin id',
  `total_qty` int(11) NOT NULL DEFAULT 0,
  `subtotal` decimal(25,2) NOT NULL DEFAULT 0.00,
  `tax_total` decimal(25,2) NOT NULL DEFAULT 0.00,
  `total` decimal(25,2) NOT NULL DEFAULT 0.00,
  `bill_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'U' COMMENT 'bill_status',
  `amount_due` decimal(17,2) NOT NULL DEFAULT 0.00 COMMENT 'amount_due',
  `total_paid` decimal(25,2) NOT NULL DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `vendor_id`, `bill_notes`, `bill_number`, `bill_date`, `payment_due_date`, `is_active`, `created_at`, `updated_at`, `admin_id`, `total_qty`, `subtotal`, `tax_total`, `total`, `bill_status`, `amount_due`, `total_paid`) VALUES
(1, 1, 'gh gf', '879', '2021-02-05 00:00:00', '2021-02-01 00:00:00', 1, '2021-02-05 12:01:28', '2021-03-30 08:50:22', 2, 2, '6491.23', '0.00', '6491.23', 'P', '0.00', '6491.23'),
(2, 2, 'gfh', 'ii99', '2021-02-05 00:00:00', '2021-02-20 00:00:00', 1, '2021-02-05 12:26:25', '2021-03-30 08:49:03', 2, 1, '4056.23', '0.00', '4056.23', 'P', '0.00', '4056.23');

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL DEFAULT 0 COMMENT 'bill_id',
  `products_or_services_id` int(11) NOT NULL DEFAULT 0 COMMENT 'expense category only',
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `qty` int(11) NOT NULL DEFAULT 1 COMMENT 'required',
  `price` decimal(17,2) NOT NULL DEFAULT 0.00 COMMENT 'required',
  `amount` decimal(25,2) NOT NULL DEFAULT 0.00 COMMENT 'required [qty x price]',
  `totaltax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_id` int(11) NOT NULL DEFAULT 1 COMMENT 'tax_id',
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`id`, `bill_id`, `products_or_services_id`, `description`, `qty`, `price`, `amount`, `totaltax`, `is_active`, `created_at`, `updated_at`, `tax_id`, `tax_rate`) VALUES
(3, 2, 7, 'electricity bill of office', 1, '4056.23', '4056.23', '0.00', 1, '2021-02-05 12:26:25', '2021-02-05 12:26:25', 1, '0.00'),
(5, 1, 4, 'my rent is ok my rent is ok my rent is ok my rent is ok', 1, '2435.00', '2435.00', '0.00', 1, '2021-02-08 13:00:31', '2021-02-08 13:00:31', 1, '0.00'),
(6, 1, 7, 'electricity bill of office', 1, '4056.23', '4056.23', '0.00', 1, '2021-02-08 13:00:31', '2021-02-08 13:00:31', 1, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `company_configurations`
--

CREATE TABLE `company_configurations` (
  `id` smallint(4) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Company Name',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'India',
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_logo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_configurations`
--

INSERT INTO `company_configurations` (`id`, `company_name`, `email`, `mobile`, `created_at`, `updated_at`, `country`, `state`, `city`, `pincode`, `address`, `landmark`, `invoice_logo`) VALUES
(1, 'Kipu Accounting', 'justemail@mail.com', '7889788978', '2021-01-27 09:04:26', '2021-02-04 12:02:54', 'India', 'Gujarat', 'Surat', '394569', 'Udhna Chaar Raasta near OM complex 123', 'Udhna Chaar Raasta', '601be26e3b42c1612440174.png');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'required',
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `is_active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'added by admin id',
  `country` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'India',
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fullname`, `firstname`, `lastname`, `email`, `mobile`, `is_active`, `created_at`, `updated_at`, `admin_id`, `country`, `state`, `city`, `pincode`, `address`, `landmark`) VALUES
(4, 'vishal kumar', 'vishal', 'kumar', 'mailme@at.com', '7856784589', 1, '2021-01-21 09:42:44', '2021-01-28 13:01:08', 1, 'India', 'Gujarat', 'Surat', '394107', 'SHOP NO. 4039, 4TH FLOOR, NR.ROYAL SQUARE,VIP CIRCLE, SILVER BUSINESS POIN', 'near cinema house'),
(3, 'TEchnomads Infotech', 'TEchnomads', 'Infotech', 'fgdfgdfg@gmail.ty', '07889788978', 1, '2021-01-21 09:29:08', '2021-01-22 11:26:25', 1, 'India', 'gujarat', 'surat', '898978', '8989, near vip circle hub', NULL),
(5, 'Naresh Kota', 'Naresh', 'Kota', 'nareshkota@mail.mi', '7858785878', 1, '2021-01-22 11:28:42', '2021-01-22 11:28:42', 1, 'India', 'gujarat', 'surat', '394540', '90, surat', 'surat mahal'),
(6, 'Viral Mehta', 'Viral', 'mehta', 'viralmehta123@gmail.com', '9878854502', 1, '2021-01-28 10:31:48', '2021-01-28 10:31:48', 2, 'India', 'gujarat', 'surat', '394526', 'surat nagar', 'near hostpital'),
(7, 'Gautam Bajrangi', 'Gautam', 'Bajrangi', 'gautamtest@gmail.com', '09797879878', 1, '2021-01-28 10:37:14', '2021-01-28 10:37:14', 2, 'India', NULL, NULL, NULL, NULL, NULL),
(8, 'fgjfdjfhg jfhjfghj', 'fdhdgfhf', 'fdgjhdfj', NULL, NULL, 1, '2021-01-28 10:40:30', '2021-01-28 10:40:30', 2, 'India', NULL, NULL, NULL, NULL, NULL),
(11, 'ET', 'E', 'T', NULL, NULL, 1, '2021-02-06 09:17:27', '2021-02-06 09:17:27', 2, 'India', NULL, NULL, NULL, NULL, NULL),
(10, 'Govind kumar', 'Govind', 'kumar', 'govindkumar23@mail.com', '09966888659', 1, '2021-02-03 10:14:18', '2021-02-03 10:14:18', 2, 'India', 'Gujarat', 'Surat', '395652', '59, hariom nagar near vraj residency', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `invoice_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `invoice_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `invoice_date` datetime DEFAULT NULL COMMENT 'required',
  `payment_due_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'added by admin id',
  `invoice_comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'remarks',
  `footer_comment` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_qty` int(11) NOT NULL DEFAULT 0,
  `subtotal` decimal(25,2) NOT NULL DEFAULT 0.00,
  `tax_total` decimal(25,2) NOT NULL DEFAULT 0.00,
  `total` decimal(25,2) NOT NULL DEFAULT 0.00,
  `invoice_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'U' COMMENT 'invoice_status',
  `amount_due` decimal(17,2) NOT NULL DEFAULT 0.00 COMMENT 'amount_due',
  `total_paid` decimal(25,2) NOT NULL DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `customer_id`, `invoice_title`, `invoice_description`, `invoice_number`, `invoice_date`, `payment_due_date`, `is_active`, `created_at`, `updated_at`, `admin_id`, `invoice_comment`, `footer_comment`, `total_qty`, `subtotal`, `tax_total`, `total`, `invoice_status`, `amount_due`, `total_paid`) VALUES
(1, 4, 'Invoice Title', 'invoice of 56', '123', '2021-02-10 00:00:00', '2021-03-13 00:00:00', 1, '2021-02-05 07:59:26', '2021-03-30 08:45:45', 2, 'pay theses amount ASAP', 'footer text', 28, '72343.00', '5529.60', '77872.60', 'P', '0.00', '77872.60'),
(4, 5, 'Invoice', '46', '456', '2021-02-05 00:00:00', '2021-02-20 00:00:00', 1, '2021-02-05 13:58:52', '2021-02-05 14:05:57', 2, NULL, NULL, 15, '61514.85', '0.00', '61514.85', 'P', '0.00', '28949.85'),
(5, 4, 'Invoice', '77', 'f1111', '2021-02-05 00:00:00', '2021-02-20 00:00:00', 1, '2021-02-05 14:25:59', '2021-02-05 14:27:03', 2, NULL, NULL, 1, '20.00', '3.60', '23.60', 'P', '0.00', '118.00'),
(3, 4, 'Invoice Title', 'invoice of 56', 'fdsdvsfv', '2021-02-10 00:00:00', '2020-12-28 00:00:00', 1, '2021-02-05 13:55:36', '2021-03-30 08:40:17', 2, 'pay theses amount ASAP', 'footer text', 30, '83589.00', '5529.60', '89118.60', 'P', '0.00', '89118.60'),
(6, 6, 'Invoice 456', 'Invoice 456789', '123e', '2021-02-06 00:00:00', '2021-03-05 00:00:00', 1, '2021-02-06 05:19:06', '2021-02-06 09:16:31', 2, '234', NULL, 74, '202800.00', '26784.00', '229584.00', 'P', '0.00', '229584.00'),
(9, 11, 'Invoice', NULL, 'et#1', '2021-02-06 00:00:00', '2021-02-21 00:00:00', 1, '2021-02-06 09:17:49', '2021-02-06 09:23:23', 2, NULL, NULL, 45, '253035.00', '45546.30', '298581.30', 'P', '0.00', '305216.44'),
(8, 4, 'Invoice', 'fdghf hf', '7uuuu', '2021-02-06 00:00:00', '2021-02-21 00:00:00', 1, '2021-02-06 09:10:20', '2021-02-06 09:15:15', 2, NULL, NULL, 1, '2400.00', '0.00', '2400.00', 'P', '0.00', '2400.00'),
(10, 5, 'Invoice', '56565', '102', '2021-03-30 00:00:00', '2021-04-14 00:00:00', 1, '2021-03-30 08:39:53', '2021-03-30 08:40:08', 2, 'hello 13', NULL, 1, '2560.00', '460.80', '3020.80', 'P', '0.00', '3020.80'),
(11, 3, 'Invoice', NULL, '55', '2021-03-30 00:00:00', '2021-04-14 00:00:00', 1, '2021-03-30 09:15:29', '2021-03-30 09:15:29', 2, NULL, NULL, 1, '999.99', '0.00', '999.99', 'U', '999.99', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` int(11) NOT NULL DEFAULT 0 COMMENT 'invoice_id',
  `products_or_services_id` int(11) NOT NULL DEFAULT 0 COMMENT 'sales category only',
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `qty` int(11) NOT NULL DEFAULT 1 COMMENT 'required',
  `price` decimal(17,2) NOT NULL DEFAULT 0.00 COMMENT 'required',
  `amount` decimal(25,2) NOT NULL DEFAULT 0.00 COMMENT 'required [qty x price]',
  `totaltax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_id` int(11) NOT NULL DEFAULT 1 COMMENT 'tax_id',
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `products_or_services_id`, `description`, `qty`, `price`, `amount`, `totaltax`, `is_active`, `created_at`, `updated_at`, `tax_id`, `tax_rate`) VALUES
(1, 1, 3, 'hifi admin panel', 12, '2560.00', '30720.00', '5529.60', 1, '2021-02-05 07:59:26', '2021-02-05 07:59:26', 2, '18.00'),
(2, 1, 8, 'per day 3-4 grapichs social media post', 15, '2400.00', '36000.00', '0.00', 1, '2021-02-05 07:59:26', '2021-02-05 07:59:26', 1, '0.00'),
(3, 1, 9, NULL, 1, '5623.00', '5623.00', '0.00', 1, '2021-02-05 07:59:26', '2021-02-05 07:59:26', 1, '0.00'),
(20, 5, 3, 'hifi admin panel', 1, '20.00', '20.00', '3.60', 1, '2021-02-05 14:27:03', '2021-02-05 14:27:03', 2, '18.00'),
(26, 8, 8, 'per day 3-4 grapichs social media post', 1, '2400.00', '2400.00', '0.00', 1, '2021-02-06 09:10:20', '2021-02-06 09:10:20', 1, '0.00'),
(16, 4, 2, 'total 5 Changes', 15, '4100.99', '61514.85', '0.00', 1, '2021-02-05 14:05:57', '2021-02-05 14:05:57', 1, '0.00'),
(31, 6, 8, 'per day 3-4 grapichs social media post', 62, '2400.00', '148800.00', '26784.00', 1, '2021-02-06 09:16:18', '2021-02-06 09:16:18', 2, '18.00'),
(30, 6, 6, 'Fancy Client website', 12, '4500.00', '54000.00', '0.00', 1, '2021-02-06 09:16:18', '2021-02-06 09:16:18', 1, '0.00'),
(37, 3, 8, 'per day 3-4 grapichs social media post', 15, '2400.00', '36000.00', '0.00', 1, '2021-02-08 12:45:59', '2021-02-08 12:45:59', 1, '0.00'),
(36, 9, 9, NULL, 45, '5623.00', '253035.00', '45546.30', 1, '2021-02-06 09:23:23', '2021-02-06 09:23:23', 2, '18.00'),
(38, 3, 3, 'hifi admin panel', 12, '2560.00', '30720.00', '5529.60', 1, '2021-02-08 12:45:59', '2021-02-08 12:45:59', 2, '18.00'),
(39, 3, 9, NULL, 3, '5623.00', '16869.00', '0.00', 1, '2021-02-08 12:45:59', '2021-02-08 12:45:59', 1, '0.00'),
(40, 10, 3, 'hifi admin panel', 1, '2560.00', '2560.00', '460.80', 1, '2021-03-30 08:39:53', '2021-03-30 08:39:53', 2, '18.00'),
(41, 11, 2, 'total 5 Changes', 1, '999.99', '999.99', '0.00', 1, '2021-03-30 09:15:29', '2021-03-30 09:15:29', 1, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `logs_deleted`
--

CREATE TABLE `logs_deleted` (
  `id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs_deleted`
--

INSERT INTO `logs_deleted` (`id`, `created_at`, `data`, `updated_at`) VALUES
(13, '2021-03-30 17:59:34', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"20.36\",\"sub_category_id\":\"29\",\"payment_method\":\"CC\",\"accounts_or_banks_id\":\"4\",\"notes\":null,\"description\":\"Write a Description1\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 17:59:34\",\"updated_at\":\"2021-03-30 17:59:34\",\"accounts_or_banks_id_transfer_fromto\":\"6\"}', '2021-03-30 17:59:34'),
(14, '2021-03-30 17:59:34', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"20.36\",\"sub_category_id\":\"29\",\"payment_method\":\"CC\",\"accounts_or_banks_id\":29,\"notes\":null,\"description\":\"Write a Description1\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 17:59:34\",\"updated_at\":\"2021-03-30 17:59:34\",\"accounts_or_banks_id_transfer_fromto\":\"4\"}', '2021-03-30 17:59:34'),
(15, '2021-03-30 18:01:09', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"26\",\"sub_category_id\":\"29\",\"payment_method\":\"B\",\"accounts_or_banks_id\":\"1\",\"notes\":null,\"description\":\"Write a Description1\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:01:09\",\"updated_at\":\"2021-03-30 18:01:09\",\"accounts_or_banks_id_transfer_fromto\":\"6\"}', '2021-03-30 18:01:09'),
(16, '2021-03-30 18:01:09', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"26\",\"sub_category_id\":\"29\",\"payment_method\":\"B\",\"accounts_or_banks_id\":29,\"notes\":null,\"description\":\"Write a Description1\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:01:09\",\"updated_at\":\"2021-03-30 18:01:09\",\"accounts_or_banks_id_transfer_fromto\":\"1\"}', '2021-03-30 18:01:09'),
(17, '2021-03-30 18:14:32', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"23\",\"sub_category_id\":\"30\",\"payment_method\":\"B\",\"accounts_or_banks_id\":\"1\",\"notes\":null,\"description\":\"ggsgfg\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:14:32\",\"updated_at\":\"2021-03-30 18:14:32\",\"accounts_or_banks_id_transfer_fromto\":\"4\"}', '2021-03-30 18:14:32'),
(18, '2021-03-30 18:14:32', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"23\",\"sub_category_id\":\"30\",\"payment_method\":\"B\",\"accounts_or_banks_id\":\"4\",\"notes\":null,\"description\":\"ggsgfg\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:14:32\",\"updated_at\":\"2021-03-30 18:14:32\",\"accounts_or_banks_id_transfer_fromto\":\"1\"}', '2021-03-30 18:14:32'),
(19, '2021-03-30 18:15:36', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-31\",\"amount\":\"236\",\"sub_category_id\":\"29\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"9\",\"notes\":null,\"description\":\"klklklkl\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:15:36\",\"updated_at\":\"2021-03-30 18:15:36\",\"accounts_or_banks_id_transfer_fromto\":\"4\"}', '2021-03-30 18:15:36'),
(20, '2021-03-30 18:15:36', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-31\",\"amount\":\"236\",\"sub_category_id\":30,\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"4\",\"notes\":null,\"description\":\"klklklkl\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:15:36\",\"updated_at\":\"2021-03-30 18:15:36\",\"accounts_or_banks_id_transfer_fromto\":\"9\"}', '2021-03-30 18:15:36'),
(21, '2021-03-30 18:23:09', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-04-01\",\"amount\":\"0.00\",\"sub_category_id\":\"30\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"1\",\"notes\":null,\"description\":\"s11111\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:23:09\",\"updated_at\":\"2021-03-30 18:23:09\",\"accounts_or_banks_id_transfer_fromto\":\"3\"}', '2021-03-30 18:23:09'),
(22, '2021-03-30 18:23:09', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-04-01\",\"amount\":\"0.00\",\"sub_category_id\":29,\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"3\",\"notes\":null,\"description\":\"s11111\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:23:09\",\"updated_at\":\"2021-03-30 18:23:09\",\"accounts_or_banks_id_transfer_fromto\":\"1\"}', '2021-03-30 18:23:09'),
(23, '2021-03-30 18:25:21', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-04-06\",\"amount\":\"1234.23\",\"sub_category_id\":\"29\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"2\",\"notes\":null,\"description\":\"kkkkkkkkkk11\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:25:21\",\"updated_at\":\"2021-03-30 18:25:21\",\"accounts_or_banks_id_transfer_fromto\":\"5\"}', '2021-03-30 18:25:21'),
(24, '2021-03-30 18:25:21', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-04-06\",\"amount\":\"1234.23\",\"sub_category_id\":30,\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"5\",\"notes\":null,\"description\":\"kkkkkkkkkk11\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:25:21\",\"updated_at\":\"2021-03-30 18:25:21\",\"accounts_or_banks_id_transfer_fromto\":\"2\"}', '2021-03-30 18:25:21'),
(25, '2021-03-30 18:33:01', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-04-11\",\"amount\":\"5600\",\"sub_category_id\":\"29\",\"payment_method\":\"C\",\"accounts_or_banks_id\":\"2\",\"notes\":null,\"description\":\"tytytyy\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:33:01\",\"updated_at\":\"2021-03-30 18:33:01\",\"accounts_or_banks_id_transfer_fromto\":\"7\"}', '2021-03-30 18:33:01'),
(26, '2021-03-30 18:33:01', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-04-11\",\"amount\":\"5600\",\"sub_category_id\":30,\"payment_method\":\"C\",\"accounts_or_banks_id\":\"7\",\"notes\":null,\"description\":\"tytytyy\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:33:01\",\"updated_at\":\"2021-03-30 18:33:01\",\"accounts_or_banks_id_transfer_fromto\":\"2\"}', '2021-03-30 18:33:01'),
(27, '2021-03-30 18:33:58', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"4997\",\"sub_category_id\":\"30\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"2\",\"notes\":\"469146\",\"description\":\"jgghjh54\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:33:58\",\"updated_at\":\"2021-03-30 18:33:58\",\"accounts_or_banks_id_transfer_fromto\":\"1\"}', '2021-03-30 18:33:58'),
(28, '2021-03-30 18:33:58', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"4997\",\"sub_category_id\":29,\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"1\",\"notes\":\"469146\",\"description\":\"jgghjh54\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:33:58\",\"updated_at\":\"2021-03-30 18:33:58\",\"accounts_or_banks_id_transfer_fromto\":\"2\"}', '2021-03-30 18:33:58'),
(29, '2021-03-30 18:35:09', '[{\"id\":1,\"transaction_date\":\"2021-03-30 00:00:00\",\"amount\":\"26.00\",\"payment_method\":\"B\",\"accounts_or_banks_id\":1,\"accounts_or_banks_id_transfer_fromto\":6,\"is_active\":1,\"created_at\":\"2021-03-30T12:31:09.000000Z\",\"updated_at\":\"2021-03-30T12:33:48.000000Z\",\"is_editable\":1,\"notes\":null,\"description\":\"Write a Description1\",\"is_reviewed\":1,\"transaction_type\":\"Cr\",\"invoice_id\":0,\"bills_id\":0,\"sub_category_id\":29,\"admin_id\":2}]', '2021-03-30 18:35:09'),
(30, '2021-03-30 18:35:11', '[{\"id\":3,\"transaction_date\":\"2021-03-30 00:00:00\",\"amount\":\"23.00\",\"payment_method\":\"B\",\"accounts_or_banks_id\":1,\"accounts_or_banks_id_transfer_fromto\":4,\"is_active\":1,\"created_at\":\"2021-03-30T12:44:32.000000Z\",\"updated_at\":\"2021-03-30T12:44:32.000000Z\",\"is_editable\":1,\"notes\":null,\"description\":\"ggsgfg\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"invoice_id\":0,\"bills_id\":0,\"sub_category_id\":30,\"admin_id\":2}]', '2021-03-30 18:35:11'),
(31, '2021-03-30 18:35:28', '[{\"id\":4,\"transaction_date\":\"2021-03-30 00:00:00\",\"amount\":\"23.00\",\"payment_method\":\"B\",\"accounts_or_banks_id\":4,\"accounts_or_banks_id_transfer_fromto\":1,\"is_active\":1,\"created_at\":\"2021-03-30T12:44:32.000000Z\",\"updated_at\":\"2021-03-30T12:44:32.000000Z\",\"is_editable\":1,\"notes\":null,\"description\":\"ggsgfg\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"invoice_id\":0,\"bills_id\":0,\"sub_category_id\":30,\"admin_id\":2}]', '2021-03-30 18:35:28'),
(32, '2021-03-30 18:36:06', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"100\",\"sub_category_id\":\"30\",\"payment_method\":\"C\",\"accounts_or_banks_id\":\"2\",\"notes\":null,\"description\":\"ghkhkjhkj\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:36:06\",\"updated_at\":\"2021-03-30 18:36:06\",\"accounts_or_banks_id_transfer_fromto\":\"5\"}', '2021-03-30 18:36:06'),
(33, '2021-03-30 18:36:06', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"100\",\"sub_category_id\":29,\"payment_method\":\"C\",\"accounts_or_banks_id\":\"5\",\"notes\":null,\"description\":\"ghkhkjhkj\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:36:06\",\"updated_at\":\"2021-03-30 18:36:06\",\"accounts_or_banks_id_transfer_fromto\":\"2\"}', '2021-03-30 18:36:06'),
(34, '2021-03-30 18:38:42', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"100\",\"sub_category_id\":\"30\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"5\",\"notes\":null,\"description\":\"fgdfgdfg\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:38:42\",\"updated_at\":\"2021-03-30 18:38:42\",\"accounts_or_banks_id_transfer_fromto\":\"1\"}', '2021-03-30 18:38:42'),
(35, '2021-03-30 18:38:42', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"100\",\"sub_category_id\":29,\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"1\",\"notes\":null,\"description\":\"fgdfgdfg\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:38:42\",\"updated_at\":\"2021-03-30 18:38:42\",\"accounts_or_banks_id_transfer_fromto\":\"5\"}', '2021-03-30 18:38:42'),
(36, '2021-03-30 18:39:17', '[{\"id\":4,\"transaction_date\":\"2021-03-30 00:00:00\",\"amount\":\"100.00\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":1,\"accounts_or_banks_id_transfer_fromto\":5,\"is_active\":1,\"created_at\":\"2021-03-30T13:08:42.000000Z\",\"updated_at\":\"2021-03-30T13:08:42.000000Z\",\"is_editable\":1,\"notes\":null,\"description\":\"fgdfgdfg\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"invoice_id\":0,\"bills_id\":0,\"sub_category_id\":29,\"admin_id\":2}]', '2021-03-30 18:39:17'),
(37, '2021-03-30 18:39:19', '[{\"id\":3,\"transaction_date\":\"2021-03-30 00:00:00\",\"amount\":\"100.00\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":5,\"accounts_or_banks_id_transfer_fromto\":1,\"is_active\":1,\"created_at\":\"2021-03-30T13:08:42.000000Z\",\"updated_at\":\"2021-03-30T13:08:42.000000Z\",\"is_editable\":1,\"notes\":null,\"description\":\"fgdfgdfg\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"invoice_id\":0,\"bills_id\":0,\"sub_category_id\":30,\"admin_id\":2}]', '2021-03-30 18:39:19'),
(38, '2021-03-30 18:39:46', '[{\"id\":1,\"transaction_date\":\"2021-03-30 00:00:00\",\"amount\":\"100.00\",\"payment_method\":\"C\",\"accounts_or_banks_id\":2,\"accounts_or_banks_id_transfer_fromto\":5,\"is_active\":1,\"created_at\":\"2021-03-30T13:06:06.000000Z\",\"updated_at\":\"2021-03-30T13:06:06.000000Z\",\"is_editable\":1,\"notes\":null,\"description\":\"ghkhkjhkj\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"invoice_id\":0,\"bills_id\":0,\"sub_category_id\":30,\"admin_id\":2}]', '2021-03-30 18:39:46'),
(39, '2021-03-30 18:39:49', '[{\"id\":2,\"transaction_date\":\"2021-03-30 00:00:00\",\"amount\":\"100.00\",\"payment_method\":\"C\",\"accounts_or_banks_id\":5,\"accounts_or_banks_id_transfer_fromto\":2,\"is_active\":1,\"created_at\":\"2021-03-30T13:06:06.000000Z\",\"updated_at\":\"2021-03-30T13:06:06.000000Z\",\"is_editable\":1,\"notes\":null,\"description\":\"ghkhkjhkj\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"invoice_id\":0,\"bills_id\":0,\"sub_category_id\":29,\"admin_id\":2}]', '2021-03-30 18:39:49'),
(40, '2021-03-30 18:40:09', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"100\",\"sub_category_id\":\"30\",\"payment_method\":\"C\",\"accounts_or_banks_id\":\"2\",\"notes\":null,\"description\":\"kgkgh\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:40:09\",\"updated_at\":\"2021-03-30 18:40:09\",\"accounts_or_banks_id_transfer_fromto\":\"1\"}', '2021-03-30 18:40:09'),
(41, '2021-03-30 18:40:09', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"100\",\"sub_category_id\":29,\"payment_method\":\"C\",\"accounts_or_banks_id\":\"1\",\"notes\":null,\"description\":\"kgkgh\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:40:09\",\"updated_at\":\"2021-03-30 18:40:09\",\"accounts_or_banks_id_transfer_fromto\":\"2\"}', '2021-03-30 18:40:09'),
(42, '2021-03-30 18:41:15', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"1000\",\"sub_category_id\":\"29\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"2\",\"notes\":null,\"description\":\"Write a Description1uiuiu\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:41:15\",\"updated_at\":\"2021-03-30 18:41:15\",\"accounts_or_banks_id_transfer_fromto\":\"1\"}', '2021-03-30 18:41:15'),
(43, '2021-03-30 18:41:15', '{\"invoice_id\":0,\"bills_id\":0,\"transaction_date\":\"2021-03-30\",\"amount\":\"1000\",\"sub_category_id\":30,\"payment_method\":\"CQ\",\"accounts_or_banks_id\":\"1\",\"notes\":null,\"description\":\"Write a Description1uiuiu\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"admin_id\":2,\"is_active\":\"1\",\"is_editable\":\"1\",\"created_at\":\"2021-03-30 18:41:15\",\"updated_at\":\"2021-03-30 18:41:15\",\"accounts_or_banks_id_transfer_fromto\":\"2\"}', '2021-03-30 18:41:15'),
(44, '2021-03-30 18:41:48', '[{\"id\":8,\"transaction_date\":\"2021-03-30 00:00:00\",\"amount\":\"1000.00\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":1,\"accounts_or_banks_id_transfer_fromto\":2,\"is_active\":1,\"created_at\":\"2021-03-30T13:11:15.000000Z\",\"updated_at\":\"2021-03-30T13:11:15.000000Z\",\"is_editable\":1,\"notes\":null,\"description\":\"Write a Description1uiuiu\",\"is_reviewed\":0,\"transaction_type\":\"Dr\",\"invoice_id\":0,\"bills_id\":0,\"sub_category_id\":30,\"admin_id\":2}]', '2021-03-30 18:41:48'),
(45, '2021-03-30 18:41:51', '[{\"id\":7,\"transaction_date\":\"2021-03-30 00:00:00\",\"amount\":\"1000.00\",\"payment_method\":\"CQ\",\"accounts_or_banks_id\":2,\"accounts_or_banks_id_transfer_fromto\":1,\"is_active\":1,\"created_at\":\"2021-03-30T13:11:15.000000Z\",\"updated_at\":\"2021-03-30T13:11:15.000000Z\",\"is_editable\":1,\"notes\":null,\"description\":\"Write a Description1uiuiu\",\"is_reviewed\":0,\"transaction_type\":\"Cr\",\"invoice_id\":0,\"bills_id\":0,\"sub_category_id\":29,\"admin_id\":2}]', '2021-03-30 18:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `main_category`
--

CREATE TABLE `main_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `name2` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_editable` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no,yes-1',
  `mainaccount_type` varchar(10) NOT NULL DEFAULT 'I' COMMENT 'mainaccount_type'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_category`
--

INSERT INTO `main_category` (`id`, `name`, `name2`, `details`, `is_active`, `created_at`, `updated_at`, `is_editable`, `mainaccount_type`) VALUES
(1, 'Income', 'Sale', 'Income Account', 1, '2021-01-18 10:57:04', '2021-01-18 10:57:04', 0, 'I'),
(2, 'Expense', 'Buy', 'Expense Account', 1, '2021-01-18 10:57:04', '2021-01-18 10:57:04', 0, 'E');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_or_services`
--

CREATE TABLE `products_or_services` (
  `id` int(11) NOT NULL,
  `sub_category_id` varchar(50) NOT NULL DEFAULT '0' COMMENT 'sub_category id IN()',
  `name` varchar(255) NOT NULL COMMENT 'required',
  `description` text DEFAULT NULL COMMENT 'optional',
  `price` decimal(25,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_id` int(11) NOT NULL DEFAULT 1 COMMENT 'tax id',
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'added by admin id'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_or_services`
--

INSERT INTO `products_or_services` (`id`, `sub_category_id`, `name`, `description`, `price`, `is_active`, `created_at`, `updated_at`, `tax_id`, `admin_id`) VALUES
(1, '1', 'YTBHH', 'fghj g jghj ghjghj', '10.00', 2, '2021-01-19 08:34:08', '2021-01-19 08:34:08', 1, 0),
(2, '1', '5 Changes', 'total 5 Changes', '999.99', 1, '2021-01-19 08:34:08', '2021-02-01 06:59:21', 1, 0),
(3, '1', 'admin panel', 'hifi admin panel', '2560.00', 1, '2021-01-19 10:37:33', '2021-02-01 06:57:55', 2, 1),
(4, '6', 'my rent for shop', 'my rent is ok my rent is ok my rent is ok my rent is ok', '2435.00', 1, '2021-01-19 10:41:25', '2021-02-03 10:06:52', 1, 1),
(6, '1', 'Client website', 'Fancy Client website', '4500.00', 1, '2021-01-21 09:47:22', '2021-02-01 06:58:42', 1, 1),
(7, '12', 'electricity bill', 'electricity bill of office', '4056.23', 1, '2021-01-21 09:48:31', '2021-01-21 09:48:31', 1, 1),
(8, '1', 'Graphics Monthly', 'per day 3-4 grapichs social media post', '2400.00', 1, '2021-02-01 07:00:26', '2021-02-01 07:00:26', 1, 2),
(9, '1', 'Web Design #234', NULL, '5623.00', 1, '2021-02-04 07:24:10', '2021-02-04 07:24:10', 2, 2),
(10, '1', 'Admin Template #26', 'Admin Template id #26', '5600.00', 1, '2021-02-04 07:25:48', '2021-02-04 07:27:26', 1, 2),
(11, '1', 'Admin Template #27', 'Admin Template id #27', '2300.00', 1, '2021-02-04 07:27:08', '2021-02-04 07:27:08', 2, 2),
(12, '9', 'my house rent', 'my house rent january 2020', '5926.00', 1, '2021-02-04 07:34:35', '2021-02-04 07:34:35', 2, 2),
(13, '8', 'my house rent', NULL, '0.00', 1, '2021-02-04 07:34:56', '2021-02-04 07:34:56', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `short_helper`
--

CREATE TABLE `short_helper` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'for what',
  `is_active` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2-deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `classhtml` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'span class'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `short_helper`
--

INSERT INTO `short_helper` (`id`, `name`, `short`, `details`, `type`, `is_active`, `created_at`, `updated_at`, `classhtml`) VALUES
(1, 'Income', 'I', 'Income Account', 'mainaccount_type', 1, '2021-01-18 11:52:56', '2021-01-18 11:52:56', NULL),
(2, 'Expense', 'E', 'Expense Account', 'mainaccount_type', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', NULL),
(3, 'Account', 'A', 'Account', 'mainaccount_type', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', NULL),
(4, 'Paid', 'P', 'Invoice Paid', 'invoice_status', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', 'success'),
(5, 'Unpaid', 'U', 'Invoice UnPaid', 'invoice_status', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', 'danger'),
(6, 'Draft', 'D', 'Invoice Draft', 'invoice_status', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', 'warning'),
(7, 'Partial', 'R', 'Invoice Partial', 'invoice_status', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', 'info'),
(8, 'Bank Payment', 'B', 'Bank Payment Method', 'payment_method', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', ''),
(9, 'Cash', 'C', 'cash Method', 'payment_method', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', ''),
(10, 'Cheque', 'CQ', 'Cheque Method', 'payment_method', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', ''),
(11, 'Credit Card', 'CC', 'Credit Card Method', 'payment_method', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', ''),
(12, 'Paypal', 'P', 'Paypal', 'payment_method', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', ''),
(13, 'Other', 'O', 'Other Method', 'payment_method', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', ''),
(14, 'Debit', 'Dr', 'Debit', 'transaction_type', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', ''),
(15, 'Credit', 'Cr', 'Credit', 'transaction_type', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', ''),
(16, 'Paid', 'P', 'Bill Paid', 'bill_status', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', 'success'),
(17, 'Unpaid', 'U', 'Bill UnPaid', 'bill_status', 1, '2021-01-22 11:52:56', '2021-01-22 11:52:56', 'danger'),
(18, 'Deposit', 'Cr', 'Deposit', 'deposit_or_withdrawal', 1, '2021-02-03 11:52:56', '2021-01-22 11:52:56', ''),
(19, 'Withdraw', 'Dr', 'Withdraw', 'deposit_or_withdrawal', 1, '2021-02-03 11:52:56', '2021-01-22 11:52:56', ''),
(20, 'Reviewed', '1', 'Reviewed', 'is_reviewed_type', 1, '2021-02-08 11:52:56', '2021-01-22 11:52:56', ''),
(21, 'Not Reviewed', '0', 'Not Reviewed', 'is_reviewed_type', 1, '2021-02-08 11:52:56', '2021-01-22 11:52:56', '');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `main_category_id` int(11) NOT NULL DEFAULT 0 COMMENT 'main_category id',
  `name` varchar(255) DEFAULT NULL,
  `name2` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_editable` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no,yes-1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `main_category_id`, `name`, `name2`, `details`, `is_active`, `created_at`, `updated_at`, `is_editable`) VALUES
(1, 1, 'Sales', NULL, 'Sales', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(2, 2, 'Accounting Fees', NULL, 'Accounting Fees', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(3, 2, 'Advertising & Promotion', NULL, 'Advertising & Promotion', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(4, 2, 'Bank Service Charges', NULL, 'Bank Service Charges', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(5, 2, 'Computer – Hardware', NULL, 'Computer – Hardware', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(6, 2, 'Computer – Hosting', NULL, 'Computer – Hosting', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(7, 2, 'Computer – Internet', NULL, 'Computer – Internet', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(8, 2, 'Computer – Software', NULL, 'Computer – Software', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(9, 2, 'Depreciation Expense', NULL, 'Depreciation Expense', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(10, 2, 'Dues & Subscriptions', NULL, 'Dues & Subscriptions', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(11, 2, 'Equipment Lease or Rental', NULL, 'Equipment Lease or Rental', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(12, 2, 'Insurance – Vehicles', NULL, 'Insurance – Vehicles', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(13, 2, 'Interest Expense', NULL, 'Interest Expense', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(14, 2, 'Loss on Foreign Exchange', NULL, 'Loss on Foreign Exchange', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(15, 2, 'Meals and Entertainment', NULL, 'Meals and Entertainment', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(16, 2, 'Office Supplies', NULL, 'Office Supplies', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(17, 2, 'Payroll – Employee Benefits', NULL, 'Payroll – Employee Benefits', 1, '2021-01-18 11:00:04', '2021-01-18 11:00:04', 0),
(20, 1, 'Gautam Own Sale group', NULL, NULL, 1, '2021-02-04 09:15:50', '2021-02-04 09:15:50', 1),
(21, 2, 'Gautam Own Expense group', 'Gautam Own Expense group rtgetr', 'Gautam Own Expense group 1', 1, '2021-02-04 09:19:37', '2021-02-04 09:35:53', 1),
(22, 1, 'Invoice Payment', 'Invoice Payment', 'Invoice Payment', 1, '2021-02-05 09:36:45', '2021-02-05 09:36:45', 0),
(23, 2, 'Bill Payment', 'Bill Payment', 'Bill Payment', 1, '2021-02-05 09:37:01', '2021-02-05 09:37:01', 0),
(24, 2, 'Expense Mine', NULL, NULL, 1, '2021-02-09 09:55:14', '2021-02-09 09:55:14', 1),
(29, 1, 'Transfer From Bank, Credit Card or Loan', 'Transfer From XXXXXX Bank', 'Transfer From XXXXXX Bank', 1, '2021-03-30 10:01:48', '2021-03-30 10:01:48', 0),
(30, 2, 'Transfer To Bank, Credit Card or Loan', 'Transfer To XXXXXX Bank', 'Transfer To XXXXXX Bank', 1, '2021-03-30 10:01:48', '2021-03-30 10:01:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'required',
  `current_tax_rate` decimal(4,2) NOT NULL DEFAULT 0.00 COMMENT 'required',
  `abbreviation` varchar(55) NOT NULL COMMENT 'required',
  `details` varchar(255) DEFAULT NULL COMMENT 'optional',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_editable` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no,yes-1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `name`, `current_tax_rate`, `abbreviation`, `details`, `is_active`, `created_at`, `updated_at`, `is_editable`) VALUES
(2, 'GST', '18.00', 'GST', 'Goods and Services Tax', 1, '2021-01-18 11:30:12', '2021-01-18 11:30:12', 0),
(1, 'Select-Tax', '0.00', 'Select-Tax', 'Zero-Tax', 1, '2021-01-18 11:30:12', '2021-01-18 11:30:12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) NOT NULL,
  `transaction_date` datetime NOT NULL COMMENT 'required',
  `amount` decimal(25,2) NOT NULL DEFAULT 0.00 COMMENT 'required',
  `payment_method` varchar(20) NOT NULL DEFAULT 'C' COMMENT 'required',
  `accounts_or_banks_id` int(11) DEFAULT 1 COMMENT 'required',
  `accounts_or_banks_id_transfer_fromto` int(11) DEFAULT NULL COMMENT 'null for not transfer type else bank id',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_editable` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no,yes-1',
  `notes` varchar(1000) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL COMMENT 'title description',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no, 1-yes',
  `transaction_type` varchar(2) NOT NULL DEFAULT 'Dr' COMMENT 'required',
  `invoice_id` int(11) NOT NULL DEFAULT 0 COMMENT 'invoices id',
  `bills_id` int(11) NOT NULL DEFAULT 0 COMMENT 'bills id',
  `sub_category_id` int(11) NOT NULL DEFAULT 0 COMMENT 'sub_category id',
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'added by'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_date`, `amount`, `payment_method`, `accounts_or_banks_id`, `accounts_or_banks_id_transfer_fromto`, `is_active`, `created_at`, `updated_at`, `is_editable`, `notes`, `description`, `is_reviewed`, `transaction_type`, `invoice_id`, `bills_id`, `sub_category_id`, `admin_id`) VALUES
(9, '2021-03-30 00:00:00', '1230.00', 'CQ', 4, NULL, 1, '2021-03-30 13:12:59', '2021-03-30 13:14:24', 1, 'fhghf', 'fghfgh fg hghfg', 0, 'Dr', 0, 0, 30, 2),
(5, '2021-03-30 00:00:00', '100.00', 'C', 2, 1, 1, '2021-03-30 13:10:09', '2021-03-30 13:10:09', 1, NULL, 'kgkgh', 0, 'Dr', 0, 0, 30, 2),
(6, '2021-03-30 00:00:00', '100.00', 'C', 1, 2, 1, '2021-03-30 13:10:09', '2021-03-30 13:10:09', 1, NULL, 'kgkgh', 0, 'Cr', 0, 0, 29, 2),
(10, '2021-03-30 00:00:00', '56.00', 'B', 1, NULL, 1, '2021-03-30 13:20:11', '2021-03-30 13:20:11', 1, NULL, 'Write a Description1 dtyhdfthfy', 0, 'Dr', 0, 0, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'required',
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `is_active` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'added by admin id',
  `country` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'India',
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `fullname`, `firstname`, `lastname`, `email`, `mobile`, `is_active`, `created_at`, `updated_at`, `admin_id`, `country`, `state`, `city`, `pincode`, `address`, `landmark`) VALUES
(1, 'TEchnomads Infotech', 'Vendor', 'Kumar', 'technomads1243@gmail.com', '07889788978', 1, '2021-01-22 11:38:28', '2021-02-03 10:18:30', 1, 'India', 'gujarat', 'surat', '898978', '8989, near vip circle hub', 'near cinema house'),
(2, 'Hemant Pvt Ltd.', 'Hemant', 'Vasava', 'hemant789@work.in', '7845780212', 1, '2021-02-03 08:55:39', '2021-02-03 10:18:58', 2, 'India', 'gujarat', 'surat', '365989', 'Saniya nagar near mall', 'surat'),
(3, 'Govind kumarp', 'Govind', 'kumar', 'govindkumar23@mail.com', '09966888659', 1, '2021-02-03 10:15:48', '2021-02-03 11:35:16', 2, 'India', 'Gujarat', 'Surat', '395652', '59, hariom nagar near vraj residency', NULL),
(4, 'Viral Media', NULL, NULL, 'viral8098@mail.ok', NULL, 1, '2021-02-03 10:22:47', '2021-02-03 10:23:05', 2, 'India', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_or_banks`
--
ALTER TABLE `accounts_or_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_category`
--
ALTER TABLE `account_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_configurations`
--
ALTER TABLE `company_configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs_deleted`
--
ALTER TABLE `logs_deleted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_category`
--
ALTER TABLE `main_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products_or_services`
--
ALTER TABLE `products_or_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `short_helper`
--
ALTER TABLE `short_helper`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts_or_banks`
--
ALTER TABLE `accounts_or_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `account_category`
--
ALTER TABLE `account_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `company_configurations`
--
ALTER TABLE `company_configurations`
  MODIFY `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `logs_deleted`
--
ALTER TABLE `logs_deleted`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `main_category`
--
ALTER TABLE `main_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products_or_services`
--
ALTER TABLE `products_or_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `short_helper`
--
ALTER TABLE `short_helper`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
