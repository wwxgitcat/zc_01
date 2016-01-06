
/* date formating plugin
 * http://blog.stevenlevithan.com/archives/date-time-format
 * http://jsfiddle.net/phZr7/1/
 */

var dateFormat=function(){var e=/d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,t=/\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,n=/[^-+\dA-Z]/g,r=function(e,t){e=String(e);t=t||2;while(e.length<t)e="0"+e;return e};return function(i,s,o){var u=dateFormat;if(arguments.length==1&&Object.prototype.toString.call(i)=="[object String]"&&!/\d/.test(i)){s=i;i=undefined}i=i?new Date(i):new Date;if(isNaN(i))throw SyntaxError("invalid date");s=String(u.masks[s]||s||u.masks["default"]);if(s.slice(0,4)=="UTC:"){s=s.slice(4);o=true}var a=o?"getUTC":"get",f=i[a+"Date"](),l=i[a+"Day"](),c=i[a+"Month"](),h=i[a+"FullYear"](),p=i[a+"Hours"](),d=i[a+"Minutes"](),v=i[a+"Seconds"](),m=i[a+"Milliseconds"](),g=o?0:i.getTimezoneOffset(),y={d:f,dd:r(f),ddd:u.i18n.dayNames[l],dddd:u.i18n.dayNames[l+7],m:c+1,mm:r(c+1),mmm:u.i18n.monthNames[c],mmmm:u.i18n.monthNames[c+12],yy:String(h).slice(2),yyyy:h,h:p%12||12,hh:r(p%12||12),H:p,HH:r(p),M:d,MM:r(d),s:v,ss:r(v),l:r(m,3),L:r(m>99?Math.round(m/10):m),t:p<12?"a":"p",tt:p<12?"am":"pm",T:p<12?"A":"P",TT:p<12?"AM":"PM",Z:o?"UTC":(String(i).match(t)||[""]).pop().replace(n,""),o:(g>0?"-":"+")+r(Math.floor(Math.abs(g)/60)*100+Math.abs(g)%60,4),S:["th","st","nd","rd"][f%10>3?0:(f%100-f%10!=10)*f%10]};return s.replace(e,function(e){return e in y?y[e]:e.slice(1,e.length-1)})}}();dateFormat.masks={"default":"ddd mmm dd yyyy HH:MM:ss",shortDate:"m/d/yy",mediumDate:"mmm d, yyyy",longDate:"mmmm d, yyyy",fullDate:"dddd, mmmm d, yyyy",shortTime:"h:MM TT",mediumTime:"h:MM:ss TT",longTime:"h:MM:ss TT Z",isoDate:"yyyy-mm-dd",isoTime:"HH:MM:ss",isoDateTime:"yyyy-mm-dd'T'HH:MM:ss",isoUtcDateTime:"UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"};dateFormat.i18n={dayNames:["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],monthNames:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","January","February","March","April","May","June","July","August","September","October","November","December"]};Date.prototype.format=function(e,t){return dateFormat(this,e,t)}

// MYBUYS
// This is for mybuys page recommendations.  This renders recommendations on the page.

function loadzone(zones) {
  for (zonekey in zones) { 
    try {
      try { 
        if (typeof zones[zonekey] == 'function') {
          continue;
        }
      } catch(e) {
        continue; 
      }
      
      var zoneDivId = zones[zonekey].divId,
          zoneDivTitle = zones[zonekey].zoneTitle,
          zoneDiv = document.getElementById(zoneDivId);
      
      if (zoneDiv) {
        var recs = zones[zonekey].recs;
        var htmlContent = '<div class="recommendations mbzone-data cross-sell"><div class="mb-header"><h3><span>Other items</span> You Might Like</h3></div><div id="mybuys-carousel" class="carousel slide"><div class="carousel-inner"><ul id="carousel-recomendations">  ';
        
        for (var i=0; i<recs.length; i++) {
          if (recs[i]) {
            htmlContent += '<li><div class="product-tile"><div class="product-image recommendation_image"><a href="' + recs[i].productUrl + '" onclick="mybuys.track(\'' + recs[i].trackUrl +' \')"><img src="' + recs[i].imageUrl + '"/></a></div><div class="product-name"><a href="' + recs[i].productUrl + '" onclick="mybuys.track(\'' + recs[i].trackUrl +' \')" title="'+recs[i].name+'">'+recs[i].name+'</a></div><div class="product-price"><span class="price-sales">'+ recs[i].price.replace('.00','') + '</span></div></div></li>';
          }
        }
        
        zoneDiv.innerHTML=htmlContent + '</ul></div></div></div>';
      
        if(app.constants.MY_BUYS_IN_CART && mybuys.pagetype=="SHOPPING_CART") {
          $(zoneDiv).find('#carousel-recomendations li').each(function() {
            app.quickView.initializeButton($(this).find('div.product-tile'), ".product-image");
          });
        }
      }
    } catch(e) {
      // console.log(e);
    }
  }
}


