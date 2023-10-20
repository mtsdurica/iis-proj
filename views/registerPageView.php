<?php
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>New Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Tailwind -->
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <!-- Dark mode -->
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body class="h-full main-background-colorscheme text-colorscheme">
    
    <!-- main container -->
    <div class="flex items-center justify-center h-full">
        <!-- form container -->
        <div class="flex flex-row items-center justify-center rounded-lg drop-shadow-md header-colorscheme">
            
                <!-- form content -->
                <div class="m-12">
                
                    <form action="<?= $context ?>/scripts/insert_account.php" method="POST" class="flex flex-col ">
                        <div class="flex-col gap-4">
                            <h1 class="mb-2 text-2xl text-center">
                            Create an account
                            </h1>
                    
                        <div>
                            <label for="user_id">
                                Username
                            </label>
                            <input type="text" placeholder="Username" name="user_id" id="user_id" required>
                        </div>
    
                        <div>
                            <label for="user_email">
                                Email
                            </label>
                            <input type="email" placeholder="Email" name="user_email" id="user_email" required>
                        </div>
    
                        <div>
                            <label for="user_first_name">
                                First name
                            </label>
                            <input type="text" placeholder="First name" name="user_first_name" id="user_first_name" required>
                        </div>

                        <div>
                            <label for="user_surname">
                                Last name
                            </label>
                            <input type="text" placeholder="Last name" name="user_surname" id="user_surname" required>
                        </div>

                        <div>
                            <label for="user_gender">
                                Gender
                            </label>
                            <select name="user_gender" id="user_gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other" selected>Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="user_birthdate">
                                Date of birth
                            </label>
                            <input type="date" name="user_birthdate" id="user_birthdate" required>
                        </div>

                        <div>
                            <label for="user_password">
                                Password
                            </label>
                            <input type="password" placeholder="Password" name="user_password" id="user_password" required>
                        </div>
    
                        <div>
                            <button type="submit" name="submitted">
                                Register
                            </button>
                        </div>
    
                        <div>
                            <span>
                                Already have an account?
                            </span>
                            <a href="<?= $context ?>/login">Log in</a>
                        </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>


    <script type="text/javascript" src="./scripts/main.js"></script>
</body>

</html>

