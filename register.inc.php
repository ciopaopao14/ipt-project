<?php
include("database/database.php");
$db = new mysqli($servername, $username, $password, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];

    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        header("Location: register.php?error=emptyinput");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: register.php?error=invalidemail");
        exit();
    }

    if ($password !== $passwordRepeat) {
        header("Location: register.php?error=passwordsdontmatch");
        exit();
    }

    // Check if username is taken
    $stmt = $db->prepare("SELECT username FROM User_Profile WHERE username = ?");
    if ($stmt === false) {
        header("Location: register.php?error=stmtfailed");
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("Location: register.php?error=usernametaken");
        exit();
    }
    $stmt->close();

    // Use prepared statements to prevent SQL injection
    $stmt = $db->prepare("INSERT INTO User_Profile (username, email, UserPassword) VALUES (?, ?, ?)");
    if ($stmt === false) {
        header("Location: register.php?error=stmtfailed");
        exit();
    }
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php?signup=success");
    exit();
} else {
    header("Location: register.php");
    exit();
}
?>
