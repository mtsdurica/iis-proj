<?php
session_start();

$context = $_SERVER["CONTEXT_PREFIX"];
?>

<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
</head>

<body class="h-full">
    <div class="flex flex-row justify-center h-full main-background-colorscheme text-colorscheme">

        <div class="flex flex-col justify-center gap-2">

            <h1 class="mb-2 text-2xl text-center text-colorscheme">
                Log in to your account
            </h1>
            <?php
            if (isset($_SESSION["invalid"])) {
            ?>
                <div class="flex justify-center h-12 p-2 text-center bg-red-500 rounded-lg bg-opacity-70">
                    <h1 class="text-xl text-white opacity-100">Incorrect username or password!</h1>
                </div>
            <?php
                unset($_SESSION["invalid"]);
            } else {
            ?>
                <div class="flex invisible h-12 p-2 text-xl"></div>
            <?php
            }
            ?>
            <form class="flex flex-col justify-center drop-shadow-md" action="<?= $context ?>/scripts/login.php" method="POST">
                <div class="flex flex-col gap-2 p-4 rounded-lg w-96 min-w-fit header-colorscheme">
                    <label class="px-2 text-lg" for="username">
                        Username or email address
                    </label>
                    <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="Username" name="username" required>
                    <label class="flex flex-row items-baseline justify-between px-2" for="password">
                        <span class="text-lg">Password</span>
                        <a class="flex text-md hover:text-blue-500" href="<?= $context ?>/recover">Forgot your password?</a>
                    </label>
                    <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="password" placeholder="Password" name="password" required>
                    <button class="items-center justify-center p-2 mt-2 text-lg text-center text-white transition-all rounded-lg confirm-button-colorscheme" type="submit" name="submitted">
                        <span class="justify-center">Log In</span>
                    </button>
                </div>
            </form>
            <div class="flex flex-col gap-2 p-2 rounded-lg text-colorscheme header-colorscheme drop-shadow-md">
                <div class="justify-center text-center rounded-lg">
                    <span class="">
                        New here?
                    </span>
                    <a class=" hover:text-blue-500" href="<?= $context ?>/register">Register an account now!</a>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
</body>

</html>