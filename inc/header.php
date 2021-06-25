<?php
    try{
        $dbh = new pdo('mysql:host=xill.tk;port=3306;dbname=gite','root','password123',array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ));

    }catch(PDOException $pe){
            echo $pe->getMessage();
    }   

    // $allimages = $dbh->query('SELECT * FROM image ORDER BY id DESC');
    $allgites = $dbh->query('SELECT * FROM hebergement ORDER BY id DESC');
    if(isset($_GET['s']) AND !empty($_GET['s'])){
        $recherche = htmlspecialchars($_GET['s']);
        $allgites = $dbh->query('SELECT * FROM hebergement WHERE lieu LIKE "%' .$recherche. '%" ORDER BY id DESC');
    }

?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/house.png" type="image/x-icon">
    <link href='inc/calendrier.css' rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>gites</title>
</head>
<body>
        <header>

            <div class="head">

                <div><a href="index.php"><img src="img/house.png" height="60px" width="60px"></a></div>
                <h1>Logement</h1>
                
                <!-- <button>Chambres</button>
                <button>Appartements</button>
                <button>Maisons</button> -->

            </div>

            <div class="accueil">

                <form method="GET">
                    <input type="search" name = "s" placeholder="Rechercher un lieu">
                    <button type="submit"><img src="img/loupe.png" width="30px" height="30px" alt=""></button>
                </form>
            
            </div>

        </header>