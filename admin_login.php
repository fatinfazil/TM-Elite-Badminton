<?php
session_start();

$error = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === '123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>TM Elite | Admin Login</title>
<link rel="stylesheet" href="style.css?v=10">

<style>
/* ✅ IMPORTANT FIX */
* {
    box-sizing: border-box;
}

/* ===== PAGE ===== */
body {
    background: #f4f6f8;
    font-family: 'Segoe UI', Tahoma, sans-serif;
    margin: 0;
}

/* ===== LOGIN WRAPPER ===== */
.login-container {
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ===== CARD ===== */
.login-card {
    width: 100%;
    max-width: 420px;
    background: white;
    padding: 36px;
    border-radius: 18px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
}

/* ===== TITLE ===== */
.login-card h2 {
    text-align: center;
    margin-bottom: 24px;
    color: #1e3a8a;
}

/* ===== FORM ===== */
.login-card form {
    width: 100%;
}

/* ===== INPUT ===== */
.login-card input {
    width: 100%;
    padding: 12px;
    margin-bottom: 16px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 14px;
}

.login-card input:focus {
    border-color: #f97316;
    outline: none;
    box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.25);
}

/* ===== BUTTON ===== */
.login-btn {
    width: 100%;
    padding: 12px;
    background: #2563eb;
    color: white;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.login-btn:hover {
    background: #1d4ed8;
}

.login-btn:active {
    background: #f97316;
    transform: scale(0.97);
}

/* ===== ERROR ===== */
.error {
    background: #fee2e2;
    color: #b91c1c;
    padding: 10px;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 16px;
    font-size: 14px;
}

/* ===== NAV ACTIVE ===== */
nav a.admin-button.active {
    background: #f97316;
    color: white;
    border-radius: 8px;
    padding: 8px 14px;
}
</style>
</head>

<body>

<header>
    <div class="header-inner">
        <h1>TM Elite Badminton Centre</h1>
        <nav>
            <a href="home.php">Home</a>
            <a href="availability.php">Book Court</a>
            <a href="about.php">About</a>
            <a href="admin.php" class="admin-button active">Admin</a>
        </nav>
    </div>
</header>

<div class="login-container">
    <div class="login-card">

        <h2>Admin Login</h2>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>

    </div>
</div>

</body>
</html>
