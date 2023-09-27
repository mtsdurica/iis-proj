<?php
$request = $_SERVER["REQUEST_URI"];
$context = $_SERVER["CONTEXT_PREFIX"];
switch ($request) {
    case ($context . '/index'):
    case ($context . '/index.php'):
    case ($context . '/'):
        require_once __DIR__ . "/views/mainPageView.php";
        break;
    case ($context . '/profile'):
        require_once  __DIR__ . "/views/profilePageView.php";
        break;
}
