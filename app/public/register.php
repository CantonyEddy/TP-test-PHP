<?php
include '../includes/database.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $conn = connectToDatabase();
  $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
  $stmt->bindParam(1, $first_name, SQLITE3_TEXT);
  $stmt->bindParam(2, $last_name, SQLITE3_TEXT);
  $stmt->bindParam(3, $email, SQLITE3_TEXT);
  $stmt->bindParam(4, $password, SQLITE3_TEXT);

  if ($stmt->execute()) {
    echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
  } else {
    echo "Erreur lors de l'inscription. Veuillez réessayer.";
  }

  $stmt->close();
  $conn->close();
}
?>

<form method="POST" action="">
    <label for="first_name">Prénom:</label>
    <input type="text" name="first_name" required>
    <label for="last_name">Nom:</label>
    <input type="text" name="last_name" required>
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" required>
    <input type="submit" value="S'inscrire">
</form>