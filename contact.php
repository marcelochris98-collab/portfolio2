<?php
include 'includes/header.php';

$prefillSubject = isset($_GET['subject']) ? clean($_GET['subject']) : '';

$successMessage = '';
if (!empty($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']);
} elseif (isset($_GET['success']) && $_GET['success'] == '1') {
    $successMessage = 'Votre message a bien été transmis. Je vous répondrai dans les plus brefs délais.';
}

$errorMessage = '';
if (!empty($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
} elseif (isset($_GET['error'])) {
    if ($_GET['error'] === 'email') {
        $errorMessage = 'Veuillez saisir une adresse email valide.';
    } elseif ($_GET['error'] === 'fields') {
        $errorMessage = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        $errorMessage = 'Une erreur est survenue lors de l\'envoi du message.';
    }
}
?>

<section class="page-header">
    <div class="container" data-reveal="fade-up">
        <span class="section-tag">Échange &amp; Devis</span>
        <h1>Contactez-moi</h1>
        <p>Vous avez un projet d'étude géotechnique, de contrôle qualité béton ou de prospection minière ? Échangeons sur vos besoins.</p>
    </div>
</section>

<section class="contact section-padding">
    <div class="container">
        <?php if ($successMessage): ?>
            <div class="alert alert-success" role="alert" data-reveal="fade-up">
                <i class="fas fa-circle-check"></i>
                <span><?php echo htmlspecialchars($successMessage); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-error" role="alert" data-reveal="fade-up">
                <i class="fas fa-triangle-exclamation"></i>
                <span><?php echo htmlspecialchars($errorMessage); ?></span>
            </div>
        <?php endif; ?>

        <div class="contact-wrapper">
            <div class="contact-info" data-reveal="fade-right">
                <span class="section-tag">Coordonnées Directes</span>
                <h2>Informations de Contact</h2>
                <p class="contact-intro">
                    Disponible pour des missions d'ingénierie géotechnique, des campagnes d'essais en laboratoire ou in situ, ainsi que des opportunités au Cameroun et à l'international.
                </p>

                <div class="info-list">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h3>Email Professionnel</h3>
                            <a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h3>Téléphone &amp; WhatsApp</h3>
                            <a href="tel:+237658136020"><?php echo SITE_PHONE; ?></a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div>
                            <h3>Localisation</h3>
                            <p><?php echo SITE_LOCATION; ?> (Mobilité nationale &amp; internationale)</p>
                        </div>
                    </div>
                </div>

                <div class="availability-card">
                    <div class="availability-header">
                        <span class="status-dot"></span>
                        <strong>Disponibilité Immédiate</strong>
                    </div>
                    <p>Réponse sous 24h pour toute demande d'étude géotechnique, de modélisation SIG ou d'entretien technique.</p>
                </div>
            </div>

            <form class="contact-form" action="process-contact.php" method="POST" data-reveal="fade-left">
                <h3>Envoyer un Message</h3>
                <p class="form-subtitle">Les champs marqués d'un astérisque (*) sont obligatoires.</p>
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="contactName">Nom complet / Entreprise *</label>
                        <input type="text" id="contactName" name="name" placeholder="Ex. Jean Ndiaye / Bureau d'Études" required>
                    </div>
                    <div class="form-group">
                        <label for="contactEmail">Adresse email *</label>
                        <input type="email" id="contactEmail" name="email" placeholder="votre.email@domaine.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="contactSubject">Objet de la demande *</label>
                    <input type="text" id="contactSubject" name="subject" value="<?php echo htmlspecialchars($prefillSubject); ?>" placeholder="Ex. Étude géotechnique de fondation / Recrutement" required>
                </div>

                <div class="form-group">
                    <label for="contactMessage">Détails de votre projet ou message *</label>
                    <textarea id="contactMessage" name="message" rows="6" placeholder="Décrivez brièvement la nature de votre ouvrage, la localisation du site ou l'objet de votre prise de contact..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <span>Envoyer le message</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
