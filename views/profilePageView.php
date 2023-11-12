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


$userDataQuery = $db->prepare("SELECT users.user_id, users.user_nickname, users.user_full_name, users.user_email, users.user_gender, users.user_birthdate FROM users WHERE users.user_nickname = ?");
$userDataQuery->execute([$exploded[3]]);

while ($userData = $userDataQuery->fetch(PDO::FETCH_ASSOC)) {
    $userId = $userData["user_id"];
    $userNickname = $userData["user_nickname"];
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

<body class="items-center h-full main-background-colorscheme">
    <!-- Page Container -->
    <div class="flex flex-col ">
        <?php
        require_once "./components/header.php";
        ?>
        <!-- Page Content Container -->
        <div class="flex flex-col items-center justify-center">
            <div class="items-center justify-center w-3/4 text-colorscheme">
                <div class="flex flex-col">
                    <div class="flex items-center justify-center">
                        <div id="cover-photo-element" class="w-1/2 h-64 mt-0 transition-all cursor-pointer hover:brightness-75">
                            <img id="cover-photo" src="<?= $context ?>/images/cover_photo.jpg" class="object-cover w-full h-full">
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <div id="change-cover-photo" class="hidden z-1 mt-[-20rem]">
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
                        <profile-photo id="profile-photo-element" class="z-50 w-40 h-40 transition-all cursor-pointer hover:brightness-75 mt-[-6rem]">
                            <img id="profile-photo" src="<?= $context ?>/images/profile_photo.jpg" class="object-cover w-full h-full rounded-full">
                        </profile-photo>
                    </div>

                    <div class="flex items-center justify-center">
                        <div id="change-profile-photo" class="absolute z-50 hidden mt-24">
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
                        <?= $userNickname ?>
                    </h2>
                </div>
                <hr class="m-2 divider-colorscheme" />
                <ul class="flex flex-row items-center justify-center gap-2 text-3xl text-center text-colorscheme drop-shadow">

                    <li class="flex">
                        <a id="show-user-threads" class="flex items-center justify-center text-xl header-element ">
                            Threads
                        </a>
                    </li>
                    <li class="flex">
                        <a id="show-user-groups" class="flex items-center justify-center text-xl header-element">
                            Groups
                        </a>
                    </li>

                    <li class="flex">
                        <a id="show-user-statistics" class="flex items-center justify-center text-xl header-element">
                            Statistics
                        </a>
                    </li>

                    <li class="flex">
                        <a id="show-user-about" class="flex items-center justify-center text-xl header-element">
                            About
                        </a>
                    </li>
                </ul>

                <div class="flex flex-col items-center w-full mb-2">
                    <div id="user-threads" class="hidden">
                        <?php
                        $threadsQuery = $db->prepare("SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, threads.thread_positive_rating, threads.thread_negative_rating, users.user_nickname AS 'thread_poster', groups.group_name FROM threads
                            LEFT JOIN users ON threads.poster_id = users.user_id
                            LEFT JOIN groups ON threads.group_id = groups.group_id
                            WHERE users.user_nickname = ?");

                        $threadsQuery->execute([$userNickname]);

                        while ($thread = $threadsQuery->fetch(PDO::FETCH_ASSOC)) {
                            $threadTitle = $thread["thread_title"];
                            $threadText = $thread["thread_text"];
                            $threadPoster = $thread["thread_poster"];
                            $threadId = $thread["thread_id"];
                            $threadPositiveRating = $thread["thread_positive_rating"];
                            $threadNegativeRating = $thread["thread_negative_rating"];
                            $groupName = $thread["group_name"];
                            include "./components/thread.php";
                        }
                        ?>
                    </div>
                    <div id="user-groups" class="hidden mt-2">
                        <div class="flex flex-wrap justify-center gap-6">
                            <?php
                            $groupsQuery = $db->prepare("SELECT groups.group_name FROM group_members 
                            LEFT JOIN groups ON group_members.group_id = groups.group_id
                            WHERE user_id = ?");

                            $groupsQuery->execute([$userId]);

                            while ($group = $groupsQuery->fetch(PDO::FETCH_ASSOC)) {
                                $groupId = $group["group_name"];
                                require "./components/browserPageGroup.php";
                            }
                            ?>
                        </div>
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
                    <div id="user-about" class="flex items-center justify-center mt-2">
                        <div class="flex flex-row">
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-row gap-2 text-xl ">
                                    <span class="font-bold">Name:</span>
                                    <span class="font-normal "><?= $userFullname ?></span>
                                </div>
                                <div class="flex flex-row gap-2 text-xl ">
                                    <span class="font-bold">Email:</span>
                                    <span class="font-normal "><?= $userEmail ?></span>
                                </div>
                                <div class="flex flex-row gap-2 text-xl ">
                                    <span class="font-bold">Gender:</span>
                                    <span class="font-normal"><?= $userGender ?></span>
                                </div>
                                <div class="flex flex-row gap-2 text-xl ">
                                    <span class="font-bold">Birthday:</span>
                                    <span class="font-normal "><?= $userBirthdate ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/userProfilePage.js"></script>
</body>

</html>