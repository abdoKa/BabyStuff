  //Remove One Product
  $('.product-remove').click(function(e) {
      e.preventDefault();
      var item = $(this);
      var url = $(this).data("url");
      swal({
              title: "Are you sure?",
              text: "You will not be able to recover this imaginary file!",
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

                      if (data.cart == 0) {
                          window.location.replace("/cart");
                      }
                      if (data.status == 'ok') {
                          swal("Deleted!", "Your imaginary file has been deleted.", "success");

                          $(item).parent().parent('.item').remove();
                          $('.totamSum').text(data.totalSum);
                          $('#totalSum').text(data.totalSum);
                      } else {
                          swal("Error", "Problem ajax", "error");
                      }
                  });
              } else {
                  swal("Cancelled", "Your imaginary file is safe :)", "error");
              }
          });
  });

  $('.clear-cart').click(function(e) {
      e.preventDefault();
      var item = $(this);
      var url = $(this).data("url");
      swal({
              title: "Are you sure?",
              text: "You will not be able to recover this imaginary file!",
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

                          swal("Deleted!", "Your imaginary file has been deleted.", "success");
                      } else {
                          swal("Error", "Problem ajax", "error");
                      }
                  });
              } else {
                  swal("Cancelled", "Your imaginary file is safe :)", "error");
              }
          });
  });

  //edit quantity
  //** var url = $(this).data("url");
  //$.post(url, function (data) {
  //if (data.status == 'ok') {
  //  $('#totalSum').text(data.totalSum);
  //  $('.totamSum').text(data.totalSum);





  $('input.quantity').change(function() {
      var url = $(this).data("url") + "/" + $(this).val();
      td = $(this);
      $.post(url, function(data) {
          if (data.status == 'ok') {
              console.log(data);
              $('#totalSum').text(data.totalSum);
              $(td).parent().parent('.sum').text(data.totalSum);

          }
      });


  });