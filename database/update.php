<?php
session_start();
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ID = $_POST['ID'];
    $SONG_TITLE = $_POST['SONG_TITLE'];
    $ARTIST = $_POST['ARTIST'];
    $GENRE = $_POST['GENRE'];

    $sql = "UPDATE musics SET SONG_TITLE = '$SONG_TITLE', ARTIST = '$ARTIST', GENRE = '$GENRE' WHERE ID = '$ID'";
    
    if (mysqli_query($conn, $sql)){
        $_SESSION['status'] = "updated";
    }else{
        $_SESSION['status'] = "error";
    }
    mysqli_close($conn);
    header("Location: ../index.php");
    exit();
}
?>