<div class="flex flex-col px-4 py-2 mt-2 rounded-lg mx-80 thread-colorscheme text-colorscheme drop-shadow-md">
    <div class="flex flex-col">
        <div class="flex flex-row">
            <span class="text-sm text-slate-500 dark:text-slate-400">
                Reply by:
            </span>
            <object class="px-1 text-sm text-slate-500 dark:text-slate-400 hover:underline">
                <a href="<?= $context ?>/profile/<?= $threadPoster ?>">
                    <?= $threadPoster ?>
                </a>
            </object>
        </div>
        <div class="flex flex-row">
        </div>
        <div class="flex flex-col justify-center w-full h-full thread-text">
            <p class="text-base">
                <?= $threadText ?>
            </p>
        </div>
        <hr class="mt-4 divider-colorscheme" />
        <?php
        $positiveRatings = $service->getPositiveRatingsForThread($threadId);
        $negativeRatings = $service->getNegativeRatingsForThread($threadId);
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
            $posActive = "";
            $negActive = "";
            $thread = $service->getThreadRating($threadId, $_SESSION["userId"]);
            if (!empty($thread) && $thread["thread_rating"] == true)
                $posActive = "ranking-active";
            else if (!empty($thread) && $thread["thread_rating"] == false)
                $negActive = "ranking-active";
        }
        ?>
        <form class="flex flex-row items-center justify-between px-4 mx-40 mt-2 rankingForm min-h-fit">
            <input type="hidden" name="threadId" value="<?= $threadId ?>">
            <div class="h-6 mr-2 border-l divider-colorscheme"></div>
            <button type="submit" name="positive" data-url="<?= $context ?>/scripts/rankPositive.php" class="<?= $posActive ?> flex flex-row items-center justify-center w-full px-2 py-1 text-base transition-all duration-300 rounded-md rankingButton hover:bg-slate-300 dark:hover:bg-slate-600">
                <i class="fa-solid fa-angle-up"></i>
                <div class="pl-4 text-base">
                    <?= $threadPositiveRating + (int)$positiveRatings["COUNT(*)"] ?>
                </div>
            </button>
            <div class="h-6 mx-2 border-l divider-colorscheme"></div>
            <button type="submit" name="negative" data-url="<?= $context ?>/scripts/rankNegative.php" class="<?= $negActive ?> flex flex-row items-center justify-center w-full px-2 py-1 text-base transition-all duration-300 rounded-md rankingButton hover:bg-slate-300 dark:hover:bg-slate-600">
                <i class="text-base fa-solid fa-angle-down"></i>
                <div class="pl-4 text-base ">
                    <?= $threadNegativeRating + (int)$negativeRatings["COUNT(*)"] ?>
                </div>
            </button>
            <div class="h-6 ml-2 border-l divider-colorscheme"></div>
        </form>
    </div>
</div>