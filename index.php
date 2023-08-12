<?php
$target_dir = "videos/";
$uploadOk = 1;

if(isset($_POST["submit"])) {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Tarkista, onko tiedosto todellinen video vai ei
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["fileToUpload"]["tmp_name"]);
    if($mime != "video/mp4") {
        echo "Tiedosto ei ole video.";
        $uploadOk = 0;
    }

    // Tarkista, onko tiedosto jo olemassa
    if (file_exists($target_file)) {
        echo "Valitettavasti tiedosto on jo olemassa.";
        $uploadOk = 0;
    }

    // Yritä ladata tiedosto, jos tarkistukset ovat kunnossa
    if ($uploadOk == 0) {
        echo "Valitettavasti tiedostoa ei voitu ladata.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "Tiedosto ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " on ladattu.";
        } else {
            echo "Valitettavasti tiedoston lataamisessa tapahtui virhe.";
        }
    }
}
?>

<link rel = "icon" href = 
"https://megamaa.com/Beta/images/logo3.png" 
type = "image/x-icon">

<!DOCTYPE html>
<html>
<title>Thearex12.com - CustomCrew</title>
<head>
    <style>
    .video-container video {
        display: block;
        margin: 10px auto;
    }
    </style>
</head>
<body>

<!-- Lomake videon lataamiseen -->
<form action="" method="post" enctype="multipart/form-data">
  Valitse video ladattavaksi:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Lataa videosi Thearex12.com palvelimeen!" name="submit">
</form>

<!-- Näytä ladatut videot -->
<div class="video-container">
<?php
$videos = glob($target_dir . "*.*");
for ($i=0; $i<count($videos); $i++)
{
    $num = $videos[$i];
    echo '<video width="320" height="240" controls>';
    echo '<source src="'.$num.'" type="video/mp4">';
    echo 'Your browser does not support the video tag.';
    echo '</video>';
}
?>
</div>

</body>
</html>
