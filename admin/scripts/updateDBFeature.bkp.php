<<<<<<< HEAD
<?
header('Content-Type: text/html; charset=utf-8');
include ("checkPermissions.php");
include("conectDB.php");

function uploadFile ($manufacturerName,$modelName,$versionName,$featureId) {
	var_dump($_FILES["file"]);
	echo "<br>#7 upload data<br>";
	var_dump($_FILES["image"]);
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& in_array($extension, $allowedExts)) {
	// && ($_FILES["file"]["size"] < 20000) ==> check the file size
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		} else {
			// $_FILES["file"]["name"] = $manufacturerName.".".end($temp);
			// $_FILES["file"]["name"] = str_replace($_FILES["file"]["name"], "%20", "-");
			// $_FILES["file"]["name"] = $manufacturerName."-".$modelName."-".$versionName."-".$featureId.".".end($temp);
			$_FILES["file"]["name"] = "imagemmarcelo.".end($temp);
			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			echo "Type: " . $_FILES["file"]["type"] . "<br>";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
				if (file_exists("../../carImages/" . $_FILES["file"]["name"])) {
					echo $_FILES["file"]["name"] . " already exists. ";
				} else {
					move_uploaded_file($_FILES["file"]["tmp_name"],
					"../../carImages/" . $_FILES["file"]["name"]);
					echo "Stored in: " . "../../carImages/" . $_FILES["file"]["name"];
					return $_FILES["file"]["name"];
				}
		}
	} else {
		echo "Invalid file";
	}
}

