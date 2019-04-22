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

    $('.dropdown-toggle').select2({
        selectOnClose: true
    });



    // tinymce.init({
    //     selector: 'textarea#produit_description',
    //     height: 500,
    //     menubar: true,
    //     plugins: [
    //         'advlist autolink lists link image charmap print preview anchor textcolor',
    //         'searchreplace visualblocks code fullscreen',
    //         'insertdatetime media table paste code help wordcount code'
    //     ],
    //     toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | code',

    // });


    const products = $('#product');

    if (products) {
        products.click(function(e) {
            if (e.target.className === 'btn-danger delete-product') {
                alert('ok');
            }
        });
    }
});