app.lazy = {
  init: function() {
    app.lazy.lazyImageInit();
    
    $(window).load(function() {
      app.lazy.loadNext();
    });
  },
  
  loadNext: function() {
    var $element = $(".js-lazy-slot:first");
    
    if ($element.length) {
      var url = app.util.getPipeUrl("Page-LazySlot") + "?id=" + $element.data("id");
      
      if ($element.data("cgid")) {
        url += "&cgid=" + $element.data("cgid");
      }
      
      $.get(url, function(content) {
        var $loaded = $(content);
        $element.replaceWith($loaded);
        
        app.lazy.bindEvents($loaded);
        
        $(window).on("scroll.lazy", function(e) {
          if (!$loaded.length) {
            $(window).off("scroll.lazy");
            return;
          }
          
          var offset = $loaded.offset();
          
          if ($(window).scrollTop() + $(window).height() > offset.top) {
            $(window).off("scroll.lazy");
            app.lazy.loadNext();
          }
        });
      });
    }
  },
  
  bindEvents: function($element) {
    $element.find('.js-tooltip').dwTooltip();
    $element.find('.js-popup, .dialogify').dwPopup();
  },
  
  lazyImageInit: function() {
    $(".js-lazy-image").each(function(e) {
      var $this = $(this);
      
      if (!$this.data("trigger") || $this.data("trigger") === "load") {
        $(window).load(function() {
          app.lazy.loadGroup($this);
        });
      } else {
        $this.mouseover(function(e) {
          app.lazy.loadGroup($this);
        });
      }
    });
  },
  
  loadGroup: function($element) {
    if ($element.data("src")) {
      app.lazy.loadImage($element);
    } else {
      $element.find("[data-src]").each(function() {
        app.lazy.loadImage($(this));
      });
    }
    
    $element.show().removeClass("visually-hidden");
  },
  
  loadImage: function($img) {
    if (typeof $img === "string") {
      $img = $(img);
    }
    
    var cssClass = $img.data("class") ? $img.data("class") : '';
    var alt = $img.data("alt") ? $img.data("alt") : '';
    
    var $content = $('<img class="' + cssClass + '" src="' + $img.data("src") + '" alt="' + alt + '"/>');    
    $img.replaceWith($content);
  }
};

app.lazy.init();


