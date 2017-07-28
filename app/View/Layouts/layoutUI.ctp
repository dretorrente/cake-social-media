<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigatipon</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/dashboard">Sample CakePHP</a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($this->Session->read('Auth.User')): ?>
                <!--<li><a href="#"><img src="<?php echo $this->Session->read('Auth.User.upload'); ?>" class="profile-mage"></a> </li>-->
                    <li class="active"><a href="/dashboard">Home</a></li>
                    <li><a href="/profile/<?php echo $this->Session->read('Auth.User.username'); ?>">Profile</a></li>
                    <li><a href="/logout">Logout</a></li>

                    <!--<li class="dropdown">-->
                        <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>-->
                        <!--<ul class="dropdown-menu">-->
                            <!--&lt;!&ndash;<?php if ($this->Session->read('Auth.User')): ?>&ndash;&gt;-->
                                <!--<li><a href="admin">Profile</a></li>-->
                                <!--<li><a href="logout">Logout</a></li>-->
                            <!--&lt;!&ndash;<?php endif; ?>&ndash;&gt;-->
                        <!--</ul>-->
                    <!--</li>-->
                <?php else: ?>
                    <li class="active"><a href="#">Home</a></li>
                    <li> <?php echo $this->Html->link( "Login",   array('action'=>'login') ); ?></li>
                <li> <?php echo $this->Html->link( "Signup",   array('action'=>'add') ); ?></li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
<div class="container clearfix">
    <?= $this->fetch('content') ?>
</div>
<!--<footer>-->
    <!--<div class="container">-->
        <!--<div class="navbar-text pull-left">-->
            <!--<p>copyright Sample CakePHP 2017 </p>-->
        <!--</div>-->
        <!--<div class="navbar-text pull-right">-->
            <!--<a href="#"><i class="fa fa-facebook fa-2x"></i></a>-->
            <!--<a href="#"><i class="fa fa-twitter fa-2x"></i></a>-->
            <!--<a href="#"><i class="fa fa-google-plus fa-2x"></i></a>-->
        <!--</div>-->
    <!--</div>-->
<!--</footer>-->


<script
        src="http://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>

<script src="/js/main.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>