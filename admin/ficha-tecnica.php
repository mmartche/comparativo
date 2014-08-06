<?php
//$date = new DateTime();
//$dateTs = $date->getTimestamp();
$dateTs = rand();
?>
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
	<script type="text/javascript" src="scripts/index.js"></script>
	
	<link rel="stylesheet" href="styles//jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="styles/index.css" />

</head>
<body name="searchList">
<?
include ("./scripts/conectDB.php");
include ("./scripts/functions.php");
?>
<div class="body">
	<header>
		<h1 class="logo"><span class="logoText logoRed">Car</span><span class="logoText logoBlack">sale</span></h1>
		<h2>
			<span>Sistema administrativo - Ficha Técnica de Veículos</span><a href='formDetails.php?action=new&category=feature&timestamp=<?=rand()?>' class='btnButton btnNewForm'>Novo Cadastro</a>
			<div class="newChoice">
				<a href="formDetails.php?action=new&category=manufacturer&timestamp=<?=rand()?>" class="btnButton">Nova Montadora</a>
				<a href="formDetails.php?action=new&category=model&timestamp=<?=rand()?>" class="btnButton">Novo Modelo</a>
				<a href="formDetails.php?action=new&category=version&timestamp=<?=rand()?>" class="btnButton">Nova Versão</a>
				<a href="formDetails.php?action=new&category=feature&timestamp=<?=rand()?>" class="btnButton">Nova Ficha Técnica</a>
			</div>
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
	<div class="formSearch">
		<form action="." method="get" >
			<div class="ui-widget">
				<input id="askInput" class="askInput" name="askInput" placeholder="Digite o que quer encontrar" />
				<input id="askType" class="askType" name="askType" />
			</div>
			<div class="ui-widget result-box">
				Result:
				<div id="log" class="ui-widget-content log-box"></div>
			</div>
			<!--div id="resultSearch" class="resultSearch"></div-->
			<input type="submit" value="Buscar" class="btnButton btnSearch" />
		</form>
	</div>
	<div class="content">
		<!--ol class="breadcrumb">
			<li><a href=".">Home</a></li>
			<li><a href="?search=manufacturer">Montadoras</a></li>
			<li><a href="?search=model">Modelos</a></li>
			<li class="active">Versao</li>
		</ol-->
		<div class="resultSearch">
			<ul class="resultList">
				<li class="resultHeader">
				<?
				$queryUrl = "&filterActive=".$_GET[filterActive]."&filterManuf=".$_GET[filterManuf]."&filterModel=".$_GET[filterModel]."&filterVersion=".$_GET[filterVersion]."&filterYearModel=".$_GET[filterYearModel]."&filterYearProduced=".$_GET[filterYearProduced]."&filterEngine=".$_GET[filterEngine]."&filterGear=".$_GET[filterGear]."&filterFuel=".$_GET[filterFuel]."&filterPrice=".$_GET[filterPrice];
				?>
					<div class="rhItems"></div>
					<div class="rhManufacturer">Montadora</div>
					<div class="rhModel">Modelo</div>
					<div class="rhVersion">Versão</div>
					<div class="rhYearModel">AnoModelo</a></div>
					<div class="rhYearProduced">AnoFabricação</a></div>
					<div class="rhEngine">Motor</div>
					<div class="rhGear">Câmbio</div>
					<div class="rhFuel">Combustível</div>
					<div class="rhSteering">Direção</div>
					<div class="rhPrice">Preço</div>
				</li>
				<li class="resultFilter">
					<form action="?filter=true" method="post">
					<div class="rfItems"><input type="checkbox" name="filterActive" id="chkRSActive" 
					<? if ($_POST[filterActive] == "n") echo 'checked="checked"'; ?> 
					value="n" onchange="submit()" style="width:10px;display:none;" />
					<label for="chkRSActive"><? if ($_POST[filterActive] == "n") echo 'Ver Ativados'; else echo 'Ver Desativos'; ?></label>
					</div>
					<div class="rfManufacturer"><input type="text" name="filterManuf" id="txtRSManufacturer" onkeyup="filterFields('rsManufacturer',this)" value="<?=$_POST[filterManuf]?>" /></div>
					<div class="rfModel"><input type="text" name="filterModel" id="txtRSModel" onkeyup="filterFields('rsModel',this)" value="<?=$_POST[filterModel]?>" /></div>
					<div class="rfVersion"><input type="text" name="filterVersion" id="txtRSVersion" onkeyup="filterFields('rsVersion',this)" value="<?=$_POST[filterVersion]?>" /></div>
					<div class="rfYearModel"><input type="text" name="filterYearModel" id="txtRSYearModel" onkeyup="filterFields('rsYearModel',this)" value="<?=$_POST[filterYearModel]?>" /></div>
					<div class="rfYearProduced"><input type="text" name="filterYearProduced" id="txtRSYearProduced" onkeyup="filterFields('rsYearProduced',this)" value="<?=$_POST[filterYearProduced]?>" /></div>
					<div class="rfEngine"><input type="text" name="filterEngine" id="txtRSEngine" onkeyup="filterFields('rsEngine',this)" value="<?=$_POST[filterEngine]?>" /></div>
					<div class="rfGear"><input type="text" name="filterGear" id="txtRSGear" onkeyup="filterFields('rsGear',this)" value="<?=$_POST[filterGear]?>" /></div>
					<div class="rfFuel"><input type="text" name="filterFuel" id="txtRSFuel" onkeyup="filterFields('rsFuel',this)" value="<?=$_POST[filterFuel]?>" /></div>
					<div class="rfSteering"><input type="text" name="filterSteering" id="txtRSSteering" onkeyup="filterFields('rsSteering',this)" value="<?=$_POST[filterSteering]?>" /></div>
					<div class="rfPrice"><input type="text" name="filterPrice" id="txtRSPrice" onkeyup="filterFields('rsPrice',this)" value="<?=$_POST[filterPrice]?>" /></div>
					<div class="rfSubmit"><input type="submit" value="Pesquisar" /></div>
					</form>
				</li>

				<li class="resultData"><ul>
				<?
					if ($_GET[askInput] != "") {
						$sqlTerm = "SELECT manufacturer.id as id, manufacturer.name as manufacturerName FROM manufacturer WHERE name like ('%".$_GET[askInput]."%') ORDER by name";
						$query_search = mysql_query($sqlTerm) or die ($sqlTerm. mysql_error()." error #135");
						while ($res = mysql_fetch_array($query_search)) {
						?>
							<li class="resultItem" idDB="<?=$res[id]?>">
								<div class="rsItems">
									<a class="btnClone btnButton" href="?category=model&action=new&vehicle=<?=$res[id]?>&timestamp=<?=rand()?>" title="Incluir Modelo para esta Montadora" alt="Incluir Modelo para esta Montadora">Novo modelo</a>
									<div class="btnActive" title="Ativo" alt="Ativo" onclick="activeItem(<?=$res[id]?>,'manufacturer',this)"></div>
								</div>
								<a href="formDetails.php?vehicle=<?=$res[id]?>&category=manufacturer&action=update&timestamp=<?=rand()?>" class="resultContent">
									<div class="rsManufacturer" title="<?=$res[manufacturerName]?>"><?=$res[manufacturerName]?></div>
								</a>
							</li>
						<? }
						$sqlTerm = "SELECT manufacturer.name as manufacturerName, model.id as id, model.name as modelName FROM manufacturer, model WHERE model.idManufacturer = manufacturer.id and model.name like ('%".$_GET[askInput]."%') ORDER by manufacturer.name, model.name";
						$query_search = mysql_query($sqlTerm) or die (" error #150");
						while ($res = mysql_fetch_array($query_search)) {
						?>
							<li class="resultItem" idDB="<?=$res[id]?>">
								<div class="rsItems">
									<a class="btnClone btnButton" href="?category=version&action=new&vehicle=<?=$res[id]?>&timestamp=<?=rand()?>" title="Incluir Versão para este Modelo" alt="Incluir Versão para este Modelo">Nova versão</a>
									<div class="btnActive" title="Ativo" alt="Ativo" onclick="activeItem(<?=$res[id]?>,'model',this)"></div>
								</div>
								<a href="formDetails.php?vehicle=<?=$res[id]?>&category=model&action=update&timestamp=<?=rand()?>" class="resultContent">
									<div class="rsManufacturer" title="<?=$res[manufacturerName]?>"><?=$res[manufacturerName]?></div>
									<div class="rsModel" title="<?=$res[modelName]?>"><?=$res[modelName]?></div>
								</a>
							</li>
						<? }
						$sqlTerm = "SELECT manufacturer.name as manufacturerName, model.name as modelName, version.id as id, version.name as versionName  FROM manufacturer, model, version WHERE version.idModel = model.id AND model.idManufacturer = manufacturer.id and version.name like ('%".$_GET[askInput]."%') ORDER by manufacturer.name, model.name, version.name";
						$query_search = mysql_query($sqlTerm) or die (" error #165");
						while ($res = mysql_fetch_array($query_search)) {
						?>
							<li class="resultItem" idDB="<?=$res[id]?>">
								<div class="rsItems">
									<a class="btnClone btnButton" href="?category=feature&action=new&vehicle=<?=$res[id]?>&timestamp=<?=rand()?>" title="Incluir Ficha Técnica para esta Versão" alt="Incluir Ficha Técnica para esta Versão">Nova Ficha</a>
									<div class="btnActive" title="Ativo" alt="Ativo" onclick="activeItem(<?=$res[id]?>,'version',this)"></div>
									<!--div class="rsPicture"><img src="<?=$res[picture]?>+'" /></div-->
								</div>
								<a href="formDetails.php?vehicle=<?=$res[id]?>&category=version&action=update&timestamp=<?=rand()?>" class="resultContent">
									<div class="rsManufacturer" title="<?=$res[manufacturerName]?>"><?=$res[manufacturerName]?></div>
									<div class="rsModel" title="<?=$res[modelName]?>"><?=$res[modelName]?></div>
									<div class="rsVersion" title="<?=$res[versionName]?>"><?=$res[versionName]?></div>
								</a>
							</li>
						<? } 
						$sqlTerm = "SELECT feature.id as id, feature.yearProduced, feature.yearModel, feature.engine, feature.gear, feature.fuel, feature.steering, manufacturer.name as manufacturerName, model.name as modelName, version.name as versionName feature.price FROM manufacturer, model, version, feature WHERE feature.idVersion = version.id AND version.idModel = model.id AND model.idManufacturer = manufacturer.id and (version.name like ('%".$_GET[askInput]."%') or model.name like ('%".$_GET[askInput]."%'))";

						$query_search = mysql_query($sqlTerm) or die (" error #165");
						while ($res = mysql_fetch_array($query_search)) {
						?>
							<li class="resultItem" idDB="<?=$res[id]?>">
								<div class="rsItems">
									<a class="btnClone btnButton" href="formDetails.php?category=feature&action=clone&vehicle=<?=$res[id]?>&timestamp=<?=rand()?>" title="Copiar todos os dados para um novo cadastro" alt="Copiar todos os dados para um novo cadastro">Clonar</a>
									<div class="btnActive" title="Ativo" alt="Ativo" onclick="activeItem(<?=$res[id]?>,'feature',this)"></div>
									<!--div class="rsPicture"><img src="<?=$res[picture]?>+'" /></div-->
								</div>
								<a href="formDetails.php?vehicle=<?=$res[id]?>&category=feature&action=update&timestamp=<?=rand()?>" class="resultContent">
									<div class="rsManufacturer" title="<?=$res[manufacturerName]?>"><?=$res[manufacturerName]?></div>
									<div class="rsModel" title="<?=$res[modelName]?>"><?=utf8_encode($res[modelName])?></div>
									<div class="rsVersion" title="<?=$res[versionName]?>"><?=utf8_encode($res[versionName])?></div>
									<div class="rsYearModel"><?=$res[yearModel]?></div>
									<div class="rsYearProduced"><?=$res[yearProduced]?></div>
									<div class="rsEngine"><?=utf8_encode($res[engine])?></div>
									<div class="rsGear"><?=utf8_encode($res[gear])?></div>
									<div class="rsFuel">
									<?
									switch (strtolower($res[fuel])) {
										case 'g':
											echo "Gasolina";
											break;
										case 'f':
											echo "Flex";
											break;
										case 'e':
											echo "Ethanol";
											break;
										case 'd':
											echo "Diesel";
											break;
										default:
											echo "Outros - ".$res[fuel];
											break;
									}
									?>
									</div>
									<div class="rsSteering"><?=utf8_encode($res[steering])?></div>
									<div class="rsPrice">R$ <?=formatToPrice($res[price])?></div>
								</a>
							</li>
						<? } 
					} else {
						if ($_POST[filterManuf] != "") { $filterSql .= " AND manufacturer.name like ('%".$_POST[filterManuf]."%') "; }
						if ($_POST[filterModel] != "") { $filterSql .= " AND model.name like ('%".$_POST[filterModel]."%') "; }
						if ($_POST[filterVersion] != "") { $filterSql .= " AND version.name like ('%".$_POST[filterVersion]."%') "; }
						if ($_POST[filterYearModel] != "") { $filterSql .= " AND feature.yearModel  like ('%".$_POST[filterYearModel]."%') "; }
						if ($_POST[filterYearProduced] != "") { $filterSql .= " AND feature.yearProduced like ('%".$_POST[filterYearProduced]."%') "; }
						if ($_POST[filterEngine] != "") { $filterSql .= " AND feature.engine like ('%".$_POST[filterEngine]."%') "; }
						if ($_POST[filterGear] != "") { $filterSql .= " AND feature.gear like ('%".$_POST[filterGear]."%') "; }
						if ($_POST[filterFuel] != "") { $filterSql .= " AND feature.fuel like ('%".$_POST[filterFuel]."%') "; }
						if ($_POST[filterPrice] != "") { $filterSql .= " AND feature.price like ('%".$_POST[filterPrice]."%') "; }
						if ($_POST[filterActive] == "n") { $filterSql .= " AND (version.active = 'n' OR feature.active = 'n') "; } else { $filterSql .= " AND (version.active = 's' AND feature.active = 's') "; }
						// if ($_POST[filterActive] == "n") { $filterSql .= " AND (version.active = 'n' OR feature.active = 'n') "; } else { $filterSql .= " AND (version.active != 'n' AND feature.active = 's') "; }

						$sql_search = "SELECT feature.id as id, version.id as versionId, feature.yearProduced, feature.yearModel, feature.engine, feature.gear, feature.fuel, feature.steering, feature.picture, feature.active, feature.active as factive, version.active as vactive, manufacturer.name as manufacturerName, model.name as modelName, version.name as versionName, feature.price FROM manufacturer, model, version, feature WHERE feature.idVersion = version.id AND version.idModel = model.id AND model.idManufacturer = manufacturer.id ".$filterSql." ORDER BY manufacturerName ASC, modelName ASC, versionName ASC, yearProduced desc, yearModel desc";
						//$sql_search = "SELECT manufacturer.id as manufacturerId, manufacturer.name as manufacturerName FROM manufacturer ORDER by name";
						// var_dump($sql_search);

						$query_search = mysql_query($sql_search) or die (mysql_error()." error #180");
						while ($res = mysql_fetch_array($query_search)) {
							//if ($versionTemp == "") { $versionTemp = $res[versionId]; }
							if ($versionTemp != $res[versionId]) {
								$versionTemp = $res[versionId];
						?>
						<li class="resultItem <? if ($res[active] == "n" or $res[vactive] == "n") { echo "desactive"; } ?>" idDB="<?=$res[id]?>">
							<div class="rsItems">
								<a class="btnClone btnButton" href="formDetails.php?category=feature&action=clone&vehicle=<?=$res[id]?>&timestamp=<?=rand()?>" title="Copiar todos os dados para um novo cadastro" alt="Copiar todos os dados para um novo cadastro">Clonar</a>
								<div class="btnActive" title="Ativo" alt="Ativo" onclick="activeItem(<?=$res[id]?>,'feature',this)"></div>
								<!--div class="rsPicture"><img src="<?=$res[picture]?>" /></div-->
							</div>
							<a href="formDetails.php?vehicle=<?=$res[id]?>&category=feature&action=update&timestamp=<?=rand()?>" class="resultContent">
								<div class="rsManufacturer" title="<?=$res[manufacturerName]?>"><?=$res[manufacturerName]?></div>
								<div class="rsModel" title="<?=$res[modelName]?>"><?=utf8_encode($res[modelName])?></div>
								<div class="rsVersion" title="<?=$res[versionName]?>"><?=utf8_encode($res[versionName])?></div>
								<div class="rsYearModel"><?=$res[yearModel]?></div>
								<div class="rsYearProduced"><?=$res[yearProduced]?></div>
								<div class="rsEngine"><?=utf8_encode($res[engine])?></div>
								<div class="rsGear"><?=utf8_encode($res[gear])?></div>
								<div class="rsFuel">
								<?
									switch (strtolower($res[fuel])) {
										case 'g':
											echo "Gasolina";
											break;
										case 'f':
											echo "Flex";
											break;
										case 'e':
											echo "Ethanol";
											break;
										case 'd':
											echo "Diesel";
											break;
										default:
											echo "Outros - ".$res[fuel];
											break;
									}
									?>
									</div>
								<div class="rsSteering"><?=utf8_encode($res[steering])?></div>
								<div class="rsPrice">R$ <?=formatToPrice($res[price])?></div>
							</a>
						</li>
						<? } }
					} ?>
				</ul></li>
			</ul>
		</div>
	</div>
	<footer>
		Copyright 2013 carsale.com.br - Todos os direitos reservados
	</footer>
</div>

</body>
</html>