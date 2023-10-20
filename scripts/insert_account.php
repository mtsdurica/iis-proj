<?php
require "services.php";
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>New Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Tailwind -->
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <!-- Dark mode -->
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<h1> Create new account </h1>

<?php
$serv = new AccountService();

$newPerson = array(
    'user_id' => $_POST['user_id'],
    'user_password' => $_POST['user_password'],
    'user_email' => $_POST['user_email'],
    'user_first_name' => $_POST['user_first_name'],
    'user_surname' => $_POST['user_surname'],
    'user_gender' => $_POST['user_gender'],
    'user_birthdate' => $_POST['user_birthdate']
);

$serv->addUser($newPerson);
?>

<p> The account has been created. </p>
<p><a href="index.php">Back</a></p>