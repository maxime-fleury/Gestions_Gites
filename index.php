<?php 
$inc_path = "./inc/";
include $inc_path . "header.php";
include $inc_path . "connexion.php";
include $inc_path . "hebergement.php";
?>


        <!-- TITRE -->

            <div class="title">

                <h1>Découvrez nos logements</h1>

            </div>

            <hr>

        <!-- FIN TITRE -->

        <!-- SECTION LOGEMENTS -->

        <section class="logement">
        <div class="view" id='view' >
        </div>

            <div class="gites">
            <!-- test moteur de recherche -->
            <?php
                    if($allgites->rowCount() > 0){

                        while($gite = $allgites->fetch()){
                            ?>
                            <p><?= $gite['lieu']?></p>
                            <?php
                        }

                    }else {
                        ?>
                        <p>Aucun gite trouvé pour la recherche</p>
                        <?php
                    }
                    ?>
                <!-- fin test -->
            <?php
                /*$statement = "select * from hebergement";
                $m = $dbh->prepare($statement);
                $m->execute();
                while($r = $m->fetch()){*/
                $collec = new hebergements($dbh);
                for($i = 0; $i < $collec->getNbHebergs(); $i++){
        ?>
                <div class="gite">

                

                    <div class="photo">
                    <?php
                            echo '
                            <img src="img/' . $collec->getHeberg($i)->getImage(0) . '" height="250px" width="310px">
                            <div class="' . strtolower($collec->getHeberg($i)->getType()) . '">' . strtolower($collec->getHeberg($i)->getType()) . '</div>';
                    ?>
                        

                    </div>

                    <div class="logos">

                        <div class="logo"><img src="img/bed.png" height="30px" width="30px"><p><?php echo $collec->getHeberg($i)->getSomething('lit'); ?></p></div>
                        <div class="logo"><img src="img/user-group.png" height="30px" width="30px"><p><?php echo $collec->getHeberg($i)->getSomething('nbpersonnes'); ?></p></div>
                        <div class="logo"><img src="img/bathtub.png" height="30px" width="30px"><p><?php echo  $collec->getHeberg($i)->getSomething("nb_sallebain"); ?></p></div>
                        <div class="logo"><img src="img/swimming.png" height="30px" width="30px"><p><?php echo ( $collec->getHeberg($i)->getSomething('piscine')==1 ? "oui" : "non"); ?></p></div>
                        <div class="logo"><img src="img/dog.png" height="30px" width="30px"><p><?php echo ( $collec->getHeberg($i)->getSomething('animaux')==1 ? "oui" : "non"); ?></p></div>
                        <div class="logo"><img src="img/wifi.png" height="30px" width="30px"><p><?php echo ( $collec->getHeberg($i)->getSomething('wifi')==1 ? "oui" : "non"); ?></p></div>

                    </div>

                    <div class="descript"><h2><?php echo $collec->getHeberg($i)->getSomething("lieu"); ?></h2><p>A partir de <b><?php echo $collec->getHeberg($i)->getSomething("prix");?> €</b> par jour</p></div>
                    <div class="zoom">
                        <button onclick='loadpage(<?php echo $collec->getHeberg($i)->getSomething("id");?>)'>Voir le logement</button>
                    </div>
                    
                </div>
                <?php 
                }
                ?>

            </div>

        </section>
        <!-- FIN LOGEMENT -->

        <!-- FOOTER -->
        
        <footer>

            <div class="foot">

                <button>Chambres</button>
                <button>Appartements</button>
                <button>Maisons</button>
                <img src="img/facebook.png" height="40px" width="40px">
                <img src="img/twitter.png" height="40px" width="40px">
                <img src="img/instagram.png" height="40px" width="40px">

            </div>

        </footer>

        <!-- FIN FOOTER -->
            <script src="ajax.js" defer></script>
    </body>

</html>

