-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2026 at 04:24 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digital_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint UNSIGNED NOT NULL,
  `agenda_id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `waktu_masuk` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_kehadiran` enum('Hadir','Terlambat','Izin','Sakit','Alpa') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `agenda_id`, `mahasiswa_id`, `waktu_masuk`, `status_kehadiran`) VALUES
(76, 200, 7, '2026-02-23 07:00:00', 'Hadir'),
(77, 201, 7, '2026-03-02 07:00:00', 'Hadir'),
(78, 202, 7, '2026-03-09 07:40:00', 'Hadir'),
(79, 203, 7, '2026-03-30 07:40:00', 'Alpa'),
(80, 204, 7, '2026-04-06 07:40:00', 'Hadir'),
(81, 205, 7, '2026-04-13 07:40:00', 'Alpa'),
(82, 206, 7, '2026-04-20 07:40:00', 'Alpa'),
(83, 207, 7, '2026-04-27 07:40:00', 'Alpa'),
(84, 208, 7, '2026-05-18 07:40:00', 'Alpa'),
(85, 209, 7, '2026-05-25 07:40:00', 'Alpa'),
(86, 210, 7, '2026-06-01 07:40:00', 'Alpa'),
(87, 212, 7, '2026-06-15 07:40:00', 'Alpa'),
(88, 214, 7, '2026-06-29 07:40:00', 'Alpa'),
(89, 215, 7, '2026-07-13 07:40:00', 'Alpa'),
(90, 200, 8, '2026-02-23 07:00:00', 'Hadir'),
(91, 201, 8, '2026-03-02 07:00:00', 'Hadir'),
(92, 202, 8, '2026-03-09 07:40:00', 'Hadir'),
(93, 203, 8, '2026-03-30 07:40:00', 'Hadir'),
(94, 204, 8, '2026-04-06 07:40:00', 'Hadir'),
(95, 205, 8, '2026-04-13 07:40:00', 'Hadir'),
(96, 206, 8, '2026-04-20 07:40:00', 'Hadir'),
(97, 207, 8, '2026-04-27 07:40:00', 'Hadir'),
(98, 208, 8, '2026-05-18 07:40:00', 'Hadir'),
(99, 209, 8, '2026-05-25 07:40:00', 'Hadir'),
(100, 210, 8, '2026-06-01 07:40:00', 'Hadir'),
(101, 212, 8, '2026-06-15 07:40:00', 'Hadir'),
(102, 214, 8, '2026-06-29 07:40:00', 'Hadir'),
(103, 215, 8, '2026-07-13 07:40:00', 'Hadir'),
(104, 200, 9, '2026-02-23 07:00:00', 'Hadir'),
(105, 201, 9, '2026-03-02 07:00:00', 'Hadir'),
(106, 202, 9, '2026-03-09 07:40:00', 'Alpa'),
(107, 203, 9, '2026-03-30 07:40:00', 'Hadir'),
(108, 204, 9, '2026-04-06 07:40:00', 'Hadir'),
(109, 205, 9, '2026-04-13 07:40:00', 'Hadir'),
(110, 206, 9, '2026-04-20 07:40:00', 'Hadir'),
(111, 207, 9, '2026-04-27 07:40:00', 'Hadir'),
(112, 208, 9, '2026-05-18 07:40:00', 'Hadir'),
(113, 209, 9, '2026-05-25 07:40:00', 'Hadir'),
(114, 210, 9, '2026-06-01 07:40:00', 'Hadir'),
(115, 212, 9, '2026-06-15 07:40:00', 'Hadir'),
(116, 214, 9, '2026-06-29 07:40:00', 'Hadir'),
(117, 215, 9, '2026-07-13 07:40:00', 'Hadir'),
(118, 200, 10, '2026-02-23 07:00:00', 'Hadir'),
(119, 201, 10, '2026-03-02 07:00:00', 'Hadir'),
(120, 202, 10, '2026-03-09 07:40:00', 'Hadir'),
(121, 203, 10, '2026-03-30 07:40:00', 'Hadir'),
(122, 204, 10, '2026-04-06 07:40:00', 'Hadir'),
(123, 205, 10, '2026-04-13 07:40:00', 'Hadir'),
(124, 206, 10, '2026-04-20 07:40:00', 'Hadir'),
(125, 207, 10, '2026-04-27 07:40:00', 'Hadir'),
(126, 208, 10, '2026-05-18 07:40:00', 'Hadir'),
(127, 209, 10, '2026-05-25 07:40:00', 'Hadir'),
(128, 210, 10, '2026-06-01 07:40:00', 'Hadir'),
(129, 212, 10, '2026-06-15 07:40:00', 'Hadir'),
(130, 214, 10, '2026-06-29 07:40:00', 'Hadir'),
(131, 215, 10, '2026-07-13 07:40:00', 'Hadir'),
(132, 200, 11, '2026-02-23 07:00:00', 'Hadir'),
(133, 201, 11, '2026-03-02 07:00:00', 'Hadir'),
(134, 202, 11, '2026-03-09 07:40:00', 'Hadir'),
(135, 203, 11, '2026-03-30 07:40:00', 'Hadir'),
(136, 204, 11, '2026-04-06 07:40:00', 'Hadir'),
(137, 205, 11, '2026-04-13 07:40:00', 'Hadir'),
(138, 206, 11, '2026-04-20 07:40:00', 'Hadir'),
(139, 207, 11, '2026-04-27 07:40:00', 'Hadir'),
(140, 208, 11, '2026-05-18 07:40:00', 'Hadir'),
(141, 209, 11, '2026-05-25 07:40:00', 'Hadir'),
(142, 210, 11, '2026-06-01 07:40:00', 'Hadir'),
(143, 212, 11, '2026-06-15 07:40:00', 'Hadir'),
(144, 214, 11, '2026-06-29 07:40:00', 'Hadir'),
(145, 215, 11, '2026-07-13 07:40:00', 'Hadir'),
(146, 200, 12, '2026-02-23 07:00:00', 'Hadir'),
(147, 201, 12, '2026-03-02 07:00:00', 'Hadir'),
(148, 202, 12, '2026-03-09 07:40:00', 'Hadir'),
(149, 203, 12, '2026-03-30 07:40:00', 'Hadir'),
(150, 204, 12, '2026-04-06 07:40:00', 'Hadir'),
(151, 205, 12, '2026-04-13 07:40:00', 'Hadir'),
(152, 206, 12, '2026-04-20 07:40:00', 'Hadir'),
(153, 207, 12, '2026-04-27 07:40:00', 'Hadir'),
(154, 208, 12, '2026-05-18 07:40:00', 'Hadir'),
(155, 209, 12, '2026-05-25 07:40:00', 'Hadir'),
(156, 210, 12, '2026-06-01 07:40:00', 'Hadir'),
(157, 212, 12, '2026-06-15 07:40:00', 'Hadir'),
(158, 214, 12, '2026-06-29 07:40:00', 'Hadir'),
(159, 215, 12, '2026-07-13 07:40:00', 'Hadir'),
(160, 200, 13, '2026-02-23 07:00:00', 'Hadir'),
(161, 201, 13, '2026-03-02 07:00:00', 'Hadir'),
(162, 202, 13, '2026-03-09 07:40:00', 'Hadir'),
(163, 203, 13, '2026-03-30 07:40:00', 'Hadir'),
(164, 204, 13, '2026-04-06 07:40:00', 'Hadir'),
(165, 205, 13, '2026-04-13 07:40:00', 'Hadir'),
(166, 206, 13, '2026-04-20 07:40:00', 'Hadir'),
(167, 207, 13, '2026-04-27 07:40:00', 'Hadir'),
(168, 208, 13, '2026-05-18 07:40:00', 'Hadir'),
(169, 209, 13, '2026-05-25 07:40:00', 'Hadir'),
(170, 210, 13, '2026-06-01 07:40:00', 'Hadir'),
(171, 212, 13, '2026-06-15 07:40:00', 'Hadir'),
(172, 214, 13, '2026-06-29 07:40:00', 'Hadir'),
(173, 215, 13, '2026-07-13 07:40:00', 'Hadir'),
(174, 200, 14, '2026-02-23 07:00:00', 'Hadir'),
(175, 201, 14, '2026-03-02 07:00:00', 'Hadir'),
(176, 202, 14, '2026-03-09 07:40:00', 'Hadir'),
(177, 203, 14, '2026-03-30 07:40:00', 'Hadir'),
(178, 204, 14, '2026-04-06 07:40:00', 'Hadir'),
(179, 205, 14, '2026-04-13 07:40:00', 'Hadir'),
(180, 206, 14, '2026-04-20 07:40:00', 'Hadir'),
(181, 207, 14, '2026-04-27 07:40:00', 'Hadir'),
(182, 208, 14, '2026-05-18 07:40:00', 'Hadir'),
(183, 209, 14, '2026-05-25 07:40:00', 'Hadir'),
(184, 210, 14, '2026-06-01 07:40:00', 'Hadir'),
(185, 212, 14, '2026-06-15 07:40:00', 'Hadir'),
(186, 214, 14, '2026-06-29 07:40:00', 'Hadir'),
(187, 215, 14, '2026-07-13 07:40:00', 'Hadir'),
(188, 200, 15, '2026-02-23 07:00:00', 'Hadir'),
(189, 201, 15, '2026-03-02 07:00:00', 'Hadir'),
(190, 202, 15, '2026-03-09 07:40:00', 'Hadir'),
(191, 203, 15, '2026-03-30 07:40:00', 'Hadir'),
(192, 204, 15, '2026-04-06 07:40:00', 'Hadir'),
(193, 205, 15, '2026-04-13 07:40:00', 'Hadir'),
(194, 206, 15, '2026-04-20 07:40:00', 'Hadir'),
(195, 207, 15, '2026-04-27 07:40:00', 'Hadir'),
(196, 208, 15, '2026-05-18 07:40:00', 'Hadir'),
(197, 209, 15, '2026-05-25 07:40:00', 'Hadir'),
(198, 210, 15, '2026-06-01 07:40:00', 'Hadir'),
(199, 212, 15, '2026-06-15 07:40:00', 'Hadir'),
(200, 214, 15, '2026-06-29 07:40:00', 'Hadir'),
(201, 215, 15, '2026-07-13 07:40:00', 'Hadir'),
(202, 200, 16, '2026-02-23 07:00:00', 'Hadir'),
(203, 201, 16, '2026-03-02 07:00:00', 'Hadir'),
(204, 202, 16, '2026-03-09 07:40:00', 'Hadir'),
(205, 203, 16, '2026-03-30 07:40:00', 'Hadir'),
(206, 204, 16, '2026-04-06 07:40:00', 'Hadir'),
(207, 205, 16, '2026-04-13 07:40:00', 'Hadir'),
(208, 206, 16, '2026-04-20 07:40:00', 'Hadir'),
(209, 207, 16, '2026-04-27 07:40:00', 'Hadir'),
(210, 208, 16, '2026-05-18 07:40:00', 'Hadir'),
(211, 209, 16, '2026-05-25 07:40:00', 'Hadir'),
(212, 210, 16, '2026-06-01 07:40:00', 'Hadir'),
(213, 212, 16, '2026-06-15 07:40:00', 'Hadir'),
(214, 214, 16, '2026-06-29 07:40:00', 'Hadir'),
(215, 215, 16, '2026-07-13 07:40:00', 'Hadir'),
(216, 200, 17, '2026-02-23 07:00:00', 'Hadir'),
(217, 201, 17, '2026-03-02 07:00:00', 'Hadir'),
(218, 202, 17, '2026-03-09 07:40:00', 'Hadir'),
(219, 203, 17, '2026-03-30 07:40:00', 'Hadir'),
(220, 204, 17, '2026-04-06 07:40:00', 'Hadir'),
(221, 205, 17, '2026-04-13 07:40:00', 'Hadir'),
(222, 206, 17, '2026-04-20 07:40:00', 'Hadir'),
(223, 207, 17, '2026-04-27 07:40:00', 'Hadir'),
(224, 208, 17, '2026-05-18 07:40:00', 'Hadir'),
(225, 209, 17, '2026-05-25 07:40:00', 'Hadir'),
(226, 210, 17, '2026-06-01 07:40:00', 'Hadir'),
(227, 212, 17, '2026-06-15 07:40:00', 'Hadir'),
(228, 214, 17, '2026-06-29 07:40:00', 'Hadir'),
(229, 215, 17, '2026-07-13 07:40:00', 'Hadir'),
(230, 200, 18, '2026-02-23 07:00:00', 'Hadir'),
(231, 201, 18, '2026-03-02 07:00:00', 'Hadir'),
(232, 202, 18, '2026-03-09 07:40:00', 'Hadir'),
(233, 203, 18, '2026-03-30 07:40:00', 'Hadir'),
(234, 204, 18, '2026-04-06 07:40:00', 'Hadir'),
(235, 205, 18, '2026-04-13 07:40:00', 'Hadir'),
(236, 206, 18, '2026-04-20 07:40:00', 'Hadir'),
(237, 207, 18, '2026-04-27 07:40:00', 'Hadir'),
(238, 208, 18, '2026-05-18 07:40:00', 'Hadir'),
(239, 209, 18, '2026-05-25 07:40:00', 'Hadir'),
(240, 210, 18, '2026-06-01 07:40:00', 'Hadir'),
(241, 212, 18, '2026-06-15 07:40:00', 'Hadir'),
(242, 214, 18, '2026-06-29 07:40:00', 'Hadir'),
(243, 215, 18, '2026-07-13 07:40:00', 'Hadir'),
(244, 200, 19, '2026-02-23 07:00:00', 'Izin'),
(245, 201, 19, '2026-03-02 07:00:00', 'Hadir'),
(246, 202, 19, '2026-03-09 07:40:00', 'Hadir'),
(247, 203, 19, '2026-03-30 07:40:00', 'Hadir'),
(248, 204, 19, '2026-04-06 07:40:00', 'Hadir'),
(249, 205, 19, '2026-04-13 07:40:00', 'Hadir'),
(250, 206, 19, '2026-04-20 07:40:00', 'Hadir'),
(251, 207, 19, '2026-04-27 07:40:00', 'Hadir'),
(252, 208, 19, '2026-05-18 07:40:00', 'Hadir'),
(253, 209, 19, '2026-05-25 07:40:00', 'Hadir'),
(254, 210, 19, '2026-06-01 07:40:00', 'Hadir'),
(255, 212, 19, '2026-06-15 07:40:00', 'Hadir'),
(256, 214, 19, '2026-06-29 07:40:00', 'Hadir'),
(257, 215, 19, '2026-07-13 07:40:00', 'Hadir'),
(258, 200, 20, '2026-02-23 07:00:00', 'Hadir'),
(259, 201, 20, '2026-03-02 07:00:00', 'Hadir'),
(260, 202, 20, '2026-03-09 07:40:00', 'Hadir'),
(261, 203, 20, '2026-03-30 07:40:00', 'Hadir'),
(262, 204, 20, '2026-04-06 07:40:00', 'Hadir'),
(263, 205, 20, '2026-04-13 07:40:00', 'Hadir'),
(264, 206, 20, '2026-04-20 07:40:00', 'Hadir'),
(265, 207, 20, '2026-04-27 07:40:00', 'Hadir'),
(266, 208, 20, '2026-05-18 07:40:00', 'Hadir'),
(267, 209, 20, '2026-05-25 07:40:00', 'Hadir'),
(268, 210, 20, '2026-06-01 07:40:00', 'Hadir'),
(269, 212, 20, '2026-06-15 07:40:00', 'Hadir'),
(270, 214, 20, '2026-06-29 07:40:00', 'Hadir'),
(271, 215, 20, '2026-07-13 07:40:00', 'Hadir'),
(272, 200, 21, '2026-02-23 07:00:00', 'Hadir'),
(273, 201, 21, '2026-03-02 07:00:00', 'Hadir'),
(274, 202, 21, '2026-03-09 07:40:00', 'Hadir'),
(275, 203, 21, '2026-03-30 07:40:00', 'Hadir'),
(276, 204, 21, '2026-04-06 07:40:00', 'Hadir'),
(277, 205, 21, '2026-04-13 07:40:00', 'Hadir'),
(278, 206, 21, '2026-04-20 07:40:00', 'Hadir'),
(279, 207, 21, '2026-04-27 07:40:00', 'Hadir'),
(280, 208, 21, '2026-05-18 07:40:00', 'Hadir'),
(281, 209, 21, '2026-05-25 07:40:00', 'Hadir'),
(282, 210, 21, '2026-06-01 07:40:00', 'Hadir'),
(283, 212, 21, '2026-06-15 07:40:00', 'Hadir'),
(284, 214, 21, '2026-06-29 07:40:00', 'Hadir'),
(285, 215, 21, '2026-07-13 07:40:00', 'Hadir'),
(286, 200, 22, '2026-02-23 07:00:00', 'Hadir'),
(287, 201, 22, '2026-03-02 07:00:00', 'Hadir'),
(288, 202, 22, '2026-03-09 07:40:00', 'Hadir'),
(289, 203, 22, '2026-03-30 07:40:00', 'Hadir'),
(290, 204, 22, '2026-04-06 07:40:00', 'Hadir'),
(291, 205, 22, '2026-04-13 07:40:00', 'Hadir'),
(292, 206, 22, '2026-04-20 07:40:00', 'Hadir'),
(293, 207, 22, '2026-04-27 07:40:00', 'Hadir'),
(294, 208, 22, '2026-05-18 07:40:00', 'Hadir'),
(295, 209, 22, '2026-05-25 07:40:00', 'Hadir'),
(296, 210, 22, '2026-06-01 07:40:00', 'Hadir'),
(297, 212, 22, '2026-06-15 07:40:00', 'Izin'),
(298, 214, 22, '2026-06-29 07:40:00', 'Hadir'),
(299, 215, 22, '2026-07-13 07:40:00', 'Hadir'),
(300, 200, 23, '2026-02-23 07:00:00', 'Hadir'),
(301, 201, 23, '2026-03-02 07:00:00', 'Hadir'),
(302, 202, 23, '2026-03-09 07:40:00', 'Hadir'),
(303, 203, 23, '2026-03-30 07:40:00', 'Hadir'),
(304, 204, 23, '2026-04-06 07:40:00', 'Hadir'),
(305, 205, 23, '2026-04-13 07:40:00', 'Hadir'),
(306, 206, 23, '2026-04-20 07:40:00', 'Hadir'),
(307, 207, 23, '2026-04-27 07:40:00', 'Hadir'),
(308, 208, 23, '2026-05-18 07:40:00', 'Hadir'),
(309, 209, 23, '2026-05-25 07:40:00', 'Hadir'),
(310, 210, 23, '2026-06-01 07:40:00', 'Hadir'),
(311, 212, 23, '2026-06-15 07:40:00', 'Hadir'),
(312, 214, 23, '2026-06-29 07:40:00', 'Hadir'),
(313, 215, 23, '2026-07-13 07:40:00', 'Hadir'),
(314, 200, 24, '2026-02-23 07:00:00', 'Hadir'),
(315, 201, 24, '2026-03-02 07:00:00', 'Hadir'),
(316, 202, 24, '2026-03-09 07:40:00', 'Izin'),
(317, 203, 24, '2026-03-30 07:40:00', 'Hadir'),
(318, 204, 24, '2026-04-06 07:40:00', 'Hadir'),
(319, 205, 24, '2026-04-13 07:40:00', 'Hadir'),
(320, 206, 24, '2026-04-20 07:40:00', 'Hadir'),
(321, 207, 24, '2026-04-27 07:40:00', 'Alpa'),
(322, 208, 24, '2026-05-18 07:40:00', 'Hadir'),
(323, 209, 24, '2026-05-25 07:40:00', 'Hadir'),
(324, 210, 24, '2026-06-01 07:40:00', 'Hadir'),
(325, 212, 24, '2026-06-15 07:40:00', 'Hadir'),
(326, 214, 24, '2026-06-29 07:40:00', 'Hadir'),
(327, 215, 24, '2026-07-13 07:40:00', 'Hadir'),
(328, 200, 25, '2026-02-23 07:00:00', 'Alpa'),
(329, 201, 25, '2026-03-02 07:00:00', 'Alpa'),
(330, 202, 25, '2026-03-09 07:40:00', 'Alpa'),
(331, 203, 25, '2026-03-30 07:40:00', 'Alpa'),
(332, 204, 25, '2026-04-06 07:40:00', 'Alpa'),
(333, 205, 25, '2026-04-13 07:40:00', 'Alpa'),
(334, 206, 25, '2026-04-20 07:40:00', 'Alpa'),
(335, 207, 25, '2026-04-27 07:40:00', 'Alpa'),
(336, 208, 25, '2026-05-18 07:40:00', 'Alpa'),
(337, 209, 25, '2026-05-25 07:40:00', 'Alpa'),
(338, 210, 25, '2026-06-01 07:40:00', 'Alpa'),
(339, 212, 25, '2026-06-15 07:40:00', 'Alpa'),
(340, 214, 25, '2026-06-29 07:40:00', 'Alpa'),
(341, 215, 25, '2026-07-13 07:40:00', 'Alpa'),
(342, 200, 26, '2026-02-23 07:00:00', 'Hadir'),
(343, 201, 26, '2026-03-02 07:00:00', 'Hadir'),
(344, 202, 26, '2026-03-09 07:40:00', 'Hadir'),
(345, 203, 26, '2026-03-30 07:40:00', 'Hadir'),
(346, 204, 26, '2026-04-06 07:40:00', 'Hadir'),
(347, 205, 26, '2026-04-13 07:40:00', 'Hadir'),
(348, 206, 26, '2026-04-20 07:40:00', 'Hadir'),
(349, 207, 26, '2026-04-27 07:40:00', 'Hadir'),
(350, 208, 26, '2026-05-18 07:40:00', 'Hadir'),
(351, 209, 26, '2026-05-25 07:40:00', 'Hadir'),
(352, 210, 26, '2026-06-01 07:40:00', 'Hadir'),
(353, 212, 26, '2026-06-15 07:40:00', 'Hadir'),
(354, 214, 26, '2026-06-29 07:40:00', 'Hadir'),
(355, 215, 26, '2026-07-13 07:40:00', 'Hadir'),
(356, 200, 27, '2026-02-23 07:00:00', 'Hadir'),
(357, 201, 27, '2026-03-02 07:00:00', 'Hadir'),
(358, 202, 27, '2026-03-09 07:40:00', 'Hadir'),
(359, 203, 27, '2026-03-30 07:40:00', 'Hadir'),
(360, 204, 27, '2026-04-06 07:40:00', 'Hadir'),
(361, 205, 27, '2026-04-13 07:40:00', 'Hadir'),
(362, 206, 27, '2026-04-20 07:40:00', 'Hadir'),
(363, 207, 27, '2026-04-27 07:40:00', 'Hadir'),
(364, 208, 27, '2026-05-18 07:40:00', 'Hadir'),
(365, 209, 27, '2026-05-25 07:40:00', 'Hadir'),
(366, 210, 27, '2026-06-01 07:40:00', 'Hadir'),
(367, 212, 27, '2026-06-15 07:40:00', 'Hadir'),
(368, 214, 27, '2026-06-29 07:40:00', 'Hadir'),
(369, 215, 27, '2026-07-13 07:40:00', 'Hadir'),
(370, 200, 28, '2026-02-23 07:00:00', 'Hadir'),
(371, 201, 28, '2026-03-02 07:00:00', 'Hadir'),
(372, 202, 28, '2026-03-09 07:40:00', 'Hadir'),
(373, 203, 28, '2026-03-30 07:40:00', 'Hadir'),
(374, 204, 28, '2026-04-06 07:40:00', 'Hadir'),
(375, 205, 28, '2026-04-13 07:40:00', 'Hadir'),
(376, 206, 28, '2026-04-20 07:40:00', 'Hadir'),
(377, 207, 28, '2026-04-27 07:40:00', 'Hadir'),
(378, 208, 28, '2026-05-18 07:40:00', 'Hadir'),
(379, 209, 28, '2026-05-25 07:40:00', 'Hadir'),
(380, 210, 28, '2026-06-01 07:40:00', 'Hadir'),
(381, 212, 28, '2026-06-15 07:40:00', 'Izin'),
(382, 214, 28, '2026-06-29 07:40:00', 'Hadir'),
(383, 215, 28, '2026-07-13 07:40:00', 'Hadir'),
(384, 200, 29, '2026-02-23 07:00:00', 'Hadir'),
(385, 201, 29, '2026-03-02 07:00:00', 'Hadir'),
(386, 202, 29, '2026-03-09 07:40:00', 'Hadir'),
(387, 203, 29, '2026-03-30 07:40:00', 'Hadir'),
(388, 204, 29, '2026-04-06 07:40:00', 'Hadir'),
(389, 205, 29, '2026-04-13 07:40:00', 'Hadir'),
(390, 206, 29, '2026-04-20 07:40:00', 'Hadir'),
(391, 207, 29, '2026-04-27 07:40:00', 'Hadir'),
(392, 208, 29, '2026-05-18 07:40:00', 'Hadir'),
(393, 209, 29, '2026-05-25 07:40:00', 'Hadir'),
(394, 210, 29, '2026-06-01 07:40:00', 'Hadir'),
(395, 212, 29, '2026-06-15 07:40:00', 'Hadir'),
(396, 214, 29, '2026-06-29 07:40:00', 'Hadir'),
(397, 215, 29, '2026-07-13 07:40:00', 'Alpa'),
(398, 200, 30, '2026-02-23 07:00:00', 'Hadir'),
(399, 201, 30, '2026-03-02 07:00:00', 'Hadir'),
(400, 202, 30, '2026-03-09 07:40:00', 'Hadir'),
(401, 203, 30, '2026-03-30 07:40:00', 'Hadir'),
(402, 204, 30, '2026-04-06 07:40:00', 'Hadir'),
(403, 205, 30, '2026-04-13 07:40:00', 'Hadir'),
(404, 206, 30, '2026-04-20 07:40:00', 'Hadir'),
(405, 207, 30, '2026-04-27 07:40:00', 'Hadir'),
(406, 208, 30, '2026-05-18 07:40:00', 'Hadir'),
(407, 209, 30, '2026-05-25 07:40:00', 'Hadir'),
(408, 210, 30, '2026-06-01 07:40:00', 'Hadir'),
(409, 212, 30, '2026-06-15 07:40:00', 'Hadir'),
(410, 214, 30, '2026-06-29 07:40:00', 'Hadir'),
(411, 215, 30, '2026-07-13 07:40:00', 'Hadir'),
(412, 200, 31, '2026-02-23 07:00:00', 'Hadir'),
(413, 201, 31, '2026-03-02 07:00:00', 'Hadir'),
(414, 202, 31, '2026-03-09 07:40:00', 'Hadir'),
(415, 203, 31, '2026-03-30 07:40:00', 'Hadir'),
(416, 204, 31, '2026-04-06 07:40:00', 'Izin'),
(417, 205, 31, '2026-04-13 07:40:00', 'Hadir'),
(418, 206, 31, '2026-04-20 07:40:00', 'Hadir'),
(419, 207, 31, '2026-04-27 07:40:00', 'Hadir'),
(420, 208, 31, '2026-05-18 07:40:00', 'Hadir'),
(421, 209, 31, '2026-05-25 07:40:00', 'Hadir'),
(422, 210, 31, '2026-06-01 07:40:00', 'Hadir'),
(423, 212, 31, '2026-06-15 07:40:00', 'Hadir'),
(424, 214, 31, '2026-06-29 07:40:00', 'Hadir'),
(425, 215, 31, '2026-07-13 07:40:00', 'Hadir'),
(426, 200, 32, '2026-02-23 07:00:00', 'Hadir'),
(427, 201, 32, '2026-03-02 07:00:00', 'Hadir'),
(428, 202, 32, '2026-03-09 07:40:00', 'Hadir'),
(429, 203, 32, '2026-03-30 07:40:00', 'Hadir'),
(430, 204, 32, '2026-04-06 07:40:00', 'Hadir'),
(431, 205, 32, '2026-04-13 07:40:00', 'Hadir'),
(432, 206, 32, '2026-04-20 07:40:00', 'Hadir'),
(433, 207, 32, '2026-04-27 07:40:00', 'Hadir'),
(434, 208, 32, '2026-05-18 07:40:00', 'Hadir'),
(435, 209, 32, '2026-05-25 07:40:00', 'Hadir'),
(436, 210, 32, '2026-06-01 07:40:00', 'Hadir'),
(437, 212, 32, '2026-06-15 07:40:00', 'Hadir'),
(438, 214, 32, '2026-06-29 07:40:00', 'Hadir'),
(439, 215, 32, '2026-07-13 07:40:00', 'Hadir');

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'created', 'App\\Models\\User', 'created', 199, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 199, \"role\": \"mahasiswa\", \"password\": \"$2y$12$qIONpONr5h.m9SUz70OTF.hzmWeA83.CVaIVtx2eMTXwLkxCPfcAW\", \"username\": \"1111\", \"created_at\": \"2026-09-01 13:34:23\"}}', NULL, '2026-09-01 06:34:23', '2026-09-01 06:34:23'),
(2, 'default', 'created', 'App\\Models\\Mahasiswa', 'created', 92, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 92, \"nim\": \"1111\", \"kelas\": \"A\", \"user_id\": 199, \"id_prodi\": 2, \"semester\": 2, \"created_at\": \"2026-09-01 13:34:23\", \"id_fakultas\": 1, \"nama_lengkap\": \"1111\", \"program_kuliah\": \"Reguler\"}}', NULL, '2026-09-01 06:34:23', '2026-09-01 06:34:23'),
(3, 'default', 'deleted', 'App\\Models\\Agenda', 'deleted', 17, 'App\\Models\\User', 2, '{\"old\": {\"id\": 17, \"kelas\": \"A\", \"lab_id\": 5, \"catatan\": \"sdsadsad\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-08-31\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"1\", \"jam_mulai\": \"15:00:00\", \"created_at\": \"2026-08-31 15:40:42\", \"jam_selesai\": \"20:30:00\", \"mata_kuliah\": \"sadsadsssa\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Karyawan\", \"materi_realisasi\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 1}}', NULL, '2026-09-01 06:35:49', '2026-09-01 06:35:49'),
(4, 'default', 'created', 'App\\Models\\Pengumuman', 'created', 11, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 11, \"judul\": \"crytvubin\", \"admin_id\": 1, \"foto_url\": null, \"created_at\": \"2026-09-01 14:19:46\", \"tanggal_mulai\": \"2026-09-01 14:19:00\", \"isi_pengumuman\": \"xrtcyubi\", \"tanggal_selesai\": \"2026-09-01 14:19:00\"}}', NULL, '2026-09-01 07:19:46', '2026-09-01 07:19:46'),
(5, 'default', 'deleted', 'App\\Models\\Pengumuman', 'deleted', 11, 'App\\Models\\User', 1, '{\"old\": {\"id\": 11, \"judul\": \"crytvubin\", \"admin_id\": 1, \"foto_url\": null, \"created_at\": \"2026-09-01 14:19:46\", \"tanggal_mulai\": \"2026-09-01 14:19:00\", \"isi_pengumuman\": \"xrtcyubi\", \"tanggal_selesai\": \"2026-09-01 14:19:00\"}}', NULL, '2026-09-01 07:26:51', '2026-09-01 07:26:51'),
(6, 'default', 'deleted', 'App\\Models\\Pengumuman', 'deleted', 3, 'App\\Models\\User', 1, '{\"old\": {\"id\": 3, \"judul\": \"ada acara makan makan\", \"admin_id\": 1, \"foto_url\": null, \"created_at\": \"2026-08-19 09:25:25\", \"tanggal_mulai\": null, \"isi_pengumuman\": \"seluruh fk kumpul\", \"tanggal_selesai\": null}}', NULL, '2026-09-01 07:28:04', '2026-09-01 07:28:04'),
(7, 'default', 'deleted', 'App\\Models\\Agenda', 'deleted', 16, 'App\\Models\\User', 1, '{\"old\": {\"id\": 16, \"kelas\": \"A\", \"lab_id\": 5, \"catatan\": \"nnnn\", \"jurusan\": \"Teknik Informatika\", \"tanggal\": \"2026-08-31\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"1\", \"jam_mulai\": \"10:33:00\", \"created_at\": \"2026-08-31 10:33:45\", \"jam_selesai\": \"11:00:00\", \"mata_kuliah\": \"algoritma dan data\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"materi_realisasi\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 1}}', NULL, '2026-09-04 04:47:32', '2026-09-04 04:47:32'),
(8, 'default', 'deleted', 'App\\Models\\Agenda', 'deleted', 15, 'App\\Models\\User', 1, '{\"old\": {\"id\": 15, \"kelas\": \"A\", \"lab_id\": 5, \"catatan\": \"skjasbdadsbas\", \"jurusan\": \"Teknik Informatika\", \"tanggal\": \"2026-08-31\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"1\", \"jam_mulai\": \"09:00:00\", \"created_at\": \"2026-08-31 09:47:46\", \"jam_selesai\": \"10:30:00\", \"mata_kuliah\": \"informatika\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"materi_realisasi\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 1}}', NULL, '2026-09-04 04:47:36', '2026-09-04 04:47:36'),
(9, 'default', 'created', 'App\\Models\\Agenda', 'created', 18, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 18, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"DATA INPUT AGENDA PRAKTIKUM (SESUAI FORM SISTEM)\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-09-04\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"08:00:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"DATA INPUT AGENDA PRAKTIKUM (SESUAI FORM SISTEM)\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(10, 'default', 'created', 'App\\Models\\Agenda', 'created', 19, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 19, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Dosen Pengampu\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-09-04\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"08:00:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Dosen Pengampu\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(11, 'default', 'created', 'App\\Models\\Agenda', 'created', 20, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 20, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(12, 'default', 'created', 'App\\Models\\Agenda', 'created', 21, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 21, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(13, 'default', 'created', 'App\\Models\\Agenda', 'created', 22, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 22, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(14, 'default', 'created', 'App\\Models\\Agenda', 'created', 23, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 23, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(15, 'default', 'created', 'App\\Models\\Agenda', 'created', 24, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 24, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(16, 'default', 'created', 'App\\Models\\Agenda', 'created', 25, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 25, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(17, 'default', 'created', 'App\\Models\\Agenda', 'created', 26, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 26, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(18, 'default', 'created', 'App\\Models\\Agenda', 'created', 27, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 27, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(19, 'default', 'created', 'App\\Models\\Agenda', 'created', 28, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 28, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(20, 'default', 'created', 'App\\Models\\Agenda', 'created', 29, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 29, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(21, 'default', 'created', 'App\\Models\\Agenda', 'created', 30, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 30, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(22, 'default', 'created', 'App\\Models\\Agenda', 'created', 31, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 31, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(23, 'default', 'created', 'App\\Models\\Agenda', 'created', 32, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 32, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(24, 'default', 'created', 'App\\Models\\Agenda', 'created', 33, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 33, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(25, 'default', 'created', 'App\\Models\\Agenda', 'created', 34, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 34, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(26, 'default', 'created', 'App\\Models\\Agenda', 'created', 35, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 35, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:00:34\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:00:34', '2026-09-04 06:00:34'),
(27, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 18, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(28, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 19, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(29, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 20, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(30, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 21, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(31, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 22, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(32, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 23, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(33, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 24, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(34, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 25, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(35, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 26, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(36, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 27, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(37, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 28, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(38, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 29, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(39, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 30, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(40, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 31, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(41, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 32, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(42, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 33, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(43, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 34, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(44, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 35, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:00:35', '2026-09-04 06:00:35'),
(45, 'default', 'created', 'App\\Models\\Agenda', 'created', 36, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 36, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"DATA INPUT AGENDA PRAKTIKUM (SESUAI FORM SISTEM)\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-09-04\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"08:00:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"DATA INPUT AGENDA PRAKTIKUM (SESUAI FORM SISTEM)\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(46, 'default', 'created', 'App\\Models\\Agenda', 'created', 37, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 37, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Dosen Pengampu\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-09-04\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"08:00:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Dosen Pengampu\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(47, 'default', 'created', 'App\\Models\\Agenda', 'created', 38, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 38, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(48, 'default', 'created', 'App\\Models\\Agenda', 'created', 39, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 39, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(49, 'default', 'created', 'App\\Models\\Agenda', 'created', 40, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 40, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(50, 'default', 'created', 'App\\Models\\Agenda', 'created', 41, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 41, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(51, 'default', 'created', 'App\\Models\\Agenda', 'created', 42, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 42, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(52, 'default', 'created', 'App\\Models\\Agenda', 'created', 43, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 43, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(53, 'default', 'created', 'App\\Models\\Agenda', 'created', 44, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 44, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(54, 'default', 'created', 'App\\Models\\Agenda', 'created', 45, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 45, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(55, 'default', 'created', 'App\\Models\\Agenda', 'created', 46, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 46, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(56, 'default', 'created', 'App\\Models\\Agenda', 'created', 47, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 47, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(57, 'default', 'created', 'App\\Models\\Agenda', 'created', 48, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 48, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(58, 'default', 'created', 'App\\Models\\Agenda', 'created', 49, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 49, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(59, 'default', 'created', 'App\\Models\\Agenda', 'created', 50, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 50, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(60, 'default', 'created', 'App\\Models\\Agenda', 'created', 51, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 51, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(61, 'default', 'created', 'App\\Models\\Agenda', 'created', 52, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 52, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(62, 'default', 'created', 'App\\Models\\Agenda', 'created', 53, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 53, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:09:58\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(63, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 36, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(64, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 37, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(65, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 38, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(66, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 39, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(67, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 40, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(68, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 41, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(69, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 42, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(70, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 43, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(71, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 44, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(72, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 45, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(73, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 46, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(74, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 47, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(75, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 48, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:58', '2026-09-04 06:09:58'),
(76, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 49, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:59', '2026-09-04 06:09:59'),
(77, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 50, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:59', '2026-09-04 06:09:59'),
(78, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 51, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:59', '2026-09-04 06:09:59'),
(79, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 52, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:59', '2026-09-04 06:09:59'),
(80, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 53, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:09:59', '2026-09-04 06:09:59'),
(81, 'default', 'created', 'App\\Models\\Agenda', 'created', 54, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 54, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"DATA INPUT AGENDA PRAKTIKUM (SESUAI FORM SISTEM)\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-09-04\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"08:00:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"DATA INPUT AGENDA PRAKTIKUM (SESUAI FORM SISTEM)\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(82, 'default', 'created', 'App\\Models\\Agenda', 'created', 55, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 55, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Dosen Pengampu\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-09-04\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"08:00:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Dosen Pengampu\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(83, 'default', 'created', 'App\\Models\\Agenda', 'created', 56, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 56, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(84, 'default', 'created', 'App\\Models\\Agenda', 'created', 57, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 57, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(85, 'default', 'created', 'App\\Models\\Agenda', 'created', 58, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 58, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(86, 'default', 'created', 'App\\Models\\Agenda', 'created', 59, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 59, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(87, 'default', 'created', 'App\\Models\\Agenda', 'created', 60, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 60, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(88, 'default', 'created', 'App\\Models\\Agenda', 'created', 61, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 61, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(89, 'default', 'created', 'App\\Models\\Agenda', 'created', 62, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 62, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(90, 'default', 'created', 'App\\Models\\Agenda', 'created', 63, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 63, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(91, 'default', 'created', 'App\\Models\\Agenda', 'created', 64, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 64, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(92, 'default', 'created', 'App\\Models\\Agenda', 'created', 65, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 65, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(93, 'default', 'created', 'App\\Models\\Agenda', 'created', 66, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 66, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(94, 'default', 'created', 'App\\Models\\Agenda', 'created', 67, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 67, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(95, 'default', 'created', 'App\\Models\\Agenda', 'created', 68, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 68, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(96, 'default', 'created', 'App\\Models\\Agenda', 'created', 69, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 69, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(97, 'default', 'created', 'App\\Models\\Agenda', 'created', 70, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 70, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(98, 'default', 'created', 'App\\Models\\Agenda', 'created', 71, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 71, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 1, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:27:10\", \"jam_selesai\": \"10:00:00\", \"mata_kuliah\": \"Zulkarnaen Noor Syarif, S.Kom., M.Kom / Anggra Triawan, S.Kom, M.Kom\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": null, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:27:10', '2026-09-04 06:27:10'),
(99, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 54, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(100, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 55, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(101, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 56, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(102, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 57, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(103, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 58, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(104, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 59, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(105, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 60, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(106, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 61, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(107, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 62, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(108, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 63, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(109, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 64, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(110, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 65, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(111, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 66, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(112, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 67, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(113, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 68, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(114, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 69, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(115, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 70, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(116, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 71, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:27:11', '2026-09-04 06:27:11'),
(117, 'default', 'created', 'App\\Models\\Agenda', 'created', 72, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 72, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(118, 'default', 'created', 'App\\Models\\Agenda', 'created', 73, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 73, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(119, 'default', 'created', 'App\\Models\\Agenda', 'created', 74, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 74, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(120, 'default', 'created', 'App\\Models\\Agenda', 'created', 75, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 75, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(121, 'default', 'created', 'App\\Models\\Agenda', 'created', 76, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 76, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(122, 'default', 'created', 'App\\Models\\Agenda', 'created', 77, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 77, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(123, 'default', 'created', 'App\\Models\\Agenda', 'created', 78, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 78, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(124, 'default', 'created', 'App\\Models\\Agenda', 'created', 79, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 79, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(125, 'default', 'created', 'App\\Models\\Agenda', 'created', 80, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 80, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(126, 'default', 'created', 'App\\Models\\Agenda', 'created', 81, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 81, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(127, 'default', 'created', 'App\\Models\\Agenda', 'created', 82, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 82, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(128, 'default', 'created', 'App\\Models\\Agenda', 'created', 83, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 83, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(129, 'default', 'created', 'App\\Models\\Agenda', 'created', 84, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 84, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(130, 'default', 'created', 'App\\Models\\Agenda', 'created', 85, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 85, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(131, 'default', 'created', 'App\\Models\\Agenda', 'created', 86, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 86, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(132, 'default', 'created', 'App\\Models\\Agenda', 'created', 87, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 87, \"kelas\": null, \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik\", \"semester\": \"1\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:40:49\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(133, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 72, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(134, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 73, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(135, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 74, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(136, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 75, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(137, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 76, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(138, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 77, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(139, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 78, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(140, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 79, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:49', '2026-09-04 06:40:49'),
(141, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 80, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:50', '2026-09-04 06:40:50'),
(142, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 81, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:50', '2026-09-04 06:40:50'),
(143, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 82, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:50', '2026-09-04 06:40:50'),
(144, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 83, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:50', '2026-09-04 06:40:50'),
(145, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 84, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:50', '2026-09-04 06:40:50'),
(146, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 85, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:50', '2026-09-04 06:40:50'),
(147, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 86, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:50', '2026-09-04 06:40:50'),
(148, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 87, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:40:50', '2026-09-04 06:40:50'),
(149, 'default', 'created', 'App\\Models\\Agenda', 'created', 88, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 88, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(150, 'default', 'created', 'App\\Models\\Agenda', 'created', 89, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 89, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(151, 'default', 'created', 'App\\Models\\Agenda', 'created', 90, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 90, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(152, 'default', 'created', 'App\\Models\\Agenda', 'created', 91, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 91, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(153, 'default', 'created', 'App\\Models\\Agenda', 'created', 92, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 92, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(154, 'default', 'created', 'App\\Models\\Agenda', 'created', 93, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 93, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(155, 'default', 'created', 'App\\Models\\Agenda', 'created', 94, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 94, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(156, 'default', 'created', 'App\\Models\\Agenda', 'created', 95, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 95, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(157, 'default', 'created', 'App\\Models\\Agenda', 'created', 96, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 96, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(158, 'default', 'created', 'App\\Models\\Agenda', 'created', 97, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 97, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(159, 'default', 'created', 'App\\Models\\Agenda', 'created', 98, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 98, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(160, 'default', 'created', 'App\\Models\\Agenda', 'created', 99, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 99, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(161, 'default', 'created', 'App\\Models\\Agenda', 'created', 100, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 100, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(162, 'default', 'created', 'App\\Models\\Agenda', 'created', 101, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 101, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(163, 'default', 'created', 'App\\Models\\Agenda', 'created', 102, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 102, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(164, 'default', 'created', 'App\\Models\\Agenda', 'created', 103, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 103, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:45:18\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(165, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 88, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(166, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 89, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(167, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 90, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(168, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 91, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(169, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 92, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(170, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 93, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(171, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 94, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(172, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 95, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(173, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 96, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(174, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 97, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(175, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 98, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(176, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 99, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(177, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 100, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(178, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 101, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(179, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 102, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(180, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 103, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:45:18', '2026-09-04 06:45:18'),
(181, 'default', 'created', 'App\\Models\\Agenda', 'created', 104, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 104, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:47:40\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:40', '2026-09-04 06:47:40'),
(182, 'default', 'created', 'App\\Models\\Agenda', 'created', 105, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 105, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:47:40\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:40', '2026-09-04 06:47:40'),
(183, 'default', 'created', 'App\\Models\\Agenda', 'created', 106, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 106, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:40\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:40', '2026-09-04 06:47:40'),
(184, 'default', 'created', 'App\\Models\\Agenda', 'created', 107, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 107, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:40\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:40', '2026-09-04 06:47:40'),
(185, 'default', 'created', 'App\\Models\\Agenda', 'created', 108, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 108, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:40\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:40', '2026-09-04 06:47:40'),
(186, 'default', 'created', 'App\\Models\\Agenda', 'created', 109, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 109, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:40\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:40', '2026-09-04 06:47:40'),
(187, 'default', 'created', 'App\\Models\\Agenda', 'created', 110, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 110, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:40\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:40', '2026-09-04 06:47:40');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(188, 'default', 'created', 'App\\Models\\Agenda', 'created', 111, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 111, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:40\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:40', '2026-09-04 06:47:40'),
(189, 'default', 'created', 'App\\Models\\Agenda', 'created', 112, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 112, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:40\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(190, 'default', 'created', 'App\\Models\\Agenda', 'created', 113, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 113, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:41\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(191, 'default', 'created', 'App\\Models\\Agenda', 'created', 114, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 114, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:41\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(192, 'default', 'created', 'App\\Models\\Agenda', 'created', 115, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 115, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:41\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(193, 'default', 'created', 'App\\Models\\Agenda', 'created', 116, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 116, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:41\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(194, 'default', 'created', 'App\\Models\\Agenda', 'created', 117, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 117, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:41\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(195, 'default', 'created', 'App\\Models\\Agenda', 'created', 118, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 118, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:41\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(196, 'default', 'created', 'App\\Models\\Agenda', 'created', 119, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 119, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:47:41\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(197, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 104, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(198, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 105, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(199, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 106, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(200, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 107, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(201, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 108, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(202, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 109, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(203, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 110, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(204, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 111, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(205, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 112, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(206, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 113, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(207, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 114, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(208, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 115, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(209, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 116, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(210, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 117, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(211, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 118, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(212, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 119, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:47:41', '2026-09-04 06:47:41'),
(213, 'default', 'created', 'App\\Models\\Agenda', 'created', 120, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 120, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(214, 'default', 'created', 'App\\Models\\Agenda', 'created', 121, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 121, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(215, 'default', 'created', 'App\\Models\\Agenda', 'created', 122, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 122, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(216, 'default', 'created', 'App\\Models\\Agenda', 'created', 123, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 123, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(217, 'default', 'created', 'App\\Models\\Agenda', 'created', 124, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 124, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(218, 'default', 'created', 'App\\Models\\Agenda', 'created', 125, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 125, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(219, 'default', 'created', 'App\\Models\\Agenda', 'created', 126, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 126, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(220, 'default', 'created', 'App\\Models\\Agenda', 'created', 127, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 127, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(221, 'default', 'created', 'App\\Models\\Agenda', 'created', 128, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 128, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(222, 'default', 'created', 'App\\Models\\Agenda', 'created', 129, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 129, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(223, 'default', 'created', 'App\\Models\\Agenda', 'created', 130, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 130, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(224, 'default', 'created', 'App\\Models\\Agenda', 'created', 131, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 131, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(225, 'default', 'created', 'App\\Models\\Agenda', 'created', 132, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 132, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(226, 'default', 'created', 'App\\Models\\Agenda', 'created', 133, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 133, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(227, 'default', 'created', 'App\\Models\\Agenda', 'created', 134, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 134, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(228, 'default', 'created', 'App\\Models\\Agenda', 'created', 135, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 135, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik & Sains\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:50:03\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:50:03', '2026-09-04 06:50:03'),
(229, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 120, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(230, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 121, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(231, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 122, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(232, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 123, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(233, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 124, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(234, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 125, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(235, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 126, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(236, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 127, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(237, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 128, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(238, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 129, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(239, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 130, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(240, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 131, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(241, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 132, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(242, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 133, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(243, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 134, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(244, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 135, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:50:04', '2026-09-04 06:50:04'),
(245, 'default', 'created', 'App\\Models\\Agenda', 'created', 136, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 136, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(246, 'default', 'created', 'App\\Models\\Agenda', 'created', 137, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 137, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(247, 'default', 'created', 'App\\Models\\Agenda', 'created', 138, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 138, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(248, 'default', 'created', 'App\\Models\\Agenda', 'created', 139, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 139, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(249, 'default', 'created', 'App\\Models\\Agenda', 'created', 140, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 140, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(250, 'default', 'created', 'App\\Models\\Agenda', 'created', 141, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 141, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(251, 'default', 'created', 'App\\Models\\Agenda', 'created', 142, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 142, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(252, 'default', 'created', 'App\\Models\\Agenda', 'created', 143, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 143, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(253, 'default', 'created', 'App\\Models\\Agenda', 'created', 144, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 144, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(254, 'default', 'created', 'App\\Models\\Agenda', 'created', 145, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 145, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(255, 'default', 'created', 'App\\Models\\Agenda', 'created', 146, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 146, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(256, 'default', 'created', 'App\\Models\\Agenda', 'created', 147, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 147, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(257, 'default', 'created', 'App\\Models\\Agenda', 'created', 148, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 148, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(258, 'default', 'created', 'App\\Models\\Agenda', 'created', 149, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 149, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(259, 'default', 'created', 'App\\Models\\Agenda', 'created', 150, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 150, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(260, 'default', 'created', 'App\\Models\\Agenda', 'created', 151, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 151, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 13:53:16\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 06:53:16', '2026-09-04 06:53:16'),
(261, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 136, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(262, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 137, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(263, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 138, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(264, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 139, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(265, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 140, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(266, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 141, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(267, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 142, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(268, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 143, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(269, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 144, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(270, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 145, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(271, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 146, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(272, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 147, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(273, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 148, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(274, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 149, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(275, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 150, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(276, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 151, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 06:53:17', '2026-09-04 06:53:17'),
(277, 'default', 'created', 'App\\Models\\Agenda', 'created', 152, NULL, NULL, '{\"attributes\": {\"id\": 152, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(278, 'default', 'created', 'App\\Models\\Agenda', 'created', 153, NULL, NULL, '{\"attributes\": {\"id\": 153, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(279, 'default', 'created', 'App\\Models\\Agenda', 'created', 154, NULL, NULL, '{\"attributes\": {\"id\": 154, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(280, 'default', 'created', 'App\\Models\\Agenda', 'created', 155, NULL, NULL, '{\"attributes\": {\"id\": 155, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(281, 'default', 'created', 'App\\Models\\Agenda', 'created', 156, NULL, NULL, '{\"attributes\": {\"id\": 156, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(282, 'default', 'created', 'App\\Models\\Agenda', 'created', 157, NULL, NULL, '{\"attributes\": {\"id\": 157, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(283, 'default', 'created', 'App\\Models\\Agenda', 'created', 158, NULL, NULL, '{\"attributes\": {\"id\": 158, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(284, 'default', 'created', 'App\\Models\\Agenda', 'created', 159, NULL, NULL, '{\"attributes\": {\"id\": 159, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(285, 'default', 'created', 'App\\Models\\Agenda', 'created', 160, NULL, NULL, '{\"attributes\": {\"id\": 160, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(286, 'default', 'created', 'App\\Models\\Agenda', 'created', 161, NULL, NULL, '{\"attributes\": {\"id\": 161, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(287, 'default', 'created', 'App\\Models\\Agenda', 'created', 162, NULL, NULL, '{\"attributes\": {\"id\": 162, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(288, 'default', 'created', 'App\\Models\\Agenda', 'created', 163, NULL, NULL, '{\"attributes\": {\"id\": 163, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(289, 'default', 'created', 'App\\Models\\Agenda', 'created', 164, NULL, NULL, '{\"attributes\": {\"id\": 164, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(290, 'default', 'created', 'App\\Models\\Agenda', 'created', 165, NULL, NULL, '{\"attributes\": {\"id\": 165, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(291, 'default', 'created', 'App\\Models\\Agenda', 'created', 166, NULL, NULL, '{\"attributes\": {\"id\": 166, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(292, 'default', 'created', 'App\\Models\\Agenda', 'created', 167, NULL, NULL, '{\"attributes\": {\"id\": 167, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:50:04\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:50:04', '2026-09-04 08:50:04'),
(293, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 152, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(294, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 153, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(295, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 154, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(296, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 155, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(297, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 156, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(298, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 157, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(299, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 158, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(300, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 159, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(301, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 160, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(302, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 161, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(303, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 162, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(304, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 163, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(305, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 164, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(306, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 165, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(307, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 166, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(308, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 167, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(309, 'default', 'created', 'App\\Models\\Agenda', 'created', 168, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 168, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(310, 'default', 'created', 'App\\Models\\Agenda', 'created', 169, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 169, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(311, 'default', 'created', 'App\\Models\\Agenda', 'created', 170, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 170, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(312, 'default', 'created', 'App\\Models\\Agenda', 'created', 171, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 171, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(313, 'default', 'created', 'App\\Models\\Agenda', 'created', 172, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 172, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(314, 'default', 'created', 'App\\Models\\Agenda', 'created', 173, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 173, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(315, 'default', 'created', 'App\\Models\\Agenda', 'created', 174, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 174, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(316, 'default', 'created', 'App\\Models\\Agenda', 'created', 175, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 175, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(317, 'default', 'created', 'App\\Models\\Agenda', 'created', 176, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 176, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(318, 'default', 'created', 'App\\Models\\Agenda', 'created', 177, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 177, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(319, 'default', 'created', 'App\\Models\\Agenda', 'created', 178, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 178, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(320, 'default', 'created', 'App\\Models\\Agenda', 'created', 179, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 179, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(321, 'default', 'created', 'App\\Models\\Agenda', 'created', 180, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 180, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(322, 'default', 'created', 'App\\Models\\Agenda', 'created', 181, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 181, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(323, 'default', 'created', 'App\\Models\\Agenda', 'created', 182, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 182, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(324, 'default', 'created', 'App\\Models\\Agenda', 'created', 183, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 183, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 15:51:08\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:51:08', '2026-09-04 08:51:08'),
(325, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 168, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(326, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 169, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(327, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 170, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(328, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 171, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(329, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 172, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(330, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 173, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(331, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 174, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(332, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 175, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(333, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 176, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(334, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 177, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(335, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 178, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(336, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 179, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(337, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 180, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(338, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 181, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(339, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 182, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(340, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 183, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:51:09', '2026-09-04 08:51:09'),
(341, 'default', 'created', 'App\\Models\\Agenda', 'created', 184, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 184, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(342, 'default', 'created', 'App\\Models\\Agenda', 'created', 185, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 185, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(343, 'default', 'created', 'App\\Models\\Agenda', 'created', 186, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 186, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(344, 'default', 'created', 'App\\Models\\Agenda', 'created', 187, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 187, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(345, 'default', 'created', 'App\\Models\\Agenda', 'created', 188, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 188, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(346, 'default', 'created', 'App\\Models\\Agenda', 'created', 189, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 189, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(347, 'default', 'created', 'App\\Models\\Agenda', 'created', 190, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 190, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(348, 'default', 'created', 'App\\Models\\Agenda', 'created', 191, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 191, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(349, 'default', 'created', 'App\\Models\\Agenda', 'created', 192, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 192, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(350, 'default', 'created', 'App\\Models\\Agenda', 'created', 193, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 193, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(351, 'default', 'created', 'App\\Models\\Agenda', 'created', 194, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 194, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(352, 'default', 'created', 'App\\Models\\Agenda', 'created', 195, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 195, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(353, 'default', 'created', 'App\\Models\\Agenda', 'created', 196, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 196, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(354, 'default', 'created', 'App\\Models\\Agenda', 'created', 197, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 197, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(355, 'default', 'created', 'App\\Models\\Agenda', 'created', 198, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 198, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(356, 'default', 'created', 'App\\Models\\Agenda', 'created', 199, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 199, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 15:58:47\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(357, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 184, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(358, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 185, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(359, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 186, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(360, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 187, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(361, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 188, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(362, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 189, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(363, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 190, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(364, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 191, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(365, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 192, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(366, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 193, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(367, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 194, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(368, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 195, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(369, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 196, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(370, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 197, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(371, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 198, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(372, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 199, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 08:58:47', '2026-09-04 08:58:47'),
(373, 'default', 'created', 'App\\Models\\Agenda', 'created', 200, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 200, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(374, 'default', 'created', 'App\\Models\\Agenda', 'created', 201, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 201, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:00:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"15:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(375, 'default', 'created', 'App\\Models\\Agenda', 'created', 202, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 202, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(376, 'default', 'created', 'App\\Models\\Agenda', 'created', 203, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 203, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(377, 'default', 'created', 'App\\Models\\Agenda', 'created', 204, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 204, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(378, 'default', 'created', 'App\\Models\\Agenda', 'created', 205, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 205, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(379, 'default', 'created', 'App\\Models\\Agenda', 'created', 206, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 206, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(380, 'default', 'created', 'App\\Models\\Agenda', 'created', 207, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 207, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(381, 'default', 'created', 'App\\Models\\Agenda', 'created', 208, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 208, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(382, 'default', 'created', 'App\\Models\\Agenda', 'created', 209, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 209, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(383, 'default', 'created', 'App\\Models\\Agenda', 'created', 210, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 210, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(384, 'default', 'created', 'App\\Models\\Agenda', 'created', 211, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 211, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(385, 'default', 'created', 'App\\Models\\Agenda', 'created', 212, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 212, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(386, 'default', 'created', 'App\\Models\\Agenda', 'created', 213, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 213, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(387, 'default', 'created', 'App\\Models\\Agenda', 'created', 214, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 214, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(388, 'default', 'created', 'App\\Models\\Agenda', 'created', 215, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 215, \"kelas\": \"Reg\", \"lab_id\": 5, \"catatan\": \"Praktikum Dasar Pemrograman Web\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"2\", \"jam_mulai\": \"14:40:00\", \"created_at\": \"2026-09-04 16:01:22\", \"jam_selesai\": \"16:30:00\", \"mata_kuliah\": \"Praktikum Dasar Pemrograman Web\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:22', '2026-09-04 09:01:22'),
(389, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 200, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(390, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 201, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(391, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 202, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(392, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 203, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(393, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 204, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(394, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 205, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(395, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 206, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(396, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 207, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(397, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 208, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(398, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 209, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(399, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 210, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(400, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 211, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(401, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 212, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(402, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 213, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(403, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 214, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(404, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 215, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:23', '2026-09-04 09:01:23'),
(405, 'default', 'created', 'App\\Models\\Agenda', 'created', 216, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 216, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-02-23\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(406, 'default', 'created', 'App\\Models\\Agenda', 'created', 217, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 217, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-02\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(407, 'default', 'created', 'App\\Models\\Agenda', 'created', 218, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 218, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-09\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(408, 'default', 'created', 'App\\Models\\Agenda', 'created', 219, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 219, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-03-30\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(409, 'default', 'created', 'App\\Models\\Agenda', 'created', 220, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 220, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-06\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(410, 'default', 'created', 'App\\Models\\Agenda', 'created', 221, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 221, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(411, 'default', 'created', 'App\\Models\\Agenda', 'created', 222, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 222, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-20\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(412, 'default', 'created', 'App\\Models\\Agenda', 'created', 223, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 223, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-04-27\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(413, 'default', 'created', 'App\\Models\\Agenda', 'created', 224, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 224, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-18\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(414, 'default', 'created', 'App\\Models\\Agenda', 'created', 225, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 225, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-05-25\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(415, 'default', 'created', 'App\\Models\\Agenda', 'created', 226, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 226, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-01\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(416, 'default', 'created', 'App\\Models\\Agenda', 'created', 227, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 227, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-08\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(417, 'default', 'created', 'App\\Models\\Agenda', 'created', 228, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 228, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-15\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(418, 'default', 'created', 'App\\Models\\Agenda', 'created', 229, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 229, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-22\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(419, 'default', 'created', 'App\\Models\\Agenda', 'created', 230, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 230, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-06-29\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(420, 'default', 'created', 'App\\Models\\Agenda', 'created', 231, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 231, \"kelas\": \"IV / Reg_A\", \"lab_id\": 5, \"catatan\": \"Pengelolaan Data dan DBMS + Praktikum\", \"jurusan\": \"Sistem Informasi\", \"tanggal\": \"2026-07-13\", \"dosen_id\": 11, \"fakultas\": \"Fakultas Teknik dan Sains (FTS)\", \"semester\": \"4\", \"jam_mulai\": \"00:41:00\", \"created_at\": \"2026-09-04 16:01:30\", \"jam_selesai\": \"08:00:00\", \"mata_kuliah\": \"Pengelolaan Data dan DBMS + Praktikum\", \"status_agenda\": \"Selesai\", \"program_kuliah\": \"Reguler\", \"jenis_pertemuan\": \"Praktikum\", \"materi_realisasi\": null, \"dosen_pengampu_id\": 10, \"dosen_waktu_masuk\": null, \"auto_alpha_processed\": 0}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(421, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 216, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(422, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 217, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(423, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 218, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(424, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 219, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(425, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 220, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(426, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 221, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(427, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 222, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(428, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 223, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(429, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 224, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(430, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 225, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(431, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 226, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(432, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 227, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(433, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 228, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(434, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 229, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(435, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 230, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(436, 'default', 'updated', 'App\\Models\\Agenda', 'updated', 231, 'App\\Models\\User', 1, '{\"old\": {\"auto_alpha_processed\": 0}, \"attributes\": {\"auto_alpha_processed\": 1}}', NULL, '2026-09-04 09:01:30', '2026-09-04 09:01:30'),
(440, 'default', 'created', 'App\\Models\\Absensi', 'created', 76, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 76, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(441, 'default', 'created', 'App\\Models\\Absensi', 'created', 77, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 77, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(442, 'default', 'created', 'App\\Models\\Absensi', 'created', 78, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 78, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(443, 'default', 'created', 'App\\Models\\Absensi', 'created', 79, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 79, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(444, 'default', 'created', 'App\\Models\\Absensi', 'created', 80, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 80, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(445, 'default', 'created', 'App\\Models\\Absensi', 'created', 81, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 81, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(446, 'default', 'created', 'App\\Models\\Absensi', 'created', 82, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 82, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(447, 'default', 'created', 'App\\Models\\Absensi', 'created', 83, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 83, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(448, 'default', 'created', 'App\\Models\\Absensi', 'created', 84, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 84, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(449, 'default', 'created', 'App\\Models\\Absensi', 'created', 85, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 85, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(450, 'default', 'created', 'App\\Models\\Absensi', 'created', 86, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 86, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(451, 'default', 'created', 'App\\Models\\Absensi', 'created', 87, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 87, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(452, 'default', 'created', 'App\\Models\\Absensi', 'created', 88, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 88, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(453, 'default', 'created', 'App\\Models\\Absensi', 'created', 89, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 89, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 7, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(454, 'default', 'created', 'App\\Models\\Absensi', 'created', 90, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 90, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(455, 'default', 'created', 'App\\Models\\Absensi', 'created', 91, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 91, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(456, 'default', 'created', 'App\\Models\\Absensi', 'created', 92, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 92, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(457, 'default', 'created', 'App\\Models\\Absensi', 'created', 93, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 93, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(458, 'default', 'created', 'App\\Models\\Absensi', 'created', 94, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 94, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(459, 'default', 'created', 'App\\Models\\Absensi', 'created', 95, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 95, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(460, 'default', 'created', 'App\\Models\\Absensi', 'created', 96, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 96, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(461, 'default', 'created', 'App\\Models\\Absensi', 'created', 97, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 97, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(462, 'default', 'created', 'App\\Models\\Absensi', 'created', 98, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 98, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(463, 'default', 'created', 'App\\Models\\Absensi', 'created', 99, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 99, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(464, 'default', 'created', 'App\\Models\\Absensi', 'created', 100, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 100, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(465, 'default', 'created', 'App\\Models\\Absensi', 'created', 101, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 101, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(466, 'default', 'created', 'App\\Models\\Absensi', 'created', 102, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 102, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(467, 'default', 'created', 'App\\Models\\Absensi', 'created', 103, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 103, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 8, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(468, 'default', 'created', 'App\\Models\\Absensi', 'created', 104, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 104, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(469, 'default', 'created', 'App\\Models\\Absensi', 'created', 105, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 105, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(470, 'default', 'created', 'App\\Models\\Absensi', 'created', 106, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 106, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(471, 'default', 'created', 'App\\Models\\Absensi', 'created', 107, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 107, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(472, 'default', 'created', 'App\\Models\\Absensi', 'created', 108, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 108, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(473, 'default', 'created', 'App\\Models\\Absensi', 'created', 109, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 109, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(474, 'default', 'created', 'App\\Models\\Absensi', 'created', 110, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 110, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(475, 'default', 'created', 'App\\Models\\Absensi', 'created', 111, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 111, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(476, 'default', 'created', 'App\\Models\\Absensi', 'created', 112, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 112, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:20', '2026-09-05 12:31:20'),
(477, 'default', 'created', 'App\\Models\\Absensi', 'created', 113, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 113, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(478, 'default', 'created', 'App\\Models\\Absensi', 'created', 114, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 114, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(479, 'default', 'created', 'App\\Models\\Absensi', 'created', 115, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 115, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(480, 'default', 'created', 'App\\Models\\Absensi', 'created', 116, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 116, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(481, 'default', 'created', 'App\\Models\\Absensi', 'created', 117, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 117, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 9, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(482, 'default', 'created', 'App\\Models\\Absensi', 'created', 118, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 118, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(483, 'default', 'created', 'App\\Models\\Absensi', 'created', 119, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 119, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(484, 'default', 'created', 'App\\Models\\Absensi', 'created', 120, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 120, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(485, 'default', 'created', 'App\\Models\\Absensi', 'created', 121, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 121, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(486, 'default', 'created', 'App\\Models\\Absensi', 'created', 122, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 122, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(487, 'default', 'created', 'App\\Models\\Absensi', 'created', 123, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 123, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(488, 'default', 'created', 'App\\Models\\Absensi', 'created', 124, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 124, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(489, 'default', 'created', 'App\\Models\\Absensi', 'created', 125, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 125, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(490, 'default', 'created', 'App\\Models\\Absensi', 'created', 126, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 126, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(491, 'default', 'created', 'App\\Models\\Absensi', 'created', 127, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 127, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(492, 'default', 'created', 'App\\Models\\Absensi', 'created', 128, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 128, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(493, 'default', 'created', 'App\\Models\\Absensi', 'created', 129, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 129, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(494, 'default', 'created', 'App\\Models\\Absensi', 'created', 130, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 130, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(495, 'default', 'created', 'App\\Models\\Absensi', 'created', 131, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 131, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 10, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(496, 'default', 'created', 'App\\Models\\Absensi', 'created', 132, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 132, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(497, 'default', 'created', 'App\\Models\\Absensi', 'created', 133, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 133, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(498, 'default', 'created', 'App\\Models\\Absensi', 'created', 134, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 134, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(499, 'default', 'created', 'App\\Models\\Absensi', 'created', 135, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 135, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(500, 'default', 'created', 'App\\Models\\Absensi', 'created', 136, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 136, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(501, 'default', 'created', 'App\\Models\\Absensi', 'created', 137, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 137, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(502, 'default', 'created', 'App\\Models\\Absensi', 'created', 138, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 138, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(503, 'default', 'created', 'App\\Models\\Absensi', 'created', 139, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 139, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(504, 'default', 'created', 'App\\Models\\Absensi', 'created', 140, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 140, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(505, 'default', 'created', 'App\\Models\\Absensi', 'created', 141, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 141, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(506, 'default', 'created', 'App\\Models\\Absensi', 'created', 142, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 142, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(507, 'default', 'created', 'App\\Models\\Absensi', 'created', 143, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 143, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(508, 'default', 'created', 'App\\Models\\Absensi', 'created', 144, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 144, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(509, 'default', 'created', 'App\\Models\\Absensi', 'created', 145, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 145, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 11, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(510, 'default', 'created', 'App\\Models\\Absensi', 'created', 146, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 146, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(511, 'default', 'created', 'App\\Models\\Absensi', 'created', 147, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 147, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(512, 'default', 'created', 'App\\Models\\Absensi', 'created', 148, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 148, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(513, 'default', 'created', 'App\\Models\\Absensi', 'created', 149, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 149, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(514, 'default', 'created', 'App\\Models\\Absensi', 'created', 150, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 150, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(515, 'default', 'created', 'App\\Models\\Absensi', 'created', 151, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 151, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(516, 'default', 'created', 'App\\Models\\Absensi', 'created', 152, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 152, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(517, 'default', 'created', 'App\\Models\\Absensi', 'created', 153, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 153, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(518, 'default', 'created', 'App\\Models\\Absensi', 'created', 154, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 154, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(519, 'default', 'created', 'App\\Models\\Absensi', 'created', 155, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 155, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(520, 'default', 'created', 'App\\Models\\Absensi', 'created', 156, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 156, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(521, 'default', 'created', 'App\\Models\\Absensi', 'created', 157, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 157, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(522, 'default', 'created', 'App\\Models\\Absensi', 'created', 158, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 158, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(523, 'default', 'created', 'App\\Models\\Absensi', 'created', 159, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 159, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 12, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(524, 'default', 'created', 'App\\Models\\Absensi', 'created', 160, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 160, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(525, 'default', 'created', 'App\\Models\\Absensi', 'created', 161, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 161, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(526, 'default', 'created', 'App\\Models\\Absensi', 'created', 162, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 162, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(527, 'default', 'created', 'App\\Models\\Absensi', 'created', 163, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 163, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(528, 'default', 'created', 'App\\Models\\Absensi', 'created', 164, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 164, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(529, 'default', 'created', 'App\\Models\\Absensi', 'created', 165, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 165, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(530, 'default', 'created', 'App\\Models\\Absensi', 'created', 166, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 166, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(531, 'default', 'created', 'App\\Models\\Absensi', 'created', 167, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 167, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(532, 'default', 'created', 'App\\Models\\Absensi', 'created', 168, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 168, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(533, 'default', 'created', 'App\\Models\\Absensi', 'created', 169, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 169, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(534, 'default', 'created', 'App\\Models\\Absensi', 'created', 170, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 170, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(535, 'default', 'created', 'App\\Models\\Absensi', 'created', 171, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 171, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(536, 'default', 'created', 'App\\Models\\Absensi', 'created', 172, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 172, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(537, 'default', 'created', 'App\\Models\\Absensi', 'created', 173, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 173, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 13, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(538, 'default', 'created', 'App\\Models\\Absensi', 'created', 174, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 174, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(539, 'default', 'created', 'App\\Models\\Absensi', 'created', 175, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 175, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(540, 'default', 'created', 'App\\Models\\Absensi', 'created', 176, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 176, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(541, 'default', 'created', 'App\\Models\\Absensi', 'created', 177, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 177, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(542, 'default', 'created', 'App\\Models\\Absensi', 'created', 178, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 178, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(543, 'default', 'created', 'App\\Models\\Absensi', 'created', 179, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 179, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(544, 'default', 'created', 'App\\Models\\Absensi', 'created', 180, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 180, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(545, 'default', 'created', 'App\\Models\\Absensi', 'created', 181, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 181, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(546, 'default', 'created', 'App\\Models\\Absensi', 'created', 182, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 182, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(547, 'default', 'created', 'App\\Models\\Absensi', 'created', 183, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 183, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(548, 'default', 'created', 'App\\Models\\Absensi', 'created', 184, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 184, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(549, 'default', 'created', 'App\\Models\\Absensi', 'created', 185, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 185, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(550, 'default', 'created', 'App\\Models\\Absensi', 'created', 186, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 186, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(551, 'default', 'created', 'App\\Models\\Absensi', 'created', 187, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 187, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 14, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(552, 'default', 'created', 'App\\Models\\Absensi', 'created', 188, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 188, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(553, 'default', 'created', 'App\\Models\\Absensi', 'created', 189, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 189, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(554, 'default', 'created', 'App\\Models\\Absensi', 'created', 190, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 190, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(555, 'default', 'created', 'App\\Models\\Absensi', 'created', 191, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 191, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(556, 'default', 'created', 'App\\Models\\Absensi', 'created', 192, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 192, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(557, 'default', 'created', 'App\\Models\\Absensi', 'created', 193, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 193, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(558, 'default', 'created', 'App\\Models\\Absensi', 'created', 194, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 194, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(559, 'default', 'created', 'App\\Models\\Absensi', 'created', 195, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 195, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(560, 'default', 'created', 'App\\Models\\Absensi', 'created', 196, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 196, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(561, 'default', 'created', 'App\\Models\\Absensi', 'created', 197, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 197, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(562, 'default', 'created', 'App\\Models\\Absensi', 'created', 198, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 198, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(563, 'default', 'created', 'App\\Models\\Absensi', 'created', 199, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 199, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(564, 'default', 'created', 'App\\Models\\Absensi', 'created', 200, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 200, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(565, 'default', 'created', 'App\\Models\\Absensi', 'created', 201, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 201, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 15, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(566, 'default', 'created', 'App\\Models\\Absensi', 'created', 202, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 202, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(567, 'default', 'created', 'App\\Models\\Absensi', 'created', 203, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 203, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(568, 'default', 'created', 'App\\Models\\Absensi', 'created', 204, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 204, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(569, 'default', 'created', 'App\\Models\\Absensi', 'created', 205, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 205, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(570, 'default', 'created', 'App\\Models\\Absensi', 'created', 206, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 206, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(571, 'default', 'created', 'App\\Models\\Absensi', 'created', 207, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 207, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(572, 'default', 'created', 'App\\Models\\Absensi', 'created', 208, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 208, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(573, 'default', 'created', 'App\\Models\\Absensi', 'created', 209, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 209, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(574, 'default', 'created', 'App\\Models\\Absensi', 'created', 210, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 210, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(575, 'default', 'created', 'App\\Models\\Absensi', 'created', 211, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 211, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(576, 'default', 'created', 'App\\Models\\Absensi', 'created', 212, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 212, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(577, 'default', 'created', 'App\\Models\\Absensi', 'created', 213, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 213, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(578, 'default', 'created', 'App\\Models\\Absensi', 'created', 214, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 214, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(579, 'default', 'created', 'App\\Models\\Absensi', 'created', 215, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 215, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 16, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(580, 'default', 'created', 'App\\Models\\Absensi', 'created', 216, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 216, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(581, 'default', 'created', 'App\\Models\\Absensi', 'created', 217, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 217, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(582, 'default', 'created', 'App\\Models\\Absensi', 'created', 218, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 218, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(583, 'default', 'created', 'App\\Models\\Absensi', 'created', 219, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 219, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(584, 'default', 'created', 'App\\Models\\Absensi', 'created', 220, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 220, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(585, 'default', 'created', 'App\\Models\\Absensi', 'created', 221, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 221, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(586, 'default', 'created', 'App\\Models\\Absensi', 'created', 222, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 222, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(587, 'default', 'created', 'App\\Models\\Absensi', 'created', 223, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 223, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(588, 'default', 'created', 'App\\Models\\Absensi', 'created', 224, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 224, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(589, 'default', 'created', 'App\\Models\\Absensi', 'created', 225, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 225, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(590, 'default', 'created', 'App\\Models\\Absensi', 'created', 226, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 226, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(591, 'default', 'created', 'App\\Models\\Absensi', 'created', 227, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 227, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(592, 'default', 'created', 'App\\Models\\Absensi', 'created', 228, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 228, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(593, 'default', 'created', 'App\\Models\\Absensi', 'created', 229, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 229, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 17, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(594, 'default', 'created', 'App\\Models\\Absensi', 'created', 230, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 230, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(595, 'default', 'created', 'App\\Models\\Absensi', 'created', 231, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 231, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(596, 'default', 'created', 'App\\Models\\Absensi', 'created', 232, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 232, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(597, 'default', 'created', 'App\\Models\\Absensi', 'created', 233, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 233, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(598, 'default', 'created', 'App\\Models\\Absensi', 'created', 234, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 234, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(599, 'default', 'created', 'App\\Models\\Absensi', 'created', 235, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 235, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(600, 'default', 'created', 'App\\Models\\Absensi', 'created', 236, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 236, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(601, 'default', 'created', 'App\\Models\\Absensi', 'created', 237, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 237, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(602, 'default', 'created', 'App\\Models\\Absensi', 'created', 238, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 238, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(603, 'default', 'created', 'App\\Models\\Absensi', 'created', 239, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 239, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(604, 'default', 'created', 'App\\Models\\Absensi', 'created', 240, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 240, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(605, 'default', 'created', 'App\\Models\\Absensi', 'created', 241, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 241, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(606, 'default', 'created', 'App\\Models\\Absensi', 'created', 242, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 242, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(607, 'default', 'created', 'App\\Models\\Absensi', 'created', 243, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 243, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 18, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(608, 'default', 'created', 'App\\Models\\Absensi', 'created', 244, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 244, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Izin\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(609, 'default', 'created', 'App\\Models\\Absensi', 'created', 245, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 245, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(610, 'default', 'created', 'App\\Models\\Absensi', 'created', 246, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 246, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(611, 'default', 'created', 'App\\Models\\Absensi', 'created', 247, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 247, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(612, 'default', 'created', 'App\\Models\\Absensi', 'created', 248, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 248, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(613, 'default', 'created', 'App\\Models\\Absensi', 'created', 249, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 249, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(614, 'default', 'created', 'App\\Models\\Absensi', 'created', 250, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 250, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(615, 'default', 'created', 'App\\Models\\Absensi', 'created', 251, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 251, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(616, 'default', 'created', 'App\\Models\\Absensi', 'created', 252, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 252, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(617, 'default', 'created', 'App\\Models\\Absensi', 'created', 253, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 253, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(618, 'default', 'created', 'App\\Models\\Absensi', 'created', 254, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 254, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(619, 'default', 'created', 'App\\Models\\Absensi', 'created', 255, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 255, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(620, 'default', 'created', 'App\\Models\\Absensi', 'created', 256, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 256, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(621, 'default', 'created', 'App\\Models\\Absensi', 'created', 257, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 257, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 19, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(622, 'default', 'created', 'App\\Models\\Absensi', 'created', 258, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 258, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(623, 'default', 'created', 'App\\Models\\Absensi', 'created', 259, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 259, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(624, 'default', 'created', 'App\\Models\\Absensi', 'created', 260, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 260, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(625, 'default', 'created', 'App\\Models\\Absensi', 'created', 261, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 261, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(626, 'default', 'created', 'App\\Models\\Absensi', 'created', 262, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 262, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(627, 'default', 'created', 'App\\Models\\Absensi', 'created', 263, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 263, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(628, 'default', 'created', 'App\\Models\\Absensi', 'created', 264, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 264, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(629, 'default', 'created', 'App\\Models\\Absensi', 'created', 265, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 265, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(630, 'default', 'created', 'App\\Models\\Absensi', 'created', 266, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 266, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(631, 'default', 'created', 'App\\Models\\Absensi', 'created', 267, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 267, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(632, 'default', 'created', 'App\\Models\\Absensi', 'created', 268, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 268, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(633, 'default', 'created', 'App\\Models\\Absensi', 'created', 269, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 269, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(634, 'default', 'created', 'App\\Models\\Absensi', 'created', 270, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 270, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(635, 'default', 'created', 'App\\Models\\Absensi', 'created', 271, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 271, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 20, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(636, 'default', 'created', 'App\\Models\\Absensi', 'created', 272, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 272, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(637, 'default', 'created', 'App\\Models\\Absensi', 'created', 273, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 273, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(638, 'default', 'created', 'App\\Models\\Absensi', 'created', 274, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 274, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(639, 'default', 'created', 'App\\Models\\Absensi', 'created', 275, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 275, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(640, 'default', 'created', 'App\\Models\\Absensi', 'created', 276, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 276, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(641, 'default', 'created', 'App\\Models\\Absensi', 'created', 277, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 277, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(642, 'default', 'created', 'App\\Models\\Absensi', 'created', 278, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 278, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(643, 'default', 'created', 'App\\Models\\Absensi', 'created', 279, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 279, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(644, 'default', 'created', 'App\\Models\\Absensi', 'created', 280, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 280, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(645, 'default', 'created', 'App\\Models\\Absensi', 'created', 281, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 281, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(646, 'default', 'created', 'App\\Models\\Absensi', 'created', 282, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 282, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(647, 'default', 'created', 'App\\Models\\Absensi', 'created', 283, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 283, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(648, 'default', 'created', 'App\\Models\\Absensi', 'created', 284, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 284, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(649, 'default', 'created', 'App\\Models\\Absensi', 'created', 285, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 285, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 21, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(650, 'default', 'created', 'App\\Models\\Absensi', 'created', 286, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 286, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(651, 'default', 'created', 'App\\Models\\Absensi', 'created', 287, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 287, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(652, 'default', 'created', 'App\\Models\\Absensi', 'created', 288, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 288, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(653, 'default', 'created', 'App\\Models\\Absensi', 'created', 289, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 289, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(654, 'default', 'created', 'App\\Models\\Absensi', 'created', 290, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 290, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(655, 'default', 'created', 'App\\Models\\Absensi', 'created', 291, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 291, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(656, 'default', 'created', 'App\\Models\\Absensi', 'created', 292, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 292, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(657, 'default', 'created', 'App\\Models\\Absensi', 'created', 293, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 293, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(658, 'default', 'created', 'App\\Models\\Absensi', 'created', 294, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 294, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(659, 'default', 'created', 'App\\Models\\Absensi', 'created', 295, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 295, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(660, 'default', 'created', 'App\\Models\\Absensi', 'created', 296, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 296, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(661, 'default', 'created', 'App\\Models\\Absensi', 'created', 297, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 297, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Izin\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(662, 'default', 'created', 'App\\Models\\Absensi', 'created', 298, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 298, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(663, 'default', 'created', 'App\\Models\\Absensi', 'created', 299, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 299, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 22, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(664, 'default', 'created', 'App\\Models\\Absensi', 'created', 300, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 300, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(665, 'default', 'created', 'App\\Models\\Absensi', 'created', 301, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 301, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(666, 'default', 'created', 'App\\Models\\Absensi', 'created', 302, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 302, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(667, 'default', 'created', 'App\\Models\\Absensi', 'created', 303, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 303, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(668, 'default', 'created', 'App\\Models\\Absensi', 'created', 304, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 304, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(669, 'default', 'created', 'App\\Models\\Absensi', 'created', 305, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 305, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(670, 'default', 'created', 'App\\Models\\Absensi', 'created', 306, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 306, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(671, 'default', 'created', 'App\\Models\\Absensi', 'created', 307, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 307, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(672, 'default', 'created', 'App\\Models\\Absensi', 'created', 308, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 308, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(673, 'default', 'created', 'App\\Models\\Absensi', 'created', 309, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 309, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(674, 'default', 'created', 'App\\Models\\Absensi', 'created', 310, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 310, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(675, 'default', 'created', 'App\\Models\\Absensi', 'created', 311, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 311, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(676, 'default', 'created', 'App\\Models\\Absensi', 'created', 312, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 312, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(677, 'default', 'created', 'App\\Models\\Absensi', 'created', 313, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 313, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 23, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(678, 'default', 'created', 'App\\Models\\Absensi', 'created', 314, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 314, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(679, 'default', 'created', 'App\\Models\\Absensi', 'created', 315, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 315, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(680, 'default', 'created', 'App\\Models\\Absensi', 'created', 316, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 316, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Izin\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(681, 'default', 'created', 'App\\Models\\Absensi', 'created', 317, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 317, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(682, 'default', 'created', 'App\\Models\\Absensi', 'created', 318, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 318, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(683, 'default', 'created', 'App\\Models\\Absensi', 'created', 319, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 319, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(684, 'default', 'created', 'App\\Models\\Absensi', 'created', 320, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 320, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(685, 'default', 'created', 'App\\Models\\Absensi', 'created', 321, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 321, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(686, 'default', 'created', 'App\\Models\\Absensi', 'created', 322, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 322, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(687, 'default', 'created', 'App\\Models\\Absensi', 'created', 323, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 323, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(688, 'default', 'created', 'App\\Models\\Absensi', 'created', 324, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 324, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(689, 'default', 'created', 'App\\Models\\Absensi', 'created', 325, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 325, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(690, 'default', 'created', 'App\\Models\\Absensi', 'created', 326, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 326, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(691, 'default', 'created', 'App\\Models\\Absensi', 'created', 327, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 327, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 24, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(692, 'default', 'created', 'App\\Models\\Absensi', 'created', 328, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 328, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(693, 'default', 'created', 'App\\Models\\Absensi', 'created', 329, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 329, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(694, 'default', 'created', 'App\\Models\\Absensi', 'created', 330, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 330, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(695, 'default', 'created', 'App\\Models\\Absensi', 'created', 331, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 331, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(696, 'default', 'created', 'App\\Models\\Absensi', 'created', 332, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 332, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(697, 'default', 'created', 'App\\Models\\Absensi', 'created', 333, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 333, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(698, 'default', 'created', 'App\\Models\\Absensi', 'created', 334, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 334, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(699, 'default', 'created', 'App\\Models\\Absensi', 'created', 335, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 335, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(700, 'default', 'created', 'App\\Models\\Absensi', 'created', 336, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 336, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(701, 'default', 'created', 'App\\Models\\Absensi', 'created', 337, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 337, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(702, 'default', 'created', 'App\\Models\\Absensi', 'created', 338, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 338, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(703, 'default', 'created', 'App\\Models\\Absensi', 'created', 339, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 339, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(704, 'default', 'created', 'App\\Models\\Absensi', 'created', 340, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 340, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(705, 'default', 'created', 'App\\Models\\Absensi', 'created', 341, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 341, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 25, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(706, 'default', 'created', 'App\\Models\\Absensi', 'created', 342, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 342, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(707, 'default', 'created', 'App\\Models\\Absensi', 'created', 343, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 343, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(708, 'default', 'created', 'App\\Models\\Absensi', 'created', 344, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 344, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(709, 'default', 'created', 'App\\Models\\Absensi', 'created', 345, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 345, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(710, 'default', 'created', 'App\\Models\\Absensi', 'created', 346, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 346, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(711, 'default', 'created', 'App\\Models\\Absensi', 'created', 347, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 347, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(712, 'default', 'created', 'App\\Models\\Absensi', 'created', 348, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 348, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(713, 'default', 'created', 'App\\Models\\Absensi', 'created', 349, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 349, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(714, 'default', 'created', 'App\\Models\\Absensi', 'created', 350, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 350, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(715, 'default', 'created', 'App\\Models\\Absensi', 'created', 351, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 351, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(716, 'default', 'created', 'App\\Models\\Absensi', 'created', 352, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 352, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(717, 'default', 'created', 'App\\Models\\Absensi', 'created', 353, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 353, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(718, 'default', 'created', 'App\\Models\\Absensi', 'created', 354, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 354, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(719, 'default', 'created', 'App\\Models\\Absensi', 'created', 355, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 355, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 26, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(720, 'default', 'created', 'App\\Models\\Absensi', 'created', 356, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 356, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(721, 'default', 'created', 'App\\Models\\Absensi', 'created', 357, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 357, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(722, 'default', 'created', 'App\\Models\\Absensi', 'created', 358, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 358, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(723, 'default', 'created', 'App\\Models\\Absensi', 'created', 359, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 359, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(724, 'default', 'created', 'App\\Models\\Absensi', 'created', 360, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 360, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(725, 'default', 'created', 'App\\Models\\Absensi', 'created', 361, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 361, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(726, 'default', 'created', 'App\\Models\\Absensi', 'created', 362, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 362, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(727, 'default', 'created', 'App\\Models\\Absensi', 'created', 363, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 363, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(728, 'default', 'created', 'App\\Models\\Absensi', 'created', 364, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 364, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(729, 'default', 'created', 'App\\Models\\Absensi', 'created', 365, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 365, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(730, 'default', 'created', 'App\\Models\\Absensi', 'created', 366, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 366, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(731, 'default', 'created', 'App\\Models\\Absensi', 'created', 367, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 367, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:21', '2026-09-05 12:31:21'),
(732, 'default', 'created', 'App\\Models\\Absensi', 'created', 368, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 368, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(733, 'default', 'created', 'App\\Models\\Absensi', 'created', 369, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 369, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 27, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(734, 'default', 'created', 'App\\Models\\Absensi', 'created', 370, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 370, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(735, 'default', 'created', 'App\\Models\\Absensi', 'created', 371, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 371, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(736, 'default', 'created', 'App\\Models\\Absensi', 'created', 372, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 372, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(737, 'default', 'created', 'App\\Models\\Absensi', 'created', 373, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 373, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(738, 'default', 'created', 'App\\Models\\Absensi', 'created', 374, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 374, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(739, 'default', 'created', 'App\\Models\\Absensi', 'created', 375, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 375, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(740, 'default', 'created', 'App\\Models\\Absensi', 'created', 376, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 376, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(741, 'default', 'created', 'App\\Models\\Absensi', 'created', 377, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 377, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(742, 'default', 'created', 'App\\Models\\Absensi', 'created', 378, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 378, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(743, 'default', 'created', 'App\\Models\\Absensi', 'created', 379, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 379, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(744, 'default', 'created', 'App\\Models\\Absensi', 'created', 380, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 380, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(745, 'default', 'created', 'App\\Models\\Absensi', 'created', 381, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 381, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Izin\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(746, 'default', 'created', 'App\\Models\\Absensi', 'created', 382, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 382, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(747, 'default', 'created', 'App\\Models\\Absensi', 'created', 383, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 383, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 28, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(748, 'default', 'created', 'App\\Models\\Absensi', 'created', 384, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 384, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(749, 'default', 'created', 'App\\Models\\Absensi', 'created', 385, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 385, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(750, 'default', 'created', 'App\\Models\\Absensi', 'created', 386, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 386, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(751, 'default', 'created', 'App\\Models\\Absensi', 'created', 387, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 387, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(752, 'default', 'created', 'App\\Models\\Absensi', 'created', 388, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 388, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(753, 'default', 'created', 'App\\Models\\Absensi', 'created', 389, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 389, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(754, 'default', 'created', 'App\\Models\\Absensi', 'created', 390, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 390, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(755, 'default', 'created', 'App\\Models\\Absensi', 'created', 391, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 391, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(756, 'default', 'created', 'App\\Models\\Absensi', 'created', 392, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 392, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(757, 'default', 'created', 'App\\Models\\Absensi', 'created', 393, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 393, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(758, 'default', 'created', 'App\\Models\\Absensi', 'created', 394, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 394, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(759, 'default', 'created', 'App\\Models\\Absensi', 'created', 395, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 395, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(760, 'default', 'created', 'App\\Models\\Absensi', 'created', 396, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 396, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(761, 'default', 'created', 'App\\Models\\Absensi', 'created', 397, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 397, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 29, \"status_kehadiran\": \"Alpa\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(762, 'default', 'created', 'App\\Models\\Absensi', 'created', 398, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 398, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(763, 'default', 'created', 'App\\Models\\Absensi', 'created', 399, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 399, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(764, 'default', 'created', 'App\\Models\\Absensi', 'created', 400, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 400, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(765, 'default', 'created', 'App\\Models\\Absensi', 'created', 401, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 401, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(766, 'default', 'created', 'App\\Models\\Absensi', 'created', 402, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 402, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(767, 'default', 'created', 'App\\Models\\Absensi', 'created', 403, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 403, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(768, 'default', 'created', 'App\\Models\\Absensi', 'created', 404, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 404, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(769, 'default', 'created', 'App\\Models\\Absensi', 'created', 405, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 405, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(770, 'default', 'created', 'App\\Models\\Absensi', 'created', 406, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 406, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(771, 'default', 'created', 'App\\Models\\Absensi', 'created', 407, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 407, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(772, 'default', 'created', 'App\\Models\\Absensi', 'created', 408, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 408, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(773, 'default', 'created', 'App\\Models\\Absensi', 'created', 409, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 409, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(774, 'default', 'created', 'App\\Models\\Absensi', 'created', 410, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 410, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(775, 'default', 'created', 'App\\Models\\Absensi', 'created', 411, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 411, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 30, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(776, 'default', 'created', 'App\\Models\\Absensi', 'created', 412, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 412, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(777, 'default', 'created', 'App\\Models\\Absensi', 'created', 413, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 413, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(778, 'default', 'created', 'App\\Models\\Absensi', 'created', 414, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 414, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(779, 'default', 'created', 'App\\Models\\Absensi', 'created', 415, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 415, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(780, 'default', 'created', 'App\\Models\\Absensi', 'created', 416, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 416, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Izin\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(781, 'default', 'created', 'App\\Models\\Absensi', 'created', 417, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 417, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(782, 'default', 'created', 'App\\Models\\Absensi', 'created', 418, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 418, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(783, 'default', 'created', 'App\\Models\\Absensi', 'created', 419, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 419, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(784, 'default', 'created', 'App\\Models\\Absensi', 'created', 420, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 420, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(785, 'default', 'created', 'App\\Models\\Absensi', 'created', 421, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 421, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(786, 'default', 'created', 'App\\Models\\Absensi', 'created', 422, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 422, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(787, 'default', 'created', 'App\\Models\\Absensi', 'created', 423, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 423, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(788, 'default', 'created', 'App\\Models\\Absensi', 'created', 424, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 424, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(789, 'default', 'created', 'App\\Models\\Absensi', 'created', 425, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 425, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 31, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(790, 'default', 'created', 'App\\Models\\Absensi', 'created', 426, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 426, \"agenda_id\": 200, \"waktu_masuk\": \"2026-02-23 14:00:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(791, 'default', 'created', 'App\\Models\\Absensi', 'created', 427, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 427, \"agenda_id\": 201, \"waktu_masuk\": \"2026-03-02 14:00:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(792, 'default', 'created', 'App\\Models\\Absensi', 'created', 428, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 428, \"agenda_id\": 202, \"waktu_masuk\": \"2026-03-09 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(793, 'default', 'created', 'App\\Models\\Absensi', 'created', 429, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 429, \"agenda_id\": 203, \"waktu_masuk\": \"2026-03-30 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(794, 'default', 'created', 'App\\Models\\Absensi', 'created', 430, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 430, \"agenda_id\": 204, \"waktu_masuk\": \"2026-04-06 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(795, 'default', 'created', 'App\\Models\\Absensi', 'created', 431, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 431, \"agenda_id\": 205, \"waktu_masuk\": \"2026-04-13 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(796, 'default', 'created', 'App\\Models\\Absensi', 'created', 432, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 432, \"agenda_id\": 206, \"waktu_masuk\": \"2026-04-20 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(797, 'default', 'created', 'App\\Models\\Absensi', 'created', 433, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 433, \"agenda_id\": 207, \"waktu_masuk\": \"2026-04-27 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(798, 'default', 'created', 'App\\Models\\Absensi', 'created', 434, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 434, \"agenda_id\": 208, \"waktu_masuk\": \"2026-05-18 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(799, 'default', 'created', 'App\\Models\\Absensi', 'created', 435, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 435, \"agenda_id\": 209, \"waktu_masuk\": \"2026-05-25 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(800, 'default', 'created', 'App\\Models\\Absensi', 'created', 436, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 436, \"agenda_id\": 210, \"waktu_masuk\": \"2026-06-01 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(801, 'default', 'created', 'App\\Models\\Absensi', 'created', 437, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 437, \"agenda_id\": 212, \"waktu_masuk\": \"2026-06-15 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(802, 'default', 'created', 'App\\Models\\Absensi', 'created', 438, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 438, \"agenda_id\": 214, \"waktu_masuk\": \"2026-06-29 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22'),
(803, 'default', 'created', 'App\\Models\\Absensi', 'created', 439, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 439, \"agenda_id\": 215, \"waktu_masuk\": \"2026-07-13 14:40:00\", \"mahasiswa_id\": 32, \"status_kehadiran\": \"Hadir\"}}', NULL, '2026-09-05 12:31:22', '2026-09-05 12:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED NOT NULL,
  `dosen_pengampu_id` bigint UNSIGNED DEFAULT NULL,
  `lab_id` bigint UNSIGNED NOT NULL,
  `mata_kuliah` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_kuliah` enum('Reguler','Karyawan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Reguler',
  `jenis_pertemuan` enum('Teori','Praktikum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Praktikum',
  `kelas` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fakultas` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status_agenda` enum('Akan Datang','Berlangsung','Selesai','Dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `materi_realisasi` text COLLATE utf8mb4_unicode_ci,
  `dosen_waktu_masuk` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `auto_alpha_processed` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `dosen_id`, `dosen_pengampu_id`, `lab_id`, `mata_kuliah`, `program_kuliah`, `jenis_pertemuan`, `kelas`, `semester`, `jurusan`, `fakultas`, `tanggal`, `jam_mulai`, `jam_selesai`, `status_agenda`, `catatan`, `materi_realisasi`, `dosen_waktu_masuk`, `created_at`, `auto_alpha_processed`) VALUES
(200, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-02-23', '14:00:00', '15:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(201, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-03-02', '14:00:00', '15:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(202, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-03-09', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(203, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-03-30', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(204, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-04-06', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(205, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-04-13', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(206, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-04-20', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(207, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-04-27', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(208, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-05-18', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(209, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-05-25', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(210, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-01', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(211, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-08', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(212, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-15', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(213, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-22', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(214, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-29', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(215, 11, 10, 5, 'Praktikum Dasar Pemrograman Web', 'Reguler', 'Praktikum', 'Reg', '2', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-07-13', '14:40:00', '16:30:00', 'Akan Datang', 'Praktikum Dasar Pemrograman Web', NULL, NULL, '2026-09-04 09:01:22', 1),
(216, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-02-23', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(217, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-03-02', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(218, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-03-09', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(219, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-03-30', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(220, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-04-06', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(221, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-04-13', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(222, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-04-20', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(223, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-04-27', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(224, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-05-18', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(225, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-05-25', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(226, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-01', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(227, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-08', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(228, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-15', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(229, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-22', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(230, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-06-29', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1),
(231, 11, 10, 5, 'Pengelolaan Data dan DBMS + Praktikum', 'Reguler', 'Praktikum', 'IV / Reg_A', '4', 'Sistem Informasi', 'Fakultas Teknik dan Sains (FTS)', '2026-07-13', '00:41:00', '08:00:00', 'Akan Datang', 'Pengelolaan Data dan DBMS + Praktikum', NULL, NULL, '2026-09-04 09:01:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Tetap','Tidak Tetap','Honorer','Cuti') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fakultas` bigint UNSIGNED DEFAULT NULL,
  `id_prodi` bigint UNSIGNED DEFAULT NULL,
  `kompetensi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `user_id`, `nip`, `nama`, `jabatan`, `status`, `id_fakultas`, `id_prodi`, `kompetensi`, `created_at`) VALUES
(1, 2, '198501012010121001', 'Dr. Budi Santoso, M.T', NULL, 'Tetap', 3, 11, 'Software Architecture', '2026-08-18 18:22:39'),
(7, 13, '0410117802', 'Novita Br Ginting, S.Kom., M.Kom.', 'Ketua Program Studi', 'Tetap', 3, 21, NULL, '2026-08-31 07:21:46'),
(8, 14, '0406037403', 'Dahlia Widhyaestoeti, S.Kom., M.Kom.', 'Sekretaris Prodi', 'Tetap', 3, 21, NULL, '2026-08-31 07:21:46'),
(9, 15, '0428098402', 'Jejen Jaenudin, S.Kom., M.Kom.', 'Dosen', 'Tetap', 3, 21, NULL, '2026-08-31 07:21:47'),
(10, 16, '0431088705', 'Anggra Triawan, S.Kom., M.Kom.', 'Dosen', 'Tetap', 3, 21, NULL, '2026-08-31 07:21:47'),
(11, 17, '0404128207', 'Zulkarnaen Noor Syarif, S.Kom., M.Kom.', 'Dosen', 'Tetap', 3, 21, NULL, '2026-08-31 07:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_fakultas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id`, `nama_fakultas`, `created_at`) VALUES
(1, 'Fakultas Agama Islam (FAI)', '2026-08-18 18:22:39'),
(2, 'Fakultas Keguruan dan Ilmu Pendidikan (FKIP)', '2026-08-18 18:22:39'),
(3, 'Fakultas Teknik dan Sains (FTS)', '2026-08-18 18:22:39'),
(4, 'Fakultas Ekonomi dan Bisnis (FEB)', '2026-08-18 18:22:39'),
(5, 'Fakultas Hukum (FH)', '2026-08-18 18:22:39'),
(6, 'Fakultas Ilmu Kesehatan (FIKES)', '2026-08-18 18:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kelas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `created_at`) VALUES
(10, 'A', '2026-08-28 08:34:18'),
(11, 'B', '2026-08-28 08:34:31'),
(12, 'C', '2026-08-28 08:34:41');

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium`
--

CREATE TABLE `laboratorium` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lab` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratorium`
--

INSERT INTO `laboratorium` (`id`, `nama_lab`, `lokasi`, `kapasitas`, `created_at`) VALUES
(5, 'lab 1', 'FTS LANTAI 2', 40, '2026-08-31 02:34:58'),
(6, 'lab 3', 'FTS LANTAI 2', 30, '2026-09-01 04:08:07'),
(8, '4', '5', 30, '2026-09-01 04:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium_pengumuman`
--

CREATE TABLE `laboratorium_pengumuman` (
  `id` bigint UNSIGNED NOT NULL,
  `laboratorium_id` bigint UNSIGNED NOT NULL,
  `pengumuman_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fakultas` bigint UNSIGNED DEFAULT NULL,
  `id_prodi` bigint UNSIGNED DEFAULT NULL,
  `program_kuliah` enum('Reguler','Karyawan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Reguler',
  `kelas` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` int DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `user_id`, `nim`, `nama_lengkap`, `id_fakultas`, `id_prodi`, `program_kuliah`, `kelas`, `semester`, `created_at`) VALUES
(1, 108, '2023001001', 'Ahmad Rizky', 3, 11, 'Reguler', 'A', 1, '2026-08-31 08:29:57'),
(2, 109, '2023001002', 'Siti Nurhaliza', 3, 11, 'Reguler', 'A', 1, '2026-08-31 08:29:57'),
(3, 110, '251106050005', 'Muhammad Irghi Alparizi', 3, 21, 'Karyawan', 'A', 3, '2026-08-31 08:54:08'),
(4, 111, '251106050013', 'NADIA NAHDLATUL FITRIYAH', 3, 21, 'Karyawan', 'A', 3, '2026-08-31 08:54:09'),
(5, 112, '251106050020', 'MUHAMMAD NUR RAFLY ARYA PRATAMA', 3, 21, 'Karyawan', 'A', 3, '2026-08-31 08:54:09'),
(6, 113, '251106050023', 'HANATHA RIZA SAPUTRA', 3, 21, 'Karyawan', 'A', 3, '2026-08-31 08:54:09'),
(7, 114, '251106050001', 'M RANGGA IRWAN', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:09'),
(8, 115, '251106050002', 'AIMY KHALISHA ADYA', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:10'),
(9, 116, '251106050003', 'ABY UBAIDILLAH TRIESNA YAHYA', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:10'),
(10, 117, '251106050004', 'FARSYAH ZALFIN SULAEMAN', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:10'),
(11, 118, '251106050006', 'MARSA AMELIA PUTRI', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:10'),
(12, 119, '251106050007', 'Muhamad Kevan Dwi Kurnia', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:11'),
(13, 120, '251106050008', 'MARLAN HARJADISASTRA', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:11'),
(14, 121, '251106050009', 'AHMAD ABQORY MUDABIGHI', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:11'),
(15, 122, '251106050010', 'IBNU MUTAQIN', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:11'),
(16, 123, '251106050011', 'DENNISYA PUTRI RAMADHIAN', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:12'),
(17, 124, '251106050012', 'Bima Mahardika', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:12'),
(18, 125, '251106050014', 'Muhammad Fadli Mustofa Kamal', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:12'),
(19, 126, '251106050015', 'NABILA SAHWA', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:12'),
(20, 127, '251106050016', 'ZHAVIRA OTAVIA RAMADHANI', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:12'),
(21, 128, '251106050017', 'MUHAMMAD YASIN FACHRI', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:13'),
(22, 129, '251106050018', 'Fikri Akbar Dzaky Ashshiddiq', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:13'),
(23, 130, '251106050019', 'Muhamad Pasia Nugraha', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:13'),
(24, 131, '251106050021', 'FIKRI ABDILLAH', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:13'),
(25, 132, '251106050022', 'ANANDA TRI SAPUTRA', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:14'),
(26, 133, '251106050024', 'MUHAMMAD LANTANG ASY\'ARI', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:14'),
(27, 134, '251106050025', 'LANGGENG TRIHADI PRATAMA SADIKIN', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:14'),
(28, 135, '251106050026', 'MALVIANSYAH ZULFIKAR', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:14'),
(29, 136, '251106050027', 'SYAUQI AHZA HAWARI', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:15'),
(30, 137, '251106050028', 'Salsa Bella', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:15'),
(31, 138, '251106050029', 'SITI HAPSOH', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:15'),
(32, 139, '251106050030', 'CHINDY DESITA JULIA PUSPA', 3, 21, 'Reguler', 'A', 3, '2026-08-31 08:54:15'),
(33, 140, '241106051227', 'NANDANA HADAYA TYOVAN', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:16'),
(34, 141, '241106051230', 'MUHAMAD APRIAN SYARONI', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:16'),
(35, 142, '241106051232', 'MUHAMMAD IRHAM', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:16'),
(36, 143, '241106051235', 'NUR MUHAMAD RAFIQ', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:16'),
(37, 144, '241106051236', 'SALSYA NURRUL FADLA', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:16'),
(38, 145, '241106051239', 'ALIKA KHAIRANA SALSABILA', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:17'),
(39, 146, '241106051241', 'ADE LISNIE AENI APRILIANI DEWI', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:17'),
(40, 147, '241106051243', 'SELAMET ALFA RIZKI', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:17'),
(41, 148, '241106051245', 'RAUDYA LAZZUARD ZAKKAWALI', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:17'),
(42, 149, '241106051248', 'AZKA RAADHIATAM MARDIAH', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:18'),
(43, 150, '241106051253', 'FARREL HADI DEWANTO', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:18'),
(44, 151, '241106051800', 'HANIYAH MAHARANI', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:18'),
(45, 152, '241106051934', 'NABILA NUR RAMADHANI', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:18'),
(46, 153, '241106052012', 'ZUFAN ADIWIDYA GHANI PRIONO', 3, 21, 'Reguler', 'A', 5, '2026-08-31 08:54:19'),
(47, 154, '241106051224', 'MUHAMAD YUSUF TANAKA TAMIDA', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:19'),
(48, 155, '241106051225', 'RAHMAN AULIA', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:19'),
(49, 156, '241106051226', 'ALIFA RAHMANIA BM', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:19'),
(50, 157, '241106051228', 'MUHAMAD FIKRI FAUZAN ZARKASIH', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:20'),
(51, 158, '241106051229', 'AGIS NUR KHALIK', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:20'),
(52, 159, '241106051231', 'SITI ALSIYAH ZAHRA', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:20'),
(53, 160, '241106051233', 'MUHAMMAD TEGAR ALI SADDAM BASHIRRAH', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:20'),
(54, 161, '241106051237', 'MUSYADDAD DZIKRI HAQIQI', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:20'),
(55, 162, '241106051242', 'BALQIS AZZAHRA', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:21'),
(56, 163, '241106051244', 'WILDAN NANDA PRAMUDYA', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:21'),
(57, 164, '241106051247', 'NABIL ALI YAQZAN SHIDQI', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:21'),
(58, 165, '241106051251', 'NAZARUDIN', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:21'),
(59, 166, '241106051252', 'ALYA SYAHIRAH', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:22'),
(60, 167, '241106051254', 'RIFAT SHAKA DIFYA ARRASYID', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:22'),
(61, 168, '241106051255', 'ERLIN RAHMADHANI', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:22'),
(62, 169, '241106051773', 'MOHAMMAD LABIB', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:22'),
(63, 170, '241106051936', 'RAIHAN NAUFAL AL GHIFARI', 3, 21, 'Reguler', 'B', 5, '2026-08-31 08:54:23'),
(64, 171, '231106050825', 'REZA ZAINUL ICHWAN', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:23'),
(65, 172, '231106050826', 'RIBY NURHALIFAH PRABOWO', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:23'),
(66, 173, '231106050827', 'REYGINA AZAHRA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:23'),
(67, 174, '231106050828', 'HABIB WIDIANA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:24'),
(68, 175, '231106050829', 'ARSHA KHOIRUNNISA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:24'),
(69, 176, '231106050830', 'MUHAMMAD QOLBIN SALIM', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:24'),
(70, 177, '231106050831', 'DIMAS RIZKI DWI SAPUTRA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:24'),
(71, 178, '231106050832', 'ZEA SATIVA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:25'),
(72, 179, '231106050833', 'VIKY AULIA SAPUTRA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:25'),
(73, 180, '231106050834', 'MUHAMMAD NAJA PADMAWIJAYA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:25'),
(74, 181, '231106050835', 'BUNGA MARYATUL KIBTIAH', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:25'),
(75, 182, '231106050836', 'RANGGA LUTHFI FIRDAUS', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:26'),
(76, 183, '231106050837', 'LUTHFI ADITYA MAKARIM', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:26'),
(77, 184, '231106050838', 'WIRA SANJAYA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:26'),
(78, 185, '231106050840', 'MUHAMMAD FAHRI.S', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:26'),
(79, 186, '231106050841', 'MALAHATI FILDZAH', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:26'),
(80, 187, '231106050842', 'RIZKY TRI MARDIANSYAH', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:27'),
(81, 188, '231106050844', 'DIVYA FAYZA NURAININGSIH', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:27'),
(82, 189, '231106050845', 'MUHAMMAD RAKHAZIKRI', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:27'),
(83, 190, '231106050846', 'NABILA FAIZA NISA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:27'),
(84, 191, '231106050847', 'FARHAN FADILAH MAULANA', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:28'),
(85, 192, '231106051399', 'ZIYAD RAIS', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:28'),
(86, 193, '231106052660', 'DZIKRI FATHULLOH', 3, 21, 'Reguler', 'A', 7, '2026-08-31 08:54:28'),
(87, 194, '221106052721', 'MUHAMMAD AKHTAR HANIF', 3, 21, 'Reguler', 'A', 9, '2026-08-31 08:54:28'),
(88, 195, '221106052735', 'NADIA PUTRI PURNAMA', 3, 21, 'Reguler', 'A', 9, '2026-08-31 08:54:29'),
(89, 196, '221106052725', 'RIOKUNCORO SAKTI', 3, 21, 'Reguler', 'A', 9, '2026-08-31 08:54:29'),
(90, 197, '221106052731', 'ADI AFRIAN WARDIANTO', 3, 21, 'Reguler', 'A', 9, '2026-08-31 08:54:29'),
(91, 198, '221106053363', 'MUHAMMAD ADAM SHAH BIN JASMIN', 3, 21, 'Reguler', 'A', 9, '2026-08-31 08:54:29'),
(92, 199, '1111', '1111', 1, 2, 'Reguler', 'A', 2, '2026-09-01 06:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_08_11_000001_create_digital_board_tables', 1),
(2, '2026_08_19_070918_add_realisasi_and_dosen_absensi_to_agenda_table', 2),
(3, '2026_08_20_000000_add_semester_to_mahasiswa_table', 3),
(4, '2026_08_20_142903_add_auto_alpha_processed_to_agenda_table', 4),
(5, '2026_08_20_144059_create_kelas_table', 5),
(6, '2026_08_31_133320_add_tanggal_to_pengumuman_table', 6),
(7, '2026_08_31_133504_create_laboratorium_pengumuman_table', 6),
(8, '2026_08_31_141126_add_jabatan_to_dosen_table', 7),
(9, '2026_08_31_150711_add_program_kuliah_to_mahasiswa_table', 8),
(10, '2026_08_31_150712_add_program_kuliah_to_agenda_table', 8),
(11, '2026_09_01_132133_create_activity_log_table', 9),
(12, '2026_09_01_132134_add_event_column_to_activity_log_table', 9),
(13, '2026_09_01_132135_add_batch_uuid_column_to_activity_log_table', 9),
(14, '2026_09_02_081318_create_jobs_table', 10),
(15, '2026_09_02_081329_create_job_batches_table', 10),
(16, '2026_09_04_110000_add_jenis_pertemuan_to_agenda_table', 11),
(17, '2026_09_04_120000_make_kelas_nullable_on_agenda_table', 11),
(18, '2026_09_04_130000_add_dosen_pengampu_id_to_agenda_table', 11),
(19, '2026_09_04_140000_make_agenda_fields_nullable', 11);

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_pengumuman` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` datetime DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `foto_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `admin_id`, `judul`, `isi_pengumuman`, `tanggal_mulai`, `tanggal_selesai`, `foto_url`, `created_at`) VALUES
(1, 1, 'Pemeliharaan Jaringan Lab', 'Akan dilakukan perawatan jaringan lokal pada pukul 18:00 WIB.', NULL, NULL, NULL, '2026-08-18 18:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `perizinan`
--

CREATE TABLE `perizinan` (
  `id` bigint UNSIGNED NOT NULL,
  `agenda_id` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `kategori` enum('Izin','Sakit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_persetujuan` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id` bigint UNSIGNED NOT NULL,
  `fakultas_id` bigint UNSIGNED NOT NULL,
  `nama_prodi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `fakultas_id`, `nama_prodi`, `created_at`) VALUES
(1, 1, 'Pendidikan Agama Islam', '2026-08-18 18:22:39'),
(2, 1, 'Hukum Keluarga Islam (Ahwal Al-Syakhshiyyah)', '2026-08-18 18:22:39'),
(3, 1, 'Komunikasi dan Penyiaran Islam', '2026-08-18 18:22:39'),
(4, 1, 'Ekonomi Syariah (FAI)', '2026-08-18 18:22:39'),
(5, 1, 'Pendidikan Guru Madrasah Ibtidaiyah (PGMI)', '2026-08-18 18:22:39'),
(6, 1, 'Bimbingan dan Konseling Pendidikan Islam', '2026-08-18 18:22:39'),
(7, 2, 'Pendidikan Masyarakat', '2026-08-18 18:22:39'),
(8, 2, 'Pendidikan Bahasa Inggris', '2026-08-18 18:22:39'),
(9, 2, 'Teknologi Pendidikan', '2026-08-18 18:22:39'),
(10, 2, 'Pendidikan Vokasional Desain Fashion (PVDF)', '2026-08-18 18:22:39'),
(11, 3, 'Teknik Informatika', '2026-08-18 18:22:39'),
(12, 3, 'Teknik Sipil', '2026-08-18 18:22:39'),
(13, 3, 'Teknik Mesin', '2026-08-18 18:22:39'),
(14, 3, 'Teknik Elektro', '2026-08-18 18:22:39'),
(15, 4, 'Manajemen', '2026-08-18 18:22:39'),
(16, 4, 'Akuntansi', '2026-08-18 18:22:39'),
(17, 4, 'Keuangan dan Perbankan', '2026-08-18 18:22:39'),
(18, 4, 'Ekonomi Syariah (FEB)', '2026-08-18 18:22:39'),
(19, 5, 'Ilmu Hukum', '2026-08-18 18:22:39'),
(20, 6, 'Kesehatan Masyarakat', '2026-08-18 18:22:39'),
(21, 3, 'Sistem Informasi', '2026-08-31 08:26:13');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('csLDchi0ugiMgwDYGMMcmUSnjNmPnvBNfKSStGTb', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJaMVhTZ1pneGJEY0RCSHRYSWtnTDQ2V3Vidlh5WVdoUGtZY0g0N1pxIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0XC9kaWdpdGFsJTIwYm9hcmRcL3B1YmxpY1wvYWRtaW5cL2Fic2Vuc2k/cGFnZT0zIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2RpZ2l0YWwlMjBib2FyZFwvcHVibGljXC9hZG1pblwvcGVuZ2d1bmE/cGFnZT0yIiwicm91dGUiOiJhZG1pbi5wZW5nZ3VuYSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1788625089);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','dosen','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin1', '$2y$12$4j3lndQXndIjwj0BFZ1WQe3.aGbhjcMiexpiEGUFCtcqKcnHuBsum', 'admin', '2026-08-18 18:22:38'),
(2, '198501012010121001', '$2y$12$Ki6/sMUdlB1yASsUDypFpuBZ72.5N4yKhbZLrBmHyLzpxL0xfScZ2', 'dosen', '2026-08-18 18:22:39'),
(13, '0410117802', '$2y$12$C15EMc8XaMUfecFGwiwH9eyRXbgcnBms5eyNZQe9Nm/JPFunBvPvu', 'dosen', '2026-08-31 07:21:46'),
(14, '0406037403', '$2y$12$/F5IrfGUAILlvybQvixAP.miCqq4a9YgpmIbBhqhP4eDc/mK6nmDS', 'dosen', '2026-08-31 07:21:46'),
(15, '0428098402', '$2y$12$1ND.FYXr.FNjGUNm2JStReNqPqDLiaq3tncKqGLHG1Rcy6S3OM5sO', 'dosen', '2026-08-31 07:21:47'),
(16, '0431088705', '$2y$12$SCAV15VecGqvzB5VkB8AxOlP7XlYNHSIAANwz.bjQSnkUJD1aaWLu', 'dosen', '2026-08-31 07:21:47'),
(17, '0404128207', '$2y$12$36Yhhcmsyq/lklhVxiHT.ehDnEINBfR9VtkPvqD/se73ufFHL2kQ2', 'dosen', '2026-08-31 07:21:47'),
(108, '2023001001', '$2y$12$tcwASYJl31.RFcreDb6RSOEsItfY9MZI1HfB1.V4gv8lu8c5RV1de', 'mahasiswa', '2026-08-31 08:29:56'),
(109, '2023001002', '$2y$12$HeIq./jfeDqOjy1h815MKeQG0NISSBPsCqg3Pege2QeBNAZa/lcuS', 'mahasiswa', '2026-08-31 08:29:57'),
(110, '251106050005', '$2y$12$f.JF3dbFS1hidofl3kKHM.H3FnhGXE1Pm5B8oQVei2x670kYcak4O', 'mahasiswa', '2026-08-31 08:54:08'),
(111, '251106050013', '$2y$12$hZBIY5Ae3q9RWDEjVFUjq.a8gvIxChIQfALKYcthb//wUTWxwkv7i', 'mahasiswa', '2026-08-31 08:54:09'),
(112, '251106050020', '$2y$12$6mIwJlMMImLxwlotRGEOjeXw.fBZTkXzbAue5OsM550wh2cDvVDuO', 'mahasiswa', '2026-08-31 08:54:09'),
(113, '251106050023', '$2y$12$A1PvFdUkYrZ25DZlsWfS9ej23Tys.HDmtVXI429DVvKS2mdOCZPmO', 'mahasiswa', '2026-08-31 08:54:09'),
(114, '251106050001', '$2y$12$8rVVbECuy9cDNnmdU.2Ksuy9dlsN.FJHaQMYVPpGVKPTAXo9mTyxi', 'mahasiswa', '2026-08-31 08:54:09'),
(115, '251106050002', '$2y$12$TG97SiY8x/NP8dpIPc9Fhec.AjgQAeSs4PN7lVSeH0OOUL3Tx.joK', 'mahasiswa', '2026-08-31 08:54:10'),
(116, '251106050003', '$2y$12$WrQ7ehnEp3bQHJIUVmpAJuAt8rdlwyfeR4frxFv7lZCs4j64MYJf2', 'mahasiswa', '2026-08-31 08:54:10'),
(117, '251106050004', '$2y$12$YCZtRALWqb9zeBiYvW59OO.XWv4N2Zym/nj2gh6DAenp5hCKQwkZm', 'mahasiswa', '2026-08-31 08:54:10'),
(118, '251106050006', '$2y$12$Z8VK4eZQsrERO.vX148i/.jq7YVlyCnOreQy3Ea4UrUA7M.Dn.dpi', 'mahasiswa', '2026-08-31 08:54:10'),
(119, '251106050007', '$2y$12$l73EsavKUs22oBzIz.9Aou8PRbX9q/Wkb7WczQOVrcg92g4oD6jBi', 'mahasiswa', '2026-08-31 08:54:11'),
(120, '251106050008', '$2y$12$MXL5LXrk3wz2bBTKSzzlJ.GTspjaLgYxcGIlhLmO6IvRk8Ayz5H7y', 'mahasiswa', '2026-08-31 08:54:11'),
(121, '251106050009', '$2y$12$TfjnSaahpcU9etDV1z.37.oFbcrL6KZq0/wWVEKAL1woWGxtH75ii', 'mahasiswa', '2026-08-31 08:54:11'),
(122, '251106050010', '$2y$12$Q4Tk5XggFSG5uyVSPCSdc.AKNbccjFJYqIpHMVAuPrPd7FJpghPfa', 'mahasiswa', '2026-08-31 08:54:11'),
(123, '251106050011', '$2y$12$xEKdKT5bH/3pRUGHUXgPwOJdh69MPx2x9p1RUysu3hGo5f61um8Uy', 'mahasiswa', '2026-08-31 08:54:12'),
(124, '251106050012', '$2y$12$fEL574NJK.qkK9eCKRIR4u6MYmPGzM1ViUUfk84aRhrYSbv5OoTBu', 'mahasiswa', '2026-08-31 08:54:12'),
(125, '251106050014', '$2y$12$/N2fDJJTInhERTAKjBy1dexXot1Zi2nshSNbdxoKZi8eR7sG3jyKa', 'mahasiswa', '2026-08-31 08:54:12'),
(126, '251106050015', '$2y$12$OzeJRTvXTEYquHdQ98QXAeRe0vVjZvNDRsRj4/AqxDiWJGXYMkxJq', 'mahasiswa', '2026-08-31 08:54:12'),
(127, '251106050016', '$2y$12$domQkRVW.vEBiBuOixeHEO8hDJB0uBEcRTE4nxA8T0qbP.z3UrP3C', 'mahasiswa', '2026-08-31 08:54:12'),
(128, '251106050017', '$2y$12$IbpJDjijW88sSGBtpdM.6uqUZ..olTyE50TkOVqfmRobsJKoO6eW2', 'mahasiswa', '2026-08-31 08:54:13'),
(129, '251106050018', '$2y$12$M9FZDCKRnr11dzJdPgq9FuDrh05qrf9hZp/6oROreyKxFQ5OOtQlm', 'mahasiswa', '2026-08-31 08:54:13'),
(130, '251106050019', '$2y$12$Ez6yqKtJc43425qbizrq.e3jxt23GXPgOGWoy7hMmTAnnLQ2fqg5u', 'mahasiswa', '2026-08-31 08:54:13'),
(131, '251106050021', '$2y$12$iueax3moROZSdHpSjp0IA.nQ6QAQcAB7QwUmRnLentflDNjGkHdjC', 'mahasiswa', '2026-08-31 08:54:13'),
(132, '251106050022', '$2y$12$5R/qqIQiwJhtdVsr0Zjl8.fz9z/qWP3.4oX6nPVOCxE/HxhxuA49K', 'mahasiswa', '2026-08-31 08:54:14'),
(133, '251106050024', '$2y$12$dGXHtPZVxjTX3hx.mUZepuDiP/gnRStVNbzFpyHTbc2jCegoV2QK.', 'mahasiswa', '2026-08-31 08:54:14'),
(134, '251106050025', '$2y$12$4aQYFhYK0RTq4jz93ypYVOrkbmNY.5MFjrGqejWwwCQcaTRKJBOsa', 'mahasiswa', '2026-08-31 08:54:14'),
(135, '251106050026', '$2y$12$G58F6xzMTTTs6Uzenttt2eZVquqWkiqZKbI4ftMMxO72ZhmOQg8am', 'mahasiswa', '2026-08-31 08:54:14'),
(136, '251106050027', '$2y$12$NdDv7IP/Bq5uIaNCNLCELuYC29vBtktLub0J9piomzkxIQ/0omHQq', 'mahasiswa', '2026-08-31 08:54:15'),
(137, '251106050028', '$2y$12$nX6d9Uz1WBkPWmuA8DRrWeL.CyoKsUaqqaQN2hUer4hLL6YOpJobe', 'mahasiswa', '2026-08-31 08:54:15'),
(138, '251106050029', '$2y$12$yqQxsE1dU.nSVTJjfnBvK.TyGdbISk8zKr8TdMGO.FMvoK2VjOc6e', 'mahasiswa', '2026-08-31 08:54:15'),
(139, '251106050030', '$2y$12$N/sS/nB/M7XKAEZC/S3J2eYFH.49yCcmA3YLMUvrUZ2wClUa/wO06', 'mahasiswa', '2026-08-31 08:54:15'),
(140, '241106051227', '$2y$12$6UuTGKQSDH8rA4pzSkDKdunch0QSBtbQecBJ5f5sheUMAfRa7At9C', 'mahasiswa', '2026-08-31 08:54:16'),
(141, '241106051230', '$2y$12$rNOHQQf7bkV0qFU7i9AmB.mVL2Yf9kJDHIct0Q7tdvYabce3rARnO', 'mahasiswa', '2026-08-31 08:54:16'),
(142, '241106051232', '$2y$12$.tossBPMRV4JzG0.VL49.OIzKwH4Bo4uGEoJfAs7F1Pd2FmRpZgiC', 'mahasiswa', '2026-08-31 08:54:16'),
(143, '241106051235', '$2y$12$bz7fkBI2va6SDiHfVQTUsOlwe/dAw4veiIf/LvfkluF64GDE9exm.', 'mahasiswa', '2026-08-31 08:54:16'),
(144, '241106051236', '$2y$12$6awPZ/DPioH3808Zw6v7vOaDMexM3i0jO.rNpYGsQDEgVxTWJ0qky', 'mahasiswa', '2026-08-31 08:54:16'),
(145, '241106051239', '$2y$12$utsd9sLwVFRAs30WjJeFZu3nCjFTCn5XhwAS3u8omgk0KwczEv3CS', 'mahasiswa', '2026-08-31 08:54:17'),
(146, '241106051241', '$2y$12$QWc.uw8U3lsmx3NMnvyJsuXy.EkasBNq2C.IivSOO3.4NTH0xTSki', 'mahasiswa', '2026-08-31 08:54:17'),
(147, '241106051243', '$2y$12$yiCGeHTD1e572Av/EauDpOQqXSYuUSuua68Y5VNzCV381vv0PzYc2', 'mahasiswa', '2026-08-31 08:54:17'),
(148, '241106051245', '$2y$12$ETqbvRGrtME7ITcgefIV3ueg91UIyuZiXNYvChmsijjiB8RjFOnmi', 'mahasiswa', '2026-08-31 08:54:17'),
(149, '241106051248', '$2y$12$qNT/cEnVRjcPyUyIgXWTNeEK24kZKoFbcap0bYIF26kDmAGpAWG2K', 'mahasiswa', '2026-08-31 08:54:18'),
(150, '241106051253', '$2y$12$MecDZVT7ZqaIS4.x0vZAc.ix6kDJQF//H5Nza/CF4y4Ub30Ad9zpe', 'mahasiswa', '2026-08-31 08:54:18'),
(151, '241106051800', '$2y$12$jZFbZtPK4jzCBr52w.yxWOyUsO.V2Y/e1qhZwAn3jA7miqSEq46Am', 'mahasiswa', '2026-08-31 08:54:18'),
(152, '241106051934', '$2y$12$8Y0q9vFPMvj7WFHVWBqL4ORWMVEX3hmHo3Hnk3CFHhw0qLqjOLgIe', 'mahasiswa', '2026-08-31 08:54:18'),
(153, '241106052012', '$2y$12$uTjaQWwLXUFL5gVGYW.UI.g763tpT9mz52b6lhIVu6SCNidqOLRSi', 'mahasiswa', '2026-08-31 08:54:19'),
(154, '241106051224', '$2y$12$hMzw76tir.WQUpCzCW8ujOjG5wve9NXWCnuY8KIuZQzLPcn4FmeNK', 'mahasiswa', '2026-08-31 08:54:19'),
(155, '241106051225', '$2y$12$WEp7Egd5NbOaZnYEW4iVfO78tqIOGrF9i08lh0oTdWaucUY0whacu', 'mahasiswa', '2026-08-31 08:54:19'),
(156, '241106051226', '$2y$12$TanbqZ4w3m6E7pCiAWLbCehuTBzrlx40x2LW8x6f0T1ru/V5mj4za', 'mahasiswa', '2026-08-31 08:54:19'),
(157, '241106051228', '$2y$12$COOAuHMEetM2ahO/iwadNOn5XDYkpSLvtmAm1pbu9eDRo0u1ELa3y', 'mahasiswa', '2026-08-31 08:54:20'),
(158, '241106051229', '$2y$12$WkNTOYzl3wYrWY6L3gfMMOlMh3yHEyDhP4YEsMWGtoxq1WtQrs6DK', 'mahasiswa', '2026-08-31 08:54:20'),
(159, '241106051231', '$2y$12$9.2VVoqjBsP8jmF.8qD2h.06/QLiaugNP6XWJ1B6Wx.tdQj1q3wO2', 'mahasiswa', '2026-08-31 08:54:20'),
(160, '241106051233', '$2y$12$dcYAVvAUsemjuSdGFO8ZSO0wf2KbEzeUxQbYSUYljqd183tRHc6pK', 'mahasiswa', '2026-08-31 08:54:20'),
(161, '241106051237', '$2y$12$bW/SbgtJyet8oikOCWVv.OpcLCArCo/EPcEuKsTorWYKbxTr4EotS', 'mahasiswa', '2026-08-31 08:54:20'),
(162, '241106051242', '$2y$12$hUEL.J2uYaD15S7v2E37X.g8YdwN9LhAWUdb2MMIF1BIrmgnqkPrK', 'mahasiswa', '2026-08-31 08:54:21'),
(163, '241106051244', '$2y$12$MWLSmp3a837jcqbV9oDGeekEa0twOHn4C4KtAIP0hMH9Kv.I95Gfm', 'mahasiswa', '2026-08-31 08:54:21'),
(164, '241106051247', '$2y$12$S2QymOHG5QeyqQQVKaMIc.8UsEhyAkVZI.RhMVfbUceQwZfH02pCS', 'mahasiswa', '2026-08-31 08:54:21'),
(165, '241106051251', '$2y$12$YtQn2kpxlsyCicZLErAbzOq5khSIFRcPPJDf6n86NObBT26Uzfqdm', 'mahasiswa', '2026-08-31 08:54:21'),
(166, '241106051252', '$2y$12$79exLL2XaPLHObSzCqPDkuhiU7ma4jPQRPr8qXlz6u.wiJ8OUQN7.', 'mahasiswa', '2026-08-31 08:54:22'),
(167, '241106051254', '$2y$12$A5gPfX557VFCogJfrWwtWub/2.YBJ3fyhpj3lvR6qsjHXCdeTelV2', 'mahasiswa', '2026-08-31 08:54:22'),
(168, '241106051255', '$2y$12$AHOR8n66IFt3Ql99BZEKZe8OFYw6/ychIr4ZZZtzEbJKQJMdzev.W', 'mahasiswa', '2026-08-31 08:54:22'),
(169, '241106051773', '$2y$12$SEdSw9/1Rg6Yfvu1cJjrmeUFT02Pc6q.3n4gPM2eUgztdzOSoI0NS', 'mahasiswa', '2026-08-31 08:54:22'),
(170, '241106051936', '$2y$12$7d0hmt.aN3KMLlXYDeXg2OLrwIbYy3.RxCqZ3E.f3Wo63U84I6NAK', 'mahasiswa', '2026-08-31 08:54:23'),
(171, '231106050825', '$2y$12$4wKpmCpjGMzINQr7MOpFxOd.S3v4DK.LNRtjyR7EsmGnGoXJXqf9S', 'mahasiswa', '2026-08-31 08:54:23'),
(172, '231106050826', '$2y$12$IYdgM6eaGHZ1Hb35Qr1RpeBWUTRId3CXBBeTrJ0PhK9B.jF6Zeoom', 'mahasiswa', '2026-08-31 08:54:23'),
(173, '231106050827', '$2y$12$wnY1SQkZ2Rl2nNbY3GZAjeynsbklqXQRLbFdALmZ.waWl/kV5q0Ca', 'mahasiswa', '2026-08-31 08:54:23'),
(174, '231106050828', '$2y$12$z2Z1Byno5N2lpfUaODic8u7OSatsXjFKoIbMnU9Z.eXDT.L30oAEm', 'mahasiswa', '2026-08-31 08:54:24'),
(175, '231106050829', '$2y$12$ZbycNOdvusmXNO/RQs7pWuLJoE36IhgGUffywd9W1nRpFTo9.OpKS', 'mahasiswa', '2026-08-31 08:54:24'),
(176, '231106050830', '$2y$12$QK4QxqzGrM.pmq0TeJCq1uBmqmQrD063WshFElrw7KDpImVZm3O7C', 'mahasiswa', '2026-08-31 08:54:24'),
(177, '231106050831', '$2y$12$mJWmbwa/RFefPILxcUtDX.gPRIxQL9h4rnjZ.qNaGBVCYxVrGT8pW', 'mahasiswa', '2026-08-31 08:54:24'),
(178, '231106050832', '$2y$12$.h2ZuBAnnkbrYYVFK.qQ3.bfQNy98CxH/HwaLtwdI.Z0CZ7t0k6YK', 'mahasiswa', '2026-08-31 08:54:25'),
(179, '231106050833', '$2y$12$qm/zqCXhgZ9fZuNXni/vuepOH2L6U6XvLvXh5YWS1CJh8vQNYYr/S', 'mahasiswa', '2026-08-31 08:54:25'),
(180, '231106050834', '$2y$12$5vRJWFfXXCVHpoosKIlVHO1lFS6ONpFdvdfMNo8.GauXt9FiR3q7y', 'mahasiswa', '2026-08-31 08:54:25'),
(181, '231106050835', '$2y$12$5blQ0iRp0uv4uhsF12OUWuNodDPjZkNsYhHOqrLHM/KGZkU27f4om', 'mahasiswa', '2026-08-31 08:54:25'),
(182, '231106050836', '$2y$12$4e.ZjQK1vk9NKz4Lhidtju8e8trfjl7PD6U/QPmMtn3J.AcD8u52O', 'mahasiswa', '2026-08-31 08:54:26'),
(183, '231106050837', '$2y$12$3tQXcpwP5OY7VMkxWUinb.0o2Nng437gB1eM5m8UQBoit5bsz1.qq', 'mahasiswa', '2026-08-31 08:54:26'),
(184, '231106050838', '$2y$12$gfXHQBHlWs3PzYOIR7X8ru8k2Fumy6AOK0bgTG2zovHruYm97pU4C', 'mahasiswa', '2026-08-31 08:54:26'),
(185, '231106050840', '$2y$12$khIBH8Xl/IHNfnn15bWI7u0grfMcc4Aj7sYTBdjrTqJKARkZK4imS', 'mahasiswa', '2026-08-31 08:54:26'),
(186, '231106050841', '$2y$12$NkNF/mept/WfVieMAlmjbuSnFWJtSzHhQ/OmPIy8iiP8Xy6H05kbi', 'mahasiswa', '2026-08-31 08:54:26'),
(187, '231106050842', '$2y$12$8gKxsFy5/kQiA/bW8joBf.v61PTmD3ggczzijtqF/S0WtWOx.tM.i', 'mahasiswa', '2026-08-31 08:54:27'),
(188, '231106050844', '$2y$12$mdI8x6AnUPRj9mLUnE9DmeiLF86EeP8CzwXP5PbIOkbLzQ/iLf0VO', 'mahasiswa', '2026-08-31 08:54:27'),
(189, '231106050845', '$2y$12$tKCnZAv4KLInsJzOwU3Of.Ky3ySRSUpNHnZdoLv1BywzvyC16iZfO', 'mahasiswa', '2026-08-31 08:54:27'),
(190, '231106050846', '$2y$12$WAuSfPiy6PPmndWSCQYW/.YVG9QWpmP7gOLuMXg94hiQk9yyDXSsu', 'mahasiswa', '2026-08-31 08:54:27'),
(191, '231106050847', '$2y$12$Xkuu4aT8VUvqYtNTwsZIo.S0gc.AC6KWYIB2OcUgoFebfjwLDt1/6', 'mahasiswa', '2026-08-31 08:54:28'),
(192, '231106051399', '$2y$12$aGOYATruuVv0UsSARia6X..hBRXqYfHcHTonQFGGDFjG37T3hX/Bu', 'mahasiswa', '2026-08-31 08:54:28'),
(193, '231106052660', '$2y$12$qPEGfpPzI2AsQMCROOOi2Ov6CzTSKgXAFW8Dk3E/S3/ldWO.Ky4RW', 'mahasiswa', '2026-08-31 08:54:28'),
(194, '221106052721', '$2y$12$Vfl8nJBbX9wrXqJOp4H6.e2MwI6m4tboSLnEqH.kPvavWSCFOVFW.', 'mahasiswa', '2026-08-31 08:54:28'),
(195, '221106052735', '$2y$12$2ecWyqh1n7Uvl6o19CRJeeiKla4aQErtf9byCyupfYSHbyqfMHcY.', 'mahasiswa', '2026-08-31 08:54:29'),
(196, '221106052725', '$2y$12$gwEs032IaQAKVhz.TPJdO.ldbKL5RmGCpjSDVLi/OMHMlnHYegcfy', 'mahasiswa', '2026-08-31 08:54:29'),
(197, '221106052731', '$2y$12$L50IsprrBh//c7aL9.Lsh.Z6XbcIgbEyAxDRvWUFndDnemh3t3tEW', 'mahasiswa', '2026-08-31 08:54:29'),
(198, '221106053363', '$2y$12$yrp4cLrkC3m.JiXiTd54gefpJ4SpZMGRcd0um5ui0a9JgSqgqUXF2', 'mahasiswa', '2026-08-31 08:54:29'),
(199, '1111', '$2y$12$qIONpONr5h.m9SUz70OTF.hzmWeA83.CVaIVtx2eMTXwLkxCPfcAW', 'mahasiswa', '2026-09-01 06:34:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensi_agenda_id_foreign` (`agenda_id`),
  ADD KEY `absensi_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agenda_dosen_id_foreign` (`dosen_id`),
  ADD KEY `agenda_lab_id_foreign` (`lab_id`),
  ADD KEY `agenda_dosen_pengampu_id_foreign` (`dosen_pengampu_id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dosen_nip_unique` (`nip`),
  ADD KEY `dosen_user_id_foreign` (`user_id`),
  ADD KEY `dosen_id_fakultas_foreign` (`id_fakultas`),
  ADD KEY `dosen_id_prodi_foreign` (`id_prodi`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_nama_kelas_unique` (`nama_kelas`);

--
-- Indexes for table `laboratorium`
--
ALTER TABLE `laboratorium`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laboratorium_pengumuman`
--
ALTER TABLE `laboratorium_pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laboratorium_pengumuman_laboratorium_id_foreign` (`laboratorium_id`),
  ADD KEY `laboratorium_pengumuman_pengumuman_id_foreign` (`pengumuman_id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mahasiswa_nim_unique` (`nim`),
  ADD KEY `mahasiswa_user_id_foreign` (`user_id`),
  ADD KEY `mahasiswa_id_fakultas_foreign` (`id_fakultas`),
  ADD KEY `mahasiswa_id_prodi_foreign` (`id_prodi`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengumuman_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `perizinan`
--
ALTER TABLE `perizinan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perizinan_agenda_id_foreign` (`agenda_id`),
  ADD KEY `perizinan_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodi_fakultas_id_foreign` (`fakultas_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=440;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=804;

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `laboratorium`
--
ALTER TABLE `laboratorium`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `laboratorium_pengumuman`
--
ALTER TABLE `laboratorium_pengumuman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `perizinan`
--
ALTER TABLE `perizinan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agenda_dosen_pengampu_id_foreign` FOREIGN KEY (`dosen_pengampu_id`) REFERENCES `dosen` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `agenda_lab_id_foreign` FOREIGN KEY (`lab_id`) REFERENCES `laboratorium` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dosen_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dosen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laboratorium_pengumuman`
--
ALTER TABLE `laboratorium_pengumuman`
  ADD CONSTRAINT `laboratorium_pengumuman_laboratorium_id_foreign` FOREIGN KEY (`laboratorium_id`) REFERENCES `laboratorium` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laboratorium_pengumuman_pengumuman_id_foreign` FOREIGN KEY (`pengumuman_id`) REFERENCES `pengumuman` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswa_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `perizinan`
--
ALTER TABLE `perizinan`
  ADD CONSTRAINT `perizinan_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `perizinan_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_fakultas_id_foreign` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
