<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireLogin();

$message = '';
$error = '';

if ($dbConnected && $pdo) {
    // Supprimer une réalisation
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
            $message = 'La réalisation a été supprimée avec succès.';
        }
    }

    // Ajouter ou modifier une réalisation
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
                    $message = 'La réalisation a été mise à jour avec succès.';
                } else {
                    $finalImage = $imageName !== '' ? $imageName : 'geo-foundation.svg';
                    $stmt = $pdo->prepare("INSERT INTO projects (title, description, technologies, url, image) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $description, $technologies, $url, $finalImage]);
                    $message = 'Votre nouvelle réalisation et sa photo sont maintenant en ligne !';
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
    <title>Publier une Réalisation | <?php echo SITE_NAME; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/responsive.css">
    <script>
        try { document.documentElement.setAttribute('data-theme', localStorage.getItem('portfolio_theme') || 'dark'); } catch (e) {}
    </script>
</head>
<body class="admin-body">
    <header class="header">
        <nav class="navbar">
            <div class="container nav-container">
                <a href="dashboard.php" class="logo">
                    <span class="logo-mark"><i class="fas fa-cloud-arrow-up"></i></span>
                    <span class="logo-text">
                        <strong>Publication Rapide</strong>
                        <small>Réalisations &amp; Photos — <?php echo SITE_NAME; ?></small>
                    </span>
                </a>
                <div class="nav-actions">
                    <a href="dashboard.php" class="btn btn-secondary btn-sm"><i class="fas fa-gauge-high"></i> Dashboard</a>
                    <a href="<?php echo SITE_URL; ?>/portfolio.php" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> Voir les Réalisations</a>
                    <a href="logout.php" class="btn btn-primary btn-sm"><i class="fas fa-power-off"></i> Déconnexion</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="section-padding">
        <div class="container">
            <?php if ($message): ?>
                <div class="alert alert-success" style="justify-content: space-between; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-circle-check"></i>
                        <span><?php echo htmlspecialchars($message); ?></span>
                    </div>
                    <a href="<?php echo SITE_URL; ?>/portfolio.php" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i> Voir sur la page Réalisations
                    </a>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-error"><i class="fas fa-triangle-exclamation"></i> <span><?php echo htmlspecialchars($error); ?></span></div>
            <?php endif; ?>

            <div class="admin-grid">
                <div class="admin-panel-card">
                    <h2>
                        <i class="fas fa-camera-retro" style="color: var(--blue-muted-light); margin-right: 0.4rem;"></i>
                        <?php echo $editProject ? 'Modifier la Réalisation' : 'Publier une Réalisation & Photo'; ?>
                    </h2>
                    <form method="POST" enctype="multipart/form-data" class="contact-form" style="padding: 0; border: none; background: transparent; box-shadow: none;">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <?php if ($editProject): ?>
                            <input type="hidden" name="id" value="<?php echo (int)$editProject['id']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="imageUpload"><i class="fas fa-image"></i> Photo du chantier / de l'étude (JPG, PNG, WEBP)</label>
                            <input type="file" id="imageUpload" name="image" accept="image/*" style="cursor: pointer;">
                            <div id="imagePreviewWrap" style="margin-top: 0.75rem; <?php echo ($editProject && !empty($editProject['image'])) ? '' : 'display: none;'; ?>">
                                <img id="imagePreview"
                                     src="<?php echo ($editProject && !empty($editProject['image'])) ? htmlspecialchars(getProjectImageUrl($editProject['image'])) : ''; ?>"
                                     alt="Aperçu de la photo"
                                     style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 10px; border: 1px solid var(--border-subtle);">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Titre de la réalisation *</label>
                            <input type="text" name="title" value="<?php echo $editProject ? htmlspecialchars($editProject['title']) : ''; ?>" placeholder="Ex. Essais au Pénétromètre Dynamique à Douala" required>
                        </div>

                        <div class="form-group">
                            <label>Description des travaux réalisés *</label>
                            <textarea name="description" rows="4" required placeholder="Décrivez brièvement l'étude, les essais de laboratoire ou le suivi de chantier..."><?php echo $editProject ? htmlspecialchars($editProject['description']) : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Outils, Essais &amp; Logiciels utilisés (séparés par des virgules) *</label>
                            <input type="text" name="technologies" value="<?php echo $editProject ? htmlspecialchars($editProject['technologies']) : ''; ?>" placeholder="Pénétromètre PDL, Essai Proctor, VBS, QGIS" required>
                        </div>

                        <div class="form-group">
                            <label>Lien externe ou contact (optionnel)</label>
                            <input type="text" name="url" value="<?php echo $editProject ? htmlspecialchars($editProject['url']) : ''; ?>" placeholder="contact.php?subject=Etude">
                        </div>

                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">
                                <i class="fas fa-cloud-arrow-up"></i> <?php echo $editProject ? 'Enregistrer les modifications' : 'Mettre en ligne maintenant'; ?>
                            </button>
                            <?php if ($editProject): ?>
                                <a href="manage-project.php" class="btn btn-secondary">Annuler</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="admin-panel-card">
                    <h2>Réalisations en ligne (<?php echo count($projects); ?>)</h2>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Réalisation</th>
                                    <th>Outils / Essais</th>
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
                                                <a href="?delete=<?php echo (int)$proj['id']; ?>" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Supprimer cette réalisation ?');">
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

    <script>
        const imageUpload = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('imagePreview');
        const imagePreviewWrap = document.getElementById('imagePreviewWrap');
        if (imageUpload && imagePreview && imagePreviewWrap) {
            imageUpload.addEventListener('change', (e) => {
                const file = e.target.files && e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        imagePreview.src = ev.target.result;
                        imagePreviewWrap.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
</body>
</html>
