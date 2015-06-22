-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 22-Jun-2015 às 19:08
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `farmgest1`
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
(2, 'TESTES', NULL, NULL, '1@1.C', 'asdasdqweq', 'asdasdsqweqw', '<p>\r\n asdasdas</p>\r\n', '<p>\r\n dasdada</p>\r\n', '<p>\r\n dasda</p>\r\n');

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
(1, 'Nutri-Estufas Quinta do Poço', 'Rua da Quinta do Poço', 'Hydroponic', 'Alface', 'g', 'Kg', 1, '<p>\r\n 0</p>\r\n'),
(2, 'Nutri - Cultura fora da estufa', 'Rua da Quinta do Poço', 'Conventional', 'Couve', 'unidade', 'Kg', 1, '<p>\r\n 0</p>\r\n'),
(3, 'Quinta de Testes', 'Coimbra', 'Integrated', 'Abóbora', 'unidade', 'Kg', 12, '<p>\r\n dfsfsdfsdf</p>\r\n');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `fin_expenses`
--

INSERT INTO `fin_expenses` (`id`, `id_type`, `description`, `id_vendor`, `n_document`, `total_cost`, `date_document`, `date_due`, `date_efective_payment`, `payment_type`, `notes`, `id_entity`, `id_farm`) VALUES
(4, 1, 'example', 2, '1', 111, '2015-04-21', '2015-04-23', '2015-04-22', 'MB', '<p>\r\n example</p>\r\n', 1, 3),
(5, 1, 'GASOLEO', 2, 'DSDS', 0, '0000-00-00', '0000-00-00', '0000-00-00', '', '', 1, 2),
(6, 5, 'Fitofarmacos Histórico / Stock Maio2015', 0, '', 0, '0000-00-00', '0000-00-00', '0000-00-00', '', '', 1, 0),
(7, 6, 'Fertilizantes Historic - Stock Maio2015', 0, '', 0, '0000-00-00', '0000-00-00', '0000-00-00', '', '', 1, 0);

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
  `quantity_unit` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `unit_cost` float NOT NULL,
  `tax_rate` float NOT NULL,
  `brand` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `technical_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `notes` longtext COLLATE latin1_general_ci NOT NULL,
  `supplier_code` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `weight` float NOT NULL,
  `package_code` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `stock_expense` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `fin_expenses_detail`
--

INSERT INTO `fin_expenses_detail` (`id`, `id_expense`, `id_item_type`, `item_description`, `item_quantity`, `quantity_unit`, `unit_cost`, `tax_rate`, `brand`, `technical_name`, `notes`, `supplier_code`, `weight`, `package_code`, `stock_expense`) VALUES
(3, 4, 2, 'example2', 1, '', 12, 10, 'something', 'something', '<p>\r\n something</p>\r\n', '12313', 2, '1231234', 0),
(2, 4, 1, 'example', 1, '', 12, 20, 'example', 'something', '<p>\r\n this is an example</p>\r\n', '123', 1, '712834123', 0),
(4, 4, 4, 'Banana', 15, '', 1, 21, 'Banana', 'Banana', '', '12584', 15, '125495', 0),
(18, 7, 6, 'Nitrato de Cálcio 1 -1Maio2015', 12, 'kg', 15, 0, 'Nitatite YARA', 'Calcinite', '', '', 12, '', 1),
(19, 0, 5, 'DECIS (12dias intervalo)', 15, 'kg', 12, 0, 'DECIS', 'DECIS', '', '', 0, '', 1),
(20, 4, 0, '', 0, '', 0, 0, '', '', '', '', 0, '', 0),
(21, 0, 3, 'das', 0, '', 0, 0, '', '', '', '', 0, '', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `fin_expenses_type`
--

INSERT INTO `fin_expenses_type` (`id`, `description`, `type`, `state`, `notes`, `id_farm`, `id_entity`) VALUES
(1, 'Gasóleo', 'expense', 'active', '<p>\r\n qweqweqw</p>\r\n', 3, 1),
(3, 'Electricidade', 'expense', 'active', '<p>\r\n zxcvv</p>\r\n', 2, 1),
(4, 'asdsada', 'expense', 'inactive', '<p>\r\n dasda</p>\r\n', 6, 12),
(5, 'Fitofármacos', 'expense', 'active', 'Produtos Fitofármacos', 1, 1),
(6, 'Fertilizantes', 'expense', 'active', '', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_orders`
--

CREATE TABLE IF NOT EXISTS `fin_orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `deliver_date` date NOT NULL,
  `quantity` float NOT NULL,
  `id_customer` int(10) NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  `state` enum('active','inactive') NOT NULL,
  `id_supplier` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `fin_orders`
--

INSERT INTO `fin_orders` (`id`, `description`, `order_date`, `deliver_date`, `quantity`, `id_customer`, `id_farm`, `id_entity`, `notes`, `state`, `id_supplier`) VALUES
(1, '', '2015-03-25', '2015-04-07', 123, 1, 3, 1, '<p>\r\n sdfsdf</p>\r\n', 'active', 0),
(2, 'encomenda varzea 01/05', '2015-05-01', '2015-05-02', 12, 1, 2, 1, '', 'active', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `fin_orders_detail`
--

INSERT INTO `fin_orders_detail` (`id`, `id_order`, `item`, `quantity`, `quantity_unit`, `notes`) VALUES
(1, 1, 1231, 12323, '123213', '<p>\r\n asdadasdasd</p>\r\n'),
(2, 2, 1, 12, 'unidades', 'dsds');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_orders_plants`
--

