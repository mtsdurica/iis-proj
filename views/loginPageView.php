<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<?php

session_start();

?>


<body>
    <form action="~xduric06/../scripts/login.php" method="POST">
        <label for="username">
            Username
        </label>
        <input type="text" placeholder="Username" name="username" required>
        <label for="password">
            Password
        </label>
        <input type="password" placeholder="Password" name="password" required>

        <button type="submit" name="submitted">
            Log In
        </button>
    </form>
</body>

</html>