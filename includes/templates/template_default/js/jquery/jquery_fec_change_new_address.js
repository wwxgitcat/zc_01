$(document).ready(function(){
  // modify the change shipping address button
  prepareFacebox();
  $('select[name="address"]').livequery('change', function() {
    var addressID = $(this).val();
    $('div.detailShippingAddr').hide();
    $('div#detailShippingAddrBook'+addressID).show();
  });
});

function prepareFacebox() {
  $('a#linkCheckoutShippingAddr').attr({
    'href': 'fec/fec_change_new_address.php?type=checkout_shipping_address',
    'rel': 'facebox'
  });
  $('a#linkCheckoutPaymentAddr img').attr('id', 'changeCheckoutShippingAddr');
  
  // modify the change payment address button
  $('a#linkCheckoutPaymentAddr').attr({
    'href': 'fec/fec_change_new_address.php?type=checkout_payment_address',
    'rel': 'facebox'
  });
  $('a#linkCheckoutPaymentAddr img').attr('id', 'changeCheckoutPaymentAddr');
  
  //facebox
  $('a[rel*=facebox]').facebox({
    loading_image : 'images/loading.gif',
    close_image   : 'images/closelabel.gif'
  });
}