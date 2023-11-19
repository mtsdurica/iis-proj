<div class="flex flex-row items-center justify-between p-2 rounded-lg header-colorscheme">
    <img class="w-12 rounded-lg" src="../images/2206.q713.011.F.m012.c7.people top view flat.jpg">
    <a class="hover:underline" href="<?= $context ?>/profile/<?= $requestUserNickname ?>">@<?= $requestUserNickname ?></a>
    <form method="POST" action="<?= $context ?>/scripts/handleJoinRequest.php" class="flex flex-row gap-2">
        <input type="hidden" name="requestGroupId" value="<?= $groupId ?>">
        <input type="hidden" name="requestUserId" value="<?= $requestUserId ?>">
        <input type="hidden" name="groupRedirect" value="<?= $groupHandle ?>">
        <button type="submit" name="requestSubmit" value="1" class="p-1 px-3 text-base font-bold text-center text-white transition-all duration-300 rounded-full max-h-fit confirm-button-colorscheme">Accept</button>
        <button type="submit" name="requestSubmit" value="0" class="p-1 px-3 text-base font-bold text-center text-white transition-all duration-300 bg-red-400 rounded-full max-h-fit hover:bg-red-500 dark:bg-red-500 dark:hover:bg-red-600">Decline</button>
    </form>
</div>