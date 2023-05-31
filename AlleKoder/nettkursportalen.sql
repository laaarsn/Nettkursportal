-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18. Apr, 2023 09:22 AM
-- Tjener-versjon: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nettkursportalen`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `bilde_user`
--

CREATE TABLE `bilde_user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `brukernavn` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `bilde_user`
--

INSERT INTO `bilde_user` (`id`, `name`, `image`, `brukernavn`) VALUES
(1, 'Malene', 'Malene - 2023.02.17 - 08.24.50pm.jpg', 'malla'),
(2, 'Johanne', 'noprofile.jpg', 'johanne'),
(3, 'Lars', 'Lars - 2023.04.14 - 02.17.51pm.png', 'Lars'),
(4, 'laarsn', 'noprofile.jpg', 'laarsn'),
(5, 'kjell', 'noprofile.jpg', 'kjell'),
(6, 'dag', 'noprofile.jpg', 'dag'),
(7, 'ola', 'ola - 2023.02.19 - 03.45.34am.jpg', 'ola'),
(8, 'solan', 'noprofile.jpg', 'solan'),
(9, 'dagroooos', 'noprofile.jpg', 'dagros'),
(10, 'test', 'test - 2023.02.20 - 11.44.20am.jpg', 'test'),
(11, 'vidar', 'noprofile.jpg', 'vidar'),
(12, 'Holger', 'noprofile.jpg', 'Holger'),
(13, 'Kari', 'Kari - 2023.02.17 - 03.54.38pm.jpg', 'kari'),
(14, 'Pål', 'noprofile.jpg', 'Pål'),
(15, 'Johnny', 'noprofile.jpg', 'johnny'),
(16, 'Sofus', 'noprofile.jpg', 'sofus');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `brukere`
--

