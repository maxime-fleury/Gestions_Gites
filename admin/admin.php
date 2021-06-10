<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<?php
$inc_path = "../inc/";
session_start();
if(isset($_SESSION['connecte'])){
    //il est co, la page ici....
    include $inc_path . "header.php";
    include $inc_path . "connexion.php";
    include $inc_path . "hebergement.php";
    if(isset($_POST['action'])){
        if($_POST['action'] == 'add'){
            if(isset($_POST['lit']) && isset($_POST["type"]) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['prix']) && isset($_POST["lieu"]) && isset($_POST['nbperso']) && isset($_POST['nbbain'])){
                echo "added";
                $jardin = 0;
                $piscine = 0;
                $garage = 0;
                $animaux = 0;
                $wifi = 0;
                if(isset($_POST['Jardin']))
                    $jardin = 1;
                if(isset($_POST['garage']))
                    $garage = 1;
                if(isset($_POST['piscine']))
                    $piscine = 1;
                if(isset($_POST['animaux']))
                    $animaux = 1;
                if(isset($_POST['wifi']))
                    $wifi = 1;
                $type = $_POST['type'];
                $titre = $_POST['titre'];
                $description = $_POST['description'];
                $prix = $_POST['prix'];
                $lieu = $_POST['lieu'];
                $nbbain = $_POST['nbbain'];
                $nbpers = $_POST['nbperso'];
                $lit = $_POST['lit'];
                $statement = "insert into hebergement values(NULL, '$titre', '$description', '$nbpers', '$nbbain', '$lieu', '$prix', '$type', '$piscine', '$wifi', '$animaux', '$garage', '$jardin', '$lit')";
                $m = $dbh->prepare($statement);
                $m->execute();
            }
        }
        if($_POST['action'] == "edit"){
            if(isset($_POST['lit']) && isset($_POST['id']) && isset($_POST["type"]) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['prix']) && isset($_POST["lieu"]) && isset($_POST['nbperso']) && isset($_POST['nbbain'])){
                echo 'updated';
                $jardin = 0;
                $piscine = 0;
                $garage = 0;
                $animaux = 0;
                $wifi = 0;
                if(isset($_POST['jardin']))
                    $jardin = 1;
                if(isset($_POST['garage']))
                    $garage = 1;
                if(isset($_POST['piscine']))
                    $piscine = 1;
                if(isset($_POST['animaux']))
                    $animaux = 1;
                if(isset($_POST['wifi']))
                    $wifi = 1;

                $type = $_POST['type'];
                $titre = $_POST['titre'];
                $description = $_POST['description'];
                $prix = $_POST['prix'];
                $lieu = $_POST['lieu'];
                $nbbain = $_POST['nbbain'];
                $nbpers = $_POST['nbperso'];
                $id = $_POST['id'];
                $lit = $_POST['lit'];
                $data = [
                    'type' => $type,
                    'titre' => $titre,
                    'description' => $description,
                    'id' => $id,
                    'prix' => $prix,
                    'lieu' => $lieu,
                    'nbbain' => $nbbain,
                    'wifi' => $wifi,
                    'garage' => $garage,
                    'nbpers' => $nbpers,
                    'piscine' => $piscine,
                    'animaux' => $animaux,
                    'jardin' => $jardin,
                    'lit' => $lit,
                ];
                $statement = "UPDATE hebergement SET type=:type, titre=:titre, Description=:description, prix=:prix, lieu=:lieu, nb_sallebain=:nbbain, wifi=:wifi, garage=:garage, nbpersonnes=:nbpers, piscine=:piscine, animaux=:animaux, jardin=:jardin, lit=:lit WHERE id=:id";
                $m = $dbh->prepare($statement);
                $m->execute($data);
            }
        }
    }
    ?>
<h2 class='titre'>
    Affichage des divers hebergement.
</h2>
<?php
    $statement = "select * from hebergement";
    $m = $dbh->prepare($statement);
    $m->execute();
    echo "  <table class='table table-dark table-striped table-hover table-bordered'><tr><th>Titre</th><th>Description</th><th>Type</th><th>Nombre de salle de bains</th><th>Nombre de couchages</th><th>Prix</th><th>lits</th><th>Lieu</th><th>Jardin</th><th>Piscine</th><th>Cave, Grenier ou Garage</th><th>wifi</th><th>animaux</th><th></th></tr>";
	while($r = $m->fetch()){
        $j = "";
        $g = "";
        $p = "";
        $w = "";
        $a = "";
        if($r['jardin'] == 1)  $j ='checked';
        if($r['garage'] == 1)  $g ='checked';
        if($r['piscine'] == 1)  $p ='checked';
        if($r['wifi'] == 1)  $w ='checked';
        if($r['animaux'] == 1)  $a ='checked';
      echo "  <form action='admin.php' method='post'>
             <tr>
            <td><input type='text' value='" . $r['titre'] . "' name='titre' placeholder='titre' id='titre'></td>
            <input type='hidden' name='action' value='edit'>
            <input type='hidden' name='id' value='" . $r['id'] . "'>
            <td><textarea name='description' placeholder='description' id='description'>" . $r['Description'] . "</textarea></td>
            <td><select name='type'>
            ";
            switch($r['type']){
                case "Chambre":
                    echo "<option value='Chambre'>Chambre</option>
                    <option value='Appartement'>Appartement</option>
                    <option value='Maison'>Maison</option>";
                break;
                case "Appartement":
                    echo "<option value='Appartement'>Appartement</option>
                    <option value='Chambre'>Chambre</option>
                    <option value='Maison'>Maison</option>";
                break;
                case "Maison":
                    echo "<option value='Maison'>Maison</option>
                    <option value='Appartement'>Appartement</option>
                    <option value='Chambre'>Chambre</option>";
                break;
            }
            echo "</select></td>
            <td><input type='number' placeholder='0' value='" . $r["nb_sallebain"] . "' name='nbbain' id='nbbain'></td>
            <td><input type='number' placeholder='0' value='" . $r["nbpersonnes"] . "'name='nbperso' id='nbperson'></td>
            <td><input type='number' placeholder='0' value='" . $r['prix'] . "' name='prix' id='prix'>€</td>
            <td><input type='number' placeholder='0' value='" . $r['lit'] . "' name='lit' id='lit'></td>
            <td><input type='text' placeholder='Nevers' value='" . $r['lieu'] . "' name='lieu' id='lieu'></td>
            <td><input type='checkbox' name='jardin' id='jardin' " . $j ."></td>
            <td><input type='checkbox' name='piscine' id='piscine' " . $p ."></td>
            <td><input type='checkbox' name='garage' id='garage' " . $g . "></td>
            <td><input type='checkbox'  name='wifi' id='wifi' " . $w . "></td>
            <td><input type='checkbox' name='animaux' id='animaux' " . $a . "></td>
            <td><input type='submit' value='Modifier !'></td>
            </tr>
        </form>";
	}echo "</table>";
