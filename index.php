<?php
require_once 'includes/header.php';

// Récupérer les 3 premiers projets pour l'aperçu sur l'accueil
$featuredProjects = array_slice($defaultProjects, 0, 3);
if ($dbConnected && $pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 3");
        $dbProjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($dbProjects)) {
            $featuredProjects = $dbProjects;
        }
    } catch (PDOException $e) {
        // Fallback sur $defaultProjects
    }
}
?>

<section class="hero">
    <div class="container hero-grid">
        <div class="hero-content" data-reveal="fade-up">
            <div class="hero-badge">
                <i class="fas fa-compass-drafting"></i>
                <span>Ariel Wamba • Ingénieur Géotechnicien &amp; Minier</span>
            </div>

            <h1 class="hero-title">
                Études Géotechniques, Contrôle Matériaux &amp; <span class="text-gradient">Ingénierie Minière.</span>
            </h1>

            <p class="hero-subtitle">
                De la caractérisation mécanique des sols et des roches jusqu'au dimensionnement d'ouvrages et à la modélisation 3D de gisements, j'accompagne les projets de génie civil et d'exploitation minière avec rigueur scientifique et exigence terrain.
            </p>

            <div class="hero-buttons">
                <a href="<?php echo SITE_URL; ?>/portfolio.php" class="btn btn-primary">
                    <span>Voir mes réalisations</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-secondary">
                    <i class="fas fa-envelope"></i>
                    <span>Demander une étude</span>
                </a>
            </div>

            <div class="hero-metrics">
                <div class="metric-item">
                    <span class="metric-value"><span class="counter" data-target="5">5</span>+</span>
                    <span class="metric-label">Années de pratique &amp; terrain</span>
                </div>
                <div class="metric-divider"></div>
                <div class="metric-item">
                    <span class="metric-value"><span class="counter" data-target="15">15</span>+</span>
                    <span class="metric-label">Campagnes &amp; études réalisées</span>
                </div>
                <div class="metric-divider"></div>
                <div class="metric-item">
                    <span class="metric-value"><span class="counter" data-target="100">100</span>%</span>
                    <span class="metric-label">Rigueur normative (NF / EN)</span>
                </div>
            </div>
        </div>

        <div class="hero-visual" data-reveal="fade-left">
            <div class="profile-frame">
                <div class="profile-backdrop"></div>
                <img src="<?php echo SITE_URL; ?>/img/wam.jpg" alt="Ariel Wamba - Ingénieur en Géotechnique" class="profile-img">
                
                <div class="floating-badge badge-top-left">
                    <div class="badge-icon"><i class="fas fa-mountain"></i></div>
                    <div>
                        <strong>Essais In Situ &amp; Labo</strong>
                        <span>PDL • Proctor • VBS • Granulométrie</span>
                    </div>
                </div>

                <div class="floating-badge badge-bottom-right">
                    <div class="badge-icon"><i class="fas fa-cubes"></i></div>
                    <div>
                        <strong>SIG &amp; Modélisation 3D</strong>
                        <span>Surpac • QGIS • ArcGIS • Revit</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="tech-ticker" aria-label="Outils et normes maîtrisés">
    <div class="container">
        <div class="ticker-wrapper">
            <span class="ticker-label"><i class="fas fa-terminal"></i> Écosystème technique :</span>
            <div class="ticker-items">
                <div class="ticker-track">
                    <span class="ticker-chip"><i class="fas fa-bore-hole"></i> Pénétromètre PDL</span>
                    <span class="ticker-chip"><i class="fas fa-flask"></i> Essais Proctor &amp; VBS</span>
                    <span class="ticker-chip"><i class="fas fa-cube"></i> Surpac 3D</span>
                    <span class="ticker-chip"><i class="fas fa-map-location-dot"></i> QGIS &amp; ArcGIS</span>
                    <span class="ticker-chip"><i class="fas fa-building"></i> Autodesk Revit &amp; AutoCAD</span>
                    <span class="ticker-chip"><i class="fas fa-chart-area"></i> Surfer &amp; Geosoft</span>
                    <span class="ticker-chip"><i class="fas fa-code"></i> MATLAB &amp; Arduino</span>
                    <!-- Copie pour le défilement continu (droite vers gauche) sur mobile -->
                    <span class="ticker-chip ticker-dup" aria-hidden="true"><i class="fas fa-bore-hole"></i> Pénétromètre PDL</span>
                    <span class="ticker-chip ticker-dup" aria-hidden="true"><i class="fas fa-flask"></i> Essais Proctor &amp; VBS</span>
                    <span class="ticker-chip ticker-dup" aria-hidden="true"><i class="fas fa-cube"></i> Surpac 3D</span>
                    <span class="ticker-chip ticker-dup" aria-hidden="true"><i class="fas fa-map-location-dot"></i> QGIS &amp; ArcGIS</span>
                    <span class="ticker-chip ticker-dup" aria-hidden="true"><i class="fas fa-building"></i> Autodesk Revit &amp; AutoCAD</span>
                    <span class="ticker-chip ticker-dup" aria-hidden="true"><i class="fas fa-chart-area"></i> Surfer &amp; Geosoft</span>
                    <span class="ticker-chip ticker-dup" aria-hidden="true"><i class="fas fa-code"></i> MATLAB &amp; Arduino</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="skills section-padding">
    <div class="container">
        <div class="section-header" data-reveal="fade-up">
            <span class="section-tag">Pôles de compétences</span>
            <h2 class="section-title">Expertise Technique &amp; Opérationnelle</h2>
            <p class="section-subtitle">
                Une maîtrise complète de la chaîne géotechnique et minière : de l'investigation in situ jusqu'à la modélisation numérique et au dimensionnement d'ouvrages.
            </p>
        </div>

        <div class="skills-grid">
            <!-- Carte 1 : Géotechnique -->
            <article class="skill-card" data-reveal="fade-up" data-delay="100">
                <div class="skill-card-header">
                    <div class="skill-icon">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <span class="skill-index">01</span>
                </div>
                <h3>Géotechnique &amp; Essais</h3>
                <p class="skill-desc">Réalisation et interprétation d'essais géotechniques en laboratoire et in situ pour la caractérisation des sols.</p>
                <ul class="skill-list">
                    <li><i class="fas fa-check"></i> Essais Proctor (Normal &amp; Modifié) et VBS (Valeur au Bleu)</li>
                    <li><i class="fas fa-check"></i> Teneur en eau naturelle et taux de matière organique</li>
                    <li><i class="fas fa-check"></i> Analyse granulométrique par tamisage et poids spécifique</li>
                    <li><i class="fas fa-check"></i> Sondages au Pénétromètre Dynamique Lourd (PDL)</li>
                </ul>
                <div class="skill-meter">
                    <div class="meter-info"><span>Maîtrise opérationnelle</span><span>95%</span></div>
                    <div class="meter-track"><div class="meter-fill" style="--target-width: 95%;"></div></div>
                </div>
            </article>

            <!-- Carte 2 : Béton et matériaux -->
            <article class="skill-card" data-reveal="fade-up" data-delay="200">
                <div class="skill-card-header">
                    <div class="skill-icon">
                        <i class="fas fa-trowel-bricks"></i>
                    </div>
                    <span class="skill-index">02</span>
                </div>
                <h3>Bétons &amp; Matériaux</h3>
                <p class="skill-desc">Formulation, suivi rhéologique et contrôle de résistance des matériaux de construction pour le génie civil.</p>
                <ul class="skill-list">
                    <li><i class="fas fa-check"></i> Formulation et contrôle qualité des bétons hydrauliques</li>
                    <li><i class="fas fa-check"></i> Formulation et valorisation de briques en matériaux locaux</li>
                    <li><i class="fas fa-check"></i> Calcul de ferraillage et exécution de dalles pleines</li>
                    <li><i class="fas fa-check"></i> Suivi de chantier et contrôle de conformité structurelle</li>
                </ul>
                <div class="skill-meter">
                    <div class="meter-info"><span>Contrôle &amp; Formulation</span><span>90%</span></div>
                    <div class="meter-track"><div class="meter-fill" style="--target-width: 90%;"></div></div>
                </div>
            </article>

            <!-- Carte 3 : Logiciels & Modélisation -->
            <article class="skill-card" data-reveal="fade-up" data-delay="300">
                <div class="skill-card-header">
                    <div class="skill-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <span class="skill-index">03</span>
                </div>
                <h3>Ingénierie, SIG &amp; DAO</h3>
                <p class="skill-desc">Maîtrise des logiciels de référence pour la planification minière, le BIM, la cartographie et le calcul scientifique.</p>
                <div class="software-groups">
                    <div class="software-group">
                        <span class="group-title">Ingénierie, Mine &amp; DAO</span>
                        <div class="tag-cloud">
                            <span class="tech-tag">Surpac</span>
                            <span class="tech-tag">Revit</span>
                            <span class="tech-tag">AutoCAD</span>
                            <span class="tech-tag">Surfer</span>
                        </div>
                    </div>
                    <div class="software-group">
                        <span class="group-title">Cartographie &amp; SIG</span>
                        <div class="tag-cloud">
                            <span class="tech-tag">QGIS</span>
                            <span class="tech-tag">ArcGIS</span>
                            <span class="tech-tag">Geosoft</span>
                        </div>
                    </div>
                    <div class="software-group">
                        <span class="group-title">Analyse, IoT &amp; Bureautique</span>
                        <div class="tag-cloud">
                            <span class="tech-tag">MATLAB</span>
                            <span class="tech-tag">Arduino</span>
                            <span class="tech-tag">Excel Avancé</span>
                            <span class="tech-tag">Illustrator / PS</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Carte 4 : Qualités professionnelles -->
            <article class="skill-card" data-reveal="fade-up" data-delay="400">
                <div class="skill-card-header">
                    <div class="skill-icon">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <span class="skill-index">04</span>
                </div>
                <h3>Atouts Professionnels</h3>
                <p class="skill-desc">Engagement terrain, esprit analytique et capacité à livrer des synthèses fiables pour l'aide à la décision.</p>
                <ul class="skill-list">
                    <li><i class="fas fa-check"></i> <strong>Rigueur scientifique :</strong> Respect strict des protocoles d'essais</li>
                    <li><i class="fas fa-check"></i> <strong>Esprit de synthèse :</strong> Rédaction de rapports géotechniques clairs</li>
                    <li><i class="fas fa-check"></i> <strong>Adaptabilité :</strong> Opérationnel sur chantiers isolés et en laboratoire</li>
                    <li><i class="fas fa-check"></i> <strong>Autonomie &amp; Équipe :</strong> Collaboration fluide avec bureaux d'études</li>
                </ul>
                <div class="skill-meter">
                    <div class="meter-info"><span>Fiabilité &amp; Leadership</span><span>98%</span></div>
                    <div class="meter-track"><div class="meter-fill" style="--target-width: 98%;"></div></div>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="featured-projects section-padding section-alt">
    <div class="container">
        <div class="section-header-flex" data-reveal="fade-up">
            <div>
                <span class="section-tag">Études de cas &amp; Projets</span>
                <h2 class="section-title">Réalisations Récentes</h2>
            </div>
            <a href="<?php echo SITE_URL; ?>/portfolio.php" class="btn btn-secondary">
                <span>Voir toutes mes réalisations</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="portfolio-grid">
            <?php foreach ($featuredProjects as $index => $project): 
                $imgUrl = getProjectImageUrl($project['image'] ?? '');
                $category = $project['category'] ?? 'Ingénierie & Terrain';
                $metrics = $project['metrics'] ?? 'Étude technique & rapport de synthèse';
            ?>
            <article class="portfolio-item" data-reveal="fade-up" data-delay="<?php echo ($index + 1) * 100; ?>">
                <div class="portfolio-image">
                    <span class="portfolio-badge"><?php echo htmlspecialchars($category); ?></span>
                    <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
                    <div class="portfolio-overlay">
                        <a href="<?php echo SITE_URL; ?>/portfolio.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Consulter l'étude
                        </a>
                    </div>
                </div>
                <div class="portfolio-info">
                    <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                    <div class="project-metric-bar">
                        <i class="fas fa-chart-line"></i>
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

<section class="cta section-padding">
    <div class="container">
        <div class="cta-box" data-reveal="zoom-in">
            <div class="cta-content">
                <span class="section-tag">Collaboration &amp; Recrutement</span>
                <h2>Besoin d'une expertise géotechnique ou minière sur votre projet ?</h2>
                <p>
                    Que ce soit pour une campagne d'essais de sol, le suivi qualité d'un chantier de génie civil ou la modélisation SIG d'un permis minier, discutons de vos besoins techniques.
                </p>
                <div class="cta-actions">
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Démarrer une discussion
                    </a>
                    <a href="<?php echo SITE_URL; ?>/about.php" class="btn btn-secondary">
                        <i class="fas fa-user-tie"></i> Consulter mon parcours
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
