<?php
$context = $_SERVER["CONTEXT_PREFIX"];
?>
<header class="flex flex-row justify-between bg-gray-100 p-2">
    <div class="text-3xl font-bold pl-2">
        <a href="<?= $context ?>/">Home</a>
    </div>
    <div class="text-3xl font-bold pl-2">
        <a href="<?= $context ?>/browse">Browse Groups</a>
    </div>
    <div class="text-3xl font-bold pr-2">
        <a href="<?= $context ?>/profile">Profile</a>
    </div>
</header>