switch ($_POST[action]) {
	case 'update':
	switch ($_POST[category]) {
		case 'manufacturer':
			$sqlUpdate = "UPDATE `manufacturer` SET `name` = '".$_POST[manufacturerName]."', `description` = '".$_POST[description]."' WHERE `id` = '".$_POST[manufacturerId]."'";
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpdate) or die (" error #10");
			echo "<br />#45".$sqlUpdate;
		break;
		case 'model':
			if ($_POST[modelId] == "") {
				$sqlUpdate = "INSERT INTO `model` ('idManufacturer', 'modelName', 'idSegment1', 'idSegment2', 'idSegment3', 'description') VALUES ('".$_POST[idManufacturer]."','".$_POST[modelName]."','".$_POST[txtidSegment1]."','".$_POST[txtidSegment2]."','".$_POST[txtidSegment3]."','".$_POST[description]."')";
			} else {
				$sqlUpdate = "UPDATE `model` SET `idManufacturer` = '".$_POST[manufacturerId]."', `name` = '".$_POST[modelName]."', `idSegment1` = '".$_POST[txtidSegment1]."' ,`idSegment2` = '".$_POST[txtidSegment2]."' ,`idSegment3` = '".$_POST[txtidSegment3]."' ,`description` = '".$_POST[description]."' WHERE `id` = ".$_POST[modelId]."";
			}
			echo $sqlUpdate;
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpdate) or die (" error #55");
			echo "<br />#55".$sqlUpdate;
		break;
		case 'version':
			if ($_POST[versionId] == "") {
				$sqlUpdate = "INSERT into `version` (`idManufacturer`, `idModel`, `name`) VALUES ('".$_POST[manufacturerId]."', '".$_POST[modelId]."', '".$_POST[versionName]."')";
			} else {
				$sqlUpdate = "UPDATE `version` SET `idManufacturer` = '".$_POST[manufacturerId]."', `idModel` = '".$_POST[modelId]."', `name` = '".$_POST[versionName]."', `description` = '".$_POST[description]."' WHERE `id` = '".$_POST[versionId]."'";
			}
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpdate) or die (mysql_error()." error #20");
			echo "<br />#60".$sqlUpdate;
		break;
		case 'feature':
			if ($_POST[manufacturerId] != "") {
				$sqlUpdate = "UPDATE `manufacturer` SET `name` = '".$_POST[manufacturerName]."', `description` = '".$_POST[description]."' WHERE `id` = '".$_POST[manufacturerId]."'";
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlUpdate) or die (" error #10");
				echo "<br />#74".$sqlUpdate;
			}
			if ($_POST[modelId] != "") {
				$sqlUpdate = "UPDATE `model` SET `idManufacturer` = '".$_POST[manufacturerId]."', `name` = '".$_POST[modelName]."', `idSegment1` = '".$_POST[txtidSegment1]."' ,`idSegment2` = '".$_POST[txtidSegment2]."' ,`idSegment3` = '".$_POST[txtidSegment3]."' ,`description` = '".$_POST[description]."' WHERE `id` = ".$_POST[modelId]."";
				echo $sqlUpdate;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlUpdate) or die (" error #55");
				echo "<br />#80".$sqlUpdate;
			}
			if ($_POST[versionId] != "") {
				$sqlUpdate = "UPDATE `version` SET `idManufacturer` = '".$_POST[manufacturerId]."', `idModel` = '".$_POST[modelId]."', `name` = '".$_POST[versionName]."', `description` = '".$_POST[description]."' WHERE `id` = '".$_POST[versionId]."'";
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlUpdate) or die (mysql_error()." error #20");
				echo "<br />#85".$sqlUpdate;
			}

			$picTemp = uploadFile($_POST[manufacturerName],$_POST[modelName],$_POST[versionName],$_POST[featureId]);
			if ($picTemp != "") {
				$picTempSql = "`picture` = '".$picTemp."',";
			}
			$sqlUpdate = "UPDATE `feature` 
			SET 
				`idManufacturer` = '".$_POST[manufacturerId]."',
				`idModel` = '".$_POST[modelId]."',
				`idVersion` = '".$_POST[versionId]."',
				`code` = '".$_POST[code]."',
				`yearProduced` = '".$_POST[yearProduced]."',
				`yearModel` = '".$_POST[yearModel]."',
				`doors` = '".$_POST[doors]."',
				`passagers` = '".$_POST[passagers]."',
				`engine` = '".$_POST[engine]."',
				`feeding` = '".$_POST[feeding]."',
				`fuel` = '".$_POST[fuel]."',
				`powerMax` = '".$_POST[powerMax]."',
				`torque` = '".$_POST[torque]."',
				`acceleration` = '".$_POST[acceleration]."',
				`steering` = '".$_POST[steering]."',
				`speedMax` = '".$_POST[speedMax]."',
				`consumptionCity` = '".$_POST[consumptionCity]."',
				`consumptionRoad` = '".$_POST[consumptionRoad]."',
				`gear` = '".$_POST[gear]."',
				`traction` = '".$_POST[traction]."',
				`wheels` = '".$_POST[wheels]."',
				`frontSuspension` = '".$_POST[frontSuspension]."',
				`rearSuspension` = '".$_POST[rearSuspension]."',
				`frontBrake` = '".$_POST[frontBrake]."',
				`rearBrake` = '".$_POST[rearBrake]."',
				`dimensionLength` = '".$_POST[dimensionLength]."',
				`dimensionWidth` = '".$_POST[dimensionWidth]."',
				`dimensionHeight` = '".$_POST[dimensionHeight]."',
				`dimensionSignAxes` = '".$_POST[dimensionSignAxes]."',
				`weight` = '".$_POST[weight]."',
				`trunk` = '".$_POST[trunk]."',
				`tank` = '".$_POST[tank]."',
				`warranty` = '".$_POST[warranty]."',
				`countryOrigin` = '".$_POST[countryOrigin]."',
				`dualFrontAirBag` = '".$_POST[dualFrontAirBag]."',
				`alarm` = '".$_POST[alarm]."',
				`airConditioning` = '".$_POST[airConditioning]."',
				`hotAir` = '".$_POST[hotAir]."',
				`leatherSeat` = '".$_POST[leatherSeat]."',
				`heightAdjustment` = '".$_POST[heightAdjustment]."',
				`rearSeatSplit` = '".$_POST[rearSeatSplit]."',
				`bluetoothSpeakerphone` = '".$_POST[bluetoothSpeakerphone]."',
				`bonnetSea` = '".$_POST[bonnetSea]."',
				`onboardComputer` = '".$_POST[onboardComputer]."',
				`accelerationCounter` = '".$_POST[accelerationCounter]."',
				`rearWindowDefroster` = '".$_POST[rearWindowDefroster]."',
				`electricSteering` = '".$_POST[electricSteering]."',
				`hydraulicSteering` = '".$_POST[hydraulicSteering]."',
				`sidesteps` = '".$_POST[sidesteps]."',
				`fogLamps` = '".$_POST[fogLamps]."',
				`xenonHeadlights` = '".$_POST[xenonHeadlights]."',
				`absBrake` = '".$_POST[absBrake]."',
				`integratedGPSPanel` = '".$_POST[integratedGPSPanel]."',
				`rearWindowWiper` = '".$_POST[rearWindowWiper]."',
				`bumper` = '".$_POST[bumper]."',
				`autopilot` = '".$_POST[autopilot]."',
				`bucketProtector` = '".$_POST[bucketProtector]."',
				`roofRack` = '".$_POST[roofRack]."',
				`cdplayerUSBInput` = '".$_POST[cdplayerUSBInput]."',
				`radio` = '".$_POST[radio]."',
				`headlightsHeightAdjustment` = '".$_POST[headlightsHeightAdjustment]."',
				`rearviewElectric` = '".$_POST[rearviewElectric]."',
				`alloyWheels` = '".$_POST[alloyWheels]."',
				`rainSensor` = '".$_POST[rainSensor]."',
				`parkingSensor` = '".$_POST[parkingSensor]."',
				`isofix` = '".$_POST[isofix]."',
				`sunroof` = '".$_POST[sunroof]."',
				`electricLock` = '".$_POST[electricLock]."',
				`electricWindow` = '".$_POST[electricWindow]."',
				`rearElectricWindow` = '".$_POST[rearElectricWindow]."',
				`steeringWheelAdjustment` = '".$_POST[steeringWheelAdjustment]."',
				`price` = '".$_POST[price]."',
				`description` = '".$_POST[description]."',
				".$picTempSql."
				`active` = 's',
				`description` = '".$_POST[description]."',
				`dateCreate` = now(),
				`dateUpdate` = now(),
				`userUpdate` = ''
			WHERE `feature`.`id` = '".$_POST[featureId]."' ;";
		
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpdate) or die (mysql_error()." error #179");
			echo "<br />#181".$sqlUpdate;

			//segment
			$sqlUpSeg = "UPDATE `model` set `idSegment1` = '".$_POST[txtidSegment1]."', `idSegment2` = '".$_POST[txtidSegment2]."', `idSegment3` = '".$_POST[txtidSegment3]."' WHERE id = '".$_POST[modelId]."'";
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpSeg) or die ("error #185");
			echo "<br />#186".$sqlUpSeg;

			//serie
			$sqlDelSeries = "delete from `serieFeature` WHERE `idFeature` = '".$_POST[featureId]."'";
			mysql_query($sqlDelSeries) or die (" error #195");
			echo "<br />#191".$sqlDelSeries;
			for ($i=0;$i<$_POST[lengthSerie];$i++){
				$serieOpt = "rdSerie".$i;
				$serieName = "txtSerie".$i;
				if ($i > 0) { $valuesSerieInput .= ","; }
				$valuesSerieInput .= "(NULL, '".$_POST[featureId]."', '".$_POST[$serieName]."', '".$_POST[$serieOpt]."', now(), now(), NULL)";
			}
			if ($valuesSerieInput != ""){
				$sqlAddSeries = "insert into `serieFeature` (`id`, `idFeature`, `description`, `option`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesSerieInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddSeries) or die (" error #201");
				echo "<br />#202".$sqlAddSeries;
			}

			//options
			$sqlDelOpts = "delete from `optionsVersion` WHERE `idVersion` = '".$_POST[versionId]."' and yearModel = '".$_POST[yearModel]."'";
			mysql_query($sqlDelOpts) or die (" error #176");
			echo "<br />#177".$sqlDelOpts;
			$o=0;
			for ($i=0;$i<=$_POST[lengthOptions];$i++){
				$optIdOption = "txtOpt".$i;
				$optChoice = "chOpt".$i;
				$codeOpt = "txtOptCode".$i;
				$optPrice = "txtOptPrice".$i;
				if ($_POST[$optChoice] == "s") {
					if ($o > 0) { $valuesOptInput .= ","; }
					$valuesOptInput .= "('".$_POST[versionId]."', '".$_POST[manufacturerId]."' , '".$_POST[$optIdOption]."', '".$_POST[$codeOpt]."', '".$_POST[$optChoice]."', '".$_POST[$optPrice]."', '".$_POST[yearModel]."' , now(), now(), '')";
					$o++;
				}
				// echo $_POST[$optIdOption]."PPPPP".$_POST[$optChoice];
			}
			if ($valuesOptInput != ""){
				$sqlAddOpts = "insert into `optionsVersion` (`idVersion`, `idManufacturer`, `idOption`, `code`, `option`, `price`, `yearModel`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesOptInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddOpts) or die (mysql_error()." error #191");
				echo "<br />#193".$sqlAddOpts;
			}

			//color
			$sqlDelColor = "delete from `colorVersion` where `idVersion` = '".$_POST[versionId]."' and yearModel = '".$_POST[yearModel]."'"; 
			mysql_query($sqlDelColor) or die (" error #199");
			echo "<br />#199".$sqlDelColor;
			for ($i=0;$i<$_POST[colorLength];$i++){
				$colorName = $_POST["colorInputName".$i];
				$colorApp = $_POST["colorInputApp".$i];
				$colorHex = $_POST["colorInputColor".$i];
			 	$colorType = $_POST["colorInputType".$i];
			 	// $colorCode = $_POST["colorInputCode".$i];
			 	$colorPrice = $_POST["colorInputPrice".$i];
			 	if ($i > 0) { $valuesColorInput .= ","; }
			 	$valuesColorInput .= "('".$_POST[versionId]."', '".$_POST[manufacturerId]."', '".$colorName."', '".$colorHex."', '".$colorApp."', '".$colorType."', '".$_POST[yearModel]."', '".$colorPrice."' ,now(), now(), NULL)";
			}
			if ($valuesColorInput != ""){
			 	$sqlAddColor = "insert into `colorVersion` (`idVersion`, `idManufacturer`, `name`, `hexa`, `application`, `type`, `yearModel`, `price`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesColorInput;
			 	mysql_query("SET NAMES 'utf8'");
			 	mysql_query($sqlAddColor) or die (mysql_error()." error #126");
				echo "<br />#211".$sqlAddColor;
			}

			//pictures
			//uploadFile();
		break;
	}
	break;
	
	case 'new':
	case 'clone':
	//TO DO: clonar foto
		if ($_POST[manufacturerId] == "") {
			$sqlAdd = "INSERT INTO `manufacturer` (`name`, `active`, `description`) VALUES ('".$_POST[manufacturerName]."','s','".$_POST[description]."')";
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlAdd) or die ("error #200");
			echo "<br />#225".$sqlAdd;
			$manufacturerId = mysql_insert_id();
			//echo "<br>manufacturer:".$manufacturerId;
		} else {
			$manufacturerId = $_POST[manufacturerId];
		}
		if ($_POST[modelId] == "") {
			if ($_POST[category] != "manufacturer") {
				$sqlAdd = "INSERT into `model` (`idManufacturer`, `name`, `idSegment1`, `idSegment2`, `idSegment3`, `description`, `active`) VALUES ('".$manufacturerId."','".$_POST[modelName]."','".$_POST[txtidSegment1]."','".$_POST[txtidSegment2]."','".$_POST[txtidSegment3]."','".$_POST[description]."','s') ";
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAdd) or die (mysql_error()." error #206");
				echo "<br />#234".$sqlAdd;
				$modelId = mysql_insert_id();
				echo "<br>model:".$modelId;
			}
		} else {
			if ($_POST[category] != "manufacturer") {
				$modelId = $_POST[modelId];
				$sqlUpSeg = "UPDATE `model` set `idSegment1` = '".$_POST[txtidSegment1]."', `idSegment2` = '".$_POST[txtidSegment2]."', `idSegment3` = '".$_POST[txtidSegment3]."' WHERE id = '".$modelId."'";
				echo $sqlUpSeg;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlUpSeg) or die ("error #228");
				echo "<br />#242".$sqlUpSeg;
			}
		}
		if ($_POST[versionId] == "") {
			if ($_POST[category] != "manufacturer" && $_POST[category] != "model") {
				$sqlAdd = "INSERT INTO `version` (`idManufacturer`,`idModel`,`name`, `active`, `description`) VALUES ('".$manufacturerId."','".$modelId."','".$_POST[versionName]."','s','".$_POST[description]."')";
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAdd) or die (mysql_error()." error #231");
				echo "<br />#247".$sqlAdd;
				$versionId = mysql_insert_id();
				//echo "<br>version:".$versionId;
			}
		} else {
			$versionId = $_POST[versionId];
		}
		
		if ($_POST[category] != "manufacturer" && $_POST[category] != "model" && $_POST[category] != "version") {
			//TO DO: check if exist image cloned before then add                       
			$picTemp = uploadFile($_POST[manufacturerName],$_POST[modelName],$_POST[versionName],$_POST[featureId]);
			if ($picTemp != "") {
				$picTempSql = "`picture`, ";
				$picTempValue = "'".$picTemp."',";
			}
			$sqlAdd = "INSERT INTO `feature` (`idModel`, `idVersion`, `code`, `yearProduced`, `yearModel`, `doors`, `passagers`, `engine`, `feeding`, `fuel`, `powerMax`, `torque`, `acceleration`, `speedMax`, `consumptionCity`, `consumptionRoad`, `gear`, `traction`, `steering`, `wheels`, `frontSuspension`, `rearSuspension`, `frontBrake`, `rearBrake`, `dimensionLength`, `dimensionWidth`, `dimensionHeight`, `dimensionSignAxes`, `weight`, `trunk`, `tank`, `warranty`, `countryOrigin`, `dualFrontAirBag`, `alarm`, `airConditioning`, `hotAir`, `leatherSeat`, `heightAdjustment`, `rearSeatSplit`, `bluetoothSpeakerphone`, `bonnetSea`, `onboardComputer`, `accelerationCounter`, `rearWindowDefroster`, `electricSteering`, `hydraulicSteering`, `sidesteps`, `fogLamps`, `xenonHeadlights`, `absBrake`, `integratedGPSPanel`, `rearWindowWiper`, `bumper`, `autopilot`, `bucketProtector`, `roofRack`, `cdplayerUSBInput`, `radio`, `headlightsHeightAdjustment`, `rearviewElectric`, `alloyWheels`, `rainSensor`, `parkingSensor`, `isofix`, `sunroof`, `electricLock`, `electricWindow`, `rearElectricWindow`, `steeringWheelAdjustment`,`price`,`description`, ".$picTempSql." `active`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ('".$modelId."','".$versionId."','".$_POST[code]."','".$_POST[yearProduced]."','".$_POST[yearModel]."','".$_POST[doors]."','".$_POST[passagers]."','".$_POST[engine]."','".$_POST[feeding]."','".$_POST[fuel]."','".$_POST[powerMax]."','".$_POST[torque]."','".$_POST[acceleration]."','".$_POST[speedMax]."','".$_POST[consumptionCity]."','".$_POST[consumptionRoad]."','".$_POST[gear]."','".$_POST[traction]."','".$_POST[steering]."','".$_POST[wheels]."','".$_POST[frontSuspension]."','".$_POST[rearSuspension]."','".$_POST[frontBrake]."','".$_POST[rearBrake]."','".$_POST[dimensionLength]."','".$_POST[dimensionWidth]."','".$_POST[dimensionHeight]."','".$_POST[dimensionSignAxes]."','".$_POST[weight]."','".$_POST[trunk]."','".$_POST[tank]."','".$_POST[warranty]."','".$_POST[countryOrigin]."','".$_POST[dualFrontAirBag]."','".$_POST[alarm]."','".$_POST[airConditioning]."','".$_POST[hotAir]."','".$_POST[leatherSeat]."','".$_POST[heightAdjustment]."','".$_POST[rearSeatSplit]."','".$_POST[bluetoothSpeakerphone]."','".$_POST[bonnetSea]."','".$_POST[onboardComputer]."','".$_POST[accelerationCounter]."','".$_POST[rearWindowDefroster]."','".$_POST[electricSteering]."','".$_POST[hydraulicSteering]."','".$_POST[sidesteps]."','".$_POST[fogLamps]."','".$_POST[xenonHeadlights]."','".$_POST[absBrake]."','".$_POST[integratedGPSPanel]."','".$_POST[rearWindowWiper]."','".$_POST[bumper]."','".$_POST[autopilot]."','".$_POST[bucketProtector]."','".$_POST[roofRack]."','".$_POST[cdplayerUSBInput]."','".$_POST[radio]."','".$_POST[headlightsHeightAdjustment]."','".$_POST[rearviewElectric]."','".$_POST[alloyWheels]."','".$_POST[rainSensor]."','".$_POST[parkingSensor]."','".$_POST[isofix]."','".$_POST[sunroof]."','".$_POST[electricLock]."','".$_POST[electricWindow]."','".$_POST[rearElectricWindow]."','".$_POST[steeringWheelAdjustment]."','".$_POST[price]."','".$_POST[description]."',".$picTempValue."'s',now(),now(),'')";
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlAdd) or die ("error #227");
			echo "<br />#263".$sqlAdd;
			//echo $sqlAdd;
			$fetId = mysql_insert_id();


			//echo $fetId;
			//serie
			for ($i=0;$i<$_POST[lengthSerie];$i++){
				$serieOpt = "rdSerie".$i;
				$serieName = "txtSerie".$i;
				if ($i > 0) { $valuesSerieInput .= ","; }
				$valuesSerieInput .= "(NULL, '".$fetId."', '".$_POST[$serieName]."', '".$_POST[$serieOpt]."', now(), now(), NULL)";
			}
			if ($valuesSerieInput != ""){
				$sqlAddSeries = "insert into `serieFeature` (`id`, `idFeature`, `description`, `option`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesSerieInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddSeries) or die (" error #239");
				echo "<br />#279".$sqlAddSeries;
				//echo $sqlAddSeries;
			}

			//options
			$o=0;
			for ($i=0;$i<=$_POST[lengthOptions];$i++){
				$optIdOption = "txtOpt".$i;
				$optChoice = "chOpt".$i;
				$codeOpt = "txtOptCode".$i;
				$optPrice = "txtOptPrice".$i;
				if ($_POST[$optChoice] == "s") {
					if ($o > 0) { $valuesOptInput .= ","; }
					$valuesOptInput .= "('".$versionId."', '".$_POST[$optIdOption]."', '".$_POST[$codeOpt]."', '".$_POST[$optChoice]."', '".$_POST[$optPrice]."', '".$_POST[yearModel]."' , now(), now(), '')";
					$o++;
				}
				// echo $_POST[$optIdOption]."PPPPP".$_POST[$optChoice];
			}
			if ($valuesOptInput != ""){
				$sqlAddOpts = "insert into `optionsVersion` (`idVersion`, `idOption`, `code`, `option`, `price`, `yearModel`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesOptInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddOpts) or die (mysql_error()." error #191");
				echo "<br />#302".$sqlAddOpts;
			}

			
			//color
			for ($i=0;$i<$_POST[colorLength];$i++){
				if ($i > 0) { $valuesColorInput .= ","; }
				$valuesColorInput .= "('".$versionId."', '".$manufacturerId."', '".$_POST["colorInputName".$i]."', '".$_POST["colorInputColor".$i]."','".$_POST["colorInputCode".$i]."', '".$_POST["colorInputApp".$i]."', '".$_POST["colorInputPrice".$i]."', '".$_POST["colorInputType".$i]."', '".$_POST[yearModel]."', now(), now(), NULL)";
			}
			if ($valuesColorInput != ""){
				$sqlAddColor = "insert into `colorVersion` (`idVersion`, `idManufacturer`, `name`, `hexa`, `code`, `application`, `price`, `type`, `yearModel`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesColorInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddColor) or die (mysql_error()." error #321");
				echo "<br />#321".$sqlAddColor;
			}
		}
	break;
}




