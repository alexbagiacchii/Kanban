-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Mag 10, 2024 alle 07:15
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
  `descrizione` varchar(50) NOT NULL,
  `fk_id` int(11) NOT NULL,
  `fk_stato` varchar(10) NOT NULL,
  `fk_username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `modifica`
--

INSERT INTO `modifica` (`tag`, `data`, `descrizione`, `fk_id`, `fk_stato`, `fk_username`) VALUES
(1, '2024-05-10 09:14:33', 'Prova', 1, 'To-Do', 'admin');

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
('Aborted', 'Eliminata/Annullata'),
('Archived', 'Archiviato'),
('Doing', 'In corso'),
('Done', 'Completato'),
('To-Do', 'Da fare');

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
(1, 'Progetto di ricerca', 'Analisi dei dati e redazione della relazione', '2024-05-10 09:00:00', 'Alta'),
(2, 'Aggiornamento del software', 'Implementazione delle nuove funzionalità e correzione di bug', '2024-05-12 14:30:00', 'Media'),
(3, 'Riorganizzazione degli archivi', 'Digitalizzazione dei documenti e creazione di un sistema di archiviazione digitale', '2024-05-15 10:00:00', 'Bassa'),
(4, 'Pianificazione del progetto', 'Definizione degli obiettivi e pianificazione delle attività', '2024-06-01 08:00:00', 'Alta'),
(5, 'Test delle funzionalità', 'Esecuzione dei test e report dei risultati', '2024-05-10 10:30:00', 'Media'),
(6, 'Meeting con il cliente', 'Discussione dei requisiti e pianificazione delle prossime fasi', '2024-05-14 15:00:00', 'Bassa'),
(7, 'Revisione del codice', 'Analisi del codice sorgente e correzione degli errori', '2024-05-09 13:00:00', 'Alta');

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
('admin', 'admin', 'admin', 'admin');

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
  MODIFY `tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
