<?php
require_once "./scripts/services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];
$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);

$userData = $service->getUserData($exploded[3]);
$userId = $userData["user_id"];
$userNickname = $userData["user_nickname"];
$userFullname = $userData["user_full_name"];
$userEmail = $userData["user_email"];
$userGender = $userData["user_gender"];
$userBirthdate = $userData["user_birthdate"];
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body class="items-center h-full main-background-colorscheme text-colorscheme">
    <!-- Page Container -->
    <div class="flex flex-col h-full">
        <?php
        require_once "./components/header.php";
        ?>
        <!-- Page Content Container -->
        <div class="flex flex-row items-center justify-center h-full">
            <!-- Left side -->
            <div class="flex flex-col">
                <!-- Profile picture section -->
                <div class="flex flex-col gap-2">
                    <h1 class="font-bold text-2xl my-3">Profile picture</h1>
                    <!-- TODO: condition that will upload photo from database -->
                    <img src="<?= $context ?>/images/profile_photo.jpg" alt="Profile picture" width="150rem" height="150rem" class="transition-all rounded-lg m-2">
                    
                    <form class="flex flex-row justify-center text-center" action="<?= $context ?>/scripts/uploadProfilePic.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input class="px-2 py-1 text-sm text-center text-white transition-all rounded-lg basic-button-colorscheme" type="submit" name="submit" value="Upload image">
                    </form>
                </div> <!-- Profile picture section -->

                <!-- General settings form section -->
                <div class="flex flex-col">
                    <h2>General</h2>
                </div> <!-- General settings form section -->

            </div> <!-- Left side -->

            <!-- Right side -->
            <div class="flex flex-col">
                <!-- Banner picture section -->
                <div>
                    <h2>Banner</h2>
                </div> <!-- Banner picture section -->

                <!-- Password settings form section -->
                <div>
                    <h2>Password</h2>
                </div> <!-- Password settings form section -->

            </div> <!-- Right side -->
        </div>
    </div>
</body>