//this is for all the email sign up on the site 
(function(app, $) {
  "use strict";
  
  var $formSubmit,
      $nextStepBtn,
      $dobField,
      $emailSignupContainer,
      $emailSignupSlot,
      formId,
      containerId,
      steps,
      ageRequired,
      formSteps,
      maxSteps;

  app.emailSignup = {
    init : function() {
      $('.email-container-div').removeClass('hidden');  
      
      if (!$.cookie('firstTimeVisitorPopup-' + app.resources.STORENAME_URL) && $('#newsletter-email-popup').length) {
        $('#newsletter-email-popup').addClass('visually-hidden');
        this.firstTimeVisitorPopup();
      }
      
      // Set form steps and vars on init in the case of multiple signup forms
      
      var $emailContainer = $('.email-container-div'),
          i;
      
      for (i = 0; i < $emailContainer.length; i++) {
        $formSubmit = $emailContainer.eq(i).find('.emailoptin-button'),
        $nextStepBtn = $emailContainer.eq(i).find('.next-step'),
        $dobField = $emailContainer.eq(i).find('.birthday-date'),
        formId = $emailContainer.eq(i).prop('id'),
        steps = $emailContainer.eq(i).hasClass('steps'),
        ageRequired = $('#' + formId).find('.age-required').length ? $('#' + formId).find('.age-required').data('agerequired') : '';
        
        if ($dobField.length) {
          this.loadBirthdayDateField();
        } 
        
        this.enterKeySubmit($nextStepBtn);
        this.checkForSteps();
      }
    },
    
    setFormVars : function(parentSelector) {
      $formSubmit = $(parentSelector).find('.emailoptin-button'),
      $emailSignupContainer = $formSubmit.closest(parentSelector),
      $emailSignupSlot = $(parentSelector).closest('.email-signup-slot'),
      formId = $formSubmit.closest(parentSelector).find('form').prop('id'),
      containerId = $formSubmit.closest(parentSelector).prop('id');
    },
    
    firstTimeVisitorPopup : function() {    
      var dialogWidth;
        
      if ($(window).width() >= 767) {
        dialogWidth = 825;
      } else if ($(window).width() >= 386) {
        dialogWidth = 425;
      } else if ($(window).width() <= 385) {
        dialogWidth = 330;
      }  
      
      var $newsLetterPopup = $('#newsletter-email-popup').detach();
      
      $.dwPopup.create($newsLetterPopup.html(), {
        autoOpen : true,    
        width: dialogWidth,
        height: 'auto',
        classname: 'first-time-visitor-popup',
        
        onOpen : function() {
          app.emailSignup.setFormVars($('.popup').find('form').closest('.email-container-div'));
        },
        
        onClose : function() {                 
          $.cookie('firstTimeVisitorPopup-' + app.resources.STORENAME_URL, 'true', { expires: 365, path: '/' });
        }
      });
    },
    
    checkForSteps : function() {
      if (steps) {
        app.emailSignup.setupSteps();        
      } else {
        app.emailSignup.submitForm();
      }   
    },
    
    setupSteps : function() {
      // Build array of possible steps based on form elements 
          
      var $emailContainer =  $('.email-container-div.steps'),
          i,
          j,
          k;
      
      formSteps = [];
      
      for (i = 0; i < $emailContainer.length; i++) {
        formSteps[i] = [];
        
        $emailContainer.eq(i).find('.emailoptin-button').addClass('hidden');
                        
        for (j = 0; j < $emailContainer.eq(i).find('.formfield').length; j++) {
          formSteps[i].push($emailContainer.eq(i).find('.formfield').eq(j).addClass('hidden'));
          formSteps[i][0].removeClass('hidden'); 
        } 
        
        maxSteps = [];
        
        for (k = 0; k < formSteps.length; k++) {
          maxSteps.push(formSteps[k].length);           
        }
        
        $nextStepBtn = $emailContainer.find('.next-step').eq(i);
        
        /* Loads stepping functionality between fields
           Checks for required fields and validation before going forward */
        
        this.nextStep(maxSteps, i, $nextStepBtn);
      }   
    },
    
    enterKeySubmit : function(clickTrigger) {
      $("#" + formId).on('keypress', function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);       
        
        if (keycode === 13) {
          e.preventDefault(); 
          clickTrigger.trigger('click');    
        }
      });
    },
    
    nextStep : function(maxSteps, i, $nextStepBtn) {
      var currentStep = 0;
      
      // Step advance upon validating form fields
            
      function advanceStep() {
        formSteps[i][currentStep].fadeOut(500).addClass('hidden').queue(function() { 
        
          if (currentStep !== maxSteps[i]) {
            formSteps[i][currentStep + 1].hide().removeClass('hidden').fadeIn(500);
          }    
      
          currentStep++;
                
        }).dequeue();
      }
      
      // Step functionality between form fields
                  
      $nextStepBtn.on('click', function(e) {
        e.preventDefault();  
        
        var $this = $(this);
                                
        app.emailSignup.setFormVars($this.closest('.email-container-div')); 
                                
        if (formSteps[i][currentStep].find('.form-row').hasClass('required')) {
          var requiredField = formSteps[i][currentStep].find('.form-row').find('.required:visible'); 
                                        
          // Check type of required fields to validate
          
          if (requiredField.hasClass('input-text')) {
            app.emailSignup.validateFields(" .input-text.required", "input");             
          } else if (requiredField.hasClass('input-checkbox')) {
            app.emailSignup.validateFields(" .input-checkbox.required", "checkbox"); 
          } else if (requiredField.hasClass('input-date')) {
            app.emailSignup.validateFields(" .input-date.required", "input");   
          
            // Add DOB validation against age if age required
            
            if (ageRequired !== '') {
              app.emailSignup.validateDOB($('#' + formId).find('.birthday-date .input-date').val());
            }
          }
          
          if (requiredField.hasClass('valid')) {
            advanceStep();
          }
          
        } else {
          advanceStep();                        
        }
        
        if (currentStep === (maxSteps[i] - 1)) {          
          $nextStepBtn.remove();
          $formSubmit.removeClass('hidden');
          app.emailSignup.submitForm();    
        }       
        
        app.emailSignup.checkForLabelErrors();
      });
    },  
    
    submitForm : function() {            
      $formSubmit.on('click', 'button', function(e) {       
        e.preventDefault();
        
        var $this = $(this);
                
        app.emailSignup.setFormVars($this.closest('.email-container-div'));
        app.emailSignup.postEmailSignUpData(formId, containerId);
        app.emailSignup.validateFields(" .input-text.required", "input");
        app.emailSignup.validateFields(" .input-checkbox.required", "checkbox");
        app.emailSignup.validateFields(" .input-date.required", "input");   
        app.emailSignup.checkForLabelErrors();
        
        if (ageRequired !== '') {
          app.emailSignup.validateDOB($('#' + formId).find('.birthday-date .input-date').val());
        }
      });   
      
      this.enterKeySubmit($formSubmit.find('button'));
    },
    
    validateFields : function(requiredField, fieldType) {     
      var errorSpan,
          errorMessage,
          i;
                
      for (i = 0; i < $("#" + formId + requiredField).length; i++) {
        errorSpan = '<span for="' + $("#" + formId + requiredField).eq(i).prop('name') + '" class="error">',    
        errorMessage = $("#" + formId + requiredField).eq(i).hasClass('email') ? app.resources.INVALID_EMAIL : app.resources.INVALID_FIELD;  
       
        $("#" + formId + requiredField).eq(i).parent().find('span.error').remove();
                
        switch(fieldType) {
          case "input":
            if ($("#" + formId + requiredField).eq(i).val() === '') {
              $("#" + formId + requiredField).eq(i).parent().append(errorSpan + errorMessage + '</span>');
            } else {
              $("#" + formId).validate().element($("#" + formId + requiredField).eq(i));
            }  
            break;
          case "checkbox":
            if (!$("#" + formId + requiredField).eq(i).is(":checked")) {
              $("#" + formId + requiredField).eq(i).parent().append(errorSpan + app.resources.INVALID_FIELD + '</span>');
            } else {
              $("#" + formId + requiredField).eq(i).addClass('valid');
            }
            break;
          default: 
            if ($("#" + formId + requiredField).eq(i).val() === '') {
              $("#" + formId + requiredField).eq(i).parent().append(errorSpan + errorMessage + '</span>');  
            } else {
              $("#" + formId).validate().element($("#" + formId + requiredField).eq(i));
            }
        }   
      } 
    },
    
    loadBirthdayDateField : function() {
      var $dobInput = $('#' + formId).find('.birthday-date .input-date');
   
      $dobInput.on('change', function(e) {
        e.preventDefault();
                
        if (ageRequired !== '') {
          app.emailSignup.validateDOB($(this).val());
        }
      });
      
      if (ageRequired !== '') {
        var requiredField = app.resources.REQUIRED_STARICON;
        $dobInput.parent().add($dobInput).addClass('required');
        $dobInput.parent().find('.optional').html(requiredField);    
      }
    },
    
    validateDOB : function(dob) {
      var $dobInput = $('#' + formId).find('.birthday-date .input-date'),
          today = new Date(),
          currentMonth = today.getMonth() + 1,
          currentDay = today.getDate(),
          currentYear = today.getFullYear(),
          currentDate = currentMonth + '/' + currentDay + '/' + currentYear,
          compareToday = new Date(currentDate),
          compareDOB = new Date(dob.replace(/-/g, '/')),
          age = compareToday.getFullYear() - compareDOB.getFullYear(),
          ageDay = compareToday.getDate() - compareDOB.getDate(),
          ageMonth = (compareToday.getMonth() + 1) - (compareDOB.getMonth() + 1);
            
      $dobInput.parent().find('span.error').remove();

      if (ageMonth < 0 || (ageMonth === 0 && ageDay < 0)) {
        age = parseInt(age) - 1;
      }
                        
      if ((age < ageRequired) || isNaN(age)) {
        var error = '<span for="' + $("#" + formId + ' .input-date.required').prop('name') + '" class="error">' + app.resources.INVALID_AGE + '</span>';
        $dobInput.removeClass('valid').addClass('error');
        $dobInput.parent().append(error);
      } else {
        $dobInput.parent().find('span.error').remove();
        $dobInput.removeClass('error').addClass('valid');   
        $dobInput.prop('value', $dobInput.val());
      }
    },
    
    checkForLabelErrors : function() {
      /* Fix for generated label errors 
         (Was happening on First Time Visitor Popup) */
      
      var lableError = $('label.error'),
          lbError = $('.lberror');
      
      if ($("#" + formId).find(lableError).length) {
        var i,
            errorHTML;
      
        for (i = 0; i < lableError.length; i++) {
          lbError.eq(i).remove();
          
          errorHTML = lableError.eq(i).html();
          
          lableError.eq(i).wrap('<div class="lberror"/>');
          lbError.eq(i).html(errorHTML.replace(/label/g, 'span'));
        }        
      }   
      
      $('input').blur(function() {
        if (lableError.length) {
          lableError.remove();
        }
      });     
    },
    
    postEmailSignUpData : function(formId, containerId) {    
      var post = $("#" + formId).serialize(),
          formnameprofile = $("#" + formId).data('formnameprofile'),
          formnameemail = $("#" + formId).data('formnameemail'),
          errormessage =  $("#" + formId).data('errormessage');  
         
      if ($("#" + formId).validate().form()) {        
        if (!$("[name=" + formnameemail + "]").hasClass('error')) {
          $("#" + formId + " .emailErrorSign").removeClass("errormessage");
        }

        post = post.replace(new RegExp(formnameemail+"_","g"), "");
        post = post.replace(new RegExp(formnameprofile+"_","g"), "");
        
        //save the callout message bcos we don't reload the whole slot
        var callout = $emailSignupSlot.find(".slot-callout-msg");

        $.ajax({
          type: "POST",
          url: app.util.getPipeUrl('EmailOptIn-Save') + '?' + post,
  
          beforeSend: function() {
            /* Use this to have a more overlay style preloader
               $("#"+formId).addClass('relative').append('<div class="loader-indicator">'); */
   
            $("#" + formId + " .all-email-sign-up-button").addClass('loader-button');
            
          },
  
          success: function(data) {   
            if ($emailSignupSlot.length) {
              $emailSignupSlot.unbind();
              $emailSignupSlot.empty().html(data);
              $('.email-container-div').before(callout);
            } else {
              $emailSignupContainer.unbind();
              $emailSignupContainer.replaceWith(data);
              $('.email-container-div').before(callout);
            }
          },
  
          failure: function(data) {
            if ($emailSignupSlot.length) {  
              $emailSignupSlot.empty().html(errormessage);
            } else {
              $emailSignupContainer.empty().html(errormessage);
            }
          },

          error: function(XMLHttpRequest, textStatus, errorThrown) {
            if ($emailSignupSlot.length) {  
              $emailSignupSlot.empty().html(errormessage);
            } else {
              $emailSignupContainer.empty().html(errormessage);
            }
          },

          complete: function() {
            if ($('.email-container-div span.error').length <=0) {           
              if (app.constants.EMAIL_COOKIE) {
                $.cookie('optedInForEmail-' + app.resources.STORENAME_URL, 'true', { expires: 365, path: '/' });
              } 
            
              /* If the top notification bar includes an email signup
              set cookie and remove upon successful opt in */
           
              var $topNotificationBar = $('#top-notification-bar'),
                  slideAnim = $topNotificationBar.data('slide');
            
              if ($topNotificationBar.length && ($topNotificationBar.find('.email-container-div').length || $topNotificationBar.find('.email-signup-popup').length || $topNotificationBar.find('.email-response').length )) {
                if (!$.cookie('notification-cookie-' + app.resources.STORENAME_URL)) {
                  $.cookie('notification-cookie-' + app.resources.STORENAME_URL, 'true', {path: '/'}); 
                  
                  if (!slideAnim) {
                    var $fadeOutContainer = $topNotificationBar.find('.fadeout-container').length ? $topNotificationBar.find('.fadeout-container') : $topNotificationBar;
              
                    $fadeOutContainer.delay(2000).fadeOut(2000).queue(function() {
                      $topNotificationBar.remove();
                    }).dequeue();
                  } else {
                    if (Modernizr.csstransitions) {
                      var slideTimeout;
                      
                      $topNotificationBar.addClass('slide-up');
                      
                      clearTimeout(slideTimeout);
                      slideTimeout = setTimeout(function() {
                        $topNotificationBar.remove();
                      }, 1000);
                    } else {
                      $topNotificationBar.remove();
                    }
                  }
                }
              }
            }
          }
        });
      } else {    
        if ($("[name=" + formnameemail + "]").hasClass('error')) {
          $("#" + formId + " .emailErrorSign").addClass("errormessage");
        }
      }
    }
  };
}(window.app = window.app || {}, jQuery));

