var $table = $('.js-product-table');
$table.find('.js-delete-product').on('click', function(e) {
    e.preventDefault();
    $(this).addClass('text-danger');
    $(this).find('.fa')
        .removeClass('fa-trash')
        .addClass('fa-spinner')
        .addClass('fa-spin');
    var deleteUrl = $(this).data('url');
    var $row = $(this).closest('tr');
    swal({
            title: "Êtes-vous sûr?",
            text: "Ce Produit va supprimer complètement sur votre catalogue 😨",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Oui, supprime-le!",
            cancelButtonText: "Non, annuler s'il vous plaît!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: deleteUrl,
                    method: 'DELETE',
                    success: function() {
                        $row.fadeOut();
                    }
                });
                swal("Dommage!!", "ce produit était supprimer sur votre panier ", "success");
            } else {
                swal("Annulé", "vous etes Annulé la suppression 😅", "error");
            }
        });

});