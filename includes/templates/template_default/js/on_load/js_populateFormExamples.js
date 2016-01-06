(function (app, $) {
  "use strict";

    if(app) {
      app.populateFormExamples = (function() {
        var $cache = {};
    
        return {
          init: function() {
          if($('form.address.checkout-shipping').length > 0) {
            $cache.currentPage = "shipping";
          } else if($('form.address.checkout-billing').length > 0) {
            $cache.currentPage = "billing";
          }
          // If the current page is not either shipping or billing, then return
          if($cache.currentPage == undefined) { return; }
          
          var self = this;
            $cache.country = $('select[name$="_country"]');
            $cache.elems = {};
            
            var examplesJSON = JSON.parse(app.constants.co_form_examples);
            $cache.formExamples = examplesJSON[$cache.currentPage] || {};  

            $cache.formExampleElemClass = 'field-example',
            $cache.formExampleElemSelector = 'span.'+ $cache.formExampleElemClass;
            
            $.each($cache.formExamples, function(key, value) {
              if( !$.isEmptyObject(value) ) {
                $cache.elems[key] = $('[name$="_'+ key +'"]');
              }
            }); 
            
            this.eventHandlers();
            $cache.country.trigger('change');
          },
          
          eventHandlers: function() {
            var self = this;
    
            $cache.country.on('change', function(e) {
              self.populateExamples();
            });
          },
          
          populateExamples: function() {
            var self = this,
              selectedCountry = $cache.country.val().toLowerCase() || 'default';
            
            // Clear existing examples
            $($cache.formExampleElemSelector).text('');
            
            // Populate the appropriate examples
            $.each($cache.elems, function(key, value) {
            var exampleText = ( $cache.formExamples[key][selectedCountry] != undefined ) ? $cache.formExamples[key][selectedCountry] : $cache.formExamples[key]['default'];
              
              if(exampleText) {
                var exampleElemnt = self.getFormExampleElement(key);
              
                if(exampleElemnt != undefined) {
                  exampleElemnt.text(exampleText);
                }
            }
            });
          },
          
          getFormExampleElement: function(key) {
            var self = this;
            
            var $elem,
              $mainElem = $cache.elems[key], 
              elemClass = $cache.formExampleElemClass ,
              elemSelector = $cache.formExampleElemSelector;

            
            if( $mainElem != undefined) {
              if( $mainElem.parent().find(elemSelector).length > 0 ) {
                $elem = $mainElem.parent().find(elemSelector);
              } else {
                $elem = $('<span></span>')
                  .addClass(elemClass+ " form-caption")
                  .appendTo($mainElem.parent());
              }
            }
            
            return $elem;
            
          }
        };
    
      })();
      
      
    } else { 
      // name space has not been defined yet
      console.log("app namespace is not loaded yet!");
    }
 }(window.app = window.app || {}, jQuery));
 
jQuery(document).ready(function() {
  function enablePlugins() {
    app.populateFormExamples.init();
  } 
  
  
  // Account for AJAX-based form. Wait for it to be rendered and enable
  
  var shippingForm = $('#shipping-form');
  if(app.constants.CC_ENABLED && shippingForm.length > 0) {
    shippingForm.on('shipping-form-rendered', function(e) {
      enablePlugins();
    });
  } else {
    enablePlugins();
  }
});