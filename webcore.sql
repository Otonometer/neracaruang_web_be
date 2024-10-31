DROP TABLE IF EXISTS `coa_account`;
CREATE TABLE `coa_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `parent_id` int(11) DEFAULT NULL,
  `code` varchar(30) DEFAULT NULL COMMENT 'NOMOR',
  `description` varchar(150) DEFAULT NULL COMMENT 'KETERANGAN',
  `initial_balance` double DEFAULT NULL COMMENT 'SALDO AWAL',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active' COMMENT 'STATUS',
  `inactive_date` date DEFAULT NULL COMMENT 'TGL INACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='TABEL PERKIRAAN';


DROP TABLE IF EXISTS `configuration_system`;
CREATE TABLE `configuration_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coa_kas` int(11) DEFAULT NULL COMMENT 'NOMOR PERKIRAAN KAS',
  `date` date DEFAULT NULL COMMENT 'TGL MULAI',
  `month_active` int(11) DEFAULT NULL COMMENT 'PERIODE BULAN AKTIF',
  `year_active` year(4) DEFAULT NULL COMMENT 'PERIODE TAHUN AKTIF',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `celeted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `deposit`;
CREATE TABLE `deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deposit_type_id` int(11) DEFAULT NULL COMMENT 'JENIS SIMPANAN',
  `increament` int(11) DEFAULT NULL COMMENT 'INCREAMENT',
  `number` varchar(20) DEFAULT NULL COMMENT 'NUMBER FORM [GENERATE BY INCREAMENT]',
  `member_id` int(11) DEFAULT NULL COMMENT 'ANGGOTA',
  `amount` double DEFAULT NULL COMMENT 'JUMLAH',
  `note` text COMMENT 'KETERANGAN',
  `type` enum('in','out') DEFAULT NULL COMMENT 'TIPE TRANSAKSI',
  `date_input` date DEFAULT NULL COMMENT 'TGL INPUT FORM',
  `created_by` int(11) DEFAULT NULL COMMENT 'ADMIN',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `deposit_type`;
CREATE TABLE `deposit_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL COMMENT 'KODE',
  `name` varchar(20) DEFAULT NULL COMMENT 'NAMA SINGKAT',
  `description` varchar(150) DEFAULT NULL COMMENT 'NAMA',
  `deposit_interest` decimal(10,0) DEFAULT NULL COMMENT 'BUNGA SIMPANAN',
  `deposit_type` varchar(20) DEFAULT NULL COMMENT 'TIPE BUNGA SIMPANAN',
  `coa_deposit` int(11) DEFAULT NULL COMMENT 'NOMOR PERKIRAAN BUNGA SIMPANAN',
  `coa_interest` int(11) DEFAULT NULL COMMENT 'NOMOR PERKIRAAN SIMPANAN',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `installment`;
CREATE TABLE `installment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) DEFAULT NULL COMMENT 'NOMOR PINJAMAN',
  `date_payment` date DEFAULT NULL COMMENT 'TGL PEMBAYARAN',
  `increament` int(11) DEFAULT NULL COMMENT 'INCREAMENT',
  `number` varchar(20) DEFAULT NULL COMMENT 'FORM NUMBER [GENERATE BY INCREAMENT]',
  `note` text COMMENT 'KETERANGAN',
  `installment_count` int(11) DEFAULT NULL COMMENT 'JUMLAH CICILAN',
  `installment_to` int(11) DEFAULT NULL COMMENT 'CICILAN KE',
  `base_amount` double DEFAULT NULL COMMENT 'JUMLAH POKOK',
  `service_percent` double DEFAULT NULL COMMENT '% JASA',
  `service_amount` double DEFAULT NULL COMMENT 'JUMLAH JASA',
  `total_paid` double DEFAULT NULL COMMENT 'JUMLAH DIBAYARKAN',
  `created_by` int(11) DEFAULT NULL COMMENT 'ADMIN',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `loan`;