CREATE TABLE IF NOT EXISTS `fin_orders_plants` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item` int(10) NOT NULL,
  `order_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `tray_quantity` int(11) NOT NULL,
  `plants_quantity` int(12) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `fin_orders_plants`
--

INSERT INTO `fin_orders_plants` (`id`, `item`, `order_date`, `delivery_date`, `tray_quantity`, `plants_quantity`, `notes`) VALUES
(1, 1, '2015-05-01', '2015-05-20', 2, 200, '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `fin_product_type`
--

INSERT INTO `fin_product_type` (`id`, `description`, `type`, `status`, `notes`, `id_farm`, `id_entity`) VALUES
(1, 'example', 'dunno', 'Active', '<p>\r\n something</p>\r\n', 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_vendor_client`
--

CREATE TABLE IF NOT EXISTS `fin_vendor_client` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
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
  `Client` tinyint(1) NOT NULL,
  `Vendor` tinyint(1) NOT NULL,
  `Other` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `fin_vendor_client`
--

INSERT INTO `fin_vendor_client` (`id`, `name`, `address`, `payment_conditions`, `payment_type`, `payment_date`, `date_created`, `observacoes`, `id_farm`, `id_entity`, `notes`, `id_g_contacts`, `Client`, `Vendor`, `Other`) VALUES
(1, 'Rui', 'asdasdas', 'sdasdasd', 'Money', '0000-00-00', '2015-03-24 00:00:00', 'asdasdasd', 3, 1, '<p>\r\n adasd</p>\r\n', 0, 1, 0, 0),
(2, 'sadasdas', 'dasdasd', 'asdasdasd', 'BankTransfer', '0000-00-00', '2015-03-23 15:40:01', 'asdasdasdas', 6, 1, '<p>\r\n asdasdasdasdasdasd</p>\r\n', 0, 0, 1, 0),
(3, 'Luis', 'adasdasd', 'asdasdasdas', 'MB', '0000-00-00', '2015-03-23 21:46:07', 'asasd', 6, 1, '<p>\r\n asasdasdasd</p>\r\n', 1, 0, 0, 1);

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
  `order_menu` int(5) NOT NULL,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `link` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci NOT NULL,
  `notes` longtext COLLATE latin1_general_ci NOT NULL,
  `id_user_role` int(10) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `g_tasks`
--

INSERT INTO `g_tasks` (`id`, `name`, `date_start`, `date_end`, `date_reminder`, `category`, `id_fields`, `id_fields_section`, `status`, `id_season`, `id_farm`, `id_entity`, `notes`) VALUES
(2, 'Limpeza de CAnais de cultivo', '2015-04-14 21:24:55', '2015-04-22 21:24:58', '2015-04-19 00:00:00', 0, 1, 2, 'In Progress', 1, 1, 1, '<p>\r\n asdas112</p>\r\n'),
(3, 'Transplante de Plantas', '2015-01-10 00:00:00', '2015-12-15 00:00:00', '2015-05-01 00:00:00', 0, 1, 0, 'In Progress', 1, 1, 1, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `g_tasks_users`
--

CREATE TABLE IF NOT EXISTS `g_tasks_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_task` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `priority` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `g_tasks_users`
--

INSERT INTO `g_tasks_users` (`id`, `id_task`, `id_user`, `priority`, `name`) VALUES
(1, 2, 1, 2, 'Limpeza de Canais de Cultivo '),
(2, 3, 1, 1, 'Transplante de Plantas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `inventory_management`
--

CREATE TABLE IF NOT EXISTS `inventory_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_exp_detail` int(11) DEFAULT NULL,
  `id_fertilization` int(11) DEFAULT NULL,
  `id_treatment` int(11) DEFAULT NULL,
  `id_prod_consum` int(11) DEFAULT NULL,
  `type` enum('add','sub') NOT NULL,
  `date_operation` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `id_entity` int(11) NOT NULL,
  `lote` varchar(30) NOT NULL,
  `quantity` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `inventory_management`
--

INSERT INTO `inventory_management` (`id`, `id_exp_detail`, `id_fertilization`, `id_treatment`, `id_prod_consum`, `type`, `date_operation`, `id_user`, `id_entity`, `lote`, `quantity`, `name`) VALUES
(1, 17, NULL, NULL, NULL, 'add', '2015-04-30 01:04:42', 1, 1, '125495', 15, 'Banana'),
(2, 18, NULL, NULL, NULL, 'add', '2015-05-01 18:59:24', 1, 1, '', 12, 'Nitatite YARA'),
(3, 20, NULL, NULL, NULL, 'add', '2015-05-01 21:38:15', 1, 1, '', 0, ''),
(4, 21, NULL, NULL, NULL, 'add', '2015-05-01 21:38:37', 1, 1, '', 0, '');

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
-- Estrutura da tabela `problem_fieldsection`
--

CREATE TABLE IF NOT EXISTS `problem_fieldsection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_problem` int(11) NOT NULL,
  `id_fieldsection` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_entity` int(11) NOT NULL,
  `id_season` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Extraindo dados da tabela `problem_fieldsection`
--

INSERT INTO `problem_fieldsection` (`id`, `id_problem`, `id_fieldsection`, `id_user`, `id_entity`, `id_season`) VALUES
(24, 37, 36, 1, 1, 0),
(25, 37, 35, 1, 1, 0),
(26, 37, 54, 1, 1, 0),
(27, 38, 33, 1, 1, 0),
(28, 38, 54, 1, 1, 0),
(29, 38, 36, 1, 1, 0),
(30, 38, 33, 1, 1, 0),
(31, 38, 54, 1, 1, 0),
(32, 38, 36, 1, 1, 0),
(33, 38, 33, 1, 1, 0),
(34, 38, 54, 1, 1, 0),
(35, 38, 36, 1, 1, 0),
(36, 38, 35, 1, 1, 0),
(37, 38, 54, 1, 1, 0),
(38, 38, 35, 1, 1, 0),
(39, 38, 54, 1, 1, 0),
(40, 39, 33, 1, 1, 0),
(41, 39, 54, 1, 1, 0),
(42, 39, 36, 1, 1, 0),
(43, 39, 33, 1, 1, 0),
(44, 39, 54, 1, 1, 0),
(45, 39, 36, 1, 1, 0),
(46, 39, 33, 1, 1, 0),
(47, 39, 54, 1, 1, 0),
(48, 39, 36, 1, 1, 0),
(49, 39, 35, 1, 1, 0),
(50, 39, 54, 1, 1, 0),
(51, 39, 35, 1, 1, 0),
(52, 39, 54, 1, 1, 0),
(53, 40, 33, 1, 1, 0),
(54, 40, 54, 1, 1, 0),
(55, 40, 36, 1, 1, 0),
(56, 40, 33, 1, 1, 0),
(57, 40, 54, 1, 1, 0),
(58, 40, 36, 1, 1, 0),
(59, 40, 33, 1, 1, 0),
(60, 40, 54, 1, 1, 0),
(61, 40, 36, 1, 1, 0),
(62, 40, 35, 1, 1, 0),
(63, 40, 54, 1, 1, 0),
(64, 40, 35, 1, 1, 0),
(65, 40, 54, 1, 1, 0),
(66, 40, 33, 1, 1, 0),
(67, 40, 54, 1, 1, 0),
(68, 40, 54, 1, 1, 0),
(69, 40, 36, 1, 1, 0),
(70, 40, 35, 1, 1, 0),
(71, 40, 53, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_fertilization`
--

CREATE TABLE IF NOT EXISTS `prod_fertilization` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_package` varchar(20) DEFAULT NULL,
  `type` enum('NitAmonio','NitCalcio','NitMonopotassio','Ferro','MicroSER','AcidNitrico','Outro') DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(11) DEFAULT NULL,
  `water_volume` float DEFAULT NULL,
  `deposit` enum('1','2','3','4','5','6') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `notes` longtext,
  `id_user` int(11) DEFAULT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `prod_fertilization`
--

INSERT INTO `prod_fertilization` (`id`, `id_package`, `type`, `quantity`, `unit`, `water_volume`, `deposit`, `date`, `notes`, `id_user`, `id_farm`, `id_entity`) VALUES
(1, '18', 'NitMonopotassio', 12, '1', 1, '1', '2015-04-22 11:19:21', '<p>\r\n example</p>\r\n', 1, 0, 1),
(2, '18', 'Ferro', 5, 'kg', 200, '4', '2015-05-01 00:00:00', NULL, 1, 1, 1);

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
  `id_farm` int(11) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `prod_fields`
--

INSERT INTO `prod_fields` (`id`, `short_code`, `name`, `surface`, `surface_unit`, `location`, `production_id`, `cadastral_plots`, `id_farm`, `id_entity`, `notes`) VALUES
(1, 'E1', 'Estufa 1', '250', 'm2', 'Este', 0, '<p>\r\n asdasdzxcvz</p>\r\n<p>\r\n dfdsafe</p>\r\n<p>\r\n afsd</p>\r\n<p>\r\n fa</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n', 1, 1, '<p>\r\n asdasdasda</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n asd</p>\r\n'),
(2, 'E2', 'Estufa 2', '250', 'm2', 'Este 2', 0, '<p>\r\n asdasdzxcvz</p>\r\n<p>\r\n dfdsafe</p>\r\n<p>\r\n afsd</p>\r\n<p>\r\n fa</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n', 1, 1, '<p>\r\n asdasdasda</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n asd</p>\r\n'),
(3, 'E3', 'Estufa 3', '250', 'm2', 'Meio 1', 0, '<p>\r\n asdasdzxcvz</p>\r\n<p>\r\n dfdsafe</p>\r\n<p>\r\n afsd</p>\r\n<p>\r\n fa</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n', 1, 1, '<p>\r\n asdasdasda</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n asd</p>\r\n'),
(4, 'E4', 'Estufa 4', '250', 'm2', 'Meio 2', 0, '<p>\r\n asdasdzxcvz</p>\r\n<p>\r\n dfdsafe</p>\r\n<p>\r\n afsd</p>\r\n<p>\r\n fa</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n', 1, 1, '<p>\r\n asdasdasda</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n asd</p>\r\n'),
(5, 'E5', 'Estufa 5', '250', 'm2', 'Meio 1', 0, '<p>\r\n asdasdzxcvz</p>\r\n<p>\r\n dfdsafe</p>\r\n<p>\r\n afsd</p>\r\n<p>\r\n fa</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n', 1, 1, '<p>\r\n asdasdasda</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n asd</p>\r\n'),
(6, 'E6', 'Estufa 6', '250', 'm2', 'Oeste 2', 0, '<p>\r\n asdasdzxcvz</p>\r\n<p>\r\n dfdsafe</p>\r\n<p>\r\n afsd</p>\r\n<p>\r\n fa</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n', 1, 1, '<p>\r\n asdasdasda</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n asd</p>\r\n'),
(7, 'E7', 'Estufa 7', '250', 'm2', 'Oeste Extremo', 0, '<p>\r\n asdasdzxcvz</p>\r\n<p>\r\n dfdsafe</p>\r\n<p>\r\n afsd</p>\r\n<p>\r\n fa</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n', 1, 1, '<p>\r\n asdasdasda</p>\r\n<p>\r\n sd</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n as</p>\r\n<p>\r\n d</p>\r\n<p>\r\n asd</p>\r\n');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191 ;

--
-- Extraindo dados da tabela `prod_fields_sections`
--

INSERT INTO `prod_fields_sections` (`id`, `section_name`, `id_field`, `id_farm`, `id_entity`, `notes`) VALUES
(3, 'E1L1A', 1, 1, 1, ''),
(4, 'E1L1AX', 1, 1, 1, ''),
(5, 'E1L1B', 1, 1, 1, ''),
(6, 'E1L1BX', 1, 1, 1, ''),
(7, 'E1L2A', 1, 1, 1, ''),
(8, 'E1L2AX', 1, 1, 1, ''),
(9, 'E1L2B', 1, 1, 1, ''),
(10, 'E1L2BX', 1, 1, 1, ''),
(11, 'E1L3A', 1, 1, 1, ''),
(12, 'E1L3AX', 1, 1, 1, ''),
(13, 'E1L3B', 1, 1, 1, ''),
(14, 'E1L3BX', 1, 1, 1, ''),
(15, 'E1L4A', 1, 1, 1, ''),
(16, 'E1L4AX', 1, 1, 1, ''),
(17, 'E1L4B', 1, 1, 1, ''),
(18, 'E1L4BX', 1, 1, 1, ''),
(19, 'E1L5A', 1, 1, 1, ''),
(20, 'E1L5AX', 1, 1, 1, ''),
(21, 'E1L5B', 1, 1, 1, ''),
(22, 'E1L5BX', 1, 1, 1, ''),
(23, 'E2L1A', 2, 1, 1, ''),
(24, 'E2L1AX', 2, 1, 1, ''),
(25, 'E2L1B', 2, 1, 1, ''),
(26, 'E2L1BX', 2, 1, 1, ''),
(27, 'E2L1C', 2, 1, 1, ''),
(28, 'E2L1CX', 2, 1, 1, ''),
(29, 'E2L2A', 2, 1, 1, ''),
(30, 'E2L2AX', 2, 1, 1, ''),
(31, 'E2L2B', 2, 1, 1, ''),
(32, 'E2L2BX', 2, 1, 1, ''),
(33, 'E2L2C', 2, 1, 1, ''),
(34, 'E2L2CX', 2, 1, 1, ''),
(35, 'E2L3A', 2, 1, 1, ''),
(36, 'E2L3AX', 2, 1, 1, ''),
(37, 'E2L3B', 2, 1, 1, ''),
(38, 'E2L3BX', 2, 1, 1, ''),
(39, 'E2L3C', 2, 1, 1, ''),
(40, 'E2L3CX', 2, 1, 1, ''),
(41, 'E2L4A', 2, 1, 1, ''),
(42, 'E2L4AX', 2, 1, 1, ''),
(43, 'E2L4B', 2, 1, 1, ''),
(44, 'E2L4BX', 2, 1, 1, ''),
(45, 'E2L4C', 2, 1, 1, ''),
(46, 'E2L4CX', 2, 1, 1, ''),
(47, 'E3L1A', 3, 1, 1, ''),
(48, 'E3L1AX', 3, 1, 1, ''),
(49, 'E3L1B', 3, 1, 1, ''),
(50, 'E3L1BX', 3, 1, 1, ''),
(51, 'E3L1C', 3, 1, 1, ''),
(52, 'E3L1CX', 3, 1, 1, ''),
(53, 'E3L2A', 3, 1, 1, ''),
(54, 'E3L2AX', 3, 1, 1, ''),
(55, 'E3L2B', 3, 1, 1, ''),
(56, 'E3L2BX', 3, 1, 1, ''),
(57, 'E3L2C', 3, 1, 1, ''),
(58, 'E3L2CX', 3, 1, 1, ''),
(59, 'E3L3A', 3, 1, 1, ''),
(60, 'E3L3AX', 3, 1, 1, ''),
(61, 'E3L3B', 3, 1, 1, ''),
(62, 'E3L3BX', 3, 1, 1, ''),
(63, 'E3L3C', 3, 1, 1, ''),
(64, 'E3L3CX', 3, 1, 1, ''),
(65, 'E3L4A', 3, 1, 1, ''),
(66, 'E3L4AX', 3, 1, 1, ''),
(67, 'E3L4B', 3, 1, 1, ''),
(68, 'E3L4BX', 3, 1, 1, ''),
(69, 'E3L4C', 3, 1, 1, ''),
(70, 'E3L4CX', 3, 1, 1, ''),
(71, 'E3L5A', 3, 1, 1, ''),
(72, 'E3L5AX', 3, 1, 1, ''),
(73, 'E3L5B', 3, 1, 1, ''),
(74, 'E3L5BX', 3, 1, 1, ''),
(75, 'E3L5C', 3, 1, 1, ''),
(76, 'E3L5CX', 3, 1, 1, ''),
(77, 'E4L1A', 4, 1, 1, ''),
(78, 'E4L1AX', 4, 1, 1, ''),
(79, 'E4L1B', 4, 1, 1, ''),
(80, 'E4L1BX', 4, 1, 1, ''),
(81, 'E4L1C', 4, 1, 1, ''),
(82, 'E4L1CX', 4, 1, 1, ''),
(83, 'E4L2A', 4, 1, 1, ''),
(84, 'E4L2AX', 4, 1, 1, ''),
(85, 'E4L2B', 4, 1, 1, ''),
(86, 'E4L2BX', 4, 1, 1, ''),
(87, 'E4L2C', 4, 1, 1, ''),
(88, 'E4L2CX', 4, 1, 1, ''),
(89, 'E4L3A', 4, 1, 1, ''),
(90, 'E4L3AX', 4, 1, 1, ''),
(91, 'E4L3B', 4, 1, 1, ''),
(92, 'E4L3BX', 4, 1, 1, ''),
(93, 'E4L3C', 4, 1, 1, ''),
(94, 'E4L3CX', 4, 1, 1, ''),
(95, 'E4L4A', 4, 1, 1, ''),
(96, 'E4L4AX', 4, 1, 1, ''),
(97, 'E4L4B', 4, 1, 1, ''),
(98, 'E4L4BX', 4, 1, 1, ''),
(99, 'E4L4C', 4, 1, 1, ''),
(100, 'E4L4CX', 4, 1, 1, ''),
(101, 'E4L5AP', 4, 1, 1, ''),
(102, 'E4L5APX', 4, 1, 1, ''),
(103, 'E4L5BP', 4, 1, 1, ''),
(104, 'E4L5BPX', 4, 1, 1, ''),
(105, 'E4L5CP', 4, 1, 1, ''),
(106, 'E4L5CPX', 4, 1, 1, ''),
(107, 'E5L1A', 5, 1, 1, ''),
(108, 'E5L1AX', 5, 1, 1, ''),
(109, 'E5L1B', 5, 1, 1, ''),
(110, 'E5L1BX', 5, 1, 1, ''),
(111, 'E5L1C', 5, 1, 1, ''),
(112, 'E5L1CX', 5, 1, 1, ''),
(113, 'E5L2A', 5, 1, 1, ''),
(114, 'E5L2AX', 5, 1, 1, ''),
(115, 'E5L2B', 5, 1, 1, ''),
(116, 'E5L2BX', 5, 1, 1, ''),
(117, 'E5L2C', 5, 1, 1, ''),
(118, 'E5L2CX', 5, 1, 1, ''),
(119, 'E5L3A', 5, 1, 1, ''),
(120, 'E5L3AX', 5, 1, 1, ''),
(121, 'E5L3B', 5, 1, 1, ''),
(122, 'E5L3BX', 5, 1, 1, ''),
(123, 'E5L3C', 5, 1, 1, ''),
(124, 'E5L3CX', 5, 1, 1, ''),
(125, 'E5L4A', 5, 1, 1, ''),
(126, 'E5L4AX', 5, 1, 1, ''),
(127, 'E5L4B', 5, 1, 1, ''),
(128, 'E5L4BX', 5, 1, 1, ''),
(129, 'E5L4C', 5, 1, 1, ''),
(130, 'E5L4CX', 5, 1, 1, ''),
(131, 'E5L5A', 5, 1, 1, ''),
(132, 'E5L5AX', 5, 1, 1, ''),
(133, 'E5L5B', 5, 1, 1, ''),
(134, 'E5L5BX', 5, 1, 1, ''),
(135, 'E5L5C', 5, 1, 1, ''),
(136, 'E5L5CX', 5, 1, 1, ''),
(137, 'E6L1A', 6, 1, 1, ''),
(138, 'E6L1AX', 6, 1, 1, ''),
(139, 'E6L1B', 6, 1, 1, ''),
(140, 'E6L1BX', 6, 1, 1, ''),
(141, 'E6L1C', 6, 1, 1, ''),
(142, 'E6L1CX', 6, 1, 1, ''),
(143, 'E6L2A', 6, 1, 1, ''),
(144, 'E6L2AX', 6, 1, 1, ''),
(145, 'E6L2B', 6, 1, 1, ''),
(146, 'E6L2BX', 6, 1, 1, ''),
(147, 'E6L2C', 6, 1, 1, ''),
(148, 'E6L2CX', 6, 1, 1, ''),
(149, 'E6L3A', 6, 1, 1, ''),
(150, 'E6L3AX', 6, 1, 1, ''),
(151, 'E6L3B', 6, 1, 1, ''),
(152, 'E6L3BX', 6, 1, 1, ''),
(153, 'E6L3C', 6, 1, 1, ''),
(154, 'E6L3CX', 6, 1, 1, ''),
(155, 'E6L4A', 6, 1, 1, ''),
(156, 'E6L4AX', 6, 1, 1, ''),
(157, 'E6L4B', 6, 1, 1, ''),
(158, 'E6L4BX', 6, 1, 1, ''),
(159, 'E6L4C', 6, 1, 1, ''),
(160, 'E6L4CX', 6, 1, 1, ''),
(161, 'E7L1A', 7, 1, 1, ''),
(162, 'E7L1AX', 7, 1, 1, ''),
(163, 'E7L1B', 7, 1, 1, ''),
(164, 'E7L1BX', 7, 1, 1, ''),
(165, 'E7L1C', 7, 1, 1, ''),
(166, 'E7L1CX', 7, 1, 1, ''),
(167, 'E7L2A', 7, 1, 1, ''),
(168, 'E7L2AX', 7, 1, 1, ''),
(169, 'E7L2B', 7, 1, 1, ''),
(170, 'E7L2BX', 7, 1, 1, ''),
(171, 'E7L2C', 7, 1, 1, ''),
(172, 'E7L2CX', 7, 1, 1, ''),
(173, 'E7L3A', 7, 1, 1, ''),
(174, 'E7L3AX', 7, 1, 1, ''),
(175, 'E7L3B', 7, 1, 1, ''),
(176, 'E7L3BX', 7, 1, 1, ''),
(177, 'E7L3C', 7, 1, 1, ''),
(178, 'E7L3CX', 7, 1, 1, ''),
(179, 'E7L4A', 7, 1, 1, ''),
(180, 'E7L4AX', 7, 1, 1, ''),
(181, 'E7L4B', 7, 1, 1, ''),
(182, 'E7L4BX', 7, 1, 1, ''),
(183, 'E7L4C', 7, 1, 1, ''),
(184, 'E7L4CX', 7, 1, 1, ''),
(185, 'E7L5AP', 7, 1, 1, ''),
(186, 'E7L5APX', 7, 1, 1, ''),
(187, 'E7L5BP', 7, 1, 1, ''),
(188, 'E7L5BPX', 7, 1, 1, ''),
(189, 'E7L5CP', 7, 1, 1, ''),
(190, 'E7L5CPX', 7, 1, 1, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_problem_section`
--

CREATE TABLE IF NOT EXISTS `prod_problem_section` (
  `id_problem` int(11) NOT NULL,
  `id_season` int(11) NOT NULL,
  `id_field_section` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_entity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season`
--

CREATE TABLE IF NOT EXISTS `prod_season` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `id_sort` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `production_type` enum('Conventional','Organic','Integrated','Hydroponic','Other') DEFAULT NULL,
  `id_template` int(10) DEFAULT NULL,
  `expected_yeld` decimal(10,0) DEFAULT NULL,
  `expected_yeld_unit` varchar(5) DEFAULT NULL,
  `expected_income` decimal(10,0) DEFAULT NULL,
  `n_plants` int(11) DEFAULT NULL,
  `plants_spacing` decimal(10,0) DEFAULT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Extraindo dados da tabela `prod_season`
--

INSERT INTO `prod_season` (`id`, `name`, `id_sort`, `start_date`, `end_date`, `status`, `production_type`, `id_template`, `expected_yeld`, `expected_yeld_unit`, `expected_income`, `n_plants`, `plants_spacing`, `id_farm`, `id_entity`) VALUES
(1, 'Alface Frisada-01Abril2015', 1, '2015-04-01', '2015-05-15', 'Active', 'Conventional', 1, '1254', 'kg', '1524', 1000, '2', 1, 1),
(2, 'Espinafres-14Abril2015', 2, '2015-04-14', '2015-04-29', 'Active', 'Conventional', 2, '123', 'kg', '1000', 500, '1', 1, 1),
(3, 'AlfaceFrisada01Maio2015', 1, '2015-05-01', '2015-06-12', 'Active', NULL, 1, '400', 'kg', '1500', 1000, NULL, 1, 2),
(4, 'Couve', 0, '2014-11-01', '2014-12-15', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0),
(22, 'teste123', 0, '2015-06-17', '2015-07-17', 'Active', 'Organic', NULL, '54', '1.5', '25', 100, NULL, 2, 0),
(21, 'teste', 0, '2015-06-17', '2015-07-17', 'Active', 'Conventional', NULL, '54', '1.5', '25', 100, NULL, 2, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_fields_sections`
--

CREATE TABLE IF NOT EXISTS `prod_season_fields_sections` (
  `id_season` int(11) NOT NULL,
  `id_fields_section` int(11) NOT NULL,
  `state` enum('active','inactive') NOT NULL,
  `notes` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `prod_season_fields_sections`
--

INSERT INTO `prod_season_fields_sections` (`id_season`, `id_fields_section`, `state`, `notes`) VALUES
(1, 2, 'active', ''),
(1, 33, 'active', ''),
(1, 35, 'active', ''),
(1, 36, 'active', ''),
(1, 53, 'active', ''),
(1, 54, 'active', ''),
(1, 55, 'active', ''),
(21, 3, 'active', ''),
(21, 4, 'active', ''),
(21, 5, 'active', ''),
(21, 6, 'active', ''),
(21, 7, 'active', ''),
(21, 8, 'active', ''),
(21, 9, 'active', ''),
(21, 10, 'active', ''),
(21, 11, 'active', ''),
(22, 3, 'active', ''),
(22, 4, 'active', ''),
(22, 5, 'active', ''),
(22, 6, 'active', ''),
(22, 7, 'active', ''),
(22, 8, 'active', ''),
(22, 9, 'active', ''),
(22, 10, 'active', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_harvast`
--

CREATE TABLE IF NOT EXISTS `prod_season_harvast` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_season` int(10) DEFAULT NULL,
  `harv_start_date` datetime DEFAULT NULL,
  `harv_end_date` datetime DEFAULT NULL,
  `n_plants` int(20) DEFAULT NULL,
  `plants_weight_totalkg` float DEFAULT NULL,
  `plants_weight_average` float NOT NULL,
  `notes` longtext,
  `id_farm` int(10) DEFAULT NULL,
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `prod_season_harvast`
--

INSERT INTO `prod_season_harvast` (`id`, `id_season`, `harv_start_date`, `harv_end_date`, `n_plants`, `plants_weight_totalkg`, `plants_weight_average`, `notes`, `id_farm`, `id_entity`) VALUES
(1, 2, '2015-04-23 00:00:00', '2015-04-24 00:00:00', 233, 1444, 1, '<p>\r\n this is an example</p>\r\n', 1, 1),
(2, 1, NULL, NULL, NULL, NULL, 0, NULL, 2, 1),
(3, 1, NULL, NULL, NULL, NULL, 0, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_harvast_fieldsection`
--

CREATE TABLE IF NOT EXISTS `prod_season_harvast_fieldsection` (
  `id_harvast` int(10) NOT NULL,
  `id_fields_section` int(10) NOT NULL,
  `priority` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `prod_season_harvast_fieldsection`
--

INSERT INTO `prod_season_harvast_fieldsection` (`id_harvast`, `id_fields_section`, `priority`) VALUES
(1, 6, 0),
(3, 11, 0),
(3, 8, 0),
(2, 5, 0),
(2, 7, 0),
(2, 9, 0),
(1, 8, 0);

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
  `status` enum('active','solved','closed') NOT NULL,
  `description` longtext NOT NULL,
  `notes` longtext NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Extraindo dados da tabela `prod_season_problems`
--

INSERT INTO `prod_season_problems` (`id`, `id_season`, `name`, `type`, `status`, `description`, `notes`, `start_date`, `end_date`) VALUES
(1, 1, 'Podridão castanha', 'Disease', 'active', 'As plantas apresentao\r\nsds\r\nda\r\ndasdas', '12-abril - muito mau', NULL, NULL),
(2, 1, 'Rebordo Queimado', 'Other', 'active', 'Apanharam sol em demasia e ficaram com problemas nas folhas', 'sasa', NULL, NULL),
(3, 1, 'Qualquer coisa', 'Disease', 'active', 'adsa', 'dsadas', NULL, NULL),
(4, 2, 'Humidade Espinafres', 'Weed', 'closed', 'adsa', 'dsadas', NULL, NULL),
(5, 1, 'Manchas castanhas', 'Disease', 'active', 'adsa', 'dsadas', NULL, NULL),
(37, 0, 'teste', 'Disease', 'solved', 'dsadasd', 'asdasd', '2015-06-15', '2015-07-15'),
(38, 0, 'teste', 'Disease', 'solved', 'dsadasd', 'asdasd', '2015-06-15', '2015-07-15'),
(39, 0, 'teste', 'Disease', 'solved', 'dsadasd', 'asdasd', '2015-06-15', '2015-07-15'),
(40, 0, 'teste', 'Disease', 'solved', 'dsadasd', 'asdasd', '2015-06-15', '2015-07-15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_problems_actions`
--

CREATE TABLE IF NOT EXISTS `prod_season_problems_actions` (
  `id` int(10) NOT NULL,
  `id_season` int(10) NOT NULL,
  `id_problem` int(11) NOT NULL,
  `action` longtext NOT NULL,
  `type` enum('treatment','cc','vv','gg') NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `result` longtext NOT NULL,
  `notes` longtext NOT NULL,
  `efficiency` enum('0%','25%','50%','75%','100%') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_problems_actions_fieldsection`
--

CREATE TABLE IF NOT EXISTS `prod_season_problems_actions_fieldsection` (
  `id_problem_action` int(10) NOT NULL,
  `id_fieldsection` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  `priority` int(10) NOT NULL,
  `id_farm` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_season_problems_fieldsection`
--

CREATE TABLE IF NOT EXISTS `prod_season_problems_fieldsection` (
  `id_problem` int(10) DEFAULT NULL,
  `id_fields_section` int(10) NOT NULL,
  `id_entity` int(10) NOT NULL,
  `notes` longtext NOT NULL,
  `priority` int(10) NOT NULL,
  `id_farm` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `prod_season_problems_fieldsection`
--

INSERT INTO `prod_season_problems_fieldsection` (`id_problem`, `id_fields_section`, `id_entity`, `notes`, `priority`, `id_farm`) VALUES
(5, 2, 0, '', 0, 0),
(5, 5, 0, '', 0, 0),
(5, 8, 0, '', 0, 0),
(1, 2, 0, '', 0, 0),
(1, 3, 0, '', 0, 0),
(1, 4, 0, '', 0, 0),
(2, 9, 0, '', 0, 0),
(4, 9, 0, '', 0, 0),
(4, 7, 0, '', 0, 0),
(2, 6, 0, '', 0, 0),
(2, 4, 0, '', 0, 0),
(3, 9, 0, '', 0, 0),
(3, 8, 0, '', 0, 0),
(3, 4, 0, '', 0, 0),
(4, 5, 0, '', 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `prod_sorts`
--

INSERT INTO `prod_sorts` (`id`, `common_name`, `technical_name`, `id_farm`, `id_entity`, `notes`, `state`) VALUES
(1, 'Alface Frisada', 'Alface Madie Frisada 34', 1, 1, NULL, 'active'),
(2, 'Espinafres', 'Spinach TR23', 1, 1, NULL, 'active');

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
  `id_entity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_tasks` (`id_tasks`,`id_prod_actions`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `prod_template`
--

INSERT INTO `prod_template` (`id`, `name`, `id_tasks`, `id_prod_actions`, `id_entity`) VALUES
(1, 'Alface-Verão(Agosto)', 1, 1, 1),
(2, 'Espinafres-Primavera(Muito Calor)', 2, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod_treatment`
--

CREATE TABLE IF NOT EXISTS `prod_treatment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_package` int(10) NOT NULL,
  `id_problem` int(11) NOT NULL,
  `active_substance` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `recomended_dose` decimal(10,0) NOT NULL,
  `quantity_used` float NOT NULL,
  `security_interval` int(11) NOT NULL,
  `persistence` int(4) DEFAULT NULL,
  `function` enum('Fungicida','Afídeos','Ácaros','Outros') COLLATE latin1_general_ci NOT NULL,
  `id_farm` int(10) NOT NULL,
  `id_entity` int(11) NOT NULL,
  `notes` longtext COLLATE latin1_general_ci NOT NULL,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `prod_treatment`
--

INSERT INTO `prod_treatment` (`id`, `id_package`, `id_problem`, `active_substance`, `recomended_dose`, `quantity_used`, `security_interval`, `persistence`, `function`, `id_farm`, `id_entity`, `notes`, `name`) VALUES
(2, 19, 5, 'dsdasd', '10', 0.01, 12, 4, 'Fungicida', 2, 1, '', 'cabrio duo'),
(3, 19, 1, 'dasdasdas', '10', 0.01, 12, 4, 'Fungicida', 2, 1, '', 'tratamento 2'),
(4, 19, 2, 'dsdasd', '10', 0.01, 12, 4, 'Afídeos', 2, 1, '', 'tratamento 3');

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
  `type` enum('word','excel') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `rep_configuration`
--

INSERT INTO `rep_configuration` (`id`, `query_code`, `query_sql`, `title`, `template_location`, `start_line`, `title_cell`, `status`, `id_entity`, `id_farm`, `type`) VALUES
(1, 'queryFinances', 'Select id_type as Type, description AS Description, n_document AS NumberDocument, total_cost as TotalCost, date_document AS DateDocument, date_efective_payment AS PaymentDay, payment_type AS PaymentType from fin_expenses', 'All Expenses', 'C:\\Users\\Ricardo\\Desktop\\cenas.xls', 10, 'B', 'Active', 1, 1, 'excel'),
(2, 'queryRastreability', 'Select * from prod_season', 'All Seasons', 'C:\\Users\\Ricardo\\Desktop\\season.xls', 10, 'B', 'Active', 1, 1, 'excel'),
(3, 'queryFinances', 'Select id, name, email, phone, website from entitys', 'ALL entitys', 'C:\\Users\\Ricardo\\Desktop\\Template.docx', 1, 'A', 'Active', 1, 1, 'word');

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
-- Estrutura da tabela `treatment_fieldsection`
--

CREATE TABLE IF NOT EXISTS `treatment_fieldsection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_treatment` int(11) DEFAULT NULL,
  `id_problem` int(11) DEFAULT NULL,
  `id_fieldsection` int(11) DEFAULT NULL,
  `id_entity` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_season` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

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
  `id_entity` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `date_added`, `date_modified`, `id_entity`) VALUES
(1, 'admin', 'c7f5867734c1bb80892e13302d96a222e2ef25e8e0657c9d4b20e37b83e5f0af', '2015-03-10 20:31:59', '2015-03-10 20:31:59', 1),
(2, 'sandra', '49877803644619a79f3c7a650cb0a93a084111841aa682e1a962d2b954f2d6dd', '2015-04-21 11:32:57', '2015-04-21 11:32:57', 1),
(3, 'Ricardo', '6d00b36195821ad501a11f8e5c417460a5273563b036d7fcefbedcf8df7ffbae', '2015-04-21 11:32:57', '2015-04-21 11:32:57', 12);

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
