<div>
	<div class="p-2 px-4 mx-40 mt-2 rounded-lg thread-colorscheme text-colorscheme drop-shadow">
		<h3 class="text-xl">
			<?= $threadTitle ?>
		</h3>
		<h4>Posted by: <?= $threadPoster ?> in <?= $groupId ?></h4>
		<p>
			<?= $threadText ?>
		</p>
	</div>
	<?php
	// $commentsQuery = $db->prepare('SELECT comments.comment_text, users.user_nick FROM comments LEFT JOIN users ON comments.poster_id = users.user_id WHERE comments.thread_id = ?');

	// $commentsQuery->execute([$threadId]);
	// while ($comment = $commentsQuery->fetch(PDO::FETCH_ASSOC)) {
	// 	$commentText  = $comment["comment_text"];
	// 	$commentPoster = $comment["user_nick"];
	// 	require "comment.php";
	// }
	?>
</div>