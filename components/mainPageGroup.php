<a href="<?= $context ?>/group/<?= $groupHandle ?>" class="flex flex-row items-center w-full gap-4 p-2 transition-all duration-200 rounded-lg cursor-pointer justify-left hover:bg-slate-200 dark:hover:bg-slate-700 text-colorscheme">
    <?php
    $imgPath = null;
    if ($groupProfilePic)
        $imgPath = $context . "/uploads/" . $groupProfilePic;
    else
        $imgPath = $context . "/images/group_photo.jpg";
    ?>
    <img class="flex w-8 rounded-lg" src="<?= $imgPath ?>">
    <span class="flex text-xl text-center"><?= $groupName ?></span>
</a>