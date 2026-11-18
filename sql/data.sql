-- Script d'initialisation de la base de données du Portfolio Ariel Wamba
CREATE DATABASE IF NOT EXISTS `profil` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `profil`;

-- Table des projets
CREATE TABLE IF NOT EXISTS `projects` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `technologies` VARCHAR(255),
    `image` VARCHAR(255),
    `url` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des contacts
CREATE TABLE IF NOT EXISTS `contacts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `subject` VARCHAR(200),
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des administrateurs
CREATE TABLE IF NOT EXISTS `admin_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Utilisateur administrateur par défaut (identifiant: admin / mot de passe: password ou admin123 selon hash)
INSERT IGNORE INTO `admin_users` (`username`, `password`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Projets d'ingénierie géotechnique et minière
INSERT INTO `projects` (`title`, `description`, `technologies`, `image`, `url`) VALUES
('Campagne Géotechnique & Dimensionnement de Fondations', 'Réalisation d\'essais au pénétromètre dynamique lourd (PDL) in situ et caractérisation complète en laboratoire (essais Proctor, VBS, granulométrie, teneur en eau) pour le dimensionnement d\'ouvrages de génie civil.', 'Pénétromètre PDL, Essai Proctor, VBS, Granulométrie, Dimensionnement', 'geo-foundation.svg', 'contact.php?subject=Etude+Geotechnique'),
('Cartographie SIG & Prospection Minière Aurifère', 'Collecte de données géologiques de terrain au GPS différentiel, élaboration de cartes thématiques multi-couches et modélisation des anomalies géochimiques et topographiques à Meiganga.', 'QGIS, ArcGIS, Surfer, GPS Terrain, Géologie Structurale', 'gis-mining.svg', 'contact.php?subject=Cartographie+SIG'),
('Formulation & Contrôle Qualité des Bétons Hydrauliques', 'Optimisation de la formulation de bétons de structure (méthode Dreux-Gorisse), suivi d\'affaissement au cône d\'Abrams et essais d\'écrasement à 7 et 28 jours chez Geofondation.', 'Dreux-Gorisse, Contrôle Qualité, Essais de Compression, Matériaux Locaux', 'concrete-lab.svg', 'contact.php?subject=Controle+Qualite+Beton'),
('Modélisation 3D de Gisement & Stabilité des Talus', 'Interprétation des logs de sondages carottés, modélisation géologique en blocs 3D et analyse de stabilité des gradins et talus miniers pour sécuriser l\'exploitation.', 'Surpac, AutoCAD, Géomécanique, Calcul de Stabilité, Excel VBA', 'slope-stability.svg', 'contact.php?subject=Modelisation+Miniere'),
('Suivi d\'Exécution & Ferraillage de Dalles Pleines', 'Calcul et vérification des plans de ferraillage de dalles pleines sous charges d\'exploitation, contrôle de mise en œuvre sur chantier et supervision des travaux chez Groupe Somaf.', 'Revit, AutoCAD, Béton Armé, Suivi de Chantier, Métré', 'structural-slab.svg', 'contact.php?subject=Suivi+Chantier'),
('Système Automatisé de Détection & Sécurité Minière', 'Conception et programmation d\'un prototype de capteur environnemental (fumée, gaz et température) sous Arduino et MATLAB pour la prévention des risques chez SMEG.', 'Arduino, MATLAB, Capteurs Gaz/Fumée, Traitement du Signal', 'iot-safety.svg', 'contact.php?subject=Innovation+Securite');
