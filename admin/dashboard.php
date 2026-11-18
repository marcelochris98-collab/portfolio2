<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$totalProjects = count($defaultProjects);
$totalContacts = 0;
$recentContacts = [];

if ($dbConnected && $pdo) {
    try {
        $totalProjects = (int)$pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
        $totalContacts = (int)$pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
        $recentContacts = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 8")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Fallback gracieux
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin | <?php echo SITE_NAME; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/style.css">
    <script>
        try { document.documentElement.setAttribute('data-theme', localStorage.getItem('portfolio_theme') || 'dark'); } catch (e) {}
    </script>
</head>
<body class="admin-body">
    <header class="header">
        <nav class="navbar">
            <div class="container nav-container">
                <a href="dashboard.php" class="logo">
                    <span class="logo-mark"><i class="fas fa-gauge-high"></i></span>
                    <span class="logo-text">
                        <strong>Tableau de Bord</strong>
                        <small>Administration <?php echo SITE_NAME; ?></small>
                    </span>
                </a>
                <div class="nav-actions">
                    <a href="manage-project.php" class="btn btn-secondary btn-sm"><i class="fas fa-folder-open"></i> Gérer les projets</a>
                    <a href="<?php echo SITE_URL; ?>/index.php" target="_blank" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-up-right-from-square"></i> Voir le site</a>
                    <a href="logout.php" class="btn btn-primary btn-sm"><i class="fas fa-power-off"></i> Déconnexion</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="section-padding">
        <div class="container">
            <div class="section-header-flex">
                <div>
                    <span class="section-tag">Espace Administrateur</span>
                    <h1 class="section-title">Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></h1>
                </div>
            </div>

            <div class="skills-grid" style="margin-bottom: 3rem;">
                <div class="skill-card">
                    <div class="skill-card-header">
                        <div class="skill-icon"><i class="fas fa-diagram-project"></i></div>
                        <span class="skill-index">PROJETS</span>
                    </div>
                    <h3 style="font-size: 2.5rem; margin-bottom: 0.4rem;"><?php echo $totalProjects; ?></h3>
                    <p class="skill-desc">Projets et études publiés dans le portfolio.</p>
                    <a href="manage-project.php" class="btn btn-primary btn-sm">Gérer le catalogue <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="skill-card">
                    <div class="skill-card-header">
                        <div class="skill-icon"><i class="fas fa-envelope-open-text"></i></div>
                        <span class="skill-index">MESSAGES</span>
                    </div>
                    <h3 style="font-size: 2.5rem; margin-bottom: 0.4rem;"><?php echo $totalContacts; ?></h3>
                    <p class="skill-desc">Demandes de contact et devis reçus via le formulaire.</p>
                </div>

                <div class="skill-card">
                    <div class="skill-card-header">
                        <div class="skill-icon"><i class="fas fa-server"></i></div>
                        <span class="skill-index">SYSTÈME</span>
                    </div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.4rem;"><?php echo $dbConnected ? 'Base SQL Active (' . htmlspecialchars($dbEngine ?? 'PDO') . ')' : 'Mode Autonome'; ?></h3>
                    <p class="skill-desc">Date serveur : <?php echo date('d/m/Y H:i'); ?></p>
                </div>
            </div>

            <div class="admin-panel-card">
                <h2><i class="fas fa-inbox"></i> Derniers Messages Reçus</h2>
                <?php if (count($recentContacts) > 0): ?>
                    <div class="admin-messages-list">
                        <?php foreach ($recentContacts as $contact): ?>
                            <div class="admin-message-item">
                                <div class="message-top">
                                    <div>
                                        <strong><?php echo htmlspecialchars($contact['name']); ?></strong>
                                        <span class="message-email">&lt;<?php echo htmlspecialchars($contact['email']); ?>&gt;</span>
                                    </div>
                                    <span class="message-date"><i class="fas fa-clock"></i> <?php echo date('d/m/Y à H:i', strtotime($contact['created_at'])); ?></span>
                                </div>
                                <?php if (!empty($contact['subject'])): ?>
                                    <div class="message-subject">Objet : <?php echo htmlspecialchars($contact['subject']); ?></div>
                                <?php endif; ?>
                                <p class="message-body"><?php echo nl2br(htmlspecialchars($contact['message'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="empty-state">Aucun message enregistré pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
