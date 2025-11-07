<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    
    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: contact.php?error=email');
        exit;
    }
    
    try {
        // Insérer dans la base de données
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);
        
        // Redirection avec message de succès
        header('Location: contact.php?success=1');
        exit;
        
    } catch(PDOException $e) {
        // En production, ne pas afficher l'erreur
        die("Une erreur est survenue. Veuillez réessayer.");
        // En développement :
        // die("Erreur : " . $e->getMessage());
    }
} else {
    header('Location: contact.php');
    exit;
}
?>