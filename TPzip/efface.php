<?php
session_start(); 
if ($_SESSION['connexion'] != "yes") {
	header("Location:login.php?error=Erreur de connexion");
}
else{
	echo "<h4>Vous êtes connecté en tant que : " .$_SESSION['username'] . "<br/></h4>";
}
?>
<a href="deconnexion.php"><img src="images/deconnexion.png"></a>
<?php
try{
    $dbh=new PDO('mysql:host=localhost;dbname=acces;charset=utf8', 'root', ''); 
    $id = $_GET['id'];
    $req=$dbh->prepare('DELETE FROM acces WHERE id=:id');
    $res=$req->execute(array(':id'=> $id,));
   
    header('Location: liste.php?message='.$res);  
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>

