<?php
$context = $_SERVER["CONTEXT_PREFIX"];
require "services.php";

session_start();

$serv = new AccountService();

if ($_POST['bannedFlag'] == 1){
    $newBannedStatus = 0;
} else {
    $newBannedStatus = 1;
}

$newData = array(
    'id' => $_POST['userId'],
    'banStatus' => $newBannedStatus
);
    if ($serv->changeBannedStatus($newData))
    {

        echo '<script type="text/javascript">
                window.onload = function () { alert("Ban status has been changed"); } 
              </script>'; 
        // redirect to the page with registration success
        header("Location:$context/adminDashboard");
    } else {
        echo '<script type="text/javascript">
                window.onload = function () { alert("Error while changing ban status."); } 
              </script>'; 
    }