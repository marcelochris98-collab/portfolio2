<?php
// Démarrer la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    $currentSavePath = session_save_path();
    if (empty($currentSavePath) || !is_writable($currentSavePath)) {
        session_save_path(sys_get_temp_dir());
    }
    session_start();
}

// Configuration de la base de données MySQL (supporte le local et les variables d'environnement Cloud / Railway)
define('DB_HOST', getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('MYSQLPORT') ?: getenv('DB_PORT') ?: '3306');
define('DB_USER', getenv('MYSQLUSER') ?: getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('MYSQLPASSWORD') ?: getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: 'profil');

// Détection dynamique de l'URL du site pour éviter les liens cassés (Apache /profil, php -S localhost:8000 ou Cloud HTTPS)
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
    || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on');
$protocol = $isHttps ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
$scriptDir = isset($_SERVER['SCRIPT_NAME']) ? rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') : '';
if (substr($scriptDir, -6) === '/admin') {
    $scriptDir = substr($scriptDir, 0, -6);
}
$detectedUrl = ($scriptDir === '' || $scriptDir === '.' || $scriptDir === '/') ? "$protocol://$host" : "$protocol://$host$scriptDir";

define('SITE_URL', $detectedUrl);
define('SITE_NAME', 'Ariel Wamba');
define('SITE_ROLE', 'Ingénieur Géotechnicien & Minier');
define('SITE_EMAIL', 'arielsolefackwamba@gmail.com');
define('SITE_PHONE', '(+237) 658 13 60 20');
define('SITE_LOCATION', 'Meiganga, Cameroun');

// Projets géotechniques et miniers par défaut
$defaultProjects = [
    [
        'id' => 1,
        'title' => 'Campagne Géotechnique & Dimensionnement de Fondations',
        'category' => 'Géotechnique',
        'location' => 'Douala & Yaoundé, Cameroun',
        'year' => '2025',
        'description' => 'Réalisation d\'essais au pénétromètre dynamique lourd (PDL) in situ et caractérisation complète en laboratoire (essais Proctor, VBS, granulométrie, teneur en eau) pour le dimensionnement d\'ouvrages de génie civil.',
        'technologies' => 'Pénétromètre PDL, Essai Proctor, VBS, Granulométrie, Dimensionnement',
        'metrics' => '24 sondages in situ • Portance admissible calculée à 2.4 bars',
        'image' => 'geo-foundation.svg',
        'url' => 'contact.php?subject=Etude+Geotechnique'
    ],
    [
        'id' => 2,
        'title' => 'Cartographie SIG & Prospection Minière Aurifère',
        'category' => 'SIG & Mines',
        'location' => 'Meiganga (Adamaoua), Cameroun',
        'year' => '2024',
        'description' => 'Collecte de données géologiques de terrain au GPS différentiel, élaboration de cartes thématiques multi-couches et modélisation des anomalies géochimiques et topographiques.',
        'technologies' => 'QGIS, ArcGIS, Surfer, GPS Terrain, Géologie Structurale',
        'metrics' => '120 km² cartographiés • 8 zones d\'intérêt identifiées',
        'image' => 'gis-mining.svg',
        'url' => 'contact.php?subject=Cartographie+SIG'
    ],
    [
        'id' => 3,
        'title' => 'Formulation & Contrôle Qualité des Bétons Hydrauliques',
        'category' => 'Matériaux & Béton',
        'location' => 'Geofondation, Cameroun',
        'year' => '2025',
        'description' => 'Optimisation de la formulation de bétons de structure (méthode Dreux-Gorisse), suivi d\'affaissement au cône d\'Abrams et essais d\'écrasement à 7 et 28 jours pour garantir la résistance caractéristique.',
        'technologies' => 'Dreux-Gorisse, Contrôle Qualité, Essais de Compression, Matériaux Locaux',
        'metrics' => 'Résistance C30/37 atteinte • +15% d\'optimisation cimentaire',
        'image' => 'concrete-lab.svg',
        'url' => 'contact.php?subject=Controle+Qualite+Beton'
    ],
    [
        'id' => 4,
        'title' => 'Modélisation 3D de Gisement & Stabilité des Talus',
        'category' => 'Modélisation Minière',
        'location' => 'Projet d\'Exploitation à Ciel Ouvert',
        'year' => '2024',
        'description' => 'Interprétation des logs de sondages carottés, modélisation géologique en blocs 3D et analyse de stabilité des gradins et talus miniers pour sécuriser l\'exploitation.',
        'technologies' => 'Surpac, AutoCAD, Géomécanique, Calcul de Stabilité, Excel VBA',
        'metrics' => 'Facteur de sécurité Fs > 1.35 • Modèle de bloc 3D validé',
        'image' => 'slope-stability.svg',
        'url' => 'contact.php?subject=Modelisation+Miniere'
    ],
    [
        'id' => 5,
        'title' => 'Suivi d\'Exécution & Ferraillage de Dalles Pleines',
        'category' => 'Génie Civil',
        'location' => 'Groupe Somaf, Cameroun',
        'year' => '2024',
        'description' => 'Calcul et vérification des plans de ferraillage de dalles pleines sous charges d\'exploitation, contrôle de mise en œuvre sur chantier et supervision des travaux de second œuvre.',
        'technologies' => 'Revit, AutoCAD, Béton Armé, Suivi de Chantier, Métré',
        'metrics' => '1 200 m² de planchers suivis • Conformité structurelle 100%',
        'image' => 'structural-slab.svg',
        'url' => 'contact.php?subject=Suivi+Chantier'
    ],
    [
        'id' => 6,
        'title' => 'Système Automatisé de Détection & Sécurité Minière',
        'category' => 'Innovation & IoT',
        'location' => 'SMEG, Cameroun',
        'year' => '2023',
        'description' => 'Conception et programmation d\'un prototype de capteur environnemental (fumée, gaz et température) sous Arduino et MATLAB pour la prévention des risques en environnement confiné.',
        'technologies' => 'Arduino, MATLAB, Capteurs Gaz/Fumée, Traitement du Signal',
        'metrics' => 'Temps de réponse < 1.5s • Alerte temps réel',
        'image' => 'iot-safety.svg',
        'url' => 'contact.php?subject=Innovation+Securite'
    ]
];