if ($_GET[debug] == "true"){ ?>
	<script> 
	alert("Atualizado");
	</script>
	<a href="../index.php">Voltar a Home</a>
<? } elseif ($_POST[action] == "new") {
	if ($_POST[category] == "manufacturer") { ?>
		<script> 
		alert("Direcionando para o cadastro do Modelo");
		window.location="../formDetails.php?vehicle=<?=$manufacturerId?>&action=new&category=model";
		</script>
		<a href="../index.php">Voltar a Home</a>	
	<? } elseif ($_POST[category] == "model") { ?>
		<script> 
		alert("Direcionando para o cadastro da Versão");
		window.location="../formDetails.php?vehicle=<?=$modelId?>&action=new&category=version";
		</script>
		<a href="../index.php">Voltar a Home</a>
	<? } elseif ($_POST[category] == "version") { ?>
		<script> 
		alert("Direcionando para o cadastro da Ficha Técnica");
		window.location="../formDetails.php?vehicle=<?=$versionId?>&action=new&category=feature";
		</script>
		<a href="../index.php">Voltar a Home</a>
	<? } else { ?>
		<script> 
		alert("Atualizado");
		window.location="../ficha-tecnica.php";
		</script>
		<a href="../index.php">Voltar a Home</a>
	<? } ?>
<? } else { ?>
	<script> 
	alert("Atualizado");
	//window.location="../ficha-tecnica.php";
	</script>
	<a href="../index.php">Voltar a Home</a>
<? } ?>
=======
<?
header('Content-Type: text/html; charset=utf-8');
include ("checkPermissions.php");
include("conectDB.php");
$date = new DateTime();
$dateTS = $date->getTimestamp();

