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

$query = $db->prepare('SELECT thread.thread_id, thread.thread_title, thread.thread_text, user.user_nick AS "thread_poster" FROM thread
LEFT JOIN user ON thread.poster_id = user.user_id');

$query->execute();

while ($thread = $query->fetch(PDO::FETCH_ASSOC)) {
    $threadTitle = $thread["thread_title"];
    $threadText = $thread["thread_text"];
    $threadPoster = $thread["thread_poster"];
    $threadId = $thread["thread_id"];
    include "./components/thread.php";
}
?>
</body>

</html>