
<div class="row users form">

    <div class="col-md-4 col-md-offset-4">

        <?php echo $this->Form->create('User'); ?>
        <legend>Login</legend>
        <div class="form-group">
            <?php echo $this->Form->input('username', array( 'class' => 'form-control')) ;  ?>
        </div>
        <div class="form-group">
            <?php  echo $this->Form->input('password', array( 'class' => 'form-control')); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Html->link( "SignUp?",   array('action'=>'add') ); ?>
        </div>

        <?php echo $this->Form->end(array( 'class' => 'btn btn-primary'),__('Submit')); ?>

    </div>

</div>

