<?php
// Vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Rediriger si non connecté
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Nettoyer les données
function clean($data) {
    return htmlspecialchars(strip_tags(trim((string)$data)), ENT_QUOTES, 'UTF-8');
}

// Générer un token CSRF
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Vérifier le token CSRF
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

// Résoudre l'URL d'une image de projet avec fallback intelligent
function getProjectImageUrl($imageName) {
    $cleanName = basename((string)$imageName);
    $rootDir = dirname(__DIR__);
    
    if ($cleanName !== '') {
        if (file_exists($rootDir . '/img/projects/' . $cleanName)) {
            return SITE_URL . '/img/projects/' . $cleanName;
        }
        if (file_exists($rootDir . '/images/projects/' . $cleanName)) {
            return SITE_URL . '/images/projects/' . $cleanName;
        }
    }
    return SITE_URL . '/img/projects/geo-foundation.svg';
}

// Upload d'image
function uploadImage($file, $targetDir = '../img/projects/') {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    if (!isset($file['type']) || !in_array($file['type'], $allowedTypes)) {
        return ['success' => false, 'message' => 'Type de fichier non autorisé (JPG, PNG, WEBP, SVG uniquement)'];
    }
    
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'message' => 'Fichier trop volumineux (max 5MB)'];
    }
    
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0775, true);
    }
    
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = 'proj_' . uniqid() . '_' . time() . '.' . $extension;
    $targetPath = rtrim($targetDir, '/') . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'filename' => $filename];
    }
    
    return ['success' => false, 'message' => 'Erreur lors de l\'upload du fichier'];
}
?>
