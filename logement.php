<?php
if(isset($_POST['id'])){
    if($_POST['id'] != ""){
        $id = $_POST['id'];
        ?>

<div class="font">
    <?php
    include "inc/connexion.php";
        $statement = "select count(id_heberg) as cnt from image where id_heberg=$id";
        $l = $dbh->prepare($statement);
        $l->execute();
        while($k = $l->fetch()){
            $i = $k['cnt'];
        }
        for($x=0; $x < $i; $x++){
    ?>
    <span id="id<?php echo $x+1;?>" class="target">
    </span>
    <?php } ?>
    <div class="cadre_diapo">
        <div class="interieur_diapo">
            <?php
                $statement = "select * from hebergement where id=$id";
                $m = $dbh->prepare($statement);
                $m->execute();
                while($r = $m->fetch()){
                    $statement = "select * from image where id_heberg=$id limit 1";
                    $l = $dbh->prepare($statement);
                    $l->execute();
                    while($k = $l->fetch()){
            ?>
            <div class=description>
                <img src="img/<?php echo $k['image'];?>" height="250px" width="600px"alt>
            </div>
            <?php
                    }
            ?>
        </div>
        <ul class="navigation_diapo">
            <?php
            $statement = "select * from image where id_heberg=$id limit 10 offset 1";
            $l = $dbh->prepare($statement);
            $l->execute();
            $i = 0;
            while($k = $l->fetch()){
                $i++;
            ?>
            <li>
                <a href="#id<?php echo $i;?>">
                <img src="img/<?php echo $k['image'];?>" height="100px" width="140px" alt>
                </a>
            </li>
           <?php
           } 
           ?>
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
        <form onsubmit="return false">
        <div id='calendrier'></div>
            <label for="">Du :</label>
            <input type="date" name="date_debut" id="date_debut" min='<?php echo date("Y-m-d"); ?>' value='<?php echo date("Y-m-d"); ?>'>
            <br>
            <label for="">Au :</label>
            <input type="date" name="date_fin" id="date_fin" min='<?php $date = new DateTime("+1 day"); echo $date->format("Y-m-d"); ?>' value='<?php $date = new DateTime("+1 day"); echo $date->format("Y-m-d"); ?>'>

            <br>
            <input type="number" min='1' max='<?php echo $r["nbpersonnes"];?>' placeholder="Nombre de personnes" name="nb_personne" id="nb_personnes">
            <br>
            <input type='email' id="email" value='gmail@gmail.com'>
                <h2><span id='nbnuit'>2</span> nuits à <?php echo $r['prix'];?> €</h2>
            <input type='hidden' id='prix_base' value='<?php echo $r["prix"];?>'>
            <h2><b>Total :</b>&nbsp;&nbsp;<mark><input type='text' id='total' disabled value='<?php echo (intval($r['prix'])*2);?>'> €</mark></h2>
            <button onclick="sendmail(<?php echo $r['id'];?>)">Réserver</button>
        
        </form>

    </div>

    <div class="rond">X</div>                    
    
</div>


<?php
        }
    }
}
?>