-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 14, 2023 at 05:57 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fia`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `category_abbr` varchar(5) NOT NULL,
  `category_color_text` varchar(10) NOT NULL,
  `category_color_background` varchar(10) NOT NULL,
  `category_color_hover` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_abbr`, `category_color_text`, `category_color_background`, `category_color_hover`) VALUES
(1, 'Formula 1', 'F1', '#FFFFFF', '#E10600', '#000000'),
(2, 'Formula 2', 'F2', '#FFFFFF', '#0090D0', '#004267'),
(3, 'Formula 3', 'F3', '#FFFFFF', '#E90300', '#37373F'),
(4, 'Formula E', 'FE', '#FFFFFF', '#00F', '#00005A');

-- --------------------------------------------------------

--
-- Table structure for table `constructors`
--

CREATE TABLE `constructors` (
  `constructor_id` int(11) NOT NULL,
  `constructor_name` varchar(60) NOT NULL,
  `constructor_country` int(11) NOT NULL,
  `constructor_principal_color` varchar(10) DEFAULT NULL,
  `constructor_secondary_color` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `constructors`
--

INSERT INTO `constructors` (`constructor_id`, `constructor_name`, `constructor_country`, `constructor_principal_color`, `constructor_secondary_color`) VALUES
(1, 'Alfa Romeo', 109, '#8f2d3a', '#ffffff'),
(2, 'Scuderia Ambrosiana', 109, NULL, NULL),
(3, 'Talbot-Lago', 74, '#0055a6', '#ffffff'),
(4, 'Ecurie Belge', 21, NULL, NULL),
(5, 'Maserati', 109, '#b73d47', '#ffffff'),
(6, 'Scuderia Achille Varzi', 11, NULL, NULL),
(8, 'Equipe Gordini', 74, NULL, NULL),
(10, 'Scuderia Ferrari', 109, NULL, NULL),
(11, 'Scuderia Milano', 109, NULL, NULL),
(16, 'GA Vandervell', 76, NULL, NULL),
(17, 'British Racing Motors', 76, NULL, NULL),
(18, 'OSCA Automobili', 109, NULL, NULL),
(19, 'AFM', 56, NULL, NULL),
(22, 'ERA', 76, '#577279', '#000000'),
(23, 'Ecurie Francorchamps', 21, NULL, NULL),
(27, 'Connaught Engineering', 76, NULL, NULL),
(28, 'Ecurie Ecosse', 76, NULL, NULL),
(32, 'Cooper Car Company', 76, NULL, NULL),
(36, 'EMW', 56, NULL, NULL),
(39, 'Mercedes-Benz', 56, NULL, NULL),
(40, 'Gilby Engineering', 76, NULL, NULL),
(41, 'Vanwall', 76, NULL, NULL),
(45, 'Scuderia Lancia', 109, NULL, NULL),
(46, 'Equipe Nationale Belge', 21, NULL, NULL),
(47, 'Scuderia Volpini', 109, NULL, NULL),
(48, 'Scuderia Centro Sud', 109, NULL, NULL),
(49, 'Automobiles Bugatti', 74, NULL, NULL),
(52, 'Porsche', 56, NULL, NULL),
(54, 'Ecurie Maarsbergen', 165, NULL, NULL),
(55, 'Team Lotus', 76, NULL, NULL),
(57, 'Kurtis Kraft', 230, NULL, NULL),
(58, 'Tec-Mec', 109, NULL, NULL),
(61, 'Aston Martin', 76, NULL, NULL),
(62, 'Scarab', 230, NULL, NULL),
(63, 'De Tomaso Automobili', 109, NULL, NULL),
(66, 'Lola Cars', 76, NULL, NULL),
(67, 'Brabham Racing Organisation', 76, NULL, NULL),
(69, 'Automobili Turismo e Sport', 109, NULL, NULL),
(71, 'Stebro', 38, NULL, NULL),
(72, 'British Racing Partnership', 76, NULL, NULL),
(73, 'Honda', 113, NULL, NULL),
(74, 'Shannon Racing Cars', 76, NULL, NULL),
(75, 'All American Racers', 230, NULL, NULL),
(76, 'McLaren', 76, NULL, NULL),
(77, 'Matra Sports', 74, NULL, NULL),
(78, 'Bellasi', 43, NULL, NULL),
(79, 'Tyrrell Racing', 76, NULL, NULL),
(80, 'Surtees Racing Organisation', 76, NULL, NULL),
(81, 'March Engineering', 76, NULL, NULL),
(82, 'Connew Racing Team', 76, NULL, NULL),
(83, 'Williams Racing Cars', 76, NULL, NULL),
(84, 'Tecno Racing Team', 109, NULL, NULL),
(85, 'Team Eifelland', 56, NULL, NULL),
(86, 'Ensign Racing Team', 76, NULL, NULL),
(87, 'Shadow Racing Cars', 230, NULL, NULL),
(88, 'Lyncar', 76, NULL, NULL),
(89, 'Maki Engineering', 113, NULL, NULL),
(90, 'Chris Amon Racing', 170, NULL, NULL),
(91, 'Token Racing', 76, NULL, NULL),
(92, 'Team Penske', 230, NULL, NULL),
(93, 'Trojan–Tauranac Racing', 76, NULL, NULL),
(94, 'Vel\'s Parnelli Jones Racing', 230, NULL, NULL),
(95, 'Hesketh Racing', 76, NULL, NULL),
(96, 'Oreste Berta', 11, NULL, NULL),
(97, 'Fittipaldi Automotive', 31, NULL, NULL),
(98, 'Embassy Hill Racing', 76, NULL, NULL),
(99, 'Kojima Engineering', 113, NULL, NULL),
(100, 'Boro', 165, NULL, NULL),
(101, 'Equipe Ligier', 74, NULL, NULL),
(103, 'Apollon', 43, NULL, NULL),
(104, 'Renault F1 Team', 74, NULL, NULL),
(105, 'LEC Refrigeration Racing', 76, NULL, NULL),
(106, 'Walter Wolf Racing', 38, NULL, NULL),
(107, 'Theodore Racing', 94, NULL, NULL),
(108, 'Team Merzario', 109, NULL, NULL),
(109, 'Automobiles Martini', 74, NULL, NULL),
(110, 'ATS Wheels', 56, NULL, NULL),
(111, 'Arrows G.P. International', 76, NULL, NULL),
(112, 'Kauhsen Racing Team', 56, NULL, NULL),
(113, 'Team Rebaque', 156, NULL, NULL),
(114, 'Osella Squadra Corse', 109, NULL, NULL),
(115, 'Toleman Motorsport', 76, NULL, NULL),
(116, 'RAM Racing', 76, NULL, NULL),
(117, 'Spirit Racing', 76, NULL, NULL),
(118, 'Minardi F1 Team', 109, NULL, NULL),
(119, 'Zakspeed', 56, NULL, NULL),
(120, 'Automobiles Gonfaronnaises Sportives', 74, NULL, NULL),
(121, 'Benetton Formula', 76, NULL, NULL),
(122, 'Scuderia Coloni', 109, NULL, NULL),
(123, 'EuroBrun Racing', 109, NULL, NULL),
(124, 'Dallara', 109, NULL, NULL),
(125, 'Rial Racing', 56, NULL, NULL),
(126, 'Onyx Grand Prix', 76, NULL, NULL),
(127, 'Life Racing Engines', 109, NULL, NULL),
(128, 'Leyton House Racing', 76, NULL, NULL),
(129, 'Footwork Arrows', 76, NULL, NULL),
(130, 'Fondmetal', 109, NULL, NULL),
(131, 'Modena Racing Team', 109, NULL, NULL),
(132, 'Larrousse F1', 74, NULL, NULL),
(133, 'Jordan Grand Prix', 101, NULL, NULL),
(134, 'Andrea Moda Formula', 109, NULL, NULL),
(135, 'Venturi', 74, NULL, NULL),
(136, 'Sauber Motorsport', 43, NULL, NULL),
(137, 'Pacific Racing', 76, NULL, NULL),
(138, 'Simtek', 76, NULL, NULL),
(139, 'Forti Corse', 109, NULL, NULL),
(140, 'Stewart Grand Prix', 76, NULL, NULL),
(141, 'Prost Grand Prix', 74, NULL, NULL),
(142, 'British American Racing', 76, NULL, NULL),
(143, 'Toyota Racing', 113, NULL, NULL),
(144, 'Jaguar Racing', 76, NULL, NULL),
(145, 'Red Bull Racing', 13, NULL, NULL),
(146, 'Super Aguri F1', 113, NULL, NULL),
(147, 'Midland F1 Racing', 190, NULL, NULL),
(148, 'Scuderia Toro Rosso', 109, NULL, NULL),
(149, 'BMW', 56, NULL, NULL),
(150, 'Spyker F1 Team', 165, NULL, NULL),
(151, 'Force India', 104, NULL, NULL),
(152, 'Brawn Grand Prix', 76, NULL, NULL),
(153, 'Virgin Racing', 76, NULL, NULL),
(154, 'HRT F1 Team', 67, NULL, NULL),
(155, 'Marussia F1 Team', 190, NULL, NULL),
(156, 'Caterham F1 Team', 157, NULL, NULL),
(157, 'Manor Racing', 76, NULL, NULL),
(158, 'Haas F1 Team', 230, NULL, NULL),
(159, 'Racing Point F1 Team', 76, NULL, NULL),
(160, 'Alpha Tauri', 109, NULL, NULL),
(161, 'Alpine F1 Team', 74, NULL, NULL),
(162, 'Alta Car', 76, '#1c6b4f', '#ffffff');

-- --------------------------------------------------------

--
-- Table structure for table `continents`
--

CREATE TABLE `continents` (
  `continent_code` char(2) NOT NULL COMMENT 'Continent code',
  `continent_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `continents`
--

INSERT INTO `continents` (`continent_code`, `continent_name`) VALUES
('AF', 'Africa'),
('AN', 'Antarctica'),
('AS', 'Asia'),
('EU', 'Europe'),
('NA', 'North America'),
('OC', 'Oceania'),
('SA', 'South America');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_code` char(2) NOT NULL COMMENT 'Two-letter country code',
  `country_name` varchar(64) NOT NULL COMMENT 'English country name',
  `country_continent_code` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_code`, `country_name`, `country_continent_code`) VALUES
(1, 'AD', 'Andorra', 'EU'),
(2, 'AE', 'United Arab Emirates', 'AS'),
(3, 'AF', 'Afghanistan', 'AS'),
(4, 'AG', 'Antigua and Barbuda', 'NA'),
(5, 'AI', 'Anguilla', 'NA'),
(6, 'AL', 'Albania', 'EU'),
(7, 'AM', 'Armenia', 'AS'),
(8, 'AN', 'Netherlands Antilles', 'NA'),
(9, 'AO', 'Angola', 'AF'),
(10, 'AQ', 'Antarctica', 'AN'),
(11, 'AR', 'Argentina', 'SA'),
(12, 'AS', 'American Samoa', 'OC'),
(13, 'AT', 'Austria', 'EU'),
(14, 'AU', 'Australia', 'OC'),
(15, 'AW', 'Aruba', 'NA'),
(16, 'AX', 'Åland', 'EU'),
(17, 'AZ', 'Azerbaijan', 'AS'),
(18, 'BA', 'Bosnia and Herzegovina', 'EU'),
(19, 'BB', 'Barbados', 'NA'),
(20, 'BD', 'Bangladesh', 'AS'),
(21, 'BE', 'Belgium', 'EU'),
(22, 'BF', 'Burkina Faso', 'AF'),
(23, 'BG', 'Bulgaria', 'EU'),
(24, 'BH', 'Bahrain', 'AS'),
(25, 'BI', 'Burundi', 'AF'),
(26, 'BJ', 'Benin', 'AF'),
(27, 'BL', 'Saint Barthélemy', 'NA'),
(28, 'BM', 'Bermuda', 'NA'),
(29, 'BN', 'Brunei Darussalam', 'AS'),
(30, 'BO', 'Bolivia', 'SA'),
(31, 'BR', 'Brazil', 'SA'),
(32, 'BS', 'Bahamas', 'NA'),
(33, 'BT', 'Bhutan', 'AS'),
(35, 'BW', 'Botswana', 'AF'),
(36, 'BY', 'Belarus', 'EU'),
(37, 'BZ', 'Belize', 'NA'),
(38, 'CA', 'Canada', 'NA'),
(39, 'CC', 'Cocos (Keeling) Islands', 'AS'),
(40, 'CD', 'Congo (Kinshasa)', 'AF'),
(41, 'CF', 'Central African Republic', 'AF'),
(42, 'CG', 'Congo (Brazzaville)', 'AF'),
(43, 'CH', 'Switzerland', 'EU'),
(44, 'CI', 'Côte d\'Ivoire', 'AF'),
(45, 'CK', 'Cook Islands', 'OC'),
(46, 'CL', 'Chile', 'SA'),
(47, 'CM', 'Cameroon', 'AF'),
(48, 'CN', 'China', 'AS'),
(49, 'CO', 'Colombia', 'SA'),
(50, 'CR', 'Costa Rica', 'NA'),
(51, 'CU', 'Cuba', 'NA'),
(52, 'CV', 'Cape Verde', 'AF'),
(53, 'CX', 'Christmas Island', 'AS'),
(54, 'CY', 'Cyprus', 'AS'),
(55, 'CZ', 'Czech Republic', 'EU'),
(56, 'DE', 'Germany', 'EU'),
(57, 'DJ', 'Djibouti', 'AF'),
(58, 'DK', 'Denmark', 'EU'),
(59, 'DM', 'Dominica', 'NA'),
(60, 'DO', 'Dominican Republic', 'NA'),
(61, 'DZ', 'Algeria', 'AF'),
(62, 'EC', 'Ecuador', 'SA'),
(63, 'EE', 'Estonia', 'EU'),
(64, 'EG', 'Egypt', 'AF'),
(65, 'EH', 'Western Sahara', 'AF'),
(66, 'ER', 'Eritrea', 'AF'),
(67, 'ES', 'Spain', 'EU'),
(68, 'ET', 'Ethiopia', 'AF'),
(69, 'FI', 'Finland', 'EU'),
(70, 'FJ', 'Fiji', 'OC'),
(71, 'FK', 'Falkland Islands', 'SA'),
(72, 'FM', 'Micronesia', 'OC'),
(73, 'FO', 'Faroe Islands', 'EU'),
(74, 'FR', 'France', 'EU'),
(75, 'GA', 'Gabon', 'AF'),
(76, 'GB', 'United Kingdom', 'EU'),
(77, 'GD', 'Grenada', 'NA'),
(78, 'GE', 'Georgia', 'AS'),
(79, 'GF', 'French Guiana', 'SA'),
(80, 'GG', 'Guernsey', 'EU'),
(81, 'GH', 'Ghana', 'AF'),
(82, 'GI', 'Gibraltar', 'EU'),
(83, 'GL', 'Greenland', 'NA'),
(84, 'GM', 'Gambia', 'AF'),
(85, 'GN', 'Guinea', 'AF'),
(87, 'GQ', 'Equatorial Guinea', 'AF'),
(88, 'GR', 'Greece', 'EU'),
(89, 'GS', 'South Georgia and South Sandwich Islands', 'AN'),
(90, 'GT', 'Guatemala', 'NA'),
(91, 'GU', 'Guam', 'OC'),
(92, 'GW', 'Guinea-Bissau', 'AF'),
(93, 'GY', 'Guyana', 'SA'),
(94, 'HK', 'Hong Kong', 'AS'),
(96, 'HN', 'Honduras', 'NA'),
(97, 'HR', 'Croatia', 'EU'),
(98, 'HT', 'Haiti', 'NA'),
(99, 'HU', 'Hungary', 'EU'),
(100, 'ID', 'Indonesia', 'AS'),
(101, 'IE', 'Ireland', 'EU'),
(102, 'IL', 'Israel', 'AS'),
(103, 'IM', 'Isle of Man', 'EU'),
(104, 'IN', 'India', 'AS'),
(106, 'IQ', 'Iraq', 'AS'),
(107, 'IR', 'Iran', 'AS'),
(108, 'IS', 'Iceland', 'EU'),
(109, 'IT', 'Italy', 'EU'),
(110, 'JE', 'Jersey', 'EU'),
(111, 'JM', 'Jamaica', 'NA'),
(112, 'JO', 'Jordan', 'AS'),
(113, 'JP', 'Japan', 'AS'),
(114, 'KE', 'Kenya', 'AF'),
(115, 'KG', 'Kyrgyzstan', 'AS'),
(116, 'KH', 'Cambodia', 'AS'),
(117, 'KI', 'Kiribati', 'OC'),
(118, 'KM', 'Comoros', 'AF'),
(119, 'KN', 'Saint Kitts and Nevis', 'NA'),
(120, 'KP', 'Korea, North', 'AS'),
(121, 'KR', 'Korea, South', 'AS'),
(122, 'KW', 'Kuwait', 'AS'),
(123, 'KY', 'Cayman Islands', 'NA'),
(124, 'KZ', 'Kazakhstan', 'AS'),
(125, 'LA', 'Laos', 'AS'),
(126, 'LB', 'Lebanon', 'AS'),
(127, 'LC', 'Saint Lucia', 'NA'),
(128, 'LI', 'Liechtenstein', 'EU'),
(129, 'LK', 'Sri Lanka', 'AS'),
(130, 'LR', 'Liberia', 'AF'),
(131, 'LS', 'Lesotho', 'AF'),
(132, 'LT', 'Lithuania', 'EU'),
(133, 'LU', 'Luxembourg', 'EU'),
(134, 'LV', 'Latvia', 'EU'),
(135, 'LY', 'Libya', 'AF'),
(136, 'MA', 'Morocco', 'AF'),
(137, 'MC', 'Monaco', 'EU'),
(138, 'MD', 'Moldova', 'EU'),
(139, 'ME', 'Montenegro', 'EU'),
(140, 'MF', 'Saint Martin (French part)', 'NA'),
(141, 'MG', 'Madagascar', 'AF'),
(142, 'MH', 'Marshall Islands', 'OC'),
(143, 'MK', 'Macedonia', 'EU'),
(144, 'ML', 'Mali', 'AF'),
(145, 'MM', 'Myanmar', 'AS'),
(146, 'MN', 'Mongolia', 'AS'),
(147, 'MO', 'Macau', 'AS'),
(148, 'MP', 'Northern Mariana Islands', 'OC'),
(149, 'MQ', 'Martinique', 'NA'),
(150, 'MR', 'Mauritania', 'AF'),
(151, 'MS', 'Montserrat', 'NA'),
(152, 'MT', 'Malta', 'EU'),
(153, 'MU', 'Mauritius', 'AF'),
(154, 'MV', 'Maldives', 'AS'),
(155, 'MW', 'Malawi', 'AF'),
(156, 'MX', 'Mexico', 'NA'),
(157, 'MY', 'Malaysia', 'AS'),
(158, 'MZ', 'Mozambique', 'AF'),
(159, 'NA', 'Namibia', 'AF'),
(160, 'NC', 'New Caledonia', 'OC'),
(161, 'NE', 'Niger', 'AF'),
(162, 'NF', 'Norfolk Island', 'OC'),
(163, 'NG', 'Nigeria', 'AF'),
(164, 'NI', 'Nicaragua', 'NA'),
(165, 'NL', 'Netherlands', 'EU'),
(166, 'NO', 'Norway', 'EU'),
(167, 'NP', 'Nepal', 'AS'),
(168, 'NR', 'Nauru', 'OC'),
(169, 'NU', 'Niue', 'OC'),
(170, 'NZ', 'New Zealand', 'OC'),
(171, 'OM', 'Oman', 'AS'),
(172, 'PA', 'Panama', 'NA'),
(173, 'PE', 'Peru', 'SA'),
(174, 'PF', 'French Polynesia', 'OC'),
(175, 'PG', 'Papua New Guinea', 'OC'),
(176, 'PH', 'Philippines', 'AS'),
(177, 'PK', 'Pakistan', 'AS'),
(178, 'PL', 'Poland', 'EU'),
(180, 'PN', 'Pitcairn', 'OC'),
(181, 'PR', 'Puerto Rico', 'NA'),
(182, 'PS', 'Palestine', 'AS'),
(183, 'PT', 'Portugal', 'EU'),
(184, 'PW', 'Palau', 'OC'),
(185, 'PY', 'Paraguay', 'SA'),
(186, 'QA', 'Qatar', 'AS'),
(188, 'RO', 'Romania', 'EU'),
(189, 'RS', 'Serbia', 'EU'),
(190, 'RU', 'Russian Federation', 'EU'),
(191, 'RW', 'Rwanda', 'AF'),
(192, 'SA', 'Saudi Arabia', 'AS'),
(193, 'SB', 'Solomon Islands', 'OC'),
(194, 'SC', 'Seychelles', 'AF'),
(195, 'SD', 'Sudan', 'AF'),
(196, 'SE', 'Sweden', 'EU'),
(197, 'SG', 'Singapore', 'AS'),
(198, 'SH', 'Saint Helena', 'AF'),
(199, 'SI', 'Slovenia', 'EU'),
(201, 'SK', 'Slovakia', 'EU'),
(202, 'SL', 'Sierra Leone', 'AF'),
(203, 'SM', 'San Marino', 'EU'),
(204, 'SN', 'Senegal', 'AF'),
(205, 'SO', 'Somalia', 'AF'),
(206, 'SR', 'Suriname', 'SA'),
(207, 'ST', 'Sao Tome and Principe', 'AF'),
(208, 'SV', 'El Salvador', 'NA'),
(209, 'SY', 'Syria', 'AS'),
(210, 'SZ', 'Swaziland', 'AF'),
(211, 'TC', 'Turks and Caicos Islands', 'NA'),
(212, 'TD', 'Chad', 'AF'),
(213, 'TF', 'French Southern Lands', 'AN'),
(214, 'TG', 'Togo', 'AF'),
(215, 'TH', 'Thailand', 'AS'),
(216, 'TJ', 'Tajikistan', 'AS'),
(217, 'TK', 'Tokelau', 'OC'),
(218, 'TL', 'Timor-Leste', 'AS'),
(219, 'TM', 'Turkmenistan', 'AS'),
(220, 'TN', 'Tunisia', 'AF'),
(221, 'TO', 'Tonga', 'OC'),
(222, 'TR', 'Turkey', 'AS'),
(223, 'TT', 'Trinidad and Tobago', 'NA'),
(224, 'TV', 'Tuvalu', 'OC'),
(225, 'TW', 'Taiwan', 'AS'),
(226, 'TZ', 'Tanzania', 'AF'),
(227, 'UA', 'Ukraine', 'EU'),
(228, 'UG', 'Uganda', 'AF'),
(230, 'US', 'United States of America', 'NA'),
(231, 'UY', 'Uruguay', 'SA'),
(232, 'UZ', 'Uzbekistan', 'AS'),
(233, 'VA', 'Vatican City', 'EU'),
(234, 'VC', 'Saint Vincent and the Grenadines', 'NA'),
(235, 'VE', 'Venezuela', 'SA'),
(236, 'VG', 'Virgin Islands, British', 'NA'),
(237, 'VI', 'Virgin Islands, U.S.', 'NA'),
(238, 'VN', 'Vietnam', 'AS'),
(239, 'VU', 'Vanuatu', 'OC'),
(240, 'WF', 'Wallis and Futuna Islands', 'OC'),
(241, 'WS', 'Samoa', 'OC'),
(242, 'YE', 'Yemen', 'AS'),
(243, 'YT', 'Mayotte', 'AF'),
(244, 'ZA', 'South Africa', 'AF'),
(245, 'ZM', 'Zambia', 'AF'),
(246, 'ZW', 'Zimbabwe', 'AF');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `driver_name` varchar(30) NOT NULL,
  `driver_lastname` varchar(30) NOT NULL,
  `driver_country` int(11) NOT NULL,
  `driver_birthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `driver_name`, `driver_lastname`, `driver_country`, `driver_birthday`) VALUES
(1, 'Adolf', 'Brudes', 56, '1899-10-15'),
(2, 'Adolfo', 'Schwelm-Cruz', 11, '1923-06-28'),
(3, 'Adrián', 'Campos', 67, '1960-06-17'),
(4, 'Adrian', 'Sutil', 56, '1983-01-11'),
(5, 'Aguri', 'Suzuki', 113, '1960-09-08'),
(6, 'Al', 'Pease', 38, '1921-10-15'),
(7, 'Alain', 'de Changy', 21, '1922-02-05'),
(8, 'Alain', 'Prost', 74, '1955-02-24'),
(9, 'Alan', 'Brown', 76, '1919-11-20'),
(10, 'Alan', 'Jones', 14, '1946-11-02'),
(11, 'Alan', 'Rees', 76, '1938-01-12'),
(12, 'Alan', 'Rollinson', 76, '1943-05-15'),
(13, 'Alan', 'Stacey', 76, '1933-08-29'),
(14, 'Albert', 'Scherrer', 43, '1908-02-28'),
(15, 'Alberto', 'Ascari', 109, '1918-07-13'),
(16, 'Alberto', 'Colombo', 109, '1946-02-23'),
(17, 'Alberto', 'Rodriguez Larreta', 11, '1934-01-14'),
(18, 'Alberto', 'Uria', 231, '1924-07-11'),
(19, 'Alberto Augusto', 'Crespo', 11, '1920-09-03'),
(20, 'Aldo', 'Gordini', 74, '1921-05-20'),
(21, 'Alejandro', 'De Tomaso', 11, '1928-07-10'),
(22, 'Alessandro', 'Nannini', 109, '1959-07-07'),
(23, 'Alessandro', 'Pesenti-Rossi', 109, '1942-08-31'),
(24, 'Alex', 'Caffi', 109, '1964-03-18'),
(25, 'Alex', 'Ribeiro', 31, '1948-11-07'),
(26, 'Alex', 'Soler-Roig', 67, '1932-10-29'),
(27, 'Alex', 'Yoong', 157, '1976-07-20'),
(28, 'Alex', 'Zanardi', 109, '1966-10-23'),
(29, 'Alexander', 'Albon', 215, '1996-03-23'),
(30, 'Alexander', 'Rossi', 230, '1991-09-25'),
(31, 'Alexander', 'Wurz', 13, '1974-02-15'),
(32, 'Alfonso', 'de Portago', 67, '1928-10-11'),
(33, 'Alfonso', 'Thiele', 230, '1920-04-05'),
(34, 'Alfredo', 'Pián', 11, '1912-10-21'),
(35, 'Allan', 'McNish', 76, '1969-12-29'),
(36, 'Allen', 'Berg', 38, '1961-08-01'),
(37, 'André', 'Guelfi', 74, '1919-03-06'),
(38, 'André', 'Lotterer', 56, '1981-11-19'),
(39, 'André', 'Milhoux', 21, '1928-12-09'),
(40, 'André', 'Pilette', 21, '1918-10-06'),
(41, 'André', 'Simon', 74, '1920-01-05'),
(42, 'André', 'Testut', 137, '1926-04-13'),
(43, 'Andrea', 'Chiesa', 43, '1964-05-06'),
(44, 'Andrea', 'de Adamich', 109, '1941-10-03'),
(45, 'Andrea', 'de Cesaris', 109, '1959-05-31'),
(46, 'Andrea', 'Montermini', 109, '1964-05-30'),
(47, 'Andy', 'Sutcliffe', 76, '1947-05-09'),
(48, 'Anthony', 'Davidson', 76, '1979-04-18'),
(49, 'Antonio', 'Creus', 67, '1924-10-28'),
(50, 'Antonio', 'Giovinazzi', 109, '1993-12-14'),
(51, 'Antonio', 'Pizzonia', 31, '1980-09-11'),
(52, 'Archie', 'Scott Brown', 76, '1927-05-13'),
(53, 'Arthur', 'Legat', 21, '1898-11-01'),
(54, 'Arthur', 'Owen', 76, '1915-03-23'),
(55, 'Arturo', 'Merzario', 109, '1943-03-11'),
(56, 'Asdrúbal', 'Fontes Bayardo', 231, '1922-12-26'),
(57, 'Ayrton', 'Senna', 31, '1960-03-21'),
(58, 'Basil', 'van Rooyen', 244, '1939-04-19'),
(59, 'Ben', 'Pon', 165, '1936-12-09'),
(60, 'Beppe', 'Gabbiani', 109, '1957-01-02'),
(61, 'Bernard', 'Collomb', 74, '1930-10-07'),
(62, 'Bernard', 'de Dryver', 21, '1952-09-19'),
(63, 'Bernd', 'Schneider', 56, '1964-07-20'),
(64, 'Bernie', 'Ecclestone', 76, '1930-10-28'),
(65, 'Bertil', 'Roos', 196, '1943-10-12'),
(66, 'Bertrand', 'Gachot', 21, '1962-12-23'),
(67, 'Bill', 'Aston', 76, '1900-03-29'),
(68, 'Bill', 'Brack', 38, '1935-12-26'),
(69, 'Bill', 'Moss', 76, '1933-09-04'),
(70, 'Bill', 'Whitehouse', 76, '1909-04-01'),
(71, 'Birabongse', 'Bhanudej', 215, '1914-07-15'),
(72, 'Bob', 'Anderson', 76, '1931-05-19'),
(73, 'Bob', 'Bondurant', 230, '1933-04-27'),
(74, 'Bob', 'Drake', 230, '1919-12-14'),
(75, 'Bob', 'Evans', 76, '1947-06-11'),
(76, 'Bob', 'Gerard', 76, '1914-01-19'),
(77, 'Bob', 'Hayje', 165, '1949-05-03'),
(78, 'Bob', 'Said', 230, '1932-05-05'),
(79, 'Bobby', 'Rahal', 230, '1953-01-10'),
(80, 'Bobby', 'Unser', 230, '1934-02-20'),
(81, 'Brausch', 'Niemann', 244, '1939-01-07'),
(82, 'Brendon', 'Hartley', 170, '1989-11-10'),
(83, 'Brett', 'Lunger', 230, '1945-11-14'),
(84, 'Brian', 'Gubby', 76, '1934-04-17'),
(85, 'Brian', 'Hart', 76, '1936-09-07'),
(86, 'Brian', 'Henton', 76, '1946-09-19'),
(87, 'Brian', 'McGuire', 14, '1945-12-13'),
(88, 'Brian', 'Naylor', 76, '1923-03-24'),
(89, 'Brian', 'Redman', 76, '1937-03-09'),
(90, 'Brian', 'Shawe-Taylor', 76, '1915-01-28'),
(91, 'Bruce', 'Halford', 76, '1931-05-18'),
(92, 'Bruce', 'Johnstone', 244, '1937-01-30'),
(93, 'Bruce', 'Kessler', 230, '1936-03-26'),
(94, 'Bruce', 'McLaren', 170, '1937-08-30'),
(95, 'Bruno', 'Giacomelli', 109, '1952-09-10'),
(96, 'Bruno', 'Senna', 31, '1983-10-15'),
(97, 'Carel', 'Godin de Beaufort', 165, '1934-04-10'),
(98, 'Carlo', 'Facetti', 109, '1935-06-26'),
(99, 'Carlo \"Gimax\"', 'Franchi', 109, '1938-01-01'),
(100, 'Carlos', 'Pace', 31, '1944-10-06'),
(101, 'Carlos', 'Reutemann', 11, '1942-04-12'),
(102, 'Carlos', 'Sainz Jr.', 67, '1994-09-01'),
(103, 'Carlos Alberto', 'Menditeguy', 11, '1915-08-10'),
(104, 'Carroll', 'Shelby', 230, '1923-01-11'),
(105, 'Cesare', 'Perdisa', 109, '1932-10-20'),
(106, 'Charles', 'de Tornaco', 21, '1927-06-07'),
(107, 'Charles', 'Leclerc', 137, '1997-10-16'),
(108, 'Charles', 'Pic', 74, '1990-02-15'),
(109, 'Charles', 'Pozzi', 74, '1909-08-27'),
(110, 'Chico', 'Landi', 31, '1907-07-14'),
(111, 'Chico', 'Serra', 31, '1957-02-03'),
(112, 'Chris', 'Amon', 170, '1943-07-20'),
(113, 'Chris', 'Bristow', 76, '1937-12-02'),
(114, 'Chris', 'Craft', 76, '1939-11-17'),
(115, 'Chris', 'Irwin', 76, '1942-06-27'),
(116, 'Chris', 'Lawrence', 76, '1933-07-27'),
(117, 'Christian', 'Danner', 56, '1958-04-04'),
(118, 'Christian', 'Fittipaldi', 31, '1971-01-18'),
(119, 'Christian', 'Goethals', 21, '1928-08-04'),
(120, 'Christian', 'Klien', 13, '1983-02-07'),
(121, 'Christijan', 'Albers', 165, '1979-04-16'),
(122, 'Christophe', 'Bouchut', 74, '1966-09-24'),
(123, 'Chuck', 'Daigh', 230, '1923-11-29'),
(124, 'Claudio', 'Langes', 109, '1961-08-04'),
(125, 'Clay', 'Regazzoni', 43, '1939-09-05'),
(126, 'Clemar', 'Bucci', 11, '1920-09-04'),
(127, 'Clemente', 'Biondetti', 109, '1898-10-18'),
(128, 'Cliff', 'Allison', 76, '1932-02-08'),
(129, 'Clive', 'Puzey', 246, '1941-07-11'),
(130, 'Colin', 'Chapman', 76, '1928-05-19'),
(131, 'Colin', 'Davis', 76, '1933-07-29'),
(132, 'Conny', 'Andersson', 196, '1939-12-28'),
(133, 'Consalvo', 'Sanesi', 109, '1911-03-29'),
(134, 'Corrado', 'Fabi', 109, '1961-04-12'),
(135, 'Cristiano', 'da Matta', 31, '1973-09-19'),
(136, 'Cuth', 'Harrison', 76, '1906-07-06'),
(137, 'Damien', 'Magee', 76, '1945-11-17'),
(138, 'Damon', 'Hill', 76, '1960-09-17'),
(139, 'Dan', 'Gurney', 230, '1931-04-13'),
(140, 'Daniel', 'Ricciardo', 14, '1989-07-01'),
(141, 'Daniil', 'Kvyat', 190, '1994-04-26'),
(142, 'Danny', 'Ongais', 230, '1942-05-21'),
(143, 'Danny', 'Sullivan', 230, '1950-03-09'),
(144, 'Dave', 'Charlton', 244, '1936-10-27'),
(145, 'Dave', 'Morgan', 76, '1944-08-07'),
(146, 'David', 'Brabham', 14, '1965-09-05'),
(147, 'David', 'Coulthard', 76, '1971-03-27'),
(148, 'David', 'Hampshire', 76, '1917-12-29'),
(149, 'David', 'Hobbs', 76, '1939-06-09'),
(150, 'David', 'Kennedy', 101, '1953-01-15'),
(151, 'David', 'Murray', 76, '1909-12-28'),
(152, 'David', 'Piper', 76, '1930-12-02'),
(153, 'David', 'Prophet', 76, '1937-10-09'),
(154, 'David', 'Purley', 76, '1945-01-26'),
(155, 'David', 'Walker', 14, '1941-06-10'),
(156, 'Dennis', 'Poore', 76, '1916-08-19'),
(157, 'Dennis', 'Taylor', 76, '1921-06-12'),
(158, 'Denny', 'Hulme', 170, '1936-06-18'),
(159, 'Derek', 'Bell', 76, '1941-10-31'),
(160, 'Derek', 'Daly', 101, '1953-03-11'),
(161, 'Derek', 'Warwick', 76, '1954-08-27'),
(162, 'Desiré', 'Wilson', 244, '1953-11-26'),
(163, 'Desmond', 'Titterington', 76, '1928-05-01'),
(164, 'Dick', 'Gibson', 76, '1918-04-16'),
(165, 'Didier', 'Pironi', 74, '1952-03-26'),
(166, 'Dieter', 'Quester', 13, '1939-05-30'),
(167, 'Divina', 'Galica', 76, '1944-08-13'),
(168, 'Domenico', 'Schattarella', 109, '1967-11-17'),
(169, 'Don', 'Beauman', 76, '1928-07-26'),
(170, 'Dorino', 'Serafini', 109, '1909-07-22'),
(171, 'Doug', 'Serrurier', 244, '1920-12-09'),
(172, 'Dries', 'van der Lof', 165, '1919-08-23'),
(173, 'Duncan', 'Hamilton', 76, '1920-04-30'),
(174, 'Eddie', 'Cheever', 230, '1958-01-10'),
(175, 'Eddie', 'Irvine', 76, '1965-11-10'),
(176, 'Eddie', 'Keizan', 244, '1944-09-12'),
(177, 'Edgar', 'Barth', 56, '1917-01-26'),
(178, 'Elie', 'Bayol', 74, '1914-02-28'),
(179, 'Elio', 'de Angelis', 109, '1958-03-26'),
(180, 'Eliseo', 'Salazar', 46, '1954-11-14'),
(181, 'Emanuele', 'Naspetti', 109, '1968-02-24'),
(182, 'Emanuele', 'Pirro', 109, '1962-01-12'),
(183, 'Emerson', 'Fittipaldi', 31, '1946-12-12'),
(184, 'Emilio', 'de Villota', 67, '1946-07-26'),
(185, 'Emilio', 'Zapico', 67, '1944-05-27'),
(186, 'Emmanuel', 'de Graffenried', 43, '1914-05-18'),
(187, 'Enrico', 'Bertaggia', 109, '1964-09-19'),
(188, 'Enrique', 'Bernoldi', 31, '1978-10-12'),
(189, 'Eppie', 'Wietzes', 38, '1938-05-28'),
(190, 'Eric', 'Bernard', 74, '1964-08-24'),
(191, 'Eric', 'Brandon', 76, '1920-07-18'),
(192, 'Eric', 'Thompson', 76, '1919-11-04'),
(193, 'Eric', 'van de Poele', 21, '1961-09-30'),
(194, 'Erik', 'Comas', 74, '1963-09-28'),
(195, 'Ernesto', 'Brambilla', 109, '1934-01-31'),
(196, 'Ernesto', 'Prinoth', 109, '1923-04-15'),
(197, 'Ernie', 'Pieterse', 244, '1938-07-04'),
(198, 'Ernst', 'Klodwig', 56, '1903-05-23'),
(199, 'Ernst', 'Loof', 56, '1907-07-04'),
(200, 'Erwin', 'Bauer', 56, '1912-07-17'),
(201, 'Esteban', 'Gutiérrez', 156, '1991-08-05'),
(202, 'Esteban', 'Ocon', 74, '1996-09-17'),
(203, 'Esteban', 'Tuero', 11, '1978-04-22'),
(204, 'Etiel', 'Cantoni', 231, '1906-10-04'),
(205, 'Ettore', 'Chimeri', 235, '1921-06-04'),
(206, 'Eugene', 'Chaboud', 74, '1907-04-12'),
(207, 'Eugene', 'Martin', 74, '1915-03-24'),
(208, 'Eugenio', 'Castelloti', 109, '1930-10-10'),
(209, 'Fabrizio', 'Barbazza', 109, '1963-04-02'),
(210, 'Felice', 'Bonetto', 109, '1903-06-09'),
(211, 'Felipe', 'Massa', 31, '1981-04-25'),
(212, 'Felipe', 'Nasr', 31, '1992-08-21'),
(213, 'Fernando', 'Alonso', 67, '1981-07-29'),
(214, 'Francisco', 'Godia', 67, '1921-03-21'),
(215, 'Franck', 'Lagorce', 74, '1968-09-01'),
(216, 'Franck', 'Montagny', 74, '1978-01-05'),
(217, 'Franco', 'Comotti', 109, '1906-07-24'),
(218, 'Franco', 'Forini', 43, '1958-09-22'),
(219, 'Franco', 'Rol', 109, '1908-06-05'),
(220, 'Francois', 'Cevert', 74, '1944-02-25'),
(221, 'Francois', 'Hesnault', 74, '1956-12-30'),
(222, 'Francois', 'Mazet', 74, '1943-02-24'),
(223, 'Francois', 'Migault', 74, '1944-12-04'),
(224, 'Francois', 'Picard', 74, '1921-04-26'),
(225, 'Frank', 'Dochnal', 230, '1920-10-08'),
(226, 'Frank', 'Gardner', 14, '1931-10-01'),
(227, 'Fred', 'Gamble', 230, '1932-03-17'),
(228, 'Fred', 'Wacker', 230, '1918-07-10'),
(229, 'Fritz', 'd\'Orey', 31, '1938-03-25'),
(230, 'Fritz', 'Riess', 56, '1922-07-11'),
(231, 'Gabriele', 'Tarquini', 109, '1962-03-02'),
(232, 'Gaetano', 'Starrabba', 109, '1932-12-03'),
(233, 'Gary', 'Brabham', 14, '1961-03-29'),
(234, 'Gastón', 'Mazzacane', 11, '1975-05-08'),
(235, 'Geoff', 'Lees', 76, '1951-05-01'),
(236, 'Geoffrey', 'Crossley', 76, '1921-05-11'),
(237, 'George', 'Abecassis', 76, '1913-03-21'),
(238, 'George', 'Constantine', 230, '1918-02-22'),
(239, 'George', 'Eaton', 38, '1945-11-12'),
(240, 'George', 'Follmer', 230, '1934-01-27'),
(241, 'George', 'Russell', 76, '1998-02-15'),
(242, 'Georges', 'Berger', 21, '1918-09-14'),
(243, 'Georges', 'Grignard', 74, '1905-07-25'),
(244, 'Gérard', 'Larrousse', 74, '1940-05-23'),
(245, 'Gerhard', 'Berger', 13, '1959-08-27'),
(246, 'Gerhard', 'Mitter', 56, '1935-08-30'),
(247, 'Gerino', 'Gerini', 109, '1928-08-10'),
(248, 'Gerry', 'Ashmore', 76, '1936-07-25'),
(249, 'Giacomo \"Geki\"', 'Russo', 109, '1937-10-23'),
(250, 'Giancarlo', 'Baghetti', 109, '1934-12-25'),
(251, 'Giancarlo', 'Fisichella', 109, '1973-01-14'),
(252, 'Gianfranco', 'Brancatelli', 109, '1950-01-18'),
(253, 'Gianmaria', 'Bruni', 109, '1981-05-30'),
(254, 'Gianni', 'Morbidelli', 109, '1968-01-13'),
(255, 'Giedo', 'van der Garde', 165, '1985-04-25'),
(256, 'Gijs', 'van Lennep', 165, '1942-03-16'),
(257, 'Gilles', 'Villeneuve', 38, '1950-01-18'),
(258, 'Gino', 'Bianco', 31, '1916-06-22'),
(259, 'Gino', 'Munaron', 109, '1928-04-02'),
(260, 'Giorgio', 'Bassi', 109, '1934-01-20'),
(261, 'Giorgio', 'Francia', 109, '1947-11-08'),
(262, 'Giorgio', 'Pantano', 109, '1979-02-04'),
(263, 'Giorgio', 'Scarlatti', 109, '1921-10-02'),
(264, 'Giovanna', 'Amati', 109, '1959-07-20'),
(265, 'Giovanni', 'de Riu', 109, '1925-03-10'),
(266, 'Giovanni', 'Lavaggi', 109, '1958-02-18'),
(267, 'Giulio', 'Cabianca', 109, '1923-02-19'),
(268, 'Giuseppe', 'Farina', 109, '1906-10-30'),
(269, 'Graham', 'Hill', 76, '1929-02-15'),
(270, 'Graham', 'McRae', 170, '1940-03-05'),
(271, 'Graham', 'Whitehead', 76, '1922-04-15'),
(272, 'Gregor', 'Foitek', 43, '1965-03-27'),
(273, 'Guerino', 'Bertocchi', 109, '1907-10-29'),
(274, 'Gunnar', 'Nilsson', 196, '1948-11-20'),
(275, 'Gunther', 'Bechem', 56, '1921-12-21'),
(276, 'Gunther', 'Seiffert', 56, '1937-10-18'),
(277, 'Guy', 'Edwards', 76, '1942-12-30'),
(278, 'Guy', 'Hutchison', 230, '1937-04-26'),
(279, 'Guy', 'Ligier', 74, '1930-07-12'),
(280, 'Guy', 'Mairesse', 74, '1910-08-10'),
(281, 'Guy', 'Tunmer', 244, '1948-12-01'),
(282, 'Hans', 'Binder', 13, '1948-06-12'),
(283, 'Hans', 'Hayer', 56, '1943-03-16'),
(284, 'Hans', 'Herrmann', 56, '1928-02-23'),
(285, 'Hans', 'Klenk', 56, '1919-10-28'),
(286, 'Hans', 'Stuck', 56, '1900-12-27'),
(287, 'Hans-Joachim', 'Stuck', 56, '1951-01-01'),
(288, 'Hap', 'Sharp', 230, '1928-01-01'),
(289, 'Harald', 'Ertl', 13, '1948-08-31'),
(290, 'Harry', 'Blanchard', 230, '1929-01-13'),
(291, 'Harry', 'Merkel', 56, '1918-01-10'),
(292, 'Harry', 'Schell', 230, '1921-06-29'),
(293, 'Héctor', 'Rebaque', 156, '1956-02-05'),
(294, 'Heikki', 'Kovalainen', 69, '1981-10-19'),
(295, 'Heini', 'Walter', 43, '1927-07-28'),
(296, 'Heinz', 'Schiller', 43, '1930-01-25'),
(297, 'Heinz-Harald', 'Frentzen', 56, '1967-05-18'),
(298, 'Helmunt', 'Glockler', 56, '1909-01-13'),
(299, 'Helmut', 'Marko', 13, '1943-04-27'),
(300, 'Helmut', 'Niedermayr', 56, '1915-11-29'),
(301, 'Helmuth', 'Koinigg', 13, '1948-11-03'),
(302, 'Henri', 'Louveau', 74, '1910-01-25'),
(303, 'Henri', 'Pescarolo', 74, '1942-09-25'),
(304, 'Henry', 'Taylor', 76, '1932-12-16'),
(305, 'Herbert', 'MacKay-Fraser', 230, '1922-06-23'),
(306, 'Hermann', 'Lang', 56, '1909-04-06'),
(307, 'Hermano', 'da Silva Ramos', 31, '1925-12-07'),
(308, 'Hideki', 'Noda', 113, '1969-03-07'),
(309, 'Hiroshi', 'Fushida', 113, '1946-03-10'),
(310, 'Horace', 'Gould', 76, '1918-09-20'),
(311, 'Howden', 'Ganley', 170, '1941-12-24'),
(312, 'Hubert', 'Hahne', 56, '1935-03-28'),
(313, 'Huub', 'Rothengatter', 165, '1954-10-08'),
(314, 'Ian', 'Ashley', 76, '1947-10-26'),
(315, 'Ian', 'Burgess', 76, '1930-07-06'),
(316, 'Ian', 'Raby', 76, '1921-09-22'),
(317, 'Ian', 'Scheckter', 244, '1947-08-22'),
(318, 'Ian', 'Stewart', 76, '1929-07-15'),
(319, 'Ignazio', 'Giunti', 109, '1941-08-30'),
(320, 'Ingo', 'Hoffmann', 31, '1953-02-28'),
(321, 'Innes', 'Ireland', 76, '1930-06-12'),
(322, 'Ivan', 'Capelli', 109, '1963-05-24'),
(323, 'Ivor', 'Bueb', 76, '1923-06-06'),
(324, 'Jac', 'Nellemann', 58, '1944-04-19'),
(325, 'Jack', 'Aitken', 76, '1995-09-23'),
(326, 'Jack', 'Brabham', 14, '1926-04-02'),
(327, 'Jack', 'Fairman', 76, '1913-03-15'),
(328, 'Jackie', 'Lewis', 76, '1936-11-01'),
(329, 'Jackie', 'Oliver', 76, '1942-08-14'),
(330, 'Jackie', 'Pretorius', 244, '1934-11-22'),
(331, 'Jackie', 'Stewart', 76, '1939-06-11'),
(332, 'Jacky', 'Ickx', 21, '1945-01-01'),
(333, 'Jacques', 'Laffite', 74, '1943-11-21'),
(334, 'Jacques', 'Pollet', 74, '1922-07-02'),
(335, 'Jacques', 'Swaters', 21, '1926-10-30'),
(336, 'Jacques', 'Villeneuve', 38, '1971-04-09'),
(337, 'Jacques', 'Villeneuve Jr.', 38, '1953-11-04'),
(338, 'Jaime', 'Alguersuari', 67, '1990-03-23'),
(339, 'James', 'Hunt', 76, '1947-08-29'),
(340, 'Jan', 'Flinterman', 165, '1919-10-02'),
(341, 'Jan', 'Lammers', 165, '1956-06-02'),
(342, 'Jan', 'Magnussen', 58, '1973-07-04'),
(343, 'Jarno', 'Trulli', 74, '1974-07-13'),
(344, 'Jay', 'Chamberlain', 230, '1925-12-29'),
(345, 'Jean', 'Alesi', 74, '1964-06-11'),
(346, 'Jean', 'Behra', 74, '1921-02-16'),
(347, 'Jean', 'Lucas', 74, '1917-04-25'),
(348, 'Jean', 'Lucienbonnet', 74, '1923-01-07'),
(349, 'Jean-Christophe', 'Boullion', 74, '1969-12-27'),
(350, 'Jean-Claude', 'Rudaz', 43, '1942-07-23'),
(351, 'Jean-Denis', 'Delétraz', 43, '1963-10-01'),
(352, 'Jean-Eric', 'Vergne', 74, '1990-04-25'),
(353, 'Jean-Louis', 'Schlesser', 74, '1948-09-12'),
(354, 'Jean-Marc', 'Gounon', 74, '1963-01-01'),
(355, 'Jean-Pierre', 'Beltoise', 74, '1937-04-26'),
(356, 'Jean-Pierre', 'Jabouille', 74, '1942-10-01'),
(357, 'Jean-Pierre', 'Jarier', 74, '1946-07-10'),
(358, 'Jenson', 'Button', 76, '1980-01-19'),
(359, 'Jerome', 'd\'Ambrosio', 21, '1985-12-27'),
(360, 'Jesús', 'Iglesias', 11, '1922-02-22'),
(361, 'Jim', 'Clark', 76, '1936-03-04'),
(362, 'Jim', 'Crawford', 76, '1948-02-13'),
(363, 'Jim', 'Hall', 230, '1935-07-23'),
(364, 'Jimmy', 'Stewart', 76, '1931-03-06'),
(365, 'Jo', 'Bonnier', 196, '1930-01-31'),
(366, 'Jo', 'Gartner', 13, '1954-01-24'),
(367, 'Jo', 'Schlesser', 74, '1928-05-18'),
(368, 'Jo', 'Siffert', 43, '1936-07-07'),
(369, 'Jo', 'Vonlanthen', 43, '1942-05-31'),
(370, 'Joachim', 'Winkelhock', 56, '1960-10-24'),
(371, 'Jochen', 'Mass', 56, '1946-09-30'),
(372, 'Jochen', 'Rindt', 13, '1942-04-18'),
(373, 'Jody', 'Scheckter', 244, '1950-01-29'),
(374, 'Joe', 'Fry', 76, '1915-10-26'),
(375, 'Joe', 'Kelly', 101, '1913-03-13'),
(376, 'John', 'Barber', 76, '1929-07-22'),
(377, 'John', 'Campbell-Jones', 76, '1930-01-21'),
(378, 'John', 'Cannon', 38, '1933-06-21'),
(379, 'John', 'Cordts', 38, '1935-07-23'),
(380, 'John', 'Fitch', 230, '1917-08-04'),
(381, 'John', 'James', 76, '1914-05-10'),
(382, 'John', 'Love', 246, '1924-12-07'),
(383, 'John', 'Miles', 76, '1943-06-14'),
(384, 'John', 'Nicholson', 170, '1941-10-06'),
(385, 'John', 'Rhodes', 76, '1927-08-18'),
(386, 'John', 'Riseley-Prichard', 76, '1924-01-17'),
(387, 'John', 'Surtees', 76, '1934-02-11'),
(388, 'John', 'Taylor', 76, '1933-03-23'),
(389, 'John', 'Watson', 76, '1946-05-04'),
(390, 'Johnny', 'Cecotto', 235, '1956-01-25'),
(391, 'Johnny', 'Claes', 21, '1916-08-11'),
(392, 'Johnny', 'Dumfries', 76, '1958-04-26'),
(393, 'Johnny', 'Herbert', 76, '1964-06-25'),
(394, 'Johnny', 'Servoz-Gavin', 74, '1942-01-18'),
(395, 'Jonathan', 'Palmer', 76, '1956-11-07'),
(396, 'Jonathan', 'Williams', 76, '1942-10-26'),
(397, 'Jorge', 'Daponte', 11, '1923-06-05'),
(398, 'Jos', 'Verstappen', 165, '1972-03-04'),
(399, 'José', 'Dolhem', 74, '1944-04-26'),
(400, 'José', 'Froilán González', 11, '1922-10-05'),
(401, 'Josef', 'Peters', 56, '1914-09-16'),
(402, 'Joylon', 'Palmer', 76, '1991-01-20'),
(403, 'Juan', 'Jover Sañes', 67, '1903-11-23'),
(404, 'Juan Manuel', 'Bordeu', 11, '1934-01-28'),
(405, 'Juan Manuel', 'Fangio', 11, '1911-06-24'),
(406, 'Juan Pablo', 'Montoya', 49, '1975-09-20'),
(407, 'Jules', 'Bianchi', 74, '1989-08-03'),
(408, 'Julian', 'Bailey', 76, '1961-10-09'),
(409, 'Justin', 'Wilson', 76, '1978-07-31'),
(410, 'Jyrki Juhani \"JJ\"', 'Lehto', 69, '1966-01-31'),
(411, 'Kamui', 'Kobayashi', 113, '1986-09-13'),
(412, 'Karl', 'Kling', 56, '1910-09-16'),
(413, 'Karl', 'Wendlinger', 13, '1968-12-20'),
(414, 'Karun', 'Chandhok', 104, '1984-01-19'),
(415, 'Kazuki', 'Nakajima', 113, '1985-01-11'),
(416, 'Kazuyoshi', 'Hoshino', 113, '1947-07-01'),
(417, 'Keith', 'Greene', 76, '1938-01-05'),
(418, 'Keke', 'Rosberg', 69, '1948-12-06'),
(419, 'Ken', 'Downing', 76, '1917-12-05'),
(420, 'Ken', 'Kavanagh', 14, '1923-12-12'),
(421, 'Ken', 'Richardson', 76, '1911-08-21'),
(422, 'Ken', 'Wharton', 76, '1916-03-21'),
(423, 'Kenneth', 'McAlpine', 76, '1920-09-21'),
(424, 'Kenny', 'Acheson', 76, '1957-11-27'),
(425, 'Kevin', 'Cogan', 230, '1956-03-31'),
(426, 'Kevin', 'Magnussen', 58, '1992-10-05'),
(427, 'Kimi', 'Raikkonen', 69, '1979-10-17'),
(428, 'Kunimitsu', 'Takahashi', 113, '1940-01-29'),
(429, 'Kurt', 'Adolff', 56, '1921-11-05'),
(430, 'Kurt', 'Ahrens Jr.', 56, '1940-04-19'),
(431, 'Kurt', 'Kuhnke', 56, '1910-04-30'),
(432, 'Lamberto', 'Leoni', 109, '1953-05-24'),
(433, 'Lance', 'Macklin', 76, '1919-09-02'),
(434, 'Lance', 'Reventlow', 230, '1936-02-24'),
(435, 'Lance', 'Stroll', 38, '1998-10-29'),
(436, 'Lando', 'Norris', 76, '1999-11-13'),
(437, 'Larry', 'Perkins', 14, '1950-03-18'),
(438, 'Leo', 'Kinnunen', 69, '1943-08-05'),
(439, 'Les', 'Leston', 76, '1920-12-16'),
(440, 'Leslie', 'Johnson', 76, '1912-03-22'),
(441, 'Leslie', 'Marr', 76, '1922-08-14'),
(442, 'Leslie', 'Thorne', 76, '1916-06-23'),
(443, 'Lewis', 'Hamilton', 76, '1985-01-07'),
(444, 'Lloyd', 'Ruby', 230, '1928-01-12'),
(445, 'Lorenzo', 'Bandini', 109, '1935-12-21'),
(446, 'Loris', 'Kessel', 43, '1950-04-01'),
(447, 'Louis', 'Chiron', 137, '1899-08-03'),
(448, 'Louis', 'Rosier', 74, '1905-11-05'),
(449, 'Luca', 'Badoer', 109, '1971-01-25'),
(450, 'Lucas', 'di Grassi', 31, '1984-08-11'),
(451, 'Luciano', 'Burti', 31, '1975-03-05'),
(452, 'Lucien', 'Bianchi', 21, '1934-11-10'),
(453, 'Ludovico', 'Scarfiotti', 109, '1933-10-18'),
(454, 'Ludwig', 'Fischer', 56, '1915-09-17'),
(455, 'Luigi', 'Fagioli', 109, '1898-06-09'),
(456, 'Luigi', 'Musso', 109, '1924-07-28'),
(457, 'Luigi', 'Piotti', 109, '1913-10-27'),
(458, 'Luigi', 'Taramazzo', 109, '1932-05-05'),
(459, 'Luigi', 'Villoresi', 109, '1909-05-16'),
(460, 'Luis', 'Pérez-Sala', 67, '1959-05-15'),
(461, 'Luiz', 'Bueno', 31, '1937-01-16'),
(462, 'Luki', 'Botha', 244, '1930-01-16'),
(463, 'Manfred', 'Winkelhock', 56, '1951-10-06'),
(464, 'Marc', 'Gené', 67, '1974-03-29'),
(465, 'Marc', 'Surer', 43, '1951-09-18'),
(466, 'Marcel', 'Balsa', 74, '1909-01-01'),
(467, 'Marco', 'Apicella', 109, '1965-10-07'),
(468, 'Marcus', 'Ericsson', 196, '1990-09-02'),
(469, 'María \"Lella\"', 'Lombardi', 109, '1941-03-26'),
(470, 'Maria Teresa', 'de Filippis', 109, '1926-11-11'),
(471, 'Mario', 'Andretti', 230, '1940-02-28'),
(472, 'Mario', 'de Araújo Cabral', 183, '1934-01-15'),
(473, 'Mark', 'Blundell', 76, '1966-04-08'),
(474, 'Mark', 'Donohue', 230, '1937-03-18'),
(475, 'Mark', 'Webber', 14, '1976-08-27'),
(476, 'Markus', 'Winkelhock', 56, '1980-06-13'),
(477, 'Martin', 'Brundle', 76, '1959-06-01'),
(478, 'Martin', 'Donnelly', 76, '1964-03-26'),
(479, 'Masami', 'Kuwashima', 113, '1950-09-14'),
(480, 'Mashiro', 'Hasemi', 113, '1945-11-13'),
(481, 'Massimiliano \"Max\"', 'Papis', 109, '1969-10-03'),
(482, 'Massimo', 'Natili', 109, '1935-07-28'),
(483, 'Masten', 'Gregory', 230, '1932-02-29'),
(484, 'Maurice', 'Trintignant', 74, '1917-10-30'),
(485, 'Maurício', 'Gugelmin', 31, '1963-04-20'),
(486, 'Mauro', 'Baldi', 109, '1954-01-31'),
(487, 'Max', 'Chilton', 76, '1991-04-21'),
(488, 'Max', 'de Terra', 43, '1918-10-06'),
(489, 'Max', 'Jean', 74, '1943-07-27'),
(490, 'Max', 'Verstappen', 165, '1997-09-30'),
(491, 'Michael', 'Andretti', 230, '1962-10-05'),
(492, 'Michael', 'Bartels', 56, '1968-03-08'),
(493, 'Michael', 'Bleekemolen', 165, '1949-10-02'),
(494, 'Michael', 'May', 43, '1934-08-18'),
(495, 'Michael', 'Schumacher', 56, '1969-01-03'),
(496, 'Michele', 'Alboreto', 109, '1956-12-23'),
(497, 'Michele', 'Leclere', 74, '1946-03-18'),
(498, 'Miguel Ángel', 'Guerra', 11, '1953-08-31'),
(499, 'Mika', 'Hakkinen', 69, '1968-09-28'),
(500, 'Mika', 'Salo', 69, '1966-11-30'),
(501, 'Mike', 'Beuttler', 76, '1940-04-13'),
(502, 'Mike', 'Fisher', 230, '1943-03-13'),
(503, 'Mike', 'Hailwood', 76, '1940-04-02'),
(504, 'Mike', 'Harris', 246, '1939-05-25'),
(505, 'Mike', 'Hawthorn', 76, '1929-04-10'),
(506, 'Mike', 'MacDowel', 76, '1932-09-13'),
(507, 'Mike', 'Parkes', 76, '1931-09-24'),
(508, 'Mike', 'Sparken', 74, '1930-06-16'),
(509, 'Mike', 'Spence', 76, '1936-12-30'),
(510, 'Mike', 'Taylor', 76, '1934-04-24'),
(511, 'Mike', 'Thackwell', 170, '1961-03-30'),
(512, 'Mike', 'Wilds', 76, '1943-01-07'),
(513, 'Mikko', 'Kozarowitzky', 69, '1948-05-17'),
(514, 'Moisés', 'Solana', 156, '1935-12-26'),
(515, 'Nanni', 'Galli', 109, '1940-10-02'),
(516, 'Naoki', 'Hattori', 113, '1966-06-13'),
(517, 'Narain', 'Karthikeyan', 104, '1977-01-14'),
(518, 'Nasif', 'Estéfano', 11, '1932-11-18'),
(519, 'Nello', 'Pagani', 109, '1911-10-11'),
(520, 'Nelson', 'Piquet', 31, '1952-08-17'),
(521, 'Nelson', 'Piquet Jr.', 31, '1985-06-25'),
(522, 'Néstor', 'García-Veiga', 11, '1945-03-27'),
(523, 'Neville', 'Lederle', 244, '1938-09-25'),
(524, 'Nicholas', 'Latifi', 38, '1995-06-29'),
(525, 'Nick', 'Heidfeld', 56, '1977-05-10'),
(526, 'Nico', 'Hulkenberg', 56, '1987-08-19'),
(527, 'Nico', 'Rosberg', 56, '1985-06-27'),
(528, 'Nicola', 'Larini', 109, '1964-03-19'),
(529, 'Nicolas', 'Kiesa', 58, '1978-03-03'),
(530, 'Nigel', 'Mansell', 76, '1953-08-08'),
(531, 'Niki', 'Lauda', 13, '1949-02-22'),
(532, 'Nikita', 'Mazepin', 190, '1999-03-02'),
(533, 'Nino', 'Vaccarella', 109, '1933-03-04'),
(534, 'Norberto', 'Fontana', 11, '1975-01-20'),
(535, 'Noritake', 'Takahara', 113, '1951-06-06'),
(536, 'Olivier', 'Beretta', 137, '1969-11-23'),
(537, 'Olivier', 'Gendebien', 21, '1924-01-12'),
(538, 'Olivier', 'Grouillard', 74, '1958-09-02'),
(539, 'Olivier', 'Panis', 74, '1966-09-02'),
(540, 'Onofre', 'Marimón', 11, '1923-12-19'),
(541, 'Óscar', 'González', 231, '1923-11-10'),
(542, 'Oscar', 'Larrauri', 11, '1954-08-19'),
(543, 'Oscar Alfredo', 'Gálvez', 11, '1913-08-17'),
(544, 'Oswald', 'Karch', 56, '1917-03-06'),
(545, 'Otto', 'Stuppacher', 13, '1947-03-03'),
(546, 'Ottorino', 'Volonterio', 43, '1917-12-07'),
(547, 'Pablo', 'Birger', 11, '1924-01-07'),
(548, 'Paddy', 'Driver', 244, '1934-05-13'),
(549, 'Paolo', 'Barilla', 109, '1961-04-20'),
(550, 'Pascal', 'Fabre', 74, '1960-01-09'),
(551, 'Pascal', 'Wherlein', 56, '1994-10-18'),
(552, 'Pastor', 'Maldonado', 235, '1985-03-09'),
(553, 'Patrick', 'Depailler', 74, '1944-08-09'),
(554, 'Patrick', 'Friesacher', 13, '1980-09-26'),
(555, 'Patrick', 'Gaillard', 74, '1952-02-12'),
(556, 'Patrick', 'Neve', 21, '1949-10-13'),
(557, 'Patrick', 'Tambay', 74, '1949-06-25'),
(558, 'Paul', 'Belmondo', 74, '1963-04-23'),
(559, 'Paul', 'di Resta', 76, '1986-04-16'),
(560, 'Paul', 'Emery', 76, '1916-11-12'),
(561, 'Paul', 'England', 14, '1929-03-28'),
(562, 'Paul', 'Frere', 21, '1917-01-30'),
(563, 'Paul', 'Hawkins', 14, '1937-10-12'),
(564, 'Paul', 'Pietsch', 56, '1911-06-20'),
(565, 'Pedro', 'Chaves', 183, '1965-02-27'),
(566, 'Pedro', 'de la Rosa', 67, '1971-02-24'),
(567, 'Pedro', 'Diniz', 31, '1970-05-22'),
(568, 'Pedro', 'Lamy', 183, '1972-03-20'),
(569, 'Pedro', 'Rodriguez', 156, '1940-01-18'),
(570, 'Perry', 'McCarthy', 76, '1961-03-03'),
(571, 'Pete', 'Lovely', 230, '1926-04-11'),
(572, 'Peter', 'Arundell', 76, '1933-11-08'),
(573, 'Peter', 'Ashdown', 76, '1934-10-16'),
(574, 'Peter', 'Broeker', 38, '1926-05-15'),
(575, 'Peter', 'Collins', 76, '1931-11-06'),
(576, 'Peter', 'de Klerk', 244, '1935-03-16'),
(577, 'Peter', 'Gethin', 76, '1940-02-21'),
(578, 'Peter', 'Hirt', 43, '1910-03-30'),
(579, 'Peter', 'Revson', 230, '1939-02-27'),
(580, 'Peter', 'Ryan', 38, '1940-06-10'),
(581, 'Peter', 'Walker', 76, '1912-10-07'),
(582, 'Peter', 'Westbury', 76, '1938-05-26'),
(583, 'Peter', 'Whitehead', 76, '1914-11-12'),
(584, 'Phil', 'Cade', 230, '1916-06-12'),
(585, 'Phil', 'Hill', 230, '1927-04-20'),
(586, 'Philip', 'Fotheringham-Parker', 76, '1907-09-22'),
(587, 'Philippe', 'Adams', 21, '1969-11-19'),
(588, 'Philippe', 'Alliot', 74, '1954-07-27'),
(589, 'Philippe', 'Etancelin', 74, '1896-12-28'),
(590, 'Philippe', 'Streiff', 74, '1955-06-26'),
(591, 'Philippe', 'Striff', 74, '1955-06-26'),
(592, 'Piercarlo', 'Ghinzani', 109, '1952-01-16'),
(593, 'Pierluigi', 'Martini', 109, '1961-04-23'),
(594, 'Piero', 'Carini', 109, '1921-03-06'),
(595, 'Piero', 'Drogo', 109, '1926-08-08'),
(596, 'Piero', 'Dusio', 109, '1899-10-13'),
(597, 'Piero', 'Scotti', 109, '1909-11-11'),
(598, 'Piero', 'Taruffi', 109, '1906-10-12'),
(599, 'Pierre', 'Gasly', 74, '1996-02-07'),
(600, 'Pierre', 'Levegh', 74, '1905-12-22'),
(601, 'Pierre-Henri', 'Raphanel', 74, '1961-05-27'),
(602, 'Piers', 'Courage', 76, '1942-05-27'),
(603, 'Pietro', 'Fittipaldi', 31, '1996-06-25'),
(604, 'Ralf', 'Schumacher', 56, '1975-06-30'),
(605, 'Ralph', 'Firman', 101, '1975-05-20'),
(606, 'Raul', 'Boesel', 31, '1957-12-04'),
(607, 'Raymond', 'Sommer', 74, '1906-08-31'),
(608, 'Reg', 'Parnell', 76, '1911-07-02'),
(609, 'Reine', 'Wisell', 196, '1941-09-30'),
(610, 'Renato', 'Pirocchi', 109, '1933-03-26'),
(611, 'René', 'Arnoux', 74, '1948-07-04'),
(612, 'Renzo', 'Zorzi', 109, '1946-12-12'),
(613, 'Ricardo', 'Londoño', 49, '1949-08-08'),
(614, 'Ricardo', 'Rodriguez', 156, '1942-02-14'),
(615, 'Ricardo', 'Rosset', 31, '1968-07-27'),
(616, 'Ricardo', 'Zonta', 31, '1976-03-23'),
(617, 'Ricardo', 'Zunino', 11, '1949-04-13'),
(618, 'Riccardo', 'Paletti', 109, '1958-06-15'),
(619, 'Riccardo', 'Patrese', 109, '1954-04-17'),
(620, 'Richard', 'Attwood', 76, '1940-04-04'),
(621, 'Richard', 'Robarts', 76, '1944-09-22'),
(622, 'Richie', 'Ginther', 230, '1930-08-05'),
(623, 'Ricky', 'von Opel', 128, '1947-10-14'),
(624, 'Rio', 'Haryanto', 100, '1993-01-22'),
(625, 'Rob', 'Schroeder', 230, '1926-05-11'),
(626, 'Robert', 'Doombos', 137, '1981-09-23'),
(627, 'Robert', 'Kubica', 178, '1984-12-07'),
(628, 'Robert', 'La Caze', 136, '1917-02-26'),
(629, 'Robert', 'Manzon', 74, '1917-04-12'),
(630, 'Robert', 'O\'Brien', 230, '1908-04-11'),
(631, 'Roberto', 'Bonomi', 11, '1919-09-30'),
(632, 'Roberto', 'Bussinello', 109, '1927-10-04'),
(633, 'Roberto', 'Guerrero', 49, '1958-11-16'),
(634, 'Roberto', 'Lippi', 109, '1926-10-17'),
(635, 'Roberto', 'Merhi', 67, '1991-03-22'),
(636, 'Roberto', 'Mieres', 11, '1924-12-03'),
(637, 'Roberto', 'Moreno', 31, '1959-02-11'),
(638, 'Robin', 'Montgomerie-Charrington', 76, '1915-06-23'),
(639, 'Robin', 'Widdows', 76, '1942-05-27'),
(640, 'Rodger', 'Ward', 230, '1921-01-10'),
(641, 'Rodney', 'Nuckey', 76, '1929-06-26'),
(642, 'Roger', 'Laurent', 21, '1913-02-21'),
(643, 'Roger', 'Loyer', 74, '1907-08-05'),
(644, 'Roger', 'Penske', 230, '1937-02-20'),
(645, 'Roger', 'Williamson', 76, '1948-02-02'),
(646, 'Roland', 'Ratzenberger', 13, '1960-07-04'),
(647, 'Roleof', 'Wunderink', 165, '1948-12-12'),
(648, 'Rolf', 'Stommelen', 56, '1943-07-11'),
(649, 'Romain', 'Grosjean', 74, '1986-04-17'),
(650, 'Ron', 'Flockhart', 14, '1923-06-16'),
(651, 'Ronnie', 'Bucknum', 230, '1936-04-05'),
(652, 'Ronnie', 'Peterson', 196, '1944-02-14'),
(653, 'Roy', 'Salvadori', 76, '1922-05-12'),
(654, 'Rubens', 'Barrichello', 31, '1972-05-23'),
(655, 'Rudi', 'Fischer', 43, '1912-04-19'),
(656, 'Rudolf', 'Krause', 56, '1907-03-30'),
(657, 'Rudolf', 'Schoeller', 43, '1902-04-27'),
(658, 'Rupert', 'Keegan', 76, '1955-02-26'),
(659, 'Sakon', 'Yamamoto', 113, '1982-07-09'),
(660, 'Sam', 'Posey', 230, '1944-05-26'),
(661, 'Sam', 'Tingle', 246, '1921-08-24'),
(662, 'Satoru', 'Nakajima', 113, '1953-02-23'),
(663, 'Scott', 'Speed', 230, '1983-01-24'),
(664, 'Sebastian', 'Vettel', 56, '1987-07-03'),
(665, 'Sébastien', 'Bourdais', 74, '1979-02-28'),
(666, 'Sébastien', 'Buemi', 43, '1988-10-31'),
(667, 'Sergey', 'Sirotkin', 190, '1995-08-27'),
(668, 'Sergio', 'Mantovani', 109, '1929-05-28'),
(669, 'Sergio', 'Pérez', 156, '1990-01-26'),
(670, 'Shinji', 'Nakano', 113, '1971-04-01'),
(671, 'Siegfried', 'Stohr', 109, '1952-10-10'),
(672, 'Silvio', 'Moser', 43, '1941-04-24'),
(673, 'Skip', 'Barber', 230, '1936-11-16'),
(674, 'Slim', 'Borgudd', 196, '1946-11-25'),
(675, 'Stefan', 'Bellof', 56, '1957-11-20'),
(676, 'Stefan', 'Johansson', 196, '1956-09-08'),
(677, 'Stefano', 'Modena', 109, '1963-05-12'),
(678, 'Stephane', 'Sarrazin', 74, '1975-11-02'),
(679, 'Stephen', 'South', 76, '1952-02-19'),
(680, 'Stirling', 'Moss', 76, '1929-09-17'),
(681, 'Stoffel', 'Vandoorne', 21, '1992-03-26'),
(682, 'Stuart', 'Lewis-Evans', 76, '1930-04-20'),
(683, 'Taki', 'Inoue', 113, '1963-09-05'),
(684, 'Takuma', 'Sato', 113, '1977-01-28'),
(685, 'Tarso', 'Marques', 31, '1976-01-19'),
(686, 'Ted', 'Whiteaway', 76, '1928-11-01'),
(687, 'Teddy', 'Pilette', 21, '1942-07-26'),
(688, 'Teo', 'Fabi', 109, '1955-03-09'),
(689, 'Theo', 'Fitzau', 56, '1923-02-10'),
(690, 'Theo', 'Helfrich', 56, '1913-05-13'),
(691, 'Thierry', 'Boutsen', 21, '1957-07-13'),
(692, 'Tiago', 'Monteiro', 183, '1976-07-24'),
(693, 'Tiff', 'Needell', 76, '1951-10-29'),
(694, 'Tim', 'Parnell', 76, '1932-06-25'),
(695, 'Tim', 'Schenken', 14, '1943-09-26'),
(696, 'Timmy', 'Mayer', 230, '1938-02-22'),
(697, 'Timo', 'Glock', 56, '1981-03-18'),
(698, 'Tom', 'Belso', 58, '1942-08-27'),
(699, 'Tom', 'Bridger', 76, '1934-06-24'),
(700, 'Tom', 'Jones', 230, '1943-04-26'),
(701, 'Tom', 'Pryce', 76, '1949-06-11'),
(702, 'Tomas', 'Enge', 55, '1976-09-11'),
(703, 'Tommy', 'Byrne', 101, '1958-05-06'),
(704, 'Toni', 'Branca', 43, '1916-09-15'),
(705, 'Toni', 'Ulmen', 56, '1906-01-25'),
(706, 'Tony', 'Brise', 76, '1952-03-28'),
(707, 'Tony', 'Brooks', 76, '1932-02-25'),
(708, 'Tony', 'Crook', 76, '1920-02-16'),
(709, 'Tony', 'Gaze', 14, '1920-02-03'),
(710, 'Tony', 'Maggs', 244, '1937-02-09'),
(711, 'Tony', 'Marsh', 76, '1931-07-20'),
(712, 'Tony', 'Rolt', 76, '1918-10-16'),
(713, 'Tony', 'Settember', 230, '1926-07-10'),
(714, 'Tony', 'Shelly', 170, '1937-02-02'),
(715, 'Tony', 'Trimmer', 76, '1943-01-24'),
(716, 'Toranosuke', 'Takagi', 113, '1974-02-12'),
(717, 'Torsten', 'Palm', 196, '1947-07-23'),
(718, 'Toshio', 'Suzuki', 113, '1955-03-10'),
(719, 'Trevor', 'Blokdyk', 244, '1935-11-30'),
(720, 'Trevor', 'Taylor', 76, '1936-12-26'),
(721, 'Troy', 'Ruttman', 230, '1930-03-11'),
(722, 'Ukyo', 'Katayama', 113, '1963-05-29'),
(723, 'Umberto', 'Maglioli', 109, '1928-06-05'),
(724, 'Valtteri', 'Bottas', 69, '1989-08-28'),
(725, 'Vern', 'Schuppan', 14, '1943-03-19'),
(726, 'Vic', 'Elford', 76, '1935-06-10'),
(727, 'Vic', 'Wilson', 76, '1931-04-14'),
(728, 'Vincenzo', 'Sospiri', 109, '1966-10-07'),
(729, 'Vitaly', 'Petrov', 190, '1984-09-08'),
(730, 'Vitantonio', 'Liuzzi', 109, '1980-08-06'),
(731, 'Vittorio', 'Brambilla', 109, '1937-11-11'),
(732, 'Volker', 'Weidler', 56, '1962-03-18'),
(733, 'Walt', 'Hansgen', 230, '1919-10-28'),
(734, 'Warwick', 'Brown', 14, '1949-12-24'),
(735, 'Will', 'Stevens', 76, '1991-06-28'),
(736, 'Willi', 'Heeks', 56, '1922-02-13'),
(737, 'Willi', 'Krakau', 56, '1911-12-04'),
(738, 'William', 'Ferguson', 244, '1940-03-06'),
(739, 'Willy', 'Mairesse', 21, '1928-10-01'),
(740, 'Wilson', 'Fittipaldi Jr', 31, '1943-12-25'),
(741, 'Wolfgang', 'Seidel', 56, '1926-07-04'),
(742, 'Wolfgang', 'von Trips', 56, '1928-05-04'),
(743, 'Xavier', 'Perrot', 43, '1932-02-01'),
(744, 'Yannick', 'Dalmas', 74, '1961-07-28'),
(745, 'Yuji', 'Ide', 113, '1975-01-21'),
(746, 'Yuki', 'Tsunoda', 113, '2000-05-11'),
(747, 'Yves', 'Giraud-Cabantous', 74, '1904-10-08'),
(748, 'Zsolt', 'Baumgartner', 99, '1981-01-01'),
(749, 'Johnnie', 'Parsons', 230, '1918-07-04'),
(750, 'Bill', 'Holland', 230, '1907-12-18'),
(751, 'Mauri', 'Rose', 230, '1906-05-26'),
(752, 'Cecil', 'Green', 230, '1919-09-30'),
(753, 'Lee', 'Wallard', 230, '1910-09-07'),
(754, 'Joie', 'Chitwood', 230, '1912-04-14'),
(755, 'Tony', 'Bettenhausen', 230, '1916-09-02'),
(756, 'Walt', 'Faulkner', 230, '1918-02-06'),
(757, 'George', 'Connor', 230, '1906-08-16'),
(758, 'Paul', 'Russo', 230, '1914-04-14'),
(759, 'Pat', 'Flaherty', 230, '1926-01-06');

-- --------------------------------------------------------

--
-- Table structure for table `season_constructors`
--

CREATE TABLE `season_constructors` (
  `season_year` int(11) NOT NULL,
  `season_category` int(11) NOT NULL,
  `season_constructor` int(11) NOT NULL,
  `season_constructor_principal_color` varchar(10) NOT NULL,
  `season_constructor_secondary_color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `season_constructors`
--

INSERT INTO `season_constructors` (`season_year`, `season_category`, `season_constructor`, `season_constructor_principal_color`, `season_constructor_secondary_color`) VALUES
(1950, 1, 1, '#8f2d3a', '#ffffff'),
(1950, 1, 3, '#0055a6', '#ffffff'),
(1950, 1, 5, '#b73d47', '#ffffff'),
(1950, 1, 22, '#577279', '#000000'),
(1950, 1, 162, '#1c6b4f', '#ffffff');

-- --------------------------------------------------------

--
-- Table structure for table `season_gps`
--

CREATE TABLE `season_gps` (
  `season_year` int(11) NOT NULL,
  `season_category` int(11) NOT NULL,
  `gp_id` int(11) NOT NULL,
  `gp_name` varchar(30) NOT NULL,
  `gp_country` int(11) NOT NULL,
  `gp_track` int(11) NOT NULL,
  `gp_length` int(11) NOT NULL,
  `gp_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `season_gps`
--

INSERT INTO `season_gps` (`season_year`, `season_category`, `gp_id`, `gp_name`, `gp_country`, `gp_track`, `gp_length`, `gp_date`) VALUES
(1950, 1, 1, 'British Grand Prix', 76, 1, 70, '1950-05-13');

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `track_id` int(11) NOT NULL,
  `track_name` varchar(60) NOT NULL,
  `track_country` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`track_id`, `track_name`, `track_country`) VALUES
(1, 'Silverstone Circuit', 76),
(2, 'Circuit de Monaco', 137),
(3, 'Indianapolis Motor Speedway', 230),
(4, 'Bremgarten Circuit', 43);

-- --------------------------------------------------------

--
-- Table structure for table `track_variants`
--

CREATE TABLE `track_variants` (
  `variant_id` int(11) NOT NULL,
  `track_id` int(11) NOT NULL,
  `variant_course` varchar(30) NOT NULL,
  `variant_length` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `track_variants`
--

INSERT INTO `track_variants` (`variant_id`, `track_id`, `variant_course`, `variant_length`) VALUES
(1, 1, 'Permanent racing facility', 4649);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_market`
--

CREATE TABLE `transfer_market` (
  `transfer_id` int(11) NOT NULL,
  `transfer_season` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `driver_number` int(11) NOT NULL,
  `driver_replace` int(11) DEFAULT NULL,
  `constructor_id` int(11) NOT NULL,
  `constructor_seat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transfer_market`
--

INSERT INTO `transfer_market` (`transfer_id`, `transfer_season`, `driver_id`, `driver_number`, `driver_replace`, `constructor_id`, `constructor_seat`) VALUES
(1, 1950, 405, 1, NULL, 1, 1),
(2, 1950, 71, 21, NULL, 5, 7),
(3, 1950, 76, 12, NULL, 22, 5),
(4, 1950, 90, 10, NULL, 5, 5),
(5, 1950, 136, 11, NULL, 22, 4),
(6, 1950, 148, 6, NULL, 5, 3),
(7, 1950, 151, 5, NULL, 5, 2),
(8, 1950, 186, 20, NULL, 5, 6),
(9, 1950, 207, 17, NULL, 3, 4),
(10, 1950, 236, 24, NULL, 162, 2),
(11, 1950, 268, 2, NULL, 1, 2),
(12, 1950, 374, 10, NULL, 5, 4),
(13, 1950, 375, 23, NULL, 162, 1),
(14, 1950, 391, 18, NULL, 3, 5),
(15, 1950, 440, 8, NULL, 22, 1),
(16, 1950, 447, 19, NULL, 5, 1),
(17, 1950, 448, 15, NULL, 3, 2),
(18, 1950, 455, 3, NULL, 1, 3),
(19, 1950, 581, 9, NULL, 22, 2),
(20, 1950, 589, 16, NULL, 3, 3),
(21, 1950, 608, 4, NULL, 1, 4),
(22, 1950, 712, 9, NULL, 22, 3),
(23, 1950, 747, 14, NULL, 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`),
  ADD UNIQUE KEY `category_abbr` (`category_abbr`);

--
-- Indexes for table `constructors`
--
ALTER TABLE `constructors`
  ADD PRIMARY KEY (`constructor_id`),
  ADD UNIQUE KEY `constructor_name` (`constructor_name`),
  ADD KEY `constructor_country` (`constructor_country`);

--
-- Indexes for table `continents`
--
ALTER TABLE `continents`
  ADD PRIMARY KEY (`continent_code`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`),
  ADD UNIQUE KEY `idx_code` (`country_code`) USING BTREE,
  ADD KEY `idx_continent_code` (`country_continent_code`) USING BTREE;

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `driver_name` (`driver_name`,`driver_lastname`),
  ADD KEY `driver_country` (`driver_country`);

--
-- Indexes for table `season_constructors`
--
ALTER TABLE `season_constructors`
  ADD PRIMARY KEY (`season_year`,`season_category`,`season_constructor`),
  ADD KEY `season_category` (`season_category`),
  ADD KEY `season_constructor` (`season_constructor`);

--
-- Indexes for table `season_gps`
--
ALTER TABLE `season_gps`
  ADD PRIMARY KEY (`season_year`,`season_category`,`gp_id`),
  ADD KEY `season_category` (`season_category`),
  ADD KEY `gp_country` (`gp_country`),
  ADD KEY `gp_circuit` (`gp_track`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`track_id`),
  ADD KEY `track_country` (`track_country`);

--
-- Indexes for table `track_variants`
--
ALTER TABLE `track_variants`
  ADD PRIMARY KEY (`variant_id`,`track_id`),
  ADD KEY `track_id` (`track_id`);

--
-- Indexes for table `transfer_market`
--
ALTER TABLE `transfer_market`
  ADD PRIMARY KEY (`transfer_id`),
  ADD KEY `constructor_id` (`constructor_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `driver_replace` (`driver_replace`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `constructors`
--
ALTER TABLE `constructors`
  MODIFY `constructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=760;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `track_variants`
--
ALTER TABLE `track_variants`
  MODIFY `variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfer_market`
--
ALTER TABLE `transfer_market`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `constructors`
--
ALTER TABLE `constructors`
  ADD CONSTRAINT `constructors_ibfk_1` FOREIGN KEY (`constructor_country`) REFERENCES `countries` (`country_id`);

--
-- Constraints for table `countries`
--
ALTER TABLE `countries`
  ADD CONSTRAINT `countries_ibfk_1` FOREIGN KEY (`country_continent_code`) REFERENCES `continents` (`continent_code`) ON UPDATE CASCADE;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_ibfk_1` FOREIGN KEY (`driver_country`) REFERENCES `countries` (`country_id`);

--
-- Constraints for table `season_constructors`
--
ALTER TABLE `season_constructors`
  ADD CONSTRAINT `season_constructors_ibfk_1` FOREIGN KEY (`season_category`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `season_constructors_ibfk_2` FOREIGN KEY (`season_constructor`) REFERENCES `constructors` (`constructor_id`);

--
-- Constraints for table `season_gps`
--
ALTER TABLE `season_gps`
  ADD CONSTRAINT `season_gps_ibfk_1` FOREIGN KEY (`season_category`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `season_gps_ibfk_2` FOREIGN KEY (`gp_country`) REFERENCES `countries` (`country_id`),
  ADD CONSTRAINT `season_gps_ibfk_3` FOREIGN KEY (`gp_track`) REFERENCES `tracks` (`track_id`);

--
-- Constraints for table `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_ibfk_1` FOREIGN KEY (`track_country`) REFERENCES `countries` (`country_id`);

--
-- Constraints for table `track_variants`
--
ALTER TABLE `track_variants`
  ADD CONSTRAINT `track_variants_ibfk_1` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`track_id`);

--
-- Constraints for table `transfer_market`
--
ALTER TABLE `transfer_market`
  ADD CONSTRAINT `transfer_market_ibfk_1` FOREIGN KEY (`constructor_id`) REFERENCES `constructors` (`constructor_id`),
  ADD CONSTRAINT `transfer_market_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`),
  ADD CONSTRAINT `transfer_market_ibfk_3` FOREIGN KEY (`driver_replace`) REFERENCES `drivers` (`driver_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