function uploadFile ($manufacturerName,$modelName,$versionName,$featureId) {
	echo "<br>";
	var_dump($_FILES["file"]);
	echo "<br>#7 upload data<br>";
	var_dump($_FILES["image"]);
	echo "<br>";
	var_dump($_FILES["file"]["image"]);
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& in_array($extension, $allowedExts)) {
	// && ($_FILES["file"]["size"] < 20000) ==> check the file size
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		} else {
			// $_FILES["file"]["name"] = $manufacturerName.".".end($temp);
			// $_FILES["file"]["name"] = str_replace($_FILES["file"]["name"], "%20", "-");
			// $_FILES["file"]["name"] = $manufacturerName."-".$modelName."-".$versionName."-".$featureId.".".end($temp);
			$_FILES["file"]["name"] = "imagemmarcelo.".end($temp);
			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			echo "Type: " . $_FILES["file"]["type"] . "<br>";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
				if (file_exists("../../carImages/" . $_FILES["file"]["name"])) {
					echo $_FILES["file"]["name"] . " already exists. ";
				} else {
					move_uploaded_file($_FILES["file"]["tmp_name"],
					"../../carImages/" . $_FILES["file"]["name"]);
					echo "Stored in: " . "../../carImages/" . $_FILES["file"]["name"];
					return $_FILES["file"]["name"];
				}
		}
	} else {
		echo "Invalid file";
	}
}

