<section class="row posts">
    <div class=" col-md-3">
     <h3>News Feed</h3>
    </div>
    <div class="col-md-6">
        <h3><?php if ($this->Session->read('Auth.User')): ?> Hi <?php echo $this->Session->read('Auth.User.username'); ?>.
            <?php endif; ?></h3>
        <form action="add" method="post">
            <!--<?php echo $this->Form->input('user_id'); ?>-->
            <div class="form-group">
                <textarea class="form-control" name="status" id="new-post" rows="3" placeholder="What's on your mind.."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>
</section>


<section class="row section2" >
    <div class="col-md-6 col-md-offset-3">
    <?php foreach ($posts as $post): ?>
    <article class="post">
        <div class="info postByUser">
            <div class="row">
                <div class="col-md-2">
                  <a href="/profile/<?php echo $post['User']['username']; ?>"><img src="<?php echo $post['User']['upload'];?>" alt="sample profile pic" class="postImage"></a>

                </div>
                <div class="col-md-6 userName">
                    <?php echo $post["User"]["username"]?>

                   <p>Posted on  <?php echo $post['Post']['created']; ?></p>
                </div>
            </div>
        </div>
        <p class="contentPost"><?php echo $post['Post']['status'] ?></p>

        <div class="interaction comment-interact" user_id="<?php echo $this->Session->read('Auth.User.id'); ?>" post_id ="<?php echo $post['Post']['id']?>">


            <a href="#" class="comment">Comment |</a>
            <?php $userId =  $this->Session->read('Auth.User.id'); ?>
            <?php $likeName = ''; ?>
            <?php foreach($post['Like'] as $likePost): ?>
            <?php if($likePost['isLike'] == true && $likePost['user_id'] == $userId): ?>
            <?php $likeName = "Liked"; ?>
            <?php endif ?>

            <?php endforeach ?>
            <a href="/likes/isLike/<?php echo $post['Post']['id']; ?>" class="like"><?php if(empty($likeName)):?><?php echo "Like |"; ?> <?php else: ?> <?php echo $likeName ." |"; ?> <?php endif; ?> </a>

            <?php
                echo $this->Html->link(
            'Edit |', array('action' => 'edit', $post['Post']['id'])
            );
            ?>
            <?php
                echo $this->Form->postLink(
            'Delete ',
            array('action' => 'delete', $post['Post']['id']),
            array('confirm' => 'Are you sure?')
            );
            ?>
            <?php $countLike = 0; ?>
            <?php foreach($post['Like'] as $likePost): ?>
                <?php if($likePost['isLike'] == true): ?>
                    <?php $countLike++; ?>
                <?php endif ?>

            <?php endforeach ?>
            <a href="#" class="postBadge pull-right">Likes<span class="badge likeBadge">0</span></a>
            <?php $totalComment = 0; ?>
            <?php foreach($post['Comment'] as $comment): ?>
                    <?php $totalComment += count($comment['comment']); ?>

            <?php endforeach ?>
            <a href="#" class="postBadge pull-right">Comments<span class="badge"><?php echo $totalComment; ?></span></a>
            <div id="form-comment">
                <?php foreach($post['Comment'] as $comment): ?>
                <div class="row imageCol">
                    <div class="col-md-1 ">
                        <img src="<?php echo $comment['User']['upload'];?>" alt="sample profile pic" class="imageComment"  >
                    </div>
                    <div class="col-md-10">
                        <p><?php echo($comment['comment']); ?> </p>
                    </div>
                </div>

                <?php endforeach ?>

                <form action="addComment/<?php echo  $post['Post']['id']; ?>" method="post" >
                    <!--<?php echo $this->Form->input('user_id'); ?>-->
                    <div class="form-group">
                        <textarea class="form-control commentBox" name="comment" id="comment" rows="2" placeholder="Type your comment here.."></textarea>
                    </div>
                    <?php echo $this->Form->input('id', array('type' => 'hidden', 'class' => 'form-control'));  ?>
                    <button type="submit" class="btn btn-default">Comment</button>

                </form>
            </div>
        </div>
    </article>
    <?php endforeach; ?>
    </div>
</section>

