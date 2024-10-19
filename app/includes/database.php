<?php
function connectToDatabase() {
    $dbname = "../database/portfolio_db.sqlite";

    $conn = new SQLite3($dbname);

    if (!$conn) {
        die("Connection failed: " . $conn->lastErrorMsg());
    }

    return $conn;
}
?>