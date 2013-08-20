<?php
/**
 * @var \app\model\Post[] $posts
 */
?>
<h1>Sample Blog</h1>
<div>
    <?php foreach($posts as $post) {?>
        <h2><a href="/?r=post/view&id=<?=$post->getId()?>"><?=$post->getTitle()?></a></h2>
        <div><?=$post->getText()?></div>
        <hr/>
    <?php } ?>
</div>
