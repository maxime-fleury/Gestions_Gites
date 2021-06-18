<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href='admin-index.css' rel='stylesheet'>
    <title>Connexion admin</title>
</head>
<body>

<?php
$inc_path = "../inc/";
include $inc_path . "connexion.php";
session_start();
if(isset($_GET['disconnect'])){
    if($_GET['disconnect'] == '1'){
        if(isset($_SESSION['connecte'])){
            unset($_SESSION['connecte']);
        } echo "Vous n'êtes pas connecté.";
        header("Location: ./index.php");
    }
}
if(isset($_SESSION['connecte'])){
    header("Location: ./admin.php");
}
//A MODIFIER
if(isset($_POST['pseudo']) && isset($_POST['pass']))
{
   if($_POST['pseudo'] == 'admin'){
        if($_POST['pass'] == 'mdp123'){
            $_SESSION["connecte"] = true;
            header("Location: ./admin.php");
        } echo "mot de passe inccorect";
    } echo "pseudo incorrect";
}
?>
<form action='index.php' method="POST">
    <input type="text" name='pseudo' placeholder='admin' id='pseudo'>
    <input type="password" name="pass" id="pass" placeholder='*****'>
    <input type="submit" value="Valider">
</form>
    
</body>
</html>