/**
 * Peupler une base PDO nouvellement créée (MySQL ou SQLite)
 */
function seedInitialDatabase(PDO $db, array $defaultProjects) {
    $checkAdmin = (int)$db->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    if ($checkAdmin === 0) {
        $stmtAdmin = $db->prepare("INSERT INTO admin_users (username, password) VALUES ('admin', ?)");
        $stmtAdmin->execute([password_hash('admin123', PASSWORD_DEFAULT)]);
    }

    $checkProj = (int)$db->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    if ($checkProj === 0) {
        $stmtProj = $db->prepare("INSERT INTO projects (title, description, technologies, image, url) VALUES (?, ?, ?, ?, ?)");
        foreach ($defaultProjects as $dp) {
            $stmtProj->execute([$dp['title'], $dp['description'], $dp['technologies'], $dp['image'], $dp['url']]);
        }
    }

    $checkContacts = (int)$db->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
    if ($checkContacts === 0) {
        $stmtContact = $db->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmtContact->execute([
            'Bureau d\'Études Géotech Cameroun',
            'contact@geotech-cm.com',
            'Demande de campagne d\'essais PDL & Proctor',
            'Bonjour M. Wamba, nous souhaitons collaborer avec vous pour une campagne de 15 sondages au pénétromètre dynamique sur un chantier à Yaoundé.'
        ]);
    }
}

$pdo = null;
$dbConnected = false;
$dbEngine = 'none';

// 1. Tentative de connexion à MySQL
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 2
        ]
    );
    $dbConnected = true;
    $dbEngine = 'MySQL';
} catch (PDOException $e) {
    // Tenter de créer la base MySQL si l'utilisateur a les droits
    try {
        $tempPdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4", DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 2
        ]);
        $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $tempPdo->exec("USE `" . DB_NAME . "`");
        $tempPdo->exec("CREATE TABLE IF NOT EXISTS projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            technologies VARCHAR(255),
            image VARCHAR(255),
            url VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $tempPdo->exec("CREATE TABLE IF NOT EXISTS contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            subject VARCHAR(200),
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $tempPdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        seedInitialDatabase($tempPdo, $defaultProjects);
        $pdo = $tempPdo;
        $dbConnected = true;
        $dbEngine = 'MySQL';
    } catch (PDOException $mysqlErr) {
        // 2. Bascule automatique sur SQLite PDO local (sql/profil.sqlite) si MySQL root nécessite sudo
        try {
            $sqlitePath = dirname(__DIR__) . '/sql/profil.sqlite';
            $sqlitePdo = new PDO("sqlite:" . $sqlitePath, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            $sqlitePdo->exec("CREATE TABLE IF NOT EXISTS projects (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                description TEXT,
                technologies TEXT,
                image TEXT,
                url TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
            $sqlitePdo->exec("CREATE TABLE IF NOT EXISTS contacts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                subject TEXT,
                message TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
            $sqlitePdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");

            seedInitialDatabase($sqlitePdo, $defaultProjects);
            $pdo = $sqlitePdo;
            $dbConnected = true;
            $dbEngine = 'SQLite';
        } catch (PDOException $sqliteErr) {
            $pdo = null;
            $dbConnected = false;
        }
    }
}
?>
