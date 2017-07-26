
<section class="row new-post">
    <div class="col-md-6 col-md-offset-3">
        <h3>Edit Topic</h3>
        <div class="form-group">

            <?php echo $this->Form->create('Post');   ?>
        </div>

        <div class="form-group">
            <?php echo $this->Form->input('status', array('rows' => '3', 'class' => 'form-control')); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('id', array('type' => 'hidden', 'class' => 'form-control'));  ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->end(array( 'class' => 'btn btn-primary'),__('Save Post')); ?>
        </div>

            <!--//echo $this->Form->end('Save Post', array('class' => 'btn btn-primary'));-->


        <!--<form action="/posts/edit" method="post">-->
            <!--<div class="form-group">-->
                <!--<input class="form-control" name="data[Post][title]" id="PostTitle"  placeholder="Title">-->
            <!--</div>-->
            <!--<div class="form-group">-->
                <!--<textarea class="form-control" name="data[Post][body]" id="PostBody" rows="5" placeholder="Your Content"></textarea>-->
            <!--</div>-->
            <!--<input type="hidden" name="_method" value="PUT">-->
            <!--<button type="submit" class="btn btn-primary">Save Post</button>-->

        <!--</form>-->
    </div>
</section>