switch ($_POST[action]) {
	case 'update':
	switch ($_POST[category]) {
		case 'manufacturer':
			$sqlUpdate = "UPDATE `manufacturer` SET `name` = '".$_POST[manufacturerName]."', `description` = '".$_POST[description]."' WHERE `id` = '".$_POST[manufacturerId]."'";
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpdate) or die (" error #10");
			echo "<br />#45".$sqlUpdate;
		break;
		case 'model':
			if ($_POST[modelId] == "") {
				$sqlUpdate = "INSERT INTO `model` ('idManufacturer', 'modelName', 'idSegment1', 'idSegment2', 'idSegment3', 'description') VALUES ('".$_POST[idManufacturer]."','".$_POST[modelName]."','".$_POST[txtidSegment1]."','".$_POST[txtidSegment2]."','".$_POST[txtidSegment3]."','".$_POST[description]."')";
			} else {
				$sqlUpdate = "UPDATE `model` SET `idManufacturer` = '".$_POST[manufacturerId]."', `name` = '".$_POST[modelName]."', `idSegment1` = '".$_POST[txtidSegment1]."' ,`idSegment2` = '".$_POST[txtidSegment2]."' ,`idSegment3` = '".$_POST[txtidSegment3]."' ,`description` = '".$_POST[description]."' WHERE `id` = ".$_POST[modelId]."";
			}
			echo $sqlUpdate;
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpdate) or die (" error #55");
			echo "<br />#55".$sqlUpdate;
		break;
		case 'version':
			if ($_POST[versionId] == "") {
				$sqlUpdate = "INSERT into `version` (`idManufacturer`, `idModel`, `name`) VALUES ('".$_POST[manufacturerId]."', '".$_POST[modelId]."', '".$_POST[versionName]."')";
			} else {
				$sqlUpdate = "UPDATE `version` SET `idManufacturer` = '".$_POST[manufacturerId]."', `idModel` = '".$_POST[modelId]."', `name` = '".$_POST[versionName]."', `description` = '".$_POST[description]."' WHERE `id` = '".$_POST[versionId]."'";
			}
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpdate) or die (mysql_error()." error #20");
			echo "<br />#60".$sqlUpdate;
		break;
		case 'feature':
			if ($_POST[manufacturerId] != "") {
				$sqlUpdate = "UPDATE `manufacturer` SET `name` = '".$_POST[manufacturerName]."', `description` = '".$_POST[description]."' WHERE `id` = '".$_POST[manufacturerId]."'";
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlUpdate) or die (" error #10");
				echo "<br />#74".$sqlUpdate;
			}
			if ($_POST[modelId] != "") {
				$sqlUpdate = "UPDATE `model` SET `idManufacturer` = '".$_POST[manufacturerId]."', `name` = '".$_POST[modelName]."', `idSegment1` = '".$_POST[txtidSegment1]."' ,`idSegment2` = '".$_POST[txtidSegment2]."' ,`idSegment3` = '".$_POST[txtidSegment3]."' ,`description` = '".$_POST[description]."' WHERE `id` = ".$_POST[modelId]."";
				echo $sqlUpdate;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlUpdate) or die (" error #55");
				echo "<br />#80".$sqlUpdate;
			}
			if ($_POST[versionId] != "") {
				$sqlUpdate = "UPDATE `version` SET `idManufacturer` = '".$_POST[manufacturerId]."', `idModel` = '".$_POST[modelId]."', `name` = '".$_POST[versionName]."', `description` = '".$_POST[description]."' WHERE `id` = '".$_POST[versionId]."'";
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlUpdate) or die (mysql_error()." error #20");
				echo "<br />#85".$sqlUpdate;
			}

			$picTemp = uploadFile($_POST[manufacturerName],$_POST[modelName],$_POST[versionName],$_POST[featureId]);
			if ($picTemp != "") {
				$picTempSql = "`picture` = '".$picTemp."',";
			}
			$sqlUpdate = "UPDATE `feature` 
			SET 
				`idManufacturer` = '".$_POST[manufacturerId]."',
				`idModel` = '".$_POST[modelId]."',
				`idVersion` = '".$_POST[versionId]."',
				`code` = '".$_POST[code]."',
				`yearProduced` = '".$_POST[yearProduced]."',
				`yearModel` = '".$_POST[yearModel]."',
				`doors` = '".$_POST[doors]."',
				`passagers` = '".$_POST[passagers]."',
				`engine` = '".$_POST[engine]."',
				`feeding` = '".$_POST[feeding]."',
				`fuel` = '".$_POST[fuel]."',
				`powerMax` = '".$_POST[powerMax]."',
				`torque` = '".$_POST[torque]."',
				`acceleration` = '".$_POST[acceleration]."',
				`steering` = '".$_POST[steering]."',
				`speedMax` = '".$_POST[speedMax]."',
				`consumptionCity` = '".$_POST[consumptionCity]."',
				`consumptionRoad` = '".$_POST[consumptionRoad]."',
				`gear` = '".$_POST[gear]."',
				`traction` = '".$_POST[traction]."',
				`wheels` = '".$_POST[wheels]."',
				`frontSuspension` = '".$_POST[frontSuspension]."',
				`rearSuspension` = '".$_POST[rearSuspension]."',
				`frontBrake` = '".$_POST[frontBrake]."',
				`rearBrake` = '".$_POST[rearBrake]."',
				`dimensionLength` = '".$_POST[dimensionLength]."',
				`dimensionWidth` = '".$_POST[dimensionWidth]."',
				`dimensionHeight` = '".$_POST[dimensionHeight]."',
				`dimensionSignAxes` = '".$_POST[dimensionSignAxes]."',
				`weight` = '".$_POST[weight]."',
				`trunk` = '".$_POST[trunk]."',
				`tank` = '".$_POST[tank]."',
				`warranty` = '".$_POST[warranty]."',
				`countryOrigin` = '".$_POST[countryOrigin]."',
				`dualFrontAirBag` = '".$_POST[dualFrontAirBag]."',
				`alarm` = '".$_POST[alarm]."',
				`airConditioning` = '".$_POST[airConditioning]."',
				`hotAir` = '".$_POST[hotAir]."',
				`leatherSeat` = '".$_POST[leatherSeat]."',
				`heightAdjustment` = '".$_POST[heightAdjustment]."',
				`rearSeatSplit` = '".$_POST[rearSeatSplit]."',
				`bluetoothSpeakerphone` = '".$_POST[bluetoothSpeakerphone]."',
				`bonnetSea` = '".$_POST[bonnetSea]."',
				`onboardComputer` = '".$_POST[onboardComputer]."',
				`accelerationCounter` = '".$_POST[accelerationCounter]."',
				`rearWindowDefroster` = '".$_POST[rearWindowDefroster]."',
				`electricSteering` = '".$_POST[electricSteering]."',
				`hydraulicSteering` = '".$_POST[hydraulicSteering]."',
				`sidesteps` = '".$_POST[sidesteps]."',
				`fogLamps` = '".$_POST[fogLamps]."',
				`xenonHeadlights` = '".$_POST[xenonHeadlights]."',
				`absBrake` = '".$_POST[absBrake]."',
				`integratedGPSPanel` = '".$_POST[integratedGPSPanel]."',
				`rearWindowWiper` = '".$_POST[rearWindowWiper]."',
				`bumper` = '".$_POST[bumper]."',
				`autopilot` = '".$_POST[autopilot]."',
				`bucketProtector` = '".$_POST[bucketProtector]."',
				`roofRack` = '".$_POST[roofRack]."',
				`cdplayerUSBInput` = '".$_POST[cdplayerUSBInput]."',
				`radio` = '".$_POST[radio]."',
				`headlightsHeightAdjustment` = '".$_POST[headlightsHeightAdjustment]."',
				`rearviewElectric` = '".$_POST[rearviewElectric]."',
				`alloyWheels` = '".$_POST[alloyWheels]."',
				`rainSensor` = '".$_POST[rainSensor]."',
				`parkingSensor` = '".$_POST[parkingSensor]."',
				`isofix` = '".$_POST[isofix]."',
				`sunroof` = '".$_POST[sunroof]."',
				`electricLock` = '".$_POST[electricLock]."',
				`electricWindow` = '".$_POST[electricWindow]."',
				`rearElectricWindow` = '".$_POST[rearElectricWindow]."',
				`steeringWheelAdjustment` = '".$_POST[steeringWheelAdjustment]."',
				`price` = '".$_POST[price]."',
				`description` = '".$_POST[description]."',
				".$picTempSql."
				`active` = 's',
				`description` = '".$_POST[description]."',
				`dateUpdate` = now(),
				`userUpdate` = ''
			WHERE `feature`.`id` = '".$_POST[featureId]."' ;";
		
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpdate) or die (mysql_error()." error #179");
			echo "<br />#181".$sqlUpdate;

			//segment
			$sqlUpSeg = "UPDATE `model` set `idSegment1` = '".$_POST[txtidSegment1]."', `idSegment2` = '".$_POST[txtidSegment2]."', `idSegment3` = '".$_POST[txtidSegment3]."' WHERE id = '".$_POST[modelId]."'";
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlUpSeg) or die ("error #185");
			echo "<br />#186".$sqlUpSeg;

			//serie
			$sqlDelSeries = "delete from `serieFeature` WHERE `idFeature` = '".$_POST[featureId]."'";
			mysql_query($sqlDelSeries) or die (" error #195");
			echo "<br />#191".$sqlDelSeries;
			for ($i=0;$i<$_POST[lengthSerie];$i++){
				$serieOpt = "rdSerie".$i;
				$serieName = "txtSerie".$i;
				if ($i > 0) { $valuesSerieInput .= ","; }
				$valuesSerieInput .= "(NULL, '".$_POST[featureId]."', '".$_POST[$serieName]."', '".$_POST[$serieOpt]."', now(), now(), NULL)";
			}
			if ($valuesSerieInput != ""){
				$sqlAddSeries = "insert into `serieFeature` (`id`, `idFeature`, `description`, `option`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesSerieInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddSeries) or die (" error #201");
				echo "<br />#202".$sqlAddSeries;
			}

			//options
			$sqlDelOpts = "delete from `optionsVersion` WHERE `idVersion` = '".$_POST[versionId]."' and yearModel = '".$_POST[yearModel]."'";
			mysql_query($sqlDelOpts) or die (" error #176");
			echo "<br />#177".$sqlDelOpts;
			$o=0;
			for ($i=0;$i<=$_POST[lengthOptions];$i++){
				$optIdOption = "txtOpt".$i;
				$optChoice = "chOpt".$i;
				$codeOpt = "txtOptCode".$i;
				$optPrice = "txtOptPrice".$i;
				if ($_POST[$optChoice] == "s") {
					if ($o > 0) { $valuesOptInput .= ","; }
					$valuesOptInput .= "('".$_POST[versionId]."', '".$_POST[manufacturerId]."' , '".$_POST[$optIdOption]."', '".$_POST[$codeOpt]."', '".$_POST[$optChoice]."', '".$_POST[$optPrice]."', '".$_POST[yearModel]."' , now(), now(), '')";
					$o++;
				}
				// echo $_POST[$optIdOption]."PPPPP".$_POST[$optChoice];
			}
			if ($valuesOptInput != ""){
				$sqlAddOpts = "insert into `optionsVersion` (`idVersion`, `idManufacturer`, `idOption`, `code`, `option`, `price`, `yearModel`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesOptInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddOpts) or die (mysql_error()." error #191");
				echo "<br />#193".$sqlAddOpts;
			}

			//color
			$sqlDelColor = "delete from `colorVersion` where `idVersion` = '".$_POST[versionId]."' and yearModel = '".$_POST[yearModel]."'"; 
			mysql_query($sqlDelColor) or die (" error #199");
			echo "<br />#199".$sqlDelColor;
			for ($i=0;$i<$_POST[colorLength];$i++){
				$colorName = $_POST["colorInputName".$i];
				$colorApp = $_POST["colorInputApp".$i];
				$colorHex = $_POST["colorInputColor".$i];
			 	$colorType = $_POST["colorInputType".$i];
			 	// $colorCode = $_POST["colorInputCode".$i];
			 	$colorPrice = $_POST["colorInputPrice".$i];
			 	if ($i > 0) { $valuesColorInput .= ","; }
			 	$valuesColorInput .= "('".$_POST[versionId]."', '".$_POST[manufacturerId]."', '".$colorName."', '".$colorHex."', '".$colorApp."', '".$colorType."', '".$_POST[yearModel]."', '".$colorPrice."' ,now(), now(), NULL)";
			}
			if ($valuesColorInput != ""){
			 	$sqlAddColor = "insert into `colorVersion` (`idVersion`, `idManufacturer`, `name`, `hexa`, `application`, `type`, `yearModel`, `price`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesColorInput;
			 	mysql_query("SET NAMES 'utf8'");
			 	mysql_query($sqlAddColor) or die (mysql_error()." error #126");
				echo "<br />#211".$sqlAddColor;
			}

			//pictures
			//uploadFile();
		break;
	}
	break;
	
	case 'new':
	case 'clone':
	//TO DO: clonar foto
		if ($_POST[manufacturerId] == "") {
			$sqlAdd = "INSERT INTO `manufacturer` (`name`, `active`, `description`) VALUES ('".$_POST[manufacturerName]."','s','".$_POST[description]."')";
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlAdd) or die ("error #200");
			echo "<br />#225".$sqlAdd;
			$manufacturerId = mysql_insert_id();
			//echo "<br>manufacturer:".$manufacturerId;
		} else {
			$manufacturerId = $_POST[manufacturerId];
		}
		if ($_POST[modelId] == "") {
			if ($_POST[category] != "manufacturer") {
				$sqlAdd = "INSERT into `model` (`idManufacturer`, `name`, `idSegment1`, `idSegment2`, `idSegment3`, `description`, `active`) VALUES ('".$manufacturerId."','".$_POST[modelName]."','".$_POST[txtidSegment1]."','".$_POST[txtidSegment2]."','".$_POST[txtidSegment3]."','".$_POST[description]."','s') ";
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAdd) or die (mysql_error()." error #206");
				echo "<br />#234".$sqlAdd;
				$modelId = mysql_insert_id();
				echo "<br>model:".$modelId;
			}
		} else {
			if ($_POST[category] != "manufacturer") {
				$modelId = $_POST[modelId];
				$sqlUpSeg = "UPDATE `model` set `idSegment1` = '".$_POST[txtidSegment1]."', `idSegment2` = '".$_POST[txtidSegment2]."', `idSegment3` = '".$_POST[txtidSegment3]."' WHERE id = '".$modelId."'";
				echo $sqlUpSeg;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlUpSeg) or die ("error #228");
				echo "<br />#242".$sqlUpSeg;
			}
		}
		if ($_POST[versionId] == "") {
			if ($_POST[category] != "manufacturer" && $_POST[category] != "model") {
				$sqlAdd = "INSERT INTO `version` (`idManufacturer`,`idModel`,`name`, `active`, `description`) VALUES ('".$manufacturerId."','".$modelId."','".$_POST[versionName]."','s','".$_POST[description]."')";
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAdd) or die (mysql_error()." error #231");
				echo "<br />#247".$sqlAdd;
				$versionId = mysql_insert_id();
				//echo "<br>version:".$versionId;
			}
		} else {
			$versionId = $_POST[versionId];
		}
		
		if ($_POST[category] != "manufacturer" && $_POST[category] != "model" && $_POST[category] != "version") {
			//TO DO: check if exist image cloned before then add                       
			$picTemp = uploadFile($_POST[manufacturerName],$_POST[modelName],$_POST[versionName],$_POST[featureId]);
			if ($picTemp != "") {
				$picTempSql = "`picture`, ";
				$picTempValue = "'".$picTemp."',";
			}
			$sqlAdd = "INSERT INTO `feature` (`idModel`, `idVersion`, `code`, `yearProduced`, `yearModel`, `doors`, `passagers`, `engine`, `feeding`, `fuel`, `powerMax`, `torque`, `acceleration`, `speedMax`, `consumptionCity`, `consumptionRoad`, `gear`, `traction`, `steering`, `wheels`, `frontSuspension`, `rearSuspension`, `frontBrake`, `rearBrake`, `dimensionLength`, `dimensionWidth`, `dimensionHeight`, `dimensionSignAxes`, `weight`, `trunk`, `tank`, `warranty`, `countryOrigin`, `dualFrontAirBag`, `alarm`, `airConditioning`, `hotAir`, `leatherSeat`, `heightAdjustment`, `rearSeatSplit`, `bluetoothSpeakerphone`, `bonnetSea`, `onboardComputer`, `accelerationCounter`, `rearWindowDefroster`, `electricSteering`, `hydraulicSteering`, `sidesteps`, `fogLamps`, `xenonHeadlights`, `absBrake`, `integratedGPSPanel`, `rearWindowWiper`, `bumper`, `autopilot`, `bucketProtector`, `roofRack`, `cdplayerUSBInput`, `radio`, `headlightsHeightAdjustment`, `rearviewElectric`, `alloyWheels`, `rainSensor`, `parkingSensor`, `isofix`, `sunroof`, `electricLock`, `electricWindow`, `rearElectricWindow`, `steeringWheelAdjustment`,`price`,`description`, ".$picTempSql." `active`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ('".$modelId."','".$versionId."','".$_POST[code]."','".$_POST[yearProduced]."','".$_POST[yearModel]."','".$_POST[doors]."','".$_POST[passagers]."','".$_POST[engine]."','".$_POST[feeding]."','".$_POST[fuel]."','".$_POST[powerMax]."','".$_POST[torque]."','".$_POST[acceleration]."','".$_POST[speedMax]."','".$_POST[consumptionCity]."','".$_POST[consumptionRoad]."','".$_POST[gear]."','".$_POST[traction]."','".$_POST[steering]."','".$_POST[wheels]."','".$_POST[frontSuspension]."','".$_POST[rearSuspension]."','".$_POST[frontBrake]."','".$_POST[rearBrake]."','".$_POST[dimensionLength]."','".$_POST[dimensionWidth]."','".$_POST[dimensionHeight]."','".$_POST[dimensionSignAxes]."','".$_POST[weight]."','".$_POST[trunk]."','".$_POST[tank]."','".$_POST[warranty]."','".$_POST[countryOrigin]."','".$_POST[dualFrontAirBag]."','".$_POST[alarm]."','".$_POST[airConditioning]."','".$_POST[hotAir]."','".$_POST[leatherSeat]."','".$_POST[heightAdjustment]."','".$_POST[rearSeatSplit]."','".$_POST[bluetoothSpeakerphone]."','".$_POST[bonnetSea]."','".$_POST[onboardComputer]."','".$_POST[accelerationCounter]."','".$_POST[rearWindowDefroster]."','".$_POST[electricSteering]."','".$_POST[hydraulicSteering]."','".$_POST[sidesteps]."','".$_POST[fogLamps]."','".$_POST[xenonHeadlights]."','".$_POST[absBrake]."','".$_POST[integratedGPSPanel]."','".$_POST[rearWindowWiper]."','".$_POST[bumper]."','".$_POST[autopilot]."','".$_POST[bucketProtector]."','".$_POST[roofRack]."','".$_POST[cdplayerUSBInput]."','".$_POST[radio]."','".$_POST[headlightsHeightAdjustment]."','".$_POST[rearviewElectric]."','".$_POST[alloyWheels]."','".$_POST[rainSensor]."','".$_POST[parkingSensor]."','".$_POST[isofix]."','".$_POST[sunroof]."','".$_POST[electricLock]."','".$_POST[electricWindow]."','".$_POST[rearElectricWindow]."','".$_POST[steeringWheelAdjustment]."','".$_POST[price]."','".$_POST[description]."',".$picTempValue."'s',now(),now(),'')";
			mysql_query("SET NAMES 'utf8'");
			mysql_query($sqlAdd) or die ("error #227");
			echo "<br />#263".$sqlAdd;
			//echo $sqlAdd;
			$fetId = mysql_insert_id();


			//echo $fetId;
			//serie
			for ($i=0;$i<$_POST[lengthSerie];$i++){
				$serieOpt = "rdSerie".$i;
				$serieName = "txtSerie".$i;
				if ($i > 0) { $valuesSerieInput .= ","; }
				$valuesSerieInput .= "(NULL, '".$fetId."', '".$_POST[$serieName]."', '".$_POST[$serieOpt]."', now(), now(), NULL)";
			}
			if ($valuesSerieInput != ""){
				$sqlAddSeries = "insert into `serieFeature` (`id`, `idFeature`, `description`, `option`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesSerieInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddSeries) or die (" error #239");
				echo "<br />#279".$sqlAddSeries;
				//echo $sqlAddSeries;
			}

			//options
			$o=0;
			for ($i=0;$i<=$_POST[lengthOptions];$i++){
				$optIdOption = "txtOpt".$i;
				$optChoice = "chOpt".$i;
				$codeOpt = "txtOptCode".$i;
				$optPrice = "txtOptPrice".$i;
				if ($_POST[$optChoice] == "s") {
					if ($o > 0) { $valuesOptInput .= ","; }
					$valuesOptInput .= "('".$versionId."', '".$_POST[$optIdOption]."', '".$_POST[$codeOpt]."', '".$_POST[$optChoice]."', '".$_POST[$optPrice]."', '".$_POST[yearModel]."' , now(), now(), '')";
					$o++;
				}
				// echo $_POST[$optIdOption]."PPPPP".$_POST[$optChoice];
			}
			if ($valuesOptInput != ""){
				$sqlAddOpts = "insert into `optionsVersion` (`idVersion`, `idOption`, `code`, `option`, `price`, `yearModel`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesOptInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddOpts) or die (mysql_error()." error #191");
				echo "<br />#302".$sqlAddOpts;
			}

			
			//color
			for ($i=0;$i<$_POST[colorLength];$i++){
				if ($i > 0) { $valuesColorInput .= ","; }
				$valuesColorInput .= "('".$versionId."', '".$manufacturerId."', '".$_POST["colorInputName".$i]."', '".$_POST["colorInputColor".$i]."','".$_POST["colorInputCode".$i]."', '".$_POST["colorInputApp".$i]."', '".$_POST["colorInputPrice".$i]."', '".$_POST["colorInputType".$i]."', '".$_POST[yearModel]."', now(), now(), NULL)";
			}
			if ($valuesColorInput != ""){
				$sqlAddColor = "insert into `colorVersion` (`idVersion`, `idManufacturer`, `name`, `hexa`, `code`, `application`, `price`, `type`, `yearModel`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ".$valuesColorInput;
				mysql_query("SET NAMES 'utf8'");
				mysql_query($sqlAddColor) or die (mysql_error()." error #321");
				echo "<br />#321".$sqlAddColor;
			}
		}
	break;
}





