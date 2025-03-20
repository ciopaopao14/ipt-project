<?php
session_start();
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $SONG_TITLE = $_POST['SONG_TITLE'];
    $ARTIST = $_POST['ARTIST'];
    $GENRE = $_POST['GENRE'];

    $sql = "INSERT INTO musics (SONG_TITLE, ARTIST, GENRE) VALUES ('$SONG_TITLE', '$ARTIST', '$GENRE')";
    if (mysqli_query($conn, $sql)){
        $_SESSION['status'] = "created";
    }else{
        $_SESSION['status'] = "error";
    }
    mysqli_close($conn);
    header("Location: ../index.php");
    exit();

}