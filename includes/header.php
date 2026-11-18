<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$currentPage = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$pageTitles = [
    'index.php'     => 'Accueil | Ingénierie Géotechnique & Minière',
    'about.php'     => 'À Propos & Parcours | ' . SITE_NAME,
    'services.php'  => 'Expertises & Prestations Techniques | ' . SITE_NAME,
    'portfolio.php' => 'Projets & Études de Terrain | ' . SITE_NAME,
    'contact.php'   => 'Contact & Devis | ' . SITE_NAME,
];
$pageTitle = $pageTitles[$currentPage] ?? (SITE_NAME . ' | ' . SITE_ROLE);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portfolio professionnel d'Ariel Wamba, Ingénieur en Géotechnique et Exploitation Minière au Cameroun. Essais de laboratoire et in situ, dimensionnement, SIG et modélisation minière.">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/responsive.css">
    <script>
        (function() {
            try {
                var savedTheme = localStorage.getItem('portfolio_theme') || 'dark';
                document.documentElement.setAttribute('data-theme', savedTheme);
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
</head>
<body>
    <div class="bg-grid-overlay" aria-hidden="true"></div>
    <div class="bg-glow bg-glow-1" aria-hidden="true"></div>
    <div class="bg-glow bg-glow-2" aria-hidden="true"></div>

    <header class="header" id="siteHeader">
        <nav class="navbar">
            <div class="container nav-container">
                <a href="<?php echo SITE_URL; ?>/index.php" class="logo" aria-label="Accueil <?php echo SITE_NAME; ?>">
                    <span class="logo-mark">
                        <i class="fas fa-layer-group"></i>
                    </span>
                    <span class="logo-text">
                        <strong>Ariel Wamba</strong>
                        <small>Ing. Géotechnique &amp; Mines</small>
                    </span>
                </a>

                <ul class="nav-menu" id="navMenu">
                    <li>
                        <a href="<?php echo SITE_URL; ?>/index.php" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/about.php" class="<?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">
                            Parcours
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/services.php" class="<?php echo $currentPage === 'services.php' ? 'active' : ''; ?>">
                            Expertises
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/portfolio.php" class="<?php echo $currentPage === 'portfolio.php' ? 'active' : ''; ?>">
                            Réalisations
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/contact.php" class="<?php echo $currentPage === 'contact.php' ? 'active' : ''; ?>">
                            Contact
                        </a>
                    </li>
                    <li class="nav-cta-mobile">
                        <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-paper-plane"></i> Discuter d'un projet
                        </a>
                    </li>
                </ul>

                <div class="nav-actions">
                    <span class="availability-pill" title="Disponible pour missions et études géotechniques">
                        <span class="status-dot"></span> Disponible
                    </span>
                    <button type="button" class="theme-toggle" id="themeToggle" aria-label="Basculer entre le mode sombre et le mode clair" title="Mode sombre / Mode clair">
                        <i class="fas fa-sun icon-sun" aria-hidden="true"></i>
                        <i class="fas fa-moon icon-moon" aria-hidden="true"></i>
                    </button>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary btn-sm nav-cta-desktop">
                        Me contacter <i class="fas fa-arrow-up-right-from-square"></i>
                    </a>
                    <button class="hamburger" id="hamburger" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </nav>
    </header>
    <main class="site-main">
