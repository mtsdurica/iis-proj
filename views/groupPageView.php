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

$groupDataQuery = $db->prepare("SELECT groups.group_id, groups.group_bio, groups.group_public_flag FROM groups WHERE groups.group_id = ?");
$groupDataQuery->execute([$exploded[3]]);

while ($groupData = $groupDataQuery->fetch(PDO::FETCH_ASSOC)) {
    $groupId = $groupData["group_id"];
    $groupBio = $groupData["group_bio"];
    $groupPublicFlag = $groupData["group_public_flag"];
}


?>
<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Group</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body class="items-center h-full main-background-colorscheme" style="min-width: 40rem; ">
    <div class="flex flex-col w-full h-full">
        <?php
        require_once "./components/header.php";
        ?>

        <div class="flex items-center justify-center">
            <div id="cover-photo-element-group" class="mt-0 cursor-pointer brightness-filter" style="width: 40rem; height: 16rem;">
                <img id="cover-photo-group" src="./images/cover_photo.jpg" class="w-full h-full" style="object-fit: cover;">
            </div>
        </div>

        <div class="flex items-center justify-center">
            <div id="change-cover-photo-group" class="hidden z-1" style="margin-top: -20rem;">
                <input type="file" id="cover-photo-input-group" class="hidden" accept="image/*">
                <div class="p-2 m-2 mt-4 transition-all rounded-lg header-colorscheme w-fit drop-shadow-xl profile-dropdown cover-photo-menu-group">
                    <a class="block cursor-pointer header-dropdown-element change-cover-photo-group">
                        <span class="pl-1">Change photo</span>
                    </a>
                    <a class="block cursor-pointer header-dropdown-element delete-cover-photo-group">
                        <span class="pl-1">Delete photo</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center">
            <profile-photo id="profile-photo-element-group" class="z-50 cursor-pointer" style="width: 10rem; height: 10rem; margin-top: -6rem;">
                <img id="profile-photo-group" src="./images/group_photo.jpg" class="w-full h-full rounded-full brightness-filter" style="object-fit: cover;">
            </profile-photo>
        </div>

        <div class="flex items-center justify-center">
            <div id="change-profile-photo-group" class="absolute z-50 hidden" style="margin-top: 6rem;">
                <input type="file" id="profile-photo-input-group" class="hidden" accept="image/*">
                <div id="" class="p-2 m-2 mt-4 transition-all rounded-lg header-colorscheme w-fit drop-shadow-xl profile-dropdown profile-photo-menu-group">
                    <a class="block cursor-pointer header-dropdown-element change-profile-photo-group">
                        <span class="pl-1">Change photo</span>
                    </a>
                    <a class="block cursor-pointer header-dropdown-element delete-profile-photo-group">
                        <span class="pl-1">Delete photo</span>
                    </a>
                </div>
            </div>
        </div>

        <h2 class="flex items-center justify-center mt-2 text-3xl font-bold text-colorscheme name">
            <?= $groupId ?>
        </h2>

        <ul class="flex flex-row items-center justify-center p-2 mt-4 text-3xl text-center text-colorscheme drop-shadow">
            <div class="flex" style=" border-top: thin solid;">
                <div class="flex">
                    <a id="show-group-threads" class="flex items-center justify-center text-xl header-element ">
                        Threads
                    </a>
                </div>
                <div class="flex">
                    <a id="show-group-members" class="flex items-center justify-center text-xl header-element">
                        Members
                    </a>
                </div>

                <div class="flex">
                    <a id="show-group-statistics" class="flex items-center justify-center text-xl header-element">
                        Statistics
                    </a>
                </div>

                <div class="flex">
                    <a id="show-group-about" class="flex items-center justify-center text-xl header-element">
                        About
                    </a>
                </div>
            </div>
        </ul>
    </div>

    <div class="items-center main-background-colorscheme ">
        <div id="group-threads" class="hidden">
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

        <div id="group-statistics" class="hidden">
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


        <div id="group-about" class="flex items-center justify-center h-full text-colorscheme">
            <div class="flex flex-row">
                <div class="flex flex-col gap-4 p-4 rounded-lg">
                    <div class="flex flex-col gap-2">
                        <h2 class=""> <a class="text-xl font-bold">Bio: </a> <span class="text-base font-normal"><?= $groupBio ?></span></h2>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h2 class=""> <a class="text-xl font-bold">Created by: </a> <span class="text-base font-normal">John Doe</span></h2>
                    </div>

                    <div class="flex flex-col gap-2">
                        <h2 class=""> <a class="text-xl font-bold">From: </a> <span class="text-base font-normal">2022-01-01</span></h2>
                    </div>
                </div>
            </div>
        </div>

        <div id="group-members" class="hidden">
            <ul>
                <li>Member 1</li>
                <li>Member 2</li>
            </ul>
        </div>
    </div>

    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/groupProfilePage.js"></script>
</body>

</html>

<style>
    .brightness-filter:hover {
        filter: brightness(0.75);
    }
</style>