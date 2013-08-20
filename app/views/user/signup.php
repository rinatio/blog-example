<form class="form-signup" action="" method="post">
    <?php if(!empty($errors)) { ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($errors as $msg) {?>
                    <li><?=$msg?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <input name="name" type="text" class="form-control" placeholder="Name" autofocus required>
    <input name="email" type="email" class="form-control" placeholder="Email address" required>
    <input name="password" type="password" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
</form>
