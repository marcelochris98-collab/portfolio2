<?php 
require_once 'includes/header.php';
 ?>
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Bonjour, je suis   Ariel Wamba<span class="highlight"> ingenieur en géotechnique</span></h1>
            <p class="hero-subtitle">motivé par l'innovation et le developpement durable, je suis pret à contribuer aux projets miniers au Cameroun et à l'international</p>
            <div class="hero-buttons">
                <a href="<?php echo SITE_URL; ?>/portfolio.php" class="btn btn-primary">Voir mon travail</a>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-secondary">Me contacter</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="img/wam.jpg" alt="Profile">
        </div>
    </div>
</section>

<section class="skills">
    <div class="container">
        <h2 class="section-title">Mes Compétences</h2>
        <div class="skills-grid">
            <div class="skill-card">
                <i class="fas fa-mountain"></i>
                <h3>géotechnique</h3>
                <p><strong>réalisation d'essais en laboratoire et in situ</strong> <ul>
                    <li>VBS,protor</li>
                    <li>teneur en eau ,matière organique</li>
                    <li>analyse granulométrique,poids spécifique</li>
                    <li>Pénétromètre dynamique lourd</li>
                </ul></p>
            </div>
            <div class="skill-card">
                <i class="fas fa-toolbox"></i>
                <h3>béton et matériaux</h3>
                <p><strong>béton et matériaux</strong>
                <ul>
                    <li>Formulation et controle qualité bétons</li>
                    <li>Formulation de briques locales</li>
                </ul>
            </p>
            </div>
            <div class="skill-card">
                <i class="fas fa-desktop"></i>
                <h3>Familarité avec les logiciels</h3>
                <p><strong>logiciels</strong>
                <ul>
                    <li><strong>ingénerie & DAO</strong></li>
                    <OL>
                        Revit,
                        surfer
                    </OL>
                </ul>
                 <ul>
                    <li><strong>Cartographie & SIG</strong></li>
                    <OL>
                        QGIS,
                        ArcGIS
                    </OL>
                </ul>
                <ul>
                    <li><strong>Analyse & programmation</strong></li>
                    <OL>
                        MATLAB,
                        Arduino
                    </OL>
                </ul>
                <ul>
                    <li><strong>bureautque & graphisme</strong></li>
                    <OL>
                        Ms word, MS Excel,Adobe photoshop,illustrator
                        ArcGIS
                    </OL>
                </ul>
            </p>
            </div>
            <div class="skill-card">
                <i class="fas fa-award"></i>
               <h3>Qualités personnelles</h3>
                <p> <ul>
                    <li>Adaptabilité</li>
                    <li>curiosité</li>
                    <li>autonomie,esprit d'equipe et de synthèse</li>
                    <li>rigueur</li>
                </ul></p>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Prêt à démarrer votre projet ?</h2>
        <p>Collaborons pour créer quelque chose d'exceptionnel</p>
        <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary">Commencer maintenant</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
