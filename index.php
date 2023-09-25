<!DOCTYPE html>
<html>

<head>
    <title>Threads demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="dist/style.css" rel="stylesheet">
</head>

<body>
<?php
// Connecting to DB 
try {
    $db = new PDO("mysql:host=localhost;dbname=xduric06;port=/var/run/mysql/mysql.sock", 'xduric06', 'j4sipera');
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    die();
}

$query = $db->prepare('SELECT thread.thread_title, thread.thread_text, reply.poster_id, reply.reply_text, U1.user_nick AS "thread_poster", U2.user_nick AS "reply_poster" FROM thread
LEFT JOIN user U1 ON thread.poster_id = U1.user_id
LEFT JOIN reply ON reply.thread_id = thread.thread_id
LEFT JOIN user U2 ON reply.poster_id = U2.user_id');

$query->execute();

while ($thread = $query->fetch(PDO::FETCH_ASSOC)) {
    $threadTitle = $thread["thread_title"];
    $threadText = $thread["thread_text"];
    $threadPoster = $thread["thread_poster"];
    $replyText = $thread["reply_text"];
    $replyPosterId = $thread["poster_id"];
    $replyPoster = $thread["reply_poster"];
    include "./components/thread.php";
    if ($replyPosterId)
        include "./components/reply.php";
}
?>
</body>

</html>