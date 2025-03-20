<?php
session_start();
include("database/database.php");
$db = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=emptyinput");
        exit();
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $db->prepare("SELECT * FROM User_Profile WHERE username = ? AND UserPassword = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($db->error));
    }
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?error=wronglogin");
        exit();
    }
    $stmt->close();
} else {
    header("Location: login.php");
    exit();
}
?>
