<?php
require_once "./scripts/services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];
$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);

$userData = $service->getUserData($exploded[3]);
$userId = $userData["user_id"];
$userNickname = $userData["user_nickname"];
$userFullname = $userData["user_full_name"];
$userEmail = $userData["user_email"];
$userGender = $userData["user_gender"];
$userBirthdate = $userData["user_birthdate"];
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body class="items-center h-full main-background-colorscheme text-colorscheme ">
    <!-- Page Container -->
    <div class="flex flex-col h-full overflow-y-scroll">
        <?php
        require_once "./components/header.php";
        ?>
        <!-- Page Content Container -->
        <div class="flex flex-col items-center justify-center h-full overflow-y-scroll px-32">
            
            <!-- Upper side -->
            <div class="flex flex-row gap-32 header-colorscheme rounded-lg p-6 mt-20 shadow-lg w-full justify-center">
                <!-- Profile picture section -->
                <div class="flex flex-col gap-2 w-full">
                    <h1 class="font-bold text-2xl mb-3">Profile picture</h1>
                    <!-- TODO: condition that will upload photo from database -->
                    <div class="flex h-44 overflow-hidden justify-center">
                        <img src="<?= $context ?>/images/profile_photo.jpg" style="object-fit: cover" alt="Profile picture" width="150rem" height="150rem" class="transition-all rounded-lg m-2">
                    </div>
                    
                    <form class="flex flex-row" action="<?= $context ?>/scripts/uploadProfilePic.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input class="px-2 py-1 text-sm text-center text-white transition-all rounded-lg basic-button-colorscheme" type="submit" name="submit" value="Upload image">
                    </form>
                </div> <!-- Profile picture section -->

                <!-- Banner picture section -->
                <div class="flex flex-col gap-2 w-full">
                    <h1 class="font-bold text-2xl mb-3">Banner</h1>
                    <div class="flex h-44 overflow-hidden justify-center">
                        <img src="<?= $context ?>/images/cover_photo.jpg" alt="Profile picture" width="250rem" height="150rem" class="transition-all rounded-lg m-2">
                    </div>
                    <form class="flex flex-row" action="<?= $context ?>/scripts/uploadBannerPic.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input class="px-2 py-1 text-sm text-center text-white transition-all rounded-lg basic-button-colorscheme" type="submit" name="submit" value="Upload image">
                    </form>
                </div> <!-- Banner picture section -->

            </div> <!-- Left side -->

            <!-- Lower side -->
            <div class="flex flex-row gap-44 header-colorscheme rounded-lg p-6 my-4 shadow-lg w-full">

                <!-- General settings form section -->
                <div class="flex flex-col">
                    <h1 class="font-bold text-2xl my-3">General</h1>
                    <!-- form content -->
                    <form class="flex flex-col gap-2" action="<?= $context ?>/scripts/update_account.php" method="POST">
                        <div class="flex flex-row gap-2 items-center">
                            <label class="px-2 text-sm w-56" for="user_nickname">
                                Username
                            </label>
                            <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="text" name="user_nickname" id="user_nickname" value="<?= $userNickname ?>" required>
                        </div>

                        <div class="flex flex-row gap-2 items-center">
                            <label class="px-2 text-sm w-56" for="user_email">
                                E-mail
                            </label>
                            <p class="text-sm"> <?= $userEmail ?> </p>
                        </div>

                        <div class="flex flex-row gap-2 items-center">
                            <label class="px-2 text-sm w-56" for="user_email">
                                Full name
                            </label>
                            <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="text" name="user_full_name" id="user_full_name" value="<?= $userFullname ?>" required>
                        </div>

                        <div class="flex flex-row gap-2 items-center">
                            <label class="px-2 text-sm w-56" for="user_birthdate">
                                Birthday
                            </label>
                            <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="date" name="user_birthdate" id="user_birthdate" value="<?= $userBirthdate ?>">
                        </div>

                        <div>
                            <label class="mt-4 py-4 text-lg w-56 font-bold">
                                Who can see my profile?
                            </label>

                            <div class="flex flex-row gap-2">
                                <input type="checkbox" id="everyone" name="everyone" value="Everyone">
                                <label class="text-sm" for="everyone">Everyone</label>

                                <input class="ml-28" type="checkbox" id="registered" name="registered" value="Registered">
                                <label class="text-sm" for="registered">Only registered users</label>
                            </div>
                            <div class="flex flex-row gap-2">
                                <input type="checkbox" id="groupMembers" name="groupMembers" value="GroupMembers">
                                <label class="text-sm" for="groupMembers">Only group members</label>

                                <input class="ml-9" type="checkbox" id="nobody" name="nobody" value="Nobody">
                                <label class="text-sm" for="nobody">Nobody</label>
                            </div>
                            
                        </div>

                        <div class="flex items-center justify-center gap-4">
                            <button type="submit" name="submitted" class="p-2 mt-2 text-sm text-center w-44 text-white transition-all rounded-lg confirm-button-colorscheme">
                                Save changes
                            </button>
                        </div>

                    </form>    

                </div> <!-- General settings form section -->

                <!-- Password settings form section -->
                <div>
                    <h1 class="font-bold text-2xl my-3">Password</h1>

                    <form class="flex flex-col gap-2" action="<?= $context ?>/scripts/update_password.php" method="POST">
                        <div class="flex flex-row gap-2 items-center">
                            <label class="px-2 text-sm w-56" for="user_old_password">
                                Old Password
                            </label>
                            <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="password" placeholder="Old Password" name="user_old_password" id="user_old_password" required>
                        </div>

                        <div class="flex flex-row gap-2 items-center">
                            <label class="px-2 text-sm w-56" for="user_new_password">
                                New Password
                            </label>
                            <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="password" placeholder="New Password" name="user_old_password" id="user_old_password" required>
                        </div>

                        <div class="flex flex-row gap-2 items-center">
                            <label class="px-2 text-sm w-56" for="user_new_password_conf">
                                New Password Again
                            </label>
                            <input class="p-2 border text-sm rounded-lg main-background-colorscheme divider-colorscheme" type="password" placeholder="New Password" name="user_old_password" id="user_old_password" required>
                        </div>

                        <div class="flex items-center justify-center gap-4">
                            <button type="submit" name="submitted" class="p-2 mt-2 text-sm text-center w-44 text-white transition-all rounded-lg confirm-button-colorscheme">
                                Save new password
                            </button>
                        </div>

                    </form>

                </div> <!-- Password settings form section -->

            </div> <!-- Right side -->
        </div>
    </div>
</body>