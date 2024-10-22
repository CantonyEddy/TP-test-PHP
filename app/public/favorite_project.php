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

    // Vérifier si le projet est déjà favori
    $stmt = $conn->prepare("SELECT is_favorite FROM projects WHERE id = ? AND user_id = ?");
    $stmt->bindParam(1, $project_id, SQLITE3_INTEGER);
    $stmt->bindParam(2, $user_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $new_status = $row['is_favorite'] ? 0 : 1;

        // Mettre à jour le statut du favori
        $stmt = $conn->prepare("UPDATE projects SET is_favorite = ? WHERE id = ? AND user_id = ?");
        $stmt->bindParam(1, $new_status, SQLITE3_INTEGER);
        $stmt->bindParam(2, $project_id, SQLITE3_INTEGER);
        $stmt->bindParam(3, $user_id, SQLITE3_INTEGER);
        $stmt->execute();
    }

    header("Location: edit_projects.php");
    exit();
}
?>