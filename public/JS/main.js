$(document).ready(function() {
    $('.new-products').slick({
        infinite: true,
        dots: true,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 4,
        responsive: [{
                breakpoint: 770,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 2
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

    $('.add-to-favourite').click(function(e) {
        e.preventDefault();
        $(this).find('.icon-change').toggleClass('fas');
    });
});


$('.list-group-item-action').click(function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
});