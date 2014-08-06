<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" />

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<!--meta http-equiv="Pragma" content="no-cache"/-->
	<meta name="robots" content="nofollow" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Carsale Administrativo</title>

	<script type="text/javascript" src="scripts/jquery.2.9.3.min.js"></script>
	<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
	<script type="text/javascript" src="scripts/jquery-ui.js"></script>
	<script type="text/javascript" src="scripts/colorpicker.js"></script>
	<script type="text/javascript" src="scripts/megaOferta.js"></script>
	<script type="text/javascript" src="scripts/editNames.js"></script>	
	
	<link rel="stylesheet" href="styles//jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="styles/index.css" />
	<link rel="stylesheet" type="text/css" href="styles/explorer.css" />
	<style type="text/css">
.custom-combobox-input {
	width: 360px;
}
	</style>
</head>
<body name="searchList">
<?
include ("./scripts/conectDB.php");
include ("./scripts/functions.php");


if ($_POST[btnSave] == "Salvar") {
	switch ($_POST[category]) {
		case 'color':
			$ssave = "update `colorVersion` set `name` = '".$_POST[txtName]."', `hexa` = '".$_POST[txtHexa]."', `price` = '".$_POST[txtPrice]."', `code` = '".$_POST[txtCode]."', `type` = '".$_POST[txtType]."' where `id` = '".$_POST[txtId]."';";
			break;
		case 'options':
			$ssave = "update `optionsManufacturer` set `name` = '".urldecode($_POST[txtName])."', `options` = '".urldecode($_POST[txtOptValue])."', `price` = '".$_POST[txtPrice]."', `code` = '".$_POST[txtCode]."' where `id` = '".$_POST[txtId]."';";

			// $sql_addOpt = "insert into `optionsManufacturer` (`id`, `idManufacturer`, `code`, `name`, `options`, `price`, `active`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ('', '".$_GET[manufacturerId]."', '".$_GET[codopt]."', '".$_GET[name]."', '".$_GET[text]."', '".$_GET[price]."', 's', now(), now(),'')";
			break;
	}
	if ($ssave) {
		// echo $ssave;
		$qsave = mysql_query($ssave);
	}
}
?>

<div class="body">
	<header>
		<h1 class="logo"><span class="logoText logoRed">Car</span><span class="logoText logoBlack">sale</span></h1>
		<h2>
			<span>Sistema administrativo - Editar Nomenclaturas</span>
		</h2>
	</header>
	<ol class="breadcrumb">
		<li><a href="index.php">Home</a></li>
	</ol>
	<!--form class="form-search">
	<div class="input-append">
	<input type="text" class="span2 search-query">
	<button type="submit" class="btn">Search</button>
	</div>
	</form-->
	<form action="#" method="post" enctype="multipart/form-data" style="overflow:hidden">
		<div class=""  data-spy="affix" data-offset-top="145">
		<input type="hidden" name="megaOfertaId" class="megaOfertaId" id="megaOfertaId" />
		<div class="megaDiv">
		
			<div class="MegaSelects">
				<select name="itemListEdit" id="itemListEdit">
					<option></option>
					<?
					switch ($_GET[category]) {
						case 'options':
							$s_opt = "select *, optionsManufacturer.id as id, optionsManufacturer.name as name, manufacturer.name as vname from optionsManufacturer, manufacturer where optionsManufacturer.idManufacturer = manufacturer.id group by optionsManufacturer.name order by optionsManufacturer.name";
							break;
						case 'color':
							$s_opt = "select *, colorVersion.id as id, colorVersion.name as name, version.name as vname from colorVersion, version where colorVersion.idVersion = version.id group by colorVersion.name order by colorVersion.name";
							break;
					}
					$q_opt = mysql_query($s_opt);
					while ($resItem = mysql_fetch_array($q_opt)) {
					?>
						<option value="<?=$resItem[id]?>"><?=utf8_encode($resItem[name])?> => <?=utf8_encode($resItem[vname])?></option>
					<?
					}
					?>
				</select>
			</div>
			<input type="hidden" name="manufacturerId" id="manufacturerId" />
			<input type="hidden" name="modelId" id="modelId" />
			<input type="hidden" name="versionId" id="versionId" />
			<!-- <input type="button" value="Limpar Campos" id="btnClean" /> -->
			<input type="hidden" name="dateIni" id="dateIni" class="addMegaDate" />
			<input type="hidden" name="dateLimit" id="dateLimit" class="addMegaDate" />
		</div>
		</div>
		<div class="formEditFeature">
			<input type="hidden" name="category" id="category" value="<?=$_GET[category]?>" /><br />
			<input type="hidden" name="txtId" id="txtId" placeholder="Id" /><br />
			Nome: <input type="text" name="txtName" id="txtName" placeholder="Nome" /><br />
			Código: <input type="text" name="txtCode" id="txtCode" placeholder="Código" /><br />
			Preço: <input type="text" name="txtPrice" id="txtPrice" placeholder="Valor Padrao" /><br />
			<? if ($_GET[category] == "color") { ?>
				Hexa: <input type="text" name="txtHexa" id="txtHexa" placeholder="Hexa" /><br />
				Tipo: <input type="text" name="txtType" id="txtType" placeholder="Tipo" /><br />
			<? } else { ?>
				<textarea id="txtOptValue" name="txtOptValue"></textarea>
			<? } ?>
			<ul id="ulVersions"></ul>
			<input type="submit" name="btnSave" value="Salvar" />
		</div>
	</form>
	<footer>
		Copyright 2013 carsale.com.br - Todos os direitos reservados
	</footer>
</div>
</body>
<script>
function loadInfo(obj){
	manufacturerId = $(obj).val();
	console.log('api/index.php?type=askOptionEdit&optId='+manufacturerId);
	$.getJSON('api/index.php?type=askOptionEdit&optId='+manufacturerId, function(data) {
		//console.log(data[0].response,data[0].insertId);
		$.each(data, function(key, val) {
			$('#formEditFeature').append('<span>'+val.value+'</span>');
			
		});
	});
}
</script>
</html>