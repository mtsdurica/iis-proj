<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Threads demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="dist/style.css" rel="stylesheet">
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
    <div class="flex flex-col bg-slate-100 h-full">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="overflow-hidden flex h-full">
            <!-- TODO: CSS needs to be fixed, this is just wrong -->
            <aside class="flex-1 p-2 min-w-fit m-1 items-center">
                <div class="p-2 flex-col">
                    <div class="bg-green-500 text-white transition-all hover:bg-green-600 text-center text-2xl font-bold mx-12 p-2 rounded-full">
                        <a href="<?= $context ?>/submit">
                            + New Thread
                        </a>
                    </div>
                    <div class="flex-col mt-4 border-b border-slate-300"></div>
                    <div class="flex-col text-2xl font-bold mx-16 p-2">
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
                <h2 class="text-2xl font-bold mx-40">
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
</body>

</html>