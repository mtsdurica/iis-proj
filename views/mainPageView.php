<?php
require_once "./scripts/services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Threads demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body class="h-full">
    <div class="flex flex-col h-full main-background-colorscheme">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="flex h-full overflow-hidden">
            <!-- TODO: CSS needs to be fixed, this is just wrong -->
            <aside class="flex p-1 m-1 min-w-fit ">
                <div class="flex-col items-center p-2 ">
                    <!-- Checking for being logged in done in the submit script -->
                    <div class="flex flex-row justify-center ">
                        <a href="<?= $context ?>/create/thread" class="p-2 px-4 mx-12 text-2xl font-bold text-center text-white transition-all duration-300 rounded-full confirm-button-colorscheme">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span class="">
                                New Thread
                            </span>
                        </a>
                    </div>
                    <hr class="flex-col mt-4 divider-colorscheme" />
                    <div class="flex flex-row items-baseline justify-between p-2 text-2xl font-bold text-colorscheme">
                        <div class="flex">
                            My Groups
                        </div>
                        <a href="<?= $context ?>/create/group" class="flex p-1 rounded-full hover:bg-slate-200 hover:dark:bg-slate-600">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                    <?php
                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                        $groups = $service->getGroupsByUsername($_SESSION["username"]);
                        foreach ($groups as $group) {
                            $groupName = $group["group_name"];
                            $groupHandle = $group["group_handle"];
                            $groupProfilePic = $group["group_profile_pic"];
                            require "./components/mainPageGroup.php";
                        }
                    }
                    ?>
                </div>
            </aside>
            <div class="flex flex-col w-full p-2 m-1">
                <?php
                if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                ?>
                    <h2 class="mx-40 text-2xl font-bold text-colorscheme">
                        My Feed
                    </h2>
                <?php
                } else {
                ?>
                    <h2 class="mx-40 text-2xl font-bold text-colorscheme">
                        Public Feed
                    </h2>
                <?php
                }
                ?>
                <div class="h-full overflow-auto no-scrollbar">
                    <div class="flex flex-col gap-4">
                        <?php
                        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                            $threads = $service->getUserGroupsThreads($_SESSION["username"]);
                            foreach ($threads as $thread) {
                                $threadTitle = $thread["thread_title"];
                                $threadText = $thread["thread_text"];
                                $threadPoster = $thread["thread_poster"];
                                $threadId = $thread["thread_id"];
                                $threadPositiveRating = $thread["thread_positive_rating"];
                                $threadNegativeRating = $thread["thread_negative_rating"];
                                $groupHandle = $thread["group_handle"];
                                include "./components/thread.php";
                            }
                        } else {
                            $threads = $service->getPublicThreads();
                            foreach ($threads as $thread) {
                                $threadTitle = $thread["thread_title"];
                                $threadText = $thread["thread_text"];
                                $threadPoster = $thread["thread_poster"];
                                $threadId = $thread["thread_id"];
                                $threadPositiveRating = $thread["thread_positive_rating"];
                                $threadNegativeRating = $thread["thread_negative_rating"];
                                $groupHandle = $thread["group_handle"];
                                include "./components/thread.php";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
</body>

</html>