$(function() {
  var $emailSignupContainer = $('.email-container-div'),
      $emailSignupSlot = $('.email-signup-slot');
        
  if ($emailSignupContainer.length) {
    if ($.cookie('firstTimeVisitorPopup-' + app.resources.STORENAME_URL)) {
      $('#newsletter-email-popup').remove();
    }  
    
    if ($.cookie('optedInForEmail-' + app.resources.STORENAME_URL)) {
      
      // Remove bottom Email Signup if cookie is set
      
      $('#main-bottom').find($emailSignupContainer).remove();
      
      if ($emailSignupSlot.length) {
        $emailSignupSlot.remove();
      }
      
      // Reinitalize if there are still email optins on the page
      
      if ($emailSignupContainer.length) {
        app.emailSignup.init(); 
      }
    } else {
      app.emailSignup.init(); 
    }   
  }
  
  // Add functionality for dialog popups
  
  if ($('.email-signup-popup').length) {
    $('body').on('click', '.email-signup-popup', function(e) {
      $(document).ajaxComplete(function() {
        $emailSignupContainer = $('.popup .email-container-div');
        
        if ($.cookie('optedInForEmail-' + app.resources.STORENAME_URL)) {   
          $emailSignupContainer.remove();
        } else {
          app.emailSignup.init();
        }
      });
    });     
  }
});

// Add click functionality for CANADA email sign up form - ".main-bottom-slot"

$(function(){ 
    $(".emailsignup-checkbox-input").on("click", function() {
      var $emailForm = $(".emailsignup-toggle"),
          isChecked = $(this).find('input').is(':checked');
      
      if (isChecked) {
        $emailForm.fadeIn('fast');
      } else {
        $emailForm.fadeOut('fast');
      }
        
    });
});

// Top Notification Bar and Cookie

