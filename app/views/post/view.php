<?php
/**
 * @var \app\model\Post $post
 * @var \app\model\Comment[] $comments
 */
?>
<h1><?=$post->getTitle()?></h1>
<pre><?=$post->getText()?></pre>
<div class="well">
    <h4>Comments:</h4>
    <?php foreach($comments as $comment) { ?>
        <div><b><?=$comment->getName() ?: 'Guest'?></b></div>
        <pre><?=$comment->getText()?></pre>
        </hr>
    <?php } ?>
</div>
<div>
    <form class="form-comment" method="post" action="/?r=comment/create">
        <h4>Add a comment</h4>
        <input type="hidden" name="post_id" value="<?=$post->getId();?>" required>
        <input name="name" type="text" class="form-control" placeholder="Name" autofocus>
        <textarea name="text" class="form-control" placeholder="Message" required rows=3"></textarea>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Add</button>
    </form>

</div>
