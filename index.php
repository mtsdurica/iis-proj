<?php
$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);
switch ($exploded[2]) {
    case ('index'):
    case ('index.php'):
    case (''):
        require_once __DIR__ . "/views/mainPageView.php";
        break;
    case ('profile'):
        require_once  __DIR__ . "/views/profilePageView.php";
        break;
    case ('submit'):
        require_once __DIR__ . "/views/threadCreationView.php";
        break;
    case ('browse'):
        require_once __DIR__ . "/views/groupsBrowserView.php";
        break;
    case ('login'):
        require_once __DIR__ . "/views/loginPageView.php";
        break;
    case ('logout'):
        require_once __DIR__ . "/scripts/logout.php";
        break;
    default:
        http_response_code(404);
        require_once __DIR__ . "/views/error404View.php";
        break;
}
