<?php
require "inc/connexion.php";
if(isset($_POST['prix']) && isset($_POST['id']) && isset($_POST['email']) && isset($_POST['date_debut']) && isset($_POST["date_fin"]) && isset($_POST['nb_personnes'])){
    if(!empty($_POST['prix']) && !empty($_POST['id']) && !empty($_POST['email']) && !empty($_POST['date_debut']) && !empty($_POST['date_fin']) && !empty($_POST['nb_personnes'])){
        $email = $_POST['email'];
        $id = $_POST['id'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $nb_personnes = $_POST['nb_personnes'];
        $prix = $_POST['prix'];
        $headers = 'From: webmaster@xill.tk' . "\r\n" .
        'Reply-To: webmaster@xill.tk' . "\r\n" .
        "Content-type: text/plain; charset=utf8" . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $sujet = utf8_decode("Votre réservation du " . $date_debut . " au " . $date_fin);
        $message = utf8_decode("Bonjour " . $email . "\n nous sommes heureux de vous confirmer votre réservation ");
        $message .= utf8_decode("\nDu " . $date_debut . " au " . $date_fin . " pour " . $nb_personnes . " personnes.\n Total : " . $prix);
        $message .= utf8_decode("€\nNous vous souhaitons un agréable séjour, bien cordialement.\n
        M. le directeur.");
        $date_debut = date("Y-m-d", strtotime($date_debut . '-1 month'));
        $date_intermedaire = date("Y-m-d", strtotime($date_debut . ' +1 day'));
        $date_fin = date("Y-m-d", strtotime($date_fin . '-1 month')); //because js date are from 0->11 but in php its 1->12
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        for($i = $date_debut; $i <= $date_fin; $i = date("Y-m-d", strtotime($i . ' +1 day'))){
            $statement = "INSERT INTO indispo VALUES(NULL,$id,'$i')";
            $m = $dbh->prepare($statement);
            $m->execute();
        }
        mail($email, $sujet, $message, $headers);
        echo "ce message est envoyé depuis la page php tout à fonctionnée correctement !";
    }
    else
        echo "Tout les champs sont obligatoire";
}
else
echo "Une erreur s'est produite, certains champs n'existe pas ?";
    