<?php
if(isset($_POST['Submit'])){
    echo "<br>_FILES[file]:";
    var_dump($_FILES["file-image"]);
    echo "<br>#7 upload data<br>Working directory:";
    var_dump(getcwd());
    $workDir = getcwd();
    echo "<br>_FILES:";
    var_dump($_FILES);
    echo "<br>";
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file-image"]["name"]);
    $extension = end($temp);
    if ((($_FILES["file-image"]["type"] == "image/gif")
    || ($_FILES["file-image"]["type"] == "image/jpeg")
    || ($_FILES["file-image"]["type"] == "image/jpg")
    || ($_FILES["file-image"]["type"] == "image/pjpeg")
    || ($_FILES["file-image"]["type"] == "image/x-png")
    || ($_FILES["file-image"]["type"] == "image/png"))
    && in_array($extension, $allowedExts)) {
    // && ($_FILES["file-image"]["size"] < 20000) ==> check the file size
        if ($_FILES["file-image"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file-image"]["error"] . "<br>";
        } else {
            // $_FILES["file-image"]["name"] = $manufacturerName.".".end($temp);
            // $_FILES["file-image"]["name"] = str_replace($_FILES["file-image"]["name"], "%20", "-");
            // $_FILES["file-image"]["name"] = $manufacturerName."-".$modelName."-".$versionName."-".$featureId.".".end($temp);
            //$_FILES["file-image"]["name"] = "imagemmarcelo.".end($temp);
            echo "Upload: " . $_FILES["file-image"]["name"] . "<br>";
            echo "Type: " . $_FILES["file-image"]["type"] . "<br>";
            echo "Size: " . ($_FILES["file-image"]["size"] / 1024) . " kB<br>";
            echo "Temp file: " . $_FILES["file-image"]["tmp_name"] . "<br>";
                if (file_exists("./carImages/" . $_FILES["file-image"]["name"])) {
                    echo $_FILES["file-image"]["name"] . " already exists. ";
                } else {
                    move_uploaded_file($_FILES["file-image"]["tmp_name"],
                    "./carImages/" . $_FILES["file-image"]["name"]);
                    echo "Stored in: " . "./carImages/" . $_FILES["file-image"]["name"];
                    
                }
        }
    } else {
        echo "Invalid file";
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="file-image" id="txtPicture" placeholder="Imagem" />
    <input type="submit" name="Submit" value="ATUALIZAR" class="btnSave btnButton">
</form>
