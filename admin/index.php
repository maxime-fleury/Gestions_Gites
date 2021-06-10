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
    <input type="text" name='pseudo' id='pseudo'>
    <input type="password" name="pass" id="pass">
    <input type="submit" value="Valider">
</form>