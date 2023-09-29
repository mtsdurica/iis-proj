<?php
$context = $_SERVER["CONTEXT_PREFIX"];
$page = str_replace($context, "", $_SERVER["REQUEST_URI"]);
?>
<header class="flex flex-row justify-between p-2 header-colorscheme text-colorscheme drop-shadow">
    <a id="/" class="header-element" href="<?= $context ?>/">
        <i class="fa-solid fa-house"></i>
    </a>
    <a id="/browse" class="header-element" href="<?= $context ?>/browse">
        <i class="fa-solid fa-users"></i>
    </a>
    <button class="toggle-dark header-element">
        <i class="fa-solid fa-moon"></i>
    </button>
    <a id="/profile" class="header-element" href="<?= $context ?>/profile">
        <i class="fa-solid fa-circle-user"></i>
    </a>
</header>