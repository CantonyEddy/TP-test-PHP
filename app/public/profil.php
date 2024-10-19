<?php
session_start();

include __DIR__ . '/includes/database.php';
include __DIR__ . '/includes/functions.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = connectToDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $skills = htmlspecialchars(trim($_POST['skills']));
    $experiences = array_map('htmlspecialchars', $_POST['experiences']);
    $education = array_map('htmlspecialchars', $_POST['education']);

    // Vérification des limites de caractères
    if (strlen($title) > 100 || strlen($description) > 500) {
        echo '<div class="notification error">Erreur : titre ou description trop long.</div>';
        exit();
    }

    // Transformation en chaîne pour la base de données
    $experiences_str = implode('||', $experiences);
    $education_str = implode('||', $education);

    $stmt = $conn->prepare("INSERT OR REPLACE INTO cvs (user_id, title, description, skills, experiences_external, education_external) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $user_id, SQLITE3_INTEGER);
    $stmt->bindParam(2, $title, SQLITE3_TEXT);
    $stmt->bindParam(3, $description, SQLITE3_TEXT);
    $stmt->bindParam(4, $skills, SQLITE3_TEXT);
    $stmt->bindParam(5, $experiences_str, SQLITE3_TEXT);
    $stmt->bindParam(6, $education_str, SQLITE3_TEXT);
    
    if ($stmt->execute()) {
        echo '<div class="notification success">CV mis à jour avec succès.</div>';
    } else {
        echo '<div class="notification error">Erreur lors de la mise à jour du CV. Veuillez réessayer.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - CV/Portfolio</title>

    <!-- Lien vers Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Lien vers ton fichier CSS personnalisé -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="container mt-5">
    <?php renderProfilePage($user_id); ?>

    <form method="POST" action="" class="container mt-5">
        <div class="form-group">
            <label for="title">Titre:</label>
            <input type="text" name="title" class="form-control" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required maxlength="500"></textarea>
        </div>

        <div class="form-group">
            <label for="skills">Compétences (séparées par des virgules):</label>
            <textarea name="skills" class="form-control" required></textarea>
        </div>

        <!-- Section pour les Expériences Professionnelles -->
        <div id="experiences-section" class="form-group">
            <h3>Expériences Professionnelles</h3>
            <div class="experience-item mb-3">
                <label for="experiences[]">Expérience :</label>
                <textarea name="experiences[]" class="form-control mb-2" required></textarea>
                <button type="button" class="btn btn-danger" onclick="removeExperience(this)">Supprimer</button>
            </div>
            <button type="button" class="btn btn-success" onclick="addExperience()">Ajouter une Expérience</button>
        </div>

        <!-- Section pour l'Éducation -->
        <div id="education-section" class="form-group">
            <h3>Éducation</h3>
            <div class="education-item mb-3">
                <label for="education[]">Formation :</label>
                <textarea name="education[]" class="form-control mb-2" required></textarea>
                <button type="button" class="btn btn-danger" onclick="removeEducation(this)">Supprimer</button>
            </div>
            <button type="button" class="btn btn-success" onclick="addEducation()">Ajouter une Formation</button>
        </div>

        <input type="submit" class="btn btn-primary" value="Mettre à jour le CV">
    </form>

    <a href="generate_pdf.php" class="btn btn-info mt-3">Télécharger le CV en PDF</a>

    <script>
        function addExperience() {
            const experiencesSection = document.getElementById("experiences-section");
            const newExperience = document.createElement("div");
            newExperience.className = "experience-item mb-3";
            newExperience.innerHTML = `
                <label for="experiences[]">Expérience :</label>
                <textarea name="experiences[]" class="form-control mb-2" required></textarea>
                <button type="button" class="btn btn-danger" onclick="removeExperience(this)">Supprimer</button>
            `;
            experiencesSection.appendChild(newExperience);
        }

        function removeExperience(button) {
            button.parentElement.remove();
        }

        function addEducation() {
            const educationSection = document.getElementById("education-section");
            const newEducation = document.createElement("div");
            newEducation.className = "education-item mb-3";
            newEducation.innerHTML = `
                <label for="education[]">Formation :</label>
                <textarea name="education[]" class="form-control mb-2" required></textarea>
                <button type="button" class="btn btn-danger" onclick="removeEducation(this)">Supprimer</button>
            `;
            educationSection.appendChild(newEducation);
        }

        function removeEducation(button) {
            button.parentElement.remove();
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>