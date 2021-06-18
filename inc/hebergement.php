<?php 

class hebergement{
		protected $id;
		protected $titre;
		protected $description;
		protected $nbpersonnes;
		protected $nb_sallebain;
		protected $lieu;
		protected $prix;
		protected $dispo;
	    protected $wifi;
		protected $lit;
		protected $images;
		protected $dbh;

		public function __construct($id, $titre, $description, $nb_pers,$nb_sbain,$lieu,$prix, $wifi, $animaux, $lit){
			$this->id = $id;
			$this->titre = $titre;
			$this->description = $description;
			$this->nbpersonnes = $nb_pers;
			$this->nb_sallebain = $nb_sbain;
			$this->lieu = $lieu;
			$this->prix = $prix;
			$this->animaux = $animaux;
			$this->wifi = $wifi;
			$this->lit = $lit;
			$this->images = new images();
		}
		public function setDbh($dbh){
			$this->dbh = $dbh;
		}
		public static function deleteHeberg($id, $dbh){
			$statement = "DELETE FROM hebergement WHERE id = $id";
			echo "<br>" . $statement . "<br>";
			$m = $dbh->prepare($statement);
			$m->execute() or die(print_r($m->errorInfo(), true));
		}
		public function insertDdb($type, $jardin, $piscine, $CaveGrenierGarage){
			$statement = "insert into hebergement values(NULL, '$this->titre', '$this->description', '$this->nbpersonnes', '$this->nb_sallebain', '$this->lieu', $this->prix, '$type', $piscine, $this->wifi, '$this->animaux', '$CaveGrenierGarage', $jardin, '$this->lit')";
			echo "<br>" . $statement . "<br>";
			$m = $this->dbh->prepare($statement);
			$m->execute() or die(print_r($m->errorInfo(), true));

		}
		public function setDispo($dispo){
			$this->dispo = $dispo;
		}
		public function loadId(){
			$statement = "SELECT count(id) as cnt from hebergement";
			$m = $this->dbh->prepare($statement);
			$m->execute();
			$this->id = $m->fetch()['cnt'];
			echo $this->id;
		}
		public function addImage($url){
			$images->addElement($url);
		}
		public function toString(){
			echo "id: " . $this->id . "<br> Titre: " . $this->titre . "<br>Description:";
			echo $this->description . "<br> Nb couchages: " . $this->nbpersonnes;
			if($this->nb_sallebain > 0)
				echo "<br>Nb salle de bain:" . $this->nb_sallebain;
			echo "<br> Lieu: " . $this->lieu . "<br> Prix: " . $this->prix;
		}

}
class chambre extends hebergement{
	private $type;
		public function __construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit){
		parent::__construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit);
		$this->type = "Chambre";
	}
	public function insertDb(){
		parent::insertDdb($this->type, 0, 0, "Aucun");
	}
	public function prepareInsertDb($type, $jardin, $piscine, $garage){
		parent::insertDdb($type, $jardin, $piscine, $garage );
	}
	public function update(){
		$statement = "UPDATE hebergement SET type='$this->type', titre='$this->titre', Description='$this->description', prix=$this->prix, lieu='$this->lieu', nb_sallebain=$this->nb_sallebain, wifi=$this->wifi, garage='Aucun', nbpersonnes=$this->nbpersonnes, piscine=0, animaux=$this->animaux, jardin=0, lit=$this->lit WHERE id=$this->id";
		$m = $this->dbh->prepare($statement);
		$m->execute() or die(print_r($m->errorInfo(), true));
	}
}
class appartement extends chambre{
	protected $jardin = 0;
	private $type;
	public function __construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin){
		$this->jardin = $jardin;

		parent::__construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit);

		$this->type = "Appartement";
	}
	public function insertDb(){
		parent::prepareInsertDb($this->type, $this->jardin, 0, "Aucun");
	}
	public function prepareInsertDb($type, $jardin, $piscine, $garage){
		echo "<br>insert appart " . $this->type . " " . $jardin  . " " . $jardin . " <br>";

		parent::prepareInsertDb($type, $jardin, $piscine, $garage);
	}
	public function toString(){
		parent::toString();
		if($this->jardin == 1)
			echo "<br>Possède un jardin !";
	}
	public function update(){
		$statement = "UPDATE hebergement SET type='$this->type', titre='$this->titre', Description='$this->description', prix=$this->prix, lieu='$this->lieu', nb_sallebain=$this->nb_sallebain, wifi=$this->wifi, garage='Aucun', nbpersonnes=$this->nbpersonnes, piscine=0, animaux=$this->animaux, jardin=$this->jardin, lit=$this->lit WHERE id=$this->id";
		$m = $this->dbh->prepare($statement);
		$m->execute() or die(print_r($m->errorInfo(), true));
	}
}
class maison extends appartement{
	protected $piscine = 0;
	protected $CaveGrenierGarage = "aucun";
	private $type;
	protected $jardin;
	public function __construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin, $piscine, $CaveGrenierGarage){
		$this->piscine = $piscine;
		$this->jardin = $jardin;
		$this->CaveGrenierGarage = $CaveGrenierGarage;

		parent::__construct($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin);

		$this->type = "Maison";
	}
	public function insertDb(){
		echo $this->jardin ." Maison Jardin";
		parent::prepareInsertDb($this->type, $this->jardin, $this->piscine, $this->CaveGrenierGarage);
	}
	public function toString(){
		parent::toString();
		if($this->piscine == 1)
			echo "<br>Possède une piscine !";
		echo "<br>Cave/Grenier/Garage : " . $this->CaveGrenierGarage;
	}
	public function update(){
			$statement = "UPDATE hebergement SET type='$this->type', titre='$this->titre', Description='$this->description', prix=$this->prix, lieu='$this->lieu', nb_sallebain=$this->nb_sallebain, wifi=$this->wifi, garage='$this->CaveGrenierGarage', nbpersonnes=$this->nbpersonnes, piscine=$this->piscine, animaux=$this->animaux, jardin=$this->jardin, lit=$this->lit WHERE id=$this->id";
			$m = $this->dbh->prepare($statement);
			$m->execute()or die(print_r($m->errorInfo(), true));
	}
}
class images {
	private $nbElements;
	private $urls = array();
	public function __construct(){
		$this->nbElements = 0;
	}
	public function addElement($url){
		$this->urls[$this->nbElements] = $url;
		$this->nbElements++;
	}
	public function getElementn($n){
		return $urls[$n];
	}
	public function getnbElements(){
		return $nbElements;
	}
	public function toString(){
		$res = "";
		foreach($this->urls as $value){
			$res .= $value . "<br>";
		}
		echo $res;
		return $res;
	}
	public static function delete($dbh, $id){
		$statement = "DELETE FROM image WHERE id_image = $id";
		$m = $dbh->prepare($statement);
		$m->execute();
	}
	public static function upload($dbh, $id, $name){
		$statement = "INSERT INTO image values(NULL, '$id', '$name') ";
		$m = $dbh->prepare($statement);
		$m->execute();
	}
	public function loadAllImages($dbh, $id){
		$statement = "SELECT * from images WHERE id_heberg = $id";
		$m = $dbh->prepare($statement);
		$m->execute();
	   
		while($r = $m->fetch()){
			$this->addElement($r['image']);
		}
	}
}/*
$x = new maison(0, "La chambre ", "C'est la chambre parfaite", 46, 16, "Nevers", 99, 0, 0, 99, 1, 1, "Grenier");
$x->toString();*/