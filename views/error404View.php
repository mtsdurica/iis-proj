<!DOCTYPE html>
<html class="h-full">

<head>
    <title>ERROR 404</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<?php
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();
?>

<body class="items-center justify-center h-full overflow-hidden main-background-colorscheme">
    <?php
        require_once "./components/header.php";
    ?>
    <!-- main container -->
    <div class="flex flex-col items-center justify-center h-full text-colorscheme">
       
        <div class="m-0">
            <img src="./images/404-error.png" alt="Page not found" style="width: 20rem;">
        </div> 
    
        <h1 class="text-2xl font-bold">
            Oooops! Something went wrong.
        </h1>  

        <p class="mt-3">
            The page you are looking for was moved, removed, renamed or does not exist.
        </p>

        <a href="<?= $context ?>/" class="flex flex-row items-center justify-center px-5 py-2 mt-20 text-2xl transition-all duration-300 bg-red-500 rounded-full bg-opacity-70 hover:bg-red-800">
            <span class="flex items-center justify-center gap-2 px-2 py-1 flew-row"> 
                <i class="fa-solid fa-chevron-left"></i>
                <span class="text-sm"> Back to Home </span> 
            </span>
        </a>
    
    </div>

    <script type="text/javascript" src="./scripts/main.js"></script>
</body>