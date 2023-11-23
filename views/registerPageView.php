<?php
$context = $_SERVER["CONTEXT_PREFIX"];
session_start();
?>

<!DOCTYPE html>
<html lang="en "class="h-full">

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

<body class="h-full ">
    
    <!-- main container -->
    <div class="flex flex-col items-center justify-center h-full main-background-colorscheme text-colorscheme">
        
        <!-- HEADING -->
        <div class="p-4">
            <h1 class="text-2xl text-center">
                Create an account
            </h1>

            <?php
            if (isset($_SESSION["errorMessage"])) {
            ?>
                <div class="flex justify-center h-12 p-2 text-center bg-red-500 rounded-lg bg-opacity-70">
                    <h1 class="text-xl text-white opacity-100"><?= $_SESSION["errorMessage"] ?></h1>
                </div>
            <?php
                unset($_SESSION["errorMessage"]);
            } else {
            ?>
                <div class="flex invisible h-12 p-2 text-xl"></div>
            <?php
            }
            ?>
        </div>
            
        <!-- form content -->
        <form class="flex flex-col gap-4 p-4 rounded-lg w-96 min-w-fit header-colorscheme" action="<?= $context ?>/scripts/insert_account.php" method="POST">
            
           <div class="flex flex-row">
                <!-- MANDATORY DATA -->
                <div class="flex flex-col gap-4 p-4 rounded-lg" id="reg_first_step">
                
                    <div class="flex flex-col gap-2">
                        <label class="px-2 text-lg" for="user_nickname">
                            Username *
                        </label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="Username" name="user_nickname" id="user_nickname" required>
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
                    
                </div>

                <!-- OTHER DATA -->
                <div class="flex flex-col gap-4 p-4 rounded-lg step w-96 min-w-fit header-colorscheme" id="reg_second_step">
                    <div class="flex flex-col gap-2">
                        <label class="px-2 text-lg" for="user_full_name">
                            Full name
                        </label>
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="text" placeholder="Full name" name="user_full_name" id="user_full_name">
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
                        <input class="p-2 border rounded-lg main-background-colorscheme divider-colorscheme" type="date" name="user_birthdate" id="user_birthdate" value="1991-01-01">
                    </div>

                </div> <!-- OTHER DATA -->
            </div>

            <!-- BUTTON -->
            <div class="flex items-center justify-center gap-4">
                <button type="submit" name="submitted" class="p-2 mt-2 text-lg text-center w-96 text-white transition-all rounded-lg confirm-button-colorscheme">
                    Register
                </button>
            </div>

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

