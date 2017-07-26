<div class="row">
    <div class="col-md-3">
        <h1>Sample Pic</h1>
        <?php foreach ($users as $user): ?>
        <div class="profile-pic">
            <img src="<?php echo $user['User']['upload'];?>" alt="sample profile pic" class="img-thumbnail img-profile">
        </div>
        <?php endforeach; ?>
    </div>
    <div class="col-md-9">
        <h1>Sample Posts</h1>
    </div>
</div>