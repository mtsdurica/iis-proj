<?php
require_once "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$service = new AccountService();

$insertedId = $service->addThread($_POST["threadTitle"], $_POST["threadContent"], $_POST["threadPoster"], $service->getGroupId($_POST["threadGroup"]));
header("Location:$context/thread/$insertedId");