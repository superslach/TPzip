<?php 
session_start(); 
if ($_SESSION['connexion'] != "yes") {
	header("Location:login.php?error=Erreur de connexion");
}
else{
	echo "<h4>Vous êtes connecté en tant que : " .$_SESSION['username'] . "<br/></h4>";
}

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=acces;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$stats = $bdd->query('SELECT nom FROM statut');
$stats->execute();
?>
<a href="deconnexion.php"><img src="images/deconnexion.png"></a>
<form action="recherche.php" method="post">
	<label for="name">Prenom :</label>
	<input type="text" name="name" value="" />
	<label for="statut">Statut :</label>
       <select name="statut[]" multiple="1">
       <?php 
       		foreach ($stats as $k) {
       			echo '<option value="'.$k['nom'].'">'.$k['nom'].'</option>';
       		}
       ?>
       </select>
    <label for="ageMin">Age min :</label>
	<input type="text" name="ageMin" value="" />
	<label for="ageMax">Age max :</label>
	<input type="text" name="ageMax" value="" />
	<br/>
	<input type="submit" value="Recherche"/> 
</form>
<table border="1">
	<tr>
		<th>id</th>
		<th>prenom</th>
		<th>login</th>
		<th>password</th>
		<th>statut</th>
		<th>age</th>
		<th>delete</th>
		<th>modifier</th>
	</tr>
<?php 
$recherche = "SELECT * FROM Acces WHERE ";

if (isset($_POST['name']) != "") {
	$recherche .= "(prenom LIKE '%". $_POST['name'] ."%') ";
}

if (isset($_POST['statut'])) {
	if (isset($_POST['name']) != "") {
	$recherche .= " AND ";
	}
	$recherche .= "( ";
	foreach ($_POST['statut'] as $a) {
		$recherche .= " statut = '" .$a."' OR ";
	}
	$recherche .= " FALSE) ";
}

//Si que ageMin
if (isset($_POST['ageMin']) != "" && $_POST["ageMax"] == "") {
	if (isset($_POST['name']) != "" || $_POST['statut'] != "") {
	$recherche .= " AND ";
	}
	$recherche .= "(age > ". $_POST['ageMin']. ")";
}

//Si que ageMax
if (isset($_POST['ageMax']) != "" && $_POST["ageMin"] == "") {
	if (isset($_POST['name']) != "" || isset($_POST['ageMin']) != "") {
	$recherche .= " AND ";
	}
	$recherche .= "(age < ". $_POST['ageMin']. ")";
}

//Si les deux age
if (isset($_POST['ageMax']) != "" && $_POST["ageMin"] != "") {
	if (isset($_POST['name']) != "" || $_POST['statut'] != "") {
	$recherche .= " AND ";
	}
	$recherche .= "(age BETWEEN ". $_POST['ageMin'] ." AND ". $_POST['ageMax'] ."  )";
}

//echo $recherche;
$q = $bdd->prepare($recherche);
$q->execute();
foreach ($q as $value) {
	echo "<tr>
			<td>". $value['id'] ."</th>
			<td>". $value['prenom'] ."</th>
			<td>". $value['login'] ."</th>
			<td>". $value['password'] ."</th>
			<td>". $value['statut'] ."</th>
			<td>". $value['age'] ."</th>
			<td><a href=\"efface.php?id=". $value['id'] ."\"><img src=\"images/croix.png\"></a></td>
			<td><a href=\"modif.php?id=". $value['id'] ."\"><img src=\"images/modif.png\"></a></td>
		</tr>";
}
?>
</table>
<a href="liste.php"><h6>Retour</h6></a>
