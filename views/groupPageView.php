<?php
require_once "./scripts/services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];
$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);

$groupData = $service->getGroupData($exploded[3]);
$groupId = $groupData["group_id"];
$groupHandle = $groupData["group_handle"];
$groupName = $groupData["group_name"];
$groupBio = $groupData["group_bio"];
$groupPublicFlag = $groupData["group_public_flag"];
$groupDateOfCreation = $groupData["group_date_of_creation"];

$groupMembers = $service->getGroupMembers($groupId);
$userIsMember = false;
$memberNicknames = [];

foreach ($groupMembers as $groupMember)
    array_push($memberNicknames, $groupMember["user_nickname"]);

if (isset($_SESSION["loggedIn"]))
    $userIsMember = in_array($_SESSION["username"], $memberNicknames);
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

<body class="h-full main-background-colorscheme">
    <div class="flex flex-col">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="flex flex-col items-center justify-center">
            <div class="items-center justify-center w-3/4 text-colorscheme">
                <div class="flex flex-col">
                    <div class="flex items-center justify-center">
                        <div id="cover-photo-element-group" class="w-1/2 h-64 mt-0 cursor-pointer hover:brightness-75">
                            <img id="cover-photo-group" src="<?= $context ?>/images/cover_photo.jpg" class="object-cover w-full h-full">
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <profile-photo id="profile-photo-element-group" class="z-50 w-40 h-40 cursor-pointer mt-[-6rem]">
                            <img id="profile-photo-group" src="<?= $context ?>/images/group_photo.jpg" class="object-cover w-full h-full rounded-full hover:brightness-75">
                        </profile-photo>
                    </div>
                    <div class="flex flex-row mx-12 justify-evenly">
                        <div class="invisible w-1/2"></div>
                        <div class="flex flex-col w-1/2">
                            <h2 class="flex items-center justify-center text-3xl font-bold text-colorscheme name">
                                <?= $groupName ?>
                            </h2>
                            <h3 class="flex items-center justify-center text-2xl"><?= $groupBio ?></h3>
                        </div>
                        <div class="flex items-center justify-end w-1/2">
                            <?php
                            if ($userIsMember == false) {
                            ?>
                                <form method="POST" action="<?= $context ?>/scripts/joinGroup.php">
                                    <input type="hidden" name="groupRedirect" value="<?= $groupHandle ?>">
                                    <input type="hidden" name="groupId" value="<?= $groupId ?>">
                                    <?php
                                    if (isset($_SESSION["loggedIn"])) {
                                    ?>
                                        <input type="hidden" name="userId" value="<?= $_SESSION["userId"] ?>">
                                    <?php
                                    }
                                    ?>
                                    <input type="hidden" name="groupPublicFlag" value="<?= $groupPublicFlag ?>">
                                    <button type="submit" name="submitted" class="p-2 px-4 text-lg font-bold text-center text-white transition-all duration-300 rounded-full max-h-fit confirm-button-colorscheme">
                                        <i class="fa-solid fa-circle-plus"></i>
                                        <span>Join Group</span>
                                    </button>
                                </form>
                            <?php
                            } else if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true && $userIsMember == true) {
                            ?>
                                <form method="POST" action="<?= $context ?>/scripts/leaveGroup.php">
                                    <input type="hidden" name="groupRedirect" value="<?= $groupHandle ?>">
                                    <input type="hidden" name="groupId" value="<?= $groupId ?>">
                                    <input type="hidden" name="userId" value="<?= $_SESSION["userId"] ?>">
                                    <input type="hidden" name="groupPublicFlag" value="<?= $groupPublicFlag ?>">
                                    <button type="submit" name="submitted" class="p-2 px-4 text-lg font-bold text-center text-white transition-all duration-300 bg-red-400 rounded-full max-h-fit hover:bg-red-500 dark:bg-red-500 dark:hover:bg-red-600">
                                        <i class="fa-solid fa-circle-minus"></i>
                                        <span>Leave Group</span>
                                    </button>
                                </form>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <hr class="m-2 divider-colorscheme" />
                <ul class="flex flex-row items-center justify-center gap-2 text-3xl text-center text-colorscheme drop-shadow">
                    <li class="flex">
                        <a id="show-group-threads" class="flex items-center justify-center text-xl header-element ">
                            Threads
                        </a>
                    </li>
                    <li class="flex">
                        <a id="show-group-members" class="flex items-center justify-center text-xl header-element">
                            Members
                        </a>
                    </li>
                    <li class="flex">
                        <a id="show-group-statistics" class="flex items-center justify-center text-xl header-element">
                            Statistics
                        </a>
                    </li>
                    <li class="flex">
                        <a id="show-group-about" class="flex items-center justify-center text-xl header-element">
                            About
                        </a>
                    </li>
                </ul>

                <div class="flex flex-col items-center w-full mb-2">
                    <div id="group-threads" class="hidden">
                        <?php
                        $threads = $service->getGroupThreads($groupId);
                        foreach ($threads as $thread) {
                            $threadTitle = $thread["thread_title"];
                            $threadText = $thread["thread_text"];
                            $threadPoster = $thread["thread_poster"];
                            $threadId = $thread["thread_id"];
                            $threadPositiveRating = $thread["thread_positive_rating"];
                            $threadNegativeRating = $thread["thread_negative_rating"];
                            include "./components/thread.php";
                        }
                        ?>
                    </div>
                    <div id="group-members" class="hidden mt-2">
                        <div class="flex flex-wrap justify-center gap-6">
                            <?php
                            foreach ($groupMembers as $groupMember) {
                                $userNickname = $groupMember["user_nickname"];
                                require "./components/browserPageUser.php";
                            }
                            ?>
                        </div>
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
                                <div class="flex flex-row gap-2 text-xl ">
                                    <span class="font-bold">Created by:</span>
                                    <?php
                                    $groupAdmin = $service->getGroupAdmin($groupId);
                                    ?>
                                    <a class="font-normal hover:underline" href="<?= $context ?>/profile/<?= $groupAdmin['user_nickname'] ?>">@<?= $groupAdmin['user_nickname'] ?> </a>
                                </div>

                                <div class="flex flex-row gap-2 text-xl">
                                    <span class="font-bold">From:</span>
                                    <span class="font-normal"><?= explode(" ", $groupDateOfCreation)[0] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/groupProfilePage.js"></script>
</body>

</html>