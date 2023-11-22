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
$userProfilePic = $userData["user_profile_pic"];
$userBanner = $userData["user_banner"];
$userPublicUnregistered = $userData["user_public_for_unregistered_flag"];
$userPublicRegistered = $userData["user_public_for_registered_flag"];
$userPublicGroupMembers = $userData["user_public_for_members_of_group_flag"];
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
                            <?php
                            if ($userBanner === NULL || $userBanner === '') {
                                $bannerUrl =  $context . '/images/cover_photo.jpg';
                            } else {
                                $bannerUrl = $context . '/uploads/' . $userBanner;
                            }
                            ?>
                            <img id="cover-photo" src="<?= $bannerUrl ?>" class="object-cover w-full h-full">
                        </div>
                    </div>

                    <div class="flex items-center justify-center">
                        <profile-photo id="profile-photo-element" class="z-50 w-40 h-40 transition-all cursor-pointer hover:brightness-75 mt-[-6rem]">
                            <?php
                            if ($userProfilePic === NULL || $userProfilePic === '') {
                                $picUrl =  $context . '/images/profile_photo.jpg';
                            } else {
                                $picUrl = $context . '/uploads/' . $userProfilePic;
                            }
                            ?>
                            <img id="profile-photo" src="<?= $picUrl ?>" class="object-cover w-full h-full rounded-full">
                        </profile-photo>
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
                        $threads = $service->getUserThreads($userNickname);
                        foreach ($threads as $thread) {
                            $threadTitle = $thread["thread_title"];
                            $threadText = $thread["thread_text"];
                            $threadPoster = $thread["thread_poster"];
                            $threadId = $thread["thread_id"];
                            $threadPositiveRating = $thread["thread_positive_rating"];
                            $threadNegativeRating = $thread["thread_negative_rating"];
                            $groupHandle = $thread["group_handle"];
                            require "./components/thread.php";
                        }
                        ?>
                    </div>
                    <div id="user-groups" class="hidden mt-2">
                        <div class="flex flex-wrap justify-center gap-6">
                            <?php
                            $groups = $service->getUserGroupsById($userId);
                            foreach ($groups as $group) {
                                $groupName = $group["group_name"];
                                $groupHandle = $group["group_handle"];
                                $groupProfilePic = $group["group_profile_pic"];
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
    <script type="text/javascript" src="<?= $context ?>/scripts/userProfilePage.js"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
</body>

</html>