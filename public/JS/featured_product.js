$('.is-featured').click(function(e) {
    e.preventDefault();
    $(this).find('.icon-change').toggleClass('fas');

    var url = $(this).data("url");
    $.post(url, function(data) {
        if (data.status == 'ok') {
            if (data.bookmark == false) {
                console.log(data.bookmark);
                swal({
                    title: "📌",
                    text: "ce produit est ajouté dans la list des produits en-vedette",
                    icon: "info",
                    closeOnClickOutside: false,
                });
            } else {
                swal({
                    title: "🗑",
                    text: "ce produit est supprimé dans la list des produits en-vedette",
                    icon: "info",
                    closeOnClickOutside: false,
                });
            }
        }
    });
});