// $(document).ready(function() {
//     alertify.set('notifier', 'position', 'top-right');

//     // Unbind previous click events to prevent multiple bindings
//     $(document).off('click', '.increment');
//     $(document).off('click', '.decrement');

//     // Increment quantity
//     $(document).on('click', '.increment', function() {
//         var $quantityInput = $(this).closest('.qtyBox').find('.qty');
//         var ingredientId = $(this).closest('.qtyBox').find('.ingId').val();
//         var currentValue = parseInt($quantityInput.val());

//         if (!isNaN(currentValue)) {
//             var qtyVal = currentValue + 1;
//             $quantityInput.val(qtyVal);
//             ingredientIncDec(ingredientId, qtyVal);
//         }
//     });

//     // Decrement quantity
//     $(document).on('click', '.decrement', function() {
//         var $quantityInput = $(this).closest('.qtyBox').find('.qty');
//         var ingredientId = $(this).closest('.qtyBox').find('.ingId').val();
//         var currentValue = parseInt($quantityInput.val());

//         if (!isNaN(currentValue) && currentValue > 1) {
//             var qtyVal = currentValue - 1;
//             $quantityInput.val(qtyVal);
//             ingredientIncDec(ingredientId, qtyVal);
//         }
//     });

//     // Function to handle quantity change via AJAX
//     function ingredientIncDec(ingId, qty) {
//         $.ajax({
//             type: "POST",
//             url: "purchase-orders-code.php",
//             data: {
//                 'ingredientIncDec': true,
//                 'ingredient_id': ingId,
//                 'quantity': qty
//             },
//             success: function(response) {
//                 var res = JSON.parse(response);
//                 if (res.status == 200) {
//                     $('#ingredientArea').load(' #ingredientContent');
//                     alertify.success(res.message);
//                 } else if (res.status == 500) {
//                     alertify.error(res.message);
//                      // Disable the increment button
//                 var $quantityInput = $('.qtyBox').find('.prodId[value="' + prodId + '"]').closest('.qtyBox').find('.increment');
//                 $quantityInput.prop('disabled', true); // Disable increment button
//                 }
//             }
//         });
//     }


//     // Proceed to Place Ingredient
//     $(document).on('click', '.proceedToPlaceIng', function() {

//         var adminName = $('#adminName').val();
//         var ingPayment_mode = $('#ingPayment_mode').val();
//         var supplierName = $('#supplierName').val();

//         // Validate Payment Method
//         if (ingPayment_mode == '') {
//             swal("Select Payment Method", "Select your payment method", "warning");
//             return false;
//         }

//         // Validate Supplier
//         if (supplierName == '') {
//             swal("Select Supplier", "Select your supplier", "warning");
//             return false;
//         }

//         // Validate Admin Name
//         if (adminName == '') {
//             swal("Enter admin name", "Enter a valid admin name", "warning");
//             return false;
//         }

//         var data = {
//             'proceedToPlaceIng': true,
//             'adminName': adminName,
//             'ingPayment_mode': ingPayment_mode,
//             'supplierName': supplierName,
//         };

//         $.ajax({
//             type: "POST",
//             url: "purchase-orders-code.php",
//             data: data,
//             dataType: "json", // Expecting JSON response
//             success: function(response) {
//                 if (response.status == 200) {
//                     // Admin exists, proceed to the next step
//                     window.location.href = "purchase-order-summary.php";
//                 } else if (response.status == 404) {
//                     // Admin does not exist, show error
//                     swal(response.message, response.message, response.status_type);
//                 } else {
//                     // Handle any other status/error
//                     swal(response.message, response.message, response.status_type);
//                 }
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 console.error('AJAX Error', textStatus, errorThrown);
//                 swal('Error', 'Failed to process the request', 'error');
//             }
//         });
        
//     });

//     $(document).on('click', '#savePurchaseOrder', function() {
//         $.ajax({
//             type: "POST",
//             url: "purchase-orders-code.php",
//             data: {
//                 'savePurchaseOrder': true   
//             },
//             success: function(response){
//                 try {
//                     var res = JSON.parse(response);  // Parse JSON only if valid
//                     if(res.status == 200){
//                         swal(res.message, res.message, res.status_type);
//                         $('#orderPlaceSuccessMessage').text(res.message);
//                         $('#orderSuccessModal').modal('show');

//                     }else{
//                         swal(res.message, res.message, res.status_type);
//                     }
//                 } catch (e) {
//                     console.error("Invalid JSON response:", response);
//                     swal("Error", "Unexpected response from server", "error");
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error("AJAX Error:", error);
//                 swal("Error", "Failed to process order", "error");
//             }
//         });
//     });  

    
// });