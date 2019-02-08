<?php
    session_start();
    if(
        array_key_exists('erreur',$_SESSION) and isset($_SESSION['erreur']) and trim($_SESSION['erreur'])!=''
    ){
        $erreur = $_SESSION['erreur'];
    }
    session_destroy();
    session_start();
    $_SESSION['erreur'] = $erreur;
    header('location: login.php');
?>