$(function() {
  var $topNotificationBar = $("#top-notification-bar"),
      slideAnim = $topNotificationBar.data('slide');
  
  if (!$.cookie('notification-cookie-' + app.resources.STORENAME_URL) && $topNotificationBar.length) {
    
    $topNotificationBar.removeClass("notification-hide");
    $('body').addClass('notification-bar-active');
    
    
    if (slideAnim) {
      var slideTimeout;
      
      clearTimeout(slideTimeout);
      slideTimeout = setTimeout(function() {
        $topNotificationBar.addClass('slide-down');
      }, 100);
    }

    $topNotificationBar.on("click", '.close', function() {
      if (slideAnim) {
        if (Modernizr.csstransitions) {
          var slideTimeout;
          
          $topNotificationBar.addClass('slide-up');
          
          clearTimeout(slideTimeout);
          slideTimeout = setTimeout(function() {
            $topNotificationBar.remove();
          }, 1000);
        } else {
          $topNotificationBar.remove();
        }
        
        $.cookie('notification-cookie-' + app.resources.STORENAME_URL, 'true', {path: '/'});
      } else {
        $(".alert").alert('close');
      }
      $('body').removeClass('notification-bar-active');
    });

    if (!slideAnim) {
      $('.alert').bind('closed.bs.alert', function() {
        $.cookie('notification-cookie-' + app.resources.STORENAME_URL, 'true', {path: '/'});
      });
    }
  } else {
    $topNotificationBar.remove();
  }
});

// Click Events for the site

$(function() {
   // Do you have a coupon code on Cart page
  
  var $coupon = $('#coupon-code-cart'),
      $cartCoupon = $('.cart-coupon-code'),
      $couponError = $cartCoupon.find('.error').length,
      couponCartActive = false;
  
  function hideEstDelivery() {
    if (jQuery('.pt_cart #estimatedArival').length) {
      if ($('.showDeliveryEstimates').hasClass('active')) {
        couponCartActive = false;
        $('#estimatedArival').hide();
        $('.showDeliveryEstimates').removeClass('active');        
      }
    }
  }
      
  if ($cartCoupon.find('.error').text().replace(/(^[\s]+|[\s]+$)/g, '') === app.resources.COUPON_CODE_MISSING) {
    couponCartActive = false;
    hideEstDelivery();
  } else if ($couponError) {
    couponCartActive = true;
    hideEstDelivery();
    $coupon.addClass('active');
    $cartCoupon.fadeIn('slow');
  }
  
  $coupon.on('click', function() {
    hideEstDelivery();
     
    if (!couponCartActive) {
      couponCartActive = true;
      $(this).addClass('active');
      $cartCoupon.fadeIn('slow');
    } else {
      couponCartActive = false;
      $(this).removeClass('active');
      $cartCoupon.fadeOut('fast');
    }
    
    return false;
  });
});

// Event for country selector

jQuery(function() {
  jQuery("#footer select.country-selector").change(function() {
    var url = "";
      
    jQuery("#footer select.country-selector option:selected").each(function () {
      url = jQuery(this).val();
    });
      
    if (url !== "") {
      jQuery(location).attr("href", url + "?source=change_country");
    }
  }).trigger('change');
});

// listener for responsive tables

jQuery(function() { 
  $("table.responsive").on('click', '.scrolltip', function (e) {
    e.preventDefault();
    $tbody = $(this).parents().children('tbody');
    $tbody.scrollLeft($tbody.scrollLeft() + 103);
  });
});

// Back to Top

(function (app, $) {
  "use strict";
  
  function initializeEvents() {
    
    var $back_to_top = $('.back-to-top'),
    
    offset = $back_to_top.data("offset") !== undefined ? $back_to_top.data("offset") : 300,
    //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
    offset_opacity = 1200,
    //duration of the top scrolling animation (in ms)
    scroll_top_duration = 700;
    
    //hide or show the "back to top" link
    $(window).scroll(function(){
      ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('is-visible') : $back_to_top.removeClass('is-visible fade-out');
      if( $(this).scrollTop() > offset_opacity ) { 
        $back_to_top.addClass('fade-out');
      }
      if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
        $back_to_top.addClass('at-footer');
      }
    });

    //smooth scroll to top
    $back_to_top.on('click', function(event){
      event.preventDefault();
      $('body,html').animate({
        scrollTop: 0
        }, scroll_top_duration
      );
    });
    
  }
  
  app.backtotop = {
    init : function () {
      initializeEvents();
    }
  };
    
  app.backtotop.init();
  
}(window.app = window.app || {}, jQuery));

// onpage seo widget

(function (app, $) {
  "use strict";
   
  function initializeEvents() {
      
    // hide seo container on load
    $('.onpage-seo-content').hide();
      
    // seo event handlers
    $('.onpage-seo').on('click', '.onpage-seo-btn', function (e) {
      $(this).toggleClass('active');
      $(this).children('span').text('-');
      
      if ($(this).hasClass('active')) {
        $(this).siblings('.onpage-seo-content').slideToggle();
      } else {
        $(this).children('span').text('+');
        $(this).siblings('.onpage-seo-content').slideToggle();
      }
      e.preventDefault();
    });
      
    $('.onpage-seo').on('click', '.close-btn', function (e) {
      $('.onpage-seo-btn').toggleClass('active');
      $('.onpage-seo').find('.onpage-seo-btn').children('span').text('+');
      $(this).parent('.onpage-seo-content').slideToggle();
      e.preventDefault();
    });
  }
    
  app.seowidget = {
    init : function () {
      initializeEvents();
    }
  };
    
  if ($('.onpage-seo-content').length) {
    app.seowidget.init();
  }  
}(window.app = window.app || {}, jQuery));

// app.loadcontentajax

