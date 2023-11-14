<div class="flex flex-row flex-wrap gap-4 w-full align-middle header-colorscheme p-3 rounded-lg items-center justify-center">
    <div class="flex items-center justify-center">
        <p> picture </p>
    </div>
    <div>
        <p> ID: <?= $id ?> </p>
    </div>
    <div class="grow w-64">
        <p class="font-bold text-md"> @<?= $nickname ?> </p>
    </div>
    <div>
        <?php
        // Determine button text and color based on $bannedFlag
        $buttonText = $bannedFlag ? "Unban" : "Ban";
        $buttonColor = $bannedFlag ? " confirm-button-colorscheme" : " cancel-button-colorscheme";
        ?>

        <!-- Form to handle the ban/unban action -->
        <form action="<?= $context ?>/scripts/changeBannedStatus.php" method="POST">
            <input type="hidden" name="userId" value="<?= $id ?>">
            <input type="hidden" name="bannedFlag" value="<?= $bannedFlag ?>">
            <!-- Button with dynamic text and color -->
            <button type="submit" class="<?= $buttonColor?> text-center py-1 w-20 rounded-lg">
                <?= $buttonText ?>
            </button>
        </form>

    </div>
    <div>
        <!-- Form to handle the delete action -->
        <form action="<?= $context ?>/scripts/deleteUser.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
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
    <div>
        <?php
        // Determine button text and color based on $publicFlag
        $buttonText = $publicFlag ? "Make Private" : "Make Public";
        $buttonColor = $publicFlag ? " basic-button-colorscheme" : " bg-slate-500";
        ?>

        <!-- Form to handle the ban/unban action -->
        <form action="<?= $context ?>/scripts/updateUserPublicity.php" method="POST">
            <input type="hidden" name="userId" value="<?= $id ?>">
            <input type="hidden" name="publicFlag" value="<?= $publicFlag ?>">
            <!-- Button with dynamic text and color -->
            <button type="submit" class="<?= $buttonColor?> py-1 text-center w-32 rounded-lg">
                <?= $buttonText ?>
            </button>
        </form>

    </div>

</div>