CREATE TABLE `loan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_type_id` int(11) DEFAULT NULL COMMENT 'JENIS PINJAMAN',
  `increament` int(11) DEFAULT NULL COMMENT 'INCREAMENT',
  `number` varchar(20) DEFAULT NULL COMMENT 'NUMBER FORM [GENERATE BY INCREAMENT]',
  `member_id` int(11) DEFAULT NULL COMMENT 'ANGGOTA',
  `base_amount` double DEFAULT NULL COMMENT 'PINJAMAN POKOK',
  `service_percent` double DEFAULT NULL COMMENT '% JASA',
  `service_amount` double DEFAULT NULL COMMENT 'TOTAL JASA',
  `amount` double DEFAULT NULL COMMENT 'TOTAL PINJAMAN',
  `loan_term` int(11) DEFAULT NULL COMMENT 'JANGKA WAKTU',
  `postpon_periode` int(11) DEFAULT NULL COMMENT 'PERIODE PENUNDAAN PEMBAYARAN DALAM BULAN',
  `note` text COMMENT 'KETERANGAN',
  `status` enum('lunas','belum lunas') DEFAULT NULL COMMENT 'STATUS',
  `date_loan` date DEFAULT NULL COMMENT 'TGL INPUT FORM PEMINJAMAN',
  `date_paid` date DEFAULT NULL COMMENT 'TGL PELUNASAN',
  `created_by` int(11) DEFAULT NULL COMMENT 'ADMIN',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `loan_type`;
CREATE TABLE `loan_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL COMMENT 'KODE',
  `name` varchar(20) DEFAULT NULL COMMENT 'NAMA SINGKAT',
  `description` varchar(150) DEFAULT NULL COMMENT 'NAMA',
  `deposit_service` decimal(10,0) DEFAULT NULL COMMENT 'JASA SIMPANAN',
  `deposit_type` varchar(20) DEFAULT NULL COMMENT 'TIPE JASA PINJAMAN',
  `coa_deposit` int(11) DEFAULT NULL COMMENT 'NOMOR PERKIRAAN BUNGA PINJAMAN',
  `coa_service` int(11) DEFAULT NULL COMMENT 'NOMOR PERKIRAAN PINJAMAN',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `long_deposit`;
CREATE TABLE `long_deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL COMMENT 'ANGGOTA',
  `date_input` date DEFAULT NULL COMMENT 'TGL INPUT',
  `deposit_type_id` int(11) DEFAULT NULL COMMENT 'JENIS SIMPANAN',
  `number` varchar(20) DEFAULT NULL COMMENT 'NUMBER TRANSAKSI [AUTO GENERATE]',
  `increament` int(11) DEFAULT NULL COMMENT 'INCREAMENT FOR NUMBER',
  `total` double DEFAULT NULL COMMENT 'AMOUNT',
  `created_by` int(11) DEFAULT NULL COMMENT 'ADMIN INPUT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `deposit_type_id` (`deposit_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `long_loan`;
CREATE TABLE `long_loan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL COMMENT 'ANGGOTA',
  `date_input` date DEFAULT NULL COMMENT 'TGL INPUT',
  `loan_type_id` int(11) DEFAULT NULL COMMENT 'JENIS PINJAMAN',
  `number` varchar(20) DEFAULT NULL COMMENT 'NUMBER TRANSAKSI [AUTO GENERATE]',
  `increament` int(11) DEFAULT NULL COMMENT 'INCREAMENT FOR NUMBER',
  `base_total` double DEFAULT NULL COMMENT 'JUMLAH POKOK',
  `service_percent` double DEFAULT NULL COMMENT '% JASA',
  `service_total` double DEFAULT NULL COMMENT 'JASA',
  `total` double DEFAULT NULL COMMENT 'JUMLAH PINJAMAN',
  `note` text COMMENT 'KETERANGAN',
  `status` enum('lunas','belum lunas') DEFAULT NULL COMMENT 'STATUS PINJAMAN',
  `type` enum('pinjaman lama','pinjaman baru') DEFAULT NULL COMMENT 'JENIS PINJAMAN',
  `loan_term` int(11) DEFAULT NULL COMMENT 'JANGKA WAKTU',
  `created_by` int(11) DEFAULT NULL COMMENT 'ADMIN INPUT',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `deposit_type_id` (`loan_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `fullname` varchar(150) DEFAULT NULL,
  `address_street` text,
  `address_city` varchar(50) DEFAULT NULL,
  `address_province` varchar(50) DEFAULT NULL,
  `address_zip` varchar(10) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `nik` varchar(30) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(50) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `registered_date` date DEFAULT NULL,
  `out_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `member_group`;
CREATE TABLE `member_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT 'NAMA',
  `status` enum('active','inactive') DEFAULT 'active' COMMENT 'STATUS',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2020_04_19_081851_create_pages_table',	1),
