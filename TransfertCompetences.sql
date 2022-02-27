-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 17 Février 2022 à 07:24
-- Version du serveur :  5.5.48
-- Version de PHP :  5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `TransfertCompetences`
--

-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

CREATE TABLE `agents` (
  `id_agent` int(11) NOT NULL,
  `id_TCs` int(11) DEFAULT NULL,
  `nomAgent` varchar(100) DEFAULT NULL,
  `nomTuteur` varchar(100) DEFAULT NULL,
  `nomResponsable` varchar(100) DEFAULT NULL,
  `secteur` varchar(255) DEFAULT NULL,
  `domaine` varchar(255) DEFAULT NULL,
  `commentaire_A` varchar(500) DEFAULT NULL,
  `commentaire_T` varchar(500) DEFAULT NULL,
  `commentaire_R` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `competences`
--

CREATE TABLE `competences` (
  `id_cpt` int(11) NOT NULL,
  `id_TCs` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `objectif` varchar(255) DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `etat` varchar(100) DEFAULT NULL,
  `pourcentage` int(3) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nom_prenom` varchar(200) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `nom_service` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Structure de la table `transfert_competences`
--

CREATE TABLE `transfert_competences` (
  `id_TCs` int(11) NOT NULL DEFAULT '0',
  `objectif_global` varchar(255) DEFAULT NULL,
  `choix_validation` varchar(255) DEFAULT NULL,
  `etat` varchar(100) DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `pourcentageGlobal` int(3) DEFAULT NULL,
  `date_cloture` date DEFAULT NULL,
  `satisfaction` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Index pour les tables exportées
--

--
-- Index pour la table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id_agent`);

--
-- Index pour la table `competences`
--
ALTER TABLE `competences`
  ADD PRIMARY KEY (`id_cpt`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_prenom` (`nom_prenom`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transfert_competences`
--
ALTER TABLE `transfert_competences`
  ADD PRIMARY KEY (`id_TCs`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `agents`
--
ALTER TABLE `agents`
  MODIFY `id_agent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT pour la table `competences`
--
ALTER TABLE `competences`
  MODIFY `id_cpt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
