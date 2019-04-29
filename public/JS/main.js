$(document).ready(function() {
    $('.new-products').slick({
        centerMode: true,
        infinite: true,
        dots: true,
        centerPadding: '10px',
        slidesToShow: 3,
        responsive: [{
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '10px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '10px',
                    slidesToShow: 1
                }
            }
        ]
    });


    $('.add-to-favourite').click(function(e) {
        e.preventDefault();
        $(this).find('.icon-change').toggleClass('fas');
    });

    $('.add-features').click(function(e) {
        e.preventDefault();
        $(this).find('.icon-change').toggleClass('fas');
    });


    $('.dropdown-toggle').select2({
        selectOnClose: true
    });



    tinymce.init({
        selector: '#produit_description , #edit_p_description , #categorie_description , #edit_categorie_description',
        height: 500,
        menubar: true,
        plugins: "lists code ",
        toolbar: 'numlist bullist | undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | code',
        setup: function(editor) {
            editor.on('change', function(e) {
                editor.save();
            });
        }
    });


});