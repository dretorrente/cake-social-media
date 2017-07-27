$(document).ready(function(){
    var postId = 0;

    $('.comment-interact').each(function(i) {
        $(this).find('.comment').on('click',function(event) {
            event.preventDefault();
            $(this).parent().find("#form-comment").toggle().find('commentBox').focus();

        });

    });

    //
    // $('.likes').on('click', function(event) {
    //     event.preventDefault();
    //     alert(1);
    //
    // });



});