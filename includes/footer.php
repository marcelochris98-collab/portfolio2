    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <a href="<?php echo SITE_URL; ?>/index.php" class="logo footer-logo">
                        <span class="logo-mark">
                            <i class="fas fa-layer-group"></i>
                        </span>
                        <span class="logo-text">
                            <strong><?php echo SITE_NAME; ?></strong>
                            <small><?php echo SITE_ROLE; ?></small>
                        </span>
                    </a>
                    <p class="footer-desc">
                        Ingénieur spécialisé en mécanique des sols, contrôle qualité des matériaux, modélisation de gisements et cartographie SIG pour les projets de génie civil et miniers au Cameroun et à l'international.
                    </p>
                    <div class="social-links">
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="mailto:<?php echo SITE_EMAIL; ?>" aria-label="Envoyer un email">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a href="tel:+237658136020" aria-label="Téléphone">
                            <i class="fas fa-phone"></i>
                        </a>
                        <a href="<?php echo SITE_URL; ?>/admin/login.php" aria-label="Espace Administration" title="Espace Admin">
                            <i class="fas fa-shield-halved"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-section">
                    <h3>Navigation</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo SITE_URL; ?>/index.php">Accueil</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/about.php">À Propos &amp; Parcours</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php">Expertises Techniques</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/portfolio.php">Projets &amp; Études</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact.php">Demander une étude</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Domaines d'intervention</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo SITE_URL; ?>/services.php">Essais Géotechniques (PDL, Proctor, VBS)</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php">Formulation &amp; Contrôle Bétons</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php">Cartographie SIG (QGIS / ArcGIS)</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php">Modélisation Minière (Surpac)</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php">Stabilité des Talus &amp; Fondations</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Coordonnées</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-location-dot"></i>
                            <span><?php echo SITE_LOCATION; ?></span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <a href="tel:+237658136020"><?php echo SITE_PHONE; ?></a>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <strong><?php echo SITE_NAME; ?></strong> — Ingénierie Géotechnique &amp; Exploitation Minière. Tous droits réservés.</p>
                <div class="footer-meta">
                    <span>Normes NF P94 • Géomécanique • SIG</span>
                </div>
            </div>
        </div>
    </footer>

    <button type="button" class="back-to-top" id="backToTop" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="<?php echo SITE_URL; ?>/js/main.js"></script>
</body>
</html>
