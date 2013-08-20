<form class="form-post" method="post" action="">
    <?php if(!empty($errors)) { ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($errors as $msg) {?>
                    <li><?=$msg?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <h2>Create a Post</h2>
    <input name="title" type="text" class="form-control" placeholder="Title" autofocus required>
    <textarea name="text" class="form-control" placeholder="Post Text" required rows=20"></textarea>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
</form>
