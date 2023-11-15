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
        if (isset($exploded[4]) && ($exploded[4] === "settings"))
            require_once __DIR__ . "/views/settingsUser.php";
        else
            require_once  __DIR__ . "/views/profilePageView.php";
        break;
    case ('group'):
        if (isset($exploded[4]) && ($exploded[4] === "settings"))
            require_once __DIR__ . "/views/settingsGroup.php";
        else
            require_once  __DIR__ . "/views/groupPageView.php";
        break;
    case ('dashboard'):
        require_once __DIR__ . "/views/dashboardPageView.php";
        break;
    case ('submit'):
        require_once __DIR__ . "/views/threadCreationView.php";
        break;
    case ('browse'):
        if (isset($exploded[3]) && ($exploded[3] === "groups" || $exploded[3] === "users"))
            require_once __DIR__ . "/views/browsePageView.php";
        else {
            http_response_code(404);
            require_once __DIR__ . "/views/error404View.php";
        }
        break;
    case ('login'):
        require_once __DIR__ . "/views/loginPageView.php";
        break;
    case ('logout'):
        require_once __DIR__ . "/scripts/logout.php";
        break;
    case ('register'):
        require_once __DIR__ . "/views/registerPageView.php";
        break;
    case ('register_success'):
        require_once __DIR__ . "/views/postRegisterView.php";
        break;
    default:
        http_response_code(404);
        require_once __DIR__ . "/views/error404View.php";
        break;
}
