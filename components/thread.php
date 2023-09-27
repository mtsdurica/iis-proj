<div>
	<div class="my-2 mx-40 p-1 border border-black rounded-md">
		<h3 class="text-xl">
			<?= $threadTitle ?>
		</h3>
		<h4>Posted by: <?= $threadPoster ?> in <?= $groupId ?></h4>
		<p>
			<?= $threadText ?>
		</p>
	</div>
	<?php
	$commentsQuery = $db->prepare('SELECT comments.comment_text, users.user_nick FROM comments LEFT JOIN users ON comments.poster_id = users.user_id WHERE comments.thread_id = ?');

	$commentsQuery->execute([$threadId]);
	while ($comment = $commentsQuery->fetch(PDO::FETCH_ASSOC)) {
		$commentText  = $comment["comment_text"];
		$commentPoster = $comment["user_nick"];
		require "comment.php";
	}
	?>
</div>