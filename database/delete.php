<?php
session_start();

include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID = $_POST['ID'];
    $sql = "DELETE FROM musics WHERE ID = '$ID'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['status'] = "deleted";
    } else {
        $_SESSION['status'] = "error";
    }
}

$conn->close();
header("Location: ../index.php");
exit();
?>