?>
<hr>
<h2 class='Titre'>Ajouter un Hebergement</h2>
    <form action='admin.php' method='post'>
	<table class='table table-dark table-striped table-hover table-bordered'><tr><th>Titre</th><th>Description</th><th>Type</th><th>Nombre de salle de bains</th><th>Nombre de couchages</th><th>Prix</th><th>lits</th><th>Lieu</th><th>Jardin</th><th>Piscine</th><th>Cave, Grenier ou Garage</th><th>wifi</th><th>animaux</th><th></th></tr>
        <tr>
		<td><input type='text' value='' name='titre' placeholder='titre' id='titre'></td>
		<input type='hidden' name='action' value='add'>
        <td><textarea name='description' placeholder='description' id='description'></textarea></td>
        <td><select name='type'>
            <option value='Chambre'>Chambre</option>
            <option value='Appartement'>Appartement</option>
            <option value='Maison'>Maison</option>
        </select></td>
        <td><input type='number' placeholder='0' name='nbbain' id='nbbain'></td>
        <td><input type='number' placeholder='0' name='nbperso' id='nbperson'></td>
        <td><input type='number' placeholder='0' name='prix' id='prix'>€</td>
        <td><input type='number' placeholder='0' name='lit' id='lit'></td>
        <td><input type='text' placeholder='Nevers' name='lieu' id='lieu'></td>
        <td><input type='checkbox'  name='jardin' id='jardin'></td>
        <td><input type='checkbox'  name='piscine' id='piscine'></td>
        <td><input type='checkbox' name='garage' id='garage'></td>
        <td><input type='checkbox'  name='wifi' id='wifi'></td>
        <td><input type='checkbox' name='animaux' id='animaux'></td>
        <td><input type='submit' value='Ajouter !'></td>
		</tr>
	</table>
    </form>
	<style>
    body{
        color:white;
        background:var(--bs-dark);
    }
        input[type=number]{
            width:4em;
        }
        input[type="submit"] {
            display: block;
            width: 150px;
            margin: 0 0 20px;
            padding: 8px 0 10px 0;
            text-align: center;
            border: 1px solid rgba(0,0,0,.5);
            background: rgba(0,0,0,.25);
        }
        textarea {
            display: block;
            width: 150px;
            height: 80px;
            margin: 0 0 5px;
            padding: 8px 12px 10px 12px;
            border: 1px solid rgba(0,0,0,.5);
            background: rgba(0,0,0,.25);
        
        }
        input[type="text"],input[type="number"],input[type="file"],select,button, select option[value='Chambre'], select option[value='Appartement'], select option[value='Maison']{
            color:white;
  padding: 8px 12px 10px 12px;
  border: 1px solid rgba(0,0,0,.5);
  background: rgba(0,0,0,.25)!important;
}
input[type="text"]{
    width:150px;
}
textarea {
  font-family: inherit;
  font-size: 100%;
  vertical-align: baseline;
  border: 0;
  outline: 0;
  color: #fff;
}
        input{
            color:white;
            background-color:var(--bs-dark);
        }
        td{
            text-align:center;
        }
        #disconnect{
            position:relative;
            right:0;
            padding:5px;
            background-color:indigo;
            color:white;
        }
        #disconnect:hover,#disconnect:focus{
            background-color:blue;
        }
    </style>
	<form action='admin.php' method='post'>
		<input type='hidden' name='action' value='addPicture'>
		<hr><h2>
        <label for='id'>
            Choisir sur quel hebergement ajouter une image.
        </label></h2><br>
        <select name='id'>
		<?php
            $statement = "select id, titre from hebergement";
            $m = $dbh->prepare($statement);
            $m->execute();
           
			while($r = $m->fetch()){
			echo "<option value='" . $r['id'] . "'>";
				echo $r['id'] . " " . $r['titre'];
			echo "</option>";
			}
		?>
		</select>
		<input type='file' name='photo' id='photo'>
		<input type='submit'>
	</form>
    <?php
}
else{
    header('Location: ./index.php');
}
?>
<a id='disconnect' href='index.php?disconnect=1'>Deconnexion</a>

<?php include  $inc_path . "footer.php";