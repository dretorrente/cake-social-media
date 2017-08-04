<section class="row posts">
    <div class=" col-md-3">
        <h3>News Feed</h3>
    </div>
    <div class="col-md-6">
        <p><?php echo __($this->Session->flash()); ?></p>
        <div class="alert alert-success" style="display: none;">
        </div>
        <h3><?php if ($this->Session->read('Auth.User')): ?> Hi <?php echo __($this->Session->read('Auth.User.username')); ?>.
            <?php endif; ?>
        </h3>
        <form id="createPost" action="" method="post">
            <div class="form-group">
                <textarea class="form-control" name="status" id="status" rows="3" placeholder="What's on your mind.."></textarea>
            </div>
            <button type="button" class="btn btn-primary" id="btnAdd">Create Post</button>
        </form>
    </div>
</section>

<section class="row section2" >
    <div class="col-md-6 col-md-offset-3" id="showdata">

        <?php foreach ($posts as $post): ?>
        <article class="post">
            <div class="info postByUser">
                <div class="row">
                    <div class="col-md-2">
                        <a href="/profile/<?php echo h($post['User']['username']); ?>"><img src="img/<?php echo h($post['User']['upload']);?>" alt="sample profile pic" class="postImage"></a>
                    </div>
                    <div class="col-md-6 userName">
                        <h4 ><?php echo __($post["User"]["username"]); ?></h4>
                        <p>Posted on  <?php echo __($post['Post']['modified']); ?></p>
                    </div>
                </div>
            </div>
            <p class="contentPost"><?php echo $post['Post']['status'] ?></p>
            <div class="interaction comment-interact" user_id="<?php echo h($this->Session->read('Auth.User.id')); ?>" post_id ="<?php echo h($post['Post']['id'])?>">
                <a href="#" class="commentTag">Comment |</a>
                <?php $userId =  $this->Session->read('Auth.User.id'); ?>
                <!-- Condition for naming Like-->
                <?php $likeName = ''; ?>
                <?php foreach($post['Like'] as $likePost): ?>
                    <?php if($likePost['isLike'] == true && $likePost['user_id'] == $userId): ?>
                    <?php $likeName = "Liked"; ?>
                    <?php endif ?>
                <?php endforeach ?>

                <a href="/likes/isLike/<?php echo h($post['Post']['id']); ?>" class="like"><?php if(empty($likeName)):?><?php echo __("Like |"); ?> <?php else: ?> <?php echo __($likeName ." |"); ?> <?php endif; ?> </a>
                <?php
                    echo __($this->Html->link(
                'Edit |', array('action' => 'edit', $post['Post']['id'])
                ));
                ?>
                <a href="javascript:;" data="<?php echo h($post['Post']['id']); ?>" class="post-delete">Delete</a>
                <!-- Getting total Likes -->
                <?php $totalLike = 0; ?>
                <?php foreach($post['Like'] as $isLike): ?>
                    <?php if($isLike['isLike'] == true): ?>
                        <?php $totalLike++; ?>
                    <?php endif ?>
                <?php endforeach ?>
                <a href="#" class="postBadge pull-right">Likes<span class="badge likeBadge"><?php echo h($totalLike); ?></span></a>
                <!-- Getting total comment -->
                <?php $totalComment = 0; ?>
                    <?php foreach($post['Comment'] as $comment): ?>
                    <?php $totalComment += count($comment['comment']); ?>
                <?php endforeach ?>

                <a href="#" class="postBadge pull-right">Comments<span class="badge commentBadge"><?php echo h($totalComment); ?></span></a>
                <div id="form-comment">
                    <div id="commentSection">
                        <?php foreach($post['Comment'] as $comment): ?>
                        <div class="row imageCol">
                            <div class="col-md-1 ">
                                <img src="img/<?php echo h($comment['User']['upload']);?>" alt="sample profile pic" class="imageComment"  >
                            </div>
                            <div class="col-md-10">
                                <?php echo __($comment["User"]["username"]); ?>
                                <p>Commented on <?php echo __($comment['modified']); ?></p>
                                <div class="jumbotron" id="commentArea">
                                    <p><?php echo __($comment['comment']); ?> </p>
                                </div>
                                <a href="javascript:;" data="<?php echo __($comment['id']); ?>" class="comment-edit">Edit | </a>
                                <a href="javascript:;" data="<?php echo __($comment['id']); ?>" class="comment-delete">Delete</a>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                    <form action="" method="post" >
                        <div class="form-group">
                            <textarea class="form-control commentBox" name="comment" id="comment" rows="2" placeholder="Type your comment here.."></textarea>
                        </div>
                        <?php echo __($this->Form->input('id', array('type' => 'hidden', 'value' => $post['Post']['id'], 'class' => 'form-control hiddenPost')));  ?>
                        <button type="submit" class="btn btn-default commentSubmit">Comment</button>
                    </form>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>

