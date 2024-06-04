-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Giu 04, 2024 alle 11:30
-- Versione del server: 10.11.6-MariaDB-0+deb12u1
-- Versione PHP: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `5i1_bagiacchidylan`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `modifica`
--

CREATE TABLE `modifica` (
  `tag` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `fk_id` int(11) NOT NULL,
  `fk_stato` varchar(10) NOT NULL,
  `fk_username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `modifica`
--

INSERT INTO `modifica` (`tag`, `data`, `fk_id`, `fk_stato`, `fk_username`) VALUES
(21, '2024-06-04 13:09:00', 11, 'to-do', 'admin'),
(22, '2024-06-04 13:21:12', 12, 'to-do', 'admin'),
(23, '2024-06-04 13:22:20', 13, 'to-do', 'alex'),
(24, '2024-06-04 13:28:41', 13, 'done', 'alex'),
(25, '2024-06-04 13:28:42', 12, 'done', 'alex'),
(26, '2024-06-04 13:29:18', 14, 'to-do', 'alex'),
(27, '2024-06-04 13:29:40', 15, 'to-do', 'alex'),
(28, '2024-06-04 13:29:42', 14, 'doing', 'alex'),
(29, '2024-06-04 13:29:43', 14, 'to-do', 'alex'),
(30, '2024-06-04 13:29:46', 11, 'doing', 'alex');

-- --------------------------------------------------------

--
-- Struttura della tabella `stato`
--

CREATE TABLE `stato` (
  `stato` varchar(10) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `stato`
--

INSERT INTO `stato` (`stato`, `nome`) VALUES
('aborted', 'Eliminata/Annullata'),
('archived', 'Archiviato'),
('doing', 'In corso'),
('done', 'Completato'),
('to-do', 'Da fare');

-- --------------------------------------------------------

--
-- Struttura della tabella `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `titolo` varchar(30) NOT NULL,
  `descrizione` varchar(150) NOT NULL,
  `data_inizio` datetime NOT NULL,
  `priorita` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `task`
--

INSERT INTO `task` (`id`, `titolo`, `descrizione`, `data_inizio`, `priorita`) VALUES
(11, 'Pulizia PC', 'Pulire CPU - RAM - VENTOLE', '2024-06-29 13:09:00', 'bassa'),
(12, 'Fare i compiti', 'Matematica, Informatica, TPSIT', '2024-06-07 13:22:00', 'bassa'),
(13, 'Pulire casa', 'Lavare pavimenti e fare lavatrice', '2024-06-04 13:26:00', 'media'),
(14, 'Esame', 'Esame di stato', '2024-06-24 13:30:00', 'alta'),
(15, 'Shopping', 'Fare nuovi acquisti', '2024-06-30 13:30:00', 'media');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `username` varchar(30) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`username`, `nome`, `cognome`, `password`) VALUES
('admin', 'admin', 'admin', 'admin'),
('alex', 'alex', 'bagiacchi', '1234');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `modifica`
--
ALTER TABLE `modifica`
  ADD PRIMARY KEY (`tag`),
  ADD KEY `fk_id` (`fk_id`),
  ADD KEY `fk_stato` (`fk_stato`),
  ADD KEY `fk_username` (`fk_username`);

--
-- Indici per le tabelle `stato`
--
ALTER TABLE `stato`
  ADD PRIMARY KEY (`stato`);

--
-- Indici per le tabelle `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `modifica`
--
ALTER TABLE `modifica`
  MODIFY `tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT per la tabella `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `modifica`
--
ALTER TABLE `modifica`
  ADD CONSTRAINT `modifica_ibfk_1` FOREIGN KEY (`fk_id`) REFERENCES `task` (`id`),
  ADD CONSTRAINT `modifica_ibfk_2` FOREIGN KEY (`fk_stato`) REFERENCES `stato` (`stato`),
  ADD CONSTRAINT `modifica_ibfk_3` FOREIGN KEY (`fk_username`) REFERENCES `utenti` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
