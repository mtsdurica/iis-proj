<?php
$context = $_SERVER["CONTEXT_PREFIX"];
require "services.php";

session_start();

$serv = new AccountService();

$id = $_POST['userId'];
echo $id;

if ($serv->deleteUser($id))
{
    // redirect back to the Admin Dashboard
    header("Location:$context/adminDashboard");
} else {
    // show alert window
    echo '<script type="text/javascript"> window.onload = function () { alert("Error while deleting user."); } </script>'; 
}

