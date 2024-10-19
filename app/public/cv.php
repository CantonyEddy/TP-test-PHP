<?php
include __DIR__ . '/includes/database.php';
include __DIR__ . '/includes/functions.php';

session_start();
if (isset($_SESSION['user_id'])) {
    renderCVPage($_SESSION['user_id']);
} else {
    header("Location: login.php");
    exit();
}
?>