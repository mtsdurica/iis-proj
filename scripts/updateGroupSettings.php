<?php

require "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$serv = new AccountService();


$updatedData = array(
    'group_id' => $_POST['groupId'],
    'group_handle' => $_POST['group_handle'],
    'group_name' => $_POST['group_name'],
    'group_bio' => $_POST['group_bio'],
    'public_flag' => isset($_POST['public_flag']) ? 1 : 0, // Default to 0 if not set
);


// update group data in the database
$serv->updateGroup($updatedData);

$_SESSION['group_handle'] = $_POST['group_handle'];
$groupHandle = $_POST['group_handle'];
header("Location:$context/group/$groupHandle/settings");
?>