<div class="border-2">
	<div class="flex flex-col items-center">
        	<div class="font-bold text-3xl">
             	<?= $threadTitle ?>
        	</div>
			<div>
				Posted by: <?= $threadPoster ?> in <?= $groupId ?>
			</div>
        <div>
			<?= $threadText ?>
		</div>
	</div>
</div>
<?php

$commentQuery = $db->prepare('SELECT comments.comment_text, users.user_nick FROM comments LEFT JOIN users ON comments.poster_id = users.user_id WHERE comments.thread_id = ?');

$commentQuery->execute([$threadId]);
while($comment = $commentQuery->fetch(PDO::FETCH_ASSOC))
{
	$commentText  = $comment["comment_text"];
	$commentPoster = $comment["user_nick"];
	include "comment.php";
}
?>