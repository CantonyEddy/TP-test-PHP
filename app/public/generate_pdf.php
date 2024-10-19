<?php
require_once __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/includes/database.php';

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = connectToDatabase();

$stmt = $conn->prepare("SELECT title, description, skills, experiences_external, education_external FROM cvs WHERE user_id = ?");
$stmt->bindParam(1, $user_id, SQLITE3_INTEGER);
$result = $stmt->execute();

if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $title = $row['title'];
    $description = $row['description'];
    $skills = $row['skills'];
    $experiences = $row['experiences_external'];
    $education = $row['education_external'];

    // Création du HTML pour le PDF
    $html = "
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
        p {
            line-height: 1.6;
        }
        .section {
            margin-bottom: 20px;
        }
    </style>
    <h1>$title</h1>
    <div class='section'>
        <h2>Description</h2>
        <p>$description</p>
    </div>
    <div class='section'>
        <h2>Compétences</h2>
        <p>$skills</p>
    </div>
    <div class='section'>
        <h2>Expériences Professionnelles</h2>
        <p>$experiences</p>
    </div>
    <div class='section'>
        <h2>Éducation</h2>
        <p>$education</p>
    </div>
    ";

    // Configuration de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    
    // Génération du fichier PDF
    $dompdf->render();
    $dompdf->stream("cv_$user_id.pdf", ["Attachment" => true]);

    //Fermer les Connexions
    $stmt->close();
    $conn->close();
}
?>