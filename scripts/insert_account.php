<?php
require "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();
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

<body class="items-center justify-center h-full main-background-colorscheme">
    
    <?php
    $serv = new AccountService();

    $newPerson = array(
        'user_id' => $_POST['user_id'],
        'user_password' => $_POST['user_password'],
        'user_email' => $_POST['user_email'],
        'user_full_name' => $_POST['user_full_name'],
        'user_gender' => $_POST['user_gender'],
        'user_birthdate' => $_POST['user_birthdate']
    );

    $serv->addUser($newPerson);
    ?>

    <!-- main container -->
    <div class="flex flex-col items-center self-center justify-center h-full place-content-center text-colorscheme">
       
        <div class="mb-20">
            <img src="<?= $context ?>/images/register_success.svg" alt="Register success" style="width: 20rem;">
        </div> 
    
        <h1 class="text-2xl font-bold mt-20">
            Registration was successful!
        </h1>  

        <p class="mt-3">
            Now you can login to your account.
        </p>
 

        <div class="flex flex-row items-center justify-center px-5 py-2 mt-10 text-2xl bg-green-500 rounded-full bg-opacity-70 hover:bg-green-800">
            <a href="<?= $context ?>/views/loginPageView.php" class="flex items-center justify-center gap-2 px-2 py-1 flew-row"> 
                <i class="fa-solid fa-chevron-left"></i>
                <span class="text-sm"> Log In </span> 
            </a>
        </div>
    </div>

    <script type="text/javascript" src="<?= $context?>/scripts/main.js"></script>
</body>