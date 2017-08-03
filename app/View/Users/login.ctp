<div class="row login form">
    <div class="col-md-4 col-md-offset-4">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Flash->render('auth'); ?>
        <?php echo $this->Form->create('User',['novalidate']); ?>
        <legend>Login</legend>
        <div class="form-group">
            <?php echo __($this->Form->input('username', array( 'class' => 'form-control', 'formnovalidate' => true)));  ?>
        </div>
        <div class="form-group">
            <?php  echo __($this->Form->input('password', array( 'class' => 'form-control'))); ?>
        </div>
        <div class="form-group">
            <?php echo __($this->Html->link( "Register?",   array('action'=>'register'))); ?>
        </div>
        <?php echo __($this->Form->end(array( 'class' => 'btn btn-primary'),__('Submit'))); ?>
    </div>
</div>