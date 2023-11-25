<?php
require_once "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$service = new AccountService();

if (strlen($_POST["groupHandle"]) > 20)
    $groupHandle = substr($_POST["groupHandle"], 0, 19);
else
    $groupHandle = $_POST["groupHandle"];

if (str_contains($groupHandle, " "))
    $groupHandle = str_replace(" ", "_", $groupHandle);

if (isset($_POST["groupPrivate"]) && $_POST["groupPrivate"] === 'on')
    $groupPrivate = 0;
else
    $groupPrivate = 1;

$alreadyExists = $service->getGroupId($groupHandle);

if ($alreadyExists) {
    $_SESSION["invalid"] = true;
    header("Location:$context/create/group");
} else {
    $service->addGroup($groupHandle, $_POST["groupName"], $_POST["groupBio"], $groupPrivate, $_POST["groupAdmin"]);
    header("Location:$context/group/$groupHandle");
}
