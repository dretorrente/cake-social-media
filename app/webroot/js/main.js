$(document).ready(function() {
    var postId = 0;
    var userId = 0;
    var docu = $(document);
    $( document).on("click",".commentTag",function(event){
        event.preventDefault();
        $(this).parent().find("#form-comment").toggle().find('.commentBox').focus();

    });
    $( document).on("click",".commentSubmit",function(event){
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
                console.log(data);
                var addComment = $('textarea[name=comment]');
                
                html += '<div class="row imageCol">'+
                            '<div class="col-md-1 ">'+
                            '<img src="'+data.User.upload+'" alt="sample profile pic" class="imageComment">'+
                            "</div>"+
                            '<div class="col-md-10">'+
                            data.User.username+
                            '<p>Commented on '+data.Comment.created+'</p>'+
                            ' <div class="jumbotron" id="commentArea">'+
                                    "<p>"+data.Comment.comment+"</p>"+
                            '</div>'+
                            '<a href="/comments/edit/'+data.Comment.id+'" class="comment-edit">Edit | </a>'+
                            '<a href="javascript:;" data="'+data.Comment.id+'" class="comment-delete">Delete</a>'+
                            '</div>'+
                      '</div>';
            
                addComment.val('');
                $this.parent().parent().find('#commentSection').append(html);
                var commentSpan = $this.parent().parent().parent().find('.commentBadge').html();
                var parseComment = parseInt(commentSpan);
                $this.parent().parent().parent().find('.commentBadge').html(parseComment+1);
            });
        });

    $( document).on("click",".like",function(event){
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
    $( document).on("click","#btnAdd",function(e){
        e.preventDefault();
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
                success: function(data){
                    addPost.val('');
                    $('.alert-success').html('Post successfully created').fadeIn().delay(4000).fadeOut('slow');
                    var html = '';
                    var i;
                    var authID = data.userID;
                    console.log(data.query);
                        html += 
                             
                                '<article class="post">'+
                                    '<div class="info postByUser">'+
                                         '<div class="row">'+
                                             '<div class="col-md-2">'+
                                                 '<a href="/profile/'+data.query.User.username+'"><img class="postImage" src="'+data.query.User.upload+'"></a>'+
                                             '</div>'+
                                          '<div class="col-md-6 col-md-offset-2 userName">'+
                                             data.query.User.username+
                                            '<p>'+"Posted on "+data.query.Post.created+'</p>'+
                                          '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<p class="contentPost">'+data.query.Post.status+'</p>'+
                                    '<div class="interaction comment-interact" user_id="'+authID+'" post_id="'+data.query.Post.id+'">'+
                                         '<a href="#" class="commentTag">Comment | </a>'+
                                        '<a href="/likes/isLike/'+data.query.Post.id+'" class="like">Like | </a>'+
                                        '<a href="/posts/edit/'+data.query.Post.id+'">Edit | </a>'+
                                         '<a href="javascript:;" data="'+data.query.Post.id+'" class="post-delete">Delete |</a>'+
                                         '<a href="javascript:;" class="postBadge pull-right">Likes<span class="badge likeBadge">0</span></a>'+
                                         '<a href="javascript:;" class="postBadge pull-right">Comments<span class="badge commentBadge">0</span></a>'+
                                         '<div id="form-comment">'+
                                             '<div id="commentSection">'+
                                             '</div>'+
                                             '<form action="" method="post" >'+
                                                 ' <div class="form-group">'+
                                                      '<textarea class="form-control commentBox" name="comment" id="comment" rows="2" placeholder="Type your comment here.."></textarea>'+
                                                '</div>'+
                                                 '<input type="hidden" value="'+data.query.Post.id+'" class="form-control hiddenPost">'+
                                                 '<button type="submit" class="btn btn-default commentSubmit">Comment</button>'+
                                              '</form>'+
                                        '</div>'+
                                     '</div>'+
                            '</article>';
                    //       
                    $('#showdata').prepend(html);
                },
                error: function(){
                    alert('Could not add data');
                }
            });

        }
    });

   //delete
    $(document).on('click', '.comment-delete', function(event){
        event.preventDefault();
        var id = $(this).attr('data');
        $this = $(this);
        $('#deleteModal').modal('show');
        $('#deleteModal').find('.modal-body').text('Are you sure you want to delete this comment?');
        //prevent previous handler - unbind()
        $('#btnDelete').unbind().click(function(event){
            event.preventDefault();
            $.ajax({
                type: 'ajax',
                method: 'POST',
                async: false,
                url: '/comments/delete/'+id ,
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#deleteModal').modal('hide');
                        $('.alert-success').html('Comment Deleted successfully').fadeIn().delay(4000).fadeOut('slow');
                        var commentSpan = $this.parent().parent().parent().parent().parent().find('.commentBadge').html();
                        var parseComment = parseInt(commentSpan);
                        $this.parent().parent().parent().parent().parent().find('.commentBadge').html(parseComment-1);
                        console.log($this.parent().parent().parent().parent().parent().find('.commentBadge').html());
                        $this.parent().parent().remove();

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
            url: '/follows/addFollow/'+follow_id
        }).done(function(res){
            var data = JSON.parse(res);
           if(data.respondFollow)
           {
               $('#addFollow').html("Followed");
           }
           else{
               $('#addFollow').html("Follow");
            }
        });
    });

    $(document).on('click', '.post-delete', function(){
        var id = $(this).attr('data');
        $this = $(this);
        $('#deleteModal').modal('show');
        $('#deleteModal').find('.modal-body').text('Do you want to delete this post?');
        //prevent previous handler - unbind()
        $('#btnDelete').unbind().click(function(){
            $.ajax({
                type: 'ajax',
                method: 'get',
                async: false,
                url: '/posts/delete/'+id,
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#deleteModal').modal('hide');
                        $('.alert-success').html('Post Deleted successfully').fadeIn().delay(4000).fadeOut('slow');
                        $this.parent().parent().remove();
                    }else{
                        alert('Error');
                    }
                },
                error: function(data){
                    alert('Error deleting');
                    console.log(data);
                }
            });
        });
    });
});


