<div class="row">
    <div class="col-md-3">
        <?php foreach ($users as $user): ?>
        <div class="profile-pic">
            <img src="/<?php echo $user['User']['upload'];?>" alt="sample profile pic" class="img-thumbnail img-profile">
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <form action="/addFollow/<?php echo $user['User']['id']; ?>" method="post" >
                    <button type="submit" class="btn btn-info">Follow</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="col-md-9">
        <h1>Sample Posts</h1>
    </div>
</div>