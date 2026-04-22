<?php
session_start();
require 'db.php';

// ── REGISTER ──
if (isset($_POST['register'])) {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];
    $conf  = $_POST['confirm_password'];

    if ($pass !== $conf) {
        die("Passwords do not match.");
    }

    $hash = password_hash($pass, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $hash]);
        $_SESSION['user_id']    = $pdo->lastInsertId();
        $_SESSION['user_email'] = $email;
        header("Location: /app_dev/nexus/dashboard.php");
        exit;
    } catch (PDOException $e) {
        die("Email already exists.");
    }
}

// ── LOGIN ──
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: /app_dev/nexus/dashboard.php");
        exit;
    } else {
        die("Invalid email or password.");
    }
}
?>
