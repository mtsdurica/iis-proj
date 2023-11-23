<div class="flex flex-row flex-wrap gap-4 w-full align-middle header-colorscheme p-3 rounded-lg items-center justify-center">
    <div class="grow w-10">
        <p> ID: <?= $id ?> </p>
    </div>
    <div class="grow w-64">
        <p class="font-bold text-lg"> <?= $name ?> </p>
    </div>
    <div class="grow w-64">
        <p class="text-md"> @<?= $handle ?> </p>
    </div>
    <div>
        <?php
        // Determine button text and color based on $bannedFlag
        $buttonText = $bannedFlag ? "Unban" : "Ban";
        $buttonColor = $bannedFlag ? " confirm-button-colorscheme" : " cancel-button-colorscheme";
        ?>

        <!-- Form to handle the ban/unban action -->
        <form action="<?= $context ?>/scripts/changeGroupBannedStatus.php" method="POST">
            <input type="hidden" name="groupId" value="<?= $id ?>">
            <input type="hidden" name="bannedFlag" value="<?= $bannedFlag ?>">
            <!-- Button with dynamic text and color -->
            <button type="submit" class="<?= $buttonColor?> text-center py-1 w-20 rounded-lg">
                <?= $buttonText ?>
            </button>
        </form>

    </div>
    <div>
        <!-- Form to handle the delete action -->
        <form action="<?= $context ?>/scripts/deleteGroup.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
            <input type="hidden" name="userId" value="<?= $id ?>">
            <!-- Button with dynamic text and color -->
            <button type="submit" class="cancel-button-colorscheme text-center w-20 py-1 rounded-lg">
                Delete
            </button>
        </form>
    </div>
    <div>
        <!-- TODO: Redirect to profile settings of user with $userId -->
        <button type="submit" class="basic-button-colorscheme py-1 text-center w-20 rounded-lg">
            Edit
        </button>
    </div>

</div>