<?php
$dbname = "../database/portfolio_db.sqlite";

if (!file_exists($dbname)) {
    $conn = new SQLite3($dbname);

    $createUsersTable = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        first_name TEXT NOT NULL,
        last_name TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL
    );";

    $createCVsTable = "CREATE TABLE IF NOT EXISTS cvs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        title TEXT,
        description TEXT,
        skills TEXT,
        experiences_external TEXT,
        education_external TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );";

    $createProjectsTable = "CREATE TABLE IF NOT EXISTS projects (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        title TEXT,
        description TEXT,
        image TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );";

    $conn->exec($createUsersTable);
    $conn->exec($createCVsTable);
    $conn->exec($createProjectsTable);

    echo "Base de données initialisée avec succès.";
} else {
    echo "La base de données existe déjà.";
}
?>