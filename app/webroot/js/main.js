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
                $this.children('.like').html("Like |");

            }
            else
            {
                $this.html('Like |');

            }


        });
    });


    // function showAllPosts(){
    //          gettingAuth();
    //         $.ajax({
    //             type: 'ajax',
    //             url: '/posts/showAllPosts',
    //             async: false,
    //             dataType: 'json',
    //             success: function(response){
    //             var html = '';
    //             var userprofile ='';
    //
    //             // response.forEach(function(message){
    //             //
    //             //
    //             //    for(var i=0; i<message.Comment.length; i++)
    //             //     {
    //             //           if(message.Comment[i].post_id == message.Post.id)
    //             //           {
    //             //             // commentProfile = '<a href="/profile/'+message.Comment[i].User.username+'"><img src="'+message.Comment[i].User.upload+'" alt="sample profile pic" class="imageComment"></a>';
    //             //
    //             //             commentProfile+=  '<div class="row imageCol">'+
    //             //                                     '<div class="col-md-1 ">'+
    //             //                                         '<a href="/profile/'+message.Comment[i].User.username+'"><img src="'+message.Comment[i].User.upload+'" alt="sample profile pic" class="postImage"></a>';
    //             //                                      '</div>'+
    //             //                                     '<div class="col-md-10"><p></p></div>'+
    //             //                                 '</div>';
    //             //
    //             //
    //             //              $('#form-comment').html(commentProfile);
    //             //
    //             //             }
    //             //     }
    //             //
    //             //     if(message.Post.user_id == message.User.id)
    //             //     {
    //             //         userprofile = '<a href="/profile/'+message.User.username+'"><img src="'+message.User.upload+'" alt="sample profile pic" class="postImage"></a>';
    //             //     }
    //             //
    //             //     html += '<article class="post">'+
    //             //                  '<div class="info postByUser">'+
    //             //                     '<div class="row">'+
    //             //                         '<div class="col-md-2">'+
    //             //                             userprofile+
    //             //                         '</div>'+
    //             //                         '<div class="col-md-6 userName">'+
    //             //                             message.User.username+
    //             //                             '<p>Posted on ' + message.Post.created + '</p>'+
    //             //                         '</div>'+
    //             //                     '</div>'+
    //             //                 '</div>'+
    //             //                 '<p class="contentPost">' + message.Post.status +' </p>'+
    //             //                 '<div class="interaction comment-interact" user_id="'+authID+'" post_id="'+message.Post.id+'">'+
    //             //                     ' <a href="#" class="comment">Comment | </a>'+
    //             //                     '<a href="/likes/isLike/'+message.Post.id+'" class="like">Like | </a>'+
    //             //                     '<a href="/posts/edit/'+message.Post.id+'" class="post-edit">Edit | </a>'+
    //             //                     '<a href="/posts/delete/'+message.Post.id+'" class="post-edit">Delete </a>'+
    //             //                     ' <a href="#" class="postBadge pull-right">Likes<span class="badge">0</span></a>'+
    //             //                     '<a href="#" class="postBadge pull-right">Comments<span class="badge">0</span></a>'+
    //             //
    //             //                     '</div>'+
    //             //             '</article>';
    //             //
    //             // });
    //             //
    //             //     $('#showAllPosts').html(html);
    //             //
    //             //
    //             // },
    //
    //         });
    //     }




    });