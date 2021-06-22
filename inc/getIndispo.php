<?php
include 'hebergement.php';
include 'connexion.php';
if(isset($_POST['id'])){
    $indispo = new indispo($dbh, $_POST['id']);
    echo $indispo->getIndispo();
}