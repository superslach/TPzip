<?php 
session_start(); 
if ($_SESSION['connexion'] != "yes") {
	header("Location:login.php?error=Erreur de connexion");
}
else{
	echo "<h4>Vous êtes connecté en tant que : " .$_SESSION['username'] . "<br/></h4>";
}

    $id = $_GET['id'];
?>


<html>
<body>
<a href="deconnexion.php"><img src="images/deconnexion.png"></a>
<form action="modif.php?id=<?php echo $id?>" method="post">
   Prénom: <input type="text" name="prenom"><br>
   Login: <input type="text" name="login"><br>
   Password: <input type="password" name="password"><br>
   Statut: <select name="statut">
        <?php 
            $bdd = new PDO('mysql:host=localhost;dbname=acces;charset=utf8', 'root', '');

            $reponse = $bdd->query('SELECT * FROM statut');
                while($data = $reponse->fetch()){ 
                    $nom = $data["nom"];
                    print("<option value='$nom'>$nom</option>");
                };

            // on ferme la connexion à mysql 
            $reponse->closeCursor(); 
        ?> 
        </select>
   
   
   <br>
   Age: <input type="text" name="age"><br>
 <input type="submit" name="modifier" value="modifier">
 <a href="liste.php">Retour à la liste</a>
 </form>
</body>
</html> 

<?php

        if (isset ($_POST['modifier']))
        {
            $id = $_GET['id'];
            $prenom = $_POST['prenom'];
            $login  = $_POST['login'];
            $password  = $_POST['password'];
            $statut  = $_POST['statut'];
            $age  = $_POST['age'];

            // Si l'un des champs est vide, lancer une erreur
            if (empty ($prenom) || empty($login) || empty($password) || empty($statut) || empty($age)){
                $info = 'Veuillez renseigner tous les champs';
                print($info);
            }
            else
            {
                $dbh=new PDO('mysql:host=localhost;dbname=acces;charset=utf8', 'root', ''); 
                $req=$dbh->prepare('UPDATE `acces` 
                SET `prenom` = :prenom, `login` = :lg, `password` = :pass, `statut` = :statut, `age` = :age 
                WHERE  `id` = :id ');
                $res=$req->execute(array(
                    ':prenom'=> $prenom,
                    ':lg'=> $login,
                    ':pass'=> $password,
                    ':statut'=> $statut,
                    ':age'=> $age,
                    ':id' => $id,           
                ));
                $info = 'Données ajoutées dans la base';
                print($info);
            }
        }
    ?>