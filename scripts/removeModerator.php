<?php
require_once "./services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];

if (isset($_POST["submitted"])) {
    $service->removeModerator($_POST["groupId"], $_POST["userNickname"]);
    $redirect = $_POST["groupRedirect"];
    header("Location:$context/group/$redirect");
}
