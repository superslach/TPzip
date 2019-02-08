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
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=acces;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


$reponse = $bdd->query('SELECT id, prenom, login, statut, age FROM acces');

echo '<a href="ajoute.php"><img src="images\ajoute.png"/></a><br>';

print("<table>");
    while($data = $reponse->fetch()){ 
        $id = $data['id'];
        $prenom = $data["prenom"];
        $login = $data['login'];
        $statut = $data['statut'];
        $age = $data['age'];
        print("<tr>
                <td><a href='efface.php?id=$id'><img src='images\croix.png' alt='delete'/></a></td>
                <td> | <b>$prenom</b></td>
                <td> | $login</td>
                <td> | $statut</td>
                <td> | $age</td>
                <td> | <a href='modif.php?id=$id'><img src='images\modif.png' alt='update'/></a></td>
            </tr>");
    }
    print("</table>");

$reponse->closeCursor(); 
?>