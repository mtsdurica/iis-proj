<?php
session_start();
require_once "services.php";

$context = $_SERVER["CONTEXT_PREFIX"];
$userNickname = $_POST['userNickname'];
$userId = $_POST['userId'];
$serv = new AccountService();

// This line cant be resolved with $context variable. There must be the whole path given.
// TODO: change to xduric06
$target_dir = "/homes/eva/xd/xdurac01/WWW/uploads/"; // specifies the directory where the file is going to be placed

$file = basename($_FILES["fileToUpload"]["name"]); // specifies the path of the file to be uploaded
$imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION)); // holds the file extension of the file (in lower case)

$file_name = $userId . "_profilePic." . $imageFileType;
$target_file = $target_dir . $file_name;
echo $target_file;
echo $_POST['userNickname'];
$uploadOk = 1;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
}
  
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
  
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        $serv->updateProfilePicColumn($userId, $file_name);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

header("Location:$context/profile/$userNickname/settings");
?>