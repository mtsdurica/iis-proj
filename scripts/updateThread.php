<?php
require_once "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$service = new AccountService();


$service->updateThread($_POST["threadTitle"], $_POST["threadContent"], $_POST["threadId"]);
$redirectId = $_POST["threadId"];
if (isset($_POST["replyId"]))
    $redirectId = $_POST["replyId"];
header("Location:$context/thread/$redirectId");
