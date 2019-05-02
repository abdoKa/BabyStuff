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
    });

    $('.add-features').click(function(e) {
        e.preventDefault();
        $(this).find('.icon-change').toggleClass('fas');
    });


    $('.dropdown-toggle').select2({
        selectOnClose: true
    });


    setTimeout(function() {
        $("div.alert").delay(6000).slideUp(300);
    }, 5000); // 5 secs

    tinymce.init({
        selector: '#produit_description , #edit_product_description , #categorie_description , #edit_categorie_description , #brands_description, #edit_brand_description',
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