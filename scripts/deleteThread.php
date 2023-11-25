<?php
require_once "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$service = new AccountService();

$insertedId = $service->deleteThread($_POST["threadId"]);
header("Location:$context/");