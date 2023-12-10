DROP database pse;
CREATE database pse;
use pse;

CREATE TABLE `departement` (
  `id` int(10) AUTO_INCREMENT PRIMARY key,
  `code` text NOT NULL,
  `nom` text NOT NULL
);

CREATE TABLE `groupe` (
`id_groupe` int(10) PRIMARY KEY AUTO_INCREMENT ,
`libelle` varchar(50) DEFAULT NULL,
`id_dep` int(10),
FOREIGN KEY (id_dep) REFERENCES departement(id)
);

CREATE TABLE `role` (
`id_role` int(10) PRIMARY KEY AUTO_INCREMENT,
`profile` varchar(50) DEFAULT NULL
);

CREATE TABLE `utilisateur` (
`id_user` int(10) PRIMARY KEY AUTO_INCREMENT ,
`login` varchar(50) DEFAULT NULL,
`pwd` varchar(100) DEFAULT NULL,
`active` tinyint(1) DEFAULT 1 COMMENT '1=Active | 0=Inactive',
`code` varchar(20) DEFAULT NULL,
`id_role` int(10) DEFAULT NULL ,
FOREIGN KEY (id_role) REFERENCES role(id_role)
);


CREATE TABLE `module` (
`id_module` int(10) PRIMARY KEY AUTO_INCREMENT,
`nom_module` varchar(50) DEFAULT NULL
);

CREATE TABLE `semestre` (
`id_semestre` int(10) PRIMARY KEY AUTO_INCREMENT,
`nom_semestre` varchar(50) DEFAULT NULL
);

CREATE TABLE `type_matiere` (
`id_type_matiere` int(10) PRIMARY KEY AUTO_INCREMENT,
`libelle_type` varchar(50) NOT NULL
);

CREATE TABLE `matiere` (
`id_matiere` int(10) PRIMARY KEY AUTO_INCREMENT ,
`code` varchar(20)  UNIQUE,
`libelle` varchar(50) DEFAULT NULL,
`specialite` varchar(20) DEFAULT NULL,
`charge` INT(20) NOT NULL,
`id_module` int(10)  ,
`id_semestre` int(10) ,
`id_type_matiere` int(10),
FOREIGN KEY (id_module) REFERENCES module(id_module),
FOREIGN KEY (id_semestre) REFERENCES semestre(id_semestre),
FOREIGN KEY (id_type_matiere) REFERENCES type_matiere(id_type_matiere)
);

CREATE TABLE `enseignant` (
`id_ens` int(10) PRIMARY KEY AUTO_INCREMENT ,
`nom` varchar(60) DEFAULT NULL,
`prenom` varchar(60) DEFAULT NULL,
`Date_naiss` date DEFAULT NULL,
`lieu_naiss` varchar(30) DEFAULT NULL,
`email` varchar(100) DEFAULT NULL,
`num_tel` int(20) DEFAULT NULL,
`num_whatsapp` int(20) DEFAULT NULL,
`diplome` varchar(20) DEFAULT NULL,
`grade` varchar(20) DEFAULT NULL,
`id_role` int(11) NOT NULL,
FOREIGN KEY (id_role) REFERENCES role(id_role)

);


CREATE TABLE `type_soumission`(
  `id_type_sous` INT(10) AUTO_INCREMENT PRIMARY KEY,
  `libelle` varchar(50) DEFAULT NULL
);



CREATE TABLE `soumission` (
`id_sous` int(10) PRIMARY KEY AUTO_INCREMENT ,
`titre_sous` varchar(50),
`description_sous` varchar(50) ,
`person_contact` varchar(100) DEFAULT NULL,
`id_ens` int(10) ,
`date_debut` datetime NOT NULL,
`date_fin` datetime NOT NULL,
`valide` tinyint(1) DEFAULT NULL,
`status` INT(5) DEFAULT 0,
`id_matiere` int(10) DEFAULT NULL,
`id_type_sous` INT(10) DEFAULT NULL,
FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere),
  FOREIGN KEY (id_ens) REFERENCES enseignant(id_ens),
  FOREIGN KEY (id_type_sous) REFERENCES type_soumission(id_type_sous)
);


