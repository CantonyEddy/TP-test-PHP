<?php
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/../data/cv_portfolio.sqlite');
    // Configurer le mode d'erreurs de PDO pour les exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>