(function (app, $) {
  "use strict";

	  if(app) {
		  /** Only zipcode validations for now. Could be later extended to handle other fields  - regex value from custom preferences */
		  /** Phone validation on the frontend is handled seperately - see app.validatePhone below */
		  
		  app.validateCheckoutForm = (function () {			  
			  var $cache = {};
			  return {
				 init: function() {
					 var self = this;
					 $cache.regex = JSON.parse(app.constants.postcode_regex) || {};
					 
					 // Set up validator
					 $.validator.addMethod("zip", self.validatePostCode, app.resources.INVALID_ZIP);
				 },
				 
				 validatePostCode: function(value, el) {
					var country = $(el).closest("form").find("select[name$='_country']");
					
				    if(country.length === 0 || country.val().length === 0 || !$cache.regex[country.val().toUpperCase()] || !$cache.regex[country.val().toUpperCase()].postCode) {
				      return true;
				    }
				    
				    var rgx = new RegExp($cache.regex[country.val().toUpperCase()].postCode.regex, 'ig');
				    var isOptional = this.optional(el),
				      isValid = rgx.test($.trim(value));

				    return isOptional || isValid;
				 }
			  };
			  
			  
		  })();
	  } else { 
		// name space has not been defined yet
		console.log("app namespace is not loaded yet!");
	  }
 }(window.app = window.app || {}, jQuery));
 
jQuery(document).ready(function() {
	app.validateCheckoutForm.init();
});

