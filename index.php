<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			
			$("#forma_unos_artikala").submit(function(event){
				event.preventDefault();

				var naziv_artikla = $("#naziv_artikla").val();
				var kolicina = $("#kolicina").val();
				var jedinica_mere = $("#jedinica_mere").val();

			$.post(
				"unos_artikla.php?akcija=dodaj-artikal", 
				{"naziv_artikla":naziv_artikla,"kolicina":kolicina,"jedinica_mere":jedinica_mere},
				 function(data){
				 	$("#uneti_artikli_tabela").html(data);
				 	$("#forma_unos_artikala")[0].reset();
				 });
			});

			$(document).on('click','.obrisi_artikal',function(event){
				event.preventDefault();

				var id_artikal = $(this).data("artikal-id");

				$.post(
					"unos_artikla.php?akcija=obrisi-artikal",
					{"id_artikal":id_artikal},
					function(data){
						$("#uneti_artikli_tabela").html(data);
					}
				);
			});

			$("#btn_osvezi_unete_artikle").click(function(){
				$.ajax({
				 		"url":"unos_artikla.php?akcija=osvezi_artikle",
				 		"success":
				 			function(data){
				 				$("#uneti_artikli_tabela").html(data);
				 			}
				});	
			});

			$("#naziv_artikla").on("input",function(){
				var naziv_artikla = $(this).val();
				if(naziv_artikla.length>0){
					$.ajax({
					url: "unos_artikla.php?akcija=prikazi_predloge",
					data: {"naziv_artikla":naziv_artikla},
					success: function(data){
						$("#predlozi").show();
						$("#predlozi").html(data);
					},
					type: "POST"
				});
				}
				
			});

			$("#predlozi").find("li").hover(
				function(){
					alert("ads");
					$(this).addClass("active");
				},
				function(){
					$(this).removeClass("active");
				});

			$("#predlozi").on("hover","li",function(){
				$(this).addClass("active");
			});

			$("#predlozi").on("click","li",function(){
				$("#naziv_artikla").val($(this).text());
				$("#predlozi").hide();
			});

		});
	</script>
	<style type="text/css">
		#grupa_naziv_artikla{
			position: relative;
		}

		#predlozi{
			position: absolute;
			width: 100%;
			display: none;
		}
	</style>
</head>
<body>
<div class="col-md-6">
	<h2 class="h2">Unos artikala</h2>
	<form id="forma_unos_artikala">
		<div id="grupa_naziv_artikla" class="form-group">
			<label for="naziv_artikla">Naziv artikla</label>
			<input type="text" name="naziv_artikla" id="naziv_artikla" class="form-control"/>
			<ul id="predlozi" class="list-group"></ul>
		</div>
		<div class="form-group">
			<label for="kolicina">Kolicina</label>
			<select class="form-control" id="kolicina" name="kolicina">
				<option value="0">Izaberi...</option>
      			<?php 
      				for($i=1; $i<=100; $i++){
      					echo "<option value=".$i.">".$i."</option>";
      				}
      			?>
    		</select>
		</div>
		<div class="form-group">
			<label for="jedinica_mere">Jedinica mere</label>
			<select class="form-control" id="jedinica_mere" name="jedinica_mere">
				<option value="0">Izaberi...</option>
				<option value="kom">kom</option>
				<option value="m">m</option>
				<option value="kutija">kutija</option>
				<option value="kg">kg</option>
			</select>
		</div>
		<input type="submit" class="btn btn-primary" id="submit" name="submit" value="Unesi">
		<button type="reset" class="btn btn-secondary">Reset</button>
	</form>
	<br>
	<a href="narudzbenica.php" class="btn btn-primary btn-lg" role="button" aria-pressed="true">Napravi narudžbenicu</a>
</div>
	<div id="uneti_artikli" class="col-md-6">
		<h2 class="h2">Uneti artikli</h2>
		<button class="btn btn-success" id="btn_osvezi_unete_artikle">Osvezi tabelu</button>
		<br>
		<br>
		<div id="uneti_artikli_tabela"></div>
	</div>
</body>
</html>

