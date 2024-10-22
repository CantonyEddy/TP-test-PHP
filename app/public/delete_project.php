<?php
include __DIR__ . '/../includes/database.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['project_id'])) {
    $user_id = $_SESSION['user_id'];
    $project_id = $_POST['project_id'];

    $conn = connectToDatabase();

    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
    $stmt->bindParam(1, $project_id, SQLITE3_INTEGER);
    $stmt->bindParam(2, $user_id, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Projet supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression du projet.</div>";
    }

    header("Location: edit_projects.php");
    exit();
}
?>