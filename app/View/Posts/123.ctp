<section class="row new-post">
    <div class="col-md-6 col-md-offset-3">
        <h3>Edit Topic</h3>
        <div class="form-group">
            <?php echo __($this->Form->create('Post'));   ?>
        </div>
        <div class="form-group">
            <?php echo __($this->Form->input('status', array('rows' => '3', 'class' => 'form-control'))); ?>
        </div>
        <div class="form-group">
            <?php echo __($this->Form->input('id', array('type' => 'hidden', 'class' => 'form-control')));  ?>
        </div>
        <div class="form-group">
            <?php echo __($this->Form->end(array( 'class' => 'btn btn-primary'),__('Save Post'))); ?>
        </div>
    </div>
</section>