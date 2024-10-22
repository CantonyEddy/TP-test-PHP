<?php
session_start(); // session_start() doit être appelé en premier

include __DIR__ . '/../includes/database.php';
include __DIR__ . '/../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = connectToDatabase();

// Récupérer tous les projets pour les afficher
$stmt = $conn->prepare("SELECT * FROM projects WHERE user_id = ?");
$stmt->bindParam(1, $user_id, SQLITE3_INTEGER);
$result = $stmt->execute();

echo "<h2>Mes Projets</h2>";
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo "<form method='POST' action='edit_projects.php' class='mb-3'>";
    echo "<input type='hidden' name='project_id' value='" . $row['id'] . "'>";
    echo "<div class='form-group'>";
    echo "<label for='title'>Titre:</label>";
    echo "<input type='text' name='title' class='form-control' value='" . htmlspecialchars($row['title']) . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='description'>Description:</label>";
    echo "<textarea name='description' class='form-control' required>" . htmlspecialchars($row['description']) . "</textarea>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='image'>Image (URL):</label>";
    echo "<input type='text' name='image' class='form-control' value='" . htmlspecialchars($row['image']) . "' required>";
    echo "</div>";
    echo "<input type='submit' name='update_project' class='btn btn-primary' value='Mettre à jour le Projet'>";
    echo "</form>";

    // Bouton pour supprimer un projet
    echo "<form method='POST' action='edit_projects.php' class='mb-3'>";
    echo "<input type='hidden' name='project_id' value='" . $row['id'] . "'>";
    echo "<input type='submit' name='delete_project' class='btn btn-danger' value='Supprimer le Projet'>";
    echo "</form>";

    // Bouton pour marquer le projet comme favori ou retirer des favoris
    echo "<form method='POST' action='edit_projects.php' class='mb-3'>";
    echo "<input type='hidden' name='project_id' value='" . $row['id'] . "'>";
    if ($row['is_favorite']) {
        echo "<input type='submit' name='toggle_favorite' class='btn btn-warning' value='Retirer des Favoris'>";
    } else {
        echo "<input type='submit' name='toggle_favorite' class='btn btn-success' value='Ajouter aux Favoris'>";
    }
    echo "</form>";
}

// Traitement des actions de mise à jour, suppression et favoris
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_project']) && isset($_POST['project_id'])) {
        // Mise à jour du projet
        $project_id = $_POST['project_id'];
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['description']));
        $image = htmlspecialchars(trim($_POST['image']));

        $stmt = $conn->prepare("UPDATE projects SET title = ?, description = ?, image = ? WHERE id = ? AND user_id = ?");
        $stmt->bindParam(1, $title, SQLITE3_TEXT);
        $stmt->bindParam(2, $description, SQLITE3_TEXT);
        $stmt->bindParam(3, $image, SQLITE3_TEXT);
        $stmt->bindParam(4, $project_id, SQLITE3_INTEGER);
        $stmt->bindParam(5, $user_id, SQLITE3_INTEGER);
        $stmt->execute();
    } elseif (isset($_POST['delete_project']) && isset($_POST['project_id'])) {
        // Suppression du projet
        $project_id = $_POST['project_id'];

        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
        $stmt->bindParam(1, $project_id, SQLITE3_INTEGER);
        $stmt->bindParam(2, $user_id, SQLITE3_INTEGER);
        $stmt->execute();
    } elseif (isset($_POST['toggle_favorite']) && isset($_POST['project_id'])) {
        // Changer le statut de favori du projet
        $project_id = $_POST['project_id'];

        $stmt = $conn->prepare("SELECT is_favorite FROM projects WHERE id = ? AND user_id = ?");
        $stmt->bindParam(1, $project_id, SQLITE3_INTEGER);
        $stmt->bindParam(2, $user_id, SQLITE3_INTEGER);
        $result = $stmt->execute();

        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $new_status = $row['is_favorite'] ? 0 : 1;

            $stmt = $conn->prepare("UPDATE projects SET is_favorite = ? WHERE id = ? AND user_id = ?");
            $stmt->bindParam(1, $new_status, SQLITE3_INTEGER);
            $stmt->bindParam(2, $project_id, SQLITE3_INTEGER);
            $stmt->bindParam(3, $user_id, SQLITE3_INTEGER);
            $stmt->execute();
        }
    }

    // Rediriger pour éviter les doubles soumissions de formulaires
    header("Location: edit_projects.php");
    exit();
}

$stmt->close();
$conn->close();
?>