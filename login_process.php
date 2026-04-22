<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    if (empty($email) || empty($pass)) {
        header("Location: login.php?error=Please+fill+in+all+fields");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: http://localhost/app_dev/nexus/dashboard.php");
        exit;
    } else {
        header("Location: login.php?error=Invalid+email+or+password");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>
