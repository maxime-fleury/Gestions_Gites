<?php 
class hebergement{
		private $id;
		private $titre;
		private $description;
		private $nbpersonnes;
		private $nb_sallebain;
		private $lieu;
		private $prix;
		private $dispo;
		
		public function __construct($id,$titre,$description,$nb_pers,$nb_sbain,$lieu,$prix){
			$this->id = $id;
			$this->titre = $titre;
			$this->description = $description;
			$this->nbpersonnes = $nb_pers;
			$this->nb_sallebain = $nb_sbain;
			$this->lieu = $lieu;
			$this->prix = $prix;
		}
		public function setDispo($dispo){
			$this->dispo = $dispo;
		}
		public function toString(){
			echo "id: " . $this->id . " Titre: " . $this->titre . "<br>Description:";
			echo $this->description . "<br> Nb couchages: " . $this->personnes;
			if($this->nb_sallebain > 0)
				echo "Nb salle de bain:" . $this->nb_sallebain;
			echo "<br> Lieu: " . $this->lieu . " Prix: " . $this->prix;
		}	

}
class chambre extends hebergement{
		public function __construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix){
		parent::__construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix);
	}
}
class appartement extends chambre{
	private $jardin = false;
	public function __construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $jardin){
		$this->jardin = $jardin;
		parent::__construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix);
	}
	public function toString(){
		parent::toString();
		if($this->jardin)
			echo "Possède un jardin !";
	}
}
class maison extends appartement{
	private $piscine = false;
	private $CaveGrenierGarage = "aucun";
	public function __construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $jardin, $piscine, $CaveGrenierGarage){
		$this->piscine = $piscine;
		$this->CaveGrenierGarage = $CaveGrenierGarage;
		parent::__construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $jardin);
	}
	public function toString(){
		parent::toString();
			echo "Cave/Grenier/Garage : " . $this->CaveGrenierGarage;
		}
	}

