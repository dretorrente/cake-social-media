$(document).ready(function() {
    var postId = 0;
    var userId = 0;

    $('.comment-interact').each(function (i) {
        $(this).find('.comment').on('click', function (event) {
            event.preventDefault();
            $(this).parent().find("#form-comment").toggle().find('.commentBox').focus();

        });

    });
    $('.like').on('click', function(event) {
        event.preventDefault();
        $(this).parent().find('.comment-interact');
        userId = $(this).parent().attr("user_id");
        postId =  $(this).parent().attr("post_id");
        $this = $(this);
        $.ajax({
            method: 'GET',
            url: '/likes/isLike',
            data:{
                user_id:userId,
                post_id:postId
            }
        }).done(function(res){
            if(res)
            {
                $this.html('Liked |');
                // $this.children('.like').html("Like |");

            }
            else
            {
                $this.html('Like |');

            }


        });
    });



});