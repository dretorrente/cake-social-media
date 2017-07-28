<div class="row profile-div">
    <div class="col-md-3">
        <div class="profile-pic">
            <img src="/<?php echo $user['User']['upload'];?>" alt="sample profile pic" class="img-thumbnail img-profile">
        </div>
        <p>Lorem ipsum dolor sit amet, eos aeque eirmod tamquam eu, per vidisse ullamcorper ne, omnes eirmod reprimique sea ex. Usu cu consul tempor, vix ad simul dolores adipisci.</p>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
             <!--<?php foreach($user['Like'] as $userLike): ?>-->
                <!--<?php if($userLike['isLike'] == true): ?>-->
                <!--<?php $totalLike++; ?>-->
                    <!--<?php endif ?>-->
                    <!--<?php endforeach ?>-->
                <?php $totalFollow =0; ?>
                <?php $userID = $this->Session->read('Auth.User.id'); ?>

                <?php foreach($user['Follow'] as $userFollow): ?>
                    <?php $totalFollow++; ?>
                <?php endforeach ?>
                <a href="#" class="FollowerBadge">Following<span class="badge following-class"><?php echo $totalFollow; ?></span></a>
                <!--<?php pr($user['User']); ?>-->
                <form action="/addFollow/<?php echo $user['User']['id']; ?>" method="post" >
                    <button type="submit" class="btn btn-info followButton">Follow</button>
                </form>

            </div>

        </div>
    </div>

    <div class="col-md-9">
        <h1 class="samplePosts">Your Sample Post</h1>

        <section class="row">
           <div class="col-md-6 col-md-offset-3">
               <?php $userID = $this->Session->read('Auth.User.id'); ?>
               <?php foreach($user['Post'] as $userPost): ?>
                    <?php if($userPost['user_id'] == $userID): ?>

               <article class="post">
                   <div class="info postByUser">
                       <div class="row">
                           <div class="col-md-2">
                                <a href="/profile/<?php echo $user['User']['username']; ?>"> <img src="/<?php echo $user['User']['upload'];?>" alt="sample profile pic" class="postImage"></a>
                            </div>
                             <div class="col-md-6 userName">
                               <?php echo $user["User"]["username"]?>
                               <p>Posted on  <?php echo $userPost['created']; ?></p>
                            </div>
                       </div>
                       <p class="contentPost"><?php echo $userPost['status'] ?></p>
                       <div class="interaction comment-interact" user_id="<?php echo $this->Session->read('Auth.User.id'); ?>" post_id ="<?php echo $userPost['id']?>">
                       <a href="#" class="comment">Comment |</a>

                           <?php $userId =  $this->Session->read('Auth.User.id'); ?>
                           <?php $likeName = ''; ?>
                           <?php foreach($user['Like'] as $likePost): ?>
                           <?php if($likePost['isLike'] == true && $likePost['user_id'] == $userId): ?>
                           <?php $likeName = "Liked"; ?>
                           <?php endif ?>

                           <?php endforeach ?>
                           <a href="/likes/isLike/<?php echo $userPost['id']; ?>" class="like"><?php if(empty($likeName)):?><?php echo "Like |"; ?> <?php else: ?> <?php echo $likeName ." |"; ?> <?php endif; ?> </a>
                       <?php
                       echo $this->Html->link(
                       'Edit |', array('controller' => 'posts', 'action' => 'edit',$userPost['id'])
                       );
                       ?>
                       <?php
                       echo $this->Form->postLink(
                       'Delete ',
                       array('controller' => 'posts','action' => 'delete', $userPost['id']),
                       array('confirm' => 'Are you sure?')
                       );
                       ?>
                       <?php $totalLike=0; ?>
                           <?php foreach($userPost['Like'] as $postLike): ?>
                               <?php if($postLike['isLike'] == true): ?>
                                   <?php $totalLike++; ?>
                               <?php endif ?>
                           <?php endforeach ?>


                       <a href="#" class="postBadge pull-right">Likes<span class="badge"><?php echo $totalLike ?></span></a>

                       <?php $totalComment = 0; ?>
                           <?php foreach($userPost['Comment'] as $comment): ?>
                           <?php $totalComment += count($comment['comment']); ?>

                       <?php endforeach ?>

                       <a href="#" class="postBadge pull-right">Comments<span class="badge"><?php echo $totalComment; ?></span></a>
                           <div id="form-comment">
                               <!--<?php foreach($user['Comment'] as $comment1): ?>-->
                                    <!--<?php if($comment1['Post']['id'] == $userPost['id']): ?>-->
                                        <!--<?php pr($comment1['Post']); ?>-->
                                    <!--<?php endif; ?>-->
                               <!--<?php endforeach ?>-->

                               <?php foreach($userPost['Comment'] as $comment): ?>
                               <div class="row imageCol">

                                   <div class="col-md-1 ">
                                       <img src="/<?php echo $comment['User']['upload'];?>" alt="sample profile pic" class="imageComment"  >
                                   </div>
                                   <div class="col-md-10">
                                       <p class="comment-profile"><?php echo($comment['comment']); ?> </p>
                                   </div>
                               </div>

                               <?php endforeach ?>

                               <form action="/addComment/<?php echo $userPost['id']; ?>" method="post" >

                                   <div class="form-group">
                                       <textarea class="form-control commentBox" name="comment" id="comment" rows="2" placeholder="Type your comment here.."></textarea>
                                   </div>
                                   <?php echo $this->Form->input('id', array('type' => 'hidden', 'class' => 'form-control'));  ?>
                                   <button type="submit" class="btn btn-default">Comment</button>

                               </form>
                           </div>
                       </div>
                   </div>
               </article>


                    <?php endif ?>

               <?php endforeach ?>
            </div>

            </section>
    </div>
</div>