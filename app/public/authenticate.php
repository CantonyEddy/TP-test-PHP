<?php
include '../includes/database.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $conn = connectToDatabase();
  $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
  $stmt->bindParam(1, $email, SQLITE3_TEXT);
  $result = $stmt->execute();

  if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    if (password_verify($password, $row['password'])) {
      session_start();
      $_SESSION['user_id'] = $row['id'];
      header("Location: profil.php");
      exit();
    } else {
      echo "Mot de passe incorrect.";
    }
  } else {
    echo "Aucun utilisateur trouvé avec cet email.";
  }

  $stmt->close();
  $conn->close();
}
?>