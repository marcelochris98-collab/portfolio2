<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$message = '';
$error = '';

if ($dbConnected && $pdo) {
    // Supprimer un projet
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $project = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($project && !empty($project['image'])) {
            $imgPath = '../img/projects/' . basename($project['image']);
            $defaultSvgs = ['geo-foundation.svg', 'gis-mining.svg', 'concrete-lab.svg', 'slope-stability.svg', 'structural-slab.svg', 'iot-safety.svg'];
            if (!in_array($project['image'], $defaultSvgs, true) && file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        if ($stmt->execute([$id])) {
            $message = 'Le projet a été supprimé avec succès.';
        }
    }

    // Ajouter ou modifier un projet
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            $error = 'Jeton de sécurité CSRF invalide.';
        } else {
            $title = clean($_POST['title'] ?? '');
            $description = clean($_POST['description'] ?? '');
            $technologies = clean($_POST['technologies'] ?? '');
            $url = clean($_POST['url'] ?? '');
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

            $imageName = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploadResult = uploadImage($_FILES['image']);
                if ($uploadResult['success']) {
                    $imageName = $uploadResult['filename'];
                } else {
                    $error = $uploadResult['message'];
                }
            }

            if (empty($error)) {
                if ($id > 0) {
                    if ($imageName !== '') {
                        $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, technologies = ?, url = ?, image = ? WHERE id = ?");
                        $stmt->execute([$title, $description, $technologies, $url, $imageName, $id]);
                    } else {
                        $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, technologies = ?, url = ? WHERE id = ?");
                        $stmt->execute([$title, $description, $technologies, $url, $id]);
                    }
                    $message = 'Le projet a été mis à jour avec succès.';
                } else {
                    $finalImage = $imageName !== '' ? $imageName : 'geo-foundation.svg';
                    $stmt = $pdo->prepare("INSERT INTO projects (title, description, technologies, url, image) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $description, $technologies, $url, $finalImage]);
                    $message = 'Le nouveau projet a été ajouté avec succès.';
                }
            }
        }
    }
}

$projects = $defaultProjects;
$editProject = null;

if ($dbConnected && $pdo) {
    try {
        $projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
        if (isset($_GET['edit'])) {
            $id = intval($_GET['edit']);
            $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
            $stmt->execute([$id]);
            $editProject = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        $projects = $defaultProjects;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Projets | <?php echo SITE_NAME; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/style.css">
</head>
<body class="admin-body">
    <header class="header">
        <nav class="navbar">
            <div class="container nav-container">
                <a href="dashboard.php" class="logo">
                    <span class="logo-mark"><i class="fas fa-folder-tree"></i></span>
                    <span class="logo-text">
                        <strong>Gestion des Projets</strong>
                        <small>Administration <?php echo SITE_NAME; ?></small>
                    </span>
                </a>
                <div class="nav-actions">
                    <a href="dashboard.php" class="btn btn-secondary btn-sm"><i class="fas fa-gauge-high"></i> Dashboard</a>
                    <a href="<?php echo SITE_URL; ?>/portfolio.php" target="_blank" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> Voir le Portfolio</a>
                    <a href="logout.php" class="btn btn-primary btn-sm"><i class="fas fa-power-off"></i> Déconnexion</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="section-padding">
        <div class="container">
            <?php if ($message): ?>
                <div class="alert alert-success"><i class="fas fa-circle-check"></i> <span><?php echo htmlspecialchars($message); ?></span></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-error"><i class="fas fa-triangle-exclamation"></i> <span><?php echo htmlspecialchars($error); ?></span></div>
            <?php endif; ?>

            <div class="admin-grid">
                <div class="admin-panel-card">
                    <h2><?php echo $editProject ? 'Modifier le Projet' : 'Ajouter un Projet'; ?></h2>
                    <form method="POST" enctype="multipart/form-data" class="contact-form" style="padding: 0; border: none; background: transparent; box-shadow: none;">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <?php if ($editProject): ?>
                            <input type="hidden" name="id" value="<?php echo (int)$editProject['id']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Titre de l'étude / du projet *</label>
                            <input type="text" name="title" value="<?php echo $editProject ? htmlspecialchars($editProject['title']) : ''; ?>" placeholder="Ex. Campagne Géotechnique & Essais PDL" required>
                        </div>

                        <div class="form-group">
                            <label>Description technique *</label>
                            <textarea name="description" rows="4" required placeholder="Détaillez les essais réalisés, la méthodologie et les résultats..."><?php echo $editProject ? htmlspecialchars($editProject['description']) : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Outils, Normes &amp; Technologies (séparés par des virgules) *</label>
                            <input type="text" name="technologies" value="<?php echo $editProject ? htmlspecialchars($editProject['technologies']) : ''; ?>" placeholder="Pénétromètre PDL, Essai Proctor, VBS, QGIS" required>
                        </div>

                        <div class="form-group">
                            <label>Lien ou référence (optionnel)</label>
                            <input type="text" name="url" value="<?php echo $editProject ? htmlspecialchars($editProject['url']) : ''; ?>" placeholder="contact.php?subject=Etude">
                        </div>

                        <div class="form-group">
                            <label>Illustration (JPG, PNG, WEBP, SVG)</label>
                            <input type="file" name="image" accept="image/*">
                        </div>

                        <div style="display: flex; gap: 0.75rem;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-floppy-disk"></i> <?php echo $editProject ? 'Enregistrer' : 'Publier le projet'; ?>
                            </button>
                            <?php if ($editProject): ?>
                                <a href="manage-project.php" class="btn btn-secondary">Annuler</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="admin-panel-card">
                    <h2>Catalogue Actuel (<?php echo count($projects); ?>)</h2>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Aperçu</th>
                                    <th>Projet</th>
                                    <th>Outils / Méthodes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $proj): ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo htmlspecialchars(getProjectImageUrl($proj['image'] ?? '')); ?>" alt="" class="admin-thumb">
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($proj['title']); ?></strong>
                                        </td>
                                        <td>
                                            <span class="admin-tech-text"><?php echo htmlspecialchars($proj['technologies']); ?></span>
                                        </td>
                                        <td>
                                            <div class="admin-actions">
                                                <a href="?edit=<?php echo (int)$proj['id']; ?>" class="btn btn-secondary btn-sm" title="Modifier">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="?delete=<?php echo (int)$proj['id']; ?>" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Supprimer ce projet ?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
