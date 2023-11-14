<?php
$context = $_SERVER["CONTEXT_PREFIX"];
require "services.php";

session_start();

$serv = new AccountService();

if ($_POST['publicFlag'] == 1){
    $newPublicStatus = 0;
} else {
    $newPublicStatus = 1;
}

$newData = array(
    'id' => $_POST['userId'],
    'publicStatus' => $newPublicStatus
);

if ($serv->changePublicStatus($newData))
{
    // redirect to the page with registration success
    header("Location:$context/adminDashboard");
} else {
    // show alert window
    echo '<script type="text/javascript"> window.onload = function () { alert("Error while changing ban status."); } </script>'; 
}