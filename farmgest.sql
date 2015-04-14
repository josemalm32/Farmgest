-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 14-Abr-2015 às 23:16
-- Versão do servidor: 5.6.17
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
-- Estrutura da tabela `entitys`
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
-- Extraindo dados da tabela `entitys`
--

INSERT INTO `entitys` (`id`, `name`, `vat`, `logo`, `email`, `phone`, `website`, `address`, `contacts`, `notes`) VALUES
(1, 'Nutrimondego', NULL, NULL, 'geral@nutrimondego.com', '123456789', 'www.nutrimondego.com', 'Brasfesmes', '123456789', '123456789'),
(12, 'teste', NULL, NULL, '1@1.C', 'asdasdqweq', 'asdasdsqweqw', '<p>\r\n asdasdas</p>\r\n', '<p>\r\n dasdada</p>\r\n', '<p>\r\n dasda</p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `farms`
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
-- Extraindo dados da tabela `farms`
--

INSERT INTO `farms` (`id`, `name`, `location`, `production_type`, `main_culture`, `seeding_unit`, `yeld_unit`, `id_entity`, `notes`) VALUES
(2, 'farm123', 'rua da estrada 42', 'Hydroponic', 'mainculture', '0', '0', 1, '<p>\r\n 0</p>\r\n'),
(3, 'farm2', 'rua da estrada 42', 'Hydroponic', 'asdasdasd', '0', '0', 1, '<p>\r\n 0</p>\r\n'),
(6, 'DFASD', 'AsdsdAS', 'Integrated', 'ASDsd', '20', '20', 12, '<p>\r\n dfsfsdfsdf</p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_expenses`
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
  `id_entity` int(11) NOT NULL,
  `id_farm` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `fin_expenses`
--

INSERT INTO `fin_expenses` (`id`, `id_type`, `description`, `id_vendor`, `n_document`, `total_cost`, `date_document`, `date_due`, `date_efective_payment`, `payment_type`, `notes`, `id_entity`, `id_farm`) VALUES
(3, 1, 'QWASDASQWE', 0, '123', 123, '2015-04-01', '2015-04-14', '2015-04-02', 'Money', '<p>\r\n ADSDASDASDASDCXC</p>\r\n', 0, 0),
(2, 0, 'fdsfsdf', 3, 'sdfsd', 0, '2010-10-10', '2010-10-10', '2010-10-10', 'BankTransfer', '', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_expenses_detail`
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
  `supplier_code` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `weight` float NOT NULL,
  `package_code` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `fin_expenses_detail`
--

INSERT INTO `fin_expenses_detail` (`id`, `id_expense`, `id_item_type`, `item_description`, `item_quantity`, `unit_cost`, `tax_rate`, `brand`, `technical_name`, `notes`, `supplier_code`, `weight`, `package_code`) VALUES
(1, 2, 0, 'asdasd', 23, 2323, 23232, 'asdasd', 'asdasd', '', '', 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_expenses_type`
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
-- Extraindo dados da tabela `fin_expenses_type`
--

INSERT INTO `fin_expenses_type` (`id`, `description`, `type`, `state`, `notes`, `id_farm`, `id_entity`) VALUES
(1, '123', 'expense', 'active', '<p>\r\n qweqweqw</p>\r\n', 3, 1),
(3, 'sadfhg', 'investment', 'active', '<p>\r\n zxcvv</p>\r\n', 2, 1),
(4, 'asdsada', 'expense', 'inactive', '<p>\r\n dasda</p>\r\n', 6, 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_orders`
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
  `description` varchar(200) NOT NULL,
  `state` enum('active','inactive') NOT NULL,
  `id_supplier` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `fin_orders`
--

INSERT INTO `fin_orders` (`id`, `order_date`, `deliver_date`, `quantity`, `id_customer`, `id_farm`, `id_entity`, `notes`, `description`, `state`, `id_supplier`) VALUES
(1, '2015-03-25', '2015-04-07', 123, 1, 3, 1, '<p>\r\n sdfsdf</p>\r\n', '', 'active', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_orders_detail`
--

CREATE TABLE IF NOT EXISTS `fin_orders_detail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_order` int(10) NOT NULL,
  `item` int(10) NOT NULL,
  `quantity` float NOT NULL,
  `quantity_unit` varchar(60) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `fin_orders_detail`
--

INSERT INTO `fin_orders_detail` (`id`, `id_order`, `item`, `quantity`, `quantity_unit`, `notes`) VALUES
(1, 1, 1231, 12323, '123213', '<p>\r\n asdadasdasd</p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_product_type`
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
-- Estrutura da tabela `fin_vendor_client`
--

CREATE TABLE IF NOT EXISTS `fin_vendor_client` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('Vendor','Customer','Both','External') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_conditions` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_type` enum('MB','BankTransfer','Money','Other') COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `observacoes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `id_g_contacts` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `fin_vendor_client`
--

INSERT INTO `fin_vendor_client` (`id`, `type`, `name`, `address`, `payment_conditions`, `payment_type`, `payment_date`, `date_created`, `observacoes`, `id_farm`, `id_entity`, `notes`, `id_g_contacts`) VALUES
(1, 'Customer', 'Rui', 'asdasdas', 'sdasdasd', 'Money', '0000-00-00', '2015-03-24 00:00:00', 'asdasdasd', 3, 1, '<p>\r\n adasd</p>\r\n', 0),
(2, '', 'sadasdas', 'dasdasd', 'asdasdasd', 'BankTransfer', '0000-00-00', '2015-03-23 15:40:01', 'asdasdasdas', 6, 12, '<p>\r\n asdasdasdasdasdasd</p>\r\n', 0),
(3, 'Vendor', 'Luis', 'adasdasd', 'asdasdasdas', 'MB', '0000-00-00', '2015-03-23 21:46:07', 'asasd', 6, 12, '<p>\r\n asasdasdasd</p>\r\n', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `globalgap_402`
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
-- Estrutura da tabela `global_gap`
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
-- Estrutura da tabela `global_gap_documentacao_suporte`
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
-- Estrutura da tabela `global_gap_respostas`
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
-- Estrutura da tabela `g_alarms`
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
-- Estrutura da tabela `g_assets`
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
-- Estrutura da tabela `g_assets_category`
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
-- Estrutura da tabela `g_assets_reserve`
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
-- Estrutura da tabela `g_changelog`
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
-- Estrutura da tabela `g_contacts`
--

CREATE TABLE IF NOT EXISTS `g_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` int(12) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `g_contacts`
--

INSERT INTO `g_contacts` (`id`, `phone`, `name`, `email`) VALUES
(1, 123456789, 'Luis', 'luis@luis.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `g_documents`
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
-- Estrutura da tabela `g_documents_labels`
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
-- Estrutura da tabela `g_labels`
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
-- Estrutura da tabela `g_menus`
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
-- Estrutura da tabela `g_tasks`
--

CREATE TABLE IF NOT EXISTS `g_tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `date_reminder` datetime NOT NULL,
  `category` int(10) NOT NULL,
  `id_fields` int(10) NOT NULL,
  `id_fields_section` int(10) NOT NULL,
  `status` enum('Pending','Scheduled','In Progress','Finished') NOT NULL,
  `id_season` int(10) NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `g_tasks`
--

INSERT INTO `g_tasks` (`id`, `name`, `date_start`, `date_end`, `date_reminder`, `category`, `id_fields`, `id_fields_section`, `status`, `id_season`, `id_farm`, `id_entity`, `notes`) VALUES
(2, 'task1', '2015-04-14 21:24:55', '2015-04-22 21:24:58', '2015-04-19 00:00:00', 123, 1, 123, 'In Progress', 1, 3, 1, '<p>\r\n asdas112</p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `g_tasks_users`
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
-- Estrutura da tabela `permission_item`
--

CREATE TABLE IF NOT EXISTS `permission_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_description` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permission_list_item`
--

CREATE TABLE IF NOT EXISTS `permission_list_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_permission_list` int(11) NOT NULL,
  `id_permission_item` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permission_list_user_role`
--

CREATE TABLE IF NOT EXISTS `permission_list_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_permission_list` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_fertilization`
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
  `id_season` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_fields`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `prod_fields`
--

INSERT INTO `prod_fields` (`id`, `short_code`, `name`, `surface`, `surface_unit`, `location`, `production_id`, `cadastral_plots`, `id_season`, `id_farm`, `id_entity`, `notes`) VALUES
(1, 'e1b1', 'asd123', '0', 'asd12', 'asd123', 1223, '<p>\r\n asdasdzxcvz</p>\r\n<p>\r\n dfdsafe</p>\r\n<p>\r\n afsd</p>\r\n<p>\r\n fa</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n', 0, 3, 1, '<p>\r\n asdasdasda</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n asd</p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_fields_sections`
--

CREATE TABLE IF NOT EXISTS `prod_fields_sections` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `section_name` varchar(255) NOT NULL,
  `id_field` int(10) NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `prod_fields_sections`
--

INSERT INTO `prod_fields_sections` (`id`, `section_name`, `id_field`, `id_farm`, `id_entity`, `notes`) VALUES
(1, 'e1b1UP', 1, 3, 1, '<p>\r\n qasadasdqwe</p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season`
--

CREATE TABLE IF NOT EXISTS `prod_season` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `production_type` varchar(20) DEFAULT NULL,
  `id_template` int(10) DEFAULT NULL,
  `expected_yeld` decimal(10,0) DEFAULT NULL,
  `expected_yeld_unit` varchar(5) DEFAULT NULL,
  `expected_income` decimal(10,0) DEFAULT NULL,
  `n_plants` int(11) DEFAULT NULL,
  `plants_spacing` decimal(10,0) DEFAULT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `id_sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `prod_season`
--

INSERT INTO `prod_season` (`id`, `name`, `start_date`, `end_date`, `status`, `production_type`, `id_template`, `expected_yeld`, `expected_yeld_unit`, `expected_income`, `n_plants`, `plants_spacing`, `id_farm`, `id_entity`, `id_sort`) VALUES
(1, 'asdasdasd', '2015-04-01', '2015-04-15', 'Active', '1', NULL, '1254', '12', '1524', 100, '0', 3, 1, 0),
(2, 'season1', '2015-04-14', '2015-04-29', 'Active', '1', 123, '123', '123', '133', 12, '0', 2, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_fields_sections`
--

CREATE TABLE IF NOT EXISTS `prod_season_fields_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_season` int(11) NOT NULL,
  `id_entity` int(11) NOT NULL,
  `id_farm` int(11) NOT NULL,
  `id_field` int(11) NOT NULL,
  `id_fieldsection` int(11) NOT NULL,
  `state` enum('active','inactive') NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_harvast`
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
-- Estrutura da tabela `prod_season_log`
--

CREATE TABLE IF NOT EXISTS `prod_season_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_season` int(11) NOT NULL,
  `id_fieldsection` int(11) NOT NULL,
  `id_field` int(11) NOT NULL,
  `id_farm` int(11) NOT NULL,
  `id_entity` int(11) NOT NULL,
  `event` enum('seed acquisition','plant acquisition','seeding','phase1','phase2','harvasting','other') NOT NULL,
  `status` enum('active','inactive','pending','progress','closed','finished','other') NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_problems`
--

CREATE TABLE IF NOT EXISTS `prod_season_problems` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_season` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('Disease','Pest','Weed','Other') NOT NULL,
  `description` longtext NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_problems_actions`
--

CREATE TABLE IF NOT EXISTS `prod_season_problems_actions` (
  `id` int(10) NOT NULL,
  `id_season` int(10) NOT NULL,
  `action` longtext NOT NULL,
  `type` enum('treatment','cc','vv','gg') NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `result` longtext NOT NULL,
  `notes` longtext NOT NULL,
  `id_problem` int(10) NOT NULL,
  `efficiency` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_problems_actions_fieldsection`
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
-- Estrutura da tabela `prod_sorts`
--

CREATE TABLE IF NOT EXISTS `prod_sorts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `common_name` varchar(255) NOT NULL,
  `technical_name` varchar(255) NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext,
  `state` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `prod_sorts`
--

INSERT INTO `prod_sorts` (`id`, `common_name`, `technical_name`, `id_farm`, `id_entity`, `notes`, `state`) VALUES
(1, 'cenas', 'cenas1', 3, 1, NULL, 'active');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_storage`
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
-- Estrutura da tabela `prod_storage_consum`
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
-- Estrutura da tabela `prod_storage_house`
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
-- Estrutura da tabela `prod_template`
--

CREATE TABLE IF NOT EXISTS `prod_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `id_tasks` int(11) NOT NULL,
  `id_prod_actions` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_tasks` (`id_tasks`,`id_prod_actions`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_treatment`
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
  `id_season` int(11) NOT NULL,
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `id_supplier` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rep_configuration`
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
-- Estrutura da tabela `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `role_description` varchar(250) DEFAULT NULL,
  `status` enum('active','inactive','demo','temporary') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('admin','moderator','user') CHARACTER SET utf8 NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `date_added`, `date_modified`, `type`, `id_entity`) VALUES
(1, 'admin', 'admin', '2015-03-10 20:31:59', '2015-03-10 20:31:59', 'admin', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_user` int(10) NOT NULL,
  `id_role` int(10) NOT NULL,
  `status` enum('active','inactive','demo','temporary') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `weather`
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
