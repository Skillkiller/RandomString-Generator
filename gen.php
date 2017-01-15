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



$data = fopen("config/data.txt", 'r+');
$line = fgets($data);
	
$muster = "/Dateien: (\d){1,}/";
if (preg_match_all($muster, $line)) {
	// Some Code
	$dateinenzahl = intval(substr("$line", 9));
	$dateinenzahl++;
	fclose($data);
	$fp = fopen ("config/data.txt", 'w' );
	flock ( $fp, 2 );
	fputs ( $fp, "Dateien: " . $dateinenzahl );
	flock ( $fp, 3 );
	fclose($fp);
} else {
	fclose($data);
	$fehlertitle = "Dateinen Fehler | Service nicht verfügbar";
	$fehlermessge = "Die data Datei scheint beschädigt zu sein. Daher können keine Dateinen zurzeit erstellt werden. ";
	$fehlermessge .= "Ein Administrator wird informiert. Falls sie sich selbst nochmal melden wollen schreiben sie bitte ein E-Mail an: <a href=\"mailto:$adminmail\">$adminmail</a>";
	$fehler = 2;
}
	


?>
<html>
<head>

	<meta charset="utf-8">
	
	<link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/dist/css/AdminLTE.min.css">
	
	<link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/bootstrap/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
	
	$alledateien = scandir('created'); //Ordner "created" auslesen
 
	foreach ($alledateien as $datei) { // Ausgabeschleife
		if ($datei != "." && $datei != ".."  && $datei != "_notes") { 
			if (intval(substr("$datei", 8, 10)) < strtotime('now - 1 hour') and substr ("$datei", -4) == ".txt")
			unlink("created/".$datei);
		}
	};
	
	$start = time();
	//Es gab keine Fehler und Datei wird generiert
	$pfad = "created/";
	$Name = "Datei - " . $start . " - " . zufallsstring(8) . ".txt";
	while (file_exists($pfad . $Name)) {
		$Name = "Datei - " . zufallsstring(8) . ".txt";
	}
	$datei = fopen($pfad . $Name,"w");
	$zeilen = $_POST["zeilen"];
	for ($i=0; $i<$zeilen + 1; $i++) {
		fwrite($datei, zufallsstring($_POST["zeilenl"]) . "\n",$_POST["zeilenl"]+1);
	}
	fclose($datei);
	$end = time();
	$laufzeit = $end - $start;
	

	
	if (isset($_POST["api"]) and $_POST["api"] == 1) {
		echo substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'], 0, -7).$pfad . $Name;
		
		exit;
	}
	
	$prozent = $laufzeit/$maxtime * 100;
	
	
	//Erstelle Output Design
	?>
	<body>
		<div class="col-md-5" style="margin-top: 10px; margin-right: auto; /* Abstand rechts */ margin-bottom: 10px; margin-left: auto; /* Abstand links */ float: none;">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Datei erstellt</h3>
					<a href="index.php"><button type="submit" class="btn btn-info pull-right">Zurück</button></a>
				</div>
				<div class="box-body">
					<a href="<?php echo $pfad . $Name; ?>"  download="<?php echo $Name; ?>" style="text-decoration:none"><div class="info-box bg-yellow">
						<span class="info-box-icon"><i class="fa fa-calendar"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Datei<?php if ($dateinenzahl > 1) {echo "nen"; } ?> erstellt</span>
							<span class="info-box-number"><?php echo $dateinenzahl; ?></span>

							<div class="progress">
								<div class="progress-bar" style="width: <?php echo "$prozent";?>%"></div>
							</div>
							<span class="progress-description">
							Die Datei wurde in <?php echo $laufzeit; ?> sek erstellt! Das sind <?php echo number_format($prozent, 3);?>% von der maximalen Laufzeit. 
							</span>
						</div>
						<!-- /.info-box-content -->
						<p class="help-block col-sm-10">Einfach drauf klicken!</p>
					</div></a>
				</div>
			</div>
		</div>
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
					<?php if ($fehler == 1) {?><p>Leite dich zurück auf die Startseite</p><?php } ?>
				</div>
			</div>
		</div>
		<?php if ($fehler == 1) {?><meta http-equiv="refresh" content="3; URL=index.php"  /><?php } ?>
	</body>	
	</html>
	<?php
	exit;
}

?>