(function (app, $) {
  "use strict";
  
  function loadcontentajax() {
    var fireajax = true,
        pagetoload = 1,
        el = $('.grid-ajax-load');
          
    el.append('<div class="loader-indicator2" id="loading-ajax">Loading...</div>');
    
    $(document).scroll(function(e) {
      if (fireajax && isScrolledIntoView('#loading-ajax')) {
        // run a function called doSomething
        
        loadnextpage(pagetoload, el);
        pagetoload = pagetoload +1;
      }
      
      if (fireajax && pagetoload >= el.data('rows')) {
        fireajax = false;
        $('#loading-ajax').remove();
      }         
    });
    
    function loadnextpage(page, el) {  
      var url = app.util.getPipeUrl('Page-Include').toString()+'?cid=' + el.data('id')  +'-page-'+page;
      
      $.ajax({
        url: url,
        beforeSend: function ( xhr ) {
          fireajax = false;
        },
        success: function(data) {
          $('#loading-ajax').before(data);
          $('.grid-ajax').fadeIn(1800); 
          fireajax = true;
          app.loadreview.init();
        },
        complete:  function(data) {
          el.append(data);
          $('.grid-ajax').fadeIn(1800); 
          fireajax = true; 
        }
      });
    }
    
    function isScrolledIntoView(elem) {
      var docViewTop = $(window).scrollTop(),
          docViewBottom = docViewTop + $(window).height(),
          elemTop = $(elem).offset().top,
          elemBottom = elemTop + $(elem).height();
        
      return ((elemTop <= docViewBottom) && (elemTop >= docViewTop));
    }
  }
    
  app.loadcontentajax = {
    init : function () {
      if ($('.grid-ajax-load').length){
        loadcontentajax();
      }
    }
  };
}(window.app = window.app || {}, jQuery));

// Bling

(function (app, $) {
  "use strict";

  var $cache = {
    ischecked:false,
    storedblingoption : 'none',
    storedblingobj : ''
  };

  function initializeBlingEvents() {
    $cache.blingcontainer = $('.bling-container');
    $cache.blingcontainer.picker = $cache.blingcontainer.find('.bling-picker');
    $cache.blingcontainer.checkbox = $cache.blingcontainer.find('.bling-check');
    $cache.blingcontainer.dropdown = $cache.blingcontainer.find('.product-option');
  
    // loads contentslot if needed
  
    loadslot();
  
    if ($cache.ischecked) {
      // checks if on load of ajax if it was checked previous and needs to be loaded
      $cache.blingcontainer.checkbox.prop('checked', true);
      $cache.blingcontainer.picker.fadeIn('fast');
    
      if ($cache.storedblingoption !== undefined && $cache.storedblingoption != 'none') {
        $cache.blingcontainer.dropdown.find('option[value="'+$cache.storedblingoption+'"]').prop("selected", true);
      } 
    }
    
    $cache.blingcontainer.checkbox.on("change", function (e) {
      if ($(this).is(':checked')) {
        $cache.ischecked = true;
        $cache.blingcontainer.picker.fadeIn('fast');
        $cache.blingcontainer.dropdown.find('option[value="'+$cache.storedblingoption+'"]').prop("selected", true);
      } else {
        $cache.ischecked = false; 
        $cache.blingcontainer.picker.fadeOut('fast');
        $cache.blingcontainer.dropdown.find('option[value="none"]').prop("selected", true);
      }
    });
  
    $cache.blingcontainer.dropdown.on("change", function (e) {
      var blingselectedval = $cache.blingcontainer.dropdown.val(); 
  
      $cache.storedblingoption = blingselectedval;
  
      loadblingexample(blingselectedval);    
    });    
  };
  
  function loadslot() {
    if ($cache.storedblingobj !== '') {
      $cache.blingcontainer.picker.append($cache.storedblingobj); 
    }
  };
  
  function loadblingexample(id) {
    $('.new-slot-id').remove();
    app.progress.show('.bling-container');
    
    if (id != 'none') {
      var params = {cid : id},
          url = app.util.appendParamsToUrl(app.util.getPipeUrl('Page-Include'), params);
      
      app.ajax.load({
        url: url,
        callback : function (data) {
          $cache.storedblingobj = "<div class='new-slot-id'>"+data+"</div>";
          loadslot();
        }
      });
      
    } else {
      app.progress.hide();
    }
  };

  app.loadblingfunc = {
    init : function () {
      initializeBlingEvents();  
    }
  };
  
  if ($('.bling-container').length) {
    app.loadblingfunc.init();
  }
} (window.app = window.app || {}, jQuery));


// Mobile Existing Account
if ($('.existing-account-btn').length) {
  var $exAcctBtn = $('button.existing-account-btn');
  
  $exAcctBtn.on('click', function() {
    $(this).parent().find('form').toggle();
  });
}

/**
 * @class app.refinementpanel
 */
(function (app, $) {
  "use strict";
  function initializeEvents() {
    // Refinements - Grid Page
    
    var $cache = {
      searchResults: $('.search-result-content'),
      offset: 50,
      panel: $('.js-panel').height()
    };
      
    // set a min height on the search results container
    if (!Modernizr.touch) {  
      $cache.searchResults.css('min-height', $cache.panel + $cache.offset);
    }
    // open the lateral panel
    $('.js-panel-btn').on('mousedown', function(event){
      event.preventDefault();
      $('.js-off-canvas').addClass('is-visible');
    });
    //close the lateral panel
    $('.js-off-canvas').on('mousedown', function(event){
      if( $(event.target).is('.js-off-canvas') || $(event.target).is('.js-panel-close-btn') ) { 
        $('.js-off-canvas').removeClass('is-visible');
        event.preventDefault();
      }
    });
  }

  app.refinementpanel = {
      init : function () {
        initializeEvents();
      }
  };

}(window.app = window.app || {}, jQuery));

////////////////////
// dwPopup plugin
////////////////////

