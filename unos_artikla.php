<?php

require "pdo_konekcija.php";

if(isset($_GET["akcija"])){
	$akcija = $_GET["akcija"];

	switch ($akcija) {
		case 'dodaj-artikal':
			$artikli_funkcije = new ArtikliFunkcije($db);
			$artikli_funkcije->dodajArtikal();
			break;
		case 'obrisi-artikal':
			$artikli_funkcije = new ArtikliFunkcije($db);
			$artikli_funkcije->obrisiArtikal();
			break;
		case 'osvezi_artikle':
			$artikli_funkcije = new ArtikliFunkcije($db);
			$artikli_funkcije->prikaziTabeluArtikala();
			break;
		case 'prikazi_predloge':
			prikaziPredlogeNaziva();
			break;
	}
}

function prikaziPredlogeNaziva(){
	global $db;

	$naziv_artikla = $_POST["naziv_artikla"];

	$sql = "SELECT naziv_artikla FROM narudzbine_roba WHERE naziv_artikla LIKE :naziv_artikla;";

	$stm = $db->prepare($sql);
	$stm->execute(["naziv_artikla"=>$naziv_artikla."%"]);

	$html = "";
	while ($row = $stm->fetch()) {
		$html.="<li class='list-group-item predlozi_item'>".$row["naziv_artikla"]."</li>";
	}

	echo $html;
	
}

class ArtikliFunkcije{
	protected $db;

	public function __construct(\PDO $db){
		$this->db = $db;
	}

	function dodajArtikal(){
	$naziv_artikla = $_POST["naziv_artikla"];
	$kolicina = $_POST["kolicina"];
	$jedinica_mere = $_POST["jedinica_mere"];

	$sql = "INSERT INTO narudzbine_roba (naziv_artikla,kolicina,jedinica_mere,id_narudzbina) VALUES(?,?,?,1);";

	$stm = $this->db->prepare($sql);
	$stm->execute([$naziv_artikla,$kolicina,$jedinica_mere]);

	$this->prikaziTabeluArtikala();
}

function obrisiArtikal(){
	$id_artikal = $_POST["id_artikal"];

	$sql = "DELETE FROM narudzbine_roba WHERE id_artikal = ?;";

	$stm = $this->db->prepare($sql);
	$stm->execute([$id_artikal]);

	$this->prikaziTabeluArtikala();
}

function prikaziTabeluArtikala(){
	$sql = "SELECT id_artikal,naziv_artikla,kolicina,jedinica_mere FROM narudzbine_roba;";

$stm = $this->db->query($sql);
$stm->execute();

$html = "<table class='table table-bordered table-striped'>"
		."<thead><tr><th>R.b.</th><th>Naziv artikla</th><th>Kolicina</th><th>J.m.</th><th>Operacije</th></tr></thead>"
		."<tbody>";
$i = 1;
while ($row = $stm->fetch()) {
	$html.="<tr>"
			."<td>".$i++."</td>"
			."<td>".$row["naziv_artikla"]."</td>"
			."<td>".$row["kolicina"]."</td>"
			."<td>".$row["jedinica_mere"]."</td>"
			."<td><a href='#' class='obrisi_artikal' data-artikal-id='".$row["id_artikal"]."'>Obrisi</a></td>"
			."</tr>";
}

$html.="</tbody><table>";

echo $html;
}
}

