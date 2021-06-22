<?php
try{
    $dbh = new pdo('mysql:host=xill.tk;port=3306;dbname=gite','root','password123',array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ));

    }catch(PDOException $pe){
        echo $pe->getMessage();
    }   