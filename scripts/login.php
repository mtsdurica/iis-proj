<?php
session_start();

$context = $_SERVER["CONTEXT_PREFIX"];

if (isset($_POST["submitted"])) {
    try {
        $db = new PDO("mysql:host=localhost;dbname=xduric06;port=/var/run/mysql/mysql.sock", 'xduric06', 'j4sipera');
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
        die();
    }

    $loginQuery = $db->prepare("SELECT user_id, user_password from users WHERE users.user_id = ?");
    $loginQuery->execute([$_POST["username"]]);

    $user = $loginQuery->fetch(PDO::FETCH_ASSOC);

    if (password_verify($_POST["password"], $user["user_password"])) {
        $_SESSION["username"] = $user["user_id"];
        $_SESSION["loggedIn"] = true;
        if ($user["user_id"] === "admin")
            $_SESSION["isAdmin"] = true;
        header("Location:$context/");
    } else {
        $_SESSION["invalid"] = true;
        header("Location:$context/login");
    }
}
