<?php
require_once "./scripts/services.php";
session_start();
$context = $_SERVER["CONTEXT_PREFIX"];

if (!isset($_SESSION["loggedIn"]))
    header("Location:$context/login");

$service = new AccountService();

$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);

$threadData = $service->getThreadData($exploded[3]);
if (!empty($threadData)) {
    $threadTitle = $threadData["thread_title"];
    $threadText = $threadData["thread_text"];
    $threadPoster = $threadData["thread_poster"];
    $threadId = $threadData["thread_id"];
    $threadPositiveRating = $threadData["thread_positive_rating"];
    $threadNegativeRating = $threadData["thread_negative_rating"];
    $groupHandle = $threadData["group_handle"];
} else {
    $replyData = $service->getReplyData($exploded[3]);
    $threadText = $replyData["thread_text"];
    $threadPoster = $replyData["thread_poster"];
    $threadId = $replyData["thread_id"];
    $threadPositiveRating = $replyData["thread_positive_rating"];
    $threadNegativeRating = $replyData["thread_negative_rating"];
    $replyId = $replyData["reply_id"];
}
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>New Thread</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body class="h-full main-background-colorscheme">
    <div class="flex flex-col h-full">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="flex flex-col items-center justify-center m-4">
            <div class="items-center justify-center w-3/4 text-colorscheme">
                <form id="newThread" class="flex flex-col items-center justify-center drop-shadow-md" action="<?= $context ?>/scripts/updateThread.php" method="POST">
                    <fieldset class="flex flex-col w-1/2 gap-2 p-4 rounded-lg min-w-fit header-colorscheme">
                        <input type="hidden" name="threadId" value="<?= $threadId ?>">
                        <?php
                        if (!empty($threadData)) {
                        ?>
                            <label class="px-2 text-lg" for="threadTitle">
                                Thread Title:
                            </label>
                            <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" value="<?= $threadTitle ?>" type="text" placeholder="Title" name="threadTitle" required>
                        <?php
                        } else {
                        ?>
                            <input type="hidden" name="replyId" value="<?= $replyId ?>">
                        <?php
                        }
                        ?>
                        <textarea form="newThread" class="p-2 pb-40 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" name="threadContent" required><?= $threadText ?></textarea>
                        <button class="items-center justify-center p-2 mt-2 text-lg text-center text-white transition-all rounded-lg confirm-button-colorscheme" type="submit" name="submitted">
                            <span class="justify-center">Update</span>
                        </button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
</body>

</html>