DROP TABLE IF EXISTS `fichiers_soumission`;
CREATE TABLE IF NOT EXISTS `fichiers_soumission` (
  `id_fichier_sous` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom_fichier` varchar(255) NOT NULL,
  `chemin_fichier` varchar(255) NOT NULL,
  `id_sous` int(10) DEFAULT NULL,
 FOREIGN KEY (id_sous) REFERENCES soumission(id_sous)
);



CREATE TABLE `etudiant` (
`id_etud` int(10) PRIMARY KEY AUTO_INCREMENT ,
`matricule` varchar(50) NOT NULL UNIQUE,
`nom` varchar(60) DEFAULT NULL,
`prenom` varchar(60) DEFAULT NULL,
`lieu_naiss` varchar(100) DEFAULT NULL,
`Date_naiss` date DEFAULT NULL,
`id_semestre` int(10) DEFAULT NULL,
`annee` varchar(50) DEFAULT NULL,
`email` varchar(50) DEFAULT NULL,
`id_role` int(11) NOT NULL,
`id_groupe` int(10) DEFAULT NULL,
`id_dep` int(10) DEFAULT NULL,
FOREIGN KEY (id_semestre) REFERENCES semestre(id_semestre),
FOREIGN KEY (id_dep) REFERENCES departement(id),
FOREIGN KEY (id_role) REFERENCES role(id_role),
FOREIGN KEY (id_groupe) REFERENCES groupe(id_groupe)
);



CREATE TABLE `enseigner` (
`id_matiere` int(10)  NOT NULL,
`id_ens` int(10)  NOT NULL,
`id_groupe` int(10) NOT NULL,
`id_type_matiere` int(10) NOT NULL,
FOREIGN KEY (id_type_matiere) REFERENCES type_matiere(id_type_matiere),
FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere),
FOREIGN KEY (id_groupe) REFERENCES groupe(id_groupe),
FOREIGN KEY (id_ens) REFERENCES enseignant(id_ens)
);

CREATE TABLE inscription(
id_insc int AUTO_INCREMENT PRIMARY key ,
id_etud int(10) NOT NULL ,
id_matiere INT(10) NOT NULL ,
id_semestre INT(10) NOT NULL ,
FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere),
FOREIGN KEY (id_semestre) REFERENCES semestre(id_semestre),
FOREIGN KEY (id_etud) REFERENCES etudiant(id_etud)
);

--

CREATE TABLE matiere_semestre(
	id_matiere_semestre int(10) PRIMARY KEY AUTO_INCREMENT ,
    id_matiere int(10),
    id_semestre int(10),
    FOREIGN KEY (id_matiere) REFERENCES matiere(id_matiere),
    FOREIGN KEY (id_semestre) REFERENCES semestre(id_semestre)
);



CREATE TABLE reponses(
  id_rep int(10) AUTO_INCREMENT PRIMARY key ,
  description_rep varchar(200),
  date datetime DEFAULT NOW(), 
  render bool DEFAULT 0,
  confirmer bool DEFAULT 0,
  note float(10) DEFAULT 0,
  id_sous INT(10) not NULL,
  id_etud INT(10) not NULL,
  FOREIGN KEY (id_sous) REFERENCES soumission(id_sous),
  FOREIGN KEY (id_etud) REFERENCES etudiant(id_etud)
);

CREATE TABLE IF NOT EXISTS `fichiers_reponses` (
  `id_fich_rep` int(11) NOT NULL AUTO_INCREMENT,
  id_rep int(10) NOT NULL,
  `nom_fichiere` varchar(255) NOT NULL,
  `chemin_fichiere` varchar(255) NOT NULL,
  PRIMARY KEY (`id_fich_rep`),
  FOREIGN KEY (id_rep) REFERENCES reponses(id_rep)
);

CREATE TABLE `demande` (
  id_demande int(10) AUTO_INCREMENT PRIMARY key ,
  `id_sous` int(10) DEFAULT NULL,
  `id_etud` int(10) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `autoriser` int(1) DEFAULT 0 COMMENT '1=Autoriser | 0= Non Autoriser',
  FOREIGN KEY (id_sous) REFERENCES soumission(id_sous),
  FOREIGN KEY (id_etud) REFERENCES etudiant(id_etud)
);


DROP TABLE IF EXISTS `fichiers_soumission`;
CREATE TABLE IF NOT EXISTS `fichiers_soumission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sous` int(11) NOT NULL,
  `nom_fichier` varchar(255) NOT NULL,
  `chemin_fichier` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
   FOREIGN KEY (id_sous) REFERENCES soumission(id_sous)
);

CREATE TABLE IF NOT EXISTS `fichiers_reponses` (
  `id_fich_rep` int(11) NOT NULL AUTO_INCREMENT,
  id_rep int(10) NOT NULL,
  `nom_fichiere` varchar(255) NOT NULL,
  `chemin_fichiere` varchar(255) NOT NULL,
  PRIMARY KEY (`id_fich_rep`),
    FOREIGN KEY (id_rep) REFERENCES reponses(id_rep)
);


-- --------------------------------------------------------
-- --------------------------------------------------------


INSERT INTO `semestre` (`id_semestre`, `nom_semestre`) VALUES
(1, 'S1'),
(2, 'S2'),
(3, 'S3'),
(4, 'S4'),
(5, 'S5'),
(6, 'S6');




-- --------------------------------------------------------
-- --------------------------------------------------------



INSERT INTO `role` (`id_role`, `profile`) VALUES
(1, 'Administrateur'),
(2, 'Enseignant'),
(3, 'Étudiant');

-- --------------------------------------------------------
-- --------------------------------------------------------

INSERT INTO `type_soumission` (`id_type_sous`, `libelle`) VALUES 
(1, 'Examen'), 
(2, 'Devoir'), 
(3, 'TP Notée');


-- --------------------------------------------------------
-- --------------------------------------------------------


INSERT INTO `utilisateur` (`login`, `pwd`, `active`, `code`, `id_role`) VALUES
('admin@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '0', 1),
('22018@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '0', 3),
('22053@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '0', 3),
('22086@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '0', 3),
('22014@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '0', 3)
;

-- --------------------------------------------------------
-- --------------------------------------------------------


INSERT INTO `module` (`nom_module`)
VALUES ('Programmation et développement 1'),
      ('Systèmes et Réseaux'),
      ('Outils mathématiques et informatiques'),
      ('Développement personnel');



-- --------------------------------------------------------
-- --------------------------------------------------------


INSERT INTO `departement` ( `code`, `nom`) VALUES
('DSI', 'Devellopement'),
('RSS', 'Réseaux'),
('CNM', 'Multimedia'),
('TC', 'Troncommun');

-- --------------------------------------------------------
-- --------------------------------------------------------

INSERT INTO `type_matiere` ( `libelle_type`) VALUES ( 'CM');
INSERT INTO `type_matiere` ( `libelle_type`) VALUES ( 'TP');
INSERT INTO `type_matiere` ( `libelle_type`) VALUES ( 'TD');


-- --------------------------------------------------------
-- --------------------------------------------------------


INSERT INTO `groupe` (`libelle`, `id_dep`) VALUES
('G1', 4),
('G2', 4),
('G3', 4);











