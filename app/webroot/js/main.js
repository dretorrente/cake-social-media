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
                var addComment = $('textarea[name=comment]');
                for(var i =0; i<data.length; i++)
                {

                    html += '<div class="row imageCol">'+
                                     '<div class="col-md-1 ">'+
                                        '<img src="img/'+data[i].User.upload+'" alt="sample profile pic" class="imageComment">'+
                                     "</div>"+
                                     '<div class="col-md-10">'+
                                        "<p>"+data[i].Comment.comment+"</p>"+
                                        '<a href="javascript:;" data="'+data[i].Comment.id+'" class="comment-edit">Edit | </a>'+
                                        '<a href="javascript:;" data="'+data[i].Comment.id+'" class="comment-delete">Delete</a>'+
                                     '</div>'+
                            '</div>';
                }
                addComment.val('');
                $this.parent().parent().find('#commentSection').html(html);

                var commentSpan = $this.parent().parent().parent().find('.commentBadge').html();

                var parseComment = parseInt(commentSpan);
                $this.parent().parent().parent().find('.commentBadge').html(parseComment+1);


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
                var parseSpan = parseInt(likeSpan);
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
    //Add New
    $('#btnAdd').click(function(){

        var data = $('#createPost').serialize();
        //validate form
        var addPost = $('textarea[name=status]');
        var result = '';

        if(addPost.val()===''){
            addPost.parent().addClass('has-error');
        }else{
            addPost.parent().removeClass('has-error');
            result +='1';
        }
        if(result==='1'){
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '/posts/add',
                data: data,
                async: false,
                dataType: 'json',
                success: function(response){
                    // // console.log(response);
                    // // if(response.success){
                    // //     showAllPost();
                    //
                    // }else{
                    //     alert('Error');
                    // }
                },
                error: function(){
                    alert('Could not add data');
                }
            });
        }
    });

    function showAllPost(){
        var autID;
        var postID;
        $.ajax({
            type: 'ajax',
            url: '/posts/showAllPost',
            data: {},
            async: false,
            dataType: 'json',
            success: function(data){
                var html = '';
                var i;
                var autID = data.authID;
                for(i=0; i<data.query.length; i++){
                    html += '<article class="post">'+
                                '<div class="info postByUser">'+
                                    '<div class="row">'+
                                        '<div class="col-md-2">'+
                                            '<a href="/profile/'+data.query[i].User.username+'"><img class="postImage" src="img/'+data.query[i].User.upload+'"></a>'+
                                        '</div>'+
                                        '<div class="col-md-6 col-md-offset-2 userName">'+
                                            data.query[i].User.username+
                                            '<p>'+"Posted on "+data.query[i].Post.created+'</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<p class="contentPost">'+data.query[i].Post.status+'</p>'+
                                '<div class="interaction comment-interact" user_id="'+autID+'" post_id="'+data.query[i].Post.id+'">'+
                                        '<a href="#" class="comment">Comment | </a>'+
                                        '<a href="/likes/isLike/'+data.query[i].Post.id+'" class="like">Like | </a>'+
                                        '<a href="/posts/edit/'+data.query[i].Post.id+'">Edit | </a>'+
                                        '<a href="/posts/delete/'+data.query[i].Post.id+'" class="post-delete">Delete |</a>'+
                                        '<a href="javascript:;" class="postBadge pull-right">Likes<span class="badge likeBadge">0</span></a>'+
                                        '<a href="javascript:;" class="postBadge pull-right">Comments<span class="badge">0</span></a>'+
                                        '<div id="form-comment">'+
                                            '<div id="commentSection">'+
                                            '</div>'+
                                            '<form action="" method="post" >'+
                                                ' <div class="form-group">'+
                                                    '<textarea class="form-control commentBox" name="comment" id="comment" rows="2" placeholder="Type your comment here.."></textarea>'+
                                                 '</div>'+
                                                '<input type="hidden" value="'+data.query[i].Post.id+'" class="form-control hiddenPost">'+
                                                 '<button type="submit" class="btn btn-default commentSubmit">Comment</button>'+
                                            '</form>'+
                                        '</div>'+
                                '</div>'+
                             '</article>';
                }
                $('#showdata').html(html);
            }
        });
    }

   //delete
    $('#commentSection').on('click', '.comment-delete', function(){
        var id = $(this).attr('data');
        $('#deleteModal').modal('show');
        //prevent previous handler - unbind()
        $('#btnDelete').unbind().click(function(){
            $.ajax({
                type: 'ajax',
                method: 'get',
                async: false,
                url: 'comments/delete' ,
                data:{id:id},
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#deleteModal').modal('hide');
                        $('.alert-success').html('Comment Deleted successfully').fadeIn().delay(4000).fadeOut('slow');
                        location.reload();
                    }else{
                        alert('Error');
                    }
                },
                error: function(){
                    alert('Error deleting');
                }
            });
        });
    });


    $('.comment-interact').on('click', '.post-delete', function(){
        var id = $(this).attr('data');
        $('#deleteModal').find('.modal-body').text('Do you want to delete this post?');
        $('#deleteModal').modal('show');
        //prevent previous handler - unbind()
        $('#btnDelete').unbind().click(function(){
            $.ajax({
                type: 'ajax',
                method: 'get',
                async: false,
                url: 'posts/delete/'+id,
                // data:{id:id},
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#deleteModal').modal('hide');
                        $('.alert-success').html('Post Deleted successfully').fadeIn().delay(4000).fadeOut('slow');
                        var url = window.location.href;
                        if (url.indexOf('?') > -1){
                            url += '&param=1';
                        }else{
                            url += '?param=1';
                        }
                        window.location.href = url;
                        showAllPost();
                    }else{
                        alert('Error');
                    }
                },
                error: function(){
                    alert('Error deleting');
                }
            });
        });
    });

    $('#addFollow').on('click', function(event) {
        event.preventDefault();
        var follow_id = $('.hiddenFollow').val();
        $.ajax({
            method: 'POST',
            url: '/follows/addFollow',
            data:{follow_id: follow_id}

        }).done(function(res){
            var data = JSON.parse(res);
           if(data.respondFollow)
           {
               alert("success");
           }
           else{
               alert("none");
            }

        });
    });

});