if ($_POST[action] == "new") {
	if ($_POST[category] == "manufacturer") { ?>
		<script> 
		alert("Direcionando para o cadastro do Modelo");
		window.location="../formDetails.php?vehicle=<?=$manufacturerId?>&action=new&category=model&timestamp=<?=$dateTS?>";
		</script>
		<a href="../index.php">Voltar a Home</a>	
	<? } elseif ($_POST[category] == "model") { ?>
		<script> 
		alert("Direcionando para o cadastro da Versão");
		window.location="../formDetails.php?vehicle=<?=$modelId?>&action=new&category=version&timestamp=<?=$dateTS?>";
		</script>
		<a href="../index.php">Voltar a Home</a>
	<? } elseif ($_POST[category] == "version") { ?>
		<script> 
		alert("Direcionando para o cadastro da Ficha Técnica");
		window.location="../formDetails.php?vehicle=<?=$versionId?>&action=new&category=feature&timestamp=<?=$dateTS?>";
		</script>
		<a href="../index.php">Voltar a Home</a>
	<? } else { ?>
		<script> 
		alert("Atualizado");
		window.location="../ficha-tecnica.php?timestamp=<?=$dateTS?>";
		</script>
		<a href="../index.php">Voltar a Home</a>
	<? } ?>
<? } else { ?>
	<script> 
	alert("Atualizado");
	window.location="../ficha-tecnica.php?timestamp=<?=$dateTS?>";
	</script>
	<a href="../index.php">Voltar a Home</a>
<? } ?>
>>>>>>> FETCH_HEAD
