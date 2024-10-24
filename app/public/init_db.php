<?php
include __DIR__ . '/includes/database.php';

$conn = connectToDatabase();

// Vérifier si la colonne 'is_favorite' existe déjà, sinon l'ajouter
$query = "PRAGMA table_info(projects)";
$columns = $conn->query($query);

$column_exists = false;
while ($column = $columns->fetchArray(SQLITE3_ASSOC)) {
    if ($column['name'] === 'is_favorite') {
        $column_exists = true;
        break;
    }
}

if (!$column_exists) {
    $alter_query = "ALTER TABLE projects ADD COLUMN is_favorite INTEGER DEFAULT 0";
    $conn->exec($alter_query);
    echo "Colonne 'is_favorite' ajoutée à la table 'projects'.\n";
}

$conn->close();

try {
    // Création de la table "users"
    $query = "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        first_name TEXT NOT NULL,
        last_name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )";
    $conn->exec($query);

    // Création de la table "cvs"
    $query = "
    CREATE TABLE IF NOT EXISTS cvs (
        user_id INTEGER PRIMARY KEY,
        title TEXT,
        description TEXT,
        skills TEXT,
        experiences_external TEXT,
        education_external TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $conn->exec($query);

    // Création de la table "projects"
    $query = "
    CREATE TABLE IF NOT EXISTS projects (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        title TEXT,
        description TEXT,
        image TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $conn->exec($query);

    echo "Base de données et tables créées avec succès.";
} catch (Exception $e) {
    echo "Erreur lors de la création de la base de données : " . $e->getMessage();
}
?>