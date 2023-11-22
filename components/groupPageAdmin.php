<div class="flex flex-row items-center justify-between p-2 text-center rounded-lg header-colorscheme">
    <?php
    $imgPath = null;
    if ($userProfilePic)
        $imgPath = $context . "/uploads/" . $userProfilePic;
    else
        $imgPath = $context . "/images/profile_photo.jpg";
    ?>
    <img class="w-12 rounded-lg" src="<?= $imgPath ?>">
    <a class="hover:underline" href="<?= $context ?>/profile/<?= $userNickname ?>">@<?= $userNickname ?></a>
    <div class="invisible"></div>
</div>