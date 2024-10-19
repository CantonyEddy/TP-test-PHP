<?php
include __DIR__ . '/includes/database.php';
include __DIR__ . '/includes/functions.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = connectToDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("INSERT INTO projects (user_id, title, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bindParam(1, $user_id, SQLITE3_INTEGER);
    $stmt->bindParam(2, $title, SQLITE3_TEXT);
    $stmt->bindParam(3, $description, SQLITE3_TEXT);
    $stmt->bindParam(4, $image, SQLITE3_TEXT);
    $stmt->execute();

    echo "Projet ajouté avec succès.";
}

renderProjectsPage($user_id);
?>

<form method="POST" action="">
    <label for="title">Titre du projet:</label>
    <input type="text" name="title" required>
    <label for="description">Description:</label>
    <textarea name="description" required></textarea>
    <label for="image">Lien de l'image:</label>
    <input type="text" name="image" required>
    <input type="submit" value="Ajouter un Projet">
</form>
