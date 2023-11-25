<?php
$context = $_SERVER["CONTEXT_PREFIX"];
require "services.php";
session_start();
$service = new AccountService();

if ($service->deleteGroup($_POST['groupId']))
    header("Location:$context/");
