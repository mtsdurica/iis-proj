<div class="flex flex-row flex-wrap gap-4 w-full">
    <div>
        <p> picture </p>
    </div>
    <div>
        <p> ID: <?= $id ?> </p>
    </div>
    <div class="grow w-64">
        <p> <?= $name ?> </p>
    </div>
    <div class="grow w-64">
        <p> @<?= $nickname ?> </p>
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
            <button type="submit" class="<?= $buttonColor?> text-center w-20 rounded-lg">
                <?= $buttonText ?>
            </button>
        </form>

    </div>
    <div>
        <button class="cancel-button-colorscheme text-center w-20 rounded-lg">
            Delete
        </button>
    </div>
    <div>
        <button class="basic-button-colorscheme text-center w-20 rounded-lg">
            Edit
        </button>
    </div>
    <div>
        <p> Public: <?= $publicFlag ?> </p>
    </div>
    
    
</div>