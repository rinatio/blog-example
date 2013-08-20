<!DOCTYPE html>
<html>
<head>
    <title>Sample Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Blog</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php if(!$this->getSession()->id) {?>
                        <li><a href="/?r=user/signin">Sign In</a></li>
                        <li><a href="/?r=user/signup">Sign Up</a></li>
                    <?php } else { ?>
                        <li><a href="/?r=post/create">Add Post</a></li>
                        <li><a href="/?r=user/logout">Logout (<?=$this->getSession()->name?>)</a></li>
                    <?php } ?>
                </ul>



            </div><!--/.nav-collapse -->
        </div>
    </div>
    <div class="container">
        <div class="content">
            <?=$content?>
        </div>
    </div>
</body>
</html>
