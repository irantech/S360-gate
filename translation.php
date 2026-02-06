<?php
// Load the PHP translations array
$translations = include 'config/langs/fa.php';

// Output the translations as JSON
header('Content-Type: application/json');
echo json_encode($translations, JSON_UNESCAPED_UNICODE);