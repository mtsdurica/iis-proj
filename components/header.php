<?php
$context = $_SERVER["CONTEXT_PREFIX"];
$page = str_replace($context, "", $_SERVER["REQUEST_URI"]);

//TODO: Header items not the same width, needs to be fixed
?>
<header class="relative z-50">
    <ul class="flex flex-row justify-between p-2 header-colorscheme text-colorscheme drop-shadow">
        <div class="flex">
            <a id="/" class="header-element" href="<?= $context ?>/">
                <i class="fa-solid fa-house"></i>
            </a>
        </div>
        <div class="flex flex-row">
            <button id="/browse" class="group browser-button header-element">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <div id="hiddenDivider" class="hidden ml-2 border-l divider-colorscheme"></div>
            <a id="hiddenButtonBrowseGroups" class="hidden mx-2  header-element" href="<?= $context ?>/browse/groups">
                <i class="fa-solid fa-users"></i>
            </a>
            <a id="hiddenButtonBrowseUsers" class="hidden header-element" href="<?= $context ?>/browse/users">
                <i class="fa-solid fa-user"></i>
            </a>
        </div>
        <div>
            <button id="/profile" class="toggle-profile-dropdown header-element">
                <i class="fa-solid fa-circle-user toggle-profile-dropdown"></i>
            </button>
            <ul class="absolute right-0 flex flex-col w-48 gap-2 p-3 m-2 mt-4 transition-all rounded-lg animated-invisible header-colorscheme min-w-fit drop-shadow-xl profile-dropdown">
                <?php
                if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                ?>
                    <a class="block header-dropdown-element" href="<?= $context ?>/profile">
                        <i class=" fa-solid fa-user"></i>
                        <span class="pl-1">Your profile</span>
                    </a>
                <?php
                } else {
                ?>
                    <a class="block header-dropdown-element" href="<?= $context ?>/login">
                        <span class="fa-solid fa-power-off" style="color: #4ade80;"></span>
                        <span class="pl-1">Log In / Sign Up</span>
                    </a>
                <?php
                }
                ?>
                <hr class="mx-2 divider-colorscheme" />
                <button class="block toggle-dark header-dropdown-element">
                    <span class="fa-solid fa-moon toggle-dark "></span>
                    <span class="pl-1 toggle-dark">Dark mode</span>
                </button>
                <?php
                if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                ?>
                    <a class="block header-dropdown-element" href="<?= $context ?>/profile/<?= $_SESSION['username'] ?>/settings">
                        <span class="fa-solid fa-gear"></span>
                        <span class="pl-1">Settings</span>
                    </a>
                <?php
                }
                ?>
                <?php
                if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                ?>
                    <hr class="mx-2 divider-colorscheme" />
                    <a class="block header-dropdown-element" href="<?= $context ?>/logout">
                        <span class="fa-solid fa-power-off" style="color: #eb0000;"></span>
                        <span class="pl-1">Log Out</span>
                    </a>
                <?php
                }
                ?>
            </ul>
        </div>
    </ul>
</header>