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
$userProfilePic = $userData["user_profile_pic"];
$userBanner = $userData["user_banner"];
$userPublicUnregistered = $userData["user_public_for_unregistered_flag"];
$userPublicRegistered = $userData["user_public_for_registered_flag"];
$userPublicGroupMembers = $userData["user_public_for_members_of_group_flag"];

$loggedInUser = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
$permission = 0;
if ($loggedInUser === 'admin') {
    $permission = 1;
} else if ($loggedInUser === $userNickname) {
    $permission = 1;
} else {
    $permission = 0;
}

if ($permission == 0) {
    echo "<body><h1>Permission denied</h1></body>";
} else {
?>

    <!DOCTYPE html>
    <html class="h-full">

    <head>
        <title><?= $userNickname ?> - Settings | Threadit</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    </head>

    <body class="h-full">
        <!-- Page Container -->
        <div class="flex flex-col h-full main-background-colorscheme text-colorscheme ">
            <?php
            require_once "./components/header.php";
            ?>
            <!-- Page Content Container -->
            <div class="flex flex-col items-center justify-center h-full px-32 overflow-hidden ">
                <div class="h-full overflow-auto no-scrollbar">

                    <?php
                    if ($userId != 1) {
                    ?>
                        <div class="flex justify-end mt-8 mb-4">
                            <!-- Form to handle the delete action -->
                            <form action="<?= $context ?>/scripts/deleteUser.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="userId" value="<?= $userId ?>">
                                <input type="hidden" name="fromProfileFlag" value="1">
                                <button type="submit" class="px-2 py-1 text-center rounded-lg cancel-button-colorscheme">
                                    Delete User Profile
                                </button>
                            </form>
                        </div>
                    <?php
                    }
                    ?>


                    <!-- Upper side -->
                    <div class="flex flex-row justify-center w-full gap-32 p-6 rounded-lg shadow-lg header-colorscheme">
                        <!-- Profile picture section -->
                        <div class="flex flex-col w-full gap-2">
                            <h1 class="mb-3 text-2xl font-bold">Profile picture</h1>
                            <?php
                            if ($userProfilePic === NULL || $userProfilePic === '') {
                                $picUrl =  $context . '/images/profile_photo.jpg';
                            } else {
                                $picUrl = $context . '/uploads/' . $userProfilePic;
                            }
                            ?>
                            <div class="flex justify-center overflow-hidden h-44">
                                <img src="<?= $picUrl ?>" style="object-fit: cover" alt="Profile Picture" width="150rem" height="150rem" class="m-2 transition-all rounded-lg">
                            </div>

                            <form class="flex flex-col items-center gap-4" action="<?= $context ?>/scripts/uploadProfilePic.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="fileToUpload" id="profilePicToUpload">
                                <input type="hidden" name="userNickname" value="<?= $userNickname ?>">
                                <input type="hidden" name="userId" value="<?= $userId ?>">
                                <input class="px-2 py-1 text-sm text-center text-white transition-all rounded-lg w-44 basic-button-colorscheme" type="submit" name="submit" value="Upload image">
                            </form>
                        </div> <!-- Profile picture section -->

                        <!-- Banner picture section -->
                        <div class="flex flex-col w-full gap-2">
                            <h1 class="mb-3 text-2xl font-bold">Banner</h1>
                            <?php
                            if ($userBanner === NULL || $userBanner === '') {
                                $bannerUrl =  $context . '/images/cover_photo.jpg';
                            } else {
                                $bannerUrl = $context . '/uploads/' . $userBanner;
                            }
                            ?>
                            <div class="flex justify-center overflow-hidden h-44">
                                <img src="<?= $bannerUrl ?>" alt="Banner" width="250rem" height="150rem" class="m-2 transition-all rounded-lg">
                            </div>
                            <form class="flex flex-col items-center gap-4" action="<?= $context ?>/scripts/uploadBannerPic.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="fileToUpload" id="bannerToUpload">
                                <input type="hidden" name="userNickname" value="<?= $userNickname ?>">
                                <input type="hidden" name="userId" value="<?= $userId ?>">
                                <input class="flex justify-center px-2 py-1 text-sm text-center text-white transition-all rounded-lg w-44 basic-button-colorscheme" type="submit" name="submit" value="Upload image">
                            </form>
                        </div> <!-- Banner picture section -->

                    </div> <!-- Upper side -->

                    <!-- Lower side -->
                    <div class="flex flex-row w-full p-6 my-4 rounded-lg shadow-lg gap-44 header-colorscheme">

                        <!-- General settings form section -->
                        <div class="flex flex-col">
                            <h1 class="my-3 text-2xl font-bold">General</h1>
                            <!-- form content -->
                            <form class="flex flex-col gap-2" action="<?= $context ?>/scripts/updateAccount.php" method="POST">
                                <div class="flex flex-row items-center gap-2">
                                    <label class="w-56 px-2 text-sm" for="user_nickname">
                                        Username
                                    </label>
                                    <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="text" name="user_nickname" id="user_nickname" value="<?= $userNickname ?>" required>
                                </div>

                                <div class="flex flex-row items-center gap-2">
                                    <p class="w-56 px-2 text-sm">
                                        E-mail
                                    </p>
                                    <p class="text-sm"> <?= $userEmail ?> </p>
                                </div>

                                <div class="flex flex-row items-center gap-2">
                                    <label class="w-56 px-2 text-sm" for="user_full_name">
                                        Full name
                                    </label>
                                    <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="text" name="user_full_name" id="user_full_name" value="<?= $userFullname ?>" required>
                                </div>

                                <div class="flex flex-row items-center gap-2">
                                    <label class="w-56 px-2 text-sm" for="user_birthdate">
                                        Birthday
                                    </label>
                                    <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="date" name="user_birthdate" id="user_birthdate" value="<?= $userBirthdate ?>">
                                </div>

                                <div>
                                    <p class="w-56 py-4 mt-4 text-lg font-bold">
                                        Who can see my profile?
                                    </p>

                                    <div class="flex flex-row gap-2">
                                        <?php
                                        if ($userPublicUnregistered == 1) {
                                            $checked = "checked";
                                        } else {
                                            $checked = "";
                                        }
                                        ?>

                                        <input type="checkbox" id="everyone" name="everyone" value="Everyone" <?= $checked ?>>
                                        <label class="text-sm" for="everyone">Everyone</label>

                                        <?php
                                        if ($userPublicRegistered == 1) {
                                            $checked = "checked";
                                        } else {
                                            $checked = "";
                                        }
                                        ?>

                                        <input class="ml-28" type="checkbox" id="registered" name="registered" value="Registered" <?= $checked ?>>
                                        <label class="text-sm" for="registered">Only registered users</label>
                                    </div>
                                    <div class="flex flex-row gap-2">

                                        <?php
                                        if ($userPublicGroupMembers == 1) {
                                            $checked = "checked";
                                        } else {
                                            $checked = "";
                                        }
                                        ?>

                                        <input type="checkbox" id="groupMembers" name="groupMembers" value="GroupMembers" <?= $checked ?>>
                                        <label class="text-sm" for="groupMembers">Only group members</label>

                                    </div>

                                </div>

                                <input type="hidden" name="userId" value="<?= $userId ?>">

                                <div class="flex items-center justify-center gap-4">
                                    <button type="submit" name="submitted" class="p-2 mt-2 text-sm text-center text-white transition-all rounded-lg w-44 confirm-button-colorscheme">
                                        Save changes
                                    </button>
                                </div>

                            </form>

                        </div> <!-- General settings form section -->

                        <!-- Password settings form section -->
                        <div>
                            <h1 class="my-3 text-2xl font-bold">Password</h1>

                            <form class="flex flex-col gap-2" action="<?= $context ?>/scripts/updatePassword.php" method="POST">
                                <div class="flex flex-row items-center gap-2">
                                    <label class="w-56 px-2 text-sm" for="user_old_password">
                                        Old Password
                                    </label>
                                    <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="password" placeholder="Old Password" name="user_old_password" id="user_old_password" required>
                                </div>

                                <div class="flex flex-row items-center gap-2">
                                    <label class="w-56 px-2 text-sm" for="user_new_password">
                                        New Password
                                    </label>
                                    <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="password" placeholder="New Password" name="user_new_password" id="user_new_password" required>
                                </div>

                                <div class="flex flex-row items-center gap-2">
                                    <label class="w-56 px-2 text-sm" for="user_new_password_conf">
                                        New Password Again
                                    </label>
                                    <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="password" placeholder="New Password" name="user_new_password_conf" id="user_new_password_conf" required>
                                </div>

                                <input type="hidden" name="userId" value="<?= $userId ?>">
                                <input type="hidden" name="userNickname" value="<?= $userNickname ?>">

                                <div class="flex items-center justify-center gap-4">
                                    <button type="submit" value="Submit" name="update" class="p-2 mt-2 text-sm text-center text-white transition-all rounded-lg w-44 confirm-button-colorscheme">
                                        Save new password
                                    </button>
                                </div>

                            </form>

                            <?php
                            if (isset($_SESSION['statusMessage'])) {
                                $statusMessage = $_SESSION['statusMessage'];
                            } else {
                                $statusMessage = '';
                            }
                            ?>

                            <div class="flex justify-center p-4 text-center">
                                <h1 class="text-lg font-bold text-red-600 opacity-100"><?= $statusMessage ?></h1>
                            </div>

                        </div> <!-- Password settings form section -->

                    </div> <!-- Right side -->
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
    </body>

    </html>
<?php
}
?>