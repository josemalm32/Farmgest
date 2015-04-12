-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2015 at 10:14 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `farmgest`
--

-- --------------------------------------------------------

--
-- Table structure for table `entitys`
--

CREATE TABLE IF NOT EXISTS `entitys` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `vat` varchar(30) DEFAULT NULL,
  `logo` longblob,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` longtext,
  `contacts` longtext,
  `notes` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `entitys`
--

INSERT INTO `entitys` (`id`, `name`, `vat`, `logo`, `email`, `phone`, `website`, `address`, `contacts`, `notes`) VALUES
(1, 'Nutrimondego', NULL, NULL, 'geral@nutrimondego.com', '123456789', 'www.nutrimondego.com', 'Brasfesmes', '123456789', '123456789'),
(12, 'teste', NULL, NULL, '1@1.C', 'asdasdqweq', 'asdasdsqweqw', '<p>\r\n asdasdas</p>\r\n', '<p>\r\n dasdada</p>\r\n', '<p>\r\n dasda</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `farms`
--

CREATE TABLE IF NOT EXISTS `farms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `production_type` enum('Conventional','Organic','Integrated','Hydroponic','Other') DEFAULT NULL,
  `main_culture` varchar(255) DEFAULT NULL,
  `seeding_unit` varchar(20) DEFAULT NULL,
  `yeld_unit` varchar(20) DEFAULT NULL,
  `id_entity` int(10) DEFAULT NULL,
  `notes` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `farms`
--

