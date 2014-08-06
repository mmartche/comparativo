<?
header('Content-Type: application/json; charset=utf-8');
include ("../scripts/conectDB.php");
include ("../scripts/functions.php");
mysql_query("SET NAMES 'utf8'");

//$sql_search = "select feature.id as featureId, manufacturer.name as manufacturerName, model.name as modelName, version.name as versionName, feature.yearProduced, feature.yearModel from manufacturer, model, version, feature where feature.idManufacturer = manufacturer.id and feature.idModel = model.id and feature.idVersion = version.id order by model.name";

switch ($_GET[type]) {
 	case 'askInput':
		echo "[";
		$sql_s_manuf = "select id, name, active from manufacturer where name like ('%".$_GET[term]."%')";
		$query_s_manuf = mysql_query($sql_s_manuf);
		// or die ($sql_s_manuf." error #15");
		$m = 0;
		while ($resM = mysql_fetch_array($query_s_manuf)) {
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resM[id].'",
					"label":"'.$resM[name].'",
					"category": "Montadora",
					"active":"'.$resM[active].'",
					"table":"manufacturer",
					"value":"'.$resM[name].'"
				}';
			$m++;
		}
		$sql_search = "select id, name, active from model where name like ('%".$_GET[term]."%')";
		$query_search = mysql_query($sql_search);
		// or die (" error #30");
		$l = 0;
		while ($res = mysql_fetch_array($query_search)) {
			if ($l > 0 || $m > 0) { echo ","; }
			echo '{
					"id":"'.$res[id].'",
					"label":"'.$res[name].'",
					"category": "Modelo",
					"active":"'.$res[active].'",
					"table":"model",
					"value":"'.$res[name].'"
				}';
			$l++;
		}
		$sql_v = "select id, name, active from version where name like ('%".$_GET[term]."%')";
		$query_v = mysql_query($sql_v);
		// or die (mysql_error()." error #40");
		$v = 0;
		while ($resV = mysql_fetch_array($query_v)) {
			if ($l > 0 || $m > 0 || $v > 0) { echo ","; }
			echo '{
					"id":"'.$resV[id].'",
					"label":"'.$resV[name].'",
					"category": "Versão",
					"active":"'.$resV[active].'",
					"table":"version",
					"value":"'.$resV[name].'"
				}';
			$l++;
		}
		echo "]";
	break;

	case 'terms':
		//echo $sql_search;
		if ($_GET[table] != "") { $filterSearch = "AND ".$_GET[table].".id = '".$_GET[idField]."'"; }
		elseif ($_GET[term] != "") { 
		//search all about the term
		}
		echo "[";
		//ALL MANUFACTURES
		if ($_GET[table] == "manufacturer") {
			$sqlTerm = "SELECT manufacturer.id as manufacturerId, manufacturer.name as manufacturerName, active FROM manufacturer WHERE id = '".$_GET[idField]."'";
			$queryTerm = mysql_query($sqlTerm) or die (mysql_error()." // ".$sqlTerm." error #70");
			$l = 0;
			while ($res = mysql_fetch_array($queryTerm)) {
				if($l>0) {echo ",";}
				echo '{
						"idItem":"'.$res[manufacturerId].'",
						"order":"'.$l.'",
						"label":"'.$_GET[term].'",
						"featureId":"'.$res[featureId].'",
						"manufacturerId":"'.$res[manufacturerId].'",
						"manufacturerName":"'.$res[manufacturerName].'",
						"modelId":"'.$res[modelId].'",
						"modelName":"'.$res[modelName].'",
						"versionId":"'.$res[versionId].'",
						"versionName":"'.$res[versionName].'",
						"yearProduced":"'.$res[yearProduced].'",
						"yearModel":"'.$res[yearModel].'",
						"category": "manufacturer",
						"active":"'.$res[active].'",
						"value":"",
						"name":""
					}';
				$l++;
			}
		}
		//ALL MODELS
		if ($_GET[table] == "manufacturer" || $_GET[table] == "model") {
			$sqlTerm = "SELECT manufacturer.id as manufacturerId, manufacturer.name as manufacturerName, model.id as modelId, model.name as modelName, model.active FROM manufacturer, model WHERE model.idManufacturer = manufacturer.id ".$filterSearch;
			$queryTerm = mysql_query($sqlTerm) or die (mysql_error()." // ".$sqlTerm." error #95");
			while ($res = mysql_fetch_array($queryTerm)) {
				if($l>0) {echo ",";}
				echo '{
						"idItem":"'.$res[modelId].'",
						"order":"'.$l.'",
						"label":"'.$_GET[term].'",
						"featureId":"'.$res[featureId].'",
						"manufacturerId":"'.$res[manufacturerId].'",
						"manufacturerName":"'.$res[manufacturerName].'",
						"modelId":"'.$res[modelId].'",
						"modelName":"'.$res[modelName].'",
						"versionId":"'.$res[versionId].'",
						"versionName":"'.$res[versionName].'",
						"yearProduced":"'.$res[yearProduced].'",
						"yearModel":"'.$res[yearModel].'",
						"category": "model",
						"active":"'.$res[active].'",
						"value":"",
						"name":""
					}';
				$l++;
			}
		}
		//ALL VERSIONS
		if ($_GET[table] == "manufacturer" || $_GET[table] == "model" || $_GET[table] == "version" || $_GET[table] == "feature") {
			$sqlTerm = "SELECT manufacturer.id as manufacturerId, manufacturer.name as manufacturerName, model.id as modelId, model.name as modelName, version.id as versionId, version.name as versionName, version.active FROM manufacturer, model, version WHERE version.idModel = model.id AND model.idManufacturer = manufacturer.id ".$filterSearch;
			$queryTerm = mysql_query($sqlTerm) or die (mysql_error()." // ".$sqlTerm." error #120");
			while ($res = mysql_fetch_array($queryTerm)) {
				if($l>0) {echo ",";}
				echo '{
						"idItem":"'.$res[versionId].'",
						"order":"'.$l.'",
						"label":"'.$_GET[term].'",
						"featureId":"'.$res[featureId].'",
						"manufacturerId":"'.$res[manufacturerId].'",
						"manufacturerName":"'.$res[manufacturerName].'",
						"modelId":"'.$res[modelId].'",
						"modelName":"'.$res[modelName].'",
						"versionId":"'.$res[versionId].'",
						"versionName":"'.$res[versionName].'",
						"yearProduced":"'.$res[yearProduced].'",
						"yearModel":"'.$res[yearModel].'",
						"category": "version",
						"active":"'.$res[active].'",
						"value":"",
						"name":""
					}';
				$l++;
			}
		}
		//ALL ALL
		if ($_GET[table] == "manufacturer" || $_GET[table] == "model" || $_GET[table] == "version" || $_GET[table] == "feature") {
			$sqlTerm = "SELECT feature.id as featureId, feature.yearProduced, feature.yearModel, feature.engine, feature.gear, feature.fuel, feature.steering, manufacturer.id as manufacturerId, manufacturer.name as manufacturerName, model.id as modelId, model.name as modelName, version.id as versionId, version.name as versionName, feature.active FROM manufacturer, model, version, feature WHERE feature.idVersion = version.id AND version.idModel = model.id AND model.idManufacturer = manufacturer.id ".$filterSearch;
			$queryTerm = mysql_query($sqlTerm) or die (mysql_error()." // ".$sqlTerm." error #150");
			while ($res = mysql_fetch_array($queryTerm)) {
				if($l>0) {echo ",";}
				echo '{
						"idItem":"'.$res[featureId].'",
						"order":"'.$l.'",
						"label":"'.$_GET[term].'",
						"featureId":"'.$res[featureId].'",
						"manufacturerId":"'.$res[manufacturerId].'",
						"manufacturerName":"'.$res[manufacturerName].'",
						"modelId":"'.$res[modelId].'",
						"modelName":"'.$res[modelName].'",
						"versionId":"'.$res[versionId].'",
						"versionName":"'.$res[versionName].'",
						"yearProduced":"'.$res[yearProduced].'",
						"yearModel":"'.$res[yearModel].'",
						"engine":"'.$res[engine].'",
						"gear":"'.$res[gear].'",
						"fuel":"'.$res[fuel].'",
						"steering":"'.$res[steering].'",
						"segment1":"'.$res[segment1].'",
						"segment2":"'.$res[segment2].'",
						"segment3":"'.$res[segment3].'",
						"category": "feature",
						"active":"'.$res[active].'",
						"value":"",
						"name":""
					}';
				$l++;
			}
		}
		echo "]";
		break;
		/*
		DESATIVANDO VALIDACAO POR CODIGO
	case 'addOption':
		$checkDB = "select id from `optionsManufacturer` where code = '".$_GET[codopt]."'";
		$checkQ = mysql_query($checkDB);
		if (mysql_num_rows($checkQ) > 0) {
			$optIdEx = mysql_fetch_array($checkQ);
			$sql_addOpt = "UPDATE `optionsManufacturer` SET `idManufacturer` = '".$_GET[manufacturerId]."', `name` = '".$_GET[name]."', `options` = '".$_GET[text]."', `price` = '".$_GET[price]."', `active` = 's', `dateUpdate` = now() WHERE code = '".$_GET[codopt]."'";
			mysql_query($sql_addOpt) or die ('[{"response":"false","error":"error #192","reason":"'.mysql_error().'"}]');
			echo '[{"response":"alert","insertId":"'.$optIdEx[id].'","reason":"Same code"}]';
		} else {
			// $text = real_escape_string(nl2br(htmlspecialchars($_GET['text'])));
			$sql_addOpt = "insert into `optionsManufacturer` (`id`, `idManufacturer`, `code`, `name`, `options`, `price`, `active`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ('', '".$_GET[manufacturerId]."', '".$_GET[codopt]."', '".$_GET[name]."', '".$_GET[text]."', '".$_GET[price]."', 's', now(), now(),'')";
			mysql_query($sql_addOpt) or die ('[{"response":"false","error":"error #192","reason":"'.mysql_error().'"}]');
			echo '[{"response":"true","insertId":"'.mysql_insert_id().'"}]';
		}
		break;
		*/
	case 'addOption':
			// $text = real_escape_string(nl2br(htmlspecialchars($_GET['text'])));
			$sql_addOpt = "insert into `optionsManufacturer` (`id`, `idManufacturer`, `code`, `name`, `options`, `price`, `active`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ('', '".$_GET[manufacturerId]."', '".$_GET[codopt]."', '".$_GET[name]."', '".$_GET[text]."', '".$_GET[price]."', 's', now(), now(),'')";
			mysql_query($sql_addOpt) or die ('[{"response":"false","error":"error #192","reason":"'.mysql_error().'"}]');
			echo '[{"response":"true","insertId":"'.mysql_insert_id().'"}]';
		break;
	case 'editOption':
		$sql = "UPDATE `optionsManufacturer` SET `code` = '".$_GET[codopt]."', `name` = '".$_GET[name]."', `options` = '".$_GET[text]."', `price` = '".$_GET[price]."', `active` = 's', `dateUpdate` = now() WHERE id = '".$_GET[optId]."';";
		mysql_query($sql) or die ('[{"response":"false","error":"error #214","reason":"'.mysql_error().'"}]');
		echo '[{"response":"true","insertId":"'.$_GET[optId].'"}]';
		break;

	case 'addColor':
		if ($_GET[cId] != "") {
			echo '[{"response":"true","error":"#205","reason":"Id já existe","insertcId":"'.$_GET[cId].'"}]';
			break;
		}
		// $checkColor = "SELECT id, name from colorManufacturer where code = '".$_GET[ccode]."'";
		// $chColor = mysql_query($checkColor);
		// if (mysql_num_rows($chColor) > 0 ) {
		// 	//return false
		// 	$rchC = mysql_fetch_array($chColor);
		// 	echo '[{"response":"false","error":"#213","reason":"Código já existe para a cor '.$rchC[name].'","insertId":"'.$rchC[id].'"}]';
		// 	//$sql_addColor = "UPDATE colorManufacturer SET `idManufacturer` = '".$_GET[manufacturerId]."', `name` = '".$_GET[cname]."', `hexa` = '".$_GET[chexa]."', `type` = '".$_GET[ctype]."', `application` = '".$_GET[capp]."', `price` = '".$_GET[cprice]."', `dateUpdate` = now() WHERE code = '".$_GET[ccode]."'";
		// } else {
		$sql_addColor = "INSERT into `colorManufacturer` (`idManufacturer`, `name`, `code`, `hexa`, `type`, `application`, `price`, `dateCreate`, `dateUpdate`, `userUpdate`) VALUES ('".$_GET[manufacturerId]."', '".$_GET[cname]."', '".$_GET[ccode]."', '".$_GET[chexa]."', '".$_GET[ctype]."', '".$_GET[capp]."', '".$_GET[cprice]."', now(), now(),'')";
		mysql_query("SET NAMES 'utf8'");
		mysql_query($sql_addColor) or die ('[{"response":"false","error":"error #198","reason":"'.mysql_error().$sql_addColor.'"}]');
		echo '[{"response":"true","insertId":"'.mysql_insert_id().'"}]';
		// }
		break;

	case 'removeColor':
		$sql_addColor = "DELETE FROM `".$_GET[table]."` WHERE `".$_GET[table]."`.`id` = '".$_GET[idColor]."'";
		mysql_query($sql_addColor) or die ('[{"response":"false","error":"error #205","reason":"'.mysql_error()." ".$sql_addColor.'"}]');
		echo '[{"response":"true"}]';
		break;

	case 'editColor':
		$sql = "UPDATE  `colorManufacturer` set `idManufacturer` = '".$_GET[manufacturerId]."', `name` = '".$_GET[cname]."', `hexa` = '".$_GET[chexa]."', `type` = '".$_GET[ctype]."', `price` = '".$_GET[cprice]."', `dateUpdate` = now() WHERE id = '".$_GET[cId]."' ";
		mysql_query($sql) or die ('[{"response":"false","error":"error #245","reason":"'.mysql_error()." ".$sql.'"}]');
		echo '[{"response":"true"}]';
		break;

		//first check if exist children-content about this, 
		//if true then response false and the children info (how many itens still using this item)
		//if false go to delConfirm
	case 'deleteForm':
		if ($_GET[table] && $_GET[idField]) {
			$sqlCheckChildren = "DELETE FROM ".$_GET[table]." WHERE `id` = '".$_GET[idField]."'";
			mysql_query($sqlCheckChildren) or die ('[{"response":"false","error":"error #215","reason":"'.mysql_error().'"}]');
			echo '[{"response":"true"}]';
		} else {
			echo '[{"response":"false","error":"error #210","reason":"Incomplete Data"}]';
		}
		break;

		//wait prompt confirm and userId
		//check if will erase the children data (NO NO NO . NOT NOW)
		//change the status to deleted by user ;x;
	case 'deleteFormConfirm':
		echo '[{"response":"true"}]';
		break;

	case 'askManuf':
		echo "[";
		$sql_s_manuf = "SELECT id, name, active from manufacturer where name like ('%".$_GET[term]."%') ORDER by name";
		$query_s_manuf = mysql_query($sql_s_manuf) or die ($sql_s_manuf." error #15");
		$m = 0;
		while ($resM = mysql_fetch_array($query_s_manuf)) {
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resM[id].'",
					"label":"'.utf8_encode($resM[name]).'",
					"category": "Montadora",
					"table":"manufacturer",
					"active":"'.$resM[active].'",
					"value":"'.utf8_encode($resM[name]).'"
				}';
			$m++;
		}
		echo "]";
		break;
	case 'askModel':
		echo "[";
		if ($_GET[mainId] != "") { $mainId = " and model.idManufacturer = '".$_GET[mainId]."' "; }
		$sql_search = "SELECT model.id, model.name, model.idSegment1, model.idSegment2, model.idSegment3, model.active from feature, model, version where model.name like ('%".$_GET[term]."%') and version.idModel = model.id and feature.idVersion = version.id and version.active = 's' and feature.active = 's' ".$mainId." GROUP BY model.id ORDER by model.name";
		$query_s_manuf = mysql_query($sql_search) or die (" error #15");
		$m = 0;
		while ($resM = mysql_fetch_array($query_s_manuf)) {
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resM[id].'",
					"label":"'.utf8_encode($resM[name]).'",
					"category": "Modelo",
					"table":"model",
					"segmentId1":"'.$resM[idSegment1].'",
					"segmentId2":"'.$resM[idSegment2].'",
					"segmentId3":"'.$resM[idSegment3].'",
					"active":"'.$resM[active].'",
					"value":"'.utf8_encode($resM[name]).'"
				}';
			$m++;
		}
		echo "]";
		break;
	case 'askVersion':
		echo "[";
		if ($_GET[mainId] != "") { $mainId = " and idModel = '".$_GET[mainId]."' and model.id = '".$_GET[mainId]."' "; }
		$sql_v = "SELECT version.id, version.name, model.active, model.idSegment1, model.idSegment2, model.idSegment3 from version, model where version.active = 's' and version.name like ('%".$_GET[term]."%') ".$mainId." ORDER by version.name";
		
		$query_s_manuf = mysql_query($sql_v) or die (" error #15");
		$m = 0;
		while ($resM = mysql_fetch_array($query_s_manuf)) {
			if ($nameSeg == "") {
				$sSeg1 = "SELECT segment.name from segment WHERE segment.id = '".$resM[idSegment1]."'";
				$qSeg1 = mysql_query($sSeg1);
				$rSeg1 = mysql_fetch_array($qSeg1);
				$sSeg2 = "SELECT segment.name from segment WHERE segment.id = '".$resM[idSegment2]."'";
				$qSeg2 = mysql_query($sSeg2);
				$rSeg2 = mysql_fetch_array($qSeg2);
				$sSeg3 = "SELECT segment.name from segment WHERE segment.id = '".$resM[idSegment3]."'";
				$qSeg3 = mysql_query($sSeg3);
				$rSeg3 = mysql_fetch_array($qSeg3);
				$nameSeg = "ok";
			}
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resM[id].'",
					"label":"'.$resM[name].'",
					"category": "Versão",
					"table":"version",
					"idSegment1":"'.$resM[idSegment1].'",
					"segmentName1":"'.$rSeg1[name].'",
					"idSegment2":"'.$resM[idSegment2].'",
					"segmentName2":"'.$rSeg2[name].'",
					"idSegment3":"'.$resM[idSegment3].'",
					"segmentName3":"'.$rSeg3[name].'",
					"active":"'.$resM[active].'",
					"value":"'.$resM[name].'"
				}';
			$m++;
		}
		echo "]";
		break;

	case 'activeItem':
		$select = "SELECT active, idVersion from ".$_GET[category]." WHERE id = '".$_GET[idItem]."'";
		$query = mysql_query($select) or die ('[{"response":"false", "errorMsg":"'.mysql_error().'"}]');
		$resAI = mysql_fetch_array($query);
		if ($resAI[active] == "n") {
			$sql_aI = "UPDATE `version` SET `active` = 's' WHERE `id` = '".$resAI[idVersion]."'	";
			mysql_query($sql_aI) or die ('[{"response":"false", "reason":"#338 '.$sql_aI.mysql_error().'"}]');
			$sql_aI = " UPDATE `".$_GET[category]."` SET `active` = 's' WHERE `id` = '".$_GET[idItem]."';";
			mysql_query($sql_aI) or die ('[{"response":"false", "reason":"#340'.mysql_error().'"}]');
			echo '[{"response":"true", "reason":"active", "status": "'.$resAI[active].'"}]';
		} else {
			$sql_aI = "UPDATE `version` SET `active` = 'n' WHERE `id` = '".$resAI[idVersion]."' ";
			mysql_query($sql_aI) or die ('[{"response":"false", "reason":"#344 '.mysql_error().'"}]');
			$sql_aI = " UPDATE `".$_GET[category]."` SET `active` = 'n' WHERE `id` = '".$_GET[idItem]."';";
			mysql_query($sql_aI) or die ('[{"response":"false", "reason":"#346 '.mysql_error().'"}]');
			echo '[{"response":"true", "reason":"desactive", "status": "'.$resAI[active].'"}]';
		}
		break;

	case 'askOption':
		$sql = "SELECT optionsManufacturer.id, optionsManufacturer.name, optionsManufacturer.options, optionsManufacturer.price, optionsManufacturer.code, manufacturer.name as manufacturerName FROM optionsManufacturer, manufacturer WHERE manufacturer.id = optionsManufacturer.idManufacturer and  optionsManufacturer.idManufacturer = '".$_GET[manufacturerId]."'";
		$query = mysql_query($sql) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
		$m=0; echo "[";
		while ($resOpt = mysql_fetch_array($query)) {
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resOpt[id].'",
					"label":"'.$resOpt[name].'",
					"category": "Opcional",
					"table":"optionsManufacturer",
					"value":"'.$resOpt[name].'",
					"optValue":"'.str_replace(array("\r", "\n"), "", $resOpt[options]).'",
					"price":"'.$resOpt[price].'",
					"code":"'.$resOpt[code].'",
					"manufacturerName":"'.$resOpt[manufacturerName].'"
				}';
			$m++;
		}
		echo "]";
		break;
	case 'askOptionValue':
		$sql = "SELECT id, name, options, price, code FROM optionsManufacturer WHERE id = '".$_GET[optId]."'";

		$query = mysql_query($sql) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
		$m=0; echo "[";
		while ($resOpt = mysql_fetch_array($query)) {
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resOpt[id].'",
					"label":"'.urlencode($resOpt[name]).'",
					"category": "Opcional",
					"table":"optionsManufacturer",
					"value":"'.urlencode($resOpt[name]).'",
					"optValue":"'.urlencode($resOpt[options]).'",
					"price":"'.$resOpt[price].'",
					"code":"'.$resOpt[code].'"
				}';
			$m++;
		}
		echo "]";
		break;
	case 'askOptionEdit':
		$sql = "SELECT id, name, options, price, code FROM optionsManufacturer WHERE idManufacturer = '".$_GET[optId]."'";
		$query = mysql_query($sql) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
		$m=0; echo "[";
		while ($resOpt = mysql_fetch_array($query)) {
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resOpt[id].'",
					"label":"'.$resOpt[name].'",
					"category": "Opcional",
					"table":"optionsManufacturer",
					"value":"'.$resOpt[name].'",
					"optValue":"'.$resOpt[options].'",
					"price":"'.$resOpt[price].'",
					"code":"'.$resOpt[code].'"
				}';
			$m++;
		}
		echo "]";
		break;
	case 'askColor':
		$sql = "SELECT colorManufacturer.id, colorManufacturer.name, colorManufacturer.hexa, colorManufacturer.price, colorManufacturer.code, manufacturer.name as manufacturerName FROM colorManufacturer, manufacturer WHERE manufacturer.id = colorManufacturer.idManufacturer and  colorManufacturer.idManufacturer = '".$_GET[manufacturerId]."' order by colorManufacturer.name asc";
		$query = mysql_query($sql) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
		$m=0; echo "[";
		while ($resCol = mysql_fetch_array($query)) {
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resCol[id].'",
					"label":"'.utf8_encode($resCol[name]).'",
					"category": "Color",
					"table":"colorManufacturer",
					"value":"'.utf8_encode($resCol[name]).'",
					"hexa":"'.$resCol[hexa].'",
					"price":"'.$resCol[price].'",
					"code":"'.$resCol[code].'",
					"manufacturerName":"'.$resCol[manufacturerName].'"
				}';
			$m++;
		}
		echo "]";
		break;
	case 'askColorValue':
		$sql = "SELECT colorManufacturer.id, colorManufacturer.name, colorManufacturer.hexa, colorManufacturer.price, colorManufacturer.code, colorManufacturer.application, colorManufacturer.type FROM colorManufacturer WHERE  colorManufacturer.id = '".$_GET[optId]."';";
		// $sql = "SELECT colorVersion.id, colorVersion.name, colorVersion.hexa, colorVersion.price, colorVersion.code, colorVersion.application, colorVersion.type, version.name as vname FROM colorVersion, version WHERE colorVersion.idManufacturer = '".$_GET[optId]."' and colorVersion.idVersion = version.id";
		$query = mysql_query($sql) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');

		$m=0; echo "[";
		while ($resOpt = mysql_fetch_array($query)) {
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resOpt[id].'",
					"label":"'.$resOpt[name].'",
					"category": "Color",
					"table":"colorManufacturer",
					"value":"'.$resOpt[name].'",
					"hexa":"'.$resOpt[hexa].'",
					"price":"'.$resOpt[price].'",
					"code":"'.$resOpt[code].'",
					"application":"'.$resOpt[application].'",
					"type":"'.$resOpt[type].'",
					"vname":"'.$resOpt[vname].'"
				}';
			$m++;
		}
		echo "]";
		break;
	case 'megaInfo':
		$sqlMO = "SELECT id, place FROM megaOferta WHERE idFeature = '".$_GET[idFeature]."'";
		$queryMO = mysql_query($sqlMO) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
		echo '[{"response":"true", "insertId":"'.mysql_insert_id().'", "reason":"Already exist, updated"}]';
		// if (mysql_num_rows($queryMO) > 0 ){
			// $sqlUp = "UPDATE `megaOferta` SET `price` = '".$_GET[price]."' AND `dateLimit` = '".$_GET[dateLimit]."' AND `place` = '".$_GET[place]."' WHERE `idFeature` = '".$_GET[idFeature]."'";
			// mysql_query($sqlUp) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
		// }
		break;
	case 'megaAdd':
	//api/index.php?type=mega&idFeature=5&price=123&p=carrousel&dateLimit=12/12/2013&name=undefined 
		// $sqlMO = "SELECT id, place FROM megaOferta WHERE idFeature = '".$_GET[idFeature]."'";
		// $queryMO = mysql_query($sqlMO) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
		// if (mysql_num_rows($queryMO) > 0 ){
		// 	$sqlUp = "UPDATE `megaOferta` SET `price` = '".$_GET[price]."' AND `dateLimit` = '".$_GET[dateLimit]."' AND `place` = '".$_GET[place]."' WHERE `idFeature` = '".$_GET[idFeature]."'";
		// 	mysql_query($sqlUp) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
		// 	echo '[{"response":"true", "errorNumber":"#355", "reason":"Already exist, updated"}]';
		// } else {
			$sql = "INSERT INTO megaOferta (`manufacturerId`,`modelId`,`versionId`,`featureId`,`price`,`place`,`description`,`picture`,`dateIni`,`dateLimit`,`dateUpdate`) VALUES ('".$_GET[manufacturerId]."','".$_GET[modelId]."','".$_GET[versionId]."','".$_GET[featureId]."','".$_GET[price]."','".$_GET[place]."','".$_GET[description]."','".$_GET[picture]."','".$_GET[dateIni]."','".$_GET[dateLimit]."',now())";
			//$query = mysql_query($sql) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
			//$res = mysql_fetch_array($query);
			echo '[{"response":"true", "id":"'.mysql_insert_id().'"}]';
		// }
		break;
	case 'megaRemove':
		$sqlRM = "DELETE from `megaOferta` WHERE `id` = '".$_GET[idItem]."'";
		mysql_query($sqlRM) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
		echo '[{"response":"true", "reason":"Item removed"}]';
		break;

	case 'checkSearch':
		if ($_GET[idItem] && $_GET[table] && $_GET[field] && $_GET[text]) {
			$field = $_GET[field];
			$sql = "SELECT ".$_GET[field]." FROM ".$_GET[table]." WHERE id = '".$_GET[idItem]."'";
			$query = mysql_query($sql) or die ('[{"response":"false", "reason":"'.mysql_error().'"}]');
			$res = mysql_fetch_array($query);
			if ($res[$field] === $_GET[text]) {
				echo '[{"response":"true", "reason":""}]';
			} else {
				echo '[{"response":"false", "reason":"Different Info"}]';
			}
		} else {
			echo '[{"response":"false", "reason":"Incomplete Info"}]';
		}
		break;

	case 'askExplorer':
		$a = ($_GET[idVersion] == "" || $_GET[idVersion] == "0" || $_GET[idVersion] == "undefined" ? "" : " and version.id = '".$_GET[idVersion]."' ");
		$sql = "SELECT feature.id as featureId, feature.code,feature.engine,feature.doors,feature.acceleration,feature.passagers,feature.speedMax,feature.powerMax,feature.steering,feature.fuel,feature.feeding,feature.torque,feature.traction,feature.frontSuspension,feature.rearSuspension,feature.frontBrake,feature.wheels,feature.dimensionLength,feature.dimensionHeight,feature.dimensionWidth,feature.rearBrake,feature.weight,feature.trunk,feature.tank,feature.dimensionSignAxes,feature.warranty,feature.gear,feature.consumptionCity,feature.consumptionRoad,feature.yearModel,feature.yearProduced,feature.items,feature.picture,feature.dualFrontAirBag,feature.electricSteering,feature.hydraulicSteering,feature.airConditioning,feature.leatherSeat,feature.alarm,feature.autoGear,feature.absBrake,feature.traction4x4,feature.dateCreate,feature.countryOrigin,feature.dateUpdate,feature.hotAir,feature.heightAdjustment,feature.rearSeatSplit,feature.bluetoothSpeakerphone,feature.bonnetSea,feature.onboardComputer,feature.accelerationCounter,feature.rearWindowDefroster,feature.sidesteps,feature.fogLamps,feature.xenonHeadlights,feature.integratedGPSPanel,feature.rearWindowWiper,feature.bumper,feature.autopilot,feature.bucketProtector,feature.roofRack,feature.cdplayerUSBInput,feature.radio,feature.headlightsHeightAdjustment,feature.rearviewElectric,feature.alloyWheels,feature.rainSensor,feature.parkingSensor,feature.isofix,feature.sunroof,feature.electricLock,feature.electricWindow,feature.rearElectricWindow,feature.steeringWheelAdjustment,feature.description,feature.active,feature.userUpdate,feature.price, manufacturer.id as manufacturerId, manufacturer.name as manufacturerName, version.id as versionId, version.name as versionName, model.id as modelId, model.name as modelName from manufacturer, feature, version, model where model.idManufacturer = manufacturer.id and  version.active = 's' and feature.idVersion = version.id and version.idModel = model.id and model.id = '".$_GET[idModel]."' ".$a." ORDER BY feature.yearProduced DESC, feature.yearModel DESC limit 1 ";
		if ($_GET[action] == "debug") {
			echo $sql;
		}
		$query = mysql_query($sql) or die ('[{"response":"false", "reason":"'.mysql_error().'error #507"}]');
		$result="[";
		$loop=0;
		while ($res = mysql_fetch_array($query)) {
			switch (strtolower($res[fuel])) {
			 	case 'g':
					$fuelType = "Gasolina";
			 		break;
			 	case 'f':
			 		$fuelType = "Flex";
			 		break;
			 	case 'a':
			 		$fuelType = "Alcool";
			 		break;
			 	case 'd':
			 		$fuelType = "Diesel";
			 		break;
			 	case 'b':
				 	$fuelType = "Bio Diesel";
			 		break;
			 	case 'h':
			 		$fuelType = "Hibrido";
			 		break;
			 	default:
			 		$fuelType = $res[fuel];
			 		break;
			}
			$result .= ($loop > 0 ? "," : "");
			$result.='{
				"response":"true",
				"featureId":"'.$res[featureId].'",
				"manufacturerId":"'.$res[manufacturerId].'",
				"manufacturerName":"'.$res[manufacturerName].'",
				"modelId":"'.$res[modelId].'",
				"modelName":"'.$res[modelName].'",
				"versionId":"'.$res[versionId].'",
				"versionName":"'.$res[versionName].'",
		        "code":"'.$res[code].'",
		        "engine":"'.$res[engine].'",
		        "doors":"'.$res[doors].'",
		        "acceleration":"'.$res[acceleration].'",
		        "passagers":"'.$res[passagers].'",
		        "speedMax":"'.$res[speedMax].'",
		        "powerMax":"'.$res[powerMax].'",
		        "steering":"'.$res[steering].'",
		        "fuel":"'.$fuelType.'",
		        "feeding":"'.$res[feeding].'",
		        "torque":"'.$res[torque].'",
		        "traction":"'.$res[traction].'",
		        "frontSuspension":"'. trim(str_replace(array("\r", "\n"), "", $res[frontSuspension])).'",
		        "rearSuspension":"'.$res[rearSuspension].'",
		        "frontBrake":"'.$res[frontBrake].'",
		        "wheels":"'.str_replace("\"", "\\\"", $res[wheels]).'",
		        "dimensionLength":"'.$res[dimensionLength].'",
		        "dimensionHeight":"'.$res[dimensionHeight].'",
		        "dimensionWidth":"'.$res[dimensionWidth].'",
		        "rearBrake":"'.$res[rearBrake].'",
		        "weight":"'.$res[weight].'",
		        "trunk":"'.$res[trunk].'",
		        "tank":"'.$res[tank].'",
		        "dimensionSignAxes":"'.$res[dimensionSignAxes].'",
		        "warranty":"'.$res[warranty].'",
		        "gear":"'.$res[gear].'",
		        "consumptionCity":"'.$res[consumptionCity].'",
		        "consumptionRoad":"'.$res[consumptionRoad].'",
		        "yearModel":"'.$res[yearModel].'",
		        "yearProduced":"'.$res[yearProduced].'",
		        "picture":"'.$res[picture].'",
		        "dualFrontAirBag":"'.$res[dualFrontAirBag].'",
		        "electricSteering":"'.$res[electricSteering].'",
		        "hydraulicSteering":"'.$res[hydraulicSteering].'",
		        "airConditioning":"'.$res[airConditioning].'",
		        "leatherSeat":"'.$res[leatherSeat].'",
		        "alarm":"'.$res[alarm].'",
		        "autoGear":"'.$res[autoGear].'",
		        "absBrake":"'.$res[absBrake].'",
		        "traction4x4":"'.$res[traction4x4].'",
		        "countryOrigin":"'.$res[countryOrigin].'",
		        "hotAir":"'.$res[hotAir].'",
		        "heightAdjustment":"'.$res[heightAdjustment].'",
		        "rearSeatSplit":"'.$res[rearSeatSplit].'",
		        "bluetoothSpeakerphone":"'.$res[bluetoothSpeakerphone].'",
		        "bonnetSea":"'.$res[bonnetSea].'",
		        "onboardComputer":"'.$res[onboardComputer].'",
		        "accelerationCounter":"'.$res[accelerationCounter].'",
		        "rearWindowDefroster":"'.$res[rearWindowDefroster].'",
		        "sidesteps":"'.$res[sidesteps].'",
		        "fogLamps":"'.$res[fogLamps].'",
		        "xenonHeadlights":"'.$res[xenonHeadlights].'",
		        "integratedGPSPanel":"'.$res[integratedGPSPanel].'",
		        "rearWindowWiper":"'.$res[rearWindowWiper].'",
		        "bumper":"'.$res[bumper].'",
		        "autopilot":"'.$res[autopilot].'",
		        "bucketProtector":"'.$res[bucketProtector].'",
		        "roofRack":"'.$res[roofRack].'",
		        "cdplayerUSBInput":"'.$res[cdplayerUSBInput].'",
		        "radio":"'.$res[radio].'",
		        "headlightsHeightAdjustment":"'.$res[headlightsHeightAdjustment].'",
		        "rearviewElectric":"'.$res[rearviewElectric].'",
		        "alloyWheels":"'.$res[alloyWheels].'",
		        "rainSensor":"'.$res[rainSensor].'",
		        "parkingSensor":"'.$res[parkingSensor].'",
		        "isofix":"'.$res[isofix].'",
		        "sunroof":"'.$res[sunroof].'",
		        "electricLock":"'.$res[electricLock].'",
		        "electricWindow":"'.$res[electricWindow].'",
		        "rearElectricWindow":"'.$res[rearElectricWindow].'",
		        "steeringWheelAdjustment":"'.$res[steeringWheelAdjustment].'",
		        "description":"'.$res[description].'",
		        "active":"'.$res[active].'",
		        "price":"'.formatToPrice($res[price]).'",
		        "itemsSerie": "'.str_replace(array("\r", "\n", "\""), "", $res[items]).'"';
			$sqlOpt = "SELECT optionsVersion.id, optionsManufacturer.code, optionsManufacturer.name, optionsManufacturer.options, optionsManufacturer.price as priceManufacturer, optionsVersion.price as priceFeature from optionsManufacturer, optionsVersion WHERE optionsVersion.code = optionsManufacturer.code and optionsVersion.idVersion = '".$res[versionId]."' and optionsVersion.yearModel = '".$res[yearModel]."'";
			$queryOpt = mysql_query($sqlOpt) or die (mysql_error()."error #522");
			$result.= (mysql_num_rows($queryOpt) > 0 ? ',"options":' : "");
			$loopOpt=0;
			while ($resOpt = mysql_fetch_array($queryOpt)) {
				$result .= ($loopOpt > 0 ? "," : "[");
		        $result.='{
	        		"id":"'.$resOpt[id].'",
		        	"code":"'.$resOpt[code].'",
		        	"name":"'.$resOpt[name].'",
		        	"items":"'.str_replace("\"", "'", str_replace(array("\r", "\n"), "", $resOpt[options])).'",
		        	"price":"'.$resOpt[priceFeature].'"
		        	}';
		        $loopOpt++;
			}
			$result.=($loopOpt>0 ? "]" : "");

			$sqlSerieItem = "SELECT description from serieFeature WHERE idFeature = '".$res[featureId]."' and serieFeature.option = 's' order by description asc";
			$querySerieItem = mysql_query($sqlSerieItem) or die (mysql_error()."error #539");
			$result.= (mysql_num_rows($querySerieItem) > 0 ? ',"serieItems":' : "");
			$loopOpt=0;
			while ($resSerieItem = mysql_fetch_array($querySerieItem)) {
				$result .= ($loopOpt > 0 ? "," : "[");
		        $result.='{
		        	"description":"'.trim(utf8_encode($resSerieItem[description])).'"
		        	}';
		        $loopOpt++;
			}
			$result.=($loopOpt>0 ? "]" : "");

			// $sqlColors = "SELECT colorVersion.id, colorManufacturer.name, colorManufacturer.code, colorManufacturer.hexa, colorManufacturer.type, colorManufacturer.application, colorVersion.price from colorVersion, colorManufacturer where colorVersion.code = colorManufacturer.code and  idVersion = '".$res[versionId]."' and yearModel = '".$res[yearModel]."'";
			$sqlColors = "SELECT colorVersion.id, colorVersion.name, colorVersion.code, colorVersion.hexa, colorVersion.type, colorVersion.application, colorVersion.price from colorVersion where idVersion = '".$res[versionId]."' and yearModel = '".$res[yearModel]."'";
			$queryColors = mysql_query($sqlColors) or die (mysql_error()."error #552");
			$result.= (mysql_num_rows($queryColors) > 0 ? ',"colors":' : "");
			$loopOpt=0;
			while ($resColors = mysql_fetch_array($queryColors)) {
				$result .= ($loopOpt > 0 ? "," : "[");
		        $result.='{
		        	"name":"'.$resColors[name].'",
		        	"code":"'.$resColors[code].'",
		        	"hexa":"'.$resColors[hexa].'",
		        	"type":"'.$resColors[type].'",
		        	"price":"'.$resColors[price].'"
		        	}';
		        $loopOpt++;
			}
			$result.=($loopOpt>0 ? "]" : "");

			$sqlVrs = "SELECT version.id, version.name from version, feature WHERE feature.idVersion = version.id and version.idModel = '".$res[modelId]."' and version.active = 's' and feature.active = 's' group by version.id order by version.name";
			$queryVrs = mysql_query($sqlVrs) or die (mysql_error()."error #552");
			$result.= (mysql_num_rows($queryVrs) > 1 ? ',"sameModel":' : "");
			$loopOpt=0;
			while ($resVrs = mysql_fetch_array($queryVrs)) {
				if ($resVrs[id] != $res[versionId]){
				$result .= ($loopOpt > 0 ? "," : "[");
			        $result.='{
		        		"id":"'.$resVrs[id].'",
			        	"name":"'.$resVrs[name].'"
			        	}';
			    $loopOpt++;
			    }
			}
			$result.=($loopOpt>0 ? "]" : "");
			$result.='}';
			$loop++;
		}
		$result.="]";
		print_r($result);
		break;

	case 'upOrder':
		$sql = "UPDATE `megaOferta` set `order` = '".$_GET[numOrder]."' WHERE id = '".$_GET[mainId]."'";
		mysql_query($sql) or die ('[{"response":"false", "reason":"#error 542"}]');
		echo '[{"response":"true", "reason":"order changed"}]';
		break;

	case 'searchMega':
		$sqlMega = "SELECT megaOferta.id as megaOfertaId, manufacturer.name as manufacturerName, manufacturer.id as manufacturerId, model.id as modelId, model.name as modelName, version.id as versionId, version.name as versionName, megaOferta.price, megaOferta.yearModel, megaOferta.place, megaOferta.orderMega, megaOferta.description, megaOferta.picture, megaOferta.dateLimit FROM megaOferta, manufacturer, model, version WHERE megaOferta.manufacturerId = manufacturer.id and megaOferta.versionId = version.id AND megaOferta.modelId = model.id and megaOferta.id = '".$_GET[idItem]."'";
		$queryMega = mysql_query($sqlMega) or die ('[{"response":"false", "reason":"'.mysql_error().'#error 612"}]');
		$resMega = mysql_fetch_array($queryMega);
		echo '[{
			"response":"true",
			"megaOfertaId":"'.$resMega[megaOfertaId].'",
			"manufacturerId":"'.$resMega[manufacturerId].'",
			"manufacturerName":"'.$resMega[manufacturerName].'",
			"modelId":"'.$resMega[modelId].'",
			"modelName":"'.$resMega[modelName].'",
			"versionId":"'.$resMega[versionId].'",
			"versionName":"'.$resMega[versionName].'",
			"price":"'.$resMega[price].'",
			"yearModel":"'.$resMega[yearModel].'",
			"place":"'.$resMega[place].'",
			"orderMega":"'.$resMega[orderMega].'",
			"description":"'.$resMega[description].'",
			"picture":"'.$resMega[picture].'"
		}]';

		break;

	case 'askVersionMega':
		echo "[";
		if ($_GET[mainId] != "") { $mainId = " and version.idModel = '".$_GET[mainId]."' and model.id = '".$_GET[mainId]."' "; }
		$sql_v = "SELECT version.id, version.name, model.active, model.idSegment1, model.idSegment2, model.idSegment3, feature.yearModel from feature, version, model where feature.idVersion = version.id and version.active = 's' and version.name like ('%".$_GET[term]."%') ".$mainId." and feature.active = 's' group by version.id ORDER by version.name";

		$query_s_manuf = mysql_query($sql_v) or die (mysql_error()." error #15");
		$m = 0;
		while ($resM = mysql_fetch_array($query_s_manuf)) {
			if ($nameSeg == "") {
				$sSeg1 = "SELECT segment.name from segment WHERE segment.id = '".$resM[idSegment1]."'";
				$qSeg1 = mysql_query($sSeg1);
				$rSeg1 = mysql_fetch_array($qSeg1);
				$sSeg2 = "SELECT segment.name from segment WHERE segment.id = '".$resM[idSegment2]."'";
				$qSeg2 = mysql_query($sSeg2);
				$rSeg2 = mysql_fetch_array($qSeg2);
				$sSeg3 = "SELECT segment.name from segment WHERE segment.id = '".$resM[idSegment3]."'";
				$qSeg3 = mysql_query($sSeg3);
				$rSeg3 = mysql_fetch_array($qSeg3);
				$nameSeg = "ok";
			}
			if ($m > 0) { echo ","; }
			echo '{
					"id":"'.$resM[id].'",
					"label":"'.$resM[name].'",
					"category": "Versão",
					"table":"version",
					"idSegment1":"'.$resM[idSegment1].'",
					"segmentName1":"'.$rSeg1[name].'",
					"idSegment2":"'.$resM[idSegment2].'",
					"segmentName2":"'.$rSeg2[name].'",
					"idSegment3":"'.$resM[idSegment3].'",
					"segmentName3":"'.$rSeg3[name].'",
					"active":"'.$resM[active].'",
					"value":"'.$resM[name].'",
					"yearModel":"'.$resM[yearModel].'"
				}';
			$m++;
		}
		echo "]";
		break;

	case 'askYear':
		$sqlY = "SELECT yearModel from manufacturer, model, version, feature where feature.active = 's' and version.active = 's' and feature.idVersion = version.id and version.idModel = model.id and model.idManufacturer = manufacturer.id  and model.id = '".$_GET[modelId]."' and version.id = '".$_GET[versionId]."' and manufacturer.id = '".$_GET[manufacturerId]."' order by yearModel desc"; 
		// echo $sqlY;
		$qY = mysql_query($sqlY) or die('[{"response":"false", "reason":"'.mysql_error().'#error 635"}]');
		$m=0; echo "[";
		while ($resY = mysql_fetch_array($qY)) {
			if ($m > 0) { echo ","; }
			echo '{
				"response":"true",
				"yearModel":"'.$resY[yearModel].'"
				}';
			$m++;
		}
		echo "]";
		break;


}











?>