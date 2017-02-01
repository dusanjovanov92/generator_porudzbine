<?php

require "pdo_konekcija.php";

$sql = "SELECT naziv_artikla,kolicina,jedinica_mere FROM narudzbine_roba;";

$stm = $db->query($sql);
$stm->execute();

$html = "<!DOCTYPE html><html><head><title></title>"
	    ."<style type='text/css'>*{padding:0; margin:0;} body{font-family: Helvetica Neue,Helvetica,Arial,sans-serif; margin:0; padding:20px;} #print_area{width:900px;} table{border-collapse:collapse; width:100%;} table td,table th{padding:10px; border:1px solid #ddd;} table th{border-bottom-width:2px;} table tr:nth-child(even){background-color:#f9f9f9;} </style></head><body>"
		."<div id='print_area'><h3>STR 'Vodorad'</h3><h3>Beogradska 10,Crepaja</h3><h3>Telefon: 013/672-005</h3><h1 style='padding-top:20px; padding-bottom:20px;'>Narudžbina</h1><table>"
		."<thead><tr><th>R.b.</th><th>Naziv artikla</th><th>Količina</th><th>J.m.</th></tr></thead>"
		."<tbody>";

$i = 1;
while ($row = $stm->fetch()) {
	$html.="<tr>"
			."<td>".$i++."</td>"
			."<td>".$row["naziv_artikla"]."</td>"
			."<td>".$row["kolicina"]."</td>"
			."<td>".$row["jedinica_mere"]."</td>"
			."</tr>";
}

$html.="</tbody><table></div></body></html>";

echo $html;