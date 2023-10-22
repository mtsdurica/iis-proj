<?php
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

    <!-- main container -->
    <div class="flex flex-col items-center self-center justify-center h-full place-content-center text-colorscheme">
       
        <div class="mb-10">
            <img src="<?= $context ?>/images/register_success.svg" alt="Register success" style="width: 17rem;">
        </div> 
    
        <h1 class="text-2xl font-bold">
            Registration was successful!
        </h1>  

        <p class="mt-3">
            Now you can login to your account.
        </p>
 

        <div class="flex flex-row items-center justify-center px-5 py-2 mt-10 text-2xl bg-green-500 rounded-full bg-opacity-70 hover:bg-green-800">
            <a href="<?= $context ?>/views/loginPageView.php" class="flex items-center justify-center gap-2 px-2 py-1 flew-row"> 
                <span class="text-sm"> Log In </span> 
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
    </div>

    <script type="text/javascript" src="<?= $context?>/scripts/main.js"></script>
</body>