CREATE TABLE `brukere` (
  `bruker_id` int(10) NOT NULL,
  `brukernavn` varchar(256) NOT NULL,
  `passord` varchar(256) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `fornavn` varchar(256) NOT NULL,
  `etternavn` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `brukere`
--

INSERT INTO `brukere` (`bruker_id`, `brukernavn`, `passord`, `mail`, `fornavn`, `etternavn`) VALUES
(1, 'lars', '12345', 'laarsn@gmail.com', 'Odne', 'Hårstad Mehus'),
(2, 'laarsn', '123', 'larshi_@hotmail.com', 'Lars', 'Mehus'),
(3, 'kjell', '123', 'kjellsen@sol.no', 'Kjell', 'Hansen'),
(4, 'dag', '123', 'dag@hotmail.com', 'Dag', 'Solstad'),
(5, 'ola', '123', 'ola@msn.com', 'Ola', 'Ekrem'),
(6, 'solan', '123', 'solan@flaaklypa.no', 'Solan', 'Gundersen'),
(7, 'malla', '123', 'malla@hotmail.com', 'Margrete', 'Larsen'),
(8, 'dagros', '123', 'dag@gmail.no', 'Dagrun', 'Lunde'),
(9, 'kari', '123', 'kari@gmail.com', 'Kari', 'Berg'),
(10, 'test', '123', 'test@test.com', 'test', 'Mehus'),
(11, 'johanne', '123', 'joohanne@sol.no', 'Johanne', 'Bergmann'),
(12, 'Holger', '123', 'holg@msn.com', 'Lars', 'Wessel'),
(13, 'vidar', '123', 'vidar@gmail.com', 'Vidar', 'Villa'),
(14, 'janne', '123', 'janne@gmail.com', 'Janne', 'Sarinen'),
(15, 'Pål', '123', 'paal@hotmail.com', 'Pål', 'Lund'),
(16, 'johnny', '123', 'johnny@msn.com', 'Johnny', 'Myra'),
(17, 'sofus', '123', 'sofus@gmail.com', 'Sofus', 'Landmark');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `calendar_event_master`
--

CREATE TABLE `calendar_event_master` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_start_date` date DEFAULT NULL,
  `event_end_date` date DEFAULT NULL,
  `brukernavn` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `calendar_event_master`
--

INSERT INTO `calendar_event_master` (`event_id`, `event_name`, `event_start_date`, `event_end_date`, `brukernavn`) VALUES
(1, 'Møte med Horgen', '2023-02-27', '2023-02-28', 'lars'),
(4, 'Hyttetur', '2023-03-10', '2023-03-12', 'test'),
(12, 'Strikkekurs', '2023-03-15', '2023-03-18', 'test'),
(13, 'Dansekurs', '2023-03-14', '2023-03-15', 'lars'),
(14, 'spise med jeanette', '2023-03-16', '2023-03-17', 'malla'),
(16, 'Møte med Horgen 20:30', '2023-03-07', '2023-03-08', 'lars'),
(31, 'Malekurs', '2023-12-11', '2023-12-11', 'lars'),
(45, 'Møte med Horgen', '2023-03-30', '2023-03-31', 'lars'),
(47, 'Røykdykkerkurs', '2023-10-24', '2023-10-24', 'lars'),
(48, 'Møte med Horgen kl 09:30', '2023-04-17', '2023-04-18', 'lars'),
(55, 'Jeger-kurs', '2023-10-20', '2023-10-20', 'lars'),
(56, 'Swing-kurs', '2023-08-14', '2023-08-14', 'solan'),
(57, 'Swing-kurs', '2023-08-14', '2023-08-14', 'lars'),
(59, 'Swing-kurs', '2023-08-14', '2023-08-14', 'test'),
(60, 'Ølbryggerkurs', '2023-10-16', '2023-10-16', 'lars'),
(61, 'Fiskekurs', '2024-01-14', '2024-01-14', 'lars');



--
-- Tabellstruktur for tabell `grafer_sektor`
--

CREATE TABLE `grafer_sektor` (
  `id` int(5) NOT NULL,
  `kursnavn` varchar(50) NOT NULL,
  `antall` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `grafer_sektor`
--

INSERT INTO `grafer_sektor` (`id`, `kursnavn`, `antall`) VALUES
(1, 'Fiskekurs', '4'),
(2, 'Swing-kurs', '5'),
(3, 'Karatekurs', '0'),
(4, 'Matlagingskurs', '2'),
(5, 'Ølbryggerkurs', '1'),
(6, 'Jeger-kurs', '3'),
(7, 'Språkkurs Fransk', '2'),
(8, 'Røykdykkerkurs ', '3'),
(9, 'Sushi-kurs', '1'),
(10, 'Malekurs', '4'),
(11, 'Keramikk-kurs', '0'),
(12, 'Engelskkurs', '1'),
(13, 'salsa-kurs', '0'),
(14, 'svømmekurs', '0'),
(15, 'Jodlekurs', '0'),
(16, 'testkurs', '0');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `grafer_stolpe`
--

CREATE TABLE `grafer_stolpe` (
  `id` int(50) NOT NULL,
  `kursnavn` varchar(50) NOT NULL,
  `inntekt` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `grafer_stolpe`
--

INSERT INTO `grafer_stolpe` (`id`, `kursnavn`, `inntekt`) VALUES
(1, 'Fiskekurs', '1596'),
(2, 'Swing-kurs', '1845'),
(3, 'Karatekurs', '0'),
(4, 'Matlagingskurs', '598'),
(5, 'Ølbryggerkurs', '599'),
(6, 'Jeger-kurs', '2697'),
(7, 'Språkkurs Fransk', '998'),
(8, 'Røykdykkerkurs', '11997'),
(9, 'Sushi-kurs', '699'),
(10, 'Malekurs', '1996'),
(11, 'Keramikk-kurs', '0'),
(12, 'Engelskkurs', '999'),
(13, 'salsa-kurs', '0'),
(14, 'svømmekurs', '0'),
(15, 'Jodlekurs', '0'),
(16, 'testkurs', '0');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `kurs`
--

CREATE TABLE `kurs` (
  `kurs_id` int(10) NOT NULL,
  `kursnavn` varchar(50) NOT NULL,
  `maksantall` int(10) NOT NULL,
  `dato` date NOT NULL,
  `oppstart` varchar(256) NOT NULL,
  `sted` varchar(256) NOT NULL,
  `pris` int(10) NOT NULL,
  `info` varchar(700) NOT NULL,
  `status` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `kurs`
--

INSERT INTO `kurs` (`kurs_id`, `kursnavn`, `maksantall`, `dato`, `oppstart`, `sted`, `pris`, `info`, `status`) VALUES
(1, 'Fiskekurs', 4, '2023-12-12', '2024-01-14', 'Oslo friluftssenter, rom 301.', 399, 'Lær mer om fisking og villmarksliv.\r\nKontakt: Lars Monsen.\r\nTelefon: 45 46 46 70.\r\nOppmøte: kl 08:00.', 'aktiv'),
(2, 'Swing-kurs', 8, '2023-05-20', '2023-08-14', 'Nydalen dansesenter', 369, 'Grunnleggende swing-kurs for folk i alle aldre.\r\nKontaktperson: Åse Bergmann.\r\nMail :bergmann@hotmail.com.\r\nkl 13:00', 'aktiv'),
(3, 'Karatekurs', 7, '2022-12-01', '2023-01-15', 'Oslo karateklubb', 799, 'Grunnleggende teknikker innen karate. Passer for folk i alle aldre og ulik kampsporterfaring.\r\nKontakt: Lyoto Machida.\r\nTlf: 45 90 14 28. \r\nKl 13:45', 'inaktiv'),
(4, 'Matlagingskurs', 5, '2023-10-24', '2023-11-24', 'Mathallen Grunerløkka', 299, 'Kontakt: Bent Stiansen.\r\nMail: Stiansenbent@statholdergaarden.no\r\nLag basiser og sauser fra bunnen av.\r\nTeknikker på behandling av råvarer.\r\nOppmøte kl 10:30 ', 'aktiv'),
(5, 'Ølbryggerkurs', 8, '2023-09-16', '2023-10-16', 'Mikrobryggeriet, Bogstadveien 6.', 599, 'Hvordan gå frem ved brygging av hjemmelaget øl? Dette kurset gir deg grunnleggende kompetanse på området.\r\nKontakt: Johnny Simonsen.\r\nMail: johnny@beerbrewing.com.\r\nOppmøte kl 11:30', 'aktiv'),
(6, 'Jeger-kurs', 12, '2023-09-20', '2023-10-20', 'Sognsvann, parkeringsplass.', 899, 'Alltid hatt lyst å jakte? Dette kurset bringer deg ett steg nærmere å realisere jegerdrømmen.\r\nKontakt: Arild Monsen.\r\nMail: monsen@gmail.com\r\nOppstart: 1. oktober 2023. ', 'aktiv'),
(7, 'Språkkurs Fransk', 15, '2023-09-30', '2023-10-30', 'UiO, Problemveien 7. Hovedinngang. ', 499, 'Frankofil person? Dette er et grunnleggende språkkurs i fransk, og tar deg et steg nærmere drømmen om å kunne snakke og forstå fransk.\r\nKontakt: Francois Le Schiffre.\r\nMail: leschiffre@frenchlessions.org.\r\nOppstart 7. oktober 2023 kl 09.00.', 'aktiv'),
(8, 'Røykdykkerkurs', 10, '2023-09-24', '2023-10-24', 'Falck Nutech, Svestadveien 27.', 3999, 'Lær deg generell kompetanse innen røykdykking. Her sertifiseres personer ihht. iso-standarder påkrevd ved ulike olje- og gassinstallasjoner med mer. \r\nKontakt: Olav Lund.\r\nMail: olavlund@nutech.com.\r\nTidspunkt for oppmøte: 09:00 ', 'aktiv'),
(9, 'Sushi-kurs', 6, '2023-10-10', '2023-11-10', 'Mathallen, Grunerløkka hovedinngang.', 699, 'Inspirert av Asia? Lær å lage sushi fra bunnen av mesterkokker med over 20 års erfaring. Kontakt: Jonathan Romano\r\nMail: jonathan@bolgenmoi.com\r\nOppmøte kl 10:00.', 'aktiv'),
(10, 'Malekurs', 6, '2023-11-11', '2023-12-11', 'Nydalen Kunstskole, Arups gate 5.', 499, 'Intensivt kurs for nybegynnere. Lær grunnleggende teknikker innen akryl- og oljemaling.\r\nKontakt: Vetle Nerdrum.\r\nMail: nerdrum@nerdrumindustries.com.\r\nTidspunkt: kl 08:30.', 'aktiv'),
(11, 'Keramikk-kurs', 8, '2023-11-20', '2023-12-20', 'Thorvald Meyers gate 55, Oslo.', 529, 'Avslappende kurs innen keramikk for nybegynnere.\r\nKontaktperson: Sissel Nysletten.\r\nMail: nysletten@keramikkhuset.no.', 'aktiv'),
(12, 'Engelskkurs', 11, '2023-10-12', '2023-11-12', 'NTNU Dragvoll, hovedinngang.', 999, 'Engelskskurs for nybegynnere. Lær deg grunnleggende grammatikk, utvid ordforrådet og gjør deg forstått på et av de mest brukte språkene i verden.\r\nTidspunkt: 10:00-14:00\r\nKontaktperson: James Hemingway. \r\nTlf: 47 15 22 22.', 'aktiv'),
(13, 'salsa-kurs', 12, '2023-10-12', '2023-11-12', 'Oslo Danseskole, Brenneriveien 11.', 569, 'Kontaktperson: Nadia Petrokova\r\nTlf: 45 90 84 12\r\nMail: nadiap@danseguiden.no\r\nTidspunkt: kl 16:00-17:30', 'aktiv'),
(14, 'svømmekurs', 6, '2024-12-12', '2024-12-16', 'Pir-badet, Havnegata 12.', 233, 'Kontaktperson: Leif Bjella\r\nKontakt: 72 45 45 46, leifb@msn.com\r\nOppstart: 23. feb 2024.', 'aktiv'),
(15, 'Jodlekurs', 12, '2024-12-12', '2024-12-16', 'Oslo kulturskole, Tøyenbekken 5.', 2999, 'Kontaktperson: Maria Boine\r\nTlf: 111 22 333\r\nMail: boine@gmail.com\r\nOppmøte kl 10:00.', 'aktiv'),
(16, 'testkurs', 10, '2023-12-12', '2024-01-12', 'NTNU', 455, 'Kontakt: Lars Mehus\r\nTLF: 48111529', 'aktiv');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `kursstatus`
--

CREATE TABLE `kursstatus` (
  `kurs_id` int(11) NOT NULL,
  `bruker_id` int(11) NOT NULL,
  `brukernavn` varchar(256) NOT NULL,
  `kursnavn` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `kursstatus`
--

INSERT INTO `kursstatus` (`kurs_id`, `bruker_id`, `brukernavn`, `kursnavn`) VALUES
(1, 1, 'lars', 'Fiskekurs'),
(1, 5, 'ola', 'Fiskekurs'),
(1, 7, 'malla', 'Fiskekurs'),
(1, 11, 'johanne', 'Fiskekurs'),
(2, 1, 'lars', 'Swing-kurs'),
(2, 2, 'laarsn', 'Swing-kurs'),
(2, 6, 'solan', 'Swing-kurs'),
(2, 7, 'malla', 'Swing-kurs'),
(2, 10, 'test', 'Swing-kurs'),
(4, 2, 'laarsn', 'Matlagingskurs'),
(4, 7, 'malla', 'Matlagingskurs'),
(5, 1, 'lars', 'Ølbryggerkurs'),
(6, 1, 'lars', 'Jeger-kurs'),
(6, 3, 'kjell', 'Jeger-kurs'),
(6, 5, 'ola', 'Jeger-kurs'),
(7, 1, 'lars', 'Språkkurs'),
(7, 7, 'malla', 'Språkkurs'),
(8, 1, 'lars', 'Røykdykkerkurs'),
(8, 3, 'kjell', 'Røykdykkerkurs'),
(8, 5, 'ola', 'Røykdykkerkurs'),
(9, 1, 'lars', 'Sushi-kurs'),
(10, 1, 'lars', 'Malekurs'),
(10, 2, 'laarsn', 'Malekurs'),
(10, 3, 'kjell', 'Malekurs'),
(10, 7, 'malla', 'Malekurs'),
(12, 1, 'lars', 'Engelskkurs');

-- --------------------------------------------------------


--
-- Tabellstruktur for tabell `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `session_brukernavn`
--

CREATE TABLE `session_brukernavn` (
  `id` int(5) NOT NULL,
  `brukernavn` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `session_brukernavn`
--

INSERT INTO `session_brukernavn` (`id`, `brukernavn`) VALUES
(1, 'lars');


--
-- Indexes for table `bilde_user`
--
ALTER TABLE `bilde_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brukere`
--
ALTER TABLE `brukere`
  ADD PRIMARY KEY (`bruker_id`);

--
-- Indexes for table `calendar_event_master`
--
ALTER TABLE `calendar_event_master`
  ADD PRIMARY KEY (`event_id`);


--
-- Indexes for table `grafer_sektor`
--
ALTER TABLE `grafer_sektor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grafer_stolpe`
--
ALTER TABLE `grafer_stolpe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kurs`
--
ALTER TABLE `kurs`
  ADD PRIMARY KEY (`kurs_id`);

--
-- Indexes for table `kursstatus`
--
ALTER TABLE `kursstatus`
  ADD PRIMARY KEY (`kurs_id`,`bruker_id`);



--
-- Indexes for table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Indexes for table `session_brukernavn`
--
ALTER TABLE `session_brukernavn`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for table `bilde_user`
--
ALTER TABLE `bilde_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `brukere`
--
ALTER TABLE `brukere`
  MODIFY `bruker_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `calendar_event_master`
--
ALTER TABLE `calendar_event_master`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;


--
-- AUTO_INCREMENT for table `grafer_sektor`
--
ALTER TABLE `grafer_sektor`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `grafer_stolpe`
--
ALTER TABLE `grafer_stolpe`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kurs`
--
ALTER TABLE `kurs`
  MODIFY `kurs_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;


--
-- AUTO_INCREMENT for table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `session_brukernavn`
--
ALTER TABLE `session_brukernavn`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
