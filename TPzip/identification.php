<?php
session_start();

    $dbh=new PDO('mysql:host=localhost;dbname=acces;charset=utf8', 'root', '');

    $query = $dbh->prepare("SELECT count(*) as nb FROM Acces WHERE login=:username AND password=:password limit 1");
    $query->bindValue(':username',$_POST['username']);
    $query->bindValue(':password',$_POST['password']);
    $query->execute();

    $nb=0;
    foreach ($query as $k) {
        $nb=$k['nb'];
        if ($nb==1) {
            $_SESSION['connexion'] = 'yes';
            $_SESSION['username'] = $_POST['username'];
            header("Location:liste.php");
        }
        else{
            $_SESSION['connexion'] = 'no';
            header("Location:login.php?error=Erreur de connexion");
        }
    }
?>