$(document).ready(function() {
    $('.new-products').slick({
        infinite: true,
        dots: true,
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 4,
        responsive: [{
                breakpoint: 768,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            }

        ]
    });

    $('.add-to-favourite').click(function() {
        /*  var fav = $(this).find('.icon-change');
         if (fav.hasClass('far fa-heart')) {
             fav.removeClass('far fa-heart')
                 .addClass('fas fa-heart')
         } else {
             fav.removeClass("fas fa-heart").addClass("far fa-heart")

         } */
    });
    $('.add-to-favourite').click(function(e) {
        e.preventDefault();
        $(this).find('.icon-change').toggleClass('fas');
    });

    // var scrolllink = $('.scroll');

    // //Smooth scrolling
    // scrolllink.click(function(e) {
    //     e.preventDefault();

    //     $('body, html').animate({
    //         scrollTop: $(this.hash).offset().top
    //     }, 3000);
    // });

    // //

});