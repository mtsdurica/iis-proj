<?php
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=xduric06;port=/var/run/mysql/mysql.sock", 'xduric06', 'j4sipera');
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Threads demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <style>
        .name-align {
            margin-left: -80px; /* Adjust as needed */
            margin-top: -60px; /* Adjust as needed */
            text-align: center; /* Add this to center the text horizontally */
        }
    </style>
</head>

<body class="h-full">
    <div class="flex flex-col h-full header-colorscheme" style="height: 570px;">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="flex items-center">
            <cover-photo-button class="mt-0 cursor-pointer photo-button" style="width: 800px; height: 300px; margin: 0 auto;" onclick="CoverPhotoMenu(event)">
                <img id="/cover-photo" src="./views/photos/mountain.jpg" class="w-full h-full" style="object-fit: cover;">
            </cover-photo-button>
        </div>

        <div class="flex items-center">
            <profile-photo-button class="cursor-pointer z-1 photo-button" style="width: 150px; height: 150px; margin: 0 auto; margin-top: -100px;" onclick="showHelloText(event)">
                <img id="/profile-photo" src="./views/photos/cat.jpg" class="w-full h-full rounded-full" style="object-fit: cover;" >
            </profile-photo-button>
        </div>

        <div id="helloText" class="hidden">
            <div id="" class="p-2 m-2 mt-4 transition-all rounded-lg header-colorscheme w-fit drop-shadow-xl profile-dropdown profile-photo-menu">
                <a class="block header-dropdown-element" href="<?= $context ?>/login">
                    <span class="pl-1">Change photo</span>
                </a>
                <a class="block header-dropdown-element" href="<?= $context ?>/login">
                    <span class="pl-1">Delete photo</span>
                </a>
            </div>
        </div>

        <div id="change-cover-photo" class="hidden">
            <div id="" class="p-2 m-2 mt-4 transition-all rounded-lg header-colorscheme w-fit drop-shadow-xl profile-dropdown cover-photo-menu">
                <a class="block header-dropdown-element" href="<?= $context ?>/login">
                    <span class="pl-1">Change photo</span>
                </a>
                <a class="block header-dropdown-element" href="<?= $context ?>/login">
                    <span class="pl-1">Delete photo</span>
                </a>
            </div>
        </div>

        <h2 id="/name" class="font-bold text-1xl text-colorscheme name" style="margin: 0 auto; margin-top: 10px; font-size: 2rem;">
            John
            Doe
        </h2>

        <ul class="flex flex-row justify-between p-2 text-3xl text-colorscheme drop-shadow" style="width: 700px; margin: 0 auto; margin-top: 40px; border-top: thin solid;">
            <div class="flex">
                <a id="/" class="profile-view-element">
                    Threads
                </a>
            </div>
            <div class="flex">
                <a id="/groups" class="profile-view-element">
                    Groups
                    hello
                </a>
            </div>
            <div class="flex">
                <a id="/" class="profile-view-element">
                    Statistics
                </a>
            </div>
            <div class="flex">
                <a id="/" class="profile-view-element">
                    About
                </a>
            </div>
        </ul>
    </div>
    <div class="flex flex-col main-background-colorscheme">
        xxx
        <?php
        if ($groups === true) {
        ?>
            <a class="">
                hello
            </a>
        <?php
        }
        ?>
        <a href="<?= $context ?>/submit" class="p-2 px-4 mx-12 text-2xl font-bold text-center text-white transition-all duration-300 bg-green-400 rounded-full hover:bg-green-500 dark:bg-green-500 dark:hover:bg-green-600">
            + New Thread
        </a>
    </div>
    <script type="text/javascript" src="./scripts/main.js"></script>
</body>

<script>
   
</script>


<script>
    function CoverPhotoMenu(event) {
        var menubar = document.getElementById('change-cover-photo');
        menubar.classList.toggle('hidden');
        event.stopPropagation();
    }

    document.addEventListener('click', function (event) {
        var menubar = document.getElementById('change-cover-photo');
        if (!menubar.classList.contains('hidden')) {
            menubar.classList.add('hidden');
        }
    });
</script>
</html>
