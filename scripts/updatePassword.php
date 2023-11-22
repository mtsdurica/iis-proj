<?php
require_once "services.php";
session_start();
$serv = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];

$statusMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Retrieve form data
    $oldPassword = $_POST["user_old_password"];
    $newPassword = $_POST["user_new_password"];
    $newPasswordConf = $_POST["user_new_password_conf"];
    $userId = $_POST["userId"];
    $userNickname = $_POST["userNickname"];

    $db_password = $serv->getPassword($userId);
    $oldPasswordComparison = password_verify($oldPassword, $db_password);

    // Perform basic validation
    if (empty($oldPassword) || empty($newPassword) || empty($newPasswordConf)) {
        $statusMessage = "All fields are required.";
    } elseif ($newPassword !== $newPasswordConf) {
        $statusMessage = "New passwords do not match.";
    } elseif (password_verify($oldPassword, $db_password) != true) {
        $statusMessage = "Old password is incorrect.";
    } else {

        if ($serv->updatePassword($userId, $newPassword))
        {
            $statusMessage = "Password successfully changed.";
        } else {
            $statusMessage = "Something went wrong.";
        }

    }
}

$_SESSION['statusMessage'] = $statusMessage;
echo $_SESSION['statusMessage'];

header("Location:$context/profile/$userNickname/settings");