<?php
require_once "./scripts/services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];

$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);

$threadData = $service->getThreadData($exploded[3]);
$threadTitle = $threadData["thread_title"];
$threadText = $threadData["thread_text"];
$threadPoster = $threadData["thread_poster"];
$threadId = $threadData["thread_id"];
$threadPositiveRating = $threadData["thread_positive_rating"];
$threadNegativeRating = $threadData["thread_negative_rating"];
$groupHandle = $threadData["group_handle"];
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title><?= $threadTitle ?> | Threadit</title>
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
            <div class="flex flex-col w-full p-2 m-1">
                <div class="h-full overflow-auto no-scrollbar">
                    <div class="flex flex-col gap-4">
                        <!-- Thread -->
                        <div class="flex flex-col px-4 py-2 mt-2 rounded-lg mx-80 thread-colorscheme text-colorscheme drop-shadow-md">
                            <div class="flex flex-col">
                                <div class="flex flex-row justify-between">
                                    <div class="flex flex-row">
                                        <span class="text-sm text-slate-500 dark:text-slate-400">
                                            Posted by:
                                        </span>
                                        <object class="px-1 text-sm text-slate-500 dark:text-slate-400 hover:underline">
                                            <a href="<?= $context ?>/profile/<?= $threadPoster ?>">
                                                <?= $threadPoster ?>
                                            </a>
                                        </object>
                                        <span class="text-sm text-slate-500 dark:text-slate-400">
                                            in
                                        </span>
                                        <object class="px-1 text-sm text-slate-500 dark:text-slate-400 hover:underline">
                                            <a href="<?= $context ?>/group/<?= $groupHandle ?>">
                                                <?= $groupHandle ?>
                                            </a>
                                        </object>
                                    </div>
                                    <?php
                                    $groupAdmin = $service->getGroupAdmin($service->getGroupId($groupHandle));
                                    $groupModerators = $service->getGroupModeratorsUsernames($service->getGroupId($groupHandle));
                                    if((isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true && $_SESSION['isAdmin'] === true) ||
                                        (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true && $_SESSION["username"] === $threadPoster) ||
                                        (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true && $_SESSION["username"] === $groupAdmin["user_nickname"]) ||
                                        (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true && !empty($groupModerators) && in_array($_SESSION["username"], $groupModerators))) {
                                    ?>
                                    <div class="flex flex-row gap-2">
                                        <object class="text-sm hover:underline text-slate-500 dark:text-slate-400">
                                            <a href="<?= $context ?>/edit/<?= $threadId ?>">
                                                Edit
                                            </a>
                                        </object>
                                        <form method="POST" action="<?= $context ?>/scripts/deleteThread.php" class="text-sm hover:underline text-slate-500 dark:text-slate-400">
                                            <input type="hidden" name="threadId" value="<?= $threadId ?>">
                                            <button class="hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="flex flex-row">
                                    <h3 class="text-xl">
                                        <?= $threadTitle ?>
                                    </h3>
                                </div>
                                <div class="flex flex-col justify-center w-full h-full">
                                    <p class="text-base">
                                        <?= $threadText ?>
                                    </p>
                                </div>
                                <hr class="mt-4 divider-colorscheme" />
                                <?php
                                $positiveRatings = $service->getPositiveRatingsForThread($threadId);
                                $negativeRatings = $service->getNegativeRatingsForThread($threadId);
                                if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                                    $posActive = "";
                                    $negActive = "";
                                    $thread = $service->getThreadRating($threadId, $_SESSION["userId"]);
                                    if (!empty($thread) && $thread["thread_rating"] == true)
                                        $posActive = "ranking-active";
                                    else if (!empty($thread) && $thread["thread_rating"] == false)
                                        $negActive = "ranking-active";
                                }
                                ?>
                                <form class="flex flex-row items-center justify-between px-4 mx-40 mt-2 rankingForm min-h-fit">
                                    <input type="hidden" name="threadId" value="<?= $threadId ?>">
                                    <div class="h-6 mr-2 border-l divider-colorscheme"></div>
                                    <button type="submit" name="positive" data-url="<?= $context ?>/scripts/rankPositive.php" class="<?= $posActive ?> flex flex-row items-center justify-center w-full px-2 py-1 text-base transition-all duration-300 rounded-md rankingButton hover:bg-slate-300 dark:hover:bg-slate-600">
                                        <i class="fa-solid fa-angle-up"></i>
                                        <div class="pl-4 text-base">
                                            <?= $threadPositiveRating + (int)$positiveRatings["COUNT(*)"] ?>
                                        </div>
                                    </button>
                                    <div class="h-6 mx-2 border-l divider-colorscheme"></div>
                                    <button type="submit" name="negative" data-url="<?= $context ?>/scripts/rankNegative.php" class="<?= $negActive ?> flex flex-row items-center justify-center w-full px-2 py-1 text-base transition-all duration-300 rounded-md rankingButton hover:bg-slate-300 dark:hover:bg-slate-600">
                                        <i class="text-base fa-solid fa-angle-down"></i>
                                        <div class="pl-4 text-base ">
                                            <?= $threadNegativeRating + (int)$negativeRatings["COUNT(*)"] ?>
                                        </div>
                                    </button>
                                    <div class="h-6 ml-2 border-l divider-colorscheme"></div>
                                </form>
                            </div>
                        </div>
                        <!-- Reply box -->
                        <div class="flex flex-col text-colorscheme">
                            <form id="newReply" action="<?= $context ?>/scripts/insertReply.php" method="POST" class="flex flex-col items-center justify-center drop-shadow-md">
                                <fieldset class="flex flex-col w-1/2 gap-2 p-2 rounded-lg min-w-fit header-colorscheme">
                                    <?php
                                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                                    ?>
                                        <input type="hidden" name="threadPoster" value="<?= $_SESSION['userId'] ?>">
                                    <?php
                                    } else {
                                    ?>
                                        <input type="hidden" name="threadPoster" value="notLoggedIn">
                                    <?php
                                    }
                                    ?>
                                    <input type="hidden" name="threadGroup" value="<?= $groupHandle ?>">
                                    <input type="hidden" name="threadReply" value="<?= $threadId ?>">
                                    <textarea form="newReply" class="p-2 pb-12 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="What is on your mind?" name="threadContent" required></textarea>
                                    <button class="items-center justify-center p-2 mt-2 text-lg text-center text-white transition-all rounded-lg confirm-button-colorscheme" type="submit" name="submitted">
                                        <span class="justify-center">Reply</span>
                                    </button>
                                </fieldset>
                            </form>
                        </div>
                        <!-- Replies -->
                        <div class="flex flex-col items-center justify-center">
                            <div class="flex flex-col w-5/6">
                                <?php
                                $threads = $service->getReplies($threadId);
                                foreach ($threads as $thread) {
                                    $threadTitle = $thread["thread_title"];
                                    $threadText = $thread["thread_text"];
                                    $threadPoster = $thread["thread_poster"];
                                    $threadId = $thread["thread_id"];
                                    $threadPositiveRating = $thread["thread_positive_rating"];
                                    $threadNegativeRating = $thread["thread_negative_rating"];
                                    $groupHandle = $thread["group_handle"];
                                    include "./components/reply.php";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
</body>

</html>