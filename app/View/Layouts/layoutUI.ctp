<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Cake</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
<!-- Navigation Bar -->
<?php echo $this->element('delete_modal'); ?>
<?php echo $this->element('edit_modal'); ?>
<nav class="navbar navbar-default">
    <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigatipon</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/dashboard">Social Media Cake</a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($this->Session->read('Auth.User')): ?>
                    <li class="active"><a href="/dashboard">Home</a></li>
                    <li><a href="/profile/<?php echo h($this->Session->read('Auth.User.username')); ?>">Profile</a></li>
                    <li><a href="/logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="/dashboard">Home</a></li>
                    <li> <?php echo __($this->Html->link( "Login",   array('action'=>'login'))); ?></li>
                    <li><a href="/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Main container -->
<div class="container clearfix">
    <?= $this->fetch('content') ?>
</div>

<!-- Jquery and Bootstrap js -->
<script
        src="http://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>

<script src="/js/main.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>