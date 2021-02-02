-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2020 at 08:14 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `midor_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jorge Reyes-Sztayzel', 'jreyess@technip.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'w76q3P1Dup0QzakaV4ZEWupKf6gYpjaq70dswEzpdyQauuX4JJ5CxrdnMumV', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(2, 'Albert Casas-Marti', 'acasas@technip.com', '$2y$10$kgDMKIfEulARGXTQIrz1H..iXfi.bfHSprVDhXSYCeWFi3UxGqiCW', 'wGoLSuj6OGzPXSiAyGEYAWOcZ56XcdjXO9TED3yKBKgpOMkA8aOz2NobZqH1', '2017-05-26 05:08:53', '2020-05-05 05:40:24'),
(3, 'LE-Raul Salas-Cuesta', 'LE-raul.salas-cuesta@technipfmc.com', '$2y$10$Qz4r40nOBoHBuo8J38YupeLlBwrF/23fbFWKpAcdDOxTyUnanm9xa', 'OsXR2xgTi9dqnV81uUIbqygFswxxcvkmUysxwijAja43u2aEcjHEWmkIIPAy', '2017-05-26 05:08:53', '2020-04-04 06:42:51'),
(4, 'LE-Mario Garcia-Rondon', 'LE-mario.garcia-rondon@technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', '16oJpYSYifPIrDg6yJb3gyTjcvTLWbU8aCvYs0d12MCjFHDcw0kQe5urlLHN', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(5, 'LD-Alberto Ruiz-Carranza-External ', 'LD-alberto.ruiz-carranza@external.technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'OsXR2xgTi9dqnV81uUIbqygFswxxcvkmUysxwijAja43u2aEcjHEWmkIIPAy', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(6, 'LD-Jose-Ricardo Blanco-Molina', 'LD-jose-ricardo.blanco-molina@technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(7, 'LD-Carlos Calderon', 'LD-carlos.calderon@technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'OsXR2xgTi9dqnV81uUIbqygFswxxcvkmUysxwijAja43u2aEcjHEWmkIIPAy', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(8, 'ST-Pere Macia-Rosell', 'ST-pere.macia-rosell@technipfmc.com', '$2y$10$5yIN4yivy0x.7.v1xxmcTOokzKow5tCh6XUvuHwrL/ppXKptWzk1.', 'Ss5Lz3QSPyeOkH1uUG8mvQcjqIUA1WLf4RGetmjyxLDxBFSazT0PleClPBU4', '2017-05-26 05:08:53', '2020-04-03 11:25:51'),
(9, 'D-Albert Font-Carrascosa', 'D-albert.font-carrascosa@technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'OsXR2xgTi9dqnV81uUIbqygFswxxcvkmUysxwijAja43u2aEcjHEWmkIIPAy', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(10, 'D-Giuseppe Passero', 'D-giuseppe.passero@technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(11, 'D-Hernando Poggiese-Moran', 'D-hernando.poggiese-moran@technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'OsXR2xgTi9dqnV81uUIbqygFswxxcvkmUysxwijAja43u2aEcjHEWmkIIPAy', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(12, 'D-Jose-Luis Magro-Gonzalez', 'D-jose-luis.magro-gonzalez@technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(13, 'D-Simone Passarelli', 'D-simone.passarelli@technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'mDZ7P2leQB43LNdLh8lyGtdM7PsO2SKqF3iDKzCvSueEdpXtDmwA30z3mO6t', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(14, 'D-Jorge-Luis Pirela-External', 'D-jorge-luis.pirela@external.technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(15, 'ST-Jose-Antonio Adrio-Martin', 'ST-jose-antonio.adrio-martin@technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'JIh10dku6VIG9w819jufqSrxhqvtr7LvwiF9noWrKNuVlnBn45MmLLHuMjxa', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(16, 'ST-Gabriel Morcillo-Parejo', 'ST-gabriel.morcillo-parejo@technipfmc.com', '$2y$10$HlRtl/dZvxBcImmufx02JerSDhA4t81pqVJj12eMCdt7/vpju7NjS', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2020-04-07 02:30:26'),
(17, 'ST-Karina Spinelli', 'ST-karina.spinelli@technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(18, 'ST-Carlos Hernandez-Orence-External', 'ST-carlos.hernandez-orence@external.technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', '09nSBOD5Ck2D5wuyyqwEqI3J565UyTmsJAU0Ly21mIHzvGth6HL8P2vecKZt', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(19, 'SP-Faustino Lopez-Garrido', 'SP-faustino.lopez-garrido@technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(20, 'Marc Pascual-Delgado', 'marc.pascual-delgado@technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'pztA24Qhu2zPVLqTF0cMP5gupLkKIzFffQb5fRcZPOx8UQFGtmjC1vj5anOk', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(21, 'SP-Simone Passarelli', 'SP-simone.passarelli@technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'u8UgOxVPI91R4KKrpJCWvA07Pdt0uGgOommjDFiCr14RAbjBwpDxwxt2x5Ut', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(22, 'SP-Carlos Hernandez-Orence-External', 'SP-carlos.hernandez-orence@external.technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'GJCFLB61GPPZOPm2nt7t3xUfDyFvHG8v5XIEDAiyPxCfVNRnm4CkmQ4UUdeH', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(23, 'SL-Albert Font-Carrascosa', 'SL-albert.font-carrascosa@technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'OsXR2xgTi9dqnV81uUIbqygFswxxcvkmUysxwijAja43u2aEcjHEWmkIIPAy', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(24, 'SL-Giuseppe Passero', 'SL-giuseppe.passero@technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(25, 'SL-Hernando Poggiese-Moran', 'SL-hernando.poggiese-moran@technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'OsXR2xgTi9dqnV81uUIbqygFswxxcvkmUysxwijAja43u2aEcjHEWmkIIPAy', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(26, 'SL-Jose-Luis Magro-Gonzalez', 'SL-jose-luis.magro-gonzalez@technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(27, 'SL-Simone Passarelli', 'SL-simone.passarelli@technipfmc.com', '$2y$10$RQx07/mac2OVe/fZgYe.teUZU0htKJn816Hes9mUaHg5EXumACJKy', 'NIECXKJqZGshQfUrvLzrtgVc9vCLupIhwMv1reA4IuAR2MEtZcazQilZKCZn', '2017-05-26 05:08:53', '2018-05-09 11:57:00'),
(28, 'SL-Jorge-Luis Pirela-External', 'SL-jorge-luis.pirela@external.technipfmc.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'TtrKVqH52zx8ps4XZHUyynLlqBdWuNhDHdnjBLKSQURR2K4RAFbvzIbBQQbX', '2017-05-26 05:08:53', '2018-04-16 12:08:58'),
(100, 'Design', 'design@technip.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'UXt3GtW5nAaBTF1UgXsxNEButq2jlRgyr99LC0os71eswZqaeyuLjKE7ge8M', '2017-05-26 03:08:53', '2018-04-16 10:08:58'),
(101, 'Stress', 'stress@technip.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'hhN5fnZ4sT1JbzkyX26qAskcYqM0JKRnNPyMuHvd0TXcTOfRSFcXo1stURoW', '2017-05-26 03:08:53', '2018-04-16 10:08:58'),
(102, 'Supports', 'supports@technip.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'Yg12tfbVE8ExqWybLWSEcy0VlHGvUifCF6XUbURL2u83JruNY7yd76EGbd7r', '2017-05-26 03:08:53', '2018-04-16 10:08:58'),
(103, 'Spool', 'spool@technip.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'bhj23W55kV6jhfgdCGTyLKuIT0UZQDlu3l9U0LqrojAjnu3rG6pdsISBkJIq', '2017-05-26 03:08:53', '2018-04-16 10:08:58'),
(104, 'Iso', 'iso@technip.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'L4zgJqOfteYnHzY2wnvWJLarnpqOqWiAQhjUPQzWZAwxxQ09cqaeh9sMHsKU', '2017-05-26 03:08:53', '2018-04-16 10:08:58'),
(105, 'Lead', 'lead@technip.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'Abc1zRvbU3BUz6l9Uf1w0cAJAeBE3LdIGBmMl3XkVS3umyCQMdFX9xoYjIL9', '2017-05-26 03:08:53', '2018-04-16 10:08:58'),
(106, 'Isomaster', 'isomaster@technip.com', '$2y$10$Kl54zgNuJSuvEgAXv.7oMOoEl2b7dObhZv9FqGVsrGsDTiNm937Du', 'gw2b0BbWPesTgYlnup1Qg8W7IwsWFiEqLWoIRksjX69vKFUUpMcecbBntwXw', '2017-05-26 03:08:53', '2018-04-16 10:08:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
