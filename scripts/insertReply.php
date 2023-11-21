<?php
require_once "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$service = new AccountService();

if ($_POST["threadPoster"] === "notLoggedIn")
    header("Location:$context/login");

if ($service->addReply($_POST["threadContent"], $_POST["threadPoster"], $service->getGroupId($_POST["threadGroup"]), $_POST["threadReply"])) {
    $redirectId = $_POST["threadReply"];
    header("Location:$context/thread/$redirectId");
    $_SESSION["threadPosted"] = true;
} else {
    header("Location:$context/thread/$redirectId");
    $_SESSION["threadPosted"] = false;
}
