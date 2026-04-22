<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];
    $conf  = $_POST['confirm_password'];

    if (empty($email) || empty($pass) || empty($conf)) {
        header("Location: signup.php?error=Please+fill+in+all+fields");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?error=Invalid+email+format");
        exit;
    }

    if (strlen($pass) < 8) {
        header("Location: signup.php?error=Password+must+be+at+least+8+characters");
        exit;
    }

    if ($pass !== $conf) {
        header("Location: signup.php?error=Passwords+do+not+match");
        exit;
    }

    $hash = password_hash($pass, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $hash]);
        $_SESSION['user_id']    = $pdo->lastInsertId();
        $_SESSION['user_email'] = $email;
        header("Location: http://localhost/app_dev/nexus/dashboard.php");
        exit;
    } catch (PDOException $e) {
        header("Location: signup.php?error=Email+already+exists");
        exit;
    }
} else {
    header("Location: signup.php");
    exit;
}
?>