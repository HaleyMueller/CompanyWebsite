<?php
include $_SERVER['DOCUMENT_ROOT'].'/Company/API/DatabaseConnection.php';
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/Company/Users/ProfilePictures/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

$path_parts = pathinfo($_FILES["fileToUpload"]["name"]);
$extension = strtoupper($path_parts['extension']);

$test = $target_dir . $_GET['UserID'] . "." . $extension;

echo 'This is the file:'.$extension.'<br>';
/*
if (is_dir($upload_dir) && is_writable($upload_dir)) {
    // do upload logic here
} else {
    echo 'Upload directory is not writable, or does not exist.';
}*/

if($check !== false) {
    //echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
    echo "<h1>File is not an image.</h1>";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

if (file_exists($target_file)) {
    echo "<h1>Sorry, file already exists.<h1><h3>Try renaming the file</h3>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $test)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $href = "/Company/Users/ShowUser?UserID=".$_GET['UserID'];
        $sql = "UPDATE `User` SET `Picture` = '".$extension."' WHERE `User`.`UserID` = " . $_GET['UserID'];
        $query = mysqli_query($conn, $sql);

        if (!$query) {
            echo 'failed';
            die("Error Found " . mysqli_error($conn));
        }
        //echo $test;
        echo "<script>window.location.href = '".$href."'</script>";
    } else {
        echo "<h1>Sorry, there was an error uploading your file.</h1>";
    }
}

function findexts ($filename)
{
    $filename = strtolower($filename) ;
    $exts = split("[/\\.]", $filename) ;
    $n = count($exts)-1;
    $exts = $exts[$n];
    return $exts;
}
?>