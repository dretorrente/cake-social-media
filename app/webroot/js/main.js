$(document).ready(function() {
    var postId = 0;
    var userId = 0;

    $('.comment-interact').each(function (i) {
        $(this).find('.comment').on('click', function (event) {
            event.preventDefault();
            $(this).parent().find("#form-comment").toggle().find('.commentBox').focus();

        });

        $(this).find('.commentSubmit').on('click', function(event) {
            event.preventDefault();
            var commentPostID = $(this).parent().find('.hiddenPost').val();
            var comment = $(this).parent().find('#comment').val();
            var $this = $(this);
            $.ajax({
                method: 'POST',
                url: "/comments/addComment/"+commentPostID,
                data: {comment: comment}
            }).done(function(res){
                var data = JSON.parse(res);
                var html = '';

                for(var i =0; i<data.length; i++)
                {

                    html += '<div class="row imageCol">'+
                                     '<div class="col-md-1 ">'+
                                        '<img src="/'+data[i].User.upload+'" alt="sample profile pic" class="imageComment">'+
                                     "</div>"+
                                     '<div class="col-md-10">'+
                                        "<p>"+data[i].Comment.comment+"</p>"+
                                        '<a href="/comments/edit/'+data[i].Comment.id+'">Edit | </a>'+
                                        '<a href="/comments/delete/'+data[i].Comment.id+'">Delete</a>'+
                                     '</div>'+
                            '</div>';
                }
                $this.parent().parent().find('#commentSection').html(html);

            });
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
                $data = JSON.parse(res);
                var likeSpan = $('.likeBadge').html();
                var parseSpan = parseInt(likeSpan)
                if($data.respondLike)
                {
                   $this.parent().find('.likeBadge').html(parseSpan+1);
                    $this.html('Liked |');
                }
               else{
                    $this.parent().find('.likeBadge').html(parseSpan-1);
                    $this.html('Like |');
                 }
            }
        });
    });


});