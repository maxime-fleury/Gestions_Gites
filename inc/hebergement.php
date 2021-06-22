<?php 
class hebergements{
	protected $hebergs;
	protected $nb_heberg;
	protected $dbh;
	public function	__construct($dbh){
		$this->nb_heberg = 0;
		$this->dbh = $dbh;
		$this->loadAllHeberg();
	}
	public function addHeberg($type, $id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin, $piscine, $CaveGrenierGarage){
		switch($type){
			case "Chambre":
				$this->hebergs[$this->nb_heberg] = new Chambre($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit);
			break;
			case "Appartement":
				$this->hebergs[$this->nb_heberg] = new Appartement($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin);
			break;
			case "Maison":
				$this->hebergs[$this->nb_heberg] = new Maison($id, $titre, $description, $nb_pers, $nb_sbain, $lieu, $prix, $wifi, $animaux, $lit, $jardin, $piscine, $CaveGrenierGarage);
			break;
		}
		$this->hebergs[$this->nb_heberg]->setDbh($this->dbh);
		$this->hebergs[$this->nb_heberg]->loadImages();
		$this->nb_heberg += 1;
	}
	public function loadAllHeberg(){
		$statement = "SELECT * from hebergement";
		$m = $this->dbh->prepare($statement);
		$m->execute();
		while($r = $m->fetch()){
			$this->addHeberg($r['type'], $r['id'], $r['titre'], $r['Description'], $r['nbpersonnes'], $r['nb_sallebain'], $r["lieu"], $r['prix'], $r['wifi'], $r["animaux"], $r['lit'], $r['jardin'], $r['piscine'], $r['garage']);
		}
	}
	public function getHeberg($nb){
		return $this->hebergs[$nb];
	}
	public function getNbHebergs(){
		return $this->nb_heberg;
	}
}
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
		public function loadImages(){
			$this->images->loadAllImages($this->dbh, $this->id);
		}
		public function getImage($n){
			return $this->images->getElementn($n);
		}
		public function toString(){
			echo "id: " . $this->id . "<br> Titre: " . $this->titre . "<br>Description:";
			echo $this->description . "<br> Nb couchages: " . $this->nbpersonnes;
			if($this->nb_sallebain > 0)
				echo "<br>Nb salle de bain:" . $this->nb_sallebain;
			echo "<br> Lieu: " . $this->lieu . "<br> Prix: " . $this->prix;
		}
		public function getType(){
			return $this->type;
		}
		public function getSomething($truc){
			if(!isset($this->$truc)){
				return "0";
			}
			return $this->$truc;
		}

}
class chambre extends hebergement{
	public $type;
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
	public $type;
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
	public $type;
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
class indispo{
	private $id;
	private $dbh;
	public function __construct($dbh,$id){
		$this->dbh = $dbh;
		$this->id = $id;
	}
	public function getIndispo(){
		$res = "";
		$statement = "SELECT * from indispo WHERE id=$this->id";
		$m = $this->dbh->prepare($statement);
		$m->execute()or die(print_r($m->errorInfo(), true));
	 	while($r = $m->fetch()){
			$res .= $r['date']."%%%";
		}
		return $res;
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
		return $this->urls[$n];
	}
	public function getnbElements(){
		return $this->nbElements;
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
		$id = intval($id);
		$statement = "SELECT * from image WHERE id_heberg = $id";
		$m = $dbh->prepare($statement);
		$m->execute();
	 	while($r = $m->fetch()){
			$this->addElement($r['image']);
		}
	}
}/*
$x = new maison(0, "La chambre ", "C'est la chambre parfaite", 46, 16, "Nevers", 99, 0, 0, 99, 1, 1, "Grenier");
$x->toString();*/