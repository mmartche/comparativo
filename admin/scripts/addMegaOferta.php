<?php
include ("./conectDB.php");
include ("./functions.php");

function uploadFile ($manufacturerId,$modelId,$versionId) {
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
			//echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		} else {
			$_FILES["file"]["name"] = $manufacturerId."-".$modelId."-".$versionId.".".end($temp);
			 //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			 //echo "Type: " . $_FILES["file"]["type"] . "<br>";
			 //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			 //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
				if (file_exists("../../carImages/" . $_FILES["file"]["name"])) {
					//echo $_FILES["file"]["name"] . " already exists. ";
				} else {
					move_uploaded_file($_FILES["file"]["tmp_name"],
					"../../carImagesMegaOferta/" . $_FILES["file"]["name"]);
					 //echo "Stored in: " . "../carImagesMegaOferta/" . $_FILES["file"]["name"];
					return $_FILES["file"]["name"];
					// echo "string";
				}
		}
	} else {
		//echo "Imagem incorreta";
	}
}
	//echo $_POST[btnAddMegaOferta];
switch ($_POST[btnAddMegaOferta]) {
	case 'Adicionar':
		$picTemp = uploadFile($_POST[manufacturerId],$_POST[modelId],$_POST[versionId]);
		$sqlAddMO = "INSERT INTO megaOferta (`manufacturerId`,`modelId`,`versionId`,`featureId`,`price`,`orderMega`,`yearModel`,`place`,`description`,`picture`,`dateIni`,`dateLimit`,`dateUpdate`) VALUES ('".$_POST[manufacturerId]."','".$_POST[modelId]."','".$_POST[versionId]."','".$_POST[featureId]."','".$_POST[price]."','".$_POST[orderMega]."','".$_POST[yearModel]."','".$_POST[place]."','".$_POST[description]."','".$picTemp."','".$_POST[dateIni]."','".$_POST[dateLimit]."',now())";
		//echo $sqlAddMO;
		mysql_query($sqlAddMO) or die("#error 71");
		break;
	case 'Atualizar':
		$picTemp = uploadFile($_POST[manufacturerId],$_POST[modelId],$_POST[versionId]);
		if ($picTemp != "") {
			$picTempSql = "`picture` = '".$picTemp."',";
		}
		$sqlUpdateMO = "UPDATE `megaOferta` SET `manufacturerId` = '".$_POST[manufacturerId]."', `modelId` = '".$_POST[modelId]."', `versionId` = '".$_POST[versionId]."', `featureId` = '".$_POST[featureId]."', `price` = '".$_POST[price]."', `orderMega` = '".$_POST[orderMega]."', `yearModel` = '".$_POST[yearModel]."', `place` = '".$_POST[place]."', `description` = '".$_POST[description]."', ".$picTempSql." `dateIni` = '".$_POST[dateIni]."', `dateLimit` = '".$_POST[dateLimit]."', `dateUpdate` = now() WHERE `id` = '".$_POST[megaOfertaId]."'";
		//echo $sqlUpdateMO;
		mysql_query($sqlUpdateMO) or die("#error 79");
		break;
}
//echo " done";
?>
<script> 
/*alert("Atualizado");*/
window.location="../megaOferta.php?timestamp=<?=rand()?>";
</script>
<a href="../index.php">Voltar a Home</a>