(5,	'2020_09_11_104416_create_settings_table',	1),
(6,	'2021_03_30_033353_create_permission_tables',	1);

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'coaAccount-create',	'web',	'2021-12-20 04:06:42',	'2021-12-20 04:06:42',	NULL),
(2,	'coaAccount-show',	'web',	'2021-12-20 04:06:42',	'2021-12-20 04:06:42',	NULL),
(3,	'coaAccount-edit',	'web',	'2021-12-20 04:06:42',	'2021-12-20 04:06:42',	NULL),
(4,	'coaAccount-update',	'web',	'2021-12-20 04:06:42',	'2021-12-20 04:06:42',	NULL),
(5,	'coaAccount-delete',	'web',	'2021-12-20 04:06:42',	'2021-12-20 04:06:42',	NULL),
(6,	'coaAccount-store',	'web',	'2021-12-20 04:06:42',	'2021-12-20 04:06:42',	NULL),
(7,	'configurationSystem-create',	'web',	'2021-12-20 04:14:17',	'2021-12-20 04:14:17',	NULL),
(8,	'configurationSystem-show',	'web',	'2021-12-20 04:14:17',	'2021-12-20 04:14:17',	NULL),
(9,	'configurationSystem-edit',	'web',	'2021-12-20 04:14:17',	'2021-12-20 04:14:17',	NULL),
(10,	'configurationSystem-update',	'web',	'2021-12-20 04:14:17',	'2021-12-20 04:14:17',	NULL),
(11,	'configurationSystem-delete',	'web',	'2021-12-20 04:14:17',	'2021-12-20 04:14:17',	NULL),
(12,	'configurationSystem-store',	'web',	'2021-12-20 04:14:17',	'2021-12-20 04:14:17',	NULL),
(13,	'deposit-create',	'web',	'2021-12-20 04:38:13',	'2021-12-20 04:38:13',	NULL),
(14,	'deposit-show',	'web',	'2021-12-20 04:38:13',	'2021-12-20 04:38:13',	NULL),
(15,	'deposit-edit',	'web',	'2021-12-20 04:38:13',	'2021-12-20 04:38:13',	NULL),
(16,	'deposit-update',	'web',	'2021-12-20 04:38:13',	'2021-12-20 04:38:13',	NULL),
(17,	'deposit-delete',	'web',	'2021-12-20 04:38:13',	'2021-12-20 04:38:13',	NULL),
(18,	'deposit-store',	'web',	'2021-12-20 04:38:13',	'2021-12-20 04:38:13',	NULL),
(19,	'depositType-create',	'web',	'2021-12-20 04:38:36',	'2021-12-20 04:38:36',	NULL),
(20,	'depositType-show',	'web',	'2021-12-20 04:38:36',	'2021-12-20 04:38:36',	NULL),
(21,	'depositType-edit',	'web',	'2021-12-20 04:38:36',	'2021-12-20 04:38:36',	NULL),
(22,	'depositType-update',	'web',	'2021-12-20 04:38:37',	'2021-12-20 04:38:37',	NULL),
(23,	'depositType-delete',	'web',	'2021-12-20 04:38:37',	'2021-12-20 04:38:37',	NULL),
(24,	'depositType-store',	'web',	'2021-12-20 04:38:37',	'2021-12-20 04:38:37',	NULL),
(25,	'installment-create',	'web',	'2021-12-20 04:39:01',	'2021-12-20 04:39:01',	NULL),
(26,	'installment-show',	'web',	'2021-12-20 04:39:01',	'2021-12-20 04:39:01',	NULL),
(27,	'installment-edit',	'web',	'2021-12-20 04:39:01',	'2021-12-20 04:39:01',	NULL),
(28,	'installment-update',	'web',	'2021-12-20 04:39:01',	'2021-12-20 04:39:01',	NULL),
(29,	'installment-delete',	'web',	'2021-12-20 04:39:01',	'2021-12-20 04:39:01',	NULL),
(30,	'installment-store',	'web',	'2021-12-20 04:39:01',	'2021-12-20 04:39:01',	NULL),
(31,	'loan-create',	'web',	'2021-12-20 04:39:27',	'2021-12-20 04:39:27',	NULL),
(32,	'loan-show',	'web',	'2021-12-20 04:39:27',	'2021-12-20 04:39:27',	NULL),
(33,	'loan-edit',	'web',	'2021-12-20 04:39:27',	'2021-12-20 04:39:27',	NULL),
(34,	'loan-update',	'web',	'2021-12-20 04:39:27',	'2021-12-20 04:39:27',	NULL),
(35,	'loan-delete',	'web',	'2021-12-20 04:39:27',	'2021-12-20 04:39:27',	NULL),
(36,	'loan-store',	'web',	'2021-12-20 04:39:27',	'2021-12-20 04:39:27',	NULL),
(37,	'loanType-create',	'web',	'2021-12-20 04:39:42',	'2021-12-20 04:39:42',	NULL),
(38,	'loanType-show',	'web',	'2021-12-20 04:39:42',	'2021-12-20 04:39:42',	NULL),
(39,	'loanType-edit',	'web',	'2021-12-20 04:39:42',	'2021-12-20 04:39:42',	NULL),
(40,	'loanType-update',	'web',	'2021-12-20 04:39:42',	'2021-12-20 04:39:42',	NULL),
(41,	'loanType-delete',	'web',	'2021-12-20 04:39:42',	'2021-12-20 04:39:42',	NULL),
(42,	'loanType-store',	'web',	'2021-12-20 04:39:43',	'2021-12-20 04:39:43',	NULL),
(43,	'longDeposit-create',	'web',	'2021-12-20 04:40:12',	'2021-12-20 04:40:12',	NULL),
(44,	'longDeposit-show',	'web',	'2021-12-20 04:40:12',	'2021-12-20 04:40:12',	NULL),
(45,	'longDeposit-edit',	'web',	'2021-12-20 04:40:12',	'2021-12-20 04:40:12',	NULL),
(46,	'longDeposit-update',	'web',	'2021-12-20 04:40:12',	'2021-12-20 04:40:12',	NULL),
(47,	'longDeposit-delete',	'web',	'2021-12-20 04:40:12',	'2021-12-20 04:40:12',	NULL),
(48,	'longDeposit-store',	'web',	'2021-12-20 04:40:13',	'2021-12-20 04:40:13',	NULL),
(49,	'longLoan-create',	'web',	'2021-12-20 04:40:42',	'2021-12-20 04:40:42',	NULL),
(50,	'longLoan-show',	'web',	'2021-12-20 04:40:42',	'2021-12-20 04:40:42',	NULL),
(51,	'longLoan-edit',	'web',	'2021-12-20 04:40:42',	'2021-12-20 04:40:42',	NULL),
(52,	'longLoan-update',	'web',	'2021-12-20 04:40:42',	'2021-12-20 04:40:42',	NULL),
(53,	'longLoan-delete',	'web',	'2021-12-20 04:40:42',	'2021-12-20 04:40:42',	NULL),
(54,	'longLoan-store',	'web',	'2021-12-20 04:40:42',	'2021-12-20 04:40:42',	NULL),
(55,	'member-create',	'web',	'2021-12-20 04:41:13',	'2021-12-20 04:41:13',	NULL),
(56,	'member-show',	'web',	'2021-12-20 04:41:13',	'2021-12-20 04:41:13',	NULL),
(57,	'member-edit',	'web',	'2021-12-20 04:41:13',	'2021-12-20 04:41:13',	NULL),
(58,	'member-update',	'web',	'2021-12-20 04:41:13',	'2021-12-20 04:41:13',	NULL),
(59,	'member-delete',	'web',	'2021-12-20 04:41:13',	'2021-12-20 04:41:13',	NULL),
(60,	'member-store',	'web',	'2021-12-20 04:41:13',	'2021-12-20 04:41:13',	NULL),
(61,	'memberGroup-create',	'web',	'2021-12-20 04:41:31',	'2021-12-20 04:41:31',	NULL),
(62,	'memberGroup-show',	'web',	'2021-12-20 04:41:31',	'2021-12-20 04:41:31',	NULL),
(63,	'memberGroup-edit',	'web',	'2021-12-20 04:41:31',	'2021-12-20 04:41:31',	NULL),
(64,	'memberGroup-update',	'web',	'2021-12-20 04:41:31',	'2021-12-20 04:41:31',	NULL),
(65,	'memberGroup-delete',	'web',	'2021-12-20 04:41:31',	'2021-12-20 04:41:31',	NULL),
(66,	'memberGroup-store',	'web',	'2021-12-20 04:41:31',	'2021-12-20 04:41:31',	NULL);

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tenancies`;
CREATE TABLE `tenancies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `db` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tenancies` (`id`, `name`, `url`, `db`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'TENANCY 1',	'koperasi',	'sispin_tenancy',	'2021-12-19 14:11:11',	NULL,	NULL);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tenancy_id` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `tenancy_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Administrataor',	'admin@redtech.id',	NULL,	'$2y$10$V3fztEln9FgpQwt7OeXe1.wcs8oBi/DReo4al1SieptP7ppIz11le',	NULL,	1,	'2021-12-19 07:01:54',	'2021-12-19 07:01:54',	NULL);


DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

