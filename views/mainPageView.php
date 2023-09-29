<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Threads demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
            localStorage.theme = 'dark';
        } else {
            document.documentElement.classList.remove('dark')
            localStorage.theme = 'light';
        }
    </script>
</head>

<?php
$context = $_SERVER["CONTEXT_PREFIX"];
try {
    $db = new PDO("mysql:host=localhost;dbname=xduric06;port=/var/run/mysql/mysql.sock", 'xduric06', 'j4sipera');
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    die();
}
?>

<body class="h-full">
    <div class="flex flex-col main-background-colorscheme h-full">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="overflow-hidden flex h-full">
            <!-- TODO: CSS needs to be fixed, this is just wrong -->
            <aside class="flex-1 p-2 min-w-fit m-1 ">
                <div class="p-2 flex-col items-center ">
                    <div class="bg-green-400 text-white transition-all hover:bg-green-500 dark:bg-green-500 dark:hover:bg-green-600 duration-300 text-center text-2xl font-bold mx-12 p-2 rounded-full cursor-pointer">
                        <a href="<?= $context ?>/submit" class="px-4">
                            + New Thread
                        </a>
                    </div>
                    <div class="flex-col mt-4 border-b divider-colorscheme"></div>
                    <div class="flex-col text-2xl font-bold p-2 text-colorscheme items-left">
                        <h2>
                            Your Groups
                        </h2>
                    </div>
                    <?php
                    $groupsQuery = $db->prepare('SELECT group_id FROM groups');

                    $groupsQuery->execute();

                    while ($group = $groupsQuery->fetch(PDO::FETCH_ASSOC)) {
                        $groupId = $group["group_id"];
                        require "./components/mainPageGroup.php";
                    }
                    ?>
                </div>
            </aside>
            <div class="flex flex-col w-full p-2 m-1">
                <h2 class="text-2xl font-bold mx-40 text-colorscheme">
                    Your Feed
                </h2>
                <div class="overflow-auto no-scrollbar">
                    <div>
                        <?php
                        $threadsQuery = $db->prepare('SELECT threads.thread_id, threads.thread_title, threads.thread_text, threads.group_id, users.user_nick AS "thread_poster" FROM threads
                            LEFT JOIN users ON threads.poster_id = users.user_id');

                        $threadsQuery->execute();

                        while ($thread = $threadsQuery->fetch(PDO::FETCH_ASSOC)) {
                            $threadTitle = $thread["thread_title"];
                            $threadText = $thread["thread_text"];
                            $threadPoster = $thread["thread_poster"];
                            $threadId = $thread["thread_id"];
                            $groupId = $thread["group_id"];
                            require "./components/thread.php";
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