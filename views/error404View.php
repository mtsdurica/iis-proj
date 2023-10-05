<!DOCTYPE html>
<html class="h-full">

<head>
    <title>ERROR 404</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./scripts/darkModeSetter.js"></script>
</head>

<?php
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();
?>

<body class="items-center justify-center h-full main-background-colorscheme">
    
<!-- main container -->
    <div class="flex flex-col items-center self-center justify-center h-full place-content-center text-colorscheme">
       
        <h1 class="text-2xl font-bold">
            Oooops! Something went wrong.
        </h1>  

        <div class="m-5">
            <img src="./images/404-error.png" alt="Page not found" style="width: 20rem;">
        </div>  

        <div class="flex flex-col items-center gap-1 px-5 py-2 text-2xl duration-300 rounded-lg cursor-pointer dark:hover:bg-slate-600 hover:bg-slate-200">
            <a href="<?= $context ?>/"><i class="fa-solid fa-house "></i></a>
            <p class="text-xs"> Back Home </p>
        </div>
    </div>

    <script type="text/javascript" src="./scripts/main.js"></script>
</body>