<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Threads demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="dist/style.css" rel="stylesheet">
</head>

<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=xduric06;port=/var/run/mysql/mysql.sock", 'xduric06', 'j4sipera');
} catch (PDOException $e) {
    echo "Connection error: ".$e->getMessage();
    die();
}
?>

<body class="h-full">
    <div class="flex flex-col h-full">
        <header class="justify-between text-center bg-gray-100 p-2">
            <a href="./index.php" class="text-3xl font-bold">Home</a>
            <a href="./pages/profile.php" class="text-3xl font-bold">Profile</a>
        </header>
        <div class="overflow-hidden flex h-full">
            <aside class="flex-1 p-2 min-w-fit  border border-black rounded-md m-1 items-center">
                <h2 class="text-2xl font-bold mx-16">
                    Your Groups
                </h2>
                <?php
                $groupsQuery = $db->prepare('SELECT group_id FROM groups');

                $groupsQuery->execute();

                while ($group = $groupsQuery->fetch(PDO::FETCH_ASSOC)) {
                    $groupId = $group["group_id"];
                    include "./components/main_page_group.php";
                }
                ?> 
            </aside>
                <div class="flex flex-col w-full border border-black rounded-md p-2 m-1">
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
                                include "./components/thread.php";
                            }
                            ?>                    
                        </div>
                    </div>
                </div>
        </div>
    </div>  
</body>

</html>