(function ($, window, document, undefined) {
  
  var pluginName = "dwPopup";
  var dwPopup;
  
  // The actual plugin constructor
  function Plugin(element, options) {
    this.element = element;
    this.init();
  }
  
  // Avoid Plugin.prototype conflicts
  $.extend(Plugin.prototype, {
    init: function() {
      dwPopup = this;
      
      // Set up event handlers
      $(dwPopup.element).on('click', function(e) {
        e.preventDefault();
        
        var $this = $(this);
        options = $this.data();
        
        if ($this.attr("href") && options.url === undefined) {
          options.url = $this.attr("href");
        }
        
        if ($this.attr("title") && options.title === undefined) {
          options.title = $this.attr("title");
        }
        
        if ($this.data("class")) {
          options.classname = $this.data("class");
        }
        
        $.dwPopup.open(options.url, options);
      });
      
      // Click the background or close button
      $('body').on('click', '.popup-wrapper, .js-close', function(e) {
        
        // Only allow clicks directly on the background and not on it's children
        if (e.target === this) {
          e.preventDefault();
          
          $.dwPopup.close();
        }
      });
      
      // On escape key press
      $(document).keyup(function(e) {
        if (e.keyCode == 27) {
          $.dwPopup.close();
        }
      });
    }
  });
  
  $.dwPopup = {
    defaults: {
      animateInClass: 'fade-in',
      animateOutClass: 'fade-out',
      classname: 'normal'
    },
    
    supportsAnimations: $('html').is('.cssanimations'),
    
    init: function() {
      if (typeof $.dwPopup.options.onOpen === "function") {
        $.dwPopup.options.onOpen();
      }
      
      $.dwPopup.resize();
      
      $('.popup-wrapper').show();
      
      if ($.dwPopup.supportsAnimations && $.dwPopup.options.animateInClass !== "none") {
        $('.popup-wrapper').addClass($.dwPopup.options.animateInClass);
      }
    },
    
    open: function(url, options) {
      $.dwPopup.create("", options);
      
      $.dwPopup.ajaxLoad(url);
    },
    
    create: function(html, options) {
      $('.popup-wrapper').remove();
      
      $.dwPopup.options = $.dwPopup.defaults;
      for (var key in options) {
        $.dwPopup.options[key] = options[key];
      }
      
      if (!$('.popup-overlay').length) {
        $('body').append('<div class="popup-overlay"></div>');
      }
      
      $('body').append('<div class="popup-wrapper">\
        <div role="dialog" aria-describedby="popup-content" class="popup animated">\
          <div class="popup-header">\
            <a class="js-close popup-close" href=""></a>\
          </div>\
          <div class="popup-content" id="popup-content">' + html + '</div>\
        </div>\
      </div>');
      
      if (options.width !== undefined) {
        $('.popup').css('width', options.width);
      }
      
      // Add title to popup if there is one
      if (options.title !== undefined) {
        $('.popup-header').prepend('<div class="popup-header-text"><h4>' + options.title + '</h4></div>');
      }
      
      $('.popup-overlay').fadeIn("fast");
      $('.popup-wrapper').addClass(options.classname);
      
      if (!html) {
        $(".popup-wrapper").hide();
      }
      
      if ($.dwPopup.supportsAnimations && $.dwPopup.options.animateInClass !== "none" && html) {
        $('.popup-wrapper').addClass($.dwPopup.options.animateInClass);
      }
      
      if (typeof $.dwPopup.options.onOpen === "function" && html) {
        $.dwPopup.options.onOpen();
      }
      
      $.dwPopup.resize();
    },
    
    close: function() {
      if ($.dwPopup.supportsAnimations && $.dwPopup.options.animateOutClass !== "none") {
        $('.popup').removeClass($.dwPopup.options.animateInClass).addClass($.dwPopup.options.animateOutClass).one('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function() {
          $('.popup-wrapper').remove();
        });
      } else {
        $('.popup-wrapper').remove();
      }
      
      if ($.dwPopup.options && typeof $.dwPopup.options.onClose === "function") {
        $.dwPopup.options.onClose();
      }
      
      $('.popup-overlay').fadeOut("fast", function() {
        $(this).remove();
      });
    },
    
    ajaxLoad: function(url) {
      $.get(url, {'format': 'ajax'}, function(data) {
        $('.popup .popup-content').html(data);
        $.dwPopup.init();
        
        if (typeof $.dwPopup.options.onOpen === "function") {
          $.dwPopup.options.onOpen();
        }
        
        app.validator.init(); // Re-init validator
      });
    },
    
    resize: function() {
      var height = $(window).height(),
          width = $(window).width(),
          minPaddingBottom = 56.259,
          windowTop = $(document).scrollTop();
          
      if (windowTop < 50) {
        windowTop = 50;
      }
      
      $(".popup-wrapper").css("top", windowTop);
      
      // Brightcove video specific code below
      var divisor = 1000 / height;
      $('.popup .video-container').css({paddingBottom: (width > height ? (Math.min(minPaddingBottom, 47 / divisor) + "%") : (minPaddingBottom + "%"))});
      // End brightcove code
      
    }
  };
  
  // A really lightweight plugin wrapper around the constructor,
  // preventing against multiple instantiations
  $.fn[pluginName] = function(options) {
    $.data(this, "plugin_" + pluginName, new Plugin(this, options));
  };
  
  // chain jQuery functions
  return this;
  
})(jQuery, window, document);


$(".popup").each(function() {
  var $popup = $(this);
  
  $("." + $popup.attr("id")).bind("click", function(e) {
    e.preventDefault();
    
    var $this = $(this);
    
    $.dwPopup.create('<div class="video-container">' + $popup.html() + '</div>', {
      classname : 'video',
      width     : '98%',
      title     : $popup.attr('title'),
      onOpen    : function() {
        if ($this.data('autostart') === true) {
          var iframeUrl = $('.popup iframe').prop('src');
          iframeUrl.replace('?autoplay=1', '');
          
          $('.popup iframe').prop('src', iframeUrl + '?autoplay=1');
        }
      }
    });
  });
});

/*  
  Add quickview to any element tagged with a 'make-quickview' class
  Element must have a child anchor tag pointing to the product url,
  i.e. <a href="$url('Product-Show','pid','SMF1141')$" />
*/

jQuery(function () {
  $('.make-quickview').each(function() {
    app.quickView.initializeButton($(this), '');
  });
});

$(function() {
  $('.js-popup, .dialogify').dwPopup();
});

// Custom tooltip plugin

