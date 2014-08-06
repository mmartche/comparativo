<?
include ("scripts/checkPermissions.php");
include("./scripts/conectDB.php");
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Carsale Administrativo</title>

	<script type="text/javascript" src="scripts/jquery.2.9.3.min.js"></script>
	<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
	<script type="text/javascript" src="scripts/jquery-ui.js"></script>
	<script type="text/javascript" src="scripts/colorpicker.js"></script>
	<script type="text/javascript" src="scripts/index.js"></script>
	
	<link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="styles/colorpicker.css" />
	
	<link rel="stylesheet" type="text/css" href="styles/index.css" />
	<link rel="stylesheet" type="text/css" href="styles/formDetails.css" />

</head>
<body name="formDetails">
<?
switch ($_GET[search]) {
	case 'manufacturer':
		$sql_search = "select id as manufacturerId, name as manufacturerName from manufacturer where id = '".$_GET[vehicle]."'";
		break;
	case 'model':
		$sql_search = "select model.id as modelId, model.name as modelName, manufacturer.id as manufacturerId, manufacturer.name as manufacturerName from model, manufacturer where model.idManufacturer = manufacturer.id and model.id = '".$_GET[vehicle]."'";
		break;
	default:
		$sql_search = "select feature.id as idFeature, feature.idManufacturer as manufacturerId, feature.idModel as idModel, feature.idVersion as idVersion, manufacturer.name as manufacturerName, manufacturer.description as manufacturerDescription, model.name as modelName, model.description as modelDescription, version.name as versionName, version.description as versionDescription, version.idSegment1, feature.id as id, feature.idManufacturer as manufacturerId, feature.idModel modelId, feature.idVersion versionId, feature.yearProduced, feature.yearModel, feature.doors, feature.passagers, feature.engine, feature.feeding, feature.fuel, feature.powerMax, feature.torque, feature.acceleration, feature.speedMax, feature.consumptionCity, feature.consumptionRoad, feature.gear, feature.traction, feature.wheels, feature.frontSuspension, feature.rearSuspension, feature.frontBrake, feature.rearBrake, feature.dimensionLength, feature.dimensionWidth, feature.dimensionHeight, feature.dimensionSignAxes, feature.weight, feature.trunk, feature.tank, feature.warranty, feature.countryOrigin, feature.dualFrontAirBag, feature.alarm, feature.airConditioning, feature.hotAir, feature.leatherSeat, feature.heightAdjustment, feature.rearSeatSplit, feature.bluetoothSpeakerphone, feature.bonnetSea, feature.onboardComputer, feature.accelerationCounter, feature.rearWindowDefroster, feature.steering, feature.sidesteps, feature.fogLamps, feature.xenonHeadlights, feature.absBrake, feature.integratedGPSPanel, feature.rearWindowWiper, feature.bumper, feature.autopilot, feature.bucketProtector, feature.roofRack, feature.cdplayerWithUSBInput, feature.headlightsHeightAdjustment, feature.rearviewElectric, feature.alloyWheels, feature.rainSensor, feature.parkingSensor, feature.isofix, feature.sunroof, feature.electricLock, feature.electricWindow, feature.rearEletricWindow, feature.steeringWheelAdjustment, feature.active, feature.dateCreate, feature.dateUpdate from feature, manufacturer, model, version where feature.idManufacturer = manufacturer.id and feature.idModel = model.id and feature.idVersion = version.id  and feature.id = '".$_GET[vehicle]."'";
		break;
}

