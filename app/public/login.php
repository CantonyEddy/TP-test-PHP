<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CV/Portfolio</title>

    <!-- Lien vers Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Lien vers ton fichier CSS personnalisé -->
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">CV/Portfolio</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="login.php">Connexion <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Inscription</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Connexion</h2>
            <?php
            include __DIR__ . '/includes/database.php';
            include __DIR__ . '/includes/functions.php';

            renderLoginPage();
            echo '<p class="mt-3 text-center">Pas encore inscrit ? <a href="register.php">Créez un compte ici</a></p>';
            ?>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">&copy; 2024 CV/Portfolio. Tous droits réservés.</span>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>