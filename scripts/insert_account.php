<?php

require "services.php";
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

$serv = new AccountService();

$newPerson = array(
    'user_nickname' => $_POST['user_nickname'],
    'user_password' => $_POST['user_password'],
    'user_email' => $_POST['user_email'],
    'user_full_name' => $_POST['user_full_name'],
    'user_gender' => $_POST['user_gender'],
    'user_birthdate' => $_POST['user_birthdate']
);

// Unique nickname validation
$available = $serv->isUsernameAvailable($_POST['user_nickname']);
echo $available;

if ($available != 0) {
    $_SESSION['errorMessage'] = "Username already exists. Try something else, please.";

    // Redirect back to the Register page
    header("Location:$context/register");
} else {
    // add user to the database
    $serv->addUser($newPerson);

    // redirect to the page with registration success
    header("Location:$context/register_success");
}

