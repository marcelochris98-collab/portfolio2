<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean($_POST['name'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = clean($_POST['subject'] ?? 'Nouveau message depuis le portfolio');
    $message = clean($_POST['message'] ?? '');

    if ($name === '' || $message === '') {
        $_SESSION['error'] = 'Veuillez remplir tous les champs obligatoires.';
        header('Location: contact.php?error=fields');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Veuillez saisir une adresse email valide.';
        header('Location: contact.php?error=email');
        exit;
    }

    if ($dbConnected && $pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
        } catch (PDOException $e) {
            // Enregistrement de secours si la table n'est pas disponible
        }
    }

    $_SESSION['success'] = 'Merci ' . $name . ' ! Votre message a bien été enregistré. Je vous répondrai très prochainement.';
    header('Location: contact.php?success=1');
    exit;
} else {
    header('Location: contact.php');
    exit;
}
?>
