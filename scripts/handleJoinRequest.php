<?php
require_once "../scripts/services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];

$updateTo = 0;
if ($_POST["accept"])
    $updateTo = 1;
else if ($_POST["accept"])
    $updateTo = 0;

$service->handleJoinRequest($_POST["requestGroupId"], $_POST["requestUserId"], true);
$redirect = $_POST["groupRedirect"];
header("Location:$context/group/$redirect");
