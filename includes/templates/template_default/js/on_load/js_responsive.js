(function($, sr) {
  
  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function(func, threshold, execAsap) {
    var timeout;
    
    return function debounced() {
      var obj = this, args = arguments;
      
      function delayed () {
        if (!execAsap) {
          func.apply(obj, args);
        }
        
        timeout = null; 
      }
      
      if (timeout) {
        clearTimeout(timeout);
      } else if (execAsap) {
        func.apply(obj, args);
      }
      
      timeout = setTimeout(delayed, threshold || 250); 
    };
  };
  
  // smartresize 
  $.fn[sr] = function(fn) {
    return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
  };
}($, 'smartresize'));


/*
 * All javascript logic for the mobile layout.
 *
 * The code relies on the $ JS library to
 * be also loaded.
 *
 * The logic extends the JS namespace app.*
 */

(function(app, $, undefined) {
  app.responsive = {
    
    // set mobile width -30px (-15px left and -15px right padding on #wrapper)
          
    mobileLayoutWidth: 981,
    
    init: function() {
      $cache = {
        body: $('body'),
        wrapper: $('#wrapper'),
        header: $('#header'),
        header_mobile: $('.header-mobile'),
        header_utility: $('.header-utility'),
        header_search: $('.header-search'),
        navigation: $('#navigation'),
        mobile_menu: $('.mobile-menu'),
        mobile_btn: $('.mobile-menu-btn'),
        mobile_search_btn: $('.mobile-search-btn'),
        mobile_search: $('.mobile-search'),
        mobile_overlay: $('.mobile-overlay'),
        main: $('#main'),
        footer: $('#footer'),
        pdp: $('#pdpMain'),
        nav_open: false,
        search_open: false,
        enable_mobile_ui: false,
        refinements: $('.refinements'),
        category_nav_open: false,
        category_nav_btn: $('.category-panel-btn')
      };
      
      // simple as this!
      // NOTE: init() is implicitly called with the plugin
      $("#header").headroom(
        {
        "offset": $cache.header.outerHeight( true )
        }
      );
      
      // Set wrapper padding
      //$cache.wrapper.css( "padding-top", $cache.header.outerHeight( true ));
      
      // Build mobile navigation
      
      $cache.mobile_btn.on('mousedown', function(e) {
        e.preventDefault();
        if (!$cache.nav_open) {
          $cache.body.addClass('push');
          $(this).addClass('is-active');
          
          // Fallback for older browsers
          
          if (!Modernizr.csstransitions) {
            $cache.wrapper.css({position: 'relative'}).animate({ left: '88%'}, 500);
            //$cache.mobile_menu.animate({ left: '0'}, 500);
          }
          
          $cache.nav_open = true;
          
          // close search bar if open
          
          if ($cache.mobile_search.hasClass('is-active')) {
            $cache.mobile_search.removeClass('is-active');
            $cache.mobile_search.find('.form-control').blur();
            $cache.search_open = false;
          }
          
          return false;
          
        } else if ($cache.nav_open) {
          $cache.body.removeClass('push');
          $(this).removeClass('is-active');
          
          if (!Modernizr.csstransitions) {
            
            // Fallback for older browsers
              
            $cache.wrapper.css({position: 'relative'}).animate({ left: '0'}, 500);
            //$cache.mobile_menu.animate({ left: '-88%'}, 500);
          }
          
          $cache.nav_open = false;
          return false;
        }
      });
      
      // close navigation if overlay is clicked
      
      $cache.mobile_overlay.on('mousedown', function() {
        $cache.mobile_btn.trigger('mousedown');
      });
      
      // open navigation and focus search
      
      $cache.mobile_search_btn.on('mousedown', function(e) {
        e.preventDefault();
        if (!$cache.search_open) {
          $cache.mobile_search_btn.addClass('is-active');
          $cache.mobile_search.addClass('is-active');
          $cache.mobile_search.find('.form-control').focus();
          $cache.search_open = true;
        } else if ($cache.search_open) {
          $cache.mobile_search_btn.removeClass('is-active');
          $cache.mobile_search.removeClass('is-active');
          $cache.mobile_search.find('.form-control').blur();
          $cache.search_open = false;
        }
      });
      
      $cache.mobile_search.on('focusout', 'input', function(){
        if ($cache.mobile_search.hasClass('is-active')) {
          $cache.mobile_search_btn.trigger('mousedown');
        }
      });
      
      /* we need this only on touch devices */
      
      if (Modernizr.touch) {   
        /* bind events */
        $(document).on('focus', 'input', function(e) {
          $cache.body.addClass('fixfixed');
        }).on('blur', 'input', function(e) {
          $cache.body.removeClass('fixfixed');
        });
      };
      
      // Append Counterfeit link to mobile menu
      
      $cache.header_utility.find('.link-counterfeit').clone().appendTo($cache.mobile_menu.find('.menu-category'));
      
      // Build toggle
      
      $cache.main.find(".js-toggle").on("click", function() {
        $(this).toggleClass("active").next(".toggle-content").toggleClass("hidden");
      });
      
      // check onload to see if mobile enabled
      
      if ($cache.mobile_btn.is(':visible')) {
        app.responsive.enableMobileUi();
      }
    },
    
    // build mobile menu
    
    enableMobileUi: function() {
      if (!$cache.enable_mobile_ui) {
        $cache.body.addClass('mobile-layout');
        $cache.navigation.addClass('hidden');
        $cache.header.removeClass('fixed');
        $cache.header_search.children().detach().appendTo($cache.mobile_search);
        $cache.wrapper.css( "padding-top", $cache.header.outerHeight( true ));
        // build expand/collapse functionality
        $cache.mobile_menu.find('.has-sub-cat').on('click', '.icon-sub-menu', function(e) {
          $(this)
            .parent()
            .toggleClass('selected')
            .siblings()
            .toggleClass('open')
            .stop()
            .slideToggle();
          e.preventDefault();
        });
        
        // build footer blocks
        
        $cache.footer.find('.footer-block').children('ul').addClass('hidden');
        $cache.footer.find('.footer-block').on('click', '.toggle', function() {
          $(this).toggleClass('active');
          $(this).next('ul').stop().slideToggle();
        });
        
        // set navigation
        
        $cache.enable_mobile_ui = true;
      }
    },
    
    // revert to standard horizontal menu
    
    disableMobileUi: function() {
      if ($cache.enable_mobile_ui) {
        $cache.body.removeClass('push');
        $cache.mobile_btn.removeClass('is-active');
        $cache.navigation.removeClass('hidden');
        $cache.mobile_search.removeClass('is-active');
        $cache.mobile_search.children().detach().appendTo($cache.header_search);
        $cache.mobile_menu.find('.level-1, .level-2').removeAttr('style');
        $cache.mobile_menu.find('.level-1').removeClass('selected');
        $cache.mobile_menu.find('.level-2').removeClass('open');
        $cache.wrapper.css( "padding-top", $cache.header.outerHeight( true ));
        
        // remove click event on sub navigation buttons
        
        $cache.mobile_menu.find('.has-sub-cat').off('click','.icon-sub-menu');
        $cache.body.removeClass('mobile-layout');
        
        // disable mobile footer
        
        $cache.footer.find('.footer-block').children('ul').removeClass('hidden');
        $cache.footer.find('.footer-block').off('click', '.toggle');
        $cache.footer.find('.footer-block .toggle').removeClass('active');
        $cache.footer.find('.footer-block').children('ul').removeAttr('style');
        
        // set navigation
        
        $cache.nav_open = false;
        $cache.enable_mobile_ui = false;
      }
    },
    
    toggleGridWideTileView: function() {
      
      // toggle grid/wide tile
        
      if ($('.toggle-grid').length === 0) {
        $('.search-result-options').append('<a class="toggle-grid" href="'+location.href+'">+</a>');
        $('.toggle-grid').click(function() {
          $('.search-result-content').toggleClass('wide-tiles');
          return false;
        });
      }
      
      if ($('.pagination').length === 0) {
        $('.toggle-grid').css('margin', '5px 20px 0 0');
      } 
    }
  };
  
  $(document).ready(function() {
    
    // Placeholder fallback
    function placeHolderInput() {  
      if (!Modernizr.input.placeholder) {
        $('[placeholder]').focus(function() {
          var input = $(this);
      
          if (input.val() === input.prop('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
          }
        }).blur(function() {
          var input = $(this);
          
          if (input.val() === '' || input.val() === input.prop('placeholder')) {
            input.addClass('placeholder');
            input.val(input.prop('placeholder'));
          }
        }).blur();
    
        $('[placeholder]').parents('form').submit(function() {
          $(this).find('[placeholder]').each(function() {
            var input = $(this);
        
            if (input.val() === input.prop('placeholder')) {
              input.val('');
            }
          });
        });
      }
    }
      
    function searchFieldInput() {      
      var placeholderText;
    
      $cache.body.on("focus", "#q", function() {
        var $this = $(this);
      
        placeholderText = $(this).prop("placeholder");
        $this.val("").prop("placeholder", $this.siblings("label").text());
      });
    }
   
    app.responsive.init();
    
    // Initialize placeholder fallback and search input 
    
    placeHolderInput();
    searchFieldInput();
    
    // set up listener so we can update DOM if page grows/shrinks, only on bigger platforms
    
    if (screen.width > app.responsive.mobileLayoutWidth) {
      $(window).smartresize(function() {
        if ($cache.mobile_btn.is(':visible')) {
          app.responsive.enableMobileUi();
        } else {
          app.responsive.disableMobileUi();
        }
      });
    }
    
    // Listen for orientation changes
    // Need to check support for browsers < IE9
    
    if (window.addEventListener) {
      window.addEventListener("orientationchange", checkOrientation, false);
    } else {
      window.attachEvent("orientationchange", checkOrientation);
    }    
    
    function checkOrientation() {
      if ($cache.mobile_btn.is(':visible')) {
        app.responsive.enableMobileUi();
      } else {
        app.responsive.disableMobileUi();
      }
    }
    
    
    // Insert Pixlee Widget for Blog
    if ($('#pixlee-container').length) {
      function isIE() {
        var myNav = navigator.userAgent.toLowerCase();
        return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
      }   
      
      // Remove on older IE browsers due to lack of support
      if (isIE() && isIE() < 9) {
        $('.blog-social-header').add('#pixlee-container').remove();
      } else {      
        var pixleeContainer = document.getElementById('pixlee-container'),
            ps = document.createElement('script');
        
        ps.setAttribute('id', 'pixlee_script');
        ps.setAttribute('src', '//assets.pixlee.com/assets/pixlee_widget_v3.js');
        ps.setAttribute('type', 'text/javascript');
        
        pixleeContainer.appendChild(ps);
        
        document.getElementById('pixlee_script').onload = function() {        
          var pixUrl = 'https://photos.pixlee.com/ggu/3731/v2?embed=true&filter_sort_id=10860',
              pixlee = new PixleeWidget(pixUrl, "pixlee_container", "https://photos.pixlee.com/", document.location.hash);
          
          pixlee.setupWidget(true);  
          
          $('#pixlee-container').show('fast'); 
        }
      }
    }
  });
}(window.app = window.app || {}, jQuery));