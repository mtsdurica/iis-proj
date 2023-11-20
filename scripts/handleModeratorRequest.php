<?php
require_once "../scripts/services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];

$updateTo = false;
if ($_POST["requestSubmit"] == true)
    $updateTo = true;
else if ($_POST["requestSubmit"] == false)
    $updateTo = false;

$service->handleModeratorRequest($_POST["requestGroupId"], $_POST["requestUserId"], $updateTo);
$redirect = $_POST["groupRedirect"];
header("Location:$context/group/$redirect");
