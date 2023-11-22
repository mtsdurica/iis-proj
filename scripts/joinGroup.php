<?php
require_once "./services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];

if (isset($_POST["submitted"])) {
    if (isset($_SESSION["loggedIn"])) {
        if ($_POST["groupPublicFlag"] == true) {
            $service->joinGroupPublic($_POST["groupId"], $_POST["userId"]);
        } else {
            $service->joinGroupPrivate($_POST["groupId"], $_POST["userId"]);
        }
        $redirect = $_POST["groupRedirect"];
        header("Location:$context/group/$redirect");
    } else
        header("Location:$context/login");
}
