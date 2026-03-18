<?php
// db.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost'; // Usually localhost on Hostinger
$user = 'u368218113_zainfolio';
$pass = '=oAQ9KTI7Z';
$dbname = 'u368218113_zainfolio';
$port = 3306; // Standard MySQL port for Hostinger

// Initial connection to create database if it doesn't exist (used mostly by setup)
try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Select the database (setup.php will create it before this happens)
    $pdo->query("USE `$dbname`");
}
catch (PDOException $e) {
    if (basename($_SERVER['PHP_SELF']) !== 'setup.php') {
        die("<div style='font-family: sans-serif; padding: 2rem; max-width: 600px; margin: 50px auto; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px;'>
                <h2 style='color: #dc2626; margin-top: 0;'>Database Not Configured</h2>
                <p style='color: #450a0a;'>The database <b>{$dbname}</b> does not exist or MySQL could not connect on port {$port}.</p>
                <a href='setup.php' style='display: inline-block; background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 15px; font-weight: bold;'>Run Automatic Setup Now</a>
                <p style='margin-top: 15px; color: #7f1d1d; font-size: 0.8rem;'>Error trace: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>
             </div>");
    }
}

// Helper to fetch all settings as an associative array
function getSettings($pdo)
{
    try {
        $stmt = $pdo->query("SELECT key_name, key_value FROM settings");
        if (!$stmt)
            return [];
        $settings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['key_name']] = $row['key_value'];
        }
        return $settings;
    }
    catch (PDOException $ex) {
        return []; // Suppress errors if table doesn't exist yet before setup
    }
}

// Optional helper for sanitized output
function e($string)
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
?>