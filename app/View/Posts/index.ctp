

<!--<h1><?php if ($this->Session->read('Auth.User')): ?> Hi <?php echo $this->Session->read('Auth.User.username'); ?>. <?php else: ?>-->
    <!--<?php echo $this->Html->link('login', array('controller' => 'users', 'action' => 'login')); ?>-->
    <!--<?php endif; ?></h1>-->

<!--<h2>Blog posts</h2>-->

<!--<p>-->
<!--&lt;!&ndash;    check if user is logged, show user name and logout link or login link &ndash;&gt;-->
<!--<?php if ($this->Session->read('Auth.User')): ?>-->
<!--You are logged in as <?php echo $this->Session->read('Auth.User.username'); ?>. <?php echo $this->Html->link('logout', array('controller' => 'users', 'action' => 'logout')); ?>-->
<!--<?php else: ?>-->
<!--<?php echo $this->Html->link('login', array('controller' => 'users', 'action' => 'login')); ?>-->
<!--<?php endif; ?>-->
<!--</p>-->


<!--<p><?php echo $this->Html->link('Add Post', array('action' => 'add')); ?></p>-->
<!--<table class="table">-->
    <!--<tr>-->
        <!--<th>Id</th>-->
        <!--<th>Title</th>-->
        <!--<th>Actions</th>-->
        <!--<th>Created</th>-->
    <!--</tr>-->

    <!--&lt;!&ndash; Here's where we loop through our $posts array, printing out post info &ndash;&gt;-->

    <!--<?php foreach ($posts as $post): ?>-->
    <!--<tr>-->
        <!--<td><?php echo $post['Post']['id']; ?></td>-->
        <!--<td>-->
            <!--<?php-->
                <!--echo $this->Html->link(-->
            <!--$post['Post']['title'],-->
            <!--array('action' => 'view', $post['Post']['id'])-->
            <!--);-->
            <!--?>-->
        <!--</td>-->
        <!--<td>-->
            <!--<?php-->
                <!--echo $this->Form->postLink(-->
            <!--'Delete',-->
            <!--array('action' => 'delete', $post['Post']['id']),-->
            <!--array('confirm' => 'Are you sure?')-->
            <!--);-->
            <!--?>-->
            <!--<?php-->
                <!--echo $this->Html->link(-->
            <!--'Edit', array('action' => 'edit', $post['Post']['id'])-->
            <!--);-->
            <!--?>-->
        <!--</td>-->
        <!--<td>-->
            <!--<?php echo $post['Post']['created']; ?>-->
        <!--</td>-->
    <!--</tr>-->
    <!--<?php endforeach; ?>-->

<!--</table>-->

<section class="row posts">
    <div class="col-md-6 col-md-offset-3">
        <header><h3>What's on your mind..</h3></header>
        <form action="add" method="post">
            <!--<?php echo $this->Form->input('user_id'); ?>-->
            <div class="form-group">
                <textarea class="form-control" name="body" id="new-post" rows="3" placeholder="Your Content"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Post</button>

        </form>
        <!--<?php foreach ($posts as $post): ?>-->
        <article class="post">
            <p><?php echo $post['Post']['body'] ?>;</p>
            <div class="info">
                <!--Posted by <?php if ($this->Session->read('Auth.User')): ?> <?php echo $this->Session->read('Auth.User.username'); ?>-->
                <!--<?php endif; ?> on  <?php echo $post['Post']['created']; ?>-->
            </div>
            <div class="interaction">
                <a href="#">Like</a>
                <!--<a href="#">Dislike</a>-->
                <!--<a href="#">Delete</a>-->
            </div>
        </article>
        <!--<?php endforeach; ?>-->
    </div>
</section>

