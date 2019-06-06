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
    $.ajax({
        url: deleteUrl,
        method: 'DELETE',
        success: function() {
            $row.fadeOut();
        }
    });
});