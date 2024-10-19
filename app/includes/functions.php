<?php

// Fonction pour afficher la page d'accueil
function renderHomePage() {
    echo "<h1>Bienvenue sur mon CV/Portfolio</h1>";
    echo "<p>Ce site vous permet de gérer vos informations de CV et de consulter des projets personnels.</p>";
}

// Fonction pour afficher la page de connexion
function renderLoginPage() {
    echo '<form action="authenticate.php" method="POST">';
    echo '<label for="email">Email:</label><input type="email" name="email" required>';
    echo '<label for="password">Mot de passe:</label><input type="password" name="password" required>';
    echo '<input type="submit" value="Se connecter">';
    echo '</form>';
}

// Fonction pour déconnecter un utilisateur
function logoutUser() {
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Fonction pour afficher la page de profil
function renderProfilePage($user_id) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
    $stmt->bindParam(1, $user_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo "<h2>Profil de l'utilisateur</h2>";
        echo "<p>Prénom: " . $row['first_name'] . "</p>";
        echo "<p>Nom: " . $row['last_name'] . "</p>";
        echo "<p>Email: " . $row['email'] . "</p>";
    }

    $stmt->close();
    $conn->close();
}

// Fonction pour afficher la page CV
function renderCVPage($user_id) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT title, description, skills, experiences_external, education_external FROM cvs WHERE user_id = ?");
    $stmt->bindParam(1, $user_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo "<h2>Mon CV</h2>";
        echo "<p>Titre: " . $row['title'] . "</p>";
        echo "<p>Description: " . $row['description'] . "</p>";
        echo "<p>Compétences: " . json_encode($row['skills']) . "</p>";
        echo "<p>Expériences: " . str_replace('||', '<br>', $row['experiences_external']) . "</p>";
        echo "<p>Éducation: " . str_replace('||', '<br>', $row['education_external']) . "</p>";
    }

    $stmt->close();
    $conn->close();
}

// Fonction pour afficher la page des projets
function renderProjectsPage($user_id) {
  $conn = connectToDatabase();
  $stmt = $conn->prepare("SELECT title, description, image FROM projects WHERE user_id = ?");
  $stmt->bindParam(1, $user_id, SQLITE3_INTEGER);
  $result = $stmt->execute();

  echo "<h2>Mes Projets</h2>";
  while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo "<div class='project'>";
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>" . $row['description'] . "</p>";
    echo "<img src='" . $row['image'] . "' alt='Image du projet'>";
    echo "</div>";
  }

  $stmt->close();
  $conn->close();
}
?>