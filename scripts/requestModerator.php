<?php
require_once "./services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];

if (isset($_POST["submitted"])) {
    $service->requestModerator($_POST["groupId"], $_POST["userId"]);
    $redirect = $_POST["groupRedirect"];
    header("Location:$context/group/$redirect");
}
