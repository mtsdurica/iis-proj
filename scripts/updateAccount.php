<?php

require "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$serv = new AccountService();

$updatedData = array(
    'user_id' => $_POST['userId'],
    'user_nickname' => $_POST['user_nickname'],
    'user_full_name' => $_POST['user_full_name'],
    'user_birthdate' => $_POST['user_birthdate'],
    'everyone' => isset($_POST['everyone']) ? 1 : 0, // Default to 0 if not set
    'registered' => isset($_POST['registered']) ? 1 : 0, // Default to 0 if not set
    'groupMembers' => isset($_POST['groupMembers']) ? 1 : 0, // Default to 0 if not set
);


// update user data in the database
$serv->updateUser($updatedData);

$_SESSION['username'] = $_POST['user_nickname'];
$username = $_POST['user_nickname'];

header("Location:$context/profile/$username/settings");
?>