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

$userIsMember = false;

if (isset($_SESSION["loggedIn"]) === true)
    $userIsMember = $service->checkMembership($groupId, $_SESSION["userId"]);

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
                        <div id="cover-photo-element-group" class="w-1/2 h-64 mt-0">
                            <img id="cover-photo-group" src="<?= $context ?>/images/cover_photo.jpg" class="object-cover w-full h-full">
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <profile-photo id="profile-photo-element-group" class="z-50 w-40 h-40 mt-[-6rem]">
                            <img id="profile-photo-group" src="<?= $context ?>/images/group_photo.jpg" class="object-cover w-full h-full rounded-full">
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
                        <div class="flex flex-row items-center justify-end w-1/2 gap-4">
                            <?php
                            if ($userIsMember === false) {
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
                            } else if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true && $userIsMember === "notAccepted") {
                            ?>
                                <div type="submit" name="submitted" class="p-2 px-4 text-lg font-bold text-center border rounded-full dark:text-white divider-colorscheme max-h-fit">
                                    <span>Request pending</span>
                                </div>
                                <?php
                            } else if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true && $userIsMember == true) {
                                $moderatorRequests = $service->getPendingModerators($groupId);
                                $moderatorRequestsNames = [];
                                foreach ($moderatorRequests as $moderatorRequest)
                                    array_push($moderatorRequestsNames, $moderatorRequest["user_nickname"]);
                                $groupModerators = $service->getGroupModeratorsUsernames($groupId);
                                $groupAdmin = $service->getGroupAdmin($groupId);
                                $pendingMod = in_array($_SESSION["username"], $moderatorRequestsNames);
                                $isMod = in_array($_SESSION["username"], $groupModerators);
                                if (!$isMod) {
                                    if (!$pendingMod && ($_SESSION["userId"] !== $groupAdmin["user_id"])) {
                                ?>
                                        <form method="POST" action="<?= $context ?>/scripts/requestModerator.php">
                                            <input type="hidden" name="groupRedirect" value="<?= $groupHandle ?>">
                                            <input type="hidden" name="groupId" value="<?= $groupId ?>">
                                            <input type="hidden" name="userId" value="<?= $_SESSION["userId"] ?>">
                                            <button type="submit" name="submitted" class="p-2 px-4 text-lg font-bold text-center transition-all duration-300 rounded-full dark:text-white max-h-fit confirm-button-colorscheme">
                                                <span>Request Moderator</span>
                                            </button>
                                        </form>
                                    <?php
                                    } else if ($pendingMod) {
                                    ?>
                                        <div type="submit" name="submitted" class="p-2 px-4 text-lg font-bold text-center border rounded-full divider-colorscheme max-h-fit">
                                            <span>Request pending</span>
                                        </div>
                                <?php
                                    }
                                }
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
                <?php
                if ($groupPublicFlag == true || ($userIsMember === true && $userIsMember !== "notAccepted")) {
                ?>
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
                        <?php
                        $groupAdmin = $service->getGroupAdmin($groupId);
                        $groupModerators = $service->getGroupModeratorsUsernames($groupId);
                        if ((isset($_SESSION["loggedIn"]) && $_SESSION["userId"] === $groupAdmin["user_id"]) || (!empty($groupModerators) && isset($_SESSION["loggedIn"]) && in_array($_SESSION["username"], $groupModerators))) {
                        ?>
                            <li class="flex">
                                <a id="show-group-requests" class="flex items-center justify-center text-xl header-element">
                                    Requests
                                </a>
                            </li>
                        <?php
                        }
                        ?>
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
                            if (!empty($threads)) {
                                foreach ($threads as $thread) {
                                    $threadTitle = $thread["thread_title"];
                                    $threadText = $thread["thread_text"];
                                    $threadPoster = $thread["thread_poster"];
                                    $threadId = $thread["thread_id"];
                                    $threadPositiveRating = $thread["thread_positive_rating"];
                                    $threadNegativeRating = $thread["thread_negative_rating"];
                                    include "./components/thread.php";
                                }
                            }
                            ?>
                        </div>
                        <div id="group-members" class="hidden mt-2">
                            <div class="flex flex-col w-[32rem]">
                                <span class="mb-2 text-lg">Admin:</span>
                                <div class="flex flex-col justify-center gap-2">
                                    <?php
                                    $groupAdmin = $service->getGroupAdmin($groupId);
                                    $userNickname = $groupAdmin["user_nickname"];
                                    $userProfilePic =  $groupAdmin["user_profile_pic"];
                                    require "./components/groupPageAdmin.php";
                                    ?>
                                </div>
                                <?php
                                $groupModerators = $service->getGroupModerators($groupId);
                                if (!empty($groupModerators)) {
                                ?>
                                    <hr class="m-2 divider-colorscheme" />
                                    <span class="mb-2 text-lg">Moderators:</span>
                                    <div class="flex flex-col justify-center gap-2">
                                        <?php
                                        foreach ($groupModerators as $groupModerator) {
                                            $userNickname = $groupModerator;
                                            $userProfilePic = $groupMember["user_profile_pic"];
                                            require "./components/groupPageModerator.php";
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                $groupMembers = $service->getGroupMembers($groupId);
                                if (!empty($groupMembers)) {
                                ?>
                                    <hr class="m-2 divider-colorscheme" />
                                    <span class="mb-2 text-lg">Members:</span>
                                    <div class="flex flex-col justify-center gap-2">
                                        <?php
                                        foreach ($groupMembers as $groupMember) {
                                            $userNickname = $groupMember["user_nickname"];
                                            $userId = $groupMember["user_id"];
                                            $userProfilePic = $groupMember["user_profile_pic"];
                                            require "./components/groupPageMembers.php";
                                        }
                                        ?>
                                    </div>
                                <?php
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
                        <?php
                        $groupModerators = $service->getGroupModeratorsUsernames($groupId);
                        if (!empty($groupModerators) && isset($_SESSION["loggedIn"]) && in_array($_SESSION["username"], $groupModerators)) {
                        ?>
                            <div id="group-requests" class="hidden">
                                <div class="flex flex-row gap-2">
                                    <div class="flex flex-col">
                                        <span class="text-lg">Pending join requests:</span>
                                        <div class="mt-2 flex flex-col w-[32rem]">
                                            <div class="flex flex-col gap-2">
                                                <?php
                                                $pendingRequests = $service->getPendingJoinRequests($groupId);
                                                if (!empty($pendingRequests)) {
                                                    foreach ($pendingRequests as $pendingRequest) {
                                                        $requestUserNickname = $pendingRequest["user_nickname"];
                                                        $requestUserId = $pendingRequest["user_id"];
                                                        require "./components/groupJoinRequest.php";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        $groupAdmin = $service->getGroupAdmin($groupId);
                        if (isset($_SESSION["loggedIn"]) && $_SESSION["userId"] === $groupAdmin["user_id"]) {
                        ?>
                            <div id="group-requests" class="hidden">
                                <div class="flex flex-row gap-2">
                                    <div class="flex flex-col">
                                        <span class="text-lg">Pending join requests:</span>
                                        <div class="mt-2 flex flex-col w-[32rem]">
                                            <div class="flex flex-col gap-2">
                                                <?php
                                                $pendingRequests = $service->getPendingJoinRequests($groupId);
                                                if (!empty($pendingRequests)) {
                                                    foreach ($pendingRequests as $pendingRequest) {
                                                        $requestUserNickname = $pendingRequest["user_nickname"];
                                                        $requestUserId = $pendingRequest["user_id"];
                                                        require "./components/groupJoinRequest.php";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-lg">Pending moderator requests:</span>
                                        <div class="mt-2 flex flex-col w-[32rem]">
                                            <div class="flex flex-col gap-2">
                                                <?php
                                                $pendingModeratorRequests = $service->getPendingModerators($groupId);
                                                if (!empty($pendingModeratorRequests)) {
                                                    foreach ($pendingModeratorRequests as $pendingModeratorRequest) {
                                                        $requestUserNickname = $pendingModeratorRequest["user_nickname"];
                                                        $requestUserId = $pendingModeratorRequest["user_id"];
                                                        require "./components/groupModeratorRequest.php";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                } else {
                ?>
                    <div class="flex flex-col items-center justify-center gap-2 text-center">
                        <span class="flex text-3xl font-bold ">This group is private.</span>
                        <span class="flex text-2xl">Request joining or log in, if you are already a member!</span>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/groupProfilePage.js"></script>
</body>

</html>