$query_search = mysql_query($sql_search) or die (mysql_error()." error 79");
$res = mysql_fetch_array($query_search);
?>
<div class="body">
	<header>
		<div class="menu">
			<ul>
				<li><a href=".">Home</a></li>
				<li><a href=".">Home</a></li>
				<li><a href=".">Home</a></li>
				<li><a href=".">Home</a></li>
			</ul>
		</div>
		<h1>Sistema administrativo - Detalhes do veículo</h1>
	</header>
	<div class="formSearch">
		<form action="" method="post" onsubmit="return false" >
			<div class="ui-widget">
				<input id="askInput" class="askInput" placeholder="Search by version, vehicle, manufacturer" />
			</div>
			<div class="ui-widget result-box">
				Result:
				<!--div id="log" class="ui-widget-content log-box"></div-->
			</div>
			<div id="resultSearch" class="resultSearch"></div>
		</form>
	</div>
	<div class="content">
		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<?
			switch ($_GET[search]) {
				case 'manufacturer':
					?><li class="active"><?=$res[manufacturerName]?></li><?
					break;
				case 'model':
					?><li><a href="?search=manufacturer"><?=$res[manufacturerName]?></a></li><li class="active"><?=$res[modelName]?></li><?
					break;
				default:
					?><li><a href="?search=manufacturer"><?=$res[manufacturerName]?></a><li><a href="?search=model"><?=$res[modelName]?></a></li><li class="active"><?=$res[versionName]?></li><?
					break;
			}
			?>
		</ol>
		<form action="scripts/updateDBFeature.php" method="post" onsubmit="">
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="idFeature" value="<?=$res[idFeature]?>" />
		<input type="hidden" name="manufacturerId" value="<?=$res[manufacturerId]?>" />
		<input type="hidden" name="idModel" value="<?=$res[idModel]?>" />
		<input type="hidden" name="idVersion" value="<?=$res[idVersion]?>" />
		<div class="dataContent">
			<div class="dataColLeft">
			<?
			//////// filtros dos inputs
			switch ($_GET[search]) {
				case 'manufacturer':
					?>
					<span><label>Montadora:</label><input type="text" name="manufaturerName" id="txtManufacturerName" value="<?=$res[manufacturerName]?>" /></span><br />
					<?
					break;
				case 'model':
					?>
					<span><label>Montadora:</label><input type="text" name="manufaturerName" id="txtManufacturerName" value="<?=$res[manufacturerName]?>" /></span><br />
					<span><label>Modelo:</label><input type="text" name="modelName" id="txtModelName" value="<?=$res[modelName]?>" /></span><br />
					<?
					break;
				default:
				?>
				<span><label>Montadora:</label><input type="text" name="manufaturerName" id="txtManufacturerName" value="<?=$res[manufacturerName]?>" /></span><br />
				<span><label>Modelo:</label><input type="text" name="modelName" id="txtModelName" value="<?=$res[modelName]?>" /></span><br />
				<span><label>Versão:</label><input type="text" name="versionName" id="txtVersionName" value="<?=$res[versionName]?>" /></span><br />
				<span><label>Ano do Modelo:</label><input type="text" name="yearProduced" id="txtYearProduced" value="<?=$res[yearProduced]?>" /></span><br />
				<span><label>Ano de Produção:</label><input type="text" name="yearModel" id="txtYearProduced" value="<?=$res[yearModel]?>" /></span><br />
				<span><label>Quantidade de portas:</label><input type="text" name="doors" id="txtDoors" value="<?=$res[doors]?>" /></span><br />
				<span><label>Quantidade de ocupantes:</label><input type="text" name="passagers" id="txtPassagers" value="<?=$res[passagers]?>" /></span><br />
				<span><label>Motor:</label><input type="text" name="engine" id="txtEngine" value="<?=$res[engine]?>" /></span><br />
				<span><label>Alimentação:</label><input type="text" name="feeding" id="txtFeeding"  value="<?=$res[feeding]?>" /></span><br />
				<span><label>Combustível:</label><input type="text" name="fuel" id="txtFuel" value="<?=$res[fuel]?>" /></span><br />
				<span><label>Potência máxima:</label><input type="text" name="powerMax" id="txtPowerMax" value="<?=$res[powerMax]?>" /></span><br />
				<span><label>Torque:</label><input type="text" name="torque" id="txtTorque" value="<?=$res[torque]?>" /></span><br />
				<span><label>Aceleração:</label><input type="text" name="acceleration" id="txtAcceleration" value="<?=$res[acceleration]?>" /></span><br />
				<span><label>Velocidade máxima (km/h):</label><input type="text" name="speedMax" id="txtSpeedMax" value="<?=$res[speedMax]?>" /></span><br />
				<span><label>Consumo (km/l) na cidade:</label><input type="text" name="consumptionCity" id="txtConsumptionCity" value="<?=$res[consumptionCity]?>" /></span><br />
				<span><label>Consumo (km/l) na estrada:</label><input type="text" name="consumptionRoad" id="txtConsumptionRoad" value="<?=$res[consumptionRoad]?>" /></span><br />
				<span><label>Câmbio:</label><input type="text" name="gear" id="txtGear" value="<?=$res[gear]?>" /></span><br />
				<span><label>Tração:</label><input type="text" name="traction" id="txtTraction" value="<?=$res[traction]?>" /></span><br />
				<span><label>Rodas:</label><input type="text" name="wheels" id="txtWheels" value="<?=$res[wheels]?>" /></span><br />
				<span><label>Suspensão dianteira:</label><input type="text" name="frontSuspension" id="txtFrontSuspension" value="<?=$res[frontSuspension]?>" /></span><br />
				<span><label>Suspensão traseira:</label><input type="text" name="rearSuspension" id="txtRearSuspension" value="<?=$res[rearSuspension]?>" /></span><br />
				<span><label>Freio dianteiro:</label><input type="text" name="frontBrake" id="txtFrontBrake" value="<?=$res[frontBrake]?>" /></span><br />
				<span><label>Freio traseiro:</label><input type="text" name="rearBrake" id="txtRearBrake" value="<?=$res[rearBrake]?>" /></span><br />
				<span><label>Dimensão (mm):</label></span><br />
				<span><label>-Comprimento:</label><input type="text" name="dimensionLength" id="txtDimensionLength" value="<?=$res[dimensionLength]?>" /></span><br />
				<span><label>-Largura:</label><input type="text" name="dimensionWidth" id="txtDimensionWidth" value="<?=$res[dimensionWidth]?>" /></span><br />
				<span><label>-Altura:</label><input type="text" name="dimensionHeight" id="txtDimensionHeight" value="<?=$res[dimensionHeight]?>" /></span><br />
				<span><label>-Entre eixos:</label><input type="text" name="dimensionSignAxes" id="txtDimensionSignAxes" value="<?=$res[dimensionSignAxes]?>" /></span><br />
				<span><label>Peso (kg):</label><input type="text" name="weight" id="txtHeight" value="<?=$res[weight]?>" /></span><br />
				<span><label>Porta malas (litros):</label><input type="text" name="trunk" id="txtTrunk" value="<?=$res[trunk]?>" /></span><br />
				<span><label>Tanque (litros):</label><input type="text" name="tank" id="txtTank" value="<?=$res[tank]?>" /></span><br />
				<span><label>Garantia:</label><input type="text" name="warranty" id="txtWarranty" value="<?=$res[warranty]?>" /></span><br />
				<span><label>País de orígem:</label><input type="text" name="countryOrigin" id="txtCountryOrigin" value="<?=$res[countryOrigin]?>" /></span><br />
				<?	
					break;
			}
			?>
			</div>
			<div class="dataColRight">
			<?
			if ($_GET[search] != "manufacturer" && $_GET[search] != "model") {
			?>
				<div class="dataFeatures dataFields">
					<label>ACESSÓRIOS</label>
					<div class="optionsVersions optionsFields">
						<span>
							<input type="radio" name="dualFrontAirBag" value="s" <? if ($res[dualFrontAirBag] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="dualFrontAirBag" value="o" <? if ($res[dualFrontAirBag] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="dualFrontAirBag" value="n" <? if ($res[dualFrontAirBag] == "n") { echo 'checked="true"'; } ?>  /> 
							Airbag duplo frontal
						</span>
						<span>
							<input type="radio" name="alarm" value="s" <? if ($res[alarm] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="alarm" value="o" <? if ($res[alarm] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="alarm" value="n" <? if ($res[alarm] == "n") { echo 'checked="true"'; } ?> />
							Alarme
						</span>
						<span>
							<input type="radio" name="airConditioning" value="s" <? if ($res[airConditioning] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="airConditioning" value="o" <? if ($res[airConditioning] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="airConditioning" value="n" <? if ($res[airConditioning] == "n") { echo 'checked="true"'; } ?> />
							Ar condicionado</span>
						<span>
							<input type="radio" name="hotAir" value="s" <? if ($res[hotAir] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="hotAir" value="o" <? if ($res[hotAir] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="hotAir" value="n" <? if ($res[hotAir] == "n") { echo 'checked="true"'; } ?> />
							Ar quente</span>
						<span>
							<input type="radio" name="leatherSeat" value="s" <? if ($res[leatherSeat] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="leatherSeat" value="o" <? if ($res[leatherSeat] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="leatherSeat" value="n" <? if ($res[leatherSeat] == "n") { echo 'checked="true"'; } ?> />
							Banco de couro</span>
						<span>
							<input type="radio" name="heightAdjustment" value="s" <? if ($res[heightAdjustment] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="heightAdjustment" value="o" <? if ($res[heightAdjustment] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="heightAdjustment" value="n" <? if ($res[heightAdjustment] == "n") { echo 'checked="true"'; } ?> />
							Banco do motorista com regulagem de altura</span>
						<span>
							<input type="radio" name="rearSeatSplit" value="s" <? if ($res[rearSeatSplit] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearSeatSplit" value="o" <? if ($res[rearSeatSplit] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearSeatSplit" value="n" <? if ($res[rearSeatSplit] == "n") { echo 'checked="true"'; } ?> />
							Banco traseiro bipartido</span>
						<span>
							<input type="radio" name="bluetoothSpeakerphone" value="s" <? if ($res[bluetoothSpeakerphone] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="bluetoothSpeakerphone" value="o" <? if ($res[bluetoothSpeakerphone] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="bluetoothSpeakerphone" value="n" <? if ($res[bluetoothSpeakerphone] == "n") { echo 'checked="true"'; } ?> />
							Bluetooth com viva-voz</span>
						<span>
							<input type="radio" name="bonnetSea" value="s" <? if ($res[bonnetSea] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="bonnetSea" value="o" <? if ($res[bonnetSea] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="bonnetSea" value="n" <? if ($res[bonnetSea] == "n") { echo 'checked="true"'; } ?> />
							Capota marítima</span>
						<span>
							<input type="radio" name="onboardComputer" value="s" <? if ($res[onboardComputer] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="onboardComputer" value="o" <? if ($res[onboardComputer] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="onboardComputer" value="n" <? if ($res[onboardComputer] == "n") { echo 'checked="true"'; } ?> />
							Computador de bordo</span>
						<span>
							<input type="radio" name="accelerationCounter" value="s" <? if ($res[accelerationCounter] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="accelerationCounter" value="o" <? if ($res[accelerationCounter] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="accelerationCounter" value="n" <? if ($res[accelerationCounter] == "n") { echo 'checked="true"'; } ?> />
							Conta giros</span>
						<span>
							<input type="radio" name="rearWindowDefroster" value="s" <? if ($res[rearWindowDefroster] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearWindowDefroster" value="o" <? if ($res[rearWindowDefroster] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearWindowDefroster" value="n" <? if ($res[rearWindowDefroster] == "n") { echo 'checked="true"'; } ?> />
							Desembaçador de vidro traseiro</span>
						<span>
							<input type="radio" name="steering" value="s" <? if ($res[steering] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="steering" value="o" <? if ($res[steering] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="steering" value="n" <? if ($res[steering] == "n") { echo 'checked="true"'; } ?> />
							Direção hidráulica</span>
						<span>
							<input type="radio" name="sidesteps" value="s" <? if ($res[sidesteps] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="sidesteps" value="o" <? if ($res[sidesteps] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="sidesteps" value="n" <? if ($res[sidesteps] == "n") { echo 'checked="true"'; } ?> />
							Estribos laterais</span>
						<span>
							<input type="radio" name="fogLamps" value="s" <? if ($res[fogLamps] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="fogLamps" value="o" <? if ($res[fogLamps] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="fogLamps" value="n" <? if ($res[fogLamps] == "n") { echo 'checked="true"'; } ?> />
							Faróis de neblina/milha</span>
						<span>
							<input type="radio" name="xenonHeadlights" value="s" <? if ($res[xenonHeadlights] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="xenonHeadlights" value="o" <? if ($res[xenonHeadlights] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="xenonHeadlights" value="n" <? if ($res[xenonHeadlights] == "n") { echo 'checked="true"'; } ?> />
							Faróis xenon</span>
						<span>
							<input type="radio" name="absBrake" value="s" <? if ($res[absBrake] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="absBrake" value="o" <? if ($res[absBrake] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="absBrake" value="n" <? if ($res[absBrake] == "n") { echo 'checked="true"'; } ?> />
							Freios Abs</span>
						<span>
							<input type="radio" name="integratedGPSPanel" value="s" <? if ($res[integratedGPSPanel] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="integratedGPSPanel" value="o" <? if ($res[integratedGPSPanel] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="integratedGPSPanel" value="n" <? if ($res[integratedGPSPanel] == "n") { echo 'checked="true"'; } ?> />
							GPS integrado ao painel</span>
						<span>
							<input type="radio" name="rearWindowWiper" value="s" <? if ($res[rearWindowWiper] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearWindowWiper" value="o" <? if ($res[rearWindowWiper] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearWindowWiper" value="n" <? if ($res[rearWindowWiper] == "n") { echo 'checked="true"'; } ?> />
							Limpador de vidro traseiro</span>
						<span>
							<input type="radio" name="bumper" value="s" <? if ($res[bumper] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="bumper" value="o" <? if ($res[bumper] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="bumper" value="n" <? if ($res[bumper] == "n") { echo 'checked="true"'; } ?> />
							Para choque na cor do veículo</span>
						<span>
							<input type="radio" name="autopilot" value="s" <? if ($res[autopilot] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="autopilot" value="o" <? if ($res[autopilot] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="autopilot" value="n" <? if ($res[autopilot] == "n") { echo 'checked="true"'; } ?> />
							Piloto automático</span>
						<span>
							<input type="radio" name="bucketProtector" value="s" <? if ($res[bucketProtector] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="bucketProtector" value="o" <? if ($res[bucketProtector] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="bucketProtector" value="n" <? if ($res[bucketProtector] == "n") { echo 'checked="true"'; } ?> />
							Protetor de caçamba</span>
						<span>
							<input type="radio" name="roofRack" value="s" <? if ($res[roofRack] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="roofRack" value="o" <? if ($res[roofRack] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="roofRack" value="n" <? if ($res[roofRack] == "n") { echo 'checked="true"'; } ?> />
							Rack de teto</span>
						<span>
							<input type="radio" name="cdplayerWithUSBInput" value="s" <? if ($res[cdplayerWithUSBInput] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="cdplayerWithUSBInput" value="o" <? if ($res[cdplayerWithUSBInput] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="cdplayerWithUSBInput" value="n" <? if ($res[cdplayerWithUSBInput] == "n") { echo 'checked="true"'; } ?> />
							Radio cd player com entrada USB</span>
						<span>
							<input type="radio" name="headlightsHeightAdjustment" value="s" <? if ($res[headlightsHeightAdjustment] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="headlightsHeightAdjustment" value="o" <? if ($res[headlightsHeightAdjustment] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="headlightsHeightAdjustment" value="n" <? if ($res[headlightsHeightAdjustment] == "n") { echo 'checked="true"'; } ?> />
							Regulagem de altura dos faróis</span>
						<span>
							<input type="radio" name="rearviewElectric" value="s" <? if ($res[rearviewElectric] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearviewElectric" value="o" <? if ($res[rearviewElectric] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearviewElectric" value="n" <? if ($res[rearviewElectric] == "n") { echo 'checked="true"'; } ?> />
							Retrovisor elétrico</span>
						<span>
							<input type="radio" name="alloyWheels" value="s" <? if ($res[alloyWheels] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="alloyWheels" value="o" <? if ($res[alloyWheels] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="alloyWheels" value="n" <? if ($res[alloyWheels] == "n") { echo 'checked="true"'; } ?> />
							Rodas de liga leve</span>
						<span>
							<input type="radio" name="rainSensor" value="s" <? if ($res[rainSensor] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rainSensor" value="o" <? if ($res[rainSensor] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rainSensor" value="n" <? if ($res[rainSensor] == "n") { echo 'checked="true"'; } ?> />
							Sensor de chuva</span>
						<span>
							<input type="radio" name="parkingSensor" value="s" <? if ($res[parkingSensor] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="parkingSensor" value="o" <? if ($res[parkingSensor] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="parkingSensor" value="n" <? if ($res[parkingSensor] == "n") { echo 'checked="true"'; } ?> />
							Sensor de estacionamento</span>
						<span>
							<input type="radio" name="isofix" value="s" <? if ($res[isofix] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="isofix" value="o" <? if ($res[isofix] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="isofix" value="n" <? if ($res[isofix] == "n") { echo 'checked="true"'; } ?> />
							Sistema Isofix para cadeira de criança</span>
						<span>
							<input type="radio" name="sunroof" value="s" <? if ($res[sunroof] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="sunroof" value="o" <? if ($res[sunroof] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="sunroof" value="n" <? if ($res[sunroof] == "n") { echo 'checked="true"'; } ?> />
							Teto solar</span>
						<span>
							<input type="radio" name="electricLock" value="s" <? if ($res[electricLock] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="electricLock" value="o" <? if ($res[electricLock] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="electricLock" value="n" <? if ($res[electricLock] == "n") { echo 'checked="true"'; } ?> />
							Trava elétrica</span>
						<span>
							<input type="radio" name="electricWindow" value="s" <? if ($res[electricWindow] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="electricWindow" value="o" <? if ($res[electricWindow] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="electricWindow" value="n" <? if ($res[electricWindow] == "n") { echo 'checked="true"'; } ?> />
							Vidro elétrico</span>
						<span>
							<input type="radio" name="rearEletricWindow" value="s" <? if ($res[rearEletricWindow] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearEletricWindow" value="o" <? if ($res[rearEletricWindow] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="rearEletricWindow" value="n" <? if ($res[rearEletricWindow] == "n") { echo 'checked="true"'; } ?> />
							Vidro elétrico traseiro</span>
						<span>
							<input type="radio" name="steeringWheelAdjustment" value="s" <? if ($res[steeringWheelAdjustment] == "s") { echo 'checked="true"'; } ?> />
							<input type="radio" name="steeringWheelAdjustment" value="o" <? if ($res[steeringWheelAdjustment] == "o") { echo 'checked="true"'; } ?> />
							<input type="radio" name="steeringWheelAdjustment" value="n" <? if ($res[steeringWheelAdjustment] == "n") { echo 'checked="true"'; } ?> />
							Volante com regulagem de altura</span>
					</div>
				</div>
				<? } ?>
				<?
				if ($_GET[search] != "manufacturer") {
				$iOpt = 0;
				$sqlOpt = "select * from optionsVersion where idFeature = '".$res[idFeature]."'";
				$queryOpt = mysql_query($sqlOpt) or die (" error #300");
				$lengthOpt = mysql_num_rows($queryOpt);
				?>
				<div class="dataOptions dataFields">
					<label>OPCIONAIS (itens de série)</label>
					<div id="optionsOptions" class="optionsOptions optionsFields">
						<span>insira novos itens sepando a cada linha</span>
						<span>
							<textarea name="textAreaOptionsAdd" id="textAreaOptionsAdd" style="width:95%"></textarea>
							<input type="radio" name="rdOptionsAdd" value="s" />Série
							<input type="radio" name="rdOptionsAdd" value="o" />Opcional
							<input type="radio" name="rdOptionsAdd" value="n" />N/D
							<input type="button" id="btnOptionsAdd" value="+" />
							<input type="hidden" name="lengthOptions" value="<?=$lengthOpt?>" id="lengthOptions" />
							<!--CHECK HOW MANY FIELDS AFTER SUBMIT AND W/ ADD SCRIPT -->
						</span>
						<label>Opcionais referente a este modelo</label><br />
						<?
						while ($resOpt = mysql_fetch_array($queryOpt)) {
							?>
							<span>
								<input type="radio" name="rdOpt<?=$iOpt?>" value="s" <? if ($resOpt[option] == "s") { echo 'checked="checked"'; } ?> />
								<input type="radio" name="rdOpt<?=$iOpt?>" value="o" <? if ($resOpt[option] == "o") { echo 'checked="checked"'; } ?> />
								<input type="radio" name="rdOpt<?=$iOpt?>" value="n" <? if ($resOpt[option] == "n") { echo 'checked="checked"'; } ?> />
								<input type="hidden" name="txtOpt<?=$iOpt?>" value="<?=$resOpt[description]?>" />
							<?=$resOpt[description]?></span>
							<?
							$iOpt++;
						}
						?>
					</div>
				</div>
				<? } ?>
				<? //ITEMS DE SERIE E ITEMS OPCIONAIS COM 2 INPUTS ?>
				<div class="dataOptions dataFields">
					<label>OPCIONAIS (itens de série)</label>
					<div id="optionsOptions" class="optionsOptions optionsFields">
						<span>insira novos itens sepando a cada linha</span>
						<span>
							<textarea name="textAreaOptionsAdd" id="textAreaOptionsAdd" style="width:95%"></textarea>
							<input type="radio" name="rdOptionsAdd" value="s" />Série
							<input type="radio" name="rdOptionsAdd" value="o" />Opcional
							<input type="radio" name="rdOptionsAdd" value="n" />N/D
							<input type="button" id="btnOptionsAdd" value="+" />
							<input type="hidden" name="lengthOptions" value="<?=$lengthOpt?>" id="lengthOptions" />
							<!--CHECK HOW MANY FIELDS AFTER SUBMIT AND W/ ADD SCRIPT -->
						</span>
						<label>Opcionais referente a este modelo</label><br />
						<?
						while ($resOpt = mysql_fetch_array($queryOpt)) {
							?>
							<span>
								<input type="radio" name="rdOpt<?=$iOpt?>" value="s" <? if ($resOpt[option] == "s") { echo 'checked="checked"'; } ?> />
								<input type="radio" name="rdOpt<?=$iOpt?>" value="o" <? if ($resOpt[option] == "o") { echo 'checked="checked"'; } ?> />
								<input type="radio" name="rdOpt<?=$iOpt?>" value="n" <? if ($resOpt[option] == "n") { echo 'checked="checked"'; } ?> />
								<input type="hidden" name="txtOpt<?=$iOpt?>" value="<?=$resOpt[description]?>" />
							<?=$resOpt[description]?></span>
							<?
							$iOpt++;
						}
						?>
					</div>
				</div>
				<?
				$iColor = 0;
				$sqlColor = "select * from colorModel where idModel = '".$res[idModel]."'";
				$queryColor = mysql_query($sqlColor) or die (" error #330");
				$lengthColor = mysql_num_rows($queryColor);
				?>
				<div class="dataColor dataFields">
					<label>CORES DISPONÍVEIS</label>
					<div class="optionsColor optionsFields" id="optionsColor">
						<span>
							<div id="colorSelector" class="divColor"><div></div></div>
							<input type="text" id="colorSelected" placeholder="cor em hexa" />
							<input type="text" id="colorName" placeholder="nome" />
							<input type="text" id="colorType" placeholder="tipo" />
							<input type="text" id="colorAplication" placeholder="aplicação" />
							<input type="button" value="+" id="btnColorAdd" />
							<input type="hidden" id="colorLength" name="colorLength" value="<?=$lengthColor?>" />
						</span>
						<? while ($resColor = mysql_fetch_array($queryColor)) { ?>
						<span><div class="delColor" onclick="deleteColor(this)">X</div><div class="divColor"><div style="background-color: #<?=$resColor[hexa]?>;"></div></div><?=$resColor[name]." - ".$resColor[type]." - ".$resColor[application]?>
						<input type="hidden" name="colorInputName<?=$iColor?>" value="<?=$resColor[name]?>" />
						<input type="hidden" name="colorInputColor<?=$iColor?>" value="<?=$resColor[hexa]?>" />
						<input type="hidden" name="colorInputApp<?=$iColor?>" value="<?=$resColor[application]?>" />
						<input type="hidden" name="colorInputType<?=$iColor?>" value="<?=$resColor[type]?>" /></span>
						<?
						$iColor++;
						}
						?>
					</div>
				</div>
				<? if ($_GET[search] != "manufacturer" && $_GET[search] != "model") { ?>
				<div class="dataPicture dataFields">
					<label>FOTOS</label>
					<div class="optionsPicture optionsFields">
						<span>Insira uma nova foto</span>
						<input type="text"><input type="button" value="pesquisar"><br />
						<input type="button" value="+">
						<ol class="listPictures">
							<li>
								<input type="checkbox" />
								<div class="btnDeletePicture"></div>
								<img src="#" />
							</li>
							<li>
								<input type="checkbox" />
								<div class="btnDeletePicture"></div>
								<img src="#" />
							</li>
							<li>
								<input type="checkbox" />
								<div class="btnDeletePicture"></div>
								<img src="#" />
							</li>
						</ol>
					</div>
				</div>
				<? } ?>
			</div>
		</div>
		<div class="divSave">
			<input type="submit" value="SALVAR" class="btnSave">
		</div>
		</form>
		<div class="relations">
			<span>Itens relacionados</span>
			<div class="dataRelationsFooter"></div>
			<div class="resultSearch">
				<ul class="resultList">
					<li class="resultHeader">
						<div class="rsItems"></div>
						<div class="rsManufacturer">Montadora</div>
						<div class="rsModel">Modelo</div>
						<div class="rsVersion">Versão</div>
						<div class="rsYear">Ano</div>
						<div class="rsOptions">Opcionais</div>
						<div class="rsPicture">Foto</div>
						<div class="rsSegment">Segmento</div>
						<div class="rsGear">Câmbio</div>
						<div class="rsOil">Combustível</div>
						<div class="rsAvaliable">Disponível</div>
					</li>
					<li class="resultFilter">
					<div class="rsItems"></div>
						<div class="rsManufacturer"><input type="text" id="txtRSManufacturer" /></div>
						<div class="rsModel"><input type="text" id="txtRSModel" /></div>
						<div class="rsVersion"><input type="text" id="txtRSVersion" /></div>
						<div class="rsYear"><input type="text" id="txtRSYear" /></div>
						<div class="rsOptions"><input type="text" id="txtRSOptions" /></div>
						<div class="rsPicture"><input type="text" id="txtRSPicture" /></div>
						<div class="rsSegment"><input type="text" id="txtRSSegment" /></div>
						<div class="rsGear"><input type="text" id="txtRSGear" /></div>
						<div class="rsOil"><input type="text" id="txtRSOil" /></div>
						<div class="rsAvaliable"><input type="text" id="txtRSAvaliable" /></div>
					</li>
					<li class="resultContent">
						<div class="rsItems">
							<div class="btnEdit"></div>
							<div class="btnDelete"></div>
							<div class="btnClone"></div>
							<div class="btnActive"></div>
						</div>
						<div class="rsManufacturer">Fiat</div>
						<div class="rsModel">Uno</div>
						<div class="rsVersion">Mille</div>
						<div class="rsYear">2010</div>
						<div class="rsOptions">Opcionais</div>
						<div class="rsPicture">Foto</div>
						<div class="rsSegment">Carro</div>
						<div class="rsGear">Manual</div>
						<div class="rsOil">Gasolina</div>
						<div class="rsAvaliable">Sim</div>
					</li>
					<li class="resultContent">
						<div class="rsItems">
							<div class="btnEdit"></div>
							<div class="btnDelete"></div>
							<div class="btnClone"></div>
							<div class="btnActive"></div>
						</div>
						<div class="rsManufacturer">Fiat</div>
						<div class="rsModel">Uno</div>
						<div class="rsVersion">Mille</div>
						<div class="rsYear">2010</div>
						<div class="rsOptions">Opcionais</div>
						<div class="rsPicture">Foto</div>
						<div class="rsSegment">Carro</div>
						<div class="rsGear">Manual</div>
						<div class="rsOil">Gasolina</div>
						<div class="rsAvaliable">Sim</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
<footer>Copyright</footer>
</div>
</body>
</html>