<?php
include 'includes/header.php';

// Récupérer les projets depuis la base de données avec fallback intelligent
$projects = [];
if ($dbConnected && $pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
        $dbRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Vérifier si la BDD contient uniquement les anciens projets web d'exemple ("Site E-commerce", etc.)
        $genericTitles = ['Site E-commerce', 'Application de Gestion', 'Portfolio Photographe'];
        $filteredDbRows = [];
        foreach ($dbRows as $row) {
            if (!in_array($row['title'], $genericTitles, true)) {
                $filteredDbRows[] = $row;
            }
        }
        $projects = !empty($filteredDbRows) ? $filteredDbRows : $defaultProjects;
    } catch (PDOException $e) {
        $projects = $defaultProjects;
    }
} else {
    $projects = $defaultProjects;
}

// Déterminer automatiquement la catégorie d'un projet pour le filtre interactif
function resolveProjectCategory($project) {
    if (!empty($project['category'])) {
        return $project['category'];
    }
    $haystack = strtolower(($project['title'] ?? '') . ' ' . ($project['technologies'] ?? '') . ' ' . ($project['description'] ?? ''));
    if (strpos($haystack, 'sig') !== false || strpos($haystack, 'qgis') !== false || strpos($haystack, 'surpac') !== false || strpos($haystack, 'min') !== false) {
        return 'SIG & Mines';
    }
    if (strpos($haystack, 'béton') !== false || strpos($haystack, 'beton') !== false || strpos($haystack, 'dalle') !== false || strpos($haystack, 'revit') !== false) {
        return 'Matériaux & Génie Civil';
    }
    return 'Géotechnique';
}
?>

<section class="page-header">
    <div class="container" data-reveal="fade-up">
        <span class="section-tag">Réalisations &amp; Travaux</span>
        <h1>Portfolio d'Ingénierie</h1>
        <p>Découvrez mes études géotechniques, campagnes d'essais en laboratoire, modélisations minières et suivis de chantiers.</p>
    </div>
</section>

<section class="portfolio section-padding">
    <div class="container">
        <!-- Filtres de projets interactifs -->
        <div class="portfolio-filters" data-reveal="fade-up">
            <button type="button" class="filter-btn active" data-filter="all">Tous les projets</button>
            <button type="button" class="filter-btn" data-filter="geotech">Géotechnique &amp; Essais</button>
            <button type="button" class="filter-btn" data-filter="mines">SIG &amp; Modélisation Minière</button>
            <button type="button" class="filter-btn" data-filter="civil">Bétons &amp; Génie Civil</button>
        </div>

        <div class="portfolio-grid" id="portfolioGrid">
            <?php foreach ($projects as $index => $project):
                $categoryLabel = resolveProjectCategory($project);
                $catLower = strtolower($categoryLabel);
                $filterSlug = 'geotech';
                if (strpos($catLower, 'mine') !== false || strpos($catLower, 'sig') !== false || strpos($catLower, 'modélisation') !== false || strpos($catLower, 'iot') !== false) {
                    $filterSlug = 'mines';
                } elseif (strpos($catLower, 'béton') !== false || strpos($catLower, 'matériaux') !== false || strpos($catLower, 'civil') !== false) {
                    $filterSlug = 'civil';
                }
                $imgUrl = getProjectImageUrl($project['image'] ?? '');
                $location = $project['location'] ?? 'Cameroun';
                $year = $project['year'] ?? (isset($project['created_at']) ? date('Y', strtotime($project['created_at'])) : '2025');
                $metrics = $project['metrics'] ?? 'Conformité aux normes géotechniques & génie civil';
                $projectUrl = !empty($project['url']) ? $project['url'] : (SITE_URL . '/contact.php?subject=' . urlencode($project['title']));
            ?>
            <article class="portfolio-item" data-category="<?php echo htmlspecialchars($filterSlug); ?>" data-reveal="fade-up" data-delay="<?php echo (($index % 3) + 1) * 100; ?>">
                <div class="portfolio-image">
                    <span class="portfolio-badge"><?php echo htmlspecialchars($categoryLabel); ?></span>
                    <span class="portfolio-year"><?php echo htmlspecialchars($year); ?></span>
                    <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
                    <div class="portfolio-overlay">
                        <button type="button"
                                class="btn btn-primary btn-sm open-project-modal"
                                data-title="<?php echo htmlspecialchars($project['title']); ?>"
                                data-category="<?php echo htmlspecialchars($categoryLabel); ?>"
                                data-location="<?php echo htmlspecialchars($location); ?>"
                                data-year="<?php echo htmlspecialchars($year); ?>"
                                data-desc="<?php echo htmlspecialchars($project['description']); ?>"
                                data-metrics="<?php echo htmlspecialchars($metrics); ?>"
                                data-techs="<?php echo htmlspecialchars($project['technologies']); ?>"
                                data-img="<?php echo htmlspecialchars($imgUrl); ?>"
                                data-url="<?php echo htmlspecialchars($projectUrl); ?>">
                            <i class="fas fa-magnifying-glass-plus"></i> Voir les détails
                        </button>
                    </div>
                </div>

                <div class="portfolio-info">
                    <div class="portfolio-meta-top">
                        <span><i class="fas fa-location-dot"></i> <?php echo htmlspecialchars($location); ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                    <p><?php echo htmlspecialchars($project['description']); ?></p>

                    <div class="project-metric-bar">
                        <i class="fas fa-check-double"></i>
                        <span><?php echo htmlspecialchars($metrics); ?></span>
                    </div>

                    <div class="technologies">
                        <?php
                        $techs = explode(',', $project['technologies'] ?? '');
                        foreach ($techs as $tech):
                            if (trim($tech) !== ''):
                        ?>
                        <span class="tech-tag"><?php echo htmlspecialchars(trim($tech)); ?></span>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Modal de détail d'un projet -->
<div class="project-modal" id="projectModal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="project-modal-backdrop" id="modalBackdrop"></div>
    <div class="project-modal-dialog">
        <button type="button" class="project-modal-close" id="modalClose" aria-label="Fermer">
            <i class="fas fa-xmark"></i>
        </button>
        <div class="project-modal-media">
            <img src="" alt="" id="modalImg">
            <span class="portfolio-badge" id="modalCategory"></span>
        </div>
        <div class="project-modal-body">
            <div class="modal-meta">
                <span id="modalLocation"><i class="fas fa-location-dot"></i> Cameroun</span>
                <span id="modalYear"><i class="fas fa-calendar"></i> 2025</span>
            </div>
            <h2 id="modalTitle">Titre du projet</h2>
            <p id="modalDesc"></p>
            <div class="project-metric-bar" id="modalMetricsWrap">
                <i class="fas fa-chart-simple"></i>
                <span id="modalMetrics"></span>
            </div>
            <div class="modal-tech-section">
                <h4>Outils, Normes &amp; Méthodes mobilisés :</h4>
                <div class="technologies" id="modalTechs"></div>
            </div>
            <div class="modal-actions">
                <a href="<?php echo SITE_URL; ?>/contact.php" id="modalLink" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Discuter d'un projet similaire
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
