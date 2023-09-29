<?php
$context = $_SERVER["CONTEXT_PREFIX"];
$page = str_replace($context, "", $_SERVER["REQUEST_URI"]);
?>
<header class="relative z-50">
    <ul class="flex flex-row justify-between p-2 header-colorscheme text-colorscheme drop-shadow">
        <a id="/" class="header-element" href="<?= $context ?>/">
            <i class="fa-solid fa-house"></i>
        </a>
        <div class="flex flex-row">
            <button id="/browse" class="browser-button header-element">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <a id="hiddenButtonBrowseGroups" class="hidden header-element" href="<?= $context ?>/browse/groups">
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
            <ul class="absolute right-0 p-2 m-2 mt-4 transition-all rounded-lg animated-invisible header-colorscheme w-fit drop-shadow-xl profile-dropdown">
                <!-- TODO: Only show when logged in, otherwise display text saying you need to login (same would apply to your groups, settings) -->
                <a class="block header-dropdown-element" href="<?= $context ?>/profile">
                    <i class=" fa-solid fa-user"></i>
                    <span class="pl-1">Your profile</span>
                </a>
                <div class="my-2 border-b divider-colorscheme"></div>
                <button class="block toggle-dark header-dropdown-element">
                    <span class="fa-solid fa-moon toggle-dark "></span>
                    <span class="pl-1 toggle-dark">Dark mode</span>
                </button>
                <a class="block header-dropdown-element" href="<?= $context ?>/profile">
                    <span class="fa-solid fa-gear"></span>
                    <span class="pl-1">Settings</span>
                </a>
                <div class="my-2 border-b divider-colorscheme"></div>
                <a class="block header-dropdown-element" href="<?= $context ?>/profile">
                    <!-- TODO: Change color to red and text to sign out -->
                    <span class="fa-solid fa-power-off" style="color: #4ade80;"></span>
                    <span class="pl-1">Sign In</span>
                </a>
            </ul>
        </div>
    </ul>
</header>