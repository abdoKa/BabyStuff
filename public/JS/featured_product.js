$('.is-featured').click(function(e) {
    e.preventDefault();
    $(this).find('.icon-change').toggleClass('fas');
    var url = $(this).data("url");
    if ($(this).find('.icon-change').hasClass('far fa-bookmark fas')) {
        $.post(url, function(data) {
            if (data.status == 'ok') {
                data.featured;


            }
            swal("Here's a message!");
            console.log('bookmark');
            console.log(data.featured);

        });

    } else
    if ($(this).find('.icon-change').hasClass('far fa-bookmark')) {
        console.log('No-bookmark');
    }
});