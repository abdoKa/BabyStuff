$('.is-featured').click(function(e) {
    e.preventDefault();
    $(this).find('.icon-change').toggleClass('fas');

    var url = $(this).data("url");
    $.post(url, function(data) {
        if (data.status == 'ok') {
            if (data.bookmark == false) {
                console.log(data.bookmark);
                swal({
                    title: "Bookmark",
                    text: "Permissions assigned Successfully",
                    icon: "info",
                    closeOnClickOutside: false,
                });
            } else {
                swal({
                    title: "No-Bookmark",
                    text: "Permissions assigned Successfully",
                    icon: "info",
                    closeOnClickOutside: false,
                });
            }
        }
    });
});