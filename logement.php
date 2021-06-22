<?php
if(isset($_POST['id'])){
    if($_POST['id'] != ""){
        $id = $_POST['id'];
        ?>

<div class="font">
    <span id="id1" class="target">
    </span>
    <span id="id2" class="target">
    </span>
    <span id="id3" class="target">
    </span>
    <span id="id4" class="target">
    </span>
    <div class="cadre_diapo">
        <div class="interieur_diapo">
            <?php
            include "inc/connexion.php";
                $statement = "select * from hebergement where id=$id";
                $m = $dbh->prepare($statement);
                $m->execute();
                while($r = $m->fetch()){
            ?>
            <div class=description>
                <img src="img/gite2p4.jpg" height="250px" width="600px"alt>
            </div>
        </div>
        <ul class="navigation_diapo">
            <li>
                <a href="#id1">
                <img src="img/gite2p1.jpg" height="100px" width="140px" alt>
                </a>
            </li>
            <li>
                <a href="#id2">
                <img src="img/gite2p2.jpg" height="100px" width="140px" alt>
                </a>
            </li>
            <li>
                <a href="#id3">
                <img src="img/gite2p3.jpg" height="100px" width="140px" alt>
                </a>
            </li>
            <li>
                <a href="#id4">
                <img src="img/gite2p4.jpg" height="100px" width="140px" alt>
                </a>
            </li>
        </ul>
        <div class="logos">
            <div class="logo"><img src="img/bed.png" height="30px" width="30px"><p><?php echo $r['lit']; ?></p></div>
            <div class="logo"><img src="img/user-group.png" height="30px" width="30px"><p><?php echo $r['nbpersonnes']; ?></p></div>
            <div class="logo"><img src="img/bathtub.png" height="30px" width="30px"><p><?php echo $r['nb_sallebain']; ?></p></div>
            <div class="logo"><img src="img/swimming.png" height="30px" width="30px"><p><?php echo ($r['piscine']==1 ? "oui" : "non"); ?></p></div>
            <div class="logo"><img src="img/dog.png" height="30px" width="30px"><p><?php echo ($r['animaux']==1 ? "oui" : "non"); ?></p></div>
            <div class="logo"><img src="img/wifi.png" height="30px" width="30px"><p><?php echo ($r['wifi']==1 ? "oui" : "non"); ?></p></div>
        </div>
        <div class="localisation">
            <h2><?php 
                echo $r['lieu'] ."</h2>";
                echo $r['Description'];
            ?>
        </div>
    </div>
    
    
    <div class="pic">
    <div id='calendrier'></div>
        <form action="">
            <h2><b><?php echo $r['prix'];?> €</b>/nuit</h2>

            <label for="">Du :</label>
            <input type="date" name="date_debut" id="date_debut" min='<?php echo date("Y-m-d"); ?>' value='<?php echo date("Y-m-d"); ?>'>
            <br>
            <label for="">Au :</label>
            <input type="date" name="date_fin" id="date_fin" min='<?php $date = new DateTime("+1 day"); echo $date->format("Y-m-d"); ?>' value='<?php $date = new DateTime("+1 day"); echo $date->format("Y-m-d"); ?>'>

            <br>
            <input type="number" min='1' max='<?php echo $r["nbpersonnes"];?>' placeholder="Nombre de personnes" name="nb_personne" id="nb_personnes">

            <h2>Résumé de votre réservation :<br></h2>
                <h2><span id='nbnuit'>2</span> nuits à <?php echo $r['prix'];?> €</h2>
            <input type='hidden' id='prix_base' value='<?php echo $r["prix"];?>'>
            <h2><b>Total :</b>&nbsp;&nbsp;<mark><input type='text' id='total' disabled value='<?php echo (intval($r['prix'])*2);?>'> €</mark></h2>
            <button type="submit">Réserver</button>
        
        </form>

    </div>

    <div class="rond">X</div>                    
    
</div>


<?php
        }
    }
}
?>