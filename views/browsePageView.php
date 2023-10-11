<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Browse</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<?php
$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=xduric06;port=/var/run/mysql/mysql.sock", 'xduric06', 'j4sipera');
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    die();
}
?>

<body class="h-full">
    <div class="flex flex-col h-full main-background-colorscheme">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="flex h-full overflow-hidden">

            <div class="flex flex-col items-center w-full p-2 m-1">
                <?php
                if ($exploded[3] === "users") {
                ?>
                    <h2 class="text-2xl font-bold text-colorscheme">
                        Browse Users
                    </h2>
                <?php
                } else if ($exploded[3] === "groups") {
                ?>
                    <h2 class="text-2xl font-bold text-colorscheme">
                        Browse Groups
                    </h2>
                <?php
                }
                ?>
                <div class="w-3/5 p-2 m-5 overflow-auto no-scrollbar">
                    <div class="flex flex-wrap justify-center gap-6">
                        <?php
                        if ($exploded[3] === "users") {
                            $usersQuery = $db->prepare('SELECT user_id FROM users');

                            $usersQuery->execute();

                            while ($user = $usersQuery->fetch(PDO::FETCH_ASSOC)) {
                                $userId = $user["user_id"];
                                include "./components/browserPageUser.php";
                            }
                        } else if ($exploded[3] === "groups") {
                            $groupsQuery = $db->prepare('SELECT group_id FROM groups WHERE group_public_flag = true');

                            $groupsQuery->execute();

                            while ($group = $groupsQuery->fetch(PDO::FETCH_ASSOC)) {
                                $groupId = $group["group_id"];
                                include "./components/browserPageGroup.php";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../scripts/main.js"></script>
</body>

<!-- <body class="h-full main-background-colorscheme">
    <?php
    require_once "./components/header.php";
    ?>
    <div class="flex flex-col items-center ">
        <div class="flex flex-row justify-center w-3/5">
            <div class="flex overflow-hidden">
                <div class="flex flex-col w-full p-2 m-1">
                    <?php
                    if ($exploded[3] === "groups") {
                    ?>
                        <h2 class="mx-40 text-2xl font-bold text-colorscheme">
                            Browse Groups
                        </h2>
                        <div class="flex flex-wrap justify-center min-w-full gap-4 overflow-auto">
                            <?php

                            $groupsQuery = $db->prepare('SELECT group_id FROM groups WHERE group_public_flag = true');

                            $groupsQuery->execute();

                            while ($group = $groupsQuery->fetch(PDO::FETCH_ASSOC)) {
                                $groupId = $group["group_id"];
                                include "./components/browserPageGroup.php";
                            }
                            ?>
                        </div>
                    <?php
                    } else if ($exploded[3] === "users") {
                    ?>
                        <h2 class="mx-40 text-2xl font-bold text-colorscheme">
                            Browse Users
                        </h2>
                        <div class="flex flex-wrap justify-center min-w-full gap-4 overflow-auto">
                            <?php

                            $usersQuery = $db->prepare('SELECT user_id FROM users WHERE user_public_flag = true');

                            $usersQuery->execute();

                            while ($user = $usersQuery->fetch(PDO::FETCH_ASSOC)) {
                                $userId = $user["user_id"];
                                include "./components/browserPageUser.php";
                                include "./components/browserPageUser.php";
                                include "./components/browserPageUser.php";
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../scripts/main.js"></script>
</body> -->