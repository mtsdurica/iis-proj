<?php

session_start();

$_SESSION = array();

$context = $_SERVER["CONTEXT_PREFIX"];

session_destroy();

header("Location:$context/");
