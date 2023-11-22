<?php
require_once "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$service = new AccountService();

$service->rateThread($_POST["threadId"], $_SESSION["userId"], 0);
