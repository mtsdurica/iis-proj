<?php
require_once "./scripts/services.php";
session_start();
$service = new AccountService();
$context = $_SERVER["CONTEXT_PREFIX"];
$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);

$groupData = $service->getGroupData($exploded[3]);
$groupId = $groupData["group_id"];
$groupHandle = $groupData["group_handle"];
$groupName = $groupData["group_name"];
$groupBio = $groupData["group_bio"];
$groupPublicFlag = $groupData["group_public_flag"];
$groupDateOfCreation = $groupData["group_date_of_creation"];
$groupProfilePic = $groupData["group_profile_pic"];
$groupBanner = $groupData["group_banner"];
?>

<head>
    <title><?= $groupName ?> - Settings | Threadit</title>
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
    <div class="flex flex-col h-full main-background-colorscheme text-colorscheme">
        <?php
        require_once "./components/header.php";
        ?>

        <!-- Page Content Container -->
        <div class="flex flex-col items-center justify-center h-full px-32 overflow-hidden">
            <div class="h-full overflow-auto no-scrollbar">

                <div class="flex justify-end mt-8 mb-4">
                    <!-- Form to handle the delete action -->
                    <form action="<?= $context ?>/scripts/deleteGroup.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
                        <input type="hidden" name="groupId" value="<?= $groupId ?>">
                        <button type="submit" class="px-2 py-1 text-center rounded-lg cancel-button-colorscheme">
                            Delete Group
                        </button>
                    </form>
                </div>

                <!-- Upper side -->
                <div class="flex flex-row justify-center w-full gap-32 p-6 rounded-lg shadow-lg header-colorscheme">
                    <!-- Profiile picture section -->
                    <div class="flex flex-col w-full gap-2">
                        <h1 class="mb-3 text-2xl font-bold">Profile picture</h1>
                        <?php
                        if ($groupProfilePic === NULL || $groupProfilePic === '') {
                            $picUrl = $context . '/images/group_photo.jpg';
                        } else {
                            $picUrl = $context . '/uploads/' . $groupProfilePic;
                        }
                        ?>
                        <div class="flex justify-center overflow-hidden h-44">
                            <img src="<?= $picUrl ?>" style="object-fit: cover" alt="Profile Picture" width="150rem" height="150rem" class="m-2 transition-all rounded-lg">
                        </div>

                        <form class="flex flex-col items-center gap-4" action="<?= $context ?>/scripts/uploadProfilePicGroup.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="fileToUpload" id="profilePicToUpload">
                            <input type="hidden" name="groupHandle" value="<?= $groupHandle ?>">
                            <input type="hidden" name="groupId" value="<?= $groupId ?>">
                            <input class="px-2 py-1 text-sm text-center text-white transition-all rounded-lg w-44 basic-button-colorscheme" type="submit" name="submit" value="Upload image">
                        </form>
                    </div> <!-- Profile picture section -->

                    <!-- Banner picture section -->
                    <div class="flex flex-col w-full gap-2">
                        <h1 class="mb-3 text-2xl font-bold">Banner</h1>
                        <?php
                        if ($groupBanner === NULL || $groupBanner === '') {
                            $bannerUrl =  $context . '/images/cover_photo.jpg';
                        } else {
                            $bannerUrl = $context . '/uploads/' . $groupBanner;
                        }
                        ?>
                        <div class="flex justify-center overflow-hidden h-44">
                            <img src="<?= $bannerUrl ?>" alt="Banner" width="250rem" height="150rem" class="m-2 transition-all rounded-lg">
                        </div>
                        <form class="flex flex-col items-center gap-4" action="<?= $context ?>/scripts/uploadGroupBannerPic.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="fileToUpload" id="bannerToUpload">
                            <input type="hidden" name="groupHandle" value="<?= $groupHandle ?>">
                            <input type="hidden" name="groupId" value="<?= $groupId ?>">
                            <input class="flex justify-center px-2 py-1 text-sm text-center text-white transition-all rounded-lg w-44 basic-button-colorscheme" type="submit" name="submit" value="Upload image">
                        </form>
                    </div> <!-- Banner picture section -->

                </div> <!-- Upper side -->

                <!-- Lower side -->
                <div class="flex justify-center w-full p-6 my-4 rounded-lg shadow-lg header-colorscheme">

                    <!-- General settings form section -->
                    <div class="flex flex-col">
                        <h1 class="my-3 text-2xl font-bold">General</h1>
                        <!-- form content -->
                        <form class="flex flex-col gap-2" action="<?= $context ?>/scripts/updateGroupSettings.php" method="POST">
                            <div class="flex flex-row items-center gap-2">
                                <label class="w-56 px-2 text-sm" for="group_handle">
                                    Group Handle
                                </label>
                                <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="text" name="group_handle" id="group_handle" value="<?= $groupHandle ?>" required>
                            </div>

                            <div class="flex flex-row items-center gap-2">
                                <label class="w-56 px-2 text-sm" for="group_name">
                                    Group Name
                                </label>
                                <input class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" type="text" name="group_name" id="group_name" value="<?= $groupName ?>" required>
                            </div>

                            <div class="flex flex-row items-center gap-2">
                                <label class="w-56 px-2 text-sm" for="group_bio">
                                    Group Bio
                                </label>
                                <textarea class="p-2 text-sm border rounded-lg main-background-colorscheme divider-colorscheme" name="group_bio" id="group_bio" required><?= $groupBio ?></textarea>
                            </div>

                            <div class="pl-2">
                                <p class="w-56 pt-4 pb-3 font-bold text-md">
                                    Privacy
                                </p>

                                <div class="flex flex-row items-center gap-4 pl-2">
                                    <?php
                                    if ($groupPublicFlag == 1) {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>
                                    <input type="checkbox" id="public_flag" name="public_flag" value="Public" <?= $checked ?>>
                                    <label class="text-sm" for="public_flag">Public</label>
                                </div>

                            </div>

                            <input type="hidden" name="groupId" value="<?= $groupId ?>">

                            <div class="flex items-center justify-center gap-4">
                                <button type="submit" name="submitted" class="p-2 mt-2 text-sm text-center text-white transition-all rounded-lg w-44 confirm-button-colorscheme">
                                    Save changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>


    </div>
    <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
</body>