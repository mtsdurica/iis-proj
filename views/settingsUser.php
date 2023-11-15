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

echo "user settings";
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
