  //Remove One Product
  $('.product-remove').click(function(e) {
      e.preventDefault();
      var item = $(this);
      var url = $(this).data("url");
      swal({
              title: "Êtes-vous sûr?",
              text: "Ce Produit va supprimer complètement sur votre panier 😨",
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
                  $.post(url, function(data) {

                      if (data.cart == 0) {
                          window.location.replace("/cart");
                      }
                      if (data.status == 'ok') {

                          swal("Dommage!!", "ce produit était supprimer sur votre panier ", "success");
                          $(item).parent().parent('.item').remove();
                          $('#totalSum').text(data.totalSum);
                          $('.sum-total').text(data.totalSum);
                          console.log(data);
                      } else {
                          swal("Error", "Problem ajax", "error");
                      }
                  });
              } else {
                  swal("Annulé", "vous méritez ce produit 😉", "error");
              }
          });
  });

  $('.clear-cart').click(function(e) {
      e.preventDefault();
      var url = $(this).data("url");
      swal({
              title: "Êtes-vous sûr?",
              text: "êtes-vous sûr de vouloir vider le panier 😨",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes, delete it!",
              cancelButtonText: "No, cancel plx!",
              closeOnConfirm: false,
              closeOnCancel: false
          },
          function(isConfirm) {
              if (isConfirm) {
                  $.post(url, function(data) {


                      if (data.status == 'ok') {
                          window.location.replace("/cart");

                          swal("Dommage!", "votre panier est vide 🤦‍♀️", "success");
                      } else {
                          swal("Error", "Problem ajax", "error");
                      }
                  });
              } else {
                  swal("Annulé", "tu a gardé votre panier 👍 ", "error");
              }
          });
  });


  $('input.quantity').change(function() {
      var quantity = $(this).val();
      var url = $(this).data("url") + "/" + $(this).val();
      var input = $(this);

      $.post(url, function(data) {

          if (data.status == 'ok') {
              $('#totalSum').text(data.totalSum);
              $('.sum-total').text(data.totalSum);
              $(input).parents('.item').find('.sum-product').text(data.productSum);

          }
      });


  });