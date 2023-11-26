<a class="flex flex-col items-center p-2 duration-300 rounded-lg header-colorscheme dark:hover:bg-slate-600 hover:bg-slate-200 drop-shadow" href="<?= $context ?>/group/<?= $groupHandle ?>">
    <?php
    $imgPath = null;
    if ($groupProfilePic)
        $imgPath = $context . "/uploads/" . $groupProfilePic;
    else
        $imgPath = $context . "/images/group_photo.jpg";
    ?>
    <img class="object-cover w-40 h-40 rounded-lg" src="<?= $imgPath ?>">
    <span class="mt-2 text-colorscheme text-md"><?= $groupName ?></span>
</a>