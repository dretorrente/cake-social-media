<div class="users form">
    <?php echo __($this->Form->create('User')); ?>
    <fieldset>
        <legend><?php echo __('Edit User'); ?></legend>
        <?php
        echo __($this->Form->hidden('id', array('value' => $this->data['User']['id'])));
        echo __($this->Form->input('username', array( 'readonly' => 'readonly', 'label' => 'Usernames cannot be changed!')));
        echo __($this->Form->input('email'));
        echo __($this->Form->input('password_update', array( 'label' => 'New Password (leave empty if you do not want to change)', 'maxLength' => 255, 'type'=>'password','required' => 0)));
        echo __($this->Form->input('password_confirm_update', array('label' => 'Confirm New Password *', 'maxLength' => 255, 'title' => 'Confirm New password', 'type'=>'password','required' => 0)));
        echo __($this->Form->input('role', array(
        'options' => array( 'king' => 'King', 'queen' => 'Queen', 'rook' => 'Rook', 'bishop' => 'Bishop', 'knight' => 'Knight', 'pawn' => 'Pawn')
        )));
        echo __($this->Form->submit('Edit User', array('class' => 'form-submit',  'title' => 'Click here to add the user')));
        ?>
    </fieldset>
    <?php echo __($this->Form->end()); ?>
</div>
<?php
    echo __($this->Html->link( "Return to Dashboard",   array('action'=>'index')));
?>
<br/>
<?php
    echo __($this->Html->link( "Logout",   array('action'=>'logout')));
?>