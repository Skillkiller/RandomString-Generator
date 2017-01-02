<html>
	<head>
	<meta charset="utf-8">
	
	<link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/dist/css/AdminLTE.min.css">
	
	<link rel="stylesheet" href="https://almsaeedstudio.com/themes/AdminLTE/bootstrap/css/bootstrap.min.css">
	
	<!-- Schrift Style -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	
	
	<title>Random String Generator</title>
	</head>
	<body style="background-color: #e5e5e5;">
		<div class="col-md-5" style="margin-top: 10px; margin-right: auto; /* Abstand rechts */ margin-bottom: 10px; margin-left: auto; /* Abstand links */ float: none;">
			<div class="box box-primary">
			<form role="form" action="gen.php" method="post" enctype="multipart/form-data" >
				<div class="box-header with-border">
					<h3 class="box-title">Random String Generator</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="zeilen">Zeilen</label>
						<output class="pull-right"  name="anzeige1">10000</output>
						<input class="form-control" oninput="anzeige1.value=zeilen.value" id="zeilen" name="zeilen" type="range" min="0" max="10000" step="1000" value="10000">
					</div>
					<div class="form-group">
						<label for="zeilenl">Zeilenlänge</label>
						<output class="pull-right"  name="anzeige2">10000</output>
						<input input class="form-control" oninput="anzeige2.value=zeilenl.value" id="zeilenl" name="zeilenl" type="range" min="0" max="10000" step="1000" value="10000">
					</div>
					<div class="form-group">
						<label for="inputZeichen">Erlaubte Zeichen</label>
						<input class="form-control" name="zeichen" id="inputZeichen" placeholder="abc..ABC" value="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789" type="text">
						<p class="help-block col-sm-10">Es sind alle Zeichen möglich z.B.: +-*/</p>
					</div>
				</div>
				<div class="box-footer">
					<button type="reset" class="btn btn-danger">Zurücksetzen</button>
					<button type="submit" class="btn btn-success pull-right">Generieren</button>
				</div>
			</form>
			</div>
		</div>
		</div>
	</body>	
</html>