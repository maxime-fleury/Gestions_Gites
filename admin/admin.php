<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link href='admin.css' rel='stylesheet'>
<script defer>
setTimeout(function(){
  let p = "show-pictures";
  let y = document.getElementById("toggleButton");
  toggleEl(p);
    y.addEventListener("click", function(){
        if(toggleEl(p))
            y.innerHTML = "Afficher les photos";
        else
            y.innerHTML = "Cacher les photos";
    }

    );
    function toggleEl(yy){
        console.log(yy);
        var x = document.getElementById(yy);
        x.style.display = x.style.display === 'none' ? '' : 'none';
        return x.style.display === 'none';
    }
},100);
   

</script>
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
                $jardin = 0;$piscine = 0;$garage = 0;$animaux = 0;$wifi = 0;
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
                $lit = $_POST['lit'];
                echo $type;
                switch($type){
                    case "Chambre" : 
                        $k = new Chambre(0, $titre, $description, $nbpers, $nbbain, $lieu, $prix, $wifi, $animaux, $lit);
                    break;
                    case "Appartement" : 
                        $k = new Appartement(0, $titre, $description, $nbpers, $nbbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin);
                    break;
                    case "Maison" : 
                        $k = new Maison(0, $titre, $description, $nbpers, $nbbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin, $piscine, $garage);
                    break;
                }
                $k->setDbh($dbh);
                $k->loadid();
                $k->insertDb();
                $k->toString();
            }
        }
        if($_POST['action'] == "edit"){
            if(isset($_POST['oldtype']) && isset($_POST['lit']) && isset($_POST['id']) && isset($_POST["type"]) && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['prix']) && isset($_POST["lieu"]) && isset($_POST['nbperso']) && isset($_POST['nbbain'])){
                echo 'updated';
                $jardin = 0;
                $piscine = 0;
                $garage = 0;
                $animaux = 0;
                $wifi = 0;
                if(isset($_POST['jardin'])) $jardin = 1;
                if(isset($_POST['garage'])) $garage = 1;
                if(isset($_POST['piscine'])) $piscine = 1;
                if(isset($_POST['animaux'])) $animaux = 1;
                if(isset($_POST['wifi'])) $wifi = 1;

                $type = $_POST['type'];
                $titre = $_POST['titre'];
                $description = $_POST['description'];
                $prix = $_POST['prix'];
                $lieu = $_POST['lieu'];
                $nbbain = $_POST['nbbain'];
                $nbpers = $_POST['nbperso'];
                $id = $_POST['id'];
                $lit = $_POST['lit'];

                switch($type){
                    case "Chambre" : 
                        $k = new Chambre($id, $titre, $description, $nbpers, $nbbain, $lieu, $prix, $wifi, $animaux, $lit);
                    break;
                    case "Appartement" : 
                        $k = new Appartement($id, $titre, $description, $nbpers, $nbbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin);
                    break;
                    case "Maison" : 
                        $k = new Maison($id, $titre, $description, $nbpers, $nbbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin, $piscine, $garage);
                    break;
                }
                $k->setDbh($dbh);
                $k->update();
            }
        }
        if($_POST['action'] == 'delete'){
            if(isset($_POST['id'])){
                echo "Image supprimée !";
                $id = $_POST['id'];
                images::delete($dbh, $id);
            }
        }
        if($_POST['action'] == 'delete_heberg'){
            if(isset($_POST['id'])){
                echo "Hebergement supprimé !";
                hebergement::deleteHeberg($_POST['id'], $dbh);
            }
        }
        if($_POST['action'] == 'addPicture'){
            if(isset($_POST['id']) && isset($_FILES["photo"])){
                echo "<h1>test</h1>";
                echo $_POST['id'];
                $target_dir = "../img/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    echo "Le fichier ". htmlspecialchars( basename( $_FILES["photo"]["name"])) . " à été uploadée.";
                    $id = $_POST['id'];
                    $name = htmlspecialchars( basename( $_FILES["photo"]["name"]));
                    images::upload($dbh, $id, $name);
                } else {
                    echo "Il y a eu une erreur lors de l'upload du fichier.";
                }
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
        $j = "";$g = "";$p = "";$w = "";$a = "";
        if($r['jardin'] == 1)  $j ='checked';
        if($r['garage'] == 1)  $g ='checked';
        if($r['piscine'] == 1)  $p ='checked';
        if($r['wifi'] == 1)  $w ='checked';
        if($r['animaux'] == 1)  $a ='checked';
      echo "<form action='admin.php' method='post'>
            <tr>
            <td><input type='text' value='" . $r['titre'] . "' name='titre' placeholder='titre' id='titre'></td>
            <input type='hidden' name='action' value='edit'>
            <input type='hidden' name='oldtype' value='" .$r['type'] . "'>
            <input type='hidden' name='id' value='" . $r['id'] . "'>
            <td><textarea name='description' placeholder='description' id='description'>" . $r['Description'] . "</textarea></td>
            <td><select name='type'>";
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
            <td><input type='submit' value='Modifier !'>
            
        </form> <form action='admin.php' method='post'>
        <input type='hidden' name='action' value='delete_heberg'>
        <input type='hidden' name='id' value='" . $r['id'] . "'>
        <input type='submit' value='Supprimer !'></form>
        </tr>";
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
	<form enctype="multipart/form-data" action='admin.php' method='post'>
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
    <hr>
    <button id='toggleButton'>Affichez les images</button>
    <div id="show-pictures">
    <h2>Supprimez des photos ?</h2>
    <?php
    $statement = "select * from image";
    $m = $dbh->prepare($statement);
    $m->execute();
            echo "<table class='table-striped table-hover table-dark'><tr><th> Heberg_id </th><th> image </th><th> Supprimer </th></tr>";
    while($r = $m->fetch()){
        echo "<form action='admin.php' method='POST'><tr><td>";
            echo  $r["id_heberg"] . "</td><td><img class='small-image' src='../img/" . $r['image'] . "'></td>";
            echo "<input type='hidden' name='action' value='delete'>";
            echo "<input type='hidden' name='id' value='" . $r["id_image"] . "'>";
            echo "<td><input type='submit' value='Supprimer'></td></tr>";
        echo "</form>";
    }
    echo "</table></div><p>  </p>";

}
else{
    header('Location: ./index.php');
}
?>
<a id='disconnect' href='index.php?disconnect=1'>Deconnexion</a>

<?php include  $inc_path . "footer.php";