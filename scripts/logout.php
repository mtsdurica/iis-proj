<?php
session_start();
$context = $_SERVER["CONTEXT_PREFIX"];
$_SESSION = array();
session_destroy();

header("Location:$context/");