INSERT INTO `farms` (`id`, `name`, `location`, `production_type`, `main_culture`, `seeding_unit`, `yeld_unit`, `id_entity`, `notes`) VALUES
(2, 'farm123', 'rua da estrada 42', 'Hydroponic', 'mainculture', '0', '0', 1, '<p>\r\n 0</p>\r\n'),
(3, 'farm2', 'rua da estrada 42', 'Hydroponic', 'asdasdasd', '0', '0', 1, '<p>\r\n 0</p>\r\n'),
(6, 'DFASD', 'AsdsdAS', 'Integrated', 'ASDsd', '20', '20', 12, '<p>\r\n dfsfsdfsdf</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `fin_expenses`
--

CREATE TABLE IF NOT EXISTS `fin_expenses` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_type` int(10) NOT NULL,
  `description` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `id_vendor` int(10) NOT NULL,
  `n_document` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `total_cost` float NOT NULL,
  `date_document` date NOT NULL,
  `date_due` date NOT NULL,
  `date_efective_payment` date NOT NULL,
  `payment_type` enum('MB','BankTransfer','Money','Check','Other') COLLATE latin1_general_ci NOT NULL,
  `notes` longtext COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fin_expenses`
--

INSERT INTO `fin_expenses` (`id`, `id_type`, `description`, `id_vendor`, `n_document`, `total_cost`, `date_document`, `date_due`, `date_efective_payment`, `payment_type`, `notes`) VALUES
(2, 0, 'fdsfsdf', 0, 'sdfsd', 0, '2010-10-10', '2010-10-10', '2010-10-10', 'BankTransfer', '');

-- --------------------------------------------------------

--
-- Table structure for table `fin_expenses_detail`
--

CREATE TABLE IF NOT EXISTS `fin_expenses_detail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_expense` int(10) NOT NULL,
  `id_item_type` int(10) NOT NULL,
  `item_description` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `item_quantity` float NOT NULL,
  `unit_cost` float NOT NULL,
  `tax_rate` float NOT NULL,
  `brand` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `technical_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `notes` longtext COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fin_expenses_detail`
--

INSERT INTO `fin_expenses_detail` (`id`, `id_expense`, `id_item_type`, `item_description`, `item_quantity`, `unit_cost`, `tax_rate`, `brand`, `technical_name`, `notes`) VALUES
(1, 2, 0, 'asdasd', 23, 2323, 23232, 'asdasd', 'asdasd', '');

-- --------------------------------------------------------

--
-- Table structure for table `fin_expenses_type`
--

CREATE TABLE IF NOT EXISTS `fin_expenses_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `type` enum('investment','expense') COLLATE latin1_general_ci NOT NULL,
  `state` enum('active','inactive') COLLATE latin1_general_ci NOT NULL DEFAULT 'active',
  `notes` longtext COLLATE latin1_general_ci NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `fin_expenses_type`
--

INSERT INTO `fin_expenses_type` (`id`, `description`, `type`, `state`, `notes`, `id_farm`, `id_entity`) VALUES
(1, '123', 'expense', 'active', '<p>\r\n qweqweqw</p>\r\n', 3, 1),
(3, 'sadfhg', 'investment', 'active', '<p>\r\n zxcvv</p>\r\n', 2, 1),
(4, 'asdsada', 'expense', 'inactive', '<p>\r\n dasda</p>\r\n', 6, 12);

-- --------------------------------------------------------

--
-- Table structure for table `fin_orders`
--

CREATE TABLE IF NOT EXISTS `fin_orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_date` date NOT NULL,
  `deliver_date` date NOT NULL,
  `quantity` float NOT NULL,
  `id_customer` int(10) NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fin_orders_detail`
--

CREATE TABLE IF NOT EXISTS `fin_orders_detail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_order` int(10) NOT NULL,
  `item` int(10) NOT NULL,
  `quantity` float NOT NULL,
  `quantity_unit` varchar(60) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fin_product_type`
--

CREATE TABLE IF NOT EXISTS `fin_product_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `notes` longtext NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fin_vendor_client`
--

CREATE TABLE IF NOT EXISTS `fin_vendor_client` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('Vendor','Customer','Both','Other External') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_conditions` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_type` enum('MB','BankTransfer','Money','Other') COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `observacoes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `id_g_contacts` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `globalgap_402`
--

CREATE TABLE IF NOT EXISTS `globalgap_402` (
  `id` text,
  `id_pai` text,
  `tipo` text,
  `ponto_controlo_PT` text,
  `criterio_cumprimento_PT` text,
  `nivel` text,
  `ponto_controlo_EN` text,
  `criterio_cumprimento_EN` text,
  `grau_cumprimento` varchar(50) DEFAULT NULL,
  `num` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `global_gap`
--

CREATE TABLE IF NOT EXISTS `global_gap` (
  `id` text,
  `id_pai` text,
  `questao` text,
  `questao2` text,
  `importancia` varchar(50) DEFAULT NULL,
  `grau_cumprimento` varchar(50) DEFAULT NULL,
  `observacoes` text,
  `notas_questao` text,
  `num` int(10) NOT NULL AUTO_INCREMENT,
  `id_ent` int(10) NOT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `global_gap_documentacao_suporte`
--

CREATE TABLE IF NOT EXISTS `global_gap_documentacao_suporte` (
  `num` int(10) NOT NULL AUTO_INCREMENT,
  `id` varchar(10) NOT NULL,
  `designacao` varchar(20) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `resposta` text,
  `data_hora` datetime DEFAULT NULL,
  `id_ent` int(10) DEFAULT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `global_gap_respostas`
--

CREATE TABLE IF NOT EXISTS `global_gap_respostas` (
  `num` int(10) NOT NULL AUTO_INCREMENT,
  `id_user` int(10) NOT NULL DEFAULT '0',
  `id` varchar(50) DEFAULT NULL,
  `resposta` varchar(50) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  `documentacao` longtext NOT NULL,
  `id_ent` int(10) NOT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_alarms`
--

CREATE TABLE IF NOT EXISTS `g_alarms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` enum('wheather','finantial','field','storage','other') NOT NULL,
  `sql_query` longtext NOT NULL,
  `sql_fields` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_assets`
--

CREATE TABLE IF NOT EXISTS `g_assets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `id_category` int(10) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `registration_number` varchar(50) NOT NULL,
  `year` int(10) NOT NULL,
  `description` longtext NOT NULL,
  `notes` longtext NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_assets_category`
--

CREATE TABLE IF NOT EXISTS `g_assets_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `notes` longtext NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_assets_reserve`
--

CREATE TABLE IF NOT EXISTS `g_assets_reserve` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_asset` int(10) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_changelog`
--

CREATE TABLE IF NOT EXISTS `g_changelog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `status` enum('Planning','Planned','Developement','Testing','Production','Validated') COLLATE latin1_general_ci NOT NULL,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `description` longtext COLLATE latin1_general_ci NOT NULL,
  `id_entity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_contacts`
--

CREATE TABLE IF NOT EXISTS `g_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` int(12) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_documents`
--

CREATE TABLE IF NOT EXISTS `g_documents` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `upload_location` varchar(255) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `id_operator` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_documents_labels`
--

CREATE TABLE IF NOT EXISTS `g_documents_labels` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_document` int(10) NOT NULL,
  `id_label` int(10) NOT NULL,
  `priority` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_labels`
--

CREATE TABLE IF NOT EXISTS `g_labels` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `label` varchar(40) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_menus`
--

CREATE TABLE IF NOT EXISTS `g_menus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_master` int(10) NOT NULL,
  `order` int(5) NOT NULL,
  `screenzone` char(4) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `link` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `new_window` enum('Y','N') COLLATE latin1_general_ci NOT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci NOT NULL,
  `notes` longtext COLLATE latin1_general_ci NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_tasks`
--

CREATE TABLE IF NOT EXISTS `g_tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `date_reminder` datetime NOT NULL,
  `category` int(10) NOT NULL,
  `fields` int(10) NOT NULL,
  `fields_section` int(10) NOT NULL,
  `status` enum('Pending','Scheduled','In Progress','Finished') NOT NULL,
  `id_season` int(10) NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `g_tasks_users`
--

CREATE TABLE IF NOT EXISTS `g_tasks_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_task` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `priority` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_fertilization`
--

CREATE TABLE IF NOT EXISTS `prod_fertilization` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_package` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(11) DEFAULT NULL,
  `water_volume` float DEFAULT NULL,
  `deposit` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `notes` longtext,
  `id_user` int(11) DEFAULT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_fields`
--

CREATE TABLE IF NOT EXISTS `prod_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `short_code` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surface` decimal(10,0) NOT NULL,
  `surface_unit` varchar(5) NOT NULL,
  `location` varchar(255) NOT NULL,
  `production_id` int(10) NOT NULL,
  `cadastral_plots` longtext NOT NULL,
  `id_season` int(11) NOT NULL,
  `id_farm` int(11) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_fields_sections`
--

CREATE TABLE IF NOT EXISTS `prod_fields_sections` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `section_name` varchar(255) NOT NULL,
  `id_field` int(10) NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_season`
--

CREATE TABLE IF NOT EXISTS `prod_season` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `production_type` varchar(20) DEFAULT NULL,
  `id_template` int(10) DEFAULT NULL,
  `expected_yeld` decimal(10,0) DEFAULT NULL,
  `expected_yeld_unit` varchar(5) DEFAULT NULL,
  `expected_income` decimal(10,0) DEFAULT NULL,
  `n_plants` int(11) DEFAULT NULL,
  `plants_spacing` decimal(10,0) DEFAULT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_season_harvast`
--

CREATE TABLE IF NOT EXISTS `prod_season_harvast` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_season` int(10) DEFAULT NULL,
  `id_sort` int(10) DEFAULT NULL,
  `harv_start_date` datetime DEFAULT NULL,
  `harv_end_date` datetime DEFAULT NULL,
  `n_plants` int(20) DEFAULT NULL,
  `plants_weight_totalkg` float DEFAULT NULL,
  `plants_weight_average` float NOT NULL,
  `notes` longtext,
  `id_field_section` int(10) NOT NULL,
  `id_field` int(11) NOT NULL,
  `id_farm` int(10) DEFAULT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_season_problems`
--

CREATE TABLE IF NOT EXISTS `prod_season_problems` (
  `id` int(10) NOT NULL,
  `id_season` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('Disease','Pest','Weed','Other') NOT NULL,
  `description` longtext NOT NULL,
  `notes` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prod_season_problems_actions`
--

CREATE TABLE IF NOT EXISTS `prod_season_problems_actions` (
  `id` int(10) NOT NULL,
  `id_season` int(10) NOT NULL,
  `action` longtext NOT NULL,
  `type` enum('treatment','cc','vv','gg') NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `result` longtext NOT NULL,
  `notes` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prod_season_problems_actions_fieldsection`
--

CREATE TABLE IF NOT EXISTS `prod_season_problems_actions_fieldsection` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_problem_action` int(10) NOT NULL,
  `id_fieldsection` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  `priority` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_sorts`
--

CREATE TABLE IF NOT EXISTS `prod_sorts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `common_name` varchar(255) NOT NULL,
  `technical_name` varchar(255) NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_storage`
--

CREATE TABLE IF NOT EXISTS `prod_storage` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_season` int(10) DEFAULT NULL,
  `id_storage` int(10) DEFAULT NULL,
  `date_in` datetime DEFAULT NULL,
  `n_plants` int(20) DEFAULT NULL,
  `plants_weight_kg` float DEFAULT NULL,
  `notes` longtext,
  `id_user` int(10) DEFAULT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `n_boxes` int(10) NOT NULL,
  `n_pallets` int(10) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `id_custumer` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_storage_consum`
--

CREATE TABLE IF NOT EXISTS `prod_storage_consum` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_storage` int(10) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `item` int(10) NOT NULL,
  `quantity` float NOT NULL,
  `quantity_unit` varchar(60) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_storage_house`
--

CREATE TABLE IF NOT EXISTS `prod_storage_house` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `notes` longtext,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prod_treatment`
--

CREATE TABLE IF NOT EXISTS `prod_treatment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_package` int(10) NOT NULL,
  `active_substance` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `recomended_dose` decimal(10,0) NOT NULL,
  `security_interval` int(11) NOT NULL,
  `function` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `type` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(11) NOT NULL,
  `notes` longtext COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rep_configuration`
--

CREATE TABLE IF NOT EXISTS `rep_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query_code` varchar(100) NOT NULL,
  `query_sql` longtext NOT NULL,
  `title` varchar(200) NOT NULL,
  `template_location` varchar(200) NOT NULL,
  `start_line` int(11) NOT NULL,
  `title_cell` varchar(5) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `id_entity` int(10) NOT NULL,
  `id_farm` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('admin','moderator','user') CHARACTER SET utf8 NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `date_added`, `date_modified`, `type`, `id_entity`) VALUES
(1, 'admin', 'admin', '2015-03-10 20:31:59', '2015-03-10 20:31:59', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `weather`
--

CREATE TABLE IF NOT EXISTS `weather` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `datetime` datetime NOT NULL,
  `item` enum('Temperature','Humidity','Wind','Air Pressure','Precipitation') NOT NULL,
  `location` enum('internal','external') NOT NULL,
  `record_type` enum('measured','probability','predicted') NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
