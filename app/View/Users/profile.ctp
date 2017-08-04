
<div class="row profile-div">
    <div class="col-md-3">
        <div class="profile-pic">
            <img src="/img/<?php echo __($user['User']['upload']);?>" alt="sample profile pic" class="img-thumbnail img-profile">
        </div>
        <p>Lorem ipsum dolor sit amet, eos aeque eirmod tamquam eu, per vidisse ullamcorper ne, omnes eirmod reprimique sea ex. Usu cu consul tempor, vix ad simul dolores adipisci.</p>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <?php $totalFollow =0; ?>
                <?php $userID = $this->Session->read('Auth.User.id'); ?>
                <?php $followName = ''; ?>
                <?php foreach($user['Follow'] as $userFollow): ?>
                    <?php if($userFollow['isFollow'] == true && $userFollow['user_id'] == $user['User']['id']): ?>
                        <?php $totalFollow++; ?>

                    <?php endif ?>
                <?php endforeach ?>
                <a href="#" class="FollowerBadge">Following<span class="badge following-class"><?php echo h($totalFollow); ?></span></a>
                <?php if($this->Session->read('Auth.User.id') != $user['User']['id'] ): ?>
                <form action="" method="post" id="followForm">
                        <!--<?php $followName = ''; ?>-->
                        <?php echo __($this->Form->input('id', array('type' => 'hidden', 'value' => $user['User']['id'], 'class' => 'form-control hiddenFollow')));  ?>

                    <button type="submit" class="btn btn-info addFollow" id="addFollow">Follow</button>
                </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <div class="col-md-9">
        <h1 class="samplePosts">
            <?php if($user['User']['id'] == $this->Session->read('Auth.User.id')): ?>
            Your Profile
            <?php else: ?>
                 <?php echo h($user['User']['username'] . "'s" . " Profile") ?>
            <?php endif; ?>
        </h1>
        <div class="alert alert-success" style="display: none;"></div>
        <section class="row">
            <div class="col-md-6 col-md-offset-3">
                <?php foreach($user['Post'] as $post): ?>
                <article class="post">
                    <div class="info postByUser">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="/profile/<?php echo h($post['User']['username']); ?>"> <img src="/img/<?php echo h($post['User']['upload']);?>" alt="sample profile pic" class="postImage"></a>
                            </div>
                            <div class="col-md-6 userName">
                                <h4><?php echo __($post["User"]["username"])?></h4>
                                <p>Posted on  <?php echo __($post['created']); ?></p>
                            </div>
                        </div>
                    </div>
                    <p class="contentPost"><?php echo __($post['status']); ?></p>
                    <div class="interaction comment-interact" user_id="<?php echo h($this->Session->read('Auth.User.id')); ?>" post_id ="<?php echo h($post['id'])?>">
                        <a href="#" class="commentTag">Comment |</a>
                        <!-- Condition for naming Like-->
                        <?php $userId =  $this->Session->read('Auth.User.id'); ?>
                        <?php $likeName = ''; ?>
                        <?php foreach($post['Like'] as $likePost): ?>
                            <?php if($likePost['isLike'] == true && $likePost['user_id'] == $userId): ?>
                                <?php $likeName = "Liked"; ?>
                            <?php endif ?>
                        <?php endforeach ?>
                        <a href="/likes/isLike/<?php echo h($post['id']); ?>" class="like"><?php if(empty($likeName)):?><?php echo __("Like |"); ?> <?php else: ?> <?php echo __($likeName ." |"); ?> <?php endif; ?> </a>
                        <?php
                            echo __($this->Html->link(
                        'Edit |', array('controller' => 'posts','action' => 'edit', $post['id'])
                        ));
                        ?>
                        <a href="javascript:;" data="<?php echo $post['id']; ?>" class="post-delete">Delete</a>
                        <!-- Getting total Likes -->
                        <?php $totalLike = 0; ?>
                            <?php foreach($post['Like'] as $likePost): ?>
                            <?php if($likePost['isLike'] == true): ?>
                                <?php $totalLike++; ?>
                            <?php endif ?>
                        <?php endforeach ?>
                        <a href="#" class="postBadge pull-right">Likes<span class="badge likeBadge"><?php echo h($totalLike); ?></span></a>
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
                                        <img src="/img/<?php echo h($comment['User']['upload']);?>" alt="sample profile pic" class="imageComment"  >
                                    </div>
                                    <div class="col-md-8 col-md-offset-1">

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
                                <?php echo __($this->Form->input('id', array('type' => 'hidden', 'value' => $post['id'], 'class' => 'form-control hiddenPost')));  ?>
                                <button type="submit" class="btn btn-default commentSubmit">Comment</button>
                            </form>
                        </div>
                    </div>
                </article>
                <?php endforeach ?>
            </div>
        </section>
    </div>
</div>
