
CREATE TABLE IF NOT EXISTS `#__payzito_coupons_apply` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `min_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `max_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `amount_unit` BIGINT(20) NOT NULL DEFAULT 0,
  `coupon_unit` INT(11) NOT NULL DEFAULT 0,
  `max_use` INT(11) NOT NULL DEFAULT 0,
  `enabled` TINYINT(4) NOT NULL DEFAULT 0,
  `ordering` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_coupons_usage` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `min_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `max_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `max_use` INT(11) NOT NULL DEFAULT 0,
  `max_use_type` TINYINT(4) NOT NULL DEFAULT 0,
  `enabled` TINYINT(4) NOT NULL DEFAULT 0,
  `ordering` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_discounts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `code` VARCHAR(255) NOT NULL DEFAULT '',
  `deal` BIGINT(20) NOT NULL DEFAULT 0,
  `type` TINYINT(4) NOT NULL DEFAULT 1,
  `all_count` INT(11) NOT NULL DEFAULT 0,
  `used_count` INT(11) NOT NULL DEFAULT 0,
  `enabled` TINYINT(4) NOT NULL DEFAULT 1,
  `start_date` VARCHAR(20) NOT NULL DEFAULT '',
  `end_date` VARCHAR(20) NOT NULL DEFAULT '',
  `allow_extension_ids` VARCHAR(255) NOT NULL DEFAULT '',
  `allow_gateway_ids` VARCHAR(255) NOT NULL DEFAULT '',
  `min_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `max_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `ceiling_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `automatic_apply` TINYINT(4) NOT NULL DEFAULT 0,
  `use_by_coupon` TINYINT(4) NOT NULL DEFAULT 0,
  `max_user_usage` INT(11) NOT NULL DEFAULT 0,
  `ordering` INT(11) NOT NULL DEFAULT 0,
  `access_level` VARCHAR(50) NOT NULL DEFAULT -1,
  `specific_titles` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_extensions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL DEFAULT '',
  `plg_name` VARCHAR(255) NOT NULL DEFAULT '',
  `params` TEXT DEFAULT NULL,
  `enabled` TINYINT(4) NOT NULL DEFAULT 0,
  `website` VARCHAR(100) NOT NULL DEFAULT '',
  `extras` VARCHAR(255) NOT NULL DEFAULT '',
  `type` TINYINT(4) NOT NULL DEFAULT 0,
  `plg_id` VARCHAR(100) NOT NULL DEFAULT 0,
  `factor_columns` VARCHAR(255) NOT NULL DEFAULT '',
  `reference_url` VARCHAR(255) NOT NULL DEFAULT '',
  `version` VARCHAR(11) NOT NULL DEFAULT '',
  `deleted` TINYINT(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_gateways` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL DEFAULT '',
  `plg_name` VARCHAR(255) NOT NULL DEFAULT '',
  `params` TEXT DEFAULT NULL,
  `enabled` TINYINT(4) NOT NULL DEFAULT 0,
  `website` VARCHAR(100) NOT NULL DEFAULT '',
  `extras` VARCHAR(255) NOT NULL DEFAULT '',
  `default` TINYINT(4) NOT NULL DEFAULT 0,
  `index` INT(11) NOT NULL DEFAULT 0,
  `use_in_smart` TINYINT(4) NOT NULL DEFAULT 1,
  `plg_id` VARCHAR(100) NOT NULL DEFAULT 0,
  `is_set` TINYINT(4) NOT NULL DEFAULT 0,
  `version` VARCHAR(11) NOT NULL DEFAULT '',
  `deleted` TINYINT(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_ideposit` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `hash` varchar(10) NOT NULL DEFAULT '',
  `gateway` varchar(10) NOT NULL DEFAULT '',
  `data` TEXT DEFAULT NULL,
  `response` TEXT DEFAULT NULL,
  `status` TINYINT(4) NOT NULL DEFAULT 0,
  `created_at` VARCHAR(19) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT 1000;

CREATE TABLE IF NOT EXISTS `#__payzito_keywords` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `keyword` VARCHAR(255) NOT NULL DEFAULT '',
  `translate_fa_ir` TEXT DEFAULT NULL,
  `translate_fa_ir_default` TEXT DEFAULT NULL,
  `translate_en_gb` TEXT DEFAULT NULL,
  `translate_en_gb_default` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `content` TEXT DEFAULT NULL,
  `viewed` TINYINT(4) NOT NULL DEFAULT 0,
  `deleted` TINYINT(4) NOT NULL DEFAULT 0,
  `created_date` VARCHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_notify` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(10) NOT NULL DEFAULT '',
  `data` TEXT DEFAULT NULL,
  `reserve_date` VARCHAR(20) NOT NULL DEFAULT '',
  `sent_count` TINYINT(4) NOT NULL DEFAULT 0,
  `sent` TINYINT(4) NOT NULL DEFAULT 0,
  `sent_status` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_psw_logs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `api` varchar(16) NOT NULL DEFAULT '',
  `hash` varchar(16) NOT NULL DEFAULT '',
  `validate` varchar(7) NOT NULL DEFAULT '',
  `amount` bigint(20) DEFAULT 0,
  `type` tinyint(4) NOT NULL DEFAULT 0,
  `params` varchar(255) NOT NULL DEFAULT '',
  `reported` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_setting` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL DEFAULT '',
  `value` MEDIUMTEXT DEFAULT NULL,
  `convert` VARCHAR(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_transactions` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(20) NOT NULL DEFAULT '',
  `user_id` INT(11) NOT NULL DEFAULT 0,
  `user_name` VARCHAR(400) NOT NULL DEFAULT '',
  `user_username` VARCHAR(150) NOT NULL DEFAULT '',
  `user_phone` VARCHAR(12) NOT NULL DEFAULT '',
  `user_email` VARCHAR(100) NOT NULL DEFAULT '',
  `user_address` VARCHAR(500) NOT NULL DEFAULT '',
  `gateway_id` INT(11) NOT NULL DEFAULT 0,
  `amount` BIGINT(20) NOT NULL DEFAULT 0,
  `total_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `modified_date` VARCHAR(20) NOT NULL DEFAULT '',
  `reserve_date` VARCHAR(20) NOT NULL DEFAULT '',
  `paid_date` VARCHAR(20) NOT NULL DEFAULT '',
  `status` TINYINT(4) NOT NULL DEFAULT 1,
  `ref_number` VARCHAR(200) NOT NULL DEFAULT '',
  `extension_id` INT(11) NOT NULL DEFAULT 1,
  `trans_id` VARCHAR(255) NOT NULL DEFAULT '',
  `validate` VARCHAR(32) NOT NULL DEFAULT '',
  `description` TEXT DEFAULT NULL,
  `log` TEXT DEFAULT NULL,
  `sent_email` TINYINT(4) NOT NULL DEFAULT 0,
  `sent_sms` TINYINT(4) NOT NULL DEFAULT 0,
  `coupon_count` INT(11) NOT NULL DEFAULT 0,
  `coupon_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `coupon_suspended_ids` VARCHAR(255) NOT NULL DEFAULT '',
  `discount_title` VARCHAR(255) NOT NULL DEFAULT '',
  `discount_code` VARCHAR(255) NOT NULL DEFAULT '',
  `discount_type` TINYINT(4) NOT NULL DEFAULT 0,
  `discount_deal` BIGINT(20) NOT NULL DEFAULT 0,
  `discount_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `discount_ceiling` BIGINT(20) NOT NULL DEFAULT 0,
  `wallet_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `sent_id` VARCHAR(50) NOT NULL DEFAULT '',
  `gateway_amount` BIGINT(20) NOT NULL DEFAULT 0,
  `factor` TEXT DEFAULT NULL,
  `others` TEXT DEFAULT NULL,
  `gateway_logs` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `cost` BIGINT(20) NOT NULL DEFAULT 0,
  `name` VARCHAR(400) NOT NULL DEFAULT '',
  `email` VARCHAR(100) NOT NULL DEFAULT '',
  `phone` VARCHAR(12) NOT NULL DEFAULT '',
  `address` VARCHAR(500) NOT NULL DEFAULT '',
  `users_name` VARCHAR(400) NOT NULL DEFAULT '',
  `users_username` VARCHAR(150) NOT NULL DEFAULT '',
  `users_email` VARCHAR(100) NOT NULL DEFAULT '',
  `log` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__payzito_users_coupon` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL DEFAULT 0,
  `count` INT(11) NOT NULL DEFAULT 0,
  `suspended_count` INT(11) NOT NULL DEFAULT 0,
  `used_count` INT(11) NOT NULL DEFAULT 0,
  `expired_count` INT(11) NOT NULL DEFAULT 0,
  `add_date` VARCHAR(20) NOT NULL DEFAULT '',
  `expire_date` VARCHAR(20) NOT NULL DEFAULT '',
  `creator_transaction_id` INT(11) NOT NULL DEFAULT 0,
  `creator_user_id` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `#__payzito_extensions` (`id`, `name`, `plg_name`, `params`, `enabled`, `website`, `extras`, `type`, `plg_id`, `factor_columns`, `reference_url`, `version`, `deleted`) VALUES
(1, 'payment', 'payzito_payment', '', 1, 'https://payzito.net', '', 0, '0', '', '', '', 0),
(2, 'sales', 'payzito_sales', '', 1, 'https://payzito.net', '', 0, '0', '', '', '', 0),
(3, 'preinvoice', 'payzito_preinvoice', '', 1, 'https://payzito.net', '', 0, '0', '', '', '', 0),
(4, 'managewallet', 'payzito_wallet', '', 1, 'https://payzito.net', '', 0, '0', '', '', '', 0),
(5, 'link', 'payzito_link', '', 1, 'https://payzito.net', '', 0, '0', '', '', '', 0),
(6, 'form', 'payzito_form', '', 1, 'https://payzito.net', '', 0, '0', '', '', '', 0),
(7, 'tracking', 'payzito_tracking', '', 1, 'https://payzito.net', '', 0, '0', '', '', '', 0);

INSERT IGNORE INTO `#__payzito_gateways` (`id`, `name`, `plg_name`, `params`, `enabled`, `website`, `extras`, `default`, `index`, `use_in_smart`, `plg_id`, `is_set`, `version`, `deleted`) VALUES
(1, 'test', 'payzito_test', '', 0, 'https://payzito.net', '', 0, 1, '0', '0', 1, '', 0),
(2, 'indirect', 'payzito_indirect', '', 1, 'https://payzito.net', '', 1, 0, '0', '0', 1, '', 0),
(3, 'smart', 'payzito_smart', '', 0, 'https://payzito.net', '', 0, 2, '0', '0', 1, '', 0),
(4, 'wallet', 'payzito_wallet', '', 0, 'https://payzito.net', '', 0, 3, '0', '0', 1, '', 0);