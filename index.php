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
            <?php
                $statement = "select * from hebergement";
                $m = $dbh->prepare($statement);
                $m->execute();
                while($r = $m->fetch()){
        ?>
                <div class="gite">

                    <div class="photo">
                    <?php
                        $id = $r['id'];
                        $statement = "select * from image where id_heberg=$id limit 1";
                        $q = $dbh->prepare($statement);
                        $q->execute();
                        while($s = $q->fetch()){
                            echo '
                            <img src="img/' . $s["image"] . '" height="250px" width="310px">
                            <div class="' . strtolower($r['type']) . '">' . strtolower($r['type']) . '</div>';
                        }
                    ?>
                        

                    </div>

                    <div class="logos">

                        <div class="logo"><img src="img/bed.png" height="30px" width="30px"><p><?php echo $r['lit']; ?></p></div>
                        <div class="logo"><img src="img/user-group.png" height="30px" width="30px"><p><?php echo $r['nbpersonnes']; ?></p></div>
                        <div class="logo"><img src="img/bathtub.png" height="30px" width="30px"><p><?php echo $r['nb_sallebain']; ?></p></div>
                        <div class="logo"><img src="img/swimming.png" height="30px" width="30px"><p><?php echo ($r['piscine']==1 ? "oui" : "non"); ?></p></div>
                        <div class="logo"><img src="img/dog.png" height="30px" width="30px"><p><?php echo ($r['animaux']==1 ? "oui" : "non"); ?></p></div>
                        <div class="logo"><img src="img/wifi.png" height="30px" width="30px"><p><?php echo ($r['wifi']==1 ? "oui" : "non"); ?></p></div>

                    </div>

                    <div class="descript"><h2><?php echo $r['lieu']; ?></h2><p>A partir de <b><?php echo $r['prix']?> €</b> par jour</p></div>
                    <div class="zoom">
                        <button onclick='loadpage(<?php echo $r["id"];?>)'>Voir le logement</button>
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

