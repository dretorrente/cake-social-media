

<div class="row users form">
    <div class="col-md-4 col-md-offset-4">
        <?php echo $this->Form->create('User', array('enctype' => 'multipart/form-data')); ?>
        <legend>Sign Up</legend>
        <div class="form-group">
            <?php echo $this->Form->input('email', array( 'class' => 'form-control')) ;  ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('username', array( 'class' => 'form-control')) ;  ?>
        </div>
        <div class="form-group">
            <?php  echo $this->Form->input('password', array( 'class' => 'form-control')); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('password_confirm', array('class' => 'form-control','label' => 'Confirm Password *', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password')); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('upload', array('type' => 'file')); ?>
        </div>


        <?php echo $this->Form->end(array( 'class' => 'btn btn-primary'),__('Submit')); ?>

    </div>
</div>
