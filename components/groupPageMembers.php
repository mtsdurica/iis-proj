<div class="flex flex-row items-center justify-between p-2 rounded-lg header-colorscheme">
    <?php
    $imgPath = null;
    if ($userProfilePic)
        $imgPath = $context . "/uploads/" . $userProfilePic;
    else
        $imgPath = $context . "/images/profile_photo.jpg";
    ?>
    <img class="w-12 rounded-lg" src="<?= $imgPath ?>">
    <a class="hover:underline" href="<?= $context ?>/profile/<?= $userNickname ?>">@<?= $userNickname ?></a>
    <?php
    if (isset($_SESSION["loggedIn"]) && $_SESSION["userId"] === $groupAdmin["user_id"]) {
    ?>
        <form method="POST" action="<?= $context ?>/scripts/kickFromGroup.php" class="flex flex-row gap-2">
            <input type="hidden" name="groupId" value="<?= $groupId ?>">
            <input type="hidden" name="userId" value="<?= $userId ?>">
            <input type="hidden" name="groupRedirect" value="<?= $groupHandle ?>">
            <button type="submit" name="kick" class="p-1 px-3 text-base font-bold text-center text-white transition-all duration-300 bg-red-400 rounded-full max-h-fit hover:bg-red-500 dark:bg-red-500 dark:hover:bg-red-600">Kick</button>
        </form>
    <?php
    } else {
    ?>
        <div class="invisible"></div>
    <?php
    }
    ?>
</div>