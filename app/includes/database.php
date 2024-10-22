<?php
function connectToDatabase() {
    $dbname = __DIR__ . '/../database/portfolio_db.sqlite';
    $conn = new SQLite3($dbname);

    if (!$conn) {
        die("Connection failed: " . $conn->lastErrorMsg());
    }

    return $conn;
}
?>