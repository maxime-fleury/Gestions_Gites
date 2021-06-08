<?php
session_start();
if(isset($_SESSION['connecte'])){
    //il est co, la page ici....
    

}
else{
    header('Location: index.php');
}
?>
<a href='index.php?disconnect=1'>Deconnexion</a>