(function ($, window, document, undefined) {
  var pluginName = "dwTooltip",
      defaults = {
        xOffset : 20,
        yOffset : 20,
        evtType : 'click',
        ttWidth : 150
      };

  var Tooltip;

  // The actual plugin constructor
  
  function Plugin (element, options) {
    this.element = element;
    this.settings = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.init();
  }

  // Avoid Plugin.prototype conflicts
  
  $.extend(Plugin.prototype, {
    init: function() {
      Tooltip = this;

      var $this = $(this.element),
          ttData = $this.data(),
          currTarget;

      if (ttData.evt === 'hover') {
        ttData.evt = 'mouseenter';
      }

      // Set up event handlers
      
      $this.on(ttData.evt || defaults.evtType, function(e) {
        e.preventDefault();
        
        currTarget = $this.data('counter');

        if ($('#tt-' + currTarget).length) {
          Tooltip.hideTooltip($this, currTarget);
        } else {
          Tooltip.showTooltip($this, ttData, currTarget);
          
          // If mouseenter delay mouseleave and hidden states
          
          if (ttData.evt === 'mouseenter') {   
            clearTimeout(ttTimeout);
            var ttTimeout;
            
            $this.on('mouseout', function() {
              ttTimeout = setTimeout(function() {
                if (!$('.tooltip-wrapper').hasClass('tt-hovered')) {
                  Tooltip.hideTooltip($this, currTarget);
                }
              }, 300);
            });
            
            $('.tooltip-wrapper').on('mouseenter', function() {
              clearTimeout(ttTimeout);
              $(this).addClass('tt-hovered');
            });
            
            $('.tooltip-wrapper').on('mouseleave', function() {
              $(this).removeClass('tt-hovered');
              Tooltip.hideTooltip($this, currTarget);
            });
          }
        }
      });
      
      // Add data counter to easily reference which tooltip
      
      var i;
      for (i = 0; i < $('.js-tooltip').length; i++) {
        $('.js-tooltip').eq(i).attr('data-counter', i);
      }
      
      // Reposition staged tooltips on window resizing

      $(window).on('resize', function() {
        Tooltip.setStagePositions();
      }).resize();
    },

    showTooltip: function($this, ttData, currTarget) {
      var ttWrap;
            
      $this.addClass('tt-shown');
      
      // Build tooltip html
      
      function setHtml(html) {
        return '<span id="tt-' + currTarget + '" class="tooltip-wrapper">' + html + '</span>';
      }

      if (ttData.info) {
        ttWrap = setHtml(ttData.info);
      } else if (ttData.pid) {      
        var url = app.util.appendParamsToUrl(app.util.getPipeUrl('ReviewTip-Get'), { pid : $this.data('pid') });
        
        pidAjax(url, function(data) {
          ttWrap = setHtml(data);
        });
      }    
      
      // Get product data
      
      function pidAjax(url, callback) {
        $.ajax({
          url: url,
          async: false
        }).done(callback);     
      }

      if ($this.parent().hasClass('tooltip-stage')) {
        $this.parent().append(ttWrap);
      } else {
        $('body').append(ttWrap);
      }
      
      // Set tooltip widths
      
      $('#tt-' + currTarget).css({ width: ttData.w || defaults.ttWidth });      
      
      // Reposition tooltips on window resizing
      
      $(window).on('resize', function() {
        Tooltip.setPositions($this, ttData, currTarget);
      }).resize();
    },

    hideTooltip: function($this, currTarget) {
      var $ttWrapper = $('#tt-' + currTarget);
      $this.removeClass('tt-shown');
      $ttWrapper.remove();
    },

    setPositions: function($this, ttData, currTarget) {
      var $container = $this.parent().hasClass('tooltip-stage') ? $('.tooltip-stage') : $(window),
          $currTT = $('.js-tooltip[data-counter="' + currTarget + '"]'),
          $ttWrapper = $('#tt-' + currTarget),
          ttWidth = $ttWrapper.outerWidth(),
          ttHeight = $ttWrapper.outerHeight(),
          ttPos = $this.parent().hasClass('tooltip-stage') ? $this.position() : $this.offset(),
          mouseX = ttPos.left + (ttData.xoffset || defaults.xOffset),
          mouseY = ttPos.top + (ttData.yoffset || defaults.yOffset);
      
      // Reposition tooltips       
     
      if ($container.width() < mouseX + ttWidth) {
        if (mouseX - ttWidth > 0 || (($(window).width() > $container.width()) && ($container.width() < ttWidth + mouseX))) {
          $ttWrapper.css({ left: mouseX - (ttWidth + (ttData.xoffset || defaults.xOffset) + $currTT.width()) });  
        } else {
          $ttWrapper.css({ left: ttWidth - mouseX });
        }
      } else {
        $ttWrapper.css({ left: mouseX });
      }

      if ($container.height() < ttHeight + mouseY || $(window).height() < ttHeight + $this.offset().top) {       
        $ttWrapper.css({ top: mouseY - (ttHeight + (ttData.yoffset || defaults.yOffset) + $currTT.height()) });
      } else {
        $ttWrapper.css({ top: mouseY });
      }
    },
    
    setStagePositions: function() {
      var $ttStage = $('.tooltip-stage'),
          j, k;
      
      for (j = 0; j < $ttStage.length; j++) {
        var $currStage = $ttStage.eq(j);
        for (k = 0; k < $currStage.find('.js-tooltip').length; k++) {
          var $currTT = $currStage.find('.js-tooltip').eq(k),
              posX = $currTT.data('x'),
              posY = $currTT.data('y');

          $ttStage.eq(j).find('.js-tooltip').eq(k).css({ top: posY + '%', left: posX + '%'}); 
        }
      }
    }
  });

  // A really lightweight plugin wrapper around the constructor,
  // preventing against multiple instantiations
  
  $.fn[ pluginName ] = function ( options ) {
    this.each(function() {
      if ( !$.data( this, "plugin_" + pluginName ) ) {
        $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
      }
    });

    // chain jQuery functions
    return this;
  };

})(jQuery, window, document);

$(function() {
  $('.js-tooltip').dwTooltip();
});
