<?php
session_start();

if (isset($_POST["submitted"])) {
    try {
        $db = new PDO("mysql:host=localhost;dbname=xduric06;port=/var/run/mysql/mysql.sock", 'xduric06', 'j4sipera');
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
        die();
    }

    $loginQuery = $db->prepare("SELECT * from users WHERE users.user_id = ? AND users.user_password = ?");
    $loginQuery->execute([$_POST["username"], $_POST["password"]]);

    $user = $loginQuery->fetch(PDO::FETCH_ASSOC);

    if (isset($user)) {
        $_SESSION["username"] = $user["user_id"];
        $_SESSION["loggedIn"] = true;
    }

    header("Location:/~xduric06/");
}
