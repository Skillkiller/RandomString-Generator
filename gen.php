<?php

include(__DIR__ . "/config/config.php");

function zufallsstring($laenge) {
   //Mögliche Zeichen für den String
   $zeichen = $_POST["zeichen"];
 
   //String wird generiert
   $str = '';
   $anz = strlen($zeichen);
   for ($i=0; $i<$laenge; $i++) {
      $str .= $zeichen[rand(0,$anz-1)];
   }
   return $str;
}

$fehler = 0;
$fehlermessge = "";
$fehlertitle = "";

if (!isset($_POST["zeilen"]) or !isset($_POST["zeilenl"]) or !isset($_POST["zeichen"])) {
	$fehlertitle = "Formular Daten ungültig";
	$fehlermessge = "Die übermitelten Formulardaten sind nicht vollständig";
	$fehler = 1;
}

if (isset($_POST["zeilen"]) and $_POST["zeilen"] > $maxzeilen) {
	$fehlertitle = "maximale Zeilen Anzahl erreicht";
	$fehlermessge = "Du hast die maximale Anzahl an Zeilen überschritten";
	$fehler = 1;
}

if (isset($_POST["zeilenl"]) and $_POST["zeilenl"] > $maxzeilenl) {
	$fehlertitle = "maximale Zeilenlänge erreicht";
	$fehlermessge = "Du hast die maximale Zeilenlänge überschritten";
	$fehler = 1;
}


?>
<html>
<head>

	<meta charset="utf-8">
	
	<link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/dist/css/AdminLTE.min.css">
	
	<link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/bootstrap/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	
	<?php
	if ($fehler > 0) {
		echo "<title>Es gab einen Fehler</title>";
	} else {
		echo "<title>Datei generiert</title>";
	}
	?>
</head>

<?php
if (!$fehler > 0) {
	//Es gab keine Fehler und Datei wird generiert
	$pfad = "created/";
	$Name = "Datei - " . zufallsstring(8) . ".txt";
	while (file_exists($pfad . $Name)) {
		$Name = "Datei - " . zufallsstring(8) . ".txt";
	}
	$datei = fopen($pfad . $Name,"w");
	$zeilen = $_POST["zeilen"];
	for ($i=0; $i<$zeilen + 1; $i++) {
		fwrite($datei, zufallsstring($_POST["zeilenl"]) . "\n",$_POST["zeilenl"]+1);
	}
	fclose($datei);
	
	//Erstelle Output Design
	?>
	<body>
		<p>Datei erstellt:</p>
		<a href="<?php echo $pfad . $Name; ?>" download="<?php echo $Name; ?>">Datei</a>
		
	</body>
	</html>
	<?php
} else {
	// Es ist ein Fehler aufgetreten
	?>
	<body>
		<div class="col-md-4" style="margin-top: 10px; margin-right: auto; /* Abstand rechts */ margin-bottom: 10px; margin-left: auto; /* Abstand links */ float: none;">
			<div class="box box-solid box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Fehler: <?php echo $fehlertitle; ?></h3>
				</div>
				<div class="box-body">
					<p><?php echo $fehlermessge; ?></p>
					<p>Leite dich zurück auf die Startseite</p>
				</div>
			</div>
		</div>
		<meta http-equiv="refresh" content="3; URL=index.php"  />
	</body>	
	</html>
	<?php
	exit;
}

?>