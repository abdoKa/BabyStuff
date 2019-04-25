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

    $('.add-features').click(function(e) {
        e.preventDefault();
        $(this).find('.icon-change').toggleClass('fas');
    });

    $('.dropdown-toggle').select2({
        selectOnClose: true
    });



    tinymce.init({
        selector: '#produit_description , #edit_p_description',
        height: 500,
        menubar: true,
        plugins: "lists",
        toolbar: 'numlist bullist | undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | code',
        setup: function(editor) {
            editor.on('change', function(e) {
                editor.save();
            });
        }
    });


    // UPDATE TABLES
    var products = $('#products');

    if ($(products)) {
        $(products).click(function(e) {
            e.preventDefault();
            if ($(e.target).hasClass('delete-me btn-danger')) {
                if (confirm('Are You Sure')) {
                    var id = e.target.attr('data-id');
                    alert(id);
                    alert("yes");
                }
            }
        });
    }
});