<?php
require_once "./scripts/services.php";
session_start();
$context = $_SERVER["CONTEXT_PREFIX"];

if (!isset($_SESSION["loggedIn"]))
    header("Location:$context/login");

$service = new AccountService();
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>New Group | Threadit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body class="h-full main-background-colorscheme">
    <div class="flex flex-col h-full">
        <?php
        require_once "./components/header.php";
        ?>
        <div class="flex flex-col items-center justify-center m-4">
            <div class="items-center justify-center w-3/4 text-colorscheme">
                <?php
                if (isset($_SESSION["invalid"])) {
                ?>
                    <div class="flex justify-center h-12 p-2 mb-4 text-center bg-red-500 rounded-lg bg-opacity-70">
                        <h1 class="text-xl text-white opacity-100">Group already exists!</h1>
                    </div>
                <?php
                    unset($_SESSION["invalid"]);
                } else {
                ?>
                    <div class="flex invisible h-12 p-2 mb-4 text-xl"></div>
                <?php
                }
                ?>
                <form id="newThread" class="flex flex-col items-center justify-center drop-shadow-md" action="<?= $context ?>/scripts/insertGroup.php" method="POST">
                    <fieldset class="flex flex-col w-1/2 gap-2 p-4 rounded-lg min-w-fit header-colorscheme">
                        <label class="px-2 text-lg" for="groupHandle">Group Handle:</label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="Group handle" name="groupHandle" required>
                        <input type="hidden" name="groupAdmin" value="<?= $_SESSION['userId'] ?>">
                        <label class="px-2 text-lg" for="groupName">Group Name:</label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="Group name" name="groupName" required>
                        <label class="px-2 text-lg" for="groupBio">Group Bio:</label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="Group bio" name="groupBio">
                        <label class="flex flex-row items-baseline gap-4 px-2 text-lg" for="groupPrivate">
                            <input class="flex" type="checkbox" name="groupPrivate">
                            <span class="flex">
                                Do you want your group to be private?
                            </span>
                        </label>
                        <button class="items-center justify-center p-2 mt-2 text-lg text-center text-white transition-all rounded-lg confirm-button-colorscheme" type="submit" name="submitted">
                            <span class="justify-center">Create Group</span>
                        </button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
</body>

</html>