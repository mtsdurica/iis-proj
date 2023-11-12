<?php
require_once "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$service = new AccountService();

if ($service->addThread($_POST["threadTitle"], $_POST["threadContent"], $_POST["threadPoster"], $_POST["threadGroup"])) {
    header("Location:$context/");
    $_SESSION["threadPosted"] = true;
} else {
    header("Location:$context/");
    $_SESSION["threadPosted"] = false;
}
