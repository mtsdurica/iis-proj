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
    <div class="flex flex-col items-center justify-center h-full">
        
        <!-- HEADING -->
        <div class="p-4">
            <h1 class="text-2xl text-center">
                Create an account
            </h1>
        </div>

                <!-- PHP: show message for bad input -->
                <?php
        if (isset($_SESSION["invalid"])) {
        ?>
            <div class="flex justify-center h-12 p-2 text-center bg-red-500 rounded-lg bg-opacity-70">
                <h1 class="text-xl text-white opacity-100">Incorrect input.</h1>
            </div>
        <?php
            unset($_SESSION["invalid"]);
        } else {
        ?>
            <div class="flex invisible h-12 p-2 text-xl"></div>
        <?php
        }
        ?>
            
            <!-- form content -->
            <form action="<?= $context ?>/scripts/insert_account.php" method="POST">
                
                <!-- FIRST STEP -->
                <div class="flex flex-col gap-4 p-4 rounded-lg w-96 min-w-fit header-colorscheme" id="reg_first_step">
                
                    <div class="flex flex-col gap-2">
                        <label class="px-2 text-lg" for="user_id">
                            Username *
                        </label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="Username" name="user_id" id="user_id" required>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="px-2 text-lg" for="user_password">
                            Password *
                        </label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="password" placeholder="Password" name="user_password" id="user_password" required>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="px-2 text-lg" for="user_email">
                            Email *
                        </label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="email" placeholder="Email" name="user_email" id="user_email" required>
                    </div>

                    <div class="flex items-center justify-center">
                        <button class="w-full p-2 mt-2 text-lg text-center text-white transition-all rounded-lg basic-button-colorscheme" type="button" id="next_button" onclick="nextPrev(1)">
                            Next
                        </button>
                    </div>
                    
                </div>

                <!-- SECOND STEP -->
                <!-- if not hidden: class="flex flex-col gap-2 p-4 rounded-lg w-96 min-w-fit header-colorscheme" -->
                <div class="hidden gap-4 p-4 rounded-lg w-96 min-w-fit header-colorscheme" id="reg_second_step">
                    <div class="flex flex-col gap-2">
                        <label class="px-2 text-lg" for="user_first_name">
                            First name
                        </label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="First name" name="user_first_name" id="user_first_name">
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <label class="px-2 text-lg" for="user_surname">
                            Last name
                        </label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="Last name" name="user_surname" id="user_surname">
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <label class="px-2 text-lg" for="user_gender">
                            Gender
                        </label>
                        <select class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme"  name="user_gender" id="user_gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other" selected>Other</option>
                        </select>
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <label class="px-2 text-lg" for="user_birthdate">
                            Birthday
                        </label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="date" name="user_birthdate" id="user_birthdate" required>
                    </div>

                    <div class="flex items-center justify-center">
                        <button type="submit" name="submitted" class="w-full p-2 mt-2 text-lg text-center text-white transition-all rounded-lg confirm-button-colorscheme">
                            Register
                        </button>
                    </div>
                    
                </div> <!-- SECOND STEP -->
                
            </form>
            
            <!-- FOOTER -->
            <div class="p-4">
                <span>
                    Already have an account?
                </span>
                <a class=" hover:text-blue-500" href="<?= $context ?>/login" >Log in</a>
            </div>

    </div>


    <script type="text/javascript" src="./scripts/main.js"></script>
</body>

</html>

