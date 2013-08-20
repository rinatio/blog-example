<form class="form-signin" method="post" action="">
    <?php if(!empty($errors)) { ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($errors as $msg) {?>
                    <li><?=$msg?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <h2 class="form-signin-heading">Please sign in</h2>
    <input name="email" type="email" class="form-control" placeholder="Email address" autofocus required>
    <input password="password" type="password" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
