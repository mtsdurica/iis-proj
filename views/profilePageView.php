<?php
$context = $_SERVER["CONTEXT_PREFIX"];
$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);
session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=xduric06;port=/var/run/mysql/mysql.sock", 'xduric06', 'j4sipera');
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    die();
}

$userDataQuery = $db->prepare("SELECT users.user_id, users.user_full_name, users.user_email, users.user_gender, users.user_birthdate FROM users WHERE users.user_id = ?");
$userDataQuery->execute([$exploded[3]]);

while ($userData = $userDataQuery->fetch(PDO::FETCH_ASSOC)) {
    $userId = $userData["user_id"];
    $userFullname = $userData["user_full_name"];
    $userEmail = $userData["user_email"];
    $userGender = $userData["user_gender"];
    $userBirthdate = $userData["user_birthdate"];
}


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

<body class="items-center h-full main-background-colorscheme" style="min-width: 650px; height: 470px;">
    <div class="flex flex-col w-full h-full">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="flex items-center justify-center">
            <div id="cover-photo-element" class="mt-0 cursor-pointer brightness-filter" style="width: 650px; height: 250px;">
                <img id="cover-photo" src="./views/photos/mountain.jpg" class="w-full h-full" style="object-fit: cover;">
            </div>
        </div>

        <div class="flex items-center justify-center">
            <div id="change-cover-photo" class="hidden z-1" style="margin-top: -320px;">
                <input type="file" id="cover-photo-input" class="hidden" accept="image/*">
                <div id="" class="p-2 m-2 mt-4 transition-all rounded-lg header-colorscheme w-fit drop-shadow-xl profile-dropdown cover-photo-menu">
                    <a class="block cursor-pointer header-dropdown-element change-cover-photo">
                        <span class="pl-1">Change photo</span>
                    </a>
                    <a class="block cursor-pointer header-dropdown-element delete-cover-photo">
                        <span class="pl-1">Delete photo</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center">
            <profile-photo id="profile-photo-element" class="z-50 cursor-pointer" style="width: 150px; height: 150px; margin-top: -100px;">
                <img id="profile-photo" src="./views/photos/cat.jpg" class="w-full h-full rounded-full brightness-filter" style="object-fit: cover;">
            </profile-photo>
        </div>

        <div class="flex items-center justify-center">
            <div id="change-profile-photo" class="absolute z-50 hidden" style="margin-top: 100px;">
                <input type="file" id="profile-photo-input" class="hidden" accept="image/*">
                <div id="" class="p-2 m-2 mt-4 transition-all rounded-lg header-colorscheme w-fit drop-shadow-xl profile-dropdown cover-photo-menu">
                    <a class="block cursor-pointer header-dropdown-element change-profile-photo">
                        <span class="pl-1">Change photo</span>
                    </a>
                    <a class="block cursor-pointer header-dropdown-element delete-profile-photo">
                        <span class="pl-1">Delete photo</span>
                    </a>
                </div>
            </div>
        </div>

        <h2 class="flex items-center justify-center mt-2 text-3xl font-bold text-colorscheme name">
            <?= $userId ?>
        </h2>


        <ul class="flex flex-row items-center justify-center p-2 mt-4 text-3xl text-center text-colorscheme drop-shadow">
            <div class="flex" style=" border-top: thin solid;">
                <div class="flex">
                    <a id="show-user-threads" class="flex items-center justify-center text-xl header-element ">
                        Threads
                    </a>
                </div>
                <div class="flex">
                    <a id="show-user-groups" class="flex items-center justify-center text-xl header-element">
                        Groups
                    </a>
                </div>

                <div class="flex">
                    <a id="show-user-statistics" class="flex items-center justify-center text-xl header-element">
                        Statistics
                    </a>
                </div>

                <div class="flex">
                    <a id="show-user-about" class="flex items-center justify-center text-xl header-element">
                        About
                    </a>
                </div>
            </div>
        </ul>

    </div>
    <div class="items-center main-background-colorscheme">
        <div id="user-threads" class="hidden">
            <ul>
                <li>Thread 1</li>
                <li>Thread 2</li>
                <li>Thread 3</li>
                <li>Thread 4</li>
                <li>Thread 5</li>
                <li>Thread 6</li>
                <li>Thread 7</li>
            </ul>
        </div>

        <div id="user-statistics" class="hidden">
            <ul>
                <li>stat 1</li>
                <li>stat 2</li>
                <li>stat 3</li>
                <li>stat 4</li>
                <li>stat 5</li>
                <li>stat 6</li>
                <li>stat 7</li>
            </ul>
        </div>


        <div id="user-about" class="flex items-center justify-center h-full text-colorscheme">
            <div class="flex flex-row">
                <div class="flex flex-col gap-4 p-4 rounded-lg">

                    <div class="flex flex-col gap-2">
                        <h2 class=""> <a class="text-xl font-bold">Name: </a> <span class="text-base font-normal"><?= $userFullname ?></span></h2>
                    </div>

                    <div class="flex flex-col gap-2">
                        <h2 class=""> <a class="text-xl font-bold">Email: </a> <span class="text-base font-normal"><?= $userEmail ?></span></h2>
                    </div>

                    <div class="flex flex-col gap-2">
                        <h2 class=""> <a class="text-xl font-bold">Gender: </a> <span class="text-base font-normal"><?= $userGender ?></span></h2>
                    </div>

                    <div class="flex flex-col gap-2">
                        <h2 class=""> <a class="text-xl font-bold">Birthday: </a> <span class="text-base font-normal"><?= $userBirthdate ?></span></h2>
                    </div>

                </div>
            </div>
        </div>

        <div id="user-groups" class="hidden">
            <ul>
                <li>Group 1</li>
                <li>Group 2</li>
                <li>Group 2</li>
                <li>Group 2</li>
                <li>Group 2</li>
                <li>Group 2</li>
                <li>Group 2</li>
                <li>Group 7</li>
            </ul>
        </div>
    </div>

    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/userProfilePage.js"></script>
</body>

</html>

<style>
    .brightness-filter:hover {
        filter: brightness(0.75);
    }
</style>