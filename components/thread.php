<div class="border-2">
	<div class="flex flex-col items-center">
        	<div class="font-bold text-3xl">
             	<?= $threadTitle ?>
        	</div>
			<div>
				Posted by: <?= $threadPoster ?>
			</div>
        <div>
			<?= $threadText ?>
		</div>
	</div>
</div>
<?php

$replyQuery = $db->prepare('SELECT reply.reply_text, user.user_nick FROM reply LEFT JOIN user ON reply.poster_id = user.user_id WHERE reply.thread_id = ?');

$replyQuery->execute([$threadId]);
while($reply = $replyQuery->fetch(PDO::FETCH_ASSOC))
{
	$replyText  = $reply["reply_text"];
	$replyPoster = $reply["user_nick"];
	include "reply.php";
}
?>