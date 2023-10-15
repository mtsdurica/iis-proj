<?php
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Register</title>
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
    <div class="flex flex-row items-center justify-center h-full">
        
        <!-- form on the left -->
        <div class="">
            <!-- form content -->
            <div class="m-12">
                
                <form>
                    <h1 class="mb-2 text-2xl text-center">
                        Create an account
                    </h1>
                    
                    <div>
                        <label for="username">
                            Username
                        </label>
                        <input type="text" placeholder="Username" name="username" required>
                    </div>
    
                    <div>
                        <label for="email">
                            Email
                        </label>
                        <input type="email" placeholder="Email" name="email" required>
                    </div>
    
                    <div>
                        <label for="first_name">
                            First name
                        </label>
                        <input type="text" placeholder="First name" name="first_name" required>
                    </div>

                    <div>
                        <label for="last_name">
                            Last name
                        </label>
                        <input type="text" placeholder="Last name" name="last_name" required>
                    </div>

                    <div>
                        <label for="gender">
                            Gender
                        </label>
                        <select name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other" selected>Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_of_birth">
                            Date of birth
                        </label>
                        <input type="date" name="date_of_birth" required>
                    </div>

                    <div>
                        <label for="password">
                            Password
                        </label>
                        <input type="password" placeholder="Password" name="password" required>
                    </div>
    
                    <div>
                        <label for="password">
                            Confirm password
                        </label>
                        <input type="password" placeholder="Confirm password" name="password" required>
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
                </form>
            </div>
            
            
        </div>

        <!-- image on the right -->
        <div>
            <!-- image content -->
            <div class="m-12 overflow-hidden w-96">
                <img src="<?= $context ?>/images/register.jpg" alt="Register image">
            </div>
            
        </div>
    </div>


    <script type="text/javascript" src="./scripts/main.js"></script>
</body>

</html>

