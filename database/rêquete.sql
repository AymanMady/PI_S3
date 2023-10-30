DROP database pi;
CREATE database pi;
use pi;

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
`description_sous` varchar(50),
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
`id_sous` int(10) DEFAULT NULL,
FOREIGN KEY (id_semestre) REFERENCES semestre(id_semestre),
FOREIGN KEY (id_role) REFERENCES role(id_role),
FOREIGN KEY (id_groupe) REFERENCES groupe(id_groupe),
FOREIGN KEY (id_sous) REFERENCES soumission(id_sous)
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



INSERT INTO `type_soumission` (`id_type_sous`, `libelle`) VALUES 
(1, 'Examen'), 
(2, 'Devoir'), 
(3, 'TP Notée');


-- --------------------------------------------------------
-- --------------------------------------------------------


INSERT INTO `utilisateur` (`login`, `pwd`, `active`, `code`, `id_role`) VALUES
('admin@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '0', 1),
('cheikh.dhib@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '0', 2),
('sidi.med@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '', 2),
('moussa.demba@supnum.mr', '25f9e794323b453885f5181f1b624d0b', '1', NULL, '2'),
('22018@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '0', 3),
('22053@supnum.mr', '25f9e794323b453885f5181f1b624d0b', 1, '0', 3),
('22053@supnum.mr', '$2b$10$2Ey3nmGNn2LPcXYc8RxPRuPgdsNL3bO4elJVLCtdeE7RBXYfH67hO', '1', NULL, '3'), 
('adminNode@supnum.mr', '$2b$10$R2prC1uaAW75mt4n4bN4EuhfzDv8n5OnWfDZJ7eOOPQFl9d4q0olC', '1', NULL, '1'),
('22034@supnum.mr', '$2b$10$/Dawu/Gi2TTPFuKKkCqsmOxNXoEpfPGLcS7efbXkl8AtoOjduxgG2', '1', NULL, '3')
;

-- --------------------------------------------------------
-- --------------------------------------------------------


INSERT INTO `module` (`nom_module`)
VALUES ('Programmation et développement 1'),
      ('Systèmes et Réseaux'),
      ('Outils mathématiques et informatiques'),
      ('Développement personnel'),
      ('Programmation et développement 2'),
      ('Atelier multumédia'),
      ('Architecture et systèmes'),
      ('Développement personnel'),
      ('Outils multimédia'),
      ('U31'),
      ('porgrammation avancée'),
      (' Science des données'),
      ('Outils Réseaux et Systèmes'),
      ('SI avancé'),
      ('Outils Développement'),
      (' Atelier dév'),
      (' Atelier Réseau'),
      ('Developpement personnel'),
      ('Dev sys info'),
      ('multimedia et reseaux'),
      ('Reseaux et systeme');


-- --------------------------------------------------------
-- --------------------------------------------------------


INSERT INTO `departement` ( `code`, `nom`) VALUES
('DSI', 'Devellopement'),
('RSS', 'Réseaux'),
('CNM', 'Multimedia'),
('TC', 'Trancommun');

-- --------------------------------------------------------
-- --------------------------------------------------------

INSERT INTO `type_matiere` ( `libelle_type`) VALUES ( 'CM');
INSERT INTO `type_matiere` ( `libelle_type`) VALUES ( 'TP');
INSERT INTO `type_matiere` ( `libelle_type`) VALUES ( 'TD');


-- --------------------------------------------------------
-- --------------------------------------------------------


INSERT INTO `groupe` (`libelle`, `id_dep`) VALUES
('G1', 1),
('G3', 1),
('G2', 1),
('G1', 2),
('G2', 2),
('G3', 2),
('G1', 3),
('G2', 3),
('G3', 3),
('G1', 4),
('G2', 4),
('G3', 4);



-- --------------------------------------------------------
-- --------------------------------------------------------




INSERT INTO `matiere` (`code`, `libelle`, `specialite`, `charge`, `id_module`, `id_semestre`, `id_type_matiere`) VALUES
('DSI310', 'Programmation avancée', 'DSI', 60, 1, 3, 1),
('DSI311', 'Bases de données', 'DSI', 60, 1, 3, 1),
('DSI312', 'Projet intégrateur I', 'DSI', 60, 1, 3, 1),
('DSI320', 'Programmation web', 'DSI', 60, 1, 2, 1),
('DSI321', 'Architecture des applications', 'DSI', 60, 1, 2, 1),
('DPR310', 'Communication professionnelle', 'DSI', 60, 4, 3, 1),
('DPR311', 'Anglais', 'DSI', 60, 4, 3, 1),
('DPR312', 'PPP', 'DSI', 60, 4, 3, 1),
('DPR313', 'Gestion entreprise', 'DSI', 60, 4, 3, 1),
('CNM310', 'Numérisation et codage des objets Multimédia', 'CNM', 60, 3, 3, 1),
('CNM311', 'CMS et PAO 2', 'CNM', 60, 3, 3, 1),
('CNM312', 'Projet intégrateur Avancé I', 'CNM', 60, 3, 3, 1),
('CNM320', 'Technologies Multimédias avancées', 'CNM', 60, 3, 3, 1),
('CNM321', 'Bases de données et conception des SI', 'CNM', 60, 3, 3, 1),
('PAV310', 'Programmation orientée objet Java', 'PAV', 60, 4, 3, 1),
('PAV311', 'Structure de données et complexité algorithmique', 'PAV', 60, 4, 3, 1),
('DAS310', 'Machine learning', 'DAS', 60, 4, 3, 1),
('DAS311', 'RO', 'DAS', 60, 4, 3, 1),
('RSS310', 'Introduction aux Réseaux Mobiles', 'RSS', 60, 2, 3, 1),
('RSS311', 'Administration systèmes et réseaux', 'RSS', 60, 2, 3, 1),
('RSS312', 'Projet intégrateur Avancé', 'RSS', 60, 2, 3, 1),
('PAV312', 'Sécurité des applications mobiles', 'PAV', 60, 4, 3, 1),
('DPR314', 'Marketing numérique', 'DSI', 60, 4, 2, 1),
('DPR315', 'Management de l\'innovation', 'DSI', 60, 4, 3, 1),
('DPR316', 'Entreprenariat', 'DSI', 60, 4, 3, 1),
('DPR317', 'Management de la qualité', 'DSI', 60, 4, 3, 1),
('CNM313', 'Design et ergonomie web', 'CNM', 60, 3, 3, 1),
('CNM314', 'Infographie et animation', 'CNM', 60, 3, 3, 1),
('CNM315', 'Projet intégrateur Avancé II', 'CNM', 60, 3, 3, 1),
('CNM322', 'Technologies audiovisuelles', 'CNM', 60, 3, 3, 1),
('CNM323', 'Gestion de projet multimédia', 'CNM', 60, 3, 3, 1),
('PAV313', 'Développement mobile multiplateforme', 'PAV', 60, 4, 2, 1),
('PAV314', 'Programmation avancée en C++', 'PAV', 60, 4, 2, 1),
('PAV315', 'Modélisation et conception objet', 'PAV', 60, 4, 3, 1),
('PAV316', 'Projet intégrateur Avancé III', 'PAV', 60, 4, 3, 1),
('DAS313', 'Analyse de données en temps réel', 'DAS', 60, 4, 3, 1),
('DAS314', 'Data visualization', 'DAS', 60, 4, 3, 1),
('DAS315', 'Big data analytics', 'DAS', 60, 4, 3, 1),
('DAS316', 'Projet intégrateur Avancé IV', 'DAS', 60, 4, 3, 1),
('RSS313', 'Sécurité des réseaux sans fil', 'RSS', 60, 2, 3, 1),
('RSS314', 'Cloud computing', 'RSS', 60, 2, 3, 1),
('RSS315', 'Virtualisation et conteneurisation', 'RSS', 60, 2, 3, 1),
('RSS316', 'Projet intégrateur Avancé V', 'RSS', 60, 2, 3, 1),
('DSI410', 'Programmation Mobile', 'DSI', 60, 1, 4, 1),
('DSI411', 'Projet intégrateur II', 'DSI', 60, 1, 4, 1),
('DPR410', 'Communication professionnelle II', 'DSI', 60, 4, 4, 1),
('DSI412', 'Intelligence artificielle', 'DSI', 60, 1, 4, 1),
('DPR411', 'Management de projet', 'DSI', 60, 4, 4, 1),
('CNM410', 'Développement web avancé', 'CNM', 60, 3, 2, 1),
('CNM411', 'Animation 2D et 3D', 'CNM', 60, 3, 4, 1),
('PAV410', 'Architecture logicielle', 'PAV', 60, 4, 4, 1),
('PAV411', 'Systèmes distribués', 'PAV', 60, 4, 4, 1),
('PAV412', 'Sécurité des applications web', 'PAV', 60, 4, 4, 1),
('DAS410', 'Apprentissage profond', 'DAS', 60, 4, 4, 1),
('DAS411', 'Traitement de données massives', 'DAS', 60, 4, 4, 1),
('DAS412', 'Analyse de données de santé', 'DAS', 60, 4, 4, 1),
('RSS410', 'Sécurité des réseaux avancée', 'RSS', 60, 2, 4, 1),
('RSS411', 'Voix sur IP', 'RSS', 60, 2, 4, 1),
('MAT101', 'Mathématiques', 'TC', 90, 1, 1, 2),
('PHY101', 'Physique', 'TC', 90, 1, 1, 2),
('INF101', 'Informatique', 'TC', 90, 1, 1, 2),
('MAT102', 'Algèbre linéaire', 'TC', 90, 1, 2, 2),
('PHY102', 'Électromagnétisme', 'TC', 90, 1, 2, 2),
('INF102', 'Programmation procédurale', 'TC', 90, 1, 2, 2),
('DPR412', 'Leadership et gestion d\'équipe', 'DSI', 60, 4, 4, 1),
('CNM412', 'Marketing digital', 'CNM', 60, 3, 4, 1),
('PAV413', 'Développement d\'applications mobiles avancées', 'PAV', 60, 4, 4, 1),
('DAS413', 'Analyse de données prédictive', 'DAS', 60, 4, 4, 1),
('RSS412', 'Sécurité des réseaux avancée II', 'RSS', 60, 2, 4, 1),
('DSI510', 'Projet intégrateur III', 'DSI', 90, 1, 5, 2),
('DSI511', 'Stage', 'DSI', 90, 1, 5, 2),
('DPR510', 'Communication professionnelle III', 'DSI', 60, 4, 5, 2),
('CNM510', 'Projet intégrateur III', 'CNM', 90, 3, 5, 2),
('PAV510', 'Projet intégrateur III', 'PAV', 90, 4, 5, 2),
('DAS510', 'Projet intégrateur III', 'DAS', 90, 4, 5, 2),
('RSS510', 'Projet intégrateur III', 'RSS', 90, 2, 5, 2),
('DSI610', 'Projet intégrateur IV', 'DSI', 90, 1, 6, 2),
('DSI611', 'Stage', 'DSI', 90, 1, 6, 2),
('DPR610', 'Communication professionnelle IV', 'DSI', 60, 4, 6, 2),
('CNM610', 'Projet intégrateur IV', 'CNM', 90, 3, 6, 2),
('PAV610', 'Projet intégrateur IV', 'PAV', 90, 4, 6, 2),
('DAS610', 'Projet intégrateur IV', 'DAS', 90, 4, 6, 2),
('RSS610', 'Projet intégrateur IV', 'RSS', 90, 2, 6, 2),
('MAT201', 'Analyse mathématique', 'TC', 90, 2, 1, 2),
('PHY201', 'Mécanique', 'TC', 90, 2, 1, 2),
('INF201', 'Programmation orientée objet', 'TC', 90, 2, 1, 2),
('MAT202', 'Calcul différentiel', 'TC', 90, 2, 2, 2),
('PHY202', 'Optique géométrique', 'TC', 90, 2, 2, 2),
('INF202', 'Structures de données', 'TC', 90, 2, 2, 2),
('MAT301', 'Algèbre linéaire avancée', 'TC', 90, 3, 1, 2),
('PHY301', 'Électricité et magnétisme', 'TC', 90, 3, 1, 2),
('INF301', 'Programmation avancée', 'TC', 90, 3, 1, 2),
('MAT302', 'Analyse numérique', 'TC', 90, 3, 2, 2),
('PHY302', 'Physique quantique', 'TC', 90, 3, 2, 2),
('INF302', 'Base de données', 'TC', 90, 3, 2, 2),
('MAT401', 'Statistiques', 'TC', 90, 4, 1, 2),
('PHY401', 'Physique des matériaux', 'TC', 90, 4, 1, 2),
('INF401', 'Intelligence artificielle', 'TC', 90, 4, 1, 2),
('MAT402', 'Équations différentielles', 'TC', 90, 4, 2, 2),
('PHY402', 'Physique nucléaire et des particules', 'TC', 90, 4, 2, 2),
('INF402', 'Systèmes d\'information', 'TC', 90, 4, 2, 2);



-- --------------------------------------------------------
-- --------------------------------------------------------





INSERT INTO `matiere_semestre` (`id_matiere`, `id_semestre`) VALUES
(27, 1),
(31, 1),
(11, 1),
(4, 2),
(3, 2),
(14, 3),
(68, 3),
(31, 2),
(5, 3),
(47, 4),
(5, 4),
(13, 4),
(27, 5),
(66, 5),
(17, 5),
(77, 6),
(13, 6),
(28, 6),
(4, 2),
(33, 2),
(32, 2),
(49, 2),
(5, 2);



-- --------------------------------------------------------
-- --------------------------------------------------------

INSERT INTO `enseignant` (`id_ens`, `nom`, `prenom`, `Date_naiss`, `lieu_naiss`, `email`, `num_tel`, `num_whatsapp`, `diplome`, `grade`, `id_role`) VALUES
(1, 'Cheikh', 'Dhib', '1983-01-22', 'nktt', 'cheikh.dhib@supnum.mr', NULL, NULL, 'doctor', 'directeur', 2),
(2, 'Moussa', 'Demba', '1989-10-12', 'nkt', 'moussa.demba@supnum.mr', NULL, NULL, 'doctor', 'directeur adjoint', 2),
(3, 'Meya', 'Haroune', '1993-06-22', 'nktt', 'meya.haroune@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(4, 'Sidi', 'Mohamed', '1995-10-27', 'Rosso', 'sidi.med@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(5, 'Aicha', 'Bobakar', '1991-12-07', 'nkt', 'aicha.bobakar@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(6, 'Mariem', 'Bellal', '1988-12-17', 'nktt', 'mariem.bellal@supnum.mr', NULL, NULL, 'master', 'maître assistant', 2),
(7, 'ahmed', 'oumar', '1990-03-15', 'nktt', 'ahmed.oumar@supnum.mr', NULL, NULL, 'master', 'prof', 2),
(8, 'fatim', 'sidi', '1985-07-10', 'nktt', 'fatim.sidi@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(9, 'mohamed', 'ali', '1992-09-05', 'nktt', 'mohamed.ali@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(10, 'asma', 'oussama', '1995-04-25', 'Aion', 'asma.oussama@supnum.mr', NULL, NULL, 'master', 'maître assistant', 2),
(11, 'issouf', 'hamid', '1991-11-09', 'nktt', 'issouf.hamid@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(12, 'khadija', 'mohamed', '1987-08-03', 'nktt', 'khadija.mohamed@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(13, 'ali', 'amine', '1994-02-18', 'nkt', 'ali.amine@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(14, 'souad', 'abdou', '1996-05-30', 'nkt', 'souad.abdou@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(15, 'ibrahim', 'khalil', '1984-09-02', 'nkt', 'ibrahim.khalil@supnum.mr', NULL, NULL, 'master', 'maître assistant', 2),
(16, 'salma', 'ahmed', '1986-06-28', 'nkt', 'salma.ahmed@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(17, 'Oumar', 'Abdoulaye', '1990-07-15', 'Nouakchott', 'oumar.abdoulaye@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(18, 'Mariem', 'Ahmed', '1988-05-19', 'Nouadhibou', 'mariem.ahmed@supnum.mr', NULL, NULL, 'master', 'prof', 2),
(19, 'Khalifa', 'Mohamed', '1993-02-25', 'Rosso', 'khalifa.mohamed@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(20, 'Aissatou', 'Mohamed', '1991-12-09', 'Nouakchott', 'aissatou.mohamed@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(21, 'Ahmed', 'Salem', '1987-10-27', 'Kaédi', 'ahmed.salem@supnum.mr', NULL, NULL, 'master', 'maître assistant', 2),
(22, 'Khadijetou', 'Ali', '1995-04-03', 'Nouakchott', 'khadijetou.ali@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(23, 'Abdallahi', 'Fatimetou', '1986-08-18', 'Nouadhibou', 'abdallahi.fatimetou@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(24, 'Sidi', 'Mamadou', '1992-06-22', 'Nouakchott', 'sidi.mamadou@supnum.mr', NULL, NULL, 'doctor', 'directeur', 2),
(25, 'Hawa', 'Mohamed', '1989-04-09', 'Kaédi', 'hawa.mohamed@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(26, 'Moulaye', 'Sidi', '1994-12-17', 'Rosso', 'moulaye.sidi@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(27, 'Salem', 'Aicha', '1985-09-05', 'Nouakchott', 'salem.aicha@supnum.mr', NULL, NULL, 'master', 'maître assistant', 2),
(28, 'Mariem', 'Ahmed', '1991-07-10', 'Nouadhibou', 'mariem.ahmed@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(29, 'Mohamed', 'Khalil', '1988-05-30', 'Nouakchott', 'mohamed.khalil@supnum.mr', NULL, NULL, 'master', 'prof', 2),
(30, 'Aminetou', 'Mohamed', '1996-03-12', 'Rosso', 'aminetou.mohamed@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(31, 'Abderrahmane', 'Salem', '1990-09-18', 'Nouakchott', 'abderrahmane.salem@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(32, 'Fatimetou', 'Ali', '1987-06-23', 'Nouadhibou', 'fatimetou.ali@supnum.mr', NULL, NULL, 'doctor', 'prof', 2),
(33, 'Mamadou', 'Sidi', '1993-04-10', 'Nouakchott', 'mamadou.sidi@supnum.mr', NULL, NULL, 'master', 'prof', 2),
(34, 'Hawa', 'Mohamed', '1989-02-15', 'Kaédi', 'hawa.mohamed@supnum.mr', NULL, NULL, 'doctor', 'maître assistant', 2),
(35, 'Salem', 'Aicha', '1986-08-08', 'Nouakchott', 'salem.aicha@supnum.mr', NULL, NULL, 'master', 'maître assistant', 2);

-- ----------------------------------------------------------------------------------------------------------------------------------------------
-- -------------------------------------------------------------------------------------------------------------------------------------------------




INSERT INTO `soumission` (`id_sous`, `titre_sous`, `description_sous`, `id_ens`, `date_debut`, `date_fin`, `valide`, `status`, `id_matiere`, `id_type_sous`) VALUES
(3, 'Devoir', 'Description', 4, '2023-07-07 12:19:00', '2023-08-06 17:20:00', 0, 0, 4, 2),
(19, 'TP', 'Description', 4, '2023-07-07 13:06:00', '2023-08-05 13:08:00', 0, 0, 5, 3),
(20, 'Devoir', 'Description1', 4, '2023-07-07 13:08:00', '2023-08-06 13:09:00', 0, 0, 5, 2),
(21, 'Examen', 'Description', 4, '2023-07-08 00:55:00', '2023-08-06 00:58:00', 0, 0, 4, 1),
(22, 'Examen', 'Description', 4, '2023-07-07 13:07:00', '2023-08-05 13:10:00', 0, 0, 5, 1),
(24, 'Examen', 'Description', 4, '2023-07-07 13:07:00', '2023-08-05 13:10:00', 0, 0, 5, 1),
(25, 'TP', 'Description', 4, '2023-07-07 13:11:00', '2023-08-05 13:11:00', 0, 0, 32, 3),
(26, 'Devoir', 'Description', 4, '2023-07-07 13:11:00', '2023-08-06 13:12:00', 0, 0, 32, 2),
(27, 'Examen', 'Description', 4, '2023-07-07 13:11:00', '2023-07-29 18:13:00', 0, 0, 32, 1),
(28, 'TP', 'Description', 4, '2023-07-07 13:12:00', '2023-08-04 13:14:00', 0, 0, 33, 3),
(29, 'Devoir', 'Description', 4, '2023-07-07 13:13:00', '2023-08-05 13:14:00', 0, 0, 33, 2),
(30, 'Examen', 'Description', 4, '2023-07-07 13:14:00', '2023-08-06 13:15:00', 0, 0, 33, 1),
(31, 'TP', 'Description', 4, '2023-07-07 13:12:00', '2023-08-06 13:16:00', 0, 0, 49, 3),
(32, 'Devoir', 'Description', 4, '2023-07-07 13:15:00', '2023-08-06 13:17:00', 0, 0, 49, 2),
(33, 'Examen', 'Description', 4, '2023-07-07 13:16:00', '2023-09-10 18:17:00', 0, 0, 49, 1),
(34, 'TP', 'Description', 4, '2023-07-08 00:55:00', '2023-08-06 00:56:00', 0, 1, 4, 3),
(35, 'Devoir', 'Description', 4, '2023-07-08 00:55:00', '2023-08-04 00:57:00', 0, 1, 4, 2);






INSERT INTO `enseigner` (`id_matiere`, `id_ens`, `id_groupe`, `id_type_matiere`) VALUES
(5, 4, 3, 2),
(32, 4, 1, 2),
(33, 4, 2, 2),
(49, 4, 2, 2),
(4, 4, 3, 2);

-- ----------------------------------------------------------------------------------------------------------------------------------------------
-- -------------------------------------------------------------------------------------------------------------------------------------------------




INSERT INTO `etudiant` (`id_etud`, `matricule`, `nom`, `prenom`, `lieu_naiss`, `Date_naiss`, `id_semestre`, `annee`, `email`, `id_role`, `id_groupe`, `id_sous`) VALUES
(1, '21001', 'Cheikh Ahmed', 'Mohamed Ahmed', 'Nouakchott', '1997-01-05', 2, '2022', '21001@supnum.mr', 3, 1, NULL),
(2, '21003', 'Touba', 'Yarahallah', 'Nouadhibou', '1998-03-15', 2, '2022', '21003@supnum.mr', 3, 2, NULL),
(3, '21004', 'Mohamed Youssef', 'Abdelbarka', 'Nouakchott', '1999-05-25', 2, '2022', '21004@supnum.mr', 3, 3, NULL),
(4, '21008', 'Rakiea', 'Dhah', 'Atar', '2000-07-10', 2, '2022', '21008@supnum.mr', 3, 1, NULL),
(5, '21010', 'Esmaou', 'Vall', 'Kaédi', '1997-09-20', 2, '2022', '21010@supnum.mr', 3, 2, NULL),
(6, '21011', 'Mohamed Lemine', 'Taleb Ahmed', 'Nouakchott', '1998-11-05', 2, '2022', '21011@supnum.mr', 3, 3, NULL),
(7, '21012', 'Ahlam', 'Abdel Kader', 'Nouadhibou', '1999-12-15', 2, '2022', '21012@supnum.mr', 3, 1, NULL),
(8, '21014', 'Taleb', 'Bahan', 'Nouakchott', '2001-02-28', 2, '2022', '21014@supnum.mr', 3, 2, NULL),
(9, '21016', 'Khadijetou', 'Abdel Ghader', 'Rosso', '1997-04-10', 2, '2022', '21016@supnum.mr', 3, 3, NULL),
(10, '21017', 'Bedra', 'Deddy', 'Nouadhibou', '1998-05-25', 2, '2022', '21017@supnum.mr', 3, 1, NULL),
(11, '21018', 'Mohamed', 'Ejelal', 'Nouakchott', '1999-07-10', 2, '2022', '21018@supnum.mr', 3, 2, NULL),
(12, '21019', 'Fatimetou', 'Dah', 'Nouadhibou', '2000-08-25', 2, '2022', '21019@supnum.mr', 3, 3, NULL),
(13, '21020', 'Ahmed', 'Sejad', 'Nouakchott', '1997-10-10', 2, '2022', '21020@supnum.mr', 3, 1, NULL),
(14, '21021', 'El Moukhtar', 'DMeiss', 'Nouakchott', '1998-11-15', 2, '2022', '21021@supnum.mr', 3, 2, NULL),
(15, '21022', 'Sidi Abdoullah', 'Mehdi', 'Nouadhibou', '1999-12-25', 2, '2022', '21022@supnum.mr', 3, 3, NULL),
(16, '21024', 'Cheikh Elhdrami', 'Begnoug', 'Atar', '2000-02-10', 2, '2022', '21024@supnum.mr', 3, 1, NULL),
(17, '21027', 'Khadigetou', 'Mohamed Mewloud', 'Nouakchott', '1997-04-25', 2, '2022', '21027@supnum.mr', 3, 2, NULL),
(18, '21028', 'Fatimetou', 'El Alem', 'Nouadhibou', '1998-06-10', 2, '2022', '21028@supnum.mr', 3, 3, NULL),
(19, '21029', 'Sidi', 'Ebeidi', 'Nouakchott', '1999-07-25', 2, '2022', '21029@supnum.mr', 3, 1, NULL),
(20, '21030', 'Aicha', 'Moussa', 'Nouadhibou', '2000-09-10', 2, '2022', '21030@supnum.mr', 3, 2, NULL),
(21, '21031', 'Sidi El Valy', 'SidElemine', 'Nouakchott', '1997-11-15', 2, '2022', '21031@supnum.mr', 3, 3, NULL),
(22, '21032', 'Oum Elvadhli', 'Cheikh', 'Nouadhibou', '1998-12-25', 2, '2022', '21032@supnum.mr', 3, 1, NULL),
(23, '21033', 'Lalla', 'Ebety', 'Nouakchott', '1999-02-10', 2, '2022', '21033@supnum.mr', 3, 2, NULL),
(24, '21038', 'El Vaghih', 'Zeine', 'Nouadhibou', '2000-03-25', 2, '2022', '21038@supnum.mr', 3, 3, NULL),
(25, '21040', 'Abdoulaye', 'Ba', 'Nouakchott', '1997-05-10', 2, '2022', '21040@supnum.mr', 3, 1, NULL),
(26, '21041', 'Mariem', 'Dahi', 'Nouakchott', '1998-05-11', 2, '2022', '21041@supnum.mr', 3, 1, NULL),
(27, '21042', 'Zeinebou', 'Lebchir', 'Nouadhibou', '1999-05-17', 2, '2022', '21042@supnum.mr', 3, 2, NULL),
(28, '21043', 'Mohamed Vall', 'Mohameden Vall', 'Atar', '2000-05-25', 2, '2022', '21043@supnum.mr', 3, 3, NULL),
(29, '21045', 'Rougha', 'Amar Salem', 'Nouakchott', '1997-06-11', 2, '2022', '21045@supnum.mr', 3, 1, NULL),
(30, '21046', 'Zeinebou', 'El Ghellawi', 'Nouadhibou', '1998-06-17', 2, '2022', '21046@supnum.mr', 3, 2, NULL),
(31, '21047', 'Djilitt', 'Abdellahi', 'Nouakchott', '1999-06-25', 2, '2022', '21047@supnum.mr', 3, 3, NULL),
(32, '21050', 'Aicha', 'Chrif Bou Ghouba', 'Nouadhibou', '2000-07-11', 2, '2022', '21050@supnum.mr', 3, 1, NULL),
(33, '21051', 'Fatimetou', 'Abdel Haye', 'Nouakchott', '1997-07-17', 2, '2022', '21051@supnum.mr', 3, 2, NULL),
(34, '21052', 'Ghlana', 'Mohamed Habib', 'Nouadhibou', '1998-07-25', 2, '2022', '21052@supnum.mr', 3, 3, NULL),
(35, '21053', 'Imane', 'Hmeyada', 'Nouakchott', '1999-08-11', 2, '2022', '21053@supnum.mr', 3, 1, NULL),
(36, '21054', 'Mariem', 'SidAhmed Taleb', 'Nouadhibou', '2000-08-17', 2, '2022', '21054@supnum.mr', 3, 2, NULL),
(37, '21055', 'Cherifa', 'Beillahi', 'Nouakchott', '1997-08-25', 2, '2022', '21055@supnum.mr', 3, 3, NULL),
(38, '21056', 'Bouchra', 'Ahmed Ramdhane', 'Nouadhibou', '1998-09-11', 2, '2022', '21056@supnum.mr', 3, 1, NULL),
(39, '21059', 'Mariem', 'Afou', 'Nouakchott', '1999-09-17', 2, '2022', '21059@supnum.mr', 3, 2, NULL),
(40, '21060', 'Tekeiber', 'Bah', 'Nouadhibou', '2000-09-25', 2, '2022', '21060@supnum.mr', 3, 3, NULL),
(41, '21061', 'Abderrahmane', 'Nanne Mohamed', 'Nouakchott', '1997-10-11', 2, '2022', '21061@supnum.mr', 3, 1, NULL),
(42, '21062', 'Oumou', 'Ba', 'Nouadhibou', '1998-10-17', 2, '2022', '21062@supnum.mr', 3, 2, NULL),
(43, '21063', 'Aicha', 'Fadel', 'Nouakchott', '1999-10-25', 2, '2022', '21063@supnum.mr', 3, 3, NULL),
(44, '21064', 'Soumeya', 'Ebi El Maaly', 'Nouadhibou', '2000-11-11', 2, '2022', '21064@supnum.mr', 3, 1, NULL),
(45, '21065', 'Moussa', 'Emhamed', 'Nouakchott', '1998-03-15', 2, '2022', '21065@supnum.mr', 3, 1, NULL),
(46, '21066', 'Aminetou', 'Lekhoueima', 'Nouakchott', '2000-08-10', 2, '2022', '21066@supnum.mr', 3, 2, NULL),
(47, '21068', 'Amani', 'Baba', 'Nouadhibou', '1999-05-02', 2, '2022', '21068@supnum.mr', 3, 1, NULL),
(48, '21069', 'Ahmed', 'Cheikh', 'Nouakchott', '1997-12-20', 2, '2022', '21069@supnum.mr', 3, 3, NULL),
(49, '21072', 'Aminetou', 'Ahmed Cherif', 'Nouakchott', '1998-09-27', 2, '2022', '21072@supnum.mr', 3, 2, NULL),
(50, '21076', 'Ahmedou', 'Enaha Cheikh', 'Nouakchott', '1997-07-05', 2, '2022', '21076@supnum.mr', 3, 3, NULL),
(51, '21007', 'Meimouna', 'Erebih', 'Nouakchott', '2001-04-18', 2, '2022', '21007@supnum.mr', 3, 1, NULL),
(52, '21009', 'Mohamed', 'Ahmedou', 'Nouakchott', '1998-11-30', 2, '2022', '21009@supnum.mr', 3, 2, NULL),
(53, '21026', 'Mohamedhen Vall', 'Khaled', 'Nouakchott', '1999-09-09', 2, '2022', '21026@supnum.mr', 3, 3, NULL),
(54, '21036', 'Cheikh', 'Aba', 'Nouadhibou', '2002-02-14', 2, '2022', '21036@supnum.mr', 3, 1, NULL),
(55, '21058', 'Aichetou', 'Abdellah', 'Nouakchott', '1998-06-23', 2, '2022', '21058@supnum.mr', 3, 2, NULL),
(56, '21071', 'Fatimetou', 'NDary', 'Nouakchott', '2000-01-12', 2, '2022', '21071@supnum.mr', 3, 3, NULL),
(57, '22001', 'Mezid Abderahman', 'Mohamed Mahmoud', 'Nouakchott', '1999-04-01', 2, '2023', '22001@supnum.mr', 3, 1, NULL),
(58, '22002', 'Mohamed Lemine', 'Al Id', 'Nouakchott', '2001-11-08', 2, '2023', '22002@supnum.mr', 3, 2, NULL),
(59, '22003', 'Ebou Oubeideta', 'Mohamed Vall', 'Nouakchott', '2000-07-15', 2, '2023', '22003@supnum.mr', 3, 3, NULL),
(60, '22004', 'El Moukhtar', 'Amar Mohamed', 'Nouakchott', '1999-06-22', 2, '2023', '22004@supnum.mr', 3, 1, NULL),
(61, '22005', 'Mariem', 'Erebih', 'Nouakchott', '2001-03-04', 2, '2023', '22005@supnum.mr', 3, 2, NULL),
(62, '22006', 'Mohamed', 'Cheikh Sidi', 'Nouadhibou', '1998-12-11', 2, '2023', '22006@supnum.mr', 3, 3, NULL),
(63, '22007', 'Ahmedou', 'Miya', 'Nouakchott', '2000-10-18', 2, '2023', '22007@supnum.mr', 3, 1, NULL),
(64, '22008', 'Mohamed', 'Dahi', 'Nouakchott', '1999-07-26', 2, '2023', '22008@supnum.mr', 3, 2, NULL),
(65, '22009', 'Ahmed', 'Mohamed Abba', 'Nouakchott', '2001-02-02', 2, '2023', '22009@supnum.mr', 3, 3, NULL),
(66, '22010', 'Aissata', 'NGaid', 'Nouakchott', '1998-09-10', 2, '2023', '22010@supnum.mr', 3, 1, NULL),
(67, '22011', 'Abdellah', 'Nomane Mohamed', 'Nouadhibou', '2000-06-17', 2, '2023', '22011@supnum.mr', 3, 2, NULL),
(68, '22012', 'Aboubakri', 'NGaidé', 'Nouakchott', '1999-03-25', 2, '2023', '22012@supnum.mr', 3, 3, NULL),
(69, '22013', 'El Moustapha', 'Mohamed El Moustapha', 'Nouakchott', '2001-01-01', 2, '2023', '22013@supnum.mr', 3, 1, NULL),
(70, '22014', 'Bechir', 'Mady', 'nkt', '2023-05-17', 2, '2023', '22014@supnum.mr', 3, NULL, NULL),
(71, '22015', 'Nebghouha', 'Seyid', 'Nouakchott', '2001-01-05', 2, '2023', '22015@supnum.mr', 3, 1, NULL),
(72, '22016', 'Diyana', 'Sambe', 'Nouakchott', '1999-04-12', 2, '2023', '22016@supnum.mr', 3, 2, NULL),
(73, '22017', 'Kadiata', 'Niang', 'Nouadhibou', '2000-11-19', 2, '2023', '22017@supnum.mr', 3, 3, NULL),
(74, '22018', 'Souleyman', 'Baba', 'nktt', '2023-05-25', 2, '2023', '22018@supnum.mr', 3, NULL, NULL),
(75, '22019', 'Sultana', 'Ebe Oumar', 'Nouakchott', '2001-06-03', 2, '2023', '22019@supnum.mr', 3, 2, NULL),
(76, '22020', 'Idoumou', 'Lehbouss', 'Nouadhibou', '1999-03-11', 2, '2023', '22020@supnum.mr', 3, 3, NULL),
(77, '22021', 'Taleb', 'Abde Selam', 'Nouakchott', '2000-10-18', 2, '2023', '22021@supnum.mr', 3, 1, NULL),
(78, '22022', 'Boubou', 'Camara', 'Nouakchott', '1998-07-26', 2, '2023', '22022@supnum.mr', 3, 2, NULL),
(79, '22023', 'Itawel Oumrou', 'Cheikh Mohamed Vadel', 'Nouadhibou', '2001-05-02', 2, '2023', '22023@supnum.mr', 3, 3, NULL),
(80, '22024', 'Ahmedou Bemba', 'Ahmedou Salem', 'Nouakchott', '1999-02-09', 2, '2023', '22024@supnum.mr', 3, 1, NULL),
(81, '22025', 'El Kherchy', 'Baba', 'Nouakchott', '2000-09-16', 2, '2023', '22025@supnum.mr', 3, 2, NULL),
(82, '22026', 'Yahya', 'Tyib Mohamed', 'Nouadhibou', '1998-06-24', 2, '2023', '22026@supnum.mr', 3, 3, NULL),
(83, '22027', 'Cheikh Maleinine', 'Cheikh Malainine', 'Nouakchott', '2001-04-01', 2, '2023', '22027@supnum.mr', 3, 1, NULL),
(84, '22028', 'Khadijetou', 'Boubakar', 'Nouakchott', '1999-01-09', 2, '2023', '22028@supnum.mr', 3, 2, NULL),
(85, '22029', 'Mohamed Lemine', 'NDiayane', 'Nouadhibou', '2000-08-17', 2, '2023', '22029@supnum.mr', 3, 3, NULL),
(86, '22031', 'Mama', 'Diakit', 'Nouakchott', '1998-05-26', 2, '2023', '22031@supnum.mr', 3, 1, NULL),
(87, '22032', 'Yahya', 'Elmine', 'Nouakchott', '2001-03-04', 2, '2023', '22032@supnum.mr', 3, 2, NULL),
(88, '22033', 'Salma', 'Lefad', 'Nouadhibou', '1999-10-11', 2, '2023', '22033@supnum.mr', 3, 3, NULL),
(89, '22034', 'Mohamed Mahmoud', 'Sidi Echeikh', 'Nouakchott', '2001-07-18', 2, '2023', '22034@supnum.mr', 3, 1, NULL),
(90, '22035', 'Vatma', 'El Wavi', 'Nouakchott', '1999-04-26', 2, '2023', '22035@supnum.mr', 3, 2, NULL),
(91, '22036', 'Memoud', 'Abdi Sidi', 'Nouadhibou', '2000-12-03', 2, '2023', '22036@supnum.mr', 3, 3, NULL),
(92, '22040', 'Mohamed', 'Dhmin', 'Nouakchott', '1998-09-10', 2, '2023', '22040@supnum.mr', 3, 1, NULL),
(93, '22041', 'Abdellahi', 'Elemine Vall', 'Nouakchott', '2001-06-17', 2, '2023', '22041@supnum.mr', 3, 2, NULL),
(94, '22042', 'Fatimetou', 'Cheikh Ould Meny', 'Nouadhibou', '1999-03-25', 2, '2023', '22042@supnum.mr', 3, 3, NULL),
(95, '22043', 'Mohamed Lemine', 'Ahmed El Haj', 'Nouakchott', '2000-11-02', 2, '2023', '22043@supnum.mr', 3, 1, NULL),
(96, '22045', 'Hawa', 'Leye', 'Nouadhibou', '1998-08-10', 2, '2023', '22045@supnum.mr', 3, 2, NULL),
(97, '22046', 'Weva', 'Nahy', 'Nouakchott', '2001-05-18', 2, '2023', '22046@supnum.mr', 3, 3, NULL),
(98, '22047', 'Mohamed', 'Camara', 'Nouakchott', '1999-02-25', 2, '2023', '22047@supnum.mr', 3, 1, NULL),
(99, '22048', 'Zeinebou', 'El Hachmi', 'Nouakchott', '2000-10-04', 2, '2023', '22048@supnum.mr', 3, 2, NULL),
(100, '22049', 'Abd Dayem', 'Ainine', 'Nouadhibou', '1998-07-12', 2, '2023', '22049@supnum.mr', 3, 3, NULL),
(101, '22050', 'Ahamed Salem', 'Chennan', 'Nouakchott', '2001-04-19', 2, '2023', '22050@supnum.mr', 3, 1, NULL),
(102, '22051', 'Ahmed', 'El Maouloud', 'Nouadhibou', '1998-03-07', 2, '2023', '22051@supnum.mr', 3, 2, NULL),
(103, '22052', 'Safia', 'El Hacen', 'Nouakchott', '2000-10-15', 2, '2023', '22052@supnum.mr', 3, 3, NULL),
(104, '22053', 'Abderahman', 'Abderahman', 'nkt', '2023-05-11', 2, '2023', '22053@supnum.mr', 3, NULL, NULL),
(105, '22054', 'Ahmed', 'Ely', 'Nouadhibou', '2000-09-03', 2, '2023', '22054@supnum.mr', 3, 3, NULL),
(106, '22055', 'Sara', 'Wedih', 'Nouakchott', '1998-06-11', 2, '2023', '22055@supnum.mr', 3, 1, NULL),
(107, '22056', 'Achato', 'Cheikh El Mehdy', 'Nouakchott', '2001-03-19', 2, '2023', '22056@supnum.mr', 3, 2, NULL),
(108, '22057', 'Ahmed Yassine', 'Mohamed Salem', 'Nouadhibou', '1999-10-26', 2, '2023', '22057@supnum.mr', 3, 3, NULL),
(109, '22058', 'Ethemane', 'Niass', 'Nouakchott', '2001-08-02', 2, '2023', '22058@supnum.mr', 3, 1, NULL),
(110, '22059', 'Tahra', 'Cheikh Mamine', 'Nouakchott', '1999-05-11', 2, '2023', '22059@supnum.mr', 3, 2, NULL),
(111, '22060', 'Mama', 'Sidi Youssouf', 'Nouadhibou', '2000-12-18', 2, '2023', '22060@supnum.mr', 3, 3, NULL),
(112, '22061', 'Marieme', 'Lab', 'Nouakchott', '1998-09-25', 2, '2023', '22061@supnum.mr', 3, 1, NULL),
(113, '22062', 'Mohameden', 'Edou', 'Nouakchott', '2001-07-04', 2, '2023', '22062@supnum.mr', 3, 2, NULL),
(114, '22063', 'Hawa', 'Blal', 'Nouakchott', '2001-09-15', 2, '2023', '22063@supnum.mr', 3, 1, NULL),
(115, '22064', 'Aminetou', 'Abderrazagh', 'Nouadhibou', '1999-06-23', 2, '2023', '22064@supnum.mr', 3, 2, NULL),
(116, '22065', 'Zeinebou', 'Saleh', 'Nouakchott', '2000-03-10', 2, '2023', '22065@supnum.mr', 3, 3, NULL),
(117, '22066', 'Aichetou', 'Mohamed Chrif', 'Nouakchott', '1998-12-18', 2, '2023', '22066@supnum.mr', 3, 1, NULL),
(118, '22067', 'Hafssatou', 'Bilal', 'Nouadhibou', '2001-07-25', 2, '2023', '22067@supnum.mr', 3, 2, NULL),
(119, '22068', 'Mariem', 'Kah', 'Nouakchott', '1999-05-03', 2, '2023', '22068@supnum.mr', 3, 3, NULL),
(120, '22069', 'Sidi Mohamed', 'Taje Dine', 'Nouadhibou', '2000-02-10', 2, '2023', '22069@supnum.mr', 3, 1, NULL),
(121, '22070', 'Mariem', 'El Youssy', 'Nouakchott', '1998-11-18', 2, '2023', '22070@supnum.mr', 3, 2, NULL),
(122, '22071', 'Rabani', 'El Bessry', 'Nouakchott', '2001-08-26', 2, '2023', '22071@supnum.mr', 3, 3, NULL),
(123, '22072', 'Toutou', 'Mouslih', 'Nouadhibou', '1999-05-04', 2, '2023', '22072@supnum.mr', 3, 1, NULL),
(124, '22073', 'El Yedaly', 'El Ahtighe', 'Nouakchott', '2000-12-12', 2, '2023', '22073@supnum.mr', 3, 2, NULL),
(125, '22074', 'Mouna', 'El Khaye', 'Nouadhibou', '1998-09-20', 2, '2023', '22074@supnum.mr', 3, 3, NULL),
(126, '22075', 'Oum El Moumnine', 'Abdel Kader', 'Nouakchott', '2001-06-27', 2, '2023', '22075@supnum.mr', 3, 1, NULL),
(127, '22076', 'Fatimetou', 'Ahmed Maham', 'Nouadhibou', '1999-04-05', 2, '2023', '22076@supnum.mr', 3, 2, NULL),
(128, '22077', 'Mohamed Lemine', 'Zeidane', 'Nouakchott', '2000-01-13', 2, '2023', '22077@supnum.mr', 3, 3, NULL),
(129, '22078', 'Roughaya', 'Bebane', 'Nouadhibou', '1998-08-21', 2, '2023', '22078@supnum.mr', 3, 1, NULL),
(130, '22079', 'Oussame', 'Said', 'Nouakchott', '2001-05-29', 2, '2023', '22079@supnum.mr', 3, 2, NULL),
(131, '22080', 'Ammou Melika', 'Mohamed', 'Nouadhibou', '1999-03-07', 2, '2023', '22080@supnum.mr', 3, 3, NULL),
(132, '22081', 'Mohamed Lemine', 'Allouche', 'Nouakchott', '1998-10-15', 2, '2023', '22081@supnum.mr', 3, 1, NULL),
(133, '22083', 'El Heiba', 'Houmren', 'Nouadhibou', '2001-07-22', 2, '2023', '22083@supnum.mr', 3, 2, NULL),
(134, '22084', 'Ahmed', 'Khouna', 'Nouakchott', '1999-04-29', 2, '2023', '22084@supnum.mr', 3, 3, NULL),
(135, '22085', 'Cheikh', 'Abidine', 'Nouadhibou', '1998-12-06', 2, '2023', '22085@supnum.mr', 3, 1, NULL),
(136, '22086', 'Aliyine', 'Wedad', 'Nouakchott', '2001-09-14', 2, '2023', '22086@supnum.mr', 3, 2, NULL),
(137, '22087', 'TFeil Maryeim', 'Mohamed', 'Nouadhibou', '1999-06-22', 2, '2023', '22087@supnum.mr', 3, 3, NULL),
(138, '22088', 'Ousama', 'El Atigh', 'Nouakchott', '2000-03-10', 2, '2023', '22088@supnum.mr', 3, 1, NULL),
(139, '22089', 'Mouna', 'El Mokhtar', 'Nouadhibou', '1998-10-18', 2, '2023', '22089@supnum.mr', 3, 2, NULL),
(140, '22030', 'Abdellahi', 'Menem', 'Nouakchott', '2001-07-25', 2, '2023', '22030@supnum.mr', 3, 3, NULL),
(141, '22037', 'Khira', 'Elema', 'Nouadhibou', '1999-04-05', 2, '2023', '22037@supnum.mr', 3, 1, NULL),
(142, '22038', 'Zeinebou', 'El Agheb', 'Nouakchott', '1998-11-13', 2, '2023', '22038@supnum.mr', 3, 2, NULL),
(143, '22039', 'Esma', 'MHadi', 'Nouadhibou', '2001-08-21', 2, '2023', '22039@supnum.mr', 3, 3, NULL),
(144, '22044', 'Mohamed Mahmoud', 'Mohamed Lemine', 'Nouakchott', '1999-05-29', 2, '2023', '22044@supnum.mr', 3, 1, NULL),
(145, '22082', 'Elmoctar Aicha', 'Mohamed', 'Nouadhibou', '1998-11-14', 2, '2023', '22082@supnum.mr', 3, 1, NULL),
(146, '21002', 'khadije', 'baye', 'Nouakchott', '2001-06-23', 2, '2022', '21002@supnum.mr', 3, 2, NULL),
(147, '21005', 'fatimetou ', 'ahmed eli', 'Nouadhibou', '1999-05-04', 2, '2022', '21005@supnum.mr', 3, 3, NULL),
(148, '21006', 'mohamed', 'sidi ahmed', 'Nouakchott', '1998-12-12', 2, '2022', '21006@supnum.mr', 3, 1, NULL),
(149, '21023', 'mohamed said', 'rebanie', 'Nouadhibou', '2001-09-20', 2, '2022', '21023@supnum.mr', 3, 2, NULL),
(150, '21025', 'mohamed mahmoud', 'ahmemd', 'Nouakchott', '1999-06-27', 2, '2022', '21025@supnum.mr', 3, 3, NULL),
(151, '21034', 'khaled', 'ahmed mahmoud', 'Nouadhibou', '2000-03-10', 2, '2022', '21034@supnum.mr', 3, 1, NULL),
(152, '21039', 'taher', 'selahi', 'Nouakchott', '1998-10-18', 2, '2022', '21039@supnum.mr', 3, 2, NULL),
(153, '21044', 'El hssein', 'nah', 'Nouadhibou', '2001-07-25', 2, '2022', '21044@supnum.mr', 3, 3, NULL),
(154, '21048', 'sara', 'ahmed horme', 'Nouakchott', '1999-04-05', 2, '2022', '21048@supnum.mr', 3, 1, NULL),
(155, '21049', 'omelkheyri', 'mahfoudh', 'Nouadhibou', '1998-11-13', 2, '2022', '21049@supnum.mr', 3, 2, NULL),
(156, '21070', 'oudaa', 'oudaa', 'Nouakchott', '2001-08-21', 2, '2022', '21070@supnum.mr', 3, 3, NULL),
(157, '21075', 'mohamed El moustpha ', 'Mohamedou', 'Nouakchott', '2000-03-07', 2, '2022', '21075@supnum.mr', 3, 2, NULL),
(158, '21074', 'mohamed mahmoud', 'Abd El kader', 'Nouadhibou', '1998-05-29', 2, '2022', '21074@supnum.mr', 3, 1, NULL);

-- --------------------------------------------------------------------------------------------------------------------------------
-- -----------------------------------------------------------------------------------------------------------------------------------


INSERT INTO `inscription` (`id_etud`, `id_matiere`, `id_semestre`) VALUES
(74, 4, 2),
(70, 4, 2),
(104, 4, 2),
(74, 5, 3),
(70, 5, 3),
(104, 5, 3),
(74, 32, 4),
(70, 32, 4),
(104, 32, 4),
(70, 33, 5),
(74, 33, 5),
(104, 33, 5),
(74, 49, 6),
(70, 49, 6),
(104, 49, 6);





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




INSERT INTO `reponses` (`id_rep`, `description_rep`, `date`, `render`, `note`, `id_sous`, `id_etud`) VALUES
(1, 'Description', '2023-07-07 15:22:59', 0, 15.5, 3, 104),
(2, 'Description', '2023-07-07 13:23:57', 0, 0, 20, 104),
(3, 'Description', '2023-07-08 01:14:39', 0, 13, 33, 104),
(5, 'Description', '2023-07-08 01:15:42', 0, 15.75, 35, 104),
(6, 'Description', '2023-07-08 01:32:46', 0, 4.5, 19, 104),
(7, 'Description', '2023-07-08 01:35:05', 0, 13, 21, 104),
(8, 'Description', '2023-07-08 01:46:27', 0, 2, 22, 104),
(9, 'Description', '2023-07-08 02:11:47', 0, 14, 33, 74),
(10, 'Description', '2023-07-08 02:52:46', 0, 0, 3, 74),
(11, 'Description', '2023-07-08 02:53:49', 0, 14.25, 35, 74),
(12, 'Description', '2023-07-08 02:54:12', 0, 0, 20, 74),
(13, 'Description', '2023-07-08 02:56:25', 0, 12, 21, 74),
(14, 'Description', '2023-07-08 02:56:44', 0, 19, 22, 74),
(15, 'Description', '2023-07-08 02:59:52', 0, 0, 24, 74),
(16, 'Description', '2023-07-08 03:01:34', 0, 13, 26, 74),
(17, 'Description', '2023-07-08 03:02:06', 0, 10, 27, 74),
(18, 'Description', '2023-07-08 03:02:21', 0, 5.5, 28, 74),
(19, 'Description', '2023-07-08 03:02:59', 0, 14, 29, 74),
(20, 'Description', '2023-07-08 03:03:16', 0, 9, 30, 74),
(21, 'Description', '2023-07-08 03:03:31', 1, 2, 31, 74),
(22, 'Description', '2023-07-08 03:04:14', 0, 13.5, 32, 74),
(23, 'Description', '2023-07-08 03:10:10', 0, 14, 30, 104),
(24, 'Description', '2023-07-08 03:10:28', 1, 3, 31, 104),
(25, 'Description', '2023-07-08 03:10:50', 0, 5.5, 32, 104),
(26, 'Description', '2023-07-08 03:11:08', 0, 8, 27, 104),
(27, 'Description', '2023-07-08 03:12:57', 0, 0, 24, 104),
(28, 'Description', '2023-07-08 03:13:29', 0, 12, 25, 104),
(29, 'Description', '2023-07-08 03:13:47', 0, 12, 26, 104),
(30, 'Description', '2023-07-07 15:09:17', 0, 15.25, 29, 104);



INSERT INTO `fichiers_reponses` (`id_fich_rep`, `id_rep`, `nom_fichiere`, `chemin_fichiere`) VALUES
(1, 1, 'POO_Python.pdf', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8111cc7ac13.88073787.pdf'),
(2, 2, 'TP_01_SysLog_SupNum_2023 (1).pdf', 'C:/wamp64/www/projet_sous-main/Files/22053/64a811ed448ea1.50170706.pdf'),
(3, 3, 'Pix_moyennes (2).xlsx', 'C:/wamp64/www/projet_sous-main/Files/22053/64a82a9dd057f2.73416492.xlsx'),
(5, 5, 'Notes2023-07-05 (2).xls', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8b87f43a386.99301363.xls'),
(6, 5, 'RES-C1AS-2023.xlsx', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8b87f453461.37201240.xlsx'),
(7, 6, 'Pix_forme (1).xlsx', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8b8bec92ef0.47681037.xlsx'),
(8, 6, 'Notes2023-07-05.xls', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8b8beca6879.73207711.xls'),
(9, 7, 'vent.txt', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8bcbea5f132.68872050.txt'),
(10, 7, 'Pix_livres (6).xlsx', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8bcbea79ed0.54794728.xlsx'),
(11, 8, 'POO_Python (1).pdf', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8bd495d0ab3.42555633.pdf'),
(12, 8, 'enseignant (1).sql', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8bd495dbb86.50132992.sql'),
(13, 8, 'Pix_moyennes (2).xlsx', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8bd495e6b95.92859897.xlsx'),
(14, 10, 'Pix_moyennes (2) (1).xlsx', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8c5e3b30163.72488415.xlsx'),
(15, 11, 'POO_Python (1).pdf', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8cf7e27b205.45017529.pdf'),
(16, 12, 'groupe (1).sql', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8cfbd8777f5.89048081.sql'),
(17, 13, 'NoteService5 (1).odt', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8cfd4a8c9d3.45180669.odt'),
(18, 14, 'Pix_moyennes (2) (1).xlsx', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d05965faf6.89597784.xlsx'),
(19, 15, 'Pix_inscription (1).docx', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d06c48f524.16204155.docx'),
(20, 16, 'Chap 3 PL-SQL.pdf', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d12847e270.06532538.pdf'),
(21, 17, 'TP2 (1).pdf', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d18e16fca0.41623708.pdf'),
(22, 18, 'exo3_1.php', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d1aee29b65.43011311.php'),
(23, 20, 'Pix_liste.docx', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d1e3011b41.03991540.docx'),
(24, 20, 'NoteService5 (1).odt', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d1e301b641.09993179.odt'),
(25, 20, 'groupe (1).sql', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d1e3028977.47029996.sql'),
(26, 21, 'vent.txt', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d1f4ced710.61790962.txt'),
(27, 22, 'TP2 SE.pdf', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d203024619.64660065.pdf'),
(28, 23, 'TD4.docx', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d22e4fbeb6.45213198.docx'),
(29, 23, 'TD_BI_2.pdf', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d22e50fe57.33599669.pdf'),
(30, 23, 'SupNum_TPExcel.pdf', 'C:/wamp64/www/projet_sous-main/Files/22018/64a8d22e51cce3.14805311.pdf'),
(31, 24, 'etudiant (1).sql', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d3925de5e7.39361797.sql'),
(32, 24, 'etudiant (1).csv', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d3925e8965.74239642.csv'),
(33, 24, 'DSI210TP Les vues.pdf', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d3925f0b10.13414924.pdf'),
(34, 24, 'DSI TP3 Les Users.pdf', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d3925f85f0.17343681.pdf'),
(35, 25, 'exo3_1.php', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d3a4754094.24847162.php'),
(36, 25, 'evaluation_db.sql', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d3a475d775.01229208.sql'),
(37, 26, 'Notes2023-07-05 (2).xls', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d3baf28db9.93665680.xls'),
(38, 27, 'Pix_cinema.xlsx', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d3cc4d93f9.93651303.xlsx'),
(39, 27, 'Pix_charte.pdf', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d3cc4edfc9.56945224.pdf'),
(40, 28, 'DSI TP3 Les Users.pdf', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d439941240.30950158.pdf'),
(41, 28, 'Dev210TP1 (2).sql', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d439950388.82376929.sql'),
(42, 28, 'DEV21_Exam_2021_2022 (1).pdf', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d439966da1.52193369.pdf'),
(43, 29, 'Notes2023-07-05 (2).xls', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d459ea31a3.09752797.xls'),
(44, 29, 'Notes2023-07-05 (1).xls', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d459eb0c20.74931763.xls'),
(45, 30, 'Pix_inscription.docx', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d46be24d59.41094184.docx'),
(46, 30, 'Pix_inscription (2).docx', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d46be2e0d9.92482134.docx'),
(47, 30, 'Pix_inscription (1).docx', 'C:/wamp64/www/projet_sous-main/Files/22053/64a8d46be387e4.01925623.docx');





INSERT INTO `fichiers_soumission` (`id`, `id_sous`, `nom_fichier`, `chemin_fichier`) VALUES
(1, 19, 'Pix_invitation.pdf', 'C:/wamp64/www/projet_sous-main/Files/DSI321/64a80e62dc6ed9.00735829.pdf'),
(2, 20, 'Chap 2 les vues et les utilisateurs.pdf', 'C:/wamp64/www/projet_sous-main/Files/DSI321/64a80eafaf68a0.49523059.pdf'),
(3, 22, 'TP1 (1).pdf', 'C:/wamp64/www/projet_sous-main/Files/DSI321/64a80ef6a51235.27776468.pdf'),
(4, 24, 'Pix_codesPostaux.xlsx', 'C:/wamp64/www/projet_sous-main/Files/PAV313/64a80f25de1819.79516214.xlsx'),
(5, 25, 'Pix_invitation.pdf', 'C:/wamp64/www/projet_sous-main/Files/PAV313/64a80f51772622.06703586.pdf'),
(6, 26, 'Pix_guide.pdf', 'C:/wamp64/www/projet_sous-main/Files/PAV313/64a80f84564fd7.59083879.pdf'),
(7, 27, 'Pix_inscription.docx', 'C:/wamp64/www/projet_sous-main/Files/PAV314/64a80fb0f26ba8.65583703.docx'),
(8, 28, 'Pix_guide.pdf', 'C:/wamp64/www/projet_sous-main/Files/PAV314/64a80fd86b1e10.89182170.pdf'),
(9, 29, 'Pix_inscription (1).docx', 'C:/wamp64/www/projet_sous-main/Files/PAV314/64a810019939a4.96893700.docx'),
(10, 30, 'TD_Adressage_2_vierge corrige.pdf', 'C:/wamp64/www/projet_sous-main/Files/CNM410/64a81037dad2b2.67109492.pdf'),
(11, 31, 'Pix_eleves (1).xlsx', 'C:/wamp64/www/projet_sous-main/Files/CNM410/64a8106545dec4.66708767.xlsx'),
(12, 32, 'NoteService5 (1).odt', 'C:/wamp64/www/projet_sous-main/Files/CNM410/64a8109a928ce3.85003457.odt'),
(13, 33, 'transactions.txt', 'C:/wamp64/www/projet_sous-main/Files/DSI320/64a8b44b1d9534.22718912.txt'),
(14, 34, 'Pix_temperatures (2).xlsx', 'C:/wamp64/www/projet_sous-main/Files/DSI320/64a8b46fa789c7.32789377.xlsx'),
(15, 35, 'PIX-12.pdf', 'C:/wamp64/www/projet_sous-main/Files/DSI320/64a8b4b20502a6.10731719.pdf');



-- --------------------------------------------------------
-- --------------------------------------------------------
