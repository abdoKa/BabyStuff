$(document).ready(function() {
    $('.new-products').slick({
        centerMode: true,
        infinite: true,
        dots: true,
        centerPadding: '10px',
        slidesToShow: 3,
        responsive: [{
                breakpoint: 800,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '25px',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 570,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '100px',
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.add-to-favourite').click(function(e) {
        e.preventDefault();
        $(this).find('.icon-change').toggleClass('fas');
        var url = $(this).data("url");
        $.post(url, function(data) {
            console.log(data);
        });

    });

    var htmlBody = document.querySelector('body');
    var search = document.querySelector('.search-bar');
    var searchContainer = document.querySelector('.search-bar');
    var searchSubmit = document.querySelector('.search-submit');

    searchContainer.addEventListener('click', activeSearch);
    searchContainer.addEventListener('blur', unactiveSearch, true);
    searchSubmit.addEventListener.click(function(e) {
        e.preventDefault();
        search.blur();
    });



    function activeSearch(event) {
        search.focus();
        htmlBody.classList.add('active');
    }

    function unactiveSearch(event) {
        htmlBody.classList.remove('active');
    }
});