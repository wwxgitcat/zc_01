(function(app, $){
  "use strict";

  if(app) {
    
    app.clickandcollect = {
        
      init : function() {      
        var selectedshippingmethod = jQuery( "#shipping-method-list input[name$=shippingMethodID]:checked" ).val();      
          if ( app.constants.cc_shipping_type != "" && selectedshippingmethod == app.constants.cc_shipping_type ) {
            app.clickandcollect.expandform( selectedshippingmethod, 'ClickandCollectForm' );
          }              
          else {
            app.clickandcollect.expandform( selectedshippingmethod, 'SingleShippingForm' );  
          };
        
        jQuery( ".single-shipping" ).on("click", "#shipping-method-list input", function() {
          if (jQuery(this).val()==app.constants.cc_shipping_type) {
            app.clickandcollect.expandform( jQuery(this).val(), "ClickandCollectForm" );
          }
          else {
            app.clickandcollect.expandform( jQuery(this).val(), "SingleShippingForm" );
          }        
        });      
      },      
      
      expandform : function(shipping_type, formtype) {
        var formElem = jQuery('form'), 
          shippingform = jQuery( "#shipping-form" ),
          ClickandCollectCSSClass = "click-and-collect-form";
        
        shippingform.load(app.util.getPipeUrl( "COShipping-" + formtype ), function() {
          if(formtype == 'ClickandCollectForm') {
            formElem.addClass( ClickandCollectCSSClass );
          } else {
            formElem.removeClass( ClickandCollectCSSClass );
          }
          
          shippingform
            .slideDown( "500" )
            .trigger('shipping-form-rendered');
        });
      }
    } // end clickandcollect
  } else { 
    // name space has not been defined yet
    alert("app namespace is not loaded yet!");
  }
  
}(window.app = window.app || {}, jQuery));

jQuery(document).ready(function() {
  if (app.constants.cc_enabled==true) {
    app.clickandcollect.init();    
  }
});
