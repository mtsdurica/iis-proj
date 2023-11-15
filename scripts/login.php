<?php
require_once "../scripts/services.php";
session_start();


$context = $_SERVER["CONTEXT_PREFIX"];

if (isset($_POST["submitted"])) {
    $service = new AccountService();
    $user = $service->getLoginData($_POST["username"]);

    if (password_verify($_POST["password"], $user["user_password"])) {
        $_SESSION["userId"] = $user["user_id"];
        $_SESSION["username"] = $user["user_nickname"];
        $_SESSION["loggedIn"] = true;
        if ($user["user_nickname"] === "admin")
            $_SESSION["isAdmin"] = true;
        else $_SESSION["isAdmin"] = false;
        header("Location:$context/");
    } else {
        $_SESSION["invalid"] = true;
        header("Location:$context/login");
    }
}
