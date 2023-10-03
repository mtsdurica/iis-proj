<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Threads demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

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

<body class="h-full">
    <div class="flex flex-col h-full main-background-colorscheme">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="flex h-full overflow-hidden">
            <!-- TODO: CSS needs to be fixed, this is just wrong -->
            <aside class="flex-1 p-1 m-1 min-w-fit ">
                <div class="flex-col items-center p-2 ">
                    <?php
                    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                    ?>
                        <a href="<?= $context ?>/submit" class="p-2 px-4 mx-12 text-2xl font-bold text-center text-white transition-all duration-300 bg-green-400 rounded-full hover:bg-green-500 dark:bg-green-500 dark:hover:bg-green-600">
                            + New Thread
                        </a>
                        <div class="flex-col mt-4 border-b divider-colorscheme"></div>
                        <div class="flex-col p-2 text-2xl font-bold text-colorscheme items-left">
                            <h2>
                                Your Groups
                            </h2>
                        </div>
                        <?php
                        // TODO: Needs update
                        // $groupsQuery = $db->prepare('SELECT group_id FROM groups');

                        // $groupsQuery->execute();

                        // while ($group = $groupsQuery->fetch(PDO::FETCH_ASSOC)) {
                        //     $groupId = $group["group_id"];
                        //     require "./components/mainPageGroup.php";
                        // }
                    } else {
                        ?>
                        <a href="<?= $context ?>/login" class="p-2 px-4 mx-12 text-2xl font-bold text-center text-white transition-all duration-300 bg-green-400 rounded-full hover:bg-green-500 dark:bg-green-500 dark:hover:bg-green-600">
                            + New Thread
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </aside>
            <div class="flex flex-col w-full p-2 m-1">
                <?php
                if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                ?>
                    <h2 class="mx-40 text-2xl font-bold text-colorscheme">
                        Your Feed
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
                <div class="overflow-auto no-scrollbar">
                    <div>
                        <?php
                        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                            // TODO: Needs update
                            // $threadsQuery = $db->prepare("SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, users.user_nick AS 'thread_poster' FROM threads
                            // LEFT JOIN users ON threads.poster_id = users.user_id");

                            // $threadsQuery->execute();

                            // while ($thread = $threadsQuery->fetch(PDO::FETCH_ASSOC)) {
                            //     $threadTitle = $thread["thread_title"];
                            //     $threadText = $thread["thread_text"];
                            //     $threadPoster = $thread["thread_poster"];
                            //     $threadId = $thread["thread_id"];
                            //     $groupId = $thread["group_id"];
                            //     require "./components/thread.php";
                            // }
                        } else {
                        ?>
                            <!-- publuic feed query-->
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./scripts/main.js"></script>
</body>

</html>