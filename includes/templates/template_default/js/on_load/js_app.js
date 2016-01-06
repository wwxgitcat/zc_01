/**
 * 
 * All java script logic for the application.
 *    (c) 2009-2012 Demandware Inc.
 *    Subject to standard usage terms and conditions
 * The code relies on the jQuery JS library to
 * be also loaded. 
 *    For all details and documentation:
 *    https://github.com/Demandware/Site-Genesis 
 */
//semi-colon to assure functionality upon script concatenation and minification
;

//if jQuery has not been loaded, load from google cdn
if (!window.jQuery) {
  var s = document.createElement('script');
  s.setAttribute('src', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
  s.setAttribute('type', 'text/javascript');
  document.getElementsByTagName('head')[0].appendChild(s);
}

/** @namespace */
var app = (function (app, $) {
  //allows the use of $ within this function without conflicting with other JavaScript libraries which are using it (JQuery extension)
  document.cookie="dw=1";
  /******** private functions & vars **********/

  /**
   * @private
   * @function
   * @description Cache dom elements which are being accessed multiple times.<br/>app.ui holds globally available elements.
   */
  function initUiCache() {
    app.ui = {
      searchContainer : $("#simple-search-form"),
      printPage       : $("a.print-page"),
      reviewsContainer: $("#pwrwritediv"),
      main            : $("#main"),
      primary         : $("#primary"),
      secondary       : $("#secondary"),
      
      // elements found in content slots
      slots : {
        subscribeEmail: $(".subscribe-email")
      }
    };
  }

  /**
   * @private
   * @function
   * @description Apply dialogify event handler to all elements that match one or more of the specified selectors.
   */
  function initializeEvents() {
    var controlKeys = ["8", "13", "46", "45", "36", "35", "38", "37", "40", "39"];
    
    $("body").on("click", "[data-dlg-options], [data-dlg-action]", app.util.setDialogify)
    .on("keydown", "textarea[data-character-limit]", function(e) {
      var text = $.trim($(this).val()),
          charsLimit = $(this).data("character-limit"),
          charsUsed = text.length;
      
      if ((charsUsed >= charsLimit) && (controlKeys.indexOf(e.which.toString()) < 0)) {
        e.preventDefault();
      }
	})
	.on("change keyup mouseup", "textarea[data-character-limit]", function(e) {
      var text = $.trim($(this).val()),
          charsLimit = $(this).data("character-limit"),
          charsUsed = text.length,
          charsRemain = charsLimit - charsUsed;
      
      if (charsRemain < 0) {
        $(this).val(text.slice(0, charsRemain));
        charsRemain = 0;
      }
      
      $(this).next('div.char-count').find('.char-remain-count').html(charsRemain);
    });
    
    // initialize search suggestions
    app.searchsuggest.init(app.ui.searchContainer, app.resources.SIMPLE_SEARCH);
    
    // print handler
    app.ui.printPage.on("click", function () { window.print(); return false; });
    
    // add show/hide navigation elements
    $('.secondary-navigation .toggle').click(function() {
      $(this).toggleClass('expanded').next('ul').toggle();
    });
    
    // subscribe email box
    if (app.ui.slots.subscribeEmail.length > 0) {
      app.ui.slots.subscribeEmail.focus(function () {
        var val = $(this.val());
        if(val.length > 0 && val !== app.resources.SUBSCRIBE_EMAIL_DEFAULT) {
          return; // do not animate when contains non-default value
        }

        $(this).animate({ color: '#999999'}, 500, 'linear', function () {
          $(this).val('').css('color','#333333');
        });
      }).blur(function () {
        var val = $.trim($(this.val()));
        if(val.length > 0) {
          return; // do not animate when contains value
        }

        $(this).val(app.resources.SUBSCRIBE_EMAIL_DEFAULT).css('color','#999999').animate({color: '#333333'}, 500, 'linear');
      });
    }
  }
  /**
   * @private
   * @function
   * @description Adds class ('js') to html for css targeting and loads js specific styles.
   */
  function initializeDom() {
    // add class to html for css targeting
    $('html').addClass('js');
    if (app.clientcache.LISTING_INFINITE_SCROLL){
      $('html').addClass('infinite-scroll');
    }
    // load js specific styles
    app.util.limitCharacters();
  }


  /**
   * @property {Object} _app "inherits" app object via $.extend() at the end of this seaf (Self-Executing Anonymous Function)
   */
  var _app = {
      containerId   : "content",
      ProductCache  : null,  // app.Product object ref to the current/main product
      ProductDetail : null,
      clearDivHtml  : '<div class="clear"></div>',
      currencyCodes : app.currencyCodes || {}, // holds currency code/symbol for the site
      iOS : (navigator.userAgent.match(/(iPad|iPhone|iPod)/i) ? true : false),

      /**
       * @name init
       * @function
       * @description Master page initialization routine
       */
      init: function () {

        if (document.cookie.length === 0) {
          $("<div/>").addClass("browser-compatibility-alert").append($("<p/>").addClass("browser-error").html(app.resources.COOKIES_DISABLED)).appendTo("#browser-check");
        }

        // init global cache
        initUiCache();

        // init global dom elements
        initializeDom();

        // init global events
        initializeEvents();

        // init specific global components
        app.minicart.init();
        app.validator.init();
        app.components.init();
        app.searchplaceholder.init();
        app.emailValidator.init();
        
        // Break cache if Pro Customer is logged in
        if (app.isProCustomer) {
          var catMenu = $('.menu-category'),
              prodBread = $('.pt_product-search-result .breadcrumb').find('h1');
          
          catMenu.find('a').each(function() {
            var $thisUrl = $(this).prop('href');
            $(this).prop('href', $thisUrl + '?p=true');
          });     
          
          if (prodBread.length) {
            prodBread.find('a').each(function() {
              var $thisUrl = $(this).prop('href');
              $(this).prop('href', $thisUrl + '?p=true');
            });             
          }       
        }

        // execute page specific initializations
        var ns = app.page.ns;
        if (ns && app[ns] && app[ns].init) {
          app[ns].init();
        }
      }
  };

  return $.extend(app, _app);
}(window.app = window.app || {}, jQuery));

/**
@class app.storefront
 */
(function (app, $) {
  var $cache = {};
  app.storefront = {
      init : function () {
        $cache = {
          main: $('#main'),
          slider: $('#homeCarousel'),
          searchResults: $('.search-result-content')
        };
        
        if ($cache.searchResults.length) {
          app.search.init();
        }

        function homeCarousel() {
          $cache.slider.carousel({
            interval: 6000,
            pause: "hover"
          });
        }
        // init carousel if it exists
        if($cache.main.find($cache.slider).length > 0) {
          homeCarousel();
        }
      }
  };

}(window.app = window.app || {}, jQuery));


/**
 @class app.product
 */
(function (app, $) {
  var $cache;

  /*************** app.product private vars and functions ***************/

  /**
   * @private
   * @function
   * @description Loads product's navigation on the product detail page
   */
  function loadProductNavigation() {
    if (app.quickView.isActive()) {
      return;
    }
    
    var pidInput = $cache.pdpForm.find("input[name='pid']").last();
    var navContainer = $("#product-nav-container");
    
    // if no hash exists, or no pid exists, or nav container does not exist, return
    if (!window.location.hash.length || !pidInput.length || !navContainer.length) {
      return;
    }

    var pid = pidInput.val();
    var hashParams = window.location.hash.substr(1);
    if (hashParams.indexOf("pid=" + pid) < 0) {
      hashParams += "&pid=" + pid;
    }
    
    var url = app.util.getPipeUrl('Product-Productnav') + (app.util.getPipeUrl('Product-Productnav').indexOf("?") < 0 ? "?" : "&") + hashParams;
    app.ajax.load({
      url: url,
      target: navContainer,
      callback: function() {
        try {
          $(".product-nav-target").find("span.prev").html(app.resources.PREVIOUS_ITEM);
          $(".product-nav-target").find("span.next").html(app.resources.NEXT_ITEM);
        } catch(e) {
          //alert(e);
        }
      }      
    });
    
    navContainer.appendTo(".product-nav-target");
  }

  /**
   * @private
   * @function
   * @description Creates product recommendation carousel using jQuery jcarousel plugin
   */
  function loadRecommendations() {
    var recommendations = $(".recommendations");
    var recCarousel = $("#recCarousel");
    var recCarouselItems = recCarousel.find('.carousel-inner').children().length;
    var recSelector = app.constants.RECOMMENDATIONS_SELECTOR;

    // build controls html
    var carouselControls = '<a class="carousel-control left" href="#' + recCarousel.attr('id') + '" data-slide="prev">&lsaquo;</a><a class="carousel-control right" href="#' + recCarousel.attr('id') + '" data-slide="next">&rsaquo;</a>';

    function attachCarousel() {
      recommendations.detach();
      $('.' + recSelector).prepend(recommendations);
    }

    if(!recCarousel || recCarousel.length === 0 || recCarouselItems === 0 || recCarouselItems <= 1) {
      if ($cache.pdpMain.find('.' + recSelector).length > 0) {
        // attach carousel if selector exists
        attachCarousel();
      }
      return;
    }
    // add carousel controls
    recCarousel.append(carouselControls);
    recCarousel.carousel(app.components.carouselSettings);

    // attach carousel if selector exists
    if ($cache.pdpMain.find('.' + recSelector).length > 0) {
      attachCarousel();
    }

  }

  /**
   * @function
   * @description Sets the main image attributes and the href for the surrounding <a> tag
   * @param {Object} atts Simple object with url, alt, title and hires properties
   */
  function setMainImage(atts) {
    var imgZoom = $cache.pdpMain.find("a.main-image");
    if (imgZoom.length>0 && atts.hires && atts.hires!=='' && atts.hires!=='null') {
      imgZoom.attr("href", atts.hires);
    }
    
    // replace(/&#39;/g, "'") Added to replace alt and title tags with single quotes

    imgZoom.find("img.primary-image").attr({
      "src" : atts.url,
      "alt" : atts.alt.replace(/&#39;/g, "'").replace(/&#34;/g, '"'),
      "title" : atts.title.replace(/&#39;/g, "'").replace(/&#34;/g, '"')
    });
  }

  /**
   * @function
   * @description helper function for swapping main image on swatch hover
   * @param {Element} element DOM element with custom data-lgimg attribute
   */
  function swapImage(element) {
    var lgImg = $(element).data("lgimg");

    var newImg = $.extend({}, lgImg);
    var imgZoom = $cache.pdpMain.find("a.main-image");
    var mainImage = imgZoom.find("img.primary-image");
    // store current image info
    lgImg.hires = imgZoom.attr("href");
    lgImg.url = mainImage.attr("src");
    
    // replace(/&#39;/g, "'") Added to replace alt and title tags with single quotes
    
    lgImg.alt = mainImage.attr("alt").replace(/&#39;/g, "'").replace(/&#34;/g, '"');
    lgImg.title = mainImage.attr("title").replace(/&#39;/g, "'").replace(/&#34;/g, '"');
    // reset element's lgimg data attribute
    $(element).data(lgImg);
    // set the main image
    setMainImage(newImg);
  }

  /**
   * @function
   * @description Enables the zoom viewer on the product detail page
   */
  function loadZoom() {
    if (app.quickView.isActive() || !app.isDesktopUserAgent) {
      return;
    }

    // zoom properties
    var options = {
        zoomType: app.constants.PRODUCT_ZOOM_TYPE,
        alwaysOn : 0, // setting to 1 will load load high res images on page load
        zoomWidth : app.constants.PRODUCT_ZOOM_WIDTH,
        zoomHeight : app.constants.PRODUCT_ZOOM_HEIGHT,
        position:'right',
        preloadImages: 0, // setting to 1 will load load high res images on page load
        xOffset: 30,
        yOffset:0,
        showEffect : 'fadein',
        hideEffect: 'fadeout'
    };

    // added to prevent empty hires zoom feature (if images don't exist)
    var mainImage = $cache.pdpMain.find("a.main-image");
    var hiresImageSrc = mainImage.attr("href");
    if (hiresImageSrc && hiresImageSrc !== '' && hiresImageSrc.indexOf('noimagelarge') < 0) {
      mainImage.removeData("jqzoom").jqzoom(options);
    }
  }
  /**
   * @function
   * @description replaces the images in the image container. for example when a different color was clicked. 
   */
  function replaceImages() {
    var newImages = $("#update-images");
    var imageContainer = $cache.pdpMain.find("div.product-image-container");

    imageContainer.html(newImages.html());
    newImages.remove();
    setMainImageLink();
    loadZoom();
  }
  /**
   * @function
   * @description Adds css class (image-zoom) to the main product image in order to activate the zoom viewer on the product detail page.
   */
  function setMainImageLink() {
    if (app.quickView.isActive() || app.isMobileUserAgent) {
      $cache.pdpMain.find("a.main-image").removeAttr("href");
    }
    else {
      $cache.pdpMain.find("a.main-image").addClass("image-zoom");
    }
  }
  /**
   * @function
   * @description Removes css class (image-zoom) from the main product image in order to deactivate the zoom viewer on the product detail page.
   */
  function removeImageZoom() {
    $cache.pdpMain.find("a.main-image").removeClass("image-zoom");
  }

  /**
   * @private
   * @function
   * @description Initializes the DOM of the product detail page (images, reviews, recommendation and product-navigation).
   */
  function initializeDom() {
    
    // Check if jQuery UI exists (for UGG where it isn't needed)
    if (typeof jQuery.ui != 'undefined') {
      $cache.pdpMain.find('div.product-tabs').tabs();
    }
    
    // Disable clicking on main image link for mobile
    $("body").on("click", "a.main-image", function(e) {
      e.preventDefault();
    });
    
    if ($('#pwrwritediv').length > 0) {
      var options = $.extend(true, {}, app.dialog.settings, {
        autoOpen : true,
        height : 750,
        width : 650,
        classname : 'writereview',
        title : 'Product Review',
        resizable : false
      });

      app.dialog.create({
        target : app.ui.reviewsContainer,
        options : options
      });
    }

    loadRecommendations($cache.container);
    loadProductNavigation();
    setMainImageLink();

    if ($cache.productSetList.length>0) {
      var unavailable = $cache.productSetList.find("form").find("button.add-to-cart[disabled]");
      if (unavailable.length > 0) {
        $cache.addAllToCart.attr("disabled", "disabled");
        $cache.addToCart.attr("disabled", "disabled"); // this may be a bundle

      }
    }
  }
  /**
   * @private
   * @function
   * @description Initializes the cache on the product detail page.
   */
  function initializeCache() {
    $cache = {
        productId : $("#pid"),
        pdpMain : $("#pdpMain"),
        productContent : $("#product-content"),
        thumbnails : $("#thumbnails"),
        bonusProductGrid : $(".bonusproductgrid"),
        imageContainer : $(".product-primary-image"),
        productSetList : $("#product-set-list"),
        addToCart : $("#add-to-cart"),
        addAllToCart : $("#add-all-to-cart")
    };
    $cache.detailContent = $cache.pdpMain.find("div.detail-content");
    $cache.pdpForm = $cache.pdpMain.find("form.pdpForm");
    $cache.swatches = $cache.pdpMain.find("ul.swatches");
    $cache.mainImageAnchor = $cache.imageZoom = $cache.imageContainer.find("a.main-image");
    $cache.mainImage = $cache.mainImageAnchor.find("img.primary-image");
  }

  /**
   * @private
   * @function
   * @description Initializes events on the product detail page for the following elements:<br/>
   * <p>availability message</p>
   * <p>add to cart functionality</p>
   * <p>images and swatches</p>
   * <p>variation selection</p>
   * <p>option selection</p>
   * <p>send to friend functionality</p>
   */
  function initializeEvents() {

    //app.product.initAddThis();

    if(app.enabledStorePickup){app.storeinventory.showStoreInventory();}
    
    // add or update shopping cart line item
    app.product.initAddToCart();
    $cache.pdpMain.on("change keyup", "form.pdpForm input[name='Quantity']", function (e) {
      var availabilityContainer = $cache.pdpMain.find("div.availability");
      app.product.getAvailability(
          $("#pid").val(),
          $(this).val(),
          function (data) {
            if (!data) {
              $cache.addToCart.removeAttr("disabled");
              availabilityContainer.find(".availability-qty-available").html();
              availabilityContainer.find(".availability-msg").show();
              return;
            }else{
              var avMsg = null;
              var avRoot = availabilityContainer.find(".availability-msg").html('');

              // Look through levels ... if msg is not empty, then create span el
              if( data.levels.IN_STOCK> 0 ) {
                avMsg = avRoot.find(".in-stock-msg");
                if (avMsg.length===0) {
                  avMsg = $("<p/>").addClass("in-stock-msg").appendTo(avRoot);
                }
                if( data.levels.PREORDER===0 && data.levels.BACKORDER===0 && data.levels.NOT_AVAILABLE===0 ) {
                  // Just in stock
                  avMsg.text(app.resources.IN_STOCK);
                } else {
                  // In stock with conditions ...
                  avMsg.text(data.inStockMsg);
                }
              }
              if( data.levels.PREORDER> 0 ) {
                avMsg = avRoot.find(".preorder-msg");
                if (avMsg.length===0) {
                  avMsg = $("<p/>").addClass("preorder-msg").appendTo(avRoot);
                }
                if( data.levels.IN_STOCK===0 && data.levels.BACKORDER===0 && data.levels.NOT_AVAILABLE===0 ) {
                  // Just in stock
                  avMsg.text(app.resources.PREORDER);
                } else {
                  avMsg.text(data.preOrderMsg);
                }
              }
              if( data.levels.BACKORDER> 0 ) {
                avMsg = avRoot.find(".backorder-msg");
                if (avMsg.length===0) {
                  avMsg = $("<p/>").addClass("backorder-msg").appendTo(avRoot);
                }
                if( data.levels.IN_STOCK===0 && data.levels.PREORDER===0 && data.levels.NOT_AVAILABLE===0 ) {
                  // Just in stock
                  avMsg.text(app.resources.BACKORDER);
                } else {
                  avMsg.text(data.backOrderMsg);
                }
              }
              if( data.inStockDate !== '' ) {
                avMsg = avRoot.find(".in-stock-date-msg");
                if (avMsg.length===0) {
                  avMsg = $("<p/>").addClass("in-stock-date-msg").appendTo(avRoot);
                }
                avMsg.text(String.format(app.resources.IN_STOCK_DATE,data.inStockDate));
              }
              if( data.levels.NOT_AVAILABLE> 0 ) {
                avMsg = avRoot.find(".not-available-msg");
                if (avMsg.length===0) {
                  avMsg = $("<p/>").addClass("not-available-msg").appendTo(avRoot);
                }
                if( data.levels.PREORDER===0 && data.levels.BACKORDER===0 && data.levels.IN_STOCK===0 ) {
                  avMsg.text(app.resources.NOT_AVAILABLE);
                } else {
                  avMsg.text(app.resources.REMAIN_NOT_AVAILABLE);
                }
              }
              return;
            }
            $cache.addToCart.attr("disabled", "disabled");
            availabilityContainer.find(".availability-msg").hide();
            var avQtyMsg = availabilityContainer.find(".availability-qty-available");
            if (avQtyMsg.length===0) {
              avQtyMsg = $("<span/>").addClass("availability-qty-available").appendTo(availabilityContainer);
            }
            avQtyMsg.text(data.inStockMsg).show();

            avQtyMsg = availabilityContainer.find(".availability-qty-available");
            if (avQtyMsg.length===0) {
              avQtyMsg = $("<span/>").addClass("availability-qty-available").appendTo(availabilityContainer);
            }
            avQtyMsg.text(data.backorderMsg).show();
          });

    });

    // Add to Wishlist and Add to Gift Registry links behaviors
    $cache.pdpMain.on("click", "a.wl-action", function (e) {
      e.preventDefault();

      var data = app.util.getQueryStringParams($("form.pdpForm").serialize());
      if (data.cartAction) {
        delete data.cartAction;
      }
      var url = app.util.appendParamsToUrl(this.href, data);
      url = this.protocol + "//" + this.hostname + ((url.charAt(0)==="/") ? url : ("/"+url));
      window.location.href = url;
    });

    $cache.pdpMain.on("mouseenter", "ul.Color a.swatchanchor", function () {
      //swapImage(this);
    });
    // productthumbnail.onclick()
    $cache.pdpMain.on("click", "img.productthumbnail", function () {
      var lgImg = $(this).data("lgimg");

      // switch indicator
      $cache.pdpMain.find("div.product-thumbnails li.selected").removeClass("selected");
      $(this).closest("li").addClass("selected");

      setMainImage(lgImg);
      // load zoom if not quick view
      if( lgImg.hires !== '' && lgImg.hires.indexOf('noimagelarge')<0 ){
        setMainImageLink();
        loadZoom();
      } else {
        removeImageZoom();
      }
    });

    // product image swipe event handlers
    if ( Modernizr.touch && app.constants.PRODUCT_IMAGE_SWIPE_ENABLED ) {//Check if we're on a touch device and if this feature is enabled for this site -JL

      var $outerSlider;
      var $innerSlider;
      var $swipeImage;
      var imageAreaWidth;
      var productThumbs;

      var InitializeProductImagesTouchScroll = function() {
        $cache.productThumbs = $('.product-thumbnails img');

        $cache.imageArea = $('.product-image-container');

        imageAreaWidth = $cache.imageArea.width();

        productThumbs = (function () {
          var array = [];
          $cache.productThumbs.each(function () {
            array.push($(this).attr('src').split("?")[0]);
          });
          return array;
        }());

        $outerSlider = $('<div/>');

        $innerSlider = $('<div/>');

        $swipeImage = $('<div/>');

        var outerSliderCSS = {
          width: imageAreaWidth,
          overflowX: 'scroll',
          overflowY: 'hidden',
          minHeight: imageAreaWidth * 1.11
        };

        var innerSliderCSS = {
          width: imageAreaWidth * productThumbs.length,
          position: 'relative',
          minHeight: imageAreaWidth * 1.11
        };

        var swipeImageCSS = {
          width: imageAreaWidth,
          height: imageAreaWidth * 1.11,
          backgroundSize: '25%',
          backgroundRepeat: 'no-repeat',
          backgroundPosition: 'center',
          position: 'absolute',
          left: '0',
          top: '0',
          zIndex: '1',
          pointerEvents: 'none'
        };

        $cache.imageArea.html("");

        $outerSlider.appendTo($cache.imageArea).append($innerSlider).css(outerSliderCSS).css('-webkit-overflow-scrolling', 'touch');

        $innerSlider.css(innerSliderCSS);

        $swipeImage.css(swipeImageCSS).addClass('product-swipe-image').appendTo($innerSlider);

        productThumbs.forEach(function (src) {
          var $image = $('<img>');

          $image.attr('src', src + "?sw=" + (imageAreaWidth * 1.75)).css('width', imageAreaWidth + "px").css({
            backgroundImage: 'url("'+src+'?sw=75")',
            backgroundSize: 'contain'
          }).appendTo($innerSlider);

        });

        var findNearestImage = function() {

          var leastDistance;
          var leastElement;

          $innerSlider.find('img').each(function(){

            var newDistance = Math.abs(($(this).position().left + (imageAreaWidth / 2)) - ($outerSlider.scrollLeft() + (imageAreaWidth / 2)+1));

            if ( typeof leastDistance === "undefined" || !leastDistance || ( newDistance < leastDistance ) ) {
              leastDistance = newDistance;
              leastElement = this;
            }

          });

          return leastElement;

        };

        $innerSlider.on("touchend", function() {

          var scrollPosition = $outerSlider.scrollLeft();

          var checkForScrollEnd = setInterval(function(){

          var newScrollPosition = $outerSlider.scrollLeft();

          if ( scrollPosition === newScrollPosition ) {

            clearInterval(checkForScrollEnd);

            var nearest = findNearestImage();
            $outerSlider.animate({
              scrollLeft: $(nearest).position().left
            }, 500);

          } else {

            scrollPosition = newScrollPosition;

          }
          },150);

        });

        $(window).resize(function(){
          setTimeout(function(){
            var nearest = findNearestImage();
            $outerSlider.animate({
              scrollLeft: $(nearest).position().left
            }, 500);
          },100);
        });

        $innerSlider.on("touchstart", function() {

          if ( $swipeImage.is('*') ) {
            $swipeImage.animate({opacity: 0}, function(){
              $(this).remove();
            });
          }

          $outerSlider.stop();
        });

      };

      InitializeProductImagesTouchScroll();

      var resizeProductImagesTouchScroll = function() {

        imageAreaWidth = $('.product-image-container').width();

        $outerSlider.css('width', imageAreaWidth);

        $innerSlider.find('img').each(function(){
          $(this).css('width', imageAreaWidth);
        });

        $innerSlider.css('width', productThumbs.length * imageAreaWidth);

      };

      $(window).resize(function(){
        resizeProductImagesTouchScroll();
      });

    }




    // dropdown variations
    $cache.pdpMain.on("change", ".product-options select", function (e) {
      var salesPrice = $cache.pdpMain.find("div.product-add-to-cart .price-sales");

      var selectedItem = $(this).children().filter(":selected").first();
      var combinedPrice = selectedItem.data("combined");
      salesPrice.text(combinedPrice);
    });

    // prevent default behavior of thumbnail link and add this Button
    $cache.pdpMain.on("click", ".thumbnail-link, .addthis_toolbox a", false);
    $cache.pdpMain.on("click", "li.unselectable a", function(e){
      e.preventDefault();
      $('.availability').hide();
      $('.add-to-cart').prop('disabled', true);
      $(this).closest('li').siblings('li').removeClass('selected');
      $(this).closest('li').addClass('selected');
      if(app.enabledStorePickup){app.storeinventory.showStoreInventory( $(this).data('id') );}
    });

    // handle drop down variation attribute value selection event
    $cache.pdpMain.on("change", ".variation-select", function(e){
      if ($(this).val().length===0) {return;}
      var qty = $cache.pdpForm.find("input[name='Quantity']").first().val(),
      listid = $cache.pdpForm.find("input[name='productlistid']").first().val(),
      productSet = $(this).closest('.subProduct'),
      params = {
        Quantity : isNaN(qty) ? "1" : qty,
            format : "ajax"
      };
      if( listid ) params.productlistid = listid;
      var target = (productSet.length > 0 && productSet.children.length > 0) ? productSet : $cache.productContent;
      var url = app.util.appendParamsToUrl($(this).val(), params);
      app.progress.show($cache.pdpMain);

      app.ajax.load({
        url: url,
        callback : function (data) {
          target.html(data);
          //app.product.initAddThis();
          app.product.initAddToCart();
          if(app.enabledStorePickup){app.storeinventory.showStoreInventory();}
          $("#update-images").remove();
        }
      });
    });

    // Set swatch text initially
    // Add selected swatch color outside of swatches loop

    if ($('.selectedcolor').length > 0) {
      var selectedColor = $('ul.swatches.Color li.selected').text();
      $('.selectedcolor').text(selectedColor);
    }
    
    //for intial page load for out of stock and category items that have not been setup yet
    app.bisnLoad.init("#bisn-form");
    
    // swatch anchor onclick()
    $cache.pdpMain.on("click", "div.product-detail a[href].swatchanchor", function (e) {
      e.preventDefault();

      var el = $(this);
      var isColor = el.closest("ul.swatches").hasClass("Color");
      if( isColor && el.parents('li').hasClass('selected') ) return;      
      var anchor = el,
      qty = $cache.pdpForm.find("input[name='Quantity']").first().val(),
      listid = $cache.pdpForm.find("input[name='productlistid']").first().val(),
      productSet = $(anchor).closest('.subProduct'),
      params = {
        Quantity : isNaN(qty) ? "1" : qty
      };
      if( listid ) params.productlistid = listid;

      var target = (productSet.length > 0 && productSet.children.length > 0) ? productSet : $cache.productContent;
      var url = app.util.appendParamsToUrl(this.href, params);
      app.progress.show($cache.pdpMain);

      app.ajax.load({
        url: url,
        callback : function (data) {
        
          // Parse Data first

          var parseData = $.parseHTML(data);

          target.html(parseData);
          //app.product.initAddThis();
          app.product.initAddToCart();
          if (isColor) {
            replaceImages();
            if ( Modernizr.touch && app.constants.PRODUCT_IMAGE_SWIPE_ENABLED ) { //If Touch is enabled and this feature is available to this site.
              InitializeProductImagesTouchScroll();
            }
          }

          // Set selected color text
          // Add selected swatch color outside of swatches loop

          if ($('.selectedcolor').length > 0) {
            var selectedColor = $(parseData).find('ul.swatches.Color li.selected').text();
            $('.selectedcolor').text(selectedColor);
          }

          /* Initialize the Estimated Delivery on the
           * PDP page after ajax callon variations
           * only init if estimated delivery is enabled
           */

          if ($(".estimatedArival").length > 0) {
            est.init();
          }
          
          //for ajax call to reload form click events
          app.bisnLoad.init("#bisn-form");
          
          // NS: BLING loads in bling option if bling container exists.
          if ($('.bling-container').length) {
            app.loadblingfunc.init();
          }
          
          // update polyvore button image
          try {
            var imageSrc = $('.product-primary-image .primary-image').attr("src");
            $('#add-to-polyvore').attr("data-image-url", imageSrc);
            //re-initialize the polyvore like button
            if (window.location.protocol == "https:") {
              $.getScript('https://www.polyvore.com/rsrc/add_to_polyvore.js');
            } else {
              $.getScript('http://akwww.polyvorecdn.com/rsrc/add_to_polyvore.js');
            }
          } catch(e) {
            //alert(e);
          }
          
          //geotarget and showStoreInventory automatically
          if(app.enabledStorePickup){app.storeinventory.showStoreInventory();}
          
        }
      });
    });

    $cache.productSetList.on("click", "div.product-set-item li a[href].swatchanchor", function (e) {
      e.preventDefault();
      // get the querystring from the anchor element
      var params = app.util.getQueryStringParams(this.search);
      var psItem = $(this).closest(".product-set-item");
      var header = psItem.find("h3").html();
      
      // set quantity to value from form
      var qty = psItem.find("form").find("input[name='Quantity']").first().val();
      params.Quantity = isNaN(qty) ? "1" : qty;

      var url = app.util.getPipeUrl('Product-GetSetItem') + "?" + $.param(params);

      // get container
      var ic = $(this).closest(".product-set-item");
      ic.load(url, function () {
        app.progress.hide();
        if ($cache.productSetList.find("button.add-to-cart[disabled]").length>0) {
          $cache.addAllToCart.attr("disabled","disabled");
          $cache.addToCart.attr("disabled","disabled"); // this may be a bundle
        }
        else {
          $cache.addAllToCart.removeAttr("disabled");
          $cache.addToCart.removeAttr("disabled"); // this may be a bundle
        }
        ic.find(".product-set-image").before($("<h3>").html(header));
        
        app.product.initAddToCart(ic);
      });
    });

    $cache.addAllToCart.on("click", function (e) {
      e.preventDefault();
      var psForms = $cache.productSetList.find("form").toArray(),
      miniCartHtml = "",
      addProductUrl = app.util.ajaxUrl(app.util.getPipeUrl('Cart-AddProduct'));

      // add items to cart
      function addItems() {
        var form = $(psForms.shift());
        var itemid = form.find("input[name='pid']").val();

        $.ajax({
          dataType : "html",
          url: addProductUrl,
          data: form.serialize()
        })
        .done(function (response) {
          // success
          miniCartHtml = response;
        })
        .fail(function (xhr, textStatus) {
          // failed
          var msg = app.resources.ADD_TO_CART_FAIL;
          $.validator.format(msg, itemid);
          if(textStatus === "parsererror") {
            msg+="\n"+app.resources.BAD_RESPONSE;
          } else {
            msg+="\n"+app.resources.SERVER_CONNECTION_ERROR;
          }
          window.alert(msg);
        })
        .always(function () {
          if (psForms.length > 0) {
            addItems();
          }
          else {
            app.quickView.close();
            app.minicart.show(miniCartHtml);
          }
        });
      }
      addItems();
      return false;
    });
    app.sendToFriend.initializeDialog($cache.pdpMain, "a.send-to-friend");

    $cache.pdpMain.find("button.add-to-cart[disabled]").attr('title', $cache.pdpMain.find(".availability-msg").html() );
  }
  /**
   * @private
   * @function
   * @description Event handler to handle the add to cart event
   */
  function setAddToCartHandler(e) {
    e.preventDefault();       
    
    // Disable add to cart button to prevent dblclicks
    $('.add-to-cart').attr('disabled', true);
    
    var form = $(this).closest("form");
    var qty = form.find("input[name='Quantity']");
    
    if (qty.length === 0 || isNaN(qty.val()) || parseInt(qty.val(), 10) === 0) {
      qty.val("1");
    }
    
    var data = form.serialize();
    app.cart.update(data, function (response) {
      var uuid = form.find("input[name='uuid']");
      
      if (uuid.length > 0 && uuid.val().length > 0) {
        app.cart.refresh();
      } else {
        
        // Ue this for the mini cart to drop down the old way vs the pop up
        //app.minicart.show(response);
        //this way is the pop up version
        app.minicart.popup(response);
      }
    });
  }

  /*************** app.product public object ***************/
  app.product = {
      init : function () {
        initializeCache();
        initializeDom();
        initializeEvents();
        loadZoom();
        try {
          if(!app.quickView.isActive() && app.isDesktopUserAgent) {
            $('.polyvore-button').removeClass('hidden');
          }
        } catch(e) {
          //alert(e);
        }
        if(app.enabledStorePickup){
          app.storeinventory.init();
        }
      },
      readReviews : function() {       
        $(".product-tabs [href='#reviewstab']").on('click', function(e) {
          e.preventDefault();
          
          var scrollNum = $('.product-tabs').offset().top - $('.tabs-menu').outerHeight();
          
          $('html,body').animate({
            scrollTop: scrollNum
          });
        });
        
        $(".product-tabs [href='#reviewstab']").trigger("click");
      },
      /**
       * @function
       * @description Loads a product into a given container div
       * @param {Object} options An object with the following properties:</br>
       * <p>containerId - id of the container div, if empty then global app.containerId is used</p>
       * <p>source - source string e.g. search, cart etc.</p>
       * <p>label - label for the add to cart button, default is Add to Cart</p>
       * <p>url - url to get the product</p>
       * <p>id - id of the product to get, is optional only used when url is empty</p>
       */   
      get : function (options) {
        var target = options.target || app.quickView.init();
        var source = options.source || "";
        var productListID = options.productlistid || "";

        var productUrl = options.url || app.util.appendParamToURL(app.util.getPipeUrl('Product-Show'), "pid", options.id);
        if(source.length > 0) {
          productUrl = app.util.appendParamToURL(productUrl, "source", source);
        }
        if(productListID.length > 0) {
          productUrl = app.util.appendParamToURL(productUrl, "productlistid", productListID);
        }

        // show small loading image
        if (!options.quickview) app.progress.show(app.ui.primary);
        app.ajax.load({
          target : target,
          url : productUrl,
          data : options.data || "",
          // replace with callback passed in by options
          callback : options.callback || app.product.init
        });
      },
      /**
       * @function
       * @description Gets the availability to given product and quantity
       */
      getAvailability : function (pid, quantity, callback) {
        app.ajax.getJson({
          url: app.util.appendParamsToUrl(app.util.getPipeUrl('Product-GetAvailability'), {pid:pid, Quantity:quantity}),
          callback: callback
        });
      },
      /**
       * @function
       * @description Initializes the 'AddThis'-functionality for the social sharing plugin
       */
      initAddThis : function () {
        var addThisServices = ["compact","facebook","myspace","google","twitter"],
        addThisToolbox = $(".addthis_toolbox"),
        addThisLinks="";

        var i,len=addThisServices.length;
        for (i=0;i<len;i++) {
          if (addThisToolbox.find(".addthis_button_"+addThisServices[i]).length===0) {
            addThisLinks += '<a class="addthis_button_'+addThisServices[i]+'"></a>';
          }
        }
        if (addThisLinks.length===0) { return; }

        addThisToolbox.html(addThisLinks);
        addthis.toolbox(".addthis_toolbox");
      },
      /**
       * @function
       * @description Binds the click event to a given target for the add-to-cart handling
       * @param {Element} target The target on which an add to cart event-handler will be set 
       */
      initAddToCart : function (target) {
        if ((!$('.bisn-unselectable').length && jQuery('#variationColor .swatchanchor').length <= 1 && !jQuery('.variationsize li').length ) || (!$('.bisn-unselectable').length && jQuery('.variationsize li').length <= 1)){
          $('.add-to-cart').prop('disabled', false);
          $('#pid').val($('.swatchanchor').data('id'));
        }
        
        if (target) {
          target.on("click", ".add-to-cart", setAddToCartHandler);
        }
        else {
          $(".add-to-cart").on("click", setAddToCartHandler);
        }
      }
  };

}(window.app = window.app || {}, jQuery));

/**
 * @class app.product.tile
 */
(function (app, $) {
  var $cache = {};

  /**
   * @function
   * @description Initializes the DOM of the Product Detail Page
   */
  function initializeDom() {
    var tiles = $cache.container.find(".product-tile");
    if (tiles.length === 0) {
      return;
    }
    
    if (!app.constants.ISOTOPEGRID) {
      $cache.container.find(".product-tile").syncHeight();
    }
  }
  /**
   * @private
   * @function
   * @description Initializes events on the product-tile for the following elements:<br/>
   * <p>swatches</p>
   * <p>thumbnails</p>
   */
  function initializeEvents() {
	  if (!app.iOS) {
      app.quickView.initializeButton($cache.container, ".product-image");
    }
	  
    var swatchEvents = {

        init: function() {

          if (!app.isDesktopUserAgent || app.constants.PRODUCT_SWATCH_CLICK) {
            $cache.container.on("click", ".swatch-list a.swatch", this.swatchMouseClick);
          }
          if (app.isDesktopUserAgent) {
            //$cache.container.on("mouseleave", ".swatch-list", this.swatchMouseLeave);
            $cache.container.on("mouseenter", ".swatch-list a.swatch", this.swatchMouseEnter);
          }

        },
        swatchMouseLeave: function(e){
          // Restore current thumb image

          var tile = $(this).closest(".grid-tile");
          var thumb = tile.find(".product-image a.thumb-link img").filter(":first");
          var data = thumb.data("current");
          if(data !== undefined) {
            thumb.attr({
              src: data.src,
              alt: data.alt,
              title: data.title
            });
          }
        },
        swatchMouseClick: function (e) {
          e.preventDefault();
          if ($(this).hasClass("selected")) { return; }

          var tile = $(this).closest(".grid-tile");
          $(this).closest(".product-swatches").find(".selected-swatch").removeClass("selected-swatch");
          $(this).closest(".product-swatches").find(".swatch.selected").removeClass("selected");
          $(this).parent("li").addClass("selected-swatch");
          $(this).addClass("selected");
          tile.find("a.thumb-link").attr("href", $(this).attr("href"));
          tile.find("a.name-link").attr("href", $( this).attr("href"));

          var swatchImg = $(this).filter(":first");   
          var data = $(this).data("thumb");     
          var thumb = tile.find(".product-image a.thumb-link img").filter(":first");
          var currentAtts = {
              src : data.src,
              alt : data.alt,
              title : data.title
          };
          thumb.attr(currentAtts);
          thumb.data("current", currentAtts);

        },
        swatchMouseEnter: function (e) {

          // if ($(this).hasClass("selected")) { return; }

          // get current thumb details
          var tile = $(this).closest(".grid-tile");
          var thumb = tile.find(".product-image a.thumb-link img").filter(":first");
          var thumbHover = tile.find(".product-image a.thumb-link img.thumb-hover").filter(":first");
          $(this).closest(".product-swatches").find(".selected-swatch").removeClass("selected-swatch");
          $(this).closest(".product-swatches").find(".swatch.selected").removeClass("selected");
          $(this).parent("li").addClass("selected-swatch");
          $(this).addClass("selected");
          tile.find("a.thumb-link").attr("href", $(this).attr("href"));
          tile.find("a.name-link").attr("href", $( this).attr("href"));

          var swatchImg = $(this).filter(":first");
          var data = JSON.parse(swatchImg.attr("data-thumb"));
          var dataHover = swatchImg.data("hover");
          var current = thumb.data('current');
                    
          // If this is the first time, then record the current img
          if(!current) {
            thumb.data('current',{src:thumb[0].src, alt:thumb[0].alt, title:thumb[0].title});    
          }     
          
          // Set the tile image to the values provided on the swatch data attributes
          // replace(/&#39;/g, "'") Added to replace alt and title tags with single quotes (see showswatches.isml)
          
          thumb.attr({
            src : data.src,
            alt : data.alt.replace(/&#39;/g, "'").replace(/&#34;/g, '"'),
            title : data.title.replace(/&#39;/g, "'").replace(/&#34;/g, '"')
          });
          
          if (dataHover !== false) {
            thumbHover.removeClass('thumb-hidden').attr({
              src: dataHover
            });
            thumbHover.parent().addClass('hover-view');
          } else {
            thumbHover.addClass('thumb-hidden');
            thumbHover.parent().removeClass('hover-view');
          }
          
        }

    };
    // init the swatch event handlers
    swatchEvents.init();

  }

  /*************** app.product.tile public object ***************/
  app.product.tile = {
      /**
       * @function
       * @description Cache, events and initialization
       */ 
      init : function () {
        $cache = {
            container : $(".tiles-container")
        };
        initializeEvents();
        initializeDom();
      }
  };

}(window.app = window.app || {}, jQuery));

/**
 * @class app.product.compare
 */
(function (app, $) {
  var $cache = {},
    _currentCategory = "",
    _isClearing = false,
    MAX_ACTIVE = 6,
    CI_PREFIX = "ci-";

  /**
   * @private
   * @function
   * @description Verifies the number of elements in the compare container and updates it with sequential classes for ui targeting
   */
  function refreshContainer() {
    if (_isClearing) { return; }

    var ac = $cache.compareContainer.find(".active").length;

    if (ac < 2) {
      $cache.compareButton.attr("disabled", "disabled");
    }
    else {
      $cache.compareButton.removeAttr("disabled");
    }

    // update list with sequential classes for ui targeting
    var compareItems = $cache.compareContainer.find('.compare-item');
    for( i=0; i < compareItems.length; i++ ){
      compareItems.removeClass('compare-item-' + i);
      $(compareItems[i]).addClass('compare-item-' + i);
    }

    $cache.compareContainer.toggle(ac > 0);

  }
  /**
   * @private
   * @function
   * @description Adds an item to the compare container and refreshes it
   */
  function addToList(data) {
    // get the first compare-item not currently active
    var item = $cache.compareContainer.find(".compare-item").not(".active").first();
    var tile = $("#"+data.uuid);
    if (item.length===0) {
      if(tile.length > 0) {
        tile.find(".compare-check")[0].checked = false;
      }
      window.alert(app.resources.COMPARE_ADD_FAIL);
      return;
    } // safety only

    // if already added somehow, return
    if ($("#"+CI_PREFIX+data.uuid).length > 0) {
      return;
    }
    // set as active item
    item.addClass("active")
    .attr("id", CI_PREFIX+data.uuid)
    .data("itemid", data.itemid);

    // replace the item image
    var itemImg = item.children("img.compareproduct").first();
    itemImg.attr({src : $(data.img).attr("src"), alt : $(data.img).attr("alt")});

    // refresh container state
    refreshContainer();

    if (tile.length===0) { return; }

    // ensure that the associated checkbox is checked
    tile.find(".compare-check")[0].checked = true;
  }
  /**
   * @private
   * @function
   * description Removes an item from the compare container and refreshes it
   */
  function removeFromList(uuid) {
    var item = $("#"+CI_PREFIX+uuid);
    if (item.length===0) { return; }

    // replace the item image
    var itemImg = item.children("img.compareproduct").first();
    itemImg.attr({src : app.util.getStaticUrl('images/comparewidgetempty.png'), alt : app.resources.EMPTY_IMG_ALT});

    // remove class, data and id from item
    item.removeClass("active")
      .removeAttr("id")
      .removeAttr("data-itemid")
      .data("itemid", "");

    // use clone to prevent image flash when removing item from list
    var cloneItem = item.clone();
    item.remove();
    cloneItem.appendTo($cache.comparePanel);
    refreshContainer();
    // ensure that the associated checkbox is not checked
    var tile = $("#"+uuid);
    if (tile.length === 0 ) { return; }

    tile.find(".compare-check")[0].checked = false;
  }
  /**
   * @private
   * @function
   * description Initializes the cache of compare container 
   */
  function initializeCache() {
    $cache = {
      primaryContent : $("#primary"),
      compareContainer : $("#compare-items"),
      compareButton : $("#compare-items-button"),
      clearButton : $("#clear-compared-items"),
      comparePanel : $("#compare-items-panel")
    };
  }
  /**
   * @private
   * @function
   * @description Initializes the DOM-Object of the compare container
   */
  function initializeDom() {
    _currentCategory = $cache.compareContainer.data("category") || "";
    var active = $cache.compareContainer.find(".compare-item").filter(".active");
    active.each(function () {
      var uuid = this.id.substr(CI_PREFIX.length);
      var tile = $("#"+uuid);
      if (tile.length === 0 ) { return; }

      tile.find(".compare-check")[0].checked = true;
    });
    // set container state
    refreshContainer();
  }
  /**
   * @private
   * @function
   * @description Initializes the events on the compare container
   */
  function initializeEvents() {
    // add event to buttons to remove products
    $cache.primaryContent.on("click", ".compare-item-remove", function (e, async) {
      var item = $(this).closest(".compare-item");
      var uuid = item[0].id.substr(CI_PREFIX.length);
      var tile = $("#"+uuid);
      var args = {
        itemid : item.data("itemid"),
        uuid : uuid,
        cb :  tile.length===0 ? null : tile.find(".compare-check"),
        async : async
      };
      app.product.compare.removeProduct(args);
      refreshContainer();
    });

    // Button to go to compare page
    $cache.primaryContent.on("click", "#compare-items-button", function () {
      window.location.href = app.util.appendParamToURL(app.util.getPipeUrl('Compare-Show'), "category", _currentCategory);
    });

    // Button to clear all compared items
    $cache.primaryContent.on("click", "#clear-compared-items", function () {
      _isClearing = true;
      $cache.compareContainer.hide()
        .find(".active .compare-item-remove")
        .trigger("click", [false]);
      _isClearing = false;
    });
  }

  /*************** app.product.compare public object ***************/
  app.product.compare = {
      /**
       * @function
       * @description Cache, events and initialization
       */   
      init : function () {
        initializeCache();
        initializeDom();
        initializeEvents();
      },
      initCache : initializeCache,
      /**
       * @function
       * @description Adds product to the compare table
       */ 
      addProduct : function (args) {
        var items = $cache.compareContainer.find(".compare-item");
        var cb = $(args.cb);
        var ac = items.filter(".active").length;
        if(ac===MAX_ACTIVE) {
          if(!window.confirm(app.resources.COMPARE_CONFIRMATION)) {
            cb[0].checked = false;
            return;
          }

          // remove product using id
          var item = items.first();

          // safety check only. should never occur.
          if (item[0].id.indexOf(CI_PREFIX)!==0) {
            cb[0].checked = false;
            window.alert(app.resources.COMPARE_ADD_FAIL);
            return;
          }
          var uuid = item[0].id.substr(CI_PREFIX.length);
          app.product.compare.removeProduct({
            itemid: item.data("itemid"),
            uuid: uuid,
            cb: $("#"+uuid).find(".compare-check")
          });
        }

        app.ajax.getJson({
          url : app.util.getPipeUrl('Compare-AddProduct'),
          data : { 'pid' : args.itemid, 'category' : _currentCategory },
          callback : function (response) {
            if (!response || !response.success) {
              // response failed. uncheck the checkbox return
              cb.checked = false;
              window.alert(app.resources.COMPARE_ADD_FAIL);
              return;
            }

            // item successfully stored in session, now add to list...
            addToList(args);
          }
        });
      },
      /**
       * @function
       * @description Removes product from the compare table
       */ 
      removeProduct : function (args) {
        if (!args.itemid) { return; }
        var cb = args.cb ? $(args.cb) : null;
        app.ajax.getJson({
          url : app.util.getPipeUrl('Compare-RemoveProduct'),
          data : { 'pid' : args.itemid, 'category' : _currentCategory },
          async: args.async,
          callback : function (response) {
            if (!response || !response.success) {
              // response failed. uncheck the checkbox return
              if (cb && cb.length > 0) { cb[0].checked = true; }
              window.alert(app.resources.COMPARE_REMOVE_FAIL);
              return;
            }

            // item successfully removed session, now remove from to list...
            removeFromList(args.uuid);
          }
        });
      }
  };

}(window.app = window.app || {}, jQuery));

/**
 * @class app.compare
 */
(function (app, $) {
  var $cache = {};
  /**
   * @private
   * @function
   * @description Initializes the cache on the compare table
   */
  function initializeCache() {
    $cache = {
        compareTable : $("#compare-table"),
        categoryList : $("#compare-category-list")
    };
  }
  /**
   * @private
   * @function
   * @description Initializes the DOM on the product tile
   */
  function initializeDom() {
    app.product.tile.init();
  }
  /**
   * @private
   * @function
   * @description Binds the click events to the remove-link and quick-view button
   */
  function initializeEvents() {
    $cache.compareTable.on("click", ".remove-link", function (e) {
      e.preventDefault();
      app.ajax.getJson({
        url : this.href,
        callback : function (response) {
          app.page.refresh();
        }
      });
    })
    .on("click", ".open-quick-view", function (e) {
      e.preventDefault();
      var form = $(this).closest("form");
      app.quickView.show({
        url:form.attr("action"),
        source:"quickview",
        data:form.serialize()
      });
    });

    $cache.categoryList.on("change", function () {
      $(this).closest("form").submit();
    });
  }

  /*************** app.compare public object ***************/
  app.compare = {
      /**
       * @function
       * @description Initializing of Cache, DOM and events
       */
      init : function () {
        initializeCache();
        initializeDom();
        initializeEvents();
        app.product.initAddToCart();
      }
  };


}(window.app = window.app || {}, jQuery));

/**
 * @class app.sendToFriend
 */
(function (app, $) {
  var $cache = {};
  
  /**
   * @private
   * @function
   * @description Initializes the events (preview, send, edit, cancel and close) on the send to friend form
   */
  function initializeEvents() {
    app.util.limitCharacters();
    
    $cache.form.on("click", ".preview-button, .send-button, .edit-button", function (e) {
      e.preventDefault();
      $cache.form.validate();
      if (!$cache.form.valid()) {
        return false;
      }
      //remove Emoji characters from input
      try {
        $cache.form.find('textarea[data-character-limit]').val( app.util.removeEmojiChars( $cache.form.find('textarea[data-character-limit]').val() ) );
      } catch (e) {
        //alert(e);
      }

      var requestType = $cache.form.find("#request-type");
      if (requestType.length>0) {
        requestType.remove();
      }
      $("<input/>").attr({id:"request-type", type:"hidden", name:$(this).attr("name"), value:$(this).attr("value")}).appendTo($cache.form);
      var data = $cache.form.serialize();
      app.ajax.load({url:$cache.form.attr("action"),
        data: data,
        target: $cache.form,
        callback: function() {
          app.validator.init();
          app.util.limitCharacters();
          $cache.form = $("#send-to-friend-form");
        }
      });
    })
    .on("click", ".cancel-button, .close-button", function (e) {
      e.preventDefault();
      $.dwPopup.close();
    });
  }

  /*************** app.sendToFriend public object ***************/
  app.sendToFriend = {
      init : function () {
        $cache = {
            form: $("#send-to-friend-form"),
            pdpForm: $("form.pdpForm")
        };
        initializeEvents();
      },

      /**
       * @function
       * @description 
       */
      initializeDialog : function (eventDelegate, eventTarget) {
        $(eventDelegate).on("click", eventTarget, function (e) {
          e.preventDefault();

          var dataWidth = $(this).data('width') !== undefined || $(this).data('width') !== '' ? $(this).data('width') : 800;
          var dlg = app.dialog.create({target:$("#send-to-friend-dialog"), options: {
            width: dataWidth,
            height: 'auto',
            title: this.title,
            classname: 'send-to-friend-popup',
            open: function() {
              app.sendToFriend.init();
              app.validator.init();
            }
          }});

          var data = app.util.getQueryStringParams($("form.pdpForm").serialize());
          if (data.cartAction) {
            delete data.cartAction;
          }
          var url = app.util.appendParamsToUrl(this.href, data);
          url = this.protocol + "//" + this.hostname + ((url.charAt(0)==="/") ? url : ("/"+url));
          app.ajax.load({
            url:app.util.ajaxUrl(url),
            target:dlg,
            callback: function () {
              $.dwPopup.init();
            }
          });
        });
      }
  };

}(window.app = window.app || {}, jQuery));

//formPopupWindow to friend

(function (app, $) {
  var $cache = {},
  initialized=false;
  function initializeFormPopupWindowEvents() {
    app.util.limitCharacters();   
    if (initialized) {return; }     
    $cache.form.on("click", ".send-button", function (e) {
      e.preventDefault();
      $cache.form.validate();
      if (!$cache.form.valid()) {
        return false;
      }
      var requestType = $cache.form.find("#request-type");
      if (requestType.length>0) {
        requestType.remove();
      }
      $("<input/>").attr({id:"request-type", type:"hidden", name:$(this).attr("name"), value:$(this).attr("value")}).appendTo($cache.form);
      var data = $cache.form.serialize();
      app.ajax.load({url:$cache.form.attr("action"),
        data: data,
        target: $cache.form,
        callback: function() {
          app.validator.init();
          app.util.limitCharacters();
          $cache.form = $("#form-popup-window");
        }
      });
    })
    .on("click", ".cancel-button, .close-button", function (e) {
      e.preventDefault();
      $.dwPopup.close();
    });
    initialized=true;
  }

  //============ app.formPopupWindow public object ============

  app.formPopupWindow = {
      init : function () {
        $cache = {
            form: $(".popup-content").find('form'),
            dialog: $(".popup-content")
        };      
        initializeFormPopupWindowEvents();
      },
      initializeDialog : function (eventDelegate, eventTarget) {
        $(eventDelegate).on("click", eventTarget, function (e) {
          e.preventDefault();
          var dlg = app.dialog.create({target:$("#form-popup-window-dialog"), options: {
            width: 360,
            height: 'auto',
            title: this.title,
            classname: 'form-popup-window',
            open: function() {
              app.formPopupWindow.init();
              app.validator.init();
            }
          }});
          var url = app.util.appendParamsToUrl(this.href);
          url = this.protocol + "//" + this.hostname + ((url.charAt(0)==="/") ? url : ("/"+url));
          app.ajax.load({
            url: app.util.ajaxUrl(url),
            target:dlg,
            callback: function () {
              // open after load to ensure dialog is centered
              $.dwPopup.init();
            }
          });
        });
      }
  };

}(window.app = window.app || {}, jQuery));

//app.storelocator

(function (app, $) {

  function initializeFormPopupWindowEvents() {
    app.formPopupWindow.initializeDialog(".pt_store-locator", "a.email-directions-btn");
  }

  app.storelocator = {
      init : function () {
        initializeFormPopupWindowEvents();
      }
  };

}(window.app = window.app || {}, jQuery));

/**
 * @class app.search
 */
(function (app, $) {
  var $cache = {};

  /**
   * @private
   * @function
   * @description replaces breadcrumbs, lefthand nav and product listing with ajax and puts a loading indicator over the product listing
   */
  function updateProductListing(isHashChange) {

    // [RAP-2653] requires special handling for 's encoding of ampersands
    var isFirefox = (navigator.userAgent).toLowerCase().indexOf('firefox') >= 0;
    var hash = isFirefox ? encodeURI(decodeURI(window.location.hash)) : window.location.hash;
    if(hash==='#results-content' || hash==='#results-products' || hash === '#search' || hash === '#mobile-navigation') { return; }


    var refineUrl = null;
    if (hash.length > 0) {
      refineUrl = window.location.pathname+"?"+hash.substr(1);      
    } else if (isHashChange) {
      refineUrl = window.location.href;      
    }

    if (!refineUrl) { return; }
    
    app.progress.show($cache.content);
    $cache.main.load(app.util.appendParamToURL(refineUrl, "format", "ajax"), function () {
      app.product.compare.init();
      app.product.tile.init();
      app.progress.hide();
      
      if (app.clientcache.LISTING_INFINITE_SCROLL) {
        initInfiniteScroll();
      }

      // re-init the seo widget (ext_js.js) if applicable
      if ($cache.main.find('.onpage-seo-content').length) {
        app.seowidget.init();
      }
      if ($cache.main.find('.js-off-canvas').length) {
        // app.refinement - ext_js.js
        app.refinementpanel.init();
      }
      
      // Toggle the h3 when clicking on refinements so that it doesn't reverse the expand/collapse classing
      if ($('.refinement').find('ul').is(':visible') && $('.refinement').find('ul').find('li.selected').length) {
        $('.refinement').find('ul').find('li.selected').parent().parent().find('h3').toggleClass('expanded');
      }
      
    });
  }
  function buildSlotCarousel() {
    // build swatch carousels
    var slotCarousel = $cache.main.find(".content-slot .carousel");
    slotCarousel.carousel();
    slotCarousel.on("click", ".right", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).closest(slotCarousel).carousel("next");
    });
    slotCarousel.on("click", ".left", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).closest(slotCarousel).carousel("prev");
    });
  }
  function buildSwatchCarousel() {
    // build swatch carousels
    var swatchCarousel = $cache.main.find(".product-swatches .carousel");
    swatchCarousel.carousel({
      interval: false
    });
    swatchCarousel.on("click", ".carousel-control", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).closest(swatchCarousel).carousel("next");
    });
  } 
  /** 
   * @private 
   * @function 
   * @description 
   */ 
  function initInfiniteScroll() {
    if (app.constants.ISOTOPEGRID && $('#isotope-container').length) {
      var $isoContainer = $('#isotope-container'),
          $preloadContainer = $('<div id="preload-container"/>'),
          $loadingIndicator = $('<div class="product-lazy-load-indicator"/>').insertAfter($isoContainer),
          isoOptions = $isoContainer.data('isotope-options'),
          disOptions = $isoContainer.data('image-settings'),
          largeImg = 'sw=' + disOptions.large.scaleWidth + '&sh=' + disOptions.large.scaleHeight + '&sm=' + disOptions.large.scaleMode,
          mediumImg = 'sw=' + disOptions.medium.scaleWidth + '&sh=' + disOptions.medium.scaleHeight + '&sm=' + disOptions.medium.scaleMode,
          isoMaxPage = parseInt($isoContainer.data('paging-max')),
          isoCurrPage = 0;

      $isoContainer.isotope(isoOptions);

      $isoContainer.imagesLoaded(function() {
        $isoContainer.isotope('layout');
      });

      if ($('.iso-large').length) {
        var i;
        var largeIso, swatchData, thumbImg, newImgPath, newIsoData, thumbImgSrc;

        // Modify all the swatch data based on sizing and mobile
        for (i = 0; i < $('.swatch-list a').length; i++) {
          largeIso = $('.swatch-list a').eq(i).closest('.grid-tile');
          swatchData = largeIso.find('.swatch-list a').data('thumb');
          thumbImg = $('.swatch-list a').eq(i).data('thumb').src;
          newImgPath = thumbImg.substring(0, thumbImg.lastIndexOf('?') + 1);

          if (largeIso.hasClass('iso-large')) {
            if ($('#wrapper').width() <= isoOptions.mobileBreak) {
              newIsoData = {src: newImgPath + mediumImg, alt: swatchData.alt, title: swatchData.title};
            } else {
              newIsoData = {src: newImgPath + largeImg, alt: swatchData.alt, title: swatchData.title};
            }

            $('.swatch-list a').eq(i).attr('data-thumb', JSON.stringify(newIsoData));
          }
        }

        // Modify the view images based on sizing and mobile
        for (i = 0; i < $('.thumb-link').length; i++) {
          largeIso = $('.thumb-link').eq(i).closest('.grid-tile');
          thumbImg = $('.thumb-link img').eq(i);
          thumbImgSrc = thumbImg.prop('src');
          newImgPath = thumbImgSrc.substring(0, thumbImgSrc.lastIndexOf('?') + 1);

          if (largeIso.hasClass('iso-large')) {
            if ($('#wrapper').width() <= isoOptions.mobileBreak) {
              thumbImg.prop('src', newImgPath + mediumImg);
            } else {
              thumbImg.prop('src', newImgPath + largeImg);
            }

            thumbImg.parent().attr('data-thumb', thumbImg.prop('src'));
          }
        }
      }

      if (isoOptions.layoutMode === 'masonry' && $('.iso-large').length) {
        var productsPerRow = Math.floor($isoContainer.width() / $(".grid-tile:not('.iso-large')").width());
        isoOptions.masonry.columnWidth = $isoContainer.width() / productsPerRow;
      }

      function incrementPaging() {
        
        // Increment page counter
        isoCurrPage++;

        // We need to reclarify the $isoContainer and isoMaxPage
        // For the refinements ajax loads
        $isoContainer = $('#isotope-container');
        isoMaxPage = parseInt($isoContainer.data('paging-max'));

        $isoContainer.imagesLoaded(function() {
          $isoContainer.isotope('layout');
        });
        
        if (isoCurrPage === isoMaxPage || isoMaxPage === 0) {

          // Reset the page counter
          // After the last set of tiles load
          isoCurrPage = 0;

          //When all the tiles finish loading remove the loading indicator
          $('.product-lazy-load-indicator').remove();
        }
      }

      // If there's only one page trigger the isotope

      if (isoMaxPage === 0) {
        incrementPaging();
      }
    }
    
    jQuery(window).on('scroll ready', function(e) {
      // getting the hidden div, which is the placeholder for the next page
      var loadingPlaceHolder = jQuery('.infinite-scroll-placeholder[data-loading-state="unloaded"]');
      var elementInView = jQuery('.search-result-content');
      
      if ((loadingPlaceHolder.length == 1 && app.util.elementInViewport(elementInView.get(0), 250)) || (loadingPlaceHolder.length == 1 && jQuery('html').hasClass('ie8','ie7'))) {
        // switch state to 'loading'
        // - switches state, so the above selector is only matching once
        // - shows loading indicator
        loadingPlaceHolder.attr('data-loading-state','loading');
        loadingPlaceHolder.addClass('infinite-scroll-loading');
        
        // get url hidden in DOM
        var gridUrl = loadingPlaceHolder.attr('data-grid-url');
        
        /**
         * named wrapper function, which can either be called, if cache is hit, or ajax response is received
         */
        var fillEndlessScrollChunk = function (html) {
          loadingPlaceHolder.removeClass('infinite-scroll-loading');
          loadingPlaceHolder.attr('data-loading-state','loaded');
          
          if (!app.constants.ISOTOPEGRID) {
            jQuery('div.search-result-content').append(html);

          } else {
            var newItems = jQuery(html).appendTo($preloadContainer);
            $preloadContainer.imagesLoaded(function() {
              newItems.appendTo('div#search-result-items');
              $isoContainer.isotope('appended', newItems);
            });
          }
                    
          // init the app.product.tile for swatch and quickview functions
          app.product.tile.init();
          buildSwatchCarousel();
          
          if (app.constants.ISOTOPEGRID) {
            incrementPaging();
          }
        };

        // else do query via ajax
        jQuery.ajax({
          type: "GET",
          dataType: 'html',
          url: gridUrl,
          success: function(response) {
            // update UI
            fillEndlessScrollChunk(response);
          },
          complete: function() {

          }
        });
      }
    });
  }

  /**
   * @private
   * @function
   * @description Initializes events for the following elements:<br/>
   * <p>refinement blocks</p>
   * <p>updating grid: refinements, pagination, breadcrumb</p>
   * <p>item click</p>
   * <p>sorting changes</p>
   */
  function initializeEvents() {

    // compare checked
    $cache.main.on("click", "input[type='checkbox'].compare-check", function (e) {
      var cb = $(this);
      var tile = cb.closest(".product-tile");

      var func = this.checked ? app.product.compare.addProduct : app.product.compare.removeProduct;
      var itemImg = tile.find("div.product-image a img").first();
      func({
        itemid : tile.data("itemid"),
        uuid : tile[0].id,
        img : itemImg
      });
    });

    // handle toggle refinement blocks    
    
    if (!$cache.main.find('.refinements.no-toggling').length) {
      $cache.main.on("click", ".refinement h3", function (e) {
        $(this).toggleClass('expanded').siblings('ul').toggle();
      }); 
    } else {
      
      // full refinements panel functionality 
      
      var $refinement = {
          panelBtn : '.panel-btn',
          panel : $('.panel'),
          panelOpen : false
      };
                  
      $cache.main.on("click", $refinement.panelBtn, function(e) {
        e.preventDefault();
                        
        // get targeted panel
        
        var $this = $(this),
          $target = $this.data('panel');
                                
        if (!$refinement.panelOpen) {
          $this.addClass('is-active');
          $this.siblings().addClass('disabled');
          $($target).addClass('is-active');
          $refinement.panelOpen = true;
        } else {
          $($refinement.panelBtn).removeClass('is-active disabled');
          $($target).removeClass('is-active');
          $refinement.panelOpen = false;
        }
      });
      
    }
    
    // handle events for updating grid
    $cache.main.on("click", ".refinements a:not('.ignore-ajax'), .pagination a, .breadcrumb-refinement-value a", function (e) {
      if ($(this).parent().hasClass("unselectable")) { return; }
      
      var catparent = $(this).parents('.category-refinement');
      var folderparent = $(this).parents('.folder-refinement');
      
      // Reset refinements panel after filtering
      
      if ($('.refinements .panel').length) {
        $refinement.panelOpen = false;
      }      
                  
      //if the anchor tag is underneath a div with the class names &, 
      //prevent the double encoding of the url else handle the encoding for the url   
      
      if (catparent.length > 0 || folderparent.length > 0 ) {
        return true;
      } else { 
        e.preventDefault();
        var uri = app.util.getUri(this);
        
        // Break cache for refinements if Pro Customer
        
        if (app.isProCustomer) {
          if ( uri.query.length > 1 ) {
            window.location.hash = encodeURI(decodeURIComponent(uri.query.substring(1))) + '&p=true';
          } else {
            window.location.href = this.href + '?p=true';
          }         
        } else {
          if ( uri.query.length > 1 ) {
            window.location.hash = encodeURI(decodeURIComponent(uri.query.substring(1)));
          } else {
            window.location.href = this.href;
          }
        }
        
        return false;
      }
    });

    // handle events item click. append params.
    $cache.main.on("click", ".product-tile a:not('#quickviewbutton')", function (e) {
      var a = $(this);
      // get current page refinement values
      var wl = window.location;

      var qsParams = (wl.search.length > 1) ? app.util.getQueryStringParams(wl.search.substr(1)) : {};
      var hashParams = (wl.hash.length > 1) ? app.util.getQueryStringParams(wl.hash.substr(1)) : {};

      // merge hash params with querystring params
      var params = $.extend(hashParams, qsParams);
      if (!params.start) {
        params.start = 0;
      }
      if (!params.cgid) {
        params.cgid = jQuery('#main').data('category');
      }
      
      // get the index of the selected item and save as start parameter
      var tile = a.closest(".product-tile");
      var idx = tile.parents(".grid-tile").prevAll(".grid-tile").length + 1;

      // convert params.start to integer and add index
      params.start = params.start + idx;
      
      // set the hash and allow normal action to continue
      a[0].hash = $.param(params);
    });

    // handle sorting change
    $cache.main.on("change", ".sort-by select", function (e) {
      var refineUrl = $(this).find('option:selected').val();
      var uri = app.util.getUri(refineUrl);
      window.location.hash = uri.query.substr(1);
      return false;
    })
    .on("change", ".items-per-page select", function (e) {
      var refineUrl = $(this).find('option:selected').val();
      if (refineUrl == "INFINITE_SCROLL") {
        jQuery('html').addClass('infinite-scroll');
        jQuery('html').removeClass('disable-infinite-scroll');
      } else {
        jQuery('html').addClass('disable-infinite-scroll');
        jQuery('html').removeClass('infinite-scroll');
        var uri = app.util.getUri(refineUrl);
        window.location.hash = uri.query.substr(1);
      }
      return false;
    });

    // handle hash change
    $(window).hashchange(function () {
      updateProductListing(true);
    });
  }
  /******* app.search public object ********/
  app.search = {
    init: function () {
      $cache = {
        main: $("#main"),
        items: $("#search-result-items")
      };
      $cache.content = $cache.main.find(".search-result-content");
      //if (app.product.compare) {
      app.product.compare.init();
      //}
      updateProductListing(false);

      if (app.clientcache.LISTING_INFINITE_SCROLL) {
        initInfiniteScroll();
      }

      app.product.tile.init();
      buildSlotCarousel();
      buildSwatchCarousel();
      
      if ($cache.main.find('.js-off-canvas').length) {
        // app.refinement - ext_js.js
        app.refinementpanel.init();
      }
      
      initializeEvents();
    }
  };

  app.footwearfinder = app.search;

}(window.app = window.app || {}, jQuery));

/**
 * @class app.bonusProductsView
 */
(function (app, $) {
  var $cache = {};
  var selectedList = [];
  var maxItems = 1;
  var bliUUID = "";
  /**
   * @private
   * @function
   * description Gets a list of bonus products related to a promoted product
   */
  function getBonusProducts() {
    var o = {};
    o.bonusproducts = [];

    var i, len;
    for (i=0, len=selectedList.length;i<len;i++) {
      var p = { pid : selectedList[i].pid,  qty : selectedList[i].qty, options : {} };
      var a, alen, bp=selectedList[i];
      for (a=0,alen=bp.options.length;a<alen;a++) {
        var opt = bp.options[a];
        p.options = {optionName:opt.name,optionValue:opt.value};
      }
      o.bonusproducts.push({product:p});
    }
    return o;
  }
  /**
   * @private
   * @function
   * @description Updates the summary page with the selected bonus product
   */
  function updateSummary() {
    if (selectedList.length===0) {
      $cache.bonusProductList.find("li.selected-bonus-item").remove();
    }
    else {
      var ulList = $cache.bonusProductList.find("ul.selected-bonus-items").first();
      var itemTemplate = ulList.children(".selected-item-template").first();
      var i, len;
      for (i=0, len=selectedList.length;i<len;i++) {
        var item = selectedList[i];
        var li = itemTemplate.clone().removeClass("selected-item-template").addClass("selected-bonus-item");
        li.data("uuid", item.uuid).data("pid", item.pid);
        li.find(".item-name").html(item.name);
        li.find(".item-qty").html(item.qty);
        var ulAtts = li.find(".item-attributes");
        var attTemplate = ulAtts.children().first().clone();
        ulAtts.empty();
        var att;
        for (att in item.attributes) {
          var attLi = attTemplate.clone();
          attLi.addClass(att);
          attLi.children(".display-name").html(item.attributes[att].displayName);
          attLi.children(".display-value").html(item.attributes[att].displayValue);
          attLi.appendTo(ulAtts);
        }
        li.appendTo(ulList);
      }
      ulList.children(".selected-bonus-item").show();
    }

    // get remaining item count
    var remain = maxItems - selectedList.length;
    $cache.bonusProductList.find(".bonus-items-available").text(remain);
    if (remain <= 0) {
      $cache.bonusProductList.find("button.button-select-bonus").attr("disabled", "disabled");
    }
    else {
      $cache.bonusProductList.find("button.button-select-bonus").removeAttr("disabled");
    }
  }
  /********* public app.bonusProductsView object *********/
  app.bonusProductsView = {
      
    /**
     * @function
     * @description Opens the bonus product quick view dialog
     */   
    show: function(url) {
      $.dwPopup.open(url, {
        width : 800,
        classname : 'bonus-product',
        title : app.resources.BONUS_PRODUCTS,
        onOpen : function() {
          app.bonusProductsView.initializeGrid();
        }
      });
    },
    
    /**
     * @function
     * @description Loads the list of bonus products into quick view dialog
     */   
    loadBonusOption: function () {
      if (!$(".bonus-discount-container").length) {
        return;
      }
  
      $(".bonus-discount-container").prependTo(".popup-content");
      
      $cache.bonusDiscountContainer = $(".bonus-discount-container");
      
      // add event handlers
      $(".popup-content").on("click", ".select-bonus-btn", function (e) {
        e.preventDefault();
        
        var uuid = $cache.bonusDiscountContainer.data("lineitemid");
        var url = app.util.appendParamsToUrl(app.util.getPipeUrl('Product-GetBonusProducts'), {
          bonusDiscountLineItemUUID: uuid,
          source: "bonus"
        });
        
        app.bonusProductsView.show(url);
      }).on("click", ".no-bonus-btn", function (e) {
        $(".bonus-discount-container").slideUp('fast');
      });
    },
    
    /**
     * @function
     * @description 
     */   
    initializeGrid: function () {
      $cache.bonusProductList = $("#bonus-product-list"),
      bliData = $cache.bonusProductList.data("line-item-detail");
      
      maxItems = bliData.maxItems;
      bliUUID = bliData.uuid;

      if (bliData.itemCount >= maxItems) {
        $cache.bonusProductList.find("button.button-select-bonus").attr("disabled", "disabled");
      }

      var cartItems = $cache.bonusProductList.find(".selected-bonus-item");

      cartItems.each(function() {
        var ci = $(this);

        var product = {
          uuid       : ci.data("uuid"),
          pid        : ci.data("pid"),
          qty        : ci.find(".item-qty").text(),
          name       : ci.find(".item-name").html(),
          attributes : {}
        };
        
        var attributes = ci.find("ul.item-attributes li");
        attributes.each(function() {
          var li = $(this);
          product.attributes[li.data("attributeId")] = {
            displayName  : li.children(".display-name").html(),
            displayValue : li.children(".display-value").html()
          };
        });
        
        selectedList.push(product);
      });
      
      $cache.bonusProductList.on("click", "div.bonus-product-item a[href].swatchanchor", function (e) {
        e.preventDefault();
        
        var anchor = $(this),
        bpItem = anchor.closest(".bonus-product-item"),
        bpForm = bpItem.find("form.bonus-product-form"),
        qty = bpForm.find("input[name='Quantity']").first().val(),
        params = {
          Quantity : isNaN(qty) ? "1" : qty,
              format : "ajax",
              source : "bonus",
              bonusDiscountLineItemUUID : bliUUID
        };

        var url = app.util.appendParamsToUrl(this.href, params);

        app.progress.show(bpItem);
        app.ajax.load({
          url: url,
          callback : function (data) {
            bpItem.html(data);
          }
        });
      })
      .on("click", "button.button-select-bonus", function (e) {
        e.preventDefault();
        if (selectedList.length >= maxItems) {
          var container = $("li.selected-bonus-item");
          if (!container.data("uuid")) { return; }

          var uuid = container.data("uuid");
          var i, len = selectedList.length;
          for(i=0;i<len;i++) {
            if (selectedList[i].uuid===uuid) {
              selectedList.splice(i,1);
              break;
            }
          }
        }

        var form = $(this).closest("form.bonus-product-form"),
        detail = $(this).closest(".product-detail");
        uuid = form.find("input[name='productUUID']").val(),
        qtyVal = form.find("input[name='Quantity']").val(),
        qty = isNaN(qtyVal) ? 1 : (+qtyVal);

        var product = {
            uuid : uuid,
            pid : form.find("input[name='pid']").val(),
            qty : qty,
            name : detail.find(".product-name").text(),
            attributes : detail.find(".product-variations").data("current"),
            options : []
        };

        var optionSelects = form.find("select.product-option");

        optionSelects.each(function (idx) {
          product.options.push({
            name : this.name,
            value : $(this).val(),
            display : $(this).children(":selected").first().html()
          });
        });
        selectedList.push(product);
        updateSummary();
        
        e.preventDefault();
        var url = app.util.appendParamsToUrl(app.util.getPipeUrl('Cart-AddBonusProduct'), {bonusDiscountLineItemUUID:bliUUID});
        var bonusProducts = getBonusProducts();
        
        $.dwPopup.close();
        
        // make the server call
        $.ajax({
          type        : "POST",
          dataType    : "json",
          cache       : false,
          contentType : "application/json",
          url         : url,
          data        : JSON.stringify(bonusProducts)
        }).always(function() {
          window.location = app.util.getPipeUrl('Cart-Show');
        });
      });
    }
  };
} (window.app = window.app || {}, jQuery));

/**
 * @class app.giftcert
 * @description Loads gift certificate details
 */
(function (app, $) {
  var $cache;

  function setAddToCartHandler(e) {
    e.preventDefault();
    
    // Disable add to cart button to prevent dblclicks

    $('#AddToBasketButton').prop('disabled', true);
    
    var form = $(this).closest("form"),
        $giftCardAdded = $('.gift-card-in-basket');

    var options = { 
        url : app.util.ajaxUrl(form.prop('action')),
        method : 'POST',
        cache: false,
        data : form.serialize()
    };
    $.ajax(options).done(function(response) {
      if (response.success) {
        form.find('span.error').hide();
        
        app.ajax.load({
          url: app.util.getPipeUrl('GiftCert-ShowMiniCart'),
          data: {lineItemId: response.result.lineItemId},
          callback: function(response) {
            app.minicart.popup(response);

            // clear all form fields but the hidden sku input
            form.find('input:not(#dwfrm_giftcert_purchase_giftCertSKU),textarea').val('');
            
            /* Since we don't allow for multiple virtual gift cards to be fulfilled we hide 
               the virtual gift card form after adding one to the cart and display messaging */
            
            form.hide();
            $giftCardAdded.show();
          }
        });
      } else {
        form.find('span.error').hide();
        for( var id in response.errors.FormErrors ) {
          var error_el = $('#'+id).addClass('error').removeClass('valid').next('.error');
          if( !error_el || error_el.length===0 ) {
            error_el = $('<span for="'+id+'" generated="true" class="error" style=""></span>');
            $('#'+id).after(error_el);
          }
          error_el.text(response.errors.FormErrors[id].replace(/\\'/g,"'")).show();
        }
        // console.log(JSON.stringify(response.errors));
      }
    }).fail(function (xhr, textStatus) {
      // failed
      if(textStatus === "parsererror") {
        window.alert(app.resources.BAD_RESPONSE);
      } else {
        window.alert(app.resources.SERVER_CONNECTION_ERROR);
      }
    }).complete(function() {      
      // Reactivate add to cart button after ajax call
      
      $('#AddToBasketButton').prop('disabled', false);
    });
  }

  function setAddToCartHandlerGC(e) {
    e.preventDefault();
    
    // Disable add to cart button to prevent dblclicks
    
    $('#AddToBasketButtonGC').prop('disabled', true);
    
    var form = $(this).closest("form");
    var options = { 
        url : app.util.ajaxUrl(form.prop('action')),
        method : 'POST',
        cache: false,
        data : form.serialize()
    };
    $.ajax(options).done(function (response) {
      if( response.success ) {
        app.ajax.load({
          url : app.util.getPipeUrl('GiftCert-ShowMiniCart'),
          data :{pid : response.result.lineItemId, quantity: '1'},
          callback : function(response){
            app.minicart.popup(response);

            // clear all form fields but the hidden sku input

            form.find('input:not(#dwfrm_giftcert_purchase_giftCertSKU),textarea').val('');
          }
        });
      } else {
        form.find('span.error').hide();
        for(var id in response.errors.FormErrors ) {
          var error_el = $('#'+id).addClass('error').removeClass('valid').next('.error');
          if( !error_el || error_el.length===0 ) {
            error_el = $('<span for="'+id+'" generated="true" class="error" style=""></span>');
            $('#'+id).after(error_el);
          }
          error_el.text(response.errors.FormErrors[id].replace(/\\'/g,"'")).show();
        }
        //console.log(JSON.stringify(response.errors));
      }
    }).fail(function (xhr, textStatus) {

      // failed

      if(textStatus === "parsererror") {
        window.alert(app.resources.BAD_RESPONSE);
      } else {
        window.alert(app.resources.SERVER_CONNECTION_ERROR);
      }
    }).complete(function() {
      // Reactivate add to cart button after ajax call
      
      $('#AddToBasketButtonGC').prop('disabled', false);
    });
  }

  function initializeCache() {
    $cache = {
        addToCart : $("#AddToBasketButton"),
        addToCartGC : $("#AddToBasketButtonGC")
    };
  }

  function initializeEvents() {
    $cache.addToCart.on('click', setAddToCartHandler);
    $cache.addToCartGC.on('click', setAddToCartHandlerGC);
    $('[class^=expander]').on('click', function(e) {
      $(this).toggleClass("expand-minus");
      $("#" + e.target.className.split(" ",1)[0]).toggleClass("hidden");
    });
    app.gift.init();
  }

  app.giftcert = {
      init : function() {
        initializeCache();
        initializeEvents();
      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.gift
 * @description Loads gift certificate details
 */
(function (app, $) {
  app.gift = {
      init : function () {
        app.gift.loadbtnclick();
      },
      loadbtnclick : function() {
        $('#gc-checkbalance').on("click", function (e) {
          e.preventDefault();
          app.getgiftcardbalance.checkBalance(jQuery(this).closest("form"),'_balance_giftCertID','_balance_giftCertCVD');
        });
      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.giftcard
 * @description Loads gift certificate details
 */
(function (app, $) {

  app.giftcard = {
      /**
       * @function
       * @description Load details to a given gift certificate
       * @param {String} id The ID of the gift certificate
       * @param {Function} callback A function to called 
       */
      checkBalance : function (id, CVD, callback) {
        
        // load gift certificate details
        var url = app.util.appendParamToURL(app.util.getPipeUrl('COBilling-GetGiftCertificateBalance'), "giftCertificateID", id);
        url = app.util.appendParamToURL(url, "giftCertificateCVD", CVD);
        
        app.ajax.getJson({
          url: url,
          callback: callback
        });
      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.giftcardbalance
 * @description Loads gift certificate balance
 */

(function(app, $) {
  app.getgiftcardbalance = {
    checkBalance : function (form, gc, gcvd) {
      $cache.gcCode = $cache.gcCode || form.find("input[name$='"+gc+"']");
      $cache.gcCodeCVD = $cache.gcCodeCVD || form.find("input[name$='"+gcvd+"']");
      $cache.balance = $cache.balance || form.find("div.balance");
      form.find(".gift-cert-balance span.error").remove();
      
      if ($cache.gcCode.length === 0 || $cache.gcCode.val().length === 0 || $cache.gcCodeCVD.length === 0 || $cache.gcCodeCVD.val().length === 0) {
        var error = form.find(".gift-cert-balance span.error").find("span.error");
        if (error.length === 0) {
          error = $("<span>").addClass("error").appendTo(form.find(".gift-cert-balance"));
        }
        error.html(app.resources.GIFT_CERT_MISSING);
        return;
      }
      
      $cache.balance.html('').addClass('loading-small');
      app.giftcard.checkBalance($cache.gcCode.val(), $cache.gcCodeCVD.val(), function(data) {

        if (!data || !data.giftCertificate) {

          // error
          var error = form.find(".gift-cert-balance span.error");
          if (error.length === 0) {
            error = $("<span>").addClass("error").appendTo(form.find(".gift-cert-balance"));
          }
          $cache.balance.removeClass('loading-small');
          error.html(app.resources.GIFT_CERT_INVALID);
          return;
        }

        // display details in UI
        $cache.balance.find("span.error").remove();
        var balance = data.giftCertificate.balance;
        $cache.balance.removeClass('loading-small');
        $cache.balance.html(app.resources.GIFT_CERT_BALANCE + " " + balance);
      });
    }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.checkout
 */
(function (app, $) {
  var $cache = {},
  isShipping = false,
  isMultiShipping = false,
  shippingMethods = null;

  /**
   * @function
   * @description Helper method which constructs a URL for an AJAX request using the
   * entered address information as URL request parameters.
   */
  function getShippingMethodURL(url) {

    // Change $cache.stateCode
    $cache.stateCode = $cache.checkoutForm.find(".state-field");

    var newUrl = app.util.appendParamsToUrl(url,
        {
      address1:$cache.address1.val(),
      address2:$cache.address2.val(),
      countryCode:$cache.countryCode.val(),
      stateCode:$cache.stateCode.val(),
      postalCode:$cache.postalCode.val(),
      city:$cache.city.val()
        }, true);
    return newUrl;
  }

  /**
   * @function 
   * @description updates the order summary based on a possibly recalculated basket after a shipping promotion has been applied
   */
  function updateSummary() {
    var url = app.util.getPipeUrl('COBilling-UpdateSummary');
    var summary = $("#secondary.summary");
    // indicate progress
    app.progress.show(summary);

    // load the updated summary area
    summary.load( url, function () {
      // hide edit shipping method link
      summary.fadeIn("fast");
      summary.find('.checkout-mini-cart .minishipment .header a').hide();
      summary.find('.order-totals-table .order-shipping .label a').hide();
    });
  }

  // updates thePAyment panel after coupon 0 out or gift card

  function updatePaymentPanel() {
    var url = app.util.appendParamsToUrl(app.util.getPipeUrl('COBilling-RefreshPaymentMethods'), {countryCode: 'US'});
    var summary = $("#payment-methode-container");

    // indicate progress

    app.progress.show(summary);

    // load the updated summary area

    summary.load( url, function () {

      //need to rebind events in #payment-methode-container
      initializeCache();
      initializeEvents();
      
      // hide edit shipping method link
      summary.fadeIn("fast");
      
    });
  }

  /**
   * @function
   * @description selects a shipping method for the default shipment and updates the summary section on the right hand side
   * @param  
   */
  function selectShippingMethod(shippingMethodID) {
    // nothing entered
    if(!shippingMethodID) {
      return;
    }

    // Change $cache.stateCode
    $cache.stateCode = $cache.checkoutForm.find(".state-field");

    // attempt to set shipping method
    var url = app.util.appendParamsToUrl(app.util.getPipeUrlSecure('COShipping-SelectShippingMethod'),
        { address1:$cache.address1.val(),
      address2:$cache.address2.val(),
      countryCode:$cache.countryCode.val(),
      stateCode:$cache.stateCode.val(),
      postalCode:$cache.postalCode.val(),
      city:$cache.city.val(),
      shippingMethodID:shippingMethodID
        }, true);

    app.ajax.getJson({
      url: url,
      callback: function (data) {
        updateSummary();
        if(!data || !data.shippingMethodID) {
          window.alert("Couldn't select shipping method.");
          return false;
        }
        // display promotion in UI and update the summary section,
        // if some promotions were applied
        $(".shippingpromotions").empty();
        if(data.shippingPriceAdjustments && data.shippingPriceAdjustments.length > 0) {
          var i,len=data.shippingPriceAdjustments.length;
          for(i=0; i<len; i++) {
            var spa = data.shippingPriceAdjustments[i];
          }
        }
      }
    });
  }

  /**
   * @function
   * @description Make an AJAX request to the server to retrieve the list of applicable shipping methods
   * based on the merchandise in the cart and the currently entered shipping address
   * (the address may be only partially entered).  If the list of applicable shipping methods
   * has changed because new address information has been entered, then issue another AJAX
   * request which updates the currently selected shipping method (if needed) and also updates
   * the UI.
   */
  function updateShippingMethodList() {
    if (!$cache.shippingMethodList || $cache.shippingMethodList.length === 0) { return; }
    var url = getShippingMethodURL(app.util.getPipeUrlSecure('COShipping-GetApplicableShippingMethodsJSON'));

    app.ajax.getJson({
      url: url,
      callback: function (data) {
        if(!data) {
          //NS -- Need to revist commented out to prevent pop up on certain conditions
          //window.alert("Couldn't get list of applicable shipping methods.");
          return false;
        }
        if (shippingMethods && shippingMethods.toString() === data.toString())
        {
          // No need to update the UI.  The list has not changed.
          return true;
        }

        // We need to update the UI.  The list has changed.
        // Cache the array of returned shipping methods.
        shippingMethods = data;

        var smlUrl = getShippingMethodURL(app.util.getPipeUrlSecure('COShipping-UpdateShippingMethodList'));

        // indicate progress
        app.progress.show($cache.shippingMethodList);

        // load the shipping method form
        $cache.shippingMethodList.load( smlUrl, function () {
          $cache.shippingMethodList.fadeIn("fast");
          // rebind the radio buttons onclick function to a handler.
          $cache.shippingMethodList.find("[name$='_shippingMethodID']").click(function () {
            selectShippingMethod($(this).val());
          });

          // update the summary
          updateSummary();
          app.progress.hide();
        });
      }
    });
  }

  //shipping page logic
  //checkout gift message counter
  /**
   * @function
   * @description Initializes gift message box, if shipment is gift 
   */ 
  function initGiftMessageBox() {
    // show gift message box, if shipment is gift

    var isGiftCheck = $cache.checkoutForm.find("#is-gift-yes")[0];

    if(isGiftCheck !== undefined) {
      $cache.giftMessage.toggle(isGiftCheck.checked);
    }

  }
  /**
   * @function
   * @description Initializes gift message box for multiship shipping, the message box starts off as hidden and this will display it if the radio button is checked to yes, also added event handler to listen for when a radio button is pressed to display the message box
   */ 
  function initMultiGiftMessageBox() {
    $.each( $("table.item-list"), function() {

      //handle initial load
      if($(this).find(".js-isgiftyes").is(':checked')){
        $(this).find(".gift-message-text").css('display','block');
      }

      //set event listeners
      $(this).bind('change', function() {
        if($(this).find(".js-isgiftyes").is(':checked')){
          $(this).find(".gift-message-text").css('display','block');
        }else if($(this).find(".js-isgiftno").is(':checked')){
          $(this).find(".gift-message-text").css('display','none');
        }
      });

    });
  } 
  /**
   * @function
   * @description this function inits the form so that uses client side validation before submitting to the server
   */  
  function initmultishipshipaddress() {
    //init the continue button as disabled
    var selectvalue = [];
    $(this).removeClass('error');
    $("select option:selected").each(function () {
      selectvalue.push(this.value);
    });

    //if we found a empty value disable the button
    if(selectvalue.indexOf('') == -1) {
      $('.formactions button').removeAttr('disabled');
    } else {
      $('.formactions button').attr('disabled','disabled');
    }
  }

  function shippingLoad() {
    
    // Hide is gift wrap on load
    $('.is-gift-wrap').css('display', 'none');
        
    $('.gift-wrap').on("click", "#is-gift-yes, #is-gift-no", function (e) {
        $(this).prop("checked", true);
        $(this).siblings('input').prop("checked", false);
        if ($('#is-gift-yes').is(':checked')) {
            $cache.checkoutForm.find(".gift-message-text").show();
            $('#is-gift-wrap-yes').prop("checked", true);
            $('#is-gift-wrap-no').prop("checked", false);
        } else {
            $cache.checkoutForm.find(".gift-message-text").hide();
            $('#is-gift-wrap-no').prop("checked", true);
            $('#is-gift-wrap-yes').prop("checked", false);
        }
    })
    .on("click", "#is-gift-wrap-yes, #is-gift-wrap-no", function (e) {
      $(this).prop("checked", true);
        $(this).siblings('input').prop("checked", false);
      $cache.checkoutForm.find(".gift-wrap-branded").slideToggle($cache.checkoutForm.find("#is-gift-wrap-yes")[0].checked);
    })
    .on("click", "#is-gift-wrap-branded-yes, #is-gift-wrap-branded-no", function() {
        $(this).prop("checked", true);
        $(this).siblings('input').prop("checked", false);
        if ($cache.checkoutForm.find('#is-gift-wrap-branded-yes').prop("checked")) {
          if ($cache.checkoutForm.find('.is-gift-wrap-branded-yes').hasClass("hidden")) {
            $cache.checkoutForm.find('.gift-wrap-branded-img img').toggleClass("hidden");
          }
        } else if ($cache.checkoutForm.find('#is-gift-wrap-branded-no').prop("checked")) {
          if ($cache.checkoutForm.find('.is-gift-wrap-branded-no').hasClass("hidden")) {
            $cache.checkoutForm.find('.gift-wrap-branded-img img').toggleClass("hidden");
          }
        }
    });
    
    $cache.checkoutForm.on("change",
        "input[name$='_addressFields_address1'], input[name$='_addressFields_address2'], select[name$='_addressFields_countries_country'], select[name$='_addressFields_states_state'], input[name$='_addressFields_states_state'], input[name$='_addressFields_city'], input[name$='_addressFields_zip']",
        updateShippingMethodList
    );
    
    $cache.checkoutForm.on("submit", function(e) {
      //remove Emoji characters from input
      try {
        $cache.checkoutForm.find('textarea[data-character-limit]').val( app.util.removeEmojiChars( $cache.checkoutForm.find('textarea[data-character-limit]').val() ) );
      } catch (err) {
        //alert(err);
      }
    });

    // gift message character limitation
    initGiftMessageBox();
    updateShippingMethodList();

    // Forces country to trigger states and provinces list on load 
    $("select[name$='_addressFields_countries_country']").trigger('change');

    if (app.authenticated && app.location.state !== undefined && app.location.state !== '') {
      app.currentShippingStateCode = app.location.state;
    }
    
    if (app.currentShippingStateCode !== undefined) {
      if ($("select[name$='_addressFields_states_state']").length) {
        $("select[name$='_addressFields_states_state']").val(app.currentShippingStateCode);
        $("select[name$='_addressFields_states_state']").find('option[value="' + app.currentShippingStateCode + '"]').prop('selected', true);
      } else {
        $("input[name$='_addressFields_states_state']").val(app.currentShippingStateCode);
      }
    }
    return null;
  }
  /**
   * @function
   * @description Selects the first address from the list of addresses
   */
  function addressLoad() {
    
    // select address from list
    $("#wrapper").on("change", ".select-address select[id$='_addressList']", function () {
      var that = $(this),
          selected = that.children(":selected").first();
      
      loadAddresses(selected);
      app.util.selectFieldChange(that);
    });
    
    $cache.addressList.trigger('change');
        
    // loads in first set of addresses
  
      if (isShipping) {
        loadAddresses($cache.addressList.find('option:nth-child(2)').first());
      }
    
    // Change $cache.stateCode
    $cache.stateCode = $cache.checkoutForm.find(".state-field");
    
    // update state options in case the country changes
    $cache.countryCode.on("change", function() {
      app.util.updateStateOptions(this);  
    }).on("focus", function() {
      
      // grabbing value to store it for later
      if ($cache.checkoutForm.find("select[id$='_state']").length) {
        var country = $(this).find('option:selected').val();
        app.ui[country] = $cache.stateCode.find('option:selected').val();     
      } else {
        var country = $(this).val();
        app.ui[country] = $cache.stateCode.val();
      }
    });
  }
    
  function loadAddresses(selected) {    
    var data = $(selected).data("address");
    if (!data) { return; }
    if (app.constants.qas_enabled === true && isShipping) {
      jQuery("input[name$='shippingAddress_addressFields_zip']:first,input[name$='shippingAddress_addressFields_houseNumber']:first,input[name$='shippingAddress_addressFields_streetName']:first,#findaddressbutton").parent(".form-row").remove();
      jQuery("#findaddressbutton,#enter_address_link,.dotted-line").remove();
      jQuery("#QAS_form").load(app.util.getPipeUrl('COShipping-QASForm'), function() {
        initializeCache();
        populateForm();
        jQuery("#QAS_form").slideDown("50000"); 
      });       
    } else {
      populateForm();
    }
    
    function populateForm() {
      var p;
      for (p in data) {
        
        if ($cache[p] && data[p] !== undefined) {
          
          // Handle empty address field
          if (data[p] === null) {
            data[p] = "";
          }
          
          $cache[p].val(data[p].replace("^","'"));
          
          // special handling for countrycode => stateCode combo            
          if ($cache[p]===$cache.countryCode) {
                    
            app.util.updateStateOptions($cache[p]);
            
            // Change $cache.stateCode
            $cache.stateCode = $cache.checkoutForm.find(".state-field");
        
            $cache.stateCode.val(data.stateCode);
            $cache.stateCode.trigger("change");
          } else {
            updateShippingMethodList();
          }
        }
      }

      // re-validate the form
      $cache.checkoutForm.validate().form();
    }
  }

  /**
   * @function
   * @description shows gift message box in multiship, and if the page is the multi shipping address page it will call initmultishipshipaddress() to initialize the form 
   */
  function multishippingLoad() {
    initMultiGiftMessageBox();
    if($(".cart-row .shippingaddress select.selectbox").length>0){
      initmultishipshipaddress();
    }
    return null;
  } 

  /**
   * @function
   * @description Changes the payment method form depending on the passed paymentMethodID
   * @param {String} paymentMethodID the ID of the payment method, to which the payment method form should be changed to    
   */
  function changePaymentMethod(paymentMethodID) {
    $cache.paymentMethods.removeClass("payment-method-expanded");
    var pmc = $cache.paymentMethods.filter("#PaymentMethod_"+paymentMethodID);
    if (pmc.length===0) {
      pmc = $("#PaymentMethod_Custom");
    }
    pmc.addClass("payment-method-expanded");

    $cache.checkoutForm.find("#billing-form").show();
    $cache.checkoutForm.find("#continue-button").show();
    $cache.checkoutForm.find("#whats-next-billing").show();
    $cache.checkoutForm.find("#vme-legend").hide();
    $cache.checkoutForm.find("#PaymentMethod_VISA_VME_Continue").hide();
    $cache.checkoutForm.find("#whats-next-billing-vme").hide();

    // ensure checkbox of payment method is checked
    if($("#is-" + paymentMethodID).length >0)$("#is-" + paymentMethodID)[0].checked = true;

    var bmlForm = $cache.checkoutForm.find("#PaymentMethod_BML");
    bmlForm.find("select[name$='_year']").removeClass("required");
    bmlForm.find("select[name$='_month']").removeClass("required");
    bmlForm.find("select[name$='_day']").removeClass("required");
    bmlForm.find("input[name$='_ssn']").removeClass("required");

    if (paymentMethodID === "BML") {
      var yr = bmlForm.find("select[name$='_year']");
      bmlForm.find("select[name$='_year']").addClass("required");
      bmlForm.find("select[name$='_month']").addClass("required");
      bmlForm.find("select[name$='_day']").addClass("required");
      bmlForm.find("input[name$='_ssn']").addClass("required");
    }

    if (paymentMethodID === "VISA_VME") {
      $cache.checkoutForm.find("#billing-form").hide();
      $cache.checkoutForm.find("#continue-button").hide();
      $cache.checkoutForm.find("#whats-next-billing").hide();
      $cache.checkoutForm.find("#vme-legend").show();
      $cache.checkoutForm.find("#PaymentMethod_VISA_VME_Continue").show();
      $cache.checkoutForm.find('#dwfrm_billing_billingAddress_addToEmailList').prop('checked', false);
      $cache.checkoutForm.find("#whats-next-billing-vme").show();
    }

    // Hide the add to address book checkbox when paypal is selected
    if (paymentMethodID === "PayPal") {
      $("#dwfrm_billing_billingAddress_addToAddressBook").parents(".form-row").hide();
    }
    
    if (paymentMethodID === "CREDIT_CARD") {
      $("#dwfrm_billing_billingAddress_addToAddressBook").parents(".form-row").show();
    }
    
    if (paymentMethodID === "GLOBALBAY_CREDIT") {
      $('.payment-method-options').find('#is-PayPal').parent().hide();
      $('#PaymentMethod_Custom').hide();
      $('.payment-method-options').find('#is-VISA_VME').parent().hide();
      $('#PaymentMethod_VISA_VME, #whats-next-billing-vme').hide();

      // Remove error messaging since sled swipe reloads page
      if ($('span.error').length) {
        $('span.error').each(function() {
          $(this).remove();
        });
      }
    }

    app.validator.init();

  }
  /**
   * @function
   * @description Fills the Credit Card form with the passed data-parameter and clears the former cvn input
   * @param {Object} data The Credit Card data (holder, type, masked number, expiration month/year)
   */
  function setCCFields(data) {
    $cache.ccOwner.val(data.holder);
    $cache.ccType.val(data.type);
    $cache.ccNum.val(data.maskedNumber);
    $cache.ccMonth.val(data.expirationMonth);
    $cache.ccYear.val(data.expirationYear);
    $cache.ccCcv.val("");

    // remove error messages
    $cache.ccContainer.find(".error")
    .toggleClass("error")
    .filter("span").remove();

    $cache.ccContainer.find(".errorlabel").toggleClass("errorlabel");
  }

  /**
   * @function
   * @description Updates the credit card form with the attributes of a given card
   * @param {String} cardID the credit card ID of a given card
   */
  function populateCreditCardForm(cardID) {
    // load card details
    var url = app.util.appendParamToURL(app.util.getPipeUrlSecure('COBilling-SelectCreditCard'), "creditCardUUID", cardID);
    app.ajax.getJson({
      url: url,
      callback: function (data) {
        if(!data) {
          window.alert(app.resources.CC_LOAD_ERROR);
          return false;
        }
        $cache.ccList.data(cardID, data);
        setCCFields(data);
      }
    });
  }

  /**
   * @function
   * @description loads billing address, Gift Certificates, Coupon and Payment methods
   */
  function billingLoad() {
    if( !$cache.paymentMethodId ) return;

    $cache.paymentMethodId.on("click", function () {
      changePaymentMethod($(this).val());

    });

    // Check if the Global Bay Form is present and trigger payment option

    if ($('#PaymentMethod_GLOBALBAY_CREDIT').length) {
      $('#is-GLOBALBAY_CREDIT').trigger('click');
      $('#is-GLOBALBAY_CREDIT').prop('checked', true);
    } else {
      $('.payment-method-options').find('#is-GLOBALBAY_CREDIT').parent().hide();  
    }

    // get selected payment method from payment method form
    var paymentMethodId = $cache.paymentMethodId.filter(":checked");
    changePaymentMethod(paymentMethodId.length===0 ? "CREDIT_CARD" : paymentMethodId.val());

    // select credit card from list
    $cache.ccList.on("change", function () {
      var cardUUID = $(this).val();
      if(!cardUUID) { return; }
      var ccdata = $cache.ccList.data(cardUUID);
      if (ccdata && ccdata.holder) {
        setCCFields(ccdata);
        return;
      }
      populateCreditCardForm(cardUUID);

    });

    // auto select credit card type

    if ($cache.appPaymentCards.length > 0) {

      // run only if enabled via business manager

      var cardType = "";
      $cache.ccNum.on("keyup", function(event) {
        var value = $(this).val().replace(/\D/g, "");

        // for debug == console.log(value);
        //event.preventDefault();

        if (value.match(/^5[1-5]/)) {
          cardType = "MasterCard";
        } else if (value.match(/^(4026|417500|4508|4844|491(3|7))/)) {
          cardType = "VisaElectron";
        } else if (value.match(/^3[47]/)) {
          cardType = "Amex";
        } else if (value.match(/^6011/)) {
          cardType = "Discover";
        } else if (value.match(/^4/) || value.match(/^4\d{12}/)) {
          cardType = "Visa";
        } else if (value.match(/^(5018|5020|5038|6304|6759|676[1-3])/)) {
          cardType = "Maestro";
        } else {
          cardType = null;
          $cache.appPaymentCards.find("li").removeClass("card-off","card-on");
        }

        if (cardType !== null) {

          // reset the options

          $cache.ccType.find("option").prop('selected', false);

          // auto select the proper option

          $cache.ccType.find("option[value='" + cardType +"']").prop('selected',true);

          // apply the new css classes

          $cache.appPaymentCards.find("li").addClass("card-off");
          $cache.appPaymentCards.find("li" + "." + cardType).removeClass("card-off").addClass("card-on");
        } 

        // for debug == console.log(cardType);

      });

    }

    // Forces country to trigger states and provinces list on load
    $("select[name$='_addressFields_countries_country']").trigger('change');

    if (app.currentBillingStateCode !== undefined) {
      if ($("select[name$='_addressFields_states_state']").length) {
        $("select[name$='_addressFields_states_state']").val(app.currentBillingStateCode);
        $("select[name$='_addressFields_states_state']").find('option[value="' + app.currentBillingStateCode + '"]').prop('selected', true);
      } else {
        $("input[name$='_addressFields_states_state']").val(app.currentBillingStateCode);
      }
    }

    /* handle whole form submit (bind click to continue checkout button)
     * append form fields of current payment form to this submit
     * in order to validate the payment method form inputs too
     */

    $cache.save.on('click', function (e) {
      // determine if the order total was paid using gift cert or a promotion
      if ($("#noPaymentNeeded").length > 0 && $(".giftcertpi").length > 0) {
        // as a safety precaution, uncheck any existing payment methods
        $cache.paymentMethodId.filter(":checked").removeProp("checked");
        // add selected radio button with gift card payment method
        $("<input/>").attr({
          name:$cache.paymentMethodId.first().attr("name"),
          type:"radio",
          checked:"checked",
          value:app.constants.PI_METHOD_GIFT_CERTIFICATE}).appendTo($cache.checkoutForm);
      }

      var tc = $cache.checkoutForm.find("input[name$='bml_termsandconditions']");
      if ($cache.paymentMethodId.filter(":checked").val()==="BML" && !$cache.checkoutForm.find("input[name$='bml_termsandconditions']")[0].checked) {
        alert(app.resources.BML_AGREE_TO_TERMS);
        return false;
      }

    });

    $cache.gcCheckBalance.on("click", function (e) {
      e.preventDefault();
      app.getgiftcardbalance.checkBalance($cache.checkoutForm,'_giftCertCode', '_giftCardCvd');
    });
    
    // ADD COUPONS ON BILLING PAGE

    $cache.addCoupon.off("click").on("click", function(e){
      e.preventDefault();
      
      $cache.couponCode = $cache.couponCode || $cache.checkoutForm.find("input[name$='_couponCode']");
      $cache.redemption = $cache.redemption || $(".couponcert-code").find("div.redemption.coupon");
      
      var val = $cache.couponCode.val();
      if (val.length===0) {
        var error = $cache.redemption.find("span.error");
        if (error.length===0) {
          error = $("<span>").addClass("error").appendTo($cache.redemption);
        }
        error.html(app.resources.COUPON_CODE_MISSING);
        return;
      }
      
      var url = app.util.appendParamsToUrl(app.util.getPipeUrlSecure('Cart-AddCoupon'), {couponCode:val,format:"ajax"});

      if (val.length===0) { 
        error = $cache.redemption.find("span.error");
        if (error.length===0) {
          $cache.redemption.html('<span class="error" />');
          error = $cache.redemption.find("span.error");
        }
        error.html(app.resources.COUPON_CODE_MISSING);
        return;
      }
      
      var getCouponData = $.ajax({
            url : url,
            type : 'GET',
            contentType : 'json',
            dataType : 'json',
            timeout : 8000
      });
      
      getCouponData.done(function(data) {
                
        if (data.status.length) {
          var priceAdjust = data.priceadjust === null ? '-0' : data.priceadjust.toString(),
              currentCoupon = '<ul class="coupon-' + data.uuid  +  '"><li class="item-details">' + '<span class="cart-coupon">Coupon Number: <input class="remove-coupon-val" type="hidden" value="' + data.uuid + '" />' + data.couponcode + '</span><br/>' + '<span class="discount">' + data.promoid + ' (' + priceAdjust.replace('-', '-$') + ')</span>' + '</li>' + '<li class="item-quantity-details">' + '<button class="textbutton button remove-coupon" type="submit" value="Remove" name="dwfrm_billing_deleteCoupon">Remove</button>' + '</li>' + '<li class="item-total">';
          
          if (data.applied) {
            currentCoupon += '<span class="bonus-item">Applied</span></li></ul>';
          } else {
            currentCoupon += '<span class="bonus-item">Not Applied</span></li></ul>';
          }
          
          if ($('#coupon-table').length) {
            $('#coupon-table').append(currentCoupon);
          }

          $cache.redemption.text(data.message);
        } else {
          $cache.redemption.text(data.message);
        }
        
      }).fail(function(data) {
        
        var fail = false,
            msg;
        
        if (!data) {
          msg = app.resources.BAD_RESPONSE;
          fail = true;
        } else if (!data.success) {
          msg = data.message;
          fail = true;
          $cache.redemption.html('<span class="error" />');
        }

        if (fail) {
          error = $cache.redemption.find("span.error");
          error.html(msg);  
          return;
        }
                
      }).always(function(data) {
        
        updateSummary();

        if (data.basketTotal <= 0){
          updatePaymentPanel();
        } 
                
        $cache.removeCoupon = $('.remove-coupon');
        $cache.removeCoupon.off("click").on("click", function(e) {
          e.preventDefault();
          var t = $(this);
          removeCouponClick(t);
        });
        
      });
      
    });

    // INIT LOAD FUNCTIONALITY FOR COUPON REMOVAL
    
    $cache.removeCoupon.off("click").on("click", function(e) {
      e.preventDefault();
      var t = $(this);
      removeCouponClick(t);
    });
    
    // REMOVE COUPONS ON BILLING PAGE

    function removeCouponClick(t) {
      var $this = t;

      $cache.removeCouponCode = $this.parent().parent().find(".cart-coupon .remove-coupon-val");
      $cache.redemption = $cache.redemption || $(".couponcert-code").find("div.redemption.coupon");

      var val = $cache.removeCouponCode.val();
      var url = app.util.appendParamsToUrl(app.util.getPipeUrlSecure('COBilling-RemoveCoupon'), {couponCode: val, format:"ajax"});

      $.ajax({
        type: "POST",
        url: url,
        success: function(data) {         
          $this.parent().parent().remove();
          $('.redemption.coupon').empty();
        },
        error: function() {
          $cache.redemption.html('<span class="error" />');
          var error = $cache.redemption.find("span.error");
          error.html(app.resources.BAD_RESPONSE); 
          return;
        }, 
        complete : function() {
          updateSummary();
          updatePaymentPanel();
        }
      });
    }

    $cache.addGiftCert.on("click", function(e){
      e.preventDefault();
      $cache.giftCertCode = $cache.giftCertCode || $cache.checkoutForm.find("input[name$='_giftCertCode']");
      $cache.giftCertCVD = $cache.giftCertCVD || $cache.checkoutForm.find("input[name$='_giftCardCvd']");
      $cache.redemptiongift = $cache.redemptiongift || $cache.checkoutForm.find("div.redemption.giftcode");
      var val = $cache.giftCertCode.val();
      var valcvd = $cache.giftCertCVD.val();
      $cache.giftCertCVD.removeClass('error').parent().removeClass('error');
      $cache.giftCertCode.removeClass('error').parent().removeClass('error');
      $cache.redemptiongift.find("span.error").remove();
      if (val.length===0 || valcvd.length===0  ) { 
        var error = $cache.redemptiongift.find("span.error");
        if (error.length===0) {
          error = $("<span>").addClass("error").appendTo($cache.redemptiongift);
        }
        error.html(app.resources.GIFT_CERT_INVALID);
        if (val.length===0 ) { 
          $cache.giftCertCode.addClass('error').parent().addClass('error');
        } 
        if (valcvd.length===0 ) { 
          $cache.giftCertCVD.addClass('error').parent().addClass('error');
        }         
        return;
      }

      var url = app.util.appendParamsToUrl(app.util.getPipeUrl('COBilling-RedeemGiftCertificate'), {giftCertificateID:val,giftCertificateCVD:valcvd,format:"ajax"});
      $.getJSON(url, function(data) {
        var fail = false;
        var msg = "";
        if (!data) {
          msg = app.resources.BAD_RESPONSE;
          fail = true;
        } else if (!data.success) {
          msg = data.message;
          
          fail = true;
        }
        
        if (fail) {
          var error = $cache.redemptiongift.find("span.error");
          if (error.length === 0) {
            $("<span>").addClass("error").appendTo($cache.redemptiongift).text(msg);
          }

          error.text(msg);
          return;
        }
        if (data.ordertotal <= 0) {
          $('.payment-method-options, .payment-method-expanded, .checkout-billing legend').remove();
        }

        $cache.redemptiongift.html('');

        for (i=0 ; i<data.value.length; i++ ) {
          $cache.redemptiongift.prepend('<div id="gc-'+data.ID[i]+'" class="success giftcert-pi">'+data.value[i]+' '+ data.text+' ' +data.ID[i].replace(/.(?=.{4})/g, '')+'.<a href="'+data.link[i]+'" class="remove" id="rgc-'+ data.ID[i] +'"><span>'+data.removetext+'</span></a></div>');
        }

        ///$('.payment-method-expanded').append('<input type="hidden" id="noPaymentNeeded" name="noPaymentNeeded" value="true" />');
        //$('.checkout-billing').find("input[name$='_selectedPaymentMethodID']").val(data.paymentmethid)
        updatePaymentPanel();
        updateSummary();
        $('.gift-cert-used').remove();
        $('.checkout-billing .form-row-button:last').before('<div class="gift-cert-used  alert alert-info">'+data.message+'</div>');
      });
    });
  }

  /**
   * @function
   * @description Sets a boolean variable (isShipping) to determine the checkout stage
   */
  function initializeDom() {
    isShipping = $(".checkout-shipping").length > 0;
    isMultiShipping = $(".checkout-multi-shipping").length > 0;
  }

  /**
   * @function
   * @description Initializes the cache of the checkout UI
   */
  function initializeCache() {
    $cache.checkoutForm = $("form.address");
    $cache.addressList = $(".select-address select[id$='_addressList']");
    function initInputFields() {
      $cache.salutation = $cache.checkoutForm.find("select[name$='_salutation']");
      $cache.firstName = $cache.checkoutForm.find("input[name$='_firstName']");
      $cache.lastName = $cache.checkoutForm.find("input[name$='_lastName']");
      $cache.email = $cache.checkoutForm.find("input[name$='_emailAddress']");
      $cache.address1 = $cache.checkoutForm.find("input[name$='_address1']");
      $cache.address2 = $cache.checkoutForm.find("input[name$='_address2']");
      $cache.city = $cache.checkoutForm.find("input[name$='_city']");
      $cache.postalCode = $cache.checkoutForm.find("input[name$='_zip']");
      $cache.phone = $cache.checkoutForm.find("input[name$='_phone']");
      $cache.countryCode = $cache.checkoutForm.find("select[id$='_country']");
      $cache.stateCode = $cache.checkoutForm.find("select[id$='_state']");
    }
    initInputFields();
    
    $cache.addToAddressBook = $cache.checkoutForm.find("input[name$='_addToAddressBook']");
    if ($cache.checkoutForm.hasClass("checkout-shipping")) {
      // shipping only
      $cache.useForBilling = $cache.checkoutForm.find("input[name$='_useAsBillingAddress']");
      $cache.giftMessage = $cache.checkoutForm.find(".gift-message-text");
      $cache.shippingMethodList = $("#shipping-method-list");
      $cache.checkoutForm.find('#shipping-form').on('shipping-form-rendered', function() {
        // initialize input fields cache and refresh then if there is a AJAX-form
        initInputFields();
      });
    }

    if ($cache.checkoutForm.hasClass("checkout-billing")) {
      // billing only
      //$cache.email = $cache.checkoutForm.find("input[name$='_emailAddress']");
      $cache.save = $cache.checkoutForm.find("button[name$='_billing_save']");
      $cache.paymentMethods = $cache.checkoutForm.find("div.payment-method");
      $cache.paymentMethodId = $cache.checkoutForm.find("input[name$='_selectedPaymentMethodID']");
      $cache.ccContainer = $("#PaymentMethod_CREDIT_CARD");
      $cache.ccList = $("#creditCardList");
      $cache.ccOwner = $cache.ccContainer.find("input[name$='creditCard_owner']");
      $cache.ccType = $cache.ccContainer.find("select[name$='_type']");
      $cache.ccNum = $cache.ccContainer.find("input[name$='_number']");
      $cache.ccMonth = $cache.ccContainer.find("[name$='_month']");
      $cache.ccYear = $cache.ccContainer.find("[name$='_year']");
      $cache.ccCcv = $cache.ccContainer.find("input[name$='_cvn']");
      $cache.BMLContainer = $("#PaymentMethod_BML");
      $cache.gcCheckBalance = $("#gc-checkbalance");
      $cache.addCoupon = $("#add-coupon");
      $cache.removeCoupon = $(".remove-coupon");
      $cache.addGiftCert = $("#add-certificate");
      $cache.appPaymentCards = $(".applicable-payment-cards");

    }
  }
  /**
   * @function Initializes the page events depending on the checkout stage (shipping/billing)
   */
  function initializeEvents() {
    $cache.checkoutForm = $("form.address");
    $cache.addressList = $(".select-address select[id$='_addressList']");
    
    addressLoad();
    if (isShipping) {
      shippingLoad();
    }
    else if (isMultiShipping) {
      multishippingLoad();
    }
    else {
      billingLoad();
    }
    
    //if on the order review page and there are products that are not available disable the submit order button
    if ($('.order-summary-footer').length > 0) {
      if ($('.notavailable').length > 0) {
        $('.submit-order button').prop( 'disabled', 'disabled' );
      }
    }
  }

  /******* app.checkout public object ********/
  app.checkout = {
      init : function () {
        initializeCache();
        initializeDom();
        initializeEvents();
      }
  };
}(window.app = window.app || {}, jQuery));


/**
 * @class app.quickview
 */
(function (app, $) {
  var $cache = {};

  /**
   * @function
   * @description Binds a 'click'-event to the quick view button
   */
  function bindQvButton() {
    $cache.qvButton.one("click", function (e) {
      e.preventDefault();
      app.quickView.show({
        url: $(this).attr("href"),
        source: "quickview"
      });
    });
  }

  /**
   * @function loadQuickviewNavigation
   * @description Creates links to navigate category in quickview
   */
  function loadQuickviewNavigation(options, dataPosition) {
    var params = app.util.getQueryStringParams(options.url);
    params.cgid = $("#main").data("category");

    if (!params.cgid) {
      return;
    }

    var url = buildProductNavUrl(app.util.getPipeUrl('Product-Productnav'), params);
    
    var navContainer = $("#product-nav-container");
    var options = {
      quickview: true,
      target: app.quickView.init(),
      source: 'quickview',
      callback: function() {
        app.product.init();
        app.progress.hide();
        loadQuickviewNavigation(options, dataPosition);
      }
    }

    app.ajax.load({
      url: url,
      target: navContainer,
      callback: function() {
        navContainer.find("span.prev").html(app.resources.PREVIOUS_ITEM);
        navContainer.find("span.next").html(app.resources.NEXT_ITEM);

        // bind refresh to nav clicks
        function previousProduct(e) {
          e.preventDefault();

          app.progress.show();

          var params = app.util.getQueryStringParams(navContainer.find(".product-previous a").attr("href").replace("#", "&"));
          params.pid = navContainer.find(".product-previous").data("pid");
          options.url = buildProductNavUrl(app.util.getPipeUrl('Product-Show'), params);
          app.product.get(options);
        }

        function nextProduct(e) {
          e.preventDefault();

          app.progress.show();

          var params = app.util.getQueryStringParams(navContainer.find(".product-next a").attr("href").replace("#", "&"));
          params.pid = navContainer.find(".product-next").data("pid");
          options.url = buildProductNavUrl(app.util.getPipeUrl('Product-Show'), params);
          app.product.get(options);
        }

        // change the products using the left and right arrow keys
        function changeProductsByKey(e) {
          if ($('.quickview').is(':visible')) {
            if (e.which == '37') {
              navContainer.find(".product-previous a").trigger('click');
            } else if (e.which == '39') {
              navContainer.find(".product-next a").trigger('click');
            }
          }
        }

        navContainer.find(".product-previous a").on("click", previousProduct);
        navContainer.find(".product-next a").on("click", nextProduct);
        $('body').off('keydown').on('keydown', changeProductsByKey);
      }
    });

    navContainer.prependTo($(".popup-content"));
  }

  function buildProductNavUrl(host, params) {
    return host + "?pid=" + params.pid + "&cgid=" + params.cgid + "&start=" + params.start + "&" + window.location.hash.substr(1);
  }

  /******* app.quickView public object ********/
  app.quickView = {
    id: "",
    initializeButton: function(container, target) {

      // quick view button
      $(container).on("mouseenter", target, function(e) {
        if (!$cache.qvButton) {
          $cache.qvButton = $("<a id='quickviewbutton'/>");
        }

        bindQvButton();

        var link = $(this).children("a:first");
        var pid = $(this).parent().data('itemid');

        // append start index and pid to url
        var href = app.util.appendParamsToUrl(link.attr("href"), {
          start: $(this).parents(".grid-tile").prevAll(".grid-tile").length + 1,
          pid: pid
        });

        app.quickView.id = pid;
        $cache.qvButton.attr({
          "href": href,
          "title": link.attr("title")
        }).appendTo($(this));
      });
    },

    init: function() {
      return $(".popup-content");
    },

    // show quick view dialog and send request to the server to get the product
    // options.source - source of the dialog i.e. search/cart
    // options.url - product url
    show: function (options) {
      if (!$(".popup").length) {
        app.dialog.create({
          target: $cache.quickView,
          options: {
            classname: 'quickview',
            animateInClass: 'slide-in-down',
            title: 'Product Quickview'
          }
        });
      }

      options.quickview = true;
      options.target = $(".popup-content");
      options.callback = function() {
        app.product.init();

        if ($("#product-nav-container").data('position')) {
          var dataPosition = $("#product-nav-container").data('position');
          loadQuickviewNavigation(options, dataPosition);
        }

        $.dwPopup.init();
      }

      app.product.get(options);

      return $(".popup-content");
    },

    // close the quick view dialog
    close: function() {
      app.dialog.close();
    },

    exists: function() {
      return $('.popup-content') && $('.popup-content').length > 0;
    },

    isActive: function() {
      return $('.popup-content') && $('.popup-content').length > 0;
    },

    container: $('.popup-content')
  }
}(window.app = window.app || {}, jQuery));


/**
 * @class app.util
 */
(function (app, $) {

  // sub namespace app.util.* contains utility functions
  app.util = {
    /**
     * @function
     * @description trims a prefix from a given string, this can be used to trim
     * a certain prefix from DOM element IDs for further processing on the ID 
     */
    trimPrefix : function (str, prefix) {
      return str.substring(prefix.length);
    },
    setDialogify : function (e) {
      e.preventDefault();
      
      var actionSource = $(this),
        dlgAction = $(actionSource).data("dlg-action") || {}, // url, target, isForm
        dlgOptions = $(actionSource).data("dlg-options") || {};
        
      dlgOptions.title = dlgOptions.title || $(actionSource).attr("title") || "";

      var url = dlgAction.url // url from data
            || (dlgAction.isForm ? $(actionSource).closest("form").attr("action") : null) // or url from form action if isForm=true
            || $(actionSource).attr("href"); // or url from href

      if (!url) { return; }

      var form = jQuery(this).parents('form');
      var method = form.attr("method") || "POST";
      
      // if this is a content link, update url from Page-Show to Page-Include
      if ($(this).hasClass("attributecontentlink")) {
        var uri = app.util.getUri(url);
        url = app.urls.pageInclude+uri.query;
      }
      
      if (method && method.toUpperCase() == "POST") {
        var postData = form.serialize() + "&"+ jQuery(this).attr("name") + "=submit";
      } else {
        if (url.indexOf('?') == -1) {
          url += '?';
        } else {
          url += '&';
        }
        
       url += form.serialize();
       url = app.util.appendParamToURL(url, jQuery(this).attr('name'), "submit");
      }
            
      app.ajax.load({
        url: $(actionSource).attr("href") || $(actionSource).closest("form").attr("action"),
        callback: function(response) {     
          $.dwPopup.create(response, dlgOptions); // open after load to ensure dialog is centered
          app.validator.init(); // re-init validator
        },
        data: !$(actionSource).attr("href") ? postData : null
      });
    },
    getPipeUrl : function(piplineName){
      var newurl = app.urls.blank.replace('Replace-This', piplineName);

      return newurl;
    },
    getPipeUrlSecure : function(piplineName){
      var newurl = app.urls.blanks.replace('Replace-This', piplineName);

      return newurl;
    },
    getStaticUrl : function(url) {
      var newurl = app.urls.staticUrl.replace('staticUrl', url);

      return newurl;
    },
    validateMyZip :  function(s) {
      // Check for correct zip code (US and Canada)
      var reZip = new RegExp(/(^\d{5}(-\d{4})?$)|(^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$)/);
      if (!reZip.test(s)) { 
        return app.resources.INVALID_ZIP;
      }

      return true;
    },
    traverseObj : function(obj, path) {
      var arr = path.split('.'),
      len = arr.length,
      i = 0,
      ret;
      for ( ; i<len; i+=1 ) {
        ret = !i ? obj[arr[i]] : ret[arr[i]];
      }
      return ret;
    },
    /**
     * @function
     * @description Appends a character to the left side of a numeric string (normally ' ')
     * @param {String} str the original string
     * @param {String} padChar the character which will be appended to the original string
     * @param {Number} len the length of the end string
     */
    padLeft : function (str, padChar, len) {
      var digs = len || 10;
      var s = str.toString();
      var dif = digs - s.length;
      while(dif > 0) {
        s = padChar + s;
        dif--;
      }
      return s;
    },

    /**
     * @function
     * @description appends the parameter with the given name and value to the given url and returns the changed url
     * @param {String} url the url to which the parameter will be added
     * @param {String} name the name of the parameter
     * @param {String} value the value of the parameter
     */
    appendParamToURL : function (url, name, value) {
      var c = "?";
      if(url.indexOf(c) !== -1) {
        c = "&";
      }
      return url + c + name + "=" + encodeURIComponent(value);
    },
    /** 
     * @function 
     * @description 
     * @param {String} 
     * @param {String} 
     */
    elementInViewport: function (el, offsetToTop) {
      var top = el.offsetTop,
      left = el.offsetLeft,
      width = el.offsetWidth,
      height = el.offsetHeight,
      xOffset = (window.pageXOffset !== undefined) ? window.pageXOffset : (document.documentElement || document.body.parentNode || document.body).scrollLeft,
      yOffset = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop,
      iWidth = window.innerWidth || document. documentElement.clientWidth,
      iHeight = window.innerHeight || document. documentElement.clientHeight;

      while (el.offsetParent) {
        el = el.offsetParent;
        top += el.offsetTop;
        left += el.offsetLeft;
      }

      if (typeof(offsetToTop) != 'undefined') {
        top -= offsetToTop;
      }

      return (
          top < (yOffset + iHeight) &&
          left < (xOffset + iWidth) &&
          (top + height) > yOffset &&
          (left + width) > xOffset
      );
    },
    /**
     * @function
     * @description appends the parameters to the given url and returns the changed url
     * @param {String} url the url to which the parameters will be added
     * @param {String} params a JSON string with the parameters 
     */
    appendParamsToUrl : function (url, params) {
      var uri = app.util.getUri(url),
      includeHash = arguments.length < 3 ? false : arguments[2];

      var qsParams = $.extend(uri.queryParams, params);
      var result = uri.path+"?"+$.param(qsParams);
      if (includeHash) {
        result+=uri.hash;
      }
      if (result.indexOf("http")<0 && result.charAt(0)!=="/") {
        result="/"+result;
      }

      return result;
    },
    /**
     * @function
     * @description removes the parameter with the given name from the given url and returns the changed url
     * @param {String} url the url from which the parameter will be removed
     * @param {String} name the name of the parameter
     */
    removeParamFromURL : function (url, parameter) {
      var urlparts = url.split('?');

      if(urlparts.length >= 2) {
        var urlBase = urlparts.shift();
        var queryString = urlparts.join("?");

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = queryString.split(/[&;]/g);
        var i=pars.length;
        while(0 > i--) {
          if(pars[i].lastIndexOf(prefix, 0) !== -1) {
            pars.splice(i, 1);
          }
        }
        url = urlBase + '?' + pars.join('&');
      }
      return url;
    },

    /**
     * @function
     * @description Returns the static url for a specific relative path 
     * @param {String} path the relative path
     */
    staticUrl : function (path) {
      if(!path || $.trim(path).length === 0) {
        return app.urls.staticPath;
      }

      return app.urls.staticPath + (path.charAt(0) === "/" ? path.substr(1) : path );
    },
    /**
     * @function
     * @description Appends the parameter 'format=ajax' to a given path   
     * @param {String} path the relative path
     */
    ajaxUrl : function (path) {
      return app.util.appendParamToURL(path, "format", "ajax");
    },

    /**
     * @function
     * @description 
     * @param {String} url
     */
    toAbsoluteUrl : function (url) {
      if (url.indexOf("http")!==0 && url.charAt(0)!=="/") {
        url = "/"+url;
      }
      return url;
    },
    /**
     * @function
     * @description Loads css dynamically from given urls
     * @param {Array} urls Array of urls from which css will be dynamically loaded.   
     */
    loadDynamicCss : function (urls) {
      var i, len=urls.length;
      for(i=0; i < len; i++) {
        app.util.loadedCssFiles.push(app.util.loadCssFile(urls[i]));
      }
    },

    /**
     * @function
     * @description Loads css file dynamically from given url
     * @param {String} url The url from which css file will be dynamically loaded.   
     */
    loadCssFile : function (url) {
      return $("<link/>").appendTo($("head")).attr({
        type : "text/css",
        rel : "stylesheet"
      }).attr("href", url); // for i.e. <9, href must be added after link has been appended to head
    },
    // array to keep track of the dynamically loaded CSS files
    loadedCssFiles : [],

    /**
     * @function
     * @description Removes all css files which were dynamically loaded   
     */
    clearDynamicCss : function () {
      var i = app.util.loadedCssFiles.length;
      while(0 > i--) {
        $(app.util.loadedCssFiles[i]).remove();
      }
      app.util.loadedCssFiles = [];
    },
    /**
     * @function
     * @description Extracts all parameters from a given query string into an object
     * @param {String} qs The query string from which the parameters will be extracted
     */
    getQueryStringParams : function (qs) {
      if(!qs || qs.length === 0) { return {}; }

      var params = {}, unescapedQS = unescape(qs);
      // Use the String::replace method to iterate over each
      // name-value pair in the string.
      unescapedQS.replace( new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
          function ( $0, $1, $2, $3 ) { params[ $1 ] = $3; }
      );
      return params;
    },
    /**
     * @function
     * @description Returns an URI-Object from a given element with the following properties:<br/>
     * <p>protocol</p>
     * <p>host</p>
     * <p>hostname</p>
     * <p>port</p>
     * <p>path</p>
     * <p>query</p>
     * <p>queryParams</p>
     * <p>hash</p>
     * <p>url</p>
     * <p>urlWithQuery</p>
     * @param {Object} o The HTML-Element
     */
    getUri : function (o) {
      var a;
      if (o.tagName && $(o).attr("href")) {
        a = o;
      }
      else if (typeof o === "string") {
        a = document.createElement("a");
        a.href = o;
      }
      else {
        return null;
      }

      return {
        protocol : a.protocol, //http:
        host : a.host, //www.myexample.com
        hostname : a.hostname, //www.myexample.com'
        port : a.port, //:80
        path : a.pathname, // /sub1/sub2
        query : a.search, // ?param1=val1&param2=val2
        queryParams : a.search.length > 1 ? app.util.getQueryStringParams(a.search.substr(1)) : {},
            hash : a.hash, // #OU812,5150
            url : a.protocol+ "//" + a.host + a.pathname,
            urlWithQuery : a.protocol+ "//" + a.host + a.port + a.pathname + a.search
      };
    },
    /**
     * @function
     * @description Appends a form-element with given arguments to a body-element and submits it
     * @param {Object} args The arguments which will be attached to the form-element:<br/>
     * <p>url</p>
     * <p>fields - an Object containing the query-string parameters</p>   
     */
    postForm : function (args) {
      var form = $("<form>").attr({action:args.url,method:"post"}).appendTo("body");
      var p;
      for (p in args.fields) {
        $("<input>").attr({name:p,value:args.fields[p]}).appendTo(form);
      }
      form.submit();
    },
    /**
     * @function
     * @description  Returns a JSON-Structure of a specific key-value pair from a given resource bundle
     * @param {String} key The key in a given Resource bundle
     * @param {String} bundleName The resource bundle name 
     * @param {Object} A callback function to be called 
     */
    getMessage : function (key, bundleName, callback) {
      if (!callback || !key || key.length===0) {
        return;
      }
      var params = {key:key};
      if (bundleName && bundleName.length===0) {
        params.bn = bundleName;
      }
      var url = app.util.appendParamsToUrl(app.util.getPipeUrl('Resources-Load'), params);
      $.getJSON(url, callback);
    },

    // Toggles selected value for select fields

    selectFieldChange : function(that) {
      var $thisSelect = that,
      selectval = $thisSelect.val();
      $thisSelect.find('option').each(function() {
        $(this).prop('selected', false);
      });

      $thisSelect.find('option[value="' + selectval + '"]').prop('selected', true);
      $thisSelect.val(selectval);
      if ($thisSelect.val() !== "") {
        var parentSelect = $thisSelect.parent();
        parentSelect.removeClass('error');
        $thisSelect.removeClass('error');
        parentSelect.find('.form-caption.error-message,.error').remove();
      }
    },
    /**
     * @function
     * @description Updates the states options to a given country
     * @param {String} countrySelect The selected country
     */
    updateStateOptions : function(countrySelect, statetoselect) {
      var country = $(countrySelect),
      form = country.closest("form"),
      zipinput = form.find("input[name$='_zip']"),
      labelSpanzip = form.find("label[for$='_zip'] .label-value");

      if (country.val() === "US") {
        labelSpanzip.html(app.resources.ZIP_CODE);
      } else {
        labelSpanzip.html(app.resources.POSTAL_CODE);
      }

      var form = country.closest("form"),
      c = app.countries[country.val()],
      arrHtml = [];

      if (c !== undefined && Object.keys(c.regions).length) {

        // Build up select field for states

        var selectOption = '<option class="select-option" label="' + app.resources.FORM_SELECT + '" value="">' + app.resources.FORM_SELECT + '</option>';

        $('.state-field').replaceWith(
            '<select class="input-select autoselect state-field form-control required" id="' + app.pCurrentStateForm + '" name="' + app.pCurrentStateForm + '">' + selectOption + '</select>'
        );

        $('.state-field').html(selectOption);

        // Cache and setup first select option Select...

        var $stateField = $('.state-field'),
        o1 = $stateField.find('option:first').clone(),
        requiredHtml = '<span class="required-indicator">' + app.resources.REQUIRED_STARICON + '</span>';

        $stateField.parent().find('.required-indicator').remove();
        $stateField.parent().find('label').prepend(requiredHtml);
        $stateField.parent().find('label .optional').remove();

        $stateField.find('option').remove();
        arrHtml.push(o1);

        // Build up all state options

        var s;
        for (s in c.regions) {
          if (s == statetoselect){
            arrHtml.push('<option selected="true" value="'+s+'">'+c.regions[s]+'</option>');
          }else{
            arrHtml.push('<option value="'+s+'">'+c.regions[s]+'</option>');
          }
        }

        // Set select html with options array

        $stateField.html(arrHtml);

        // Initialize change events for state select dropdowns

        $stateField.on('change', function() {
          var that = $(this);
          app.util.selectFieldChange(that);
        });

        $stateField.parent('.form-row').find('span.error').remove();

      } else {

        // Build up input field for state
        $('.state-field').replaceWith('<input class="input-text autoselect state-field form-control" id="' + app.pCurrentStateForm + '" name="' + app.pCurrentStateForm + '" value="" type="text" autocomplete="on" />');

        var $stateField = $('.state-field'),
        requiredHtml = '<span class="required-indicator">' + app.resources.REQUIRED_STARICON + '</span>',
        optionalHtml = '<span class="optional">(' + app.resources.FORM_OPTIONAL + ')</span>';

        if (c !== undefined && c.mandatory === true) {
          $stateField.addClass('required');
          $stateField.parent().addClass('required');
          $stateField.parent().find('.required-indicator').remove();
          $stateField.parent().find('label').prepend(requiredHtml);
          $stateField.removeClass('valid');
          $stateField.parent().find('label .optional').remove();
        } else {
          $stateField.removeClass('required');
          $stateField.parent().removeClass('required');
          $stateField.parent().find('.required-indicator').remove();
          $stateField.parent().find('label .optional').remove();
          $stateField.parent().find('label').append(optionalHtml);
        }
        $stateField.parent('.form-row').find('span.error').remove();
      }

      // Change state label based on selections

      var labelSpan = form.find("label[for$='_states_state'] span.label-value").not(".required-indicator");

      if (c !== undefined) {
        labelSpan.html(c.label);
      } else {
        labelSpan.html(app.resources.STATE_ALL);
      }

      country.on('change', function() {
        var that = $(this);
        app.util.selectFieldChange(that);
      });

      var statestate = form.find(".state-field");

      if (app.ui !== undefined && app.ui[country.val()] !== "" && app.ui[country.val()] !== undefined) {
        statestate.val(app.ui[country.val()]);
      }
      
      if (app.util.validateMyZip(zipinput.val()) && app.constants.processZipOnStateUpdate) {
        zipinput.removeClass('error').parent().find('.error').remove();
      }
    },
    /**
     * @function
     * @description Updates the number of the remaining character 
     * based on the character limit in a text area  
     */
    limitCharacters : function () {
      $('form').find('textarea[data-character-limit]').each(function() {
        var characterLimit = $(this).data("character-limit");
        var charCountHtml = String.format(app.resources.CHAR_LIMIT_MSG,
            '<span class="char-remain-count">'+characterLimit+'</span>',
            '<span class="char-allowed-count">'+characterLimit+'</span>');
        var charCountContainer = $(this).next('div.char-count');
        if (charCountContainer.length===0) {
          charCountContainer = $('<div class="char-count"/>').insertAfter($(this));
        }
        charCountContainer.html(charCountHtml);
        // trigger the keydown event so that any existing character data is calculated
        $(this).change();
      });
    },
    /**
     * @function
     * @description Binds the onclick-event to a delete button on a given container, 
     * which opens a confirmation box with a given message  
     * @param {String} container The name of element to which the function will be bind
     * @param {String} message The message the will be shown upon a click 
     */
    setDeleteConfirmation : function(container, message) {
      $(container).on("click", ".delete", function(e){
        return confirm(message);
      });
    },
    /**
     * @function
     * @description Scrolls a browser window to a given x point
     * @param {String} The x coordinate 
     */
    scrollBrowser : function (xLocation) {
      $('html, body').animate({ scrollTop: xLocation }, 500);
    },

    removeEmojiChars : function (str) {
      return str.replace(/(\u00AE|\u00A9|[\uE000-\uF8FF]|[\u2000-\u2FFF]|\uD83C[\uDE00-\uDFFF]|\uD83D[\uDC00-\uDDFF]|\uD83D[\uDE00-\uDEFF]|(\uD83C.*){2})/g, '');
    },
    
    briteverifyEmailAddress : function(address) {
      var isValid = true;
      
      try {
        $.ajax({
          url: app.util.getPipeUrl('EmailOptIn-VerifyJson') + "?email=" + $.trim(address),
          dataType: "json",
          async: false,
          success: function(data) {
            
            if (data) {
              isValid = data.valid;
            } else {
              isValid = true;
            }
          }
        });
      } catch(e) {
        //console.log(e);
      }
      
      return isValid;
    }
  };
} (window.app = window.app || {}, jQuery));

/**
 * @class app.page
 */
(function (app, $) {
  app.page = {
    title : "",
    type : "",
    setContext : function(o) {
      $.extend(app.page, o);
    },
    params : app.util.getQueryStringParams(window.location.search.substr(1)),
    redirect : function(newURL) {
      var t = setTimeout(function() {
        window.location.href = newURL;
      }, 0);
    },
    refresh : function() {
      var t = setTimeout(function() {
        window.location.assign(window.location.href);
      }, 500);
    }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.registry
 */
(function (app, $) {
  var $cache = {};
  /**
   * @function
   * @description Loads address details to a given address and fills the "Pre-Event-Shipping" address form
   * @param {String} addressID The ID of the address to which data will be loaded
   */
  function populateBeforeAddressForm(addressID) {
    // load address details
    var url = app.util.getPipeUrlSecure('Address-GetAddressDetails?addressID=') + addressID;
    app.ajax.getJson({
      url: url,
      callback: function (data) {
        if(!data || !data.address) {
          window.alert(app.resources.REG_ADDR_ERROR);
          return false;
        }
        // fill the form
        $cache.addressBeforeFields.filter("[name$='_addressid']").val(data.address.ID);
        $cache.addressAfterFields.filter("[name$='_salutation']").val(data.address.salutation.salutation);
        $cache.addressBeforeFields.filter("[name$='_firstname']").val(data.address.firstName);
        $cache.addressBeforeFields.filter("[name$='_lastname']").val(data.address.lastName);
        $cache.addressBeforeFields.filter("[name$='_address1']").val(data.address.address1);
        $cache.addressBeforeFields.filter("[name$='_address2']").val(data.address.address2);
        $cache.addressBeforeFields.filter("[name$='_city']").val(data.address.city);
        $cache.addressBeforeFields.filter("[name$='_zip']").val(data.address.postalCode);
        $cache.addressBeforeFields.filter("[name$='_state']").val(data.address.stateCode);
        $cache.addressBeforeFields.filter("[name$='_country']").val(data.address.countryCode);
        $cache.addressBeforeFields.filter("[name$='_phone']").val(data.address.phone);
        $cache.registryForm.validate().form();
      }
    });
  }

  /**
   * @function
   * @description Loads address details to a given address and fills the "Post-Event-Shipping" address form
   * @param {String} addressID The ID of the address to which data will be loaded
   */
  function populateAfterAddressForm(addressID) {
    // load address details
    var url = app.util.getPipeUrlSecure('Address-GetAddressDetails?addressID=') + addressID;
    app.ajax.getJson({
      url: url,
      callback: function (data) {
        if(!data || !data.address) {
          window.alert(app.resources.REG_ADDR_ERROR);
          return false;
        }
        // fill the form
        $cache.addressAfterFields.filter("[name$='_addressid']").val(data.address.ID);
        $cache.addressAfterFields.filter("[name$='_salutation']").val(data.address.salutation.salutation);
        $cache.addressAfterFields.filter("[name$='_firstname']").val(data.address.firstName);       
        $cache.addressAfterFields.filter("[name$='_lastname']").val(data.address.lastName);
        $cache.addressAfterFields.filter("[name$='_address1']").val(data.address.address1);
        $cache.addressAfterFields.filter("[name$='_address2']").val(data.address.address2);
        $cache.addressAfterFields.filter("[name$='_city']").val(data.address.city);
        $cache.addressAfterFields.filter("[name$='_zip']").val(data.address.postalCode);
        $cache.addressAfterFields.filter("[name$='_state']").val(data.address.stateCode);
        $cache.addressAfterFields.filter("[name$='_country']").val(data.address.countryCode);
        $cache.addressAfterFields.filter("[name$='_phone']").val(data.address.phone);
        $cache.registryForm.validate().form();
      }
    });
  }
  /**
   * @function
   * @description copy pre-event address fields to post-event address fields
   */
  function copyBeforeAddress() {
    $cache.addressBeforeFields.each(function () {
      var fieldName = $(this).attr("name");
      var afterField = $cache.addressAfterFields.filter("[name='"+fieldName.replace("Before","After")+"']");
      afterField.val($(this).val());
    });
  }

  /**
   * @function
   * @description Disables or enables the post-event address fields depending on a given boolean
   * @param {Boolean} disabled True to disable; False to enables 
   */
  function setAfterAddressDisabled(disabled) {
    if (disabled) {
      $cache.addressAfterFields.attr("disabled", "disabled");
    }
    else {
      $cache.addressAfterFields.removeAttr("disabled");
    }
  }
  /**
   * @private
   * @function
   * @description Cache initialization of the gift registration 
   */
  function initializeCache() {
    $cache = {
        registryForm : $("form[name$='_giftregistry']"),
        registryItemsTable : $("form[name$='_giftregistry_items']"),
        registryTable : $("#registry-results")
    };
    $cache.copyAddress = $cache.registryForm.find("input[name$='_copyAddress']");
    $cache.addressBeforeFields = $cache.registryForm.find("fieldset[name='address-before'] input:not(:checkbox), fieldset[name='address-before'] select");
    $cache.addressAfterFields = $cache.registryForm.find("fieldset[name='address-after'] input:not(:checkbox), fieldset[name='address-after'] select");
  }
  /**
   * @private
   * @function
   * @description DOM-Object initialization of the gift registration 
   */
  function initializeDom() {
    $cache.addressBeforeFields.filter("[name$='_country']").data("stateField", $cache.addressBeforeFields.filter("[name$='_state']"));
    $cache.addressAfterFields.filter("[name$='_country']").data("stateField", $cache.addressAfterFields.filter("[name$='_state']"));

    if ($cache.copyAddress.length && $cache.copyAddress[0].checked) {
      // fill the address after fields
      copyBeforeAddress();
      setAfterAddressDisabled(true);
    }
  }
  /**
   * @private
   * @function
   * @description Initializes events for the gift registration
   */
  function initializeEvents() {
    app.sendToFriend.initializeDialog("div.list-table-header", ".send-to-friend");
    app.util.setDeleteConfirmation("table.item-list", String.format(app.resources.CONFIRM_DELETE, app.resources.TITLE_GIFTREGISTRY));

    $cache.copyAddress.on("click", function () {
      if (this.checked) {
        // fill the address after fields
        copyBeforeAddress();
      }
    });
    $cache.registryForm.on("change", "select[name$='_addressBeforeList']", function (e) {
      var addressID = $(this).val();
      if (addressID.length===0) { return; }
      populateBeforeAddressForm(addressID);
      if ($cache.copyAddress[0].checked) {
        copyBeforeAddress();
      }
    })
    .on("change", "select[name$='_addressAfterList']", function (e) {
      var addressID = $(this).val();
      if (addressID.length===0) { return; }
      populateAfterAddressForm(addressID);
    })
    .on("change", $cache.addressBeforeFields.filter(":not([name$='_country'])"), function (e) {
      if (!$cache.copyAddress[0].checked) { return; }
      copyBeforeAddress();
    });


    $("form").on("change", "select[name$='_country']", function(e) {
      app.util.updateStateOptions(this);

      if ($cache.copyAddress.length > 0 && $cache.copyAddress[0].checked && this.id.indexOf("_addressBefore") > 0) {
        copyBeforeAddress();
        $cache.addressAfterFields.filter("[name$='_country']").trigger("change");
      }
    });

    $("select[name$='_country']").trigger('change');

    $cache.registryItemsTable.on("click", ".item-details a", function (e) {
      e.preventDefault();
      var productListID = $('input[name=productListID]').val();
      app.quickView.show({
        url : e.target.href,
        source : "giftregistry",
        productlistid : productListID
      });
    });
  }

  /******* app.registry public object ********/
  app.registry = {
      init : function () {
        initializeCache();
        initializeDom();
        initializeEvents();
        app.product.initAddToCart();

      }

  };

}(window.app = window.app || {}, jQuery));

/**
 * @class app.progress
 */
(function (app, $) {
  var loader;
  app.progress = {
      /**
       * @function
       * @description Shows an AJAX-loader on top of a given container
       * @param {Element} container The Element on top of which the AJAX-Loader will be shown
       */ 
      show: function (container) {
        var target = (!container || $(container).length===0) ? $("body") : $(container);
        loader = loader || $(".loader");

        if (loader.length===0) {
          loader = $("<div/>").addClass("loader")
          .append($("<div/>").addClass("loader-indicator"), $("<div/>").addClass("loader-bg"));

        }
        return loader.appendTo(target).show();
        target.css({"border-color": "#C1E0FF", "border-width":"1px", "border-style":"solid"});
      },
      /**
       * @function
       * @description Hides an AJAX-loader
       */   
      hide: function () {
        if (loader) { loader.hide(); }
      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.components
 */
(function (app, dw, $) {
  /**
   * @function
   * @description capture recommendation of each product when it becomes visible in the carousel
   * @param c TBD
   * @param {Element} li The visible product element in the carousel
   * @param index TBD
   * @param state TBD 
   */
  function captureCarouselRecommendations(c, li, index, state) {
    if (!dw) { return; }

    $(li).find(".capture-product-id").each(function () {
      dw.ac.capture({
        id : $(this).text(),
        type : dw.ac.EV_PRD_RECOMMENDATION
      });
    });
  }

  /******* app.components public object ********/
  app.components = {
      carouselSettings : {
        interval : false
      },
      init : function () {
        setTimeout(function() {
          // renders horizontal/vertical carousels for product slots
          //$('#vertical-carousel').carousel($.extend({vertical : true}, app.components.carouselSettings));
          $('#horizontal-carousel').carousel(app.components.carouselSettings);
        }, 1000);
      }
  };
}(window.app = window.app || {}, window.dw, jQuery));

/**
 * @class app.cart
 */
(function (app, $) {
  var $cache = {};
  /**
   * @private
   * @function
   * @description Updates the cart with new data
   * @param {Object} postdata An Object representing the the new or uptodate data
   * @param {Object} A callback function to be called 
   */
  function updateCart(postdata, callback) {
    var url = app.util.ajaxUrl(app.util.getPipeUrl('Cart-AddProduct'));
    $.post(url, postdata, callback || app.cart.refresh);
  }
  /**
   * @private
   * @function
   * @description Cache initialization of the cart page 
   */
  function initializeCache() {
    $cache = {
        cartTable : $("#cart-table"),
        itemsForm : $("#cart-items-form"),
        addCoupon : $("#add-coupon"),
        couponCode : $("form input[name$='_couponCode']")
    };
  }
  /**
   * @private
   * @function
   * @description Binds events to the cart page (edit item's details, bonus item's actions, coupon code entry ) 
   */
  function initializeEvents() {
    $cache.cartTable.on("click", ".item-edit-details:not(.item-edit-giftcert-details) a", function (e) {
      if(!$(this).hasClass('nopop')){
        e.preventDefault();
        app.quickView.show({
          url : e.target.href,
          source : "cart"
        });
      }
    })
    .on("click", ".bonus-item-actions a", function (e) {
      e.preventDefault();
      app.bonusProductsView.show(this.href);
    });

    // override enter key for coupon code entry
    $cache.couponCode.on("keydown", function (e) {
      if (e.which === 13 && $(this).val().length===0) { return false; }
    });
  }
  /******* app.cart public object ********/
  app.cart = {
      /**
       * @function
       * @description Adds new item to the cart
       * @param {Object} postdata An Object representing the the new or uptodate data
       * @param {Object} A callback function to be called 
       */ 
      add : function (postdata, callback) {
        updateCart(postdata, callback);
      },
      /**
       * @function
       * @description Hook for removing item from the cart 
       * 
       */   
      remove : function () {
        return;
      },
      /**
       * @function
       * @description Updates the cart with new data
       * @param {Object} postdata An Object representing the the new or uptodate data
       * @param {Object} A callback function to be called 
       */   
      update : function (postdata, callback) {
        updateCart(postdata, callback);
      },
      /**
       * @function
       * @description Refreshes the cart without posting
       */   
      refresh : function () {
        // refresh without posting
        app.page.refresh();
      },
      /**
       * @function
       * @description Initializes the functionality on the cart
       */   
      init : function () {
        // edit shopping cart line item
        initializeCache();
        initializeEvents();
        if(app.enabledStorePickup){
          app.storeinventory.init();
        }
      }
  };

}(window.app = window.app || {}, jQuery));

/**
 * @class app.account
 */
(function (app, $) {
  var $cache = {};
  /**
   * @private
   * @function
   * @description Initializes the events on the address form (apply, cancel, delete)
   * @param {Element} form The form which will be initialized
   */
  function initializeAddressForm(form) {
    var form = $("#edit-address-form");

    // Kill the autofocus for forms in popup

    if (form.find('input').length) {
      form.find('input').blur().removeClass('error');
      form.find('span.error').remove();
    }

    form.find("input[name='format']").remove();
    //$("<input/>").attr({type:"hidden", name:"format", value:"ajax"}).appendTo(form);

    form.on("click", ".apply-button", function(e) {
      e.preventDefault();
      var addressId = form.find("input[name$='_addressid']");
      addressId.val(addressId.val().replace(/[^\w+-]/g, "-"));
      if (!form.valid()) {
        return false;
      }
      var url = app.util.appendParamsToUrl(form.attr('action'),{format:"ajax"});
      var applyName = form.find('.apply-button').attr('name');
      var options = {
          url: url,
          data: form.serialize()+"&"+applyName+'=x',
          type: "POST"
      };

      $.ajax( options ).done(function(data) {   
        if(typeof(data)==='string') {
          app.dialog.close();
          app.page.refresh();
        } else {
          $('#dialog-container').html(data);
          app.account.init();
        }       

      }).fail(function(data) {
        alert(data.message);
        return false;
      });
    })
    .on("click", ".cancel-button, .close-button", function(e){
      e.preventDefault();
      app.dialog.close();
    })
    .on("click", ".delete-button", function(e){
      e.preventDefault();
      if (confirm(String.format(app.resources.CONFIRM_DELETE, app.resources.TITLE_ADDRESS))) {
        var url = app.util.appendParamsToUrl(app.util.getPipeUrl('Address-Delete'), {AddressID:form.find("#addressid").val(),format:"ajax"});
        $.ajax({
          url: url,
          method: "POST",
          dataType:"json"
        }).done(function(data){
          if (data.status.toLowerCase()==="ok") {
            app.dialog.close();
            app.page.refresh();
          }
          else if (data.message.length>0) {
            alert(data.message);
            return false;
          }
          else {
            app.dialog.close();
            app.page.refresh();
          }
        });
      }
    });

    $cache.countrySelect = form.find("select[id$='_country']");
    $cache.countrySelect.on("change", function() {
      app.util.updateStateOptions(this, form.find("select[id$='_state']").val());
    });

    $cache.countrySelect.trigger('change');

    app.validator.init();
  }
  /**
   * @private
   * @function
   * @description Toggles the list of Orders
   */
  function toggleFullOrder () {
    $('.order-items')
    .find('li.hidden:first')
    .prev('li')
    .append('<a class="toggle">View All</a>')
    .children('.toggle')
    .click(function() {
      $(this).parent().siblings('li.hidden').show();
      $(this).remove();
    });
  }
  /**
   * @private
   * @function
   * @description Binds the events on the address form (edit, create, delete)
   */
  function initAddressEvents() {
    var addresses = $("#addresses");
    if (addresses.length===0) { return; }

    addresses.on("click", "a.address-edit, a.address-create", function(e){
      e.preventDefault();
      var options = {open: initializeAddressForm, title: $(this).prop('title'), classname: 'address-dialog'};

      if ($(this).data('width') !== undefined || $(this).data('width') !== '') {
        options.width = $(this).data('width');
      }

      app.dialog.open({url:this.href, options:options});
    }).on("click", ".delete", function(e){
      e.preventDefault();
      if (confirm(String.format(app.resources.CONFIRM_DELETE, app.resources.TITLE_ADDRESS))) {
        $.ajax({
          url: app.util.appendParamsToUrl($(this).attr("href"), {format:"ajax"}),
          dataType:"json"
        }).done(function(data){
          if (data.status.toLowerCase()==="ok") {
            app.page.redirect(app.util.getPipeUrlSecure('Address-List'));
          }
          else if (data.message.length>0) {
            alert(data.message);
          }
          else {
            app.page.refresh();
          }
        });
      }
    });
  }
  /**
   * @private
   * @function
   * @description Binds the events of the payment methods list (delete card)
   */ 
  function initPaymentEvents() {
    var paymentList = $(".payment-list");
    if (paymentList.length===0) { return; }

    app.util.setDeleteConfirmation(paymentList, String.format(app.resources.CONFIRM_DELETE, app.resources.TITLE_CREDITCARD));

    $("form[name='payment-remove']").on("submit", function(e){
      e.preventDefault();
      // override form submission in order to prevent refresh issues
      var button = $(this).find("button.delete");
      $("<input/>").attr({type:"hidden", name:button.attr("name"), value:button.attr("value")||"delete card"}).appendTo($(this));
      var data = $(this).serialize();
      $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: data
      })
      .done(function(response) {
        app.page.redirect(app.util.getPipeUrlSecure('PaymentInstruments-List'));
      });
    });
  }
  /** 
   * @private 
   * @function 
   * @description init events for the loginPage
   */
  function initLoginPage() {
    
    //o-auth binding for which icon is clicked
    $('.oAuthIcon').bind("click", function() {
      $('#OAuthProvider').val(this.id);
    }); 
    
    //toggle the value of the rememberme checkbox
    $("#dwfrm_login_rememberme").bind("change", function() {
      if ($('#dwfrm_login_rememberme').prop('checked')) {
        $('#rememberme').val('true');
      } else {
        $('#rememberme').val('false');
      }
    });
  }
  function loadcharacterlimit() {
    jQuery(".contactmessage textarea").bind("keyup keydown", function() {
      var max = 3000;
      var value = jQuery(this).val();

      var left = max - value.length;
      if(left < 0) {
        jQuery(this).val( value.slice(0, left) );
        left = 0;
      }
      jQuery(".contactmessage span.count").text(left);

    });


    // init send contact message
    function initMessageBox() {

      // init left character count and max characters
      var max = 3000;
      var text = jQuery(".contactmessage span.form-caption").html();
      var count = jQuery(".contactmessage textarea").val().length;
      jQuery(".contactmessage span.form-caption").html( text.replace("XXX", "<span class=\"count\"><\/span>").replace("YYY", max) );  
      var left = max - count;
      jQuery(".contactmessage span.count").text(left);

    }

    initMessageBox();
  }
  /**
   * @private
   * @function
   * @description Binds the events of the order, address and payment pages
   */
  function initializeEvents() {
    toggleFullOrder();
    initAddressEvents();
    initPaymentEvents();
    
    initLoginPage();

    if (jQuery(".contactmessage textarea").length) {
      loadcharacterlimit();
    }
  }

  /******* app.account public object ********/
  app.account = {
    /**
     * @function
     * @description Binds the events of the order, address and payment pages
     */   
    init : function () {
      initializeEvents();
    
      app.giftcert.init();
    },
    initCartLogin : function () {
      initLoginPage();
    }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.wishlist
 */
(function (app, $) {
  var $cache = {};
  /**
   * @private
   * @function
   * @description Binds the send to friend and address changed events to the wishlist page
   */
  function initializeEvents() {
    app.sendToFriend.initializeDialog("div.list-table-header", ".send-to-friend");
    $cache.editAddress.on('change', function () {
      window.location.href = app.util.appendParamToURL(app.util.getPipeUrlSecure('Wishlist-SetShippingAddress'), "AddressID", $(this).val());
    });
    
    //add js logic to remove the , from the qty feild to pass regex expression on client side
    jQuery('.option-quantity-desired div input').focus(function() {    
      $(this).val($(this).val().replace(',','')); 
    });
    
    $cache.wishlistTable.on("click", ".item-details a", function(e) {

      if (!$(this).hasClass('nopop')) {
        e.preventDefault();
        app.quickView.show({
          url : e.target.href,
          source : "wishlist"
        });
      }
    });
  }


  /******* app.wishlist public object ********/
  app.wishlist = {
      /**
       * @function
       * @description Binds events to the wishlist page
       */   
      init : function () {
        $cache.editAddress = $('#editAddress');
        $cache.wishlistTable = $('.pt_wish-list .item-list');
        app.product.initAddToCart();
        initializeEvents();

      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.minicart
 */
(function (app, $) {
  // sub name space app.minicart.* provides functionality around the mini cart

  var $cache = {},
  initialized = false;

  var timer = {
      id : null,
      clear : function () {
        if(timer.id) {
          window.clearTimeout(timer.id);
          delete timer.id;
        }
      },
      start : function (duration) {
        timer.id = setTimeout(app.minicart.close, duration);
      }
  };
  /******* app.minicart public object ********/
  app.minicart = {
      url : "", // during page loading, the Demandware URL is stored here

      /**
       * @function
       * @description Cache initializations and event binding to the mimcart
       */ 
      init : function () {
        $cache.minicart = $("#mini-cart");
        $cache.mcTotal = $cache.minicart.find(".mini-cart-total");
        $cache.mcContent = $cache.minicart.find(".mini-cart-content");
        $cache.mcClose = $cache.minicart.find(".mini-cart-close");
        $cache.mcProductList = $cache.minicart.find(".mini-cart-products");
        $cache.mcProducts = $cache.mcProductList.children(".mini-cart-product");
        
        // bind hover event to the cart total link at the top right corner
        $cache.minicart.on("mouseenter", ".mini-cart-total", function () {
          if($cache.mcContent.not(":visible")) {
            app.minicart.slide();
          }
        })
        .on("mouseenter", ".mini-cart-content", function (e) {
          timer.clear();
        })
        .on("mouseleave", ".mini-cart-content", function (e) {
          timer.clear();
          timer.start(30);
        })
        .on("click", ".mini-cart-close", app.minicart.close);
        
        // Minicart Product Toggler - Enabled via app.resources
        if (app.constants.MINICART_PRODUCT_TOGGLER) {
          var collapsed = $cache.mcProductList.children().not(":first").addClass("collapsed");
          $cache.mcProducts.append('<div class="mini-cart-toggler">&nbsp;</div>');
          $cache.mcProductList.toggledList({toggleClass : "collapsed", triggerSelector:".mini-cart-toggler", eventName:"click"});
        }

        initialized = true;
      }, 
      /**
       * @function
       * @description Shows the given content in the mini cart
       * @param {String} A HTML string with the content which will be shown
       */
      show : function (html) {
        $cache.minicart.html(html);
        app.util.scrollBrowser(0);
        app.minicart.init();
        app.minicart.slide();
        app.bonusProductsView.loadBonusOption();
      },

      popup : function (html) {
        
        // takes the user to the cart on mobile
        if (app.isMobileUserAgent){
          window.location = app.util.getPipeUrl('Cart-Show');
          return false;
        }
        
        $cache.minicart.html(html);
        $('.footer-cart-item-total').html(parseInt($('.footer-cart-item-total').html()) + 1);
        $('.footer-cart-total-label').html($('.mini-cart-subtotals .value').html());
        var dlg = app.dialog.create({target:$("#add-to-cart-pop-up"), options: {
          width: 600,
          height: 'auto',
          title: app.resources.ADD_TO_CART,
          classname: 'add-to-cart-popup',
          open: function() {
            app.bonusProductsView.loadBonusOption();
            
            $('.continue-shopping').click(function() {
              app.dialog.close();
            });
          },
          close:function() {
            
            // Reactivate add to cart button after close of minicart popup
            $('.add-to-cart').prop('disabled', false);
            
            // If on cart page, reload to show new product
            if (window.location.href.indexOf("cart") >= 0 || window.location.href.indexOf("Cart-Show") >= 0 ) {
              location.reload(true);
            };
          }
        }});

        var miniCartHtml = $cache.minicart.find('.mini-cart-product:first').clone();
        dlg.append(miniCartHtml);
        
        app.minicart.init();
        
        dlg.append('<a href="'+app.util.getPipeUrl('Cart-Show')+'" class="button checkout-now button-fancy-medium"><span>'+app.resources.CHECKOUT_NOW+'</span></a>');
        dlg.append('<a class="button continue-shopping close">'+app.resources.CONTINUE_SHOPPING+'</a>');
        if(typeof(mybuys) != "undefined") {
          if (!app.quickView.isActive()) {
            dlg.append($('#mybuyspagezone1').html());
          } else {
            dlg.append('<div id="mybuyspagezone1" mybuyszone="1"></div>');
            mybuys.setPageType("ADD_TO_CART");

            jQuery(function() {
              mybuys.setDataResponseCallback(loadzone);
            });

            dlg.append($('#mybuyspagezone1').html());
            mybuys.set("productid",app.quickView.id);
          }
          mybuys.initPage();
        }
        
        $.dwPopup.init();
      },

      // slide down and show the contents of the mini cart
      /**
       * @function
       * @description Slides down and show the contents of the mini cart
       */ 
      slide : function () {
        if(!initialized) {
          app.minicart.init();
        }

        if(app.minicart.suppressSlideDown && app.minicart.suppressSlideDown()) {
          return;
        }

        timer.clear();

        // show the item
        $cache.mcContent.slideDown('slow');

        // after a time out automatically close it
        timer.start(10000);
      },
      /**
       * @function
       * @description Closes the mini cart with given delay
       * @param {Number} delay The delay in milliseconds
       */ 
      close : function (delay) {
        timer.clear();
        $cache.mcContent.slideUp();
      },
      /**
       * @function
       * @description Hook which can be replaced by individual pages/page types (e.g. cart)
       */
      suppressSlideDown : function () {
        return false;
      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.dialog
 */
(function (app, $) {
  // private

  var $cache = {};
  // end private

  /******* app.dialog public object ********/
  app.dialog = {
    /**
     * @function
     * @description Appends a dialog to a given container (target)
     * @param {Object} params  params.target can be an id selector or an jquery object
     */ 
    create : function(params) {
      if (params.options.open !== undefined) {
        params.options.onOpen = params.options.open;
      }
      
      if (params.options.close !== undefined) {
        params.options.onClose = params.options.close;
      }
      
      $.dwPopup.create("", params.options);
      return $(".popup-content");
    },
    /**
     * @function
     * @description Opens a dialog using the given url (params.url)
     * @param {Object} params.url should contain the url 
     */
    open : function(params) {
      var options = params.options;
      
      if (options === undefined) {
  	  options = {};
      }
      
      if (options.open !== undefined) {
        options.onOpen = options.open;
      }
      
      if (options.close !== undefined) {
        options.onClose = options.close;
      }
  	
  	  $.dwPopup.open(params.url, options);
      
      // Check if ajax popup address form and setup updateStateOptions()
      if ($(".popup-content").find('.state-select').length && $('#dialog-container').find('.state-input').length) {
        
        $(".popup-content").find("form select[id$='_country']").on('change', function() {
          var that = $(this);
          app.util.selectFieldChange(that);
        });
        
        $(".popup-content").find("form select[id$='_country']").trigger('change');
      }
      
      return $(".popup-content");
    },
    /**
     * @function
     * @description Closes the dialog and triggers the "close" event for the dialog
     */
    close : function() {
    	$.dwPopup.close();
    },
    /**
     * @function
     * @description Triggers the "apply" event for the dialog
     */
    triggerApply : function () {
      $(this).trigger("dialogApplied");
    },
    /**
     * @function
     * @description Attaches the given callback function upon dialog "apply" event
     */
    onApply : function (callback) {
      if(callback) {
        $(this).bind("dialogApplied", callback);
      }
    },
    /**
     * @function
     * @description Triggers the "delete" event for the dialog
     */
    triggerDelete : function () {
      $(this).trigger("dialogDeleted");
    },
    /**
     * @function
     * @description Attaches the given callback function upon dialog "delete" event
     * @param {String} The callback function to be called
     */
    onDelete : function (callback) {
      if(callback) {
        $(this).bind("dialogDeleted", callback);
      }
    },
    /**
     * @function
     * @description Submits the dialog form with the given action
     * @param {String} The action which will be triggered upon form submit
     */
    submit : function (action) {      
      var form = $cache.container.find("form:first");
      // set the action
      $("<input/>").attr({
        name : action,
        type : "hidden"
      }).appendTo(form);

      // serialize the form and get the post url
      var post = form.serialize();
      var url = form.attr("action");

      // post the data and replace current content with response content
      $.ajax({
        type : "POST",
        url : url,
        data : post,
        dataType : "html",
        success : function (data) {
          $cache.container.html(data);
        },
        failure : function (data) {
          window.alert(app.resources.SERVER_ERROR);
        }
      });
     }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.validator
 */
(function (app, $) {

  var naPhone = /^\(?([2-9][0-8][0-9])\)?[\-\. ]?([2-9][0-9]{2})[\-\. ]?([0-9]{4})(\s*x[0-9]+)?$/,
  regex = {
      phone : {
        us : naPhone,
        ca : naPhone
      },
      postal : {
        us : /^\d{5}(-\d{4})?$/,
        ca : /^[ABCEGHJKLMNPRSTVXYabceghjklmnprstvxy]{1}\d{1}[A-Za-z]{1} *\d{1}[A-Za-z]{1}\d{1}$/,
        gb : /^[a-zA-Z]?[a-zA-Z]\d.*[a-zA-Z\d]?\d[a-zA-Z]{2}$/,
        cn : /^([0-9]){6}$/
      },
      email : /^[\w.%+\-]+@[\w.\-]+\.[\w]{2,}$/
  },
  settings = {
      // global form validator settings
      errorClass : 'error',
      errorElement : 'span',
      onkeyup : false,
      onfocusout : function (element) {
        if(!this.checkable(element)) {
          this.element(element);
        }
      }
  };
  /**
   * @function
   * @description Validates a given phone number against the countries phone regex
   * @param {String} value The phone number which will be validated
   * @param {String} el The input field
   */
  function validatePhone(value, el) {
    var country = $(el).closest("form").find("select[name$='_country']");
    if(country.length === 0 || country.val().length === 0 || !regex.phone[country.val().toLowerCase()]) {
      return true;
    }

    var rgx = regex.phone[country.val().toLowerCase()];
    var isOptional = this.optional(el);
    var isValid = rgx.test($.trim(value));

    return isOptional || isValid;
  }
  /**
   * @function
   * @description Validates a given email
   * @param {String} value The email which will be validated
   * @param {String} el The input field
   */
  function validateEmail(value, el) {
    var isOptional = this.optional(el);
    var isValid = regex.email.test($.trim(value));
    return isOptional || isValid;
  }
  
  /* Validates Zip */

  function validateZip(value, el) {
    var country = $(el).closest("form").find("select[name$='_country']");

    if(country.length === 0 || country.val().length === 0 || !regex.postal[country.val().toLowerCase()]) {
      return true;
    }

    var rgx = regex.postal[country.val().toLowerCase()];
    var isOptional = this.optional(el);
    var isValid = rgx.test($.trim(value));

    return isOptional || isValid;
  }
  
  /* Validate DOB based on age requirement */
  
  function validateDob(value, el) {
    var value = value.replace(/-/g, '/'),
        today = new Date(),
        currentMonth = today.getMonth() + 1,
        currentDay = today.getDate(),
        currentYear = today.getFullYear(),
        currentDate = currentMonth + '/' + currentDay + '/' + currentYear,
        compareToday = new Date(currentDate),
        compareDOB = new Date(value),
        age = compareToday.getFullYear() - compareDOB.getFullYear(),
        ageDay = compareToday.getDate() - compareDOB.getDate(),
        ageMonth = (compareToday.getMonth() + 1) - (compareDOB.getMonth() + 1);   
    
    if (ageMonth < 0 || (ageMonth === 0 && ageDay < 0)) {
      age = parseInt(age) - 1;
    }

    var isOptional = this.optional(el),
      isValid = age >= app.constants.DOB_AGE_REQUIREMENT;
    
    return isOptional || isValid;
  }

  /* Validates Credit Card */
  
  function validateCCExp(value, el) {
    var monthCC = $(el).closest("form").find(".month select");
    var yearCC = $(el).closest("form").find(".year select");
    var minMonth = new Date().getMonth() + 1;
    var minYear = new Date().getFullYear();
    var month = parseInt($(monthCC).val(), 10);
    var year = parseInt($(yearCC).val(), 10);
    var isOptional = this.optional(el);
    var isValid = (year > minYear || (year === minYear && month >= minMonth));
    return  isOptional || isValid;
  }

  $.validator.addMethod("cMaxlength", $.validator.methods.maxlength, $.format(app.resources.INVALID_LENGTH));
  
  /**
   * Add phone validation method to jQuery validation plugin.
   * Text fields must have 'phone' css class to be validated as phone
   */
  $.validator.addMethod("phone", validatePhone, app.resources.INVALID_PHONE);

  /**
   * Add email validation method to jQuery validation plugin.
   * Text fields must have 'email' css class to be validated as email
   */
  $.validator.addMethod("email", validateEmail, app.resources.INVALID_EMAIL);

  /*
   * Add zip validation method to jQuery validation plugin.
   * Text fields must have 'zip' css class to be validated as phone
   */

  $.validator.addMethod("zip", validateZip, app.resources.INVALID_ZIP);
  
  /**
   * Add birthdate validation method to jQuery validation plugin.
   * Text fields must have 'bday' css class to be validated as phone
   */
  
  $.validator.addMethod("bday", validateDob, app.resources.INVALID_AGE);
  
  /**
   * Add creditcard exp validation method to jQuery validation plugin.
   * Text fields must have 'ccexp' css class to be validated as phone
   */

  $.validator.addMethod('ccexp', validateCCExp, app.resources.INVALID_CCEXP);

  /*
   * Add gift cert amount validation method to jQuery validation plugin.
   * Text fields must have 'gift-cert-amont' css class to be validated
   */
  
  // The input is a numerical stepper and should begin with the min value
  
  $(".gift-cert-amount").prop("min", 20);
  
  $.validator.addMethod("gift-cert-amount", function(value, el){
    var isOptional = this.optional(el);
    var isValid = (!isNaN(value)) && (parseFloat(value)>=20) && (parseFloat(value)<=2000);

    return isOptional || isValid;
  }, app.resources.GIFT_CERT_AMOUNT_INVALID);

  /**
   * Add positive number validation method to jQuery validation plugin.
   * Text fields must have 'positivenumber' css class to be validated as positivenumber
   */
  $.validator.addMethod("positivenumber", function (value, element) {
    if($.trim(value).length === 0) { return true; }
    return (!isNaN(value) && Number(value) >= 0);
  }, "");
  // "" should be replaced with error message if needed

  $.validator.messages.required = function ($1, ele, $3) {
    var requiredText = $(ele).parents('.form-row').attr('data-required-text');
    return requiredText||app.resources.INVALID_FIELD;
  };

  /******* app.validator public object ********/
  app.validator = {
      regex : regex,
      settings : settings,
      init : function () {

        $('input').closest('.form-row:not(.required)').each(function() {
          $(this).find('input').addClass('ignore');
        });

        $('.ignore').blur(function() {
          if ($(this).val() === '') {
            $(this).removeClass('valid');
          }
        });

        $("form:not(.suppress)").each(function() {
          $(this).validate(app.validator.settings);
        });
        
        // Check globally for date field support
        // And switch to text if not supported
        
        if (!Modernizr.inputtypes.date) {
          var i;
          for (i = 0; i < $('.input-date').length; i++) {
            $('.input-date').eq(i).prop('type', 'text');  
          }
        }
      },
      initForm : function(f) {
        $(f).validate(app.validator.settings);
      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * app.emailValidator
 * 	Add real time email validation on the client
 *  when user has opted-in to receive emails
 *  
 *  This is a 'soft' stop: if the email address is invalid
 *   the user is warned yet allowed to continue
 * @param app
 * @param $
 */
(function (app,$) {
  app.emailValidator = {
    init: function() {
      var $cache = {};
      var singlepage = false;
      // register page
      if ($("form#RegistrationForm").length) {
        $cache.regForm = $("form#RegistrationForm");
        $cache.emailOptin = $("input[name$='profile_emailpreferences_receiveemails']");
        $cache.emailInput = $("input[name$='profile_customer_email']");
      
      // checkout - billing page
      } else if ($("form#dwfrm_billing").length) {
        $cache.regForm = $("form#dwfrm_billing");
        $cache.emailOptin = $("input[name$='_addToEmailList']");
        $cache.emailInput = $("input[name$='_emailAddress']");

      // singlepage checkout
      } else if ($("input[name$='_emailAddress']").val() != "" && $("form#next").length && $("form#next").hasClass('onepagecheckout') ) {
          $cache.regForm = $("form#next");
          $cache.emailOptin = $("input[name$='_addToEmailList']");
          $cache.emailInput = $("input[name$='_emailAddress']");
          singlepage = true;
          
        // no email registration form to validate
      } else {
        return true;
      }
      if (singlepage) {

	         if ($cache.emailOptin.prop('checked')) {
	            var address = $cache.emailInput.val();
	            var isEmailValid = app.util.briteverifyEmailAddress(address);
	            
	            if (!isEmailValid) {

	              $cache.emailInput.removeClass("valid");
	              $cache.emailInput.addClass("error");
	              $("#next > div.accordion-section.a-shipping-section").show().addClass('active');
	              // if the email address is invalid, message user but let them continue if they wish
	              $('#emailVal').remove();
	              var msgElem = '<span id="emailVal" class="error">'+app.resources.EMAIL_SOFTERROR+'</span>';
	              $cache.emailInput.after(msgElem);
	            }else{
	            	$('#emailVal').remove();

	            }
	          }
	       return isEmailValid;  	
      }
      // if there is an email optin form on the page validate the address on submit
      $cache.regForm.submit(function(e) {
    	  if (singlepage) {
    	    return;
    	  }
        if ($cache.emailOptin.prop('checked')) {
          var address = $cache.emailInput.val();
          var isEmailValid = app.util.briteverifyEmailAddress(address);
          
          if (!isEmailValid) {
            e.preventDefault();
            $cache.emailInput.removeClass("valid");
            $cache.emailInput.addClass("error");
           
            // if the email address is invalid, message user but let them continue if they wish
            var msgElem = '<span class="error">'+app.resources.EMAIL_SOFTERROR+'</span>​<br />';
            $cache.emailInput.after(msgElem);
            $cache.regForm.off("submit");
          }
        }
        
      });
    }
  };
} (window.app = window.app || {}, jQuery));


/**
 * @class app.ajax
 */
(function (app, $) {

  var currentRequests = [];
  // request cache

  // sub namespace app.ajax.* contains application specific ajax components
  app.ajax = {
      /**
       * @function
       * @description Ajax request to get json response
       * @param {Boolean} async  Asynchronous or not
       * @param {String} url URI for the request
       * @param {Object} data Name/Value pair data request
       * @param {Function} callback  Callback function to be called
       */ 
      getJson : function (options) {
        options.url = app.util.toAbsoluteUrl(options.url);
        // return if no url exists or url matches a current request
        if(!options.url || currentRequests[options.url]) {
          return;
        }

        currentRequests[options.url] = true;

        // make the server call
        $.ajax({
          dataType : "json",
          url : options.url,
          async : (typeof options.async==="undefined" || options.async===null) ? true : options.async,
              data : options.data || {}
        })
        
        // success
        .done(function (response) {
          if(options.callback) {
            options.callback(response);
          }
        })
        
        // failed
        .fail(function(xhr, textStatus) {
          if (textStatus === "parsererror") {
            window.alert(app.resources.BAD_RESPONSE);
          }
          
          if (options.callback) {
            options.callback(null);
          }
        })
        
        // executed on success or fail
        .always(function () {
          
          // remove current request from hash
          if (currentRequests[options.url]) {
            delete currentRequests[options.url];
          }
        });
      },
      /**
       * @function
       * @description ajax request to load html response in a given container
       * @param {String} url URI for the request
       * @param {Object} data Name/Value pair data request
       * @param {Function} callback  Callback function to be called
       * @param {Object} target Selector or element that will receive content
       */ 
      load : function (options) {
        options.url = app.util.toAbsoluteUrl(options.url);
        // return if no url exists or url matches a current request
        if(!options.url || currentRequests[options.url]) {
          return;
        }

        currentRequests[options.url] = true;

        // make the server call
        $.ajax({
          dataType : "html",
          url : app.util.appendParamToURL(options.url, "format", "ajax"),
          data : options.data
        })
        .done(function (response) {
          // success
          if(options.target) {
            $(options.target).empty().html(response);
          }
          if(options.callback) {
            options.callback(response);
          }

        })
        .fail(function (xhr, textStatus) {
          // failed
          if(textStatus === "parsererror") {
            window.alert(app.resources.BAD_RESPONSE);
          }
          options.callback(null, textStatus);
        })
        .always(function () {
          app.progress.hide();
          // remove current request from hash
          if(currentRequests[options.url]) {
            delete currentRequests[options.url];
          }
        });
      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.searchsuggest
 */
(function (app, $) {
  var qlen = 0,
  listTotal = -1,
  listCurrent = -1,
  delay = 300,
  fieldDefault = null,
  suggestionsJson = null,
  $searchForm,
  $searchField,
  $searchContainer,
  $resultsContainer;
  /**
   * @function
   * @description Handles keyboard's arrow keys
   * @param keyCode Code of an arrow key to be handled
   */
  function handleArrowKeys(keyCode) {
    switch (keyCode) {
      case 38:
        // keyUp
        listCurrent = (listCurrent <= 0) ? (listTotal - 1) : (listCurrent - 1);
        break;
      case 40:
        // keyDown
        listCurrent = (listCurrent >= listTotal - 1) ? 0 : listCurrent + 1;
        break;
      default:
        // reset
        listCurrent = -1;
      return false;
    }

    $resultsContainer.children().removeClass("selected").eq(listCurrent).addClass("selected");
    $searchField.val($resultsContainer.find(".selected div.suggestionterm").first().text());
    return true;
  }

  /******* app.searchsuggest public object ********/
  app.searchsuggest = {
      /**
       * @function
       * @description Configures parameters and required object instances
       */ 
      init : function (container, defaultValue) {
        // initialize vars
        $searchContainer = $(container);
        $searchForm = $searchContainer.find("form[name='simpleSearch']");
        $searchField = $searchForm.find("input[name='q']");
        fieldDefault = defaultValue;

        // disable browser auto complete
        $searchField.attr("autocomplete", "off");

        // on focus listener (clear default value)
        $searchField.focus(function () {
          if(!$resultsContainer) {
            // create results container if needed
            $resultsContainer = $("<div/>").attr("id", "suggestions").appendTo($searchContainer).css({
              "top" : $searchContainer[0].offsetHeight,
              "left" : 0,
              "width" : $searchField[0].offsetWidth
            });
          }
          if($searchField.val() === fieldDefault) {
            $searchField.val("");
          }
        });
        // on blur listener
        $searchField.blur(function () {
          setTimeout(app.searchsuggest.clearResults, 200);
        });
        // on key up listener
        $searchField.keyup(function (e) {

          // get keyCode (window.event is for IE)
          var keyCode = e.keyCode || window.event.keyCode;

          // check and treat up and down arrows
          if(handleArrowKeys(keyCode)) {
            return;
          }
          // check for an ENTER or ESC
          if(keyCode === 13 || keyCode === 27) {
            app.searchsuggest.clearResults();
            return;
          }

          var lastVal = $searchField.val();

          // if is text, call with delay
          setTimeout(function () { app.searchsuggest.suggest(lastVal); }, delay);
        });
        // on submit we do not submit the form, but change the window location
        // in order to avoid https to http warnings in the browser
        // only if it's not the default value and it's not empty
        $searchForm.submit(function (e) {
          e.preventDefault();
          var searchTerm = $searchField.val();
          if(searchTerm === fieldDefault || searchTerm.length === 0) {
            return false;
          }
          window.location = app.util.appendParamToURL($(this).attr("action"), "q", searchTerm);
        });
      },

      /**
       * @function
       * @description trigger suggest action
       * @param lastValue
       */
      suggest : function (lastValue) {
        // get the field value
        var part = $searchField.val();

        // if it's empty clear the resuts box and return
        if(part.length === 0) {
          app.searchsuggest.clearResults();
          return;
        }

        // if part is not equal to the value from the initiated call,
        // or there were no results in the last call and the query length
        // is longer than the last query length, return
        // #TODO: improve this to look at the query value and length
        if ((lastValue !== part) || (listTotal === 0 && part.length > qlen)) {
          return;
        }
        qlen = part.length;

        // build the request url
        var reqUrl = app.util.appendParamToURL(app.util.getPipeUrl('Search-GetSuggestions'), "q", part);

        // get remote data as JSON
        $.getJSON(reqUrl, function (data) {
          // get the total of results
          var suggestions = data,
          ansLength = suggestions.length,
          listTotal = ansLength;

          // if there are results populate the results div
          if(ansLength === 0) {
            app.searchsuggest.clearResults();
            return;
          }
          suggestionsJson = suggestions;
          var html = "";
          var i, len=ansLength;
          for(i=0; i < len; i++) {
            html+='<div><div class="suggestionterm">'+suggestions[i].suggestion+'</div><span class="hits">'+suggestions[i].hits+'</span></div>';
          }

          // update the results div
          $resultsContainer.html(html).show().on("mouseenter", "div", function () {
            $(this).toggleClass = "selected";
          }).on("click", "div", function () {
            // on click copy suggestion to search field, hide the list and submit the search
            $searchField.val($(this).children(".suggestionterm").text());
            app.searchsuggest.clearResults();
            $searchForm.trigger("submit");
          });
        });
      },
      /**
       * @function
       * @description 
       */   
      clearResults : function () {
        if (!$resultsContainer) { return; }
        $resultsContainer.empty().hide();
      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.searchplaceholder
 */
(function (app, $) {
  /**
   * @private
   * @function
   * @description Binds event to the place holder (.blur) 
   */
  function initializeEvents() {
    $('#q').focus(function () {
      var input = $(this);
      if (input.val() === input.attr("placeholder")) {
        input.val("");
      }
    })
    .blur(function () {
      var input = $(this);
      if (input.val() === "" || input.val() === input.attr("placeholder")) {
        input.val(input.attr("placeholder"));
      }
    })
    .blur();
  }

  /******* app.searchplaceholder public object ********/
  app.searchplaceholder = {
      /**
       * @function
       * @description Binds event to the place holder (.blur) 
       */   
      init : function () {
        initializeEvents();
      }
  };
}(window.app = window.app || {}, jQuery));

/**
 * @class app.storeinventory
 */
(function (app, $) {

  var $cache = {};
  var pid = null;
  var currentTemplate = jQuery('#wrapper.pt_cart').length ? "cart" : "pdp";

  /******* app.storeinventory public object ********/
  app.storeinventory = {
    /**
     * @function
     * @description
     */
    init : function() {
      app.storeinventory.initializeCache();
      app.storeinventory.initializeDom();
    },

    initializeCache : function () {
      $cache.preferredStorePanel = jQuery('<div id="preferred-store-panel"/>');
      $cache.storeList = jQuery('<div class="store-list"/>');
    },

      initializeDom: function() {
        
        // check for items that trigger dialog
        jQuery('#cart-table .set-preferred-store').on('click', function(e){
          e.preventDefault();
        app.storeinventory.loadPreferredStorePanel(jQuery(this).parent().attr('id'));
        });
        
        //disable the radio button for home deliveries if the store inventory is out of stock
        jQuery('#cart-table .item-delivery-options .home-delivery .not-available').each(function() {
          jQuery(this).parents('.home-delivery').children('input').attr('disabled','disabled');
        });
        

        jQuery('.pdp-main').on('click', '.set-preferred-store', function(e){
          e.stopImmediatePropagation();
          e.preventDefault();
          app.storeinventory.loadPreferredStorePanel(jQuery(this).parent().attr('id'));
        });

        jQuery('.item-delivery-options input.radio-url').click(function() {
          app.storeinventory.setLineItemStore(jQuery(this));
        });

        if(jQuery(".checkout-shipping").length > 0) app.storeinventory.shippingLoad();

        //disable the cart button if there is pli set to instore and the status is 'Not Available' and it is marked as an instore pli
        jQuery('.item-delivery-options').each(function() {
          if ((jQuery(this).children(".instore-delivery").children("input").attr('disabled')=='disabled') && (jQuery(this).children('.instore-delivery').children('.selected-store-availability').children('.store-error').length > 0) && (jQuery(this).children(".instore-delivery").children("input").attr('checked')=='checked')){
            jQuery('.cart-action-checkout button').attr("disabled", "disabled");
          }
        });
    },

    setLineItemStore: function(radio) {

      jQuery(radio).parent().parent().children().toggleClass('hide');
      jQuery(radio).parent().parent().toggleClass('loading');

      app.ajax.getJson({
        url: app.util.appendParamsToUrl(jQuery(radio).attr('data-url') , {storeid : jQuery(radio).siblings('.storeid').attr('value')}),
        callback: function(data){
          jQuery(radio).prop('checked', true);
          jQuery(radio).parent().parent().toggleClass('loading');
          jQuery(radio).parent().parent().children().toggleClass('hide');
        }
      });

      // Scan the plis to see if there are any that are not able to go through checkout, if none are found re-enable the checkout button
      var countplis = 0;
      jQuery('.item-delivery-options').each(function() {
        if ((jQuery(this).children(".instore-delivery").children("input").attr('disabled') == 'disabled')
          && (jQuery(this).children('.instore-delivery').children('.selected-store-availability').children('.store-error').length > 0)
          && (jQuery(this).children(".instore-delivery").children("input").prop('checked'))
        ) {
          jQuery('.cart-action-checkout button').attr("disabled", "disabled");
        } else {
          countplis++;
        }
      });
      if (countplis > 0 && jQuery('.error-message').length == 0) {
        jQuery('.cart-action-checkout button').removeAttr("disabled", "disabled");
      }
    },

    showStoreInventory: function(id) {
        app.storeinventory.buildStoreList(id);
    },
    
    getLocationFromAddress: function(address) {
    	var addrTrim = address.replace(/\s/g,'+');
    	addrTrim = addrTrim + '+' + app.constants.STORE_INVENTORY_COUNTRY;
    	var url = window.location.protocol + "//maps.googleapis.com/maps/api/geocode/json?address="+addrTrim+"&sensor=true";
        jQuery.getJSON(url, function(data) {
        	app.user.lat = data.results[0].geometry.location.lat;
        	app.user.long = data.results[0].geometry.location.lng;
        	//stash the current location's lat-long in the session so the user sees the same loc until they perform a new search
        	app.storeinventory.setSessionLatLong(app.user.lat, app.user.long);
    		app.storeinventory.buildStoreList();
        });
    },
    
    buildStoreList: function(id) {
      var pid = id ? id : $("#pid").val();
      
      if(typeof pid == 'undefined' || !pid) return;
      
      jQuery('.change-location').on('click', function(e) {
        jQuery('#retail-search-form').fadeIn();
      });
      
      app.ajax.getJson({
        url: app.util.appendParamsToUrl(app.util.getPipeUrlSecure('StoreInventory-Inventory'), {pid:pid, latitude:app.user.lat, longitude:app.user.long}),
        callback: function(data){
        	
          // clear any previous results, then build new
          if(!$cache.storeList.length > 0) $cache.storeList.empty();
          var listings = jQuery("<ul class='store-list'/>");
          var label = '', foundNearest = false;
          var nearest = app.resources.STORE_NEAREST;
          var nearestAvail = nearest + ' ' + app.resources.WITH_AVAIL;
          if(data && data.length > 0) {
            for (var i=0; i < data.length; i++) {
              var item=data[i];
              
              // label the nearest store and nearest store with product available
              // first store gets 'nearest you' label
              // is the product available at nearest store?
              if (i==0 && item.status == app.resources.AVAIL_IN_STORE) {
                label = nearestAvail; 
                foundNearest = true;
              } else if (i==0 && item.status != app.resources.AVAIL_IN_STORE) {
                label = nearest;
              } else if (i>0 && !foundNearest && item.status == app.resources.AVAIL_IN_STORE) {
                label = nearestAvail; 
                foundNearest = true;
              } else {
                label = '';
              }
              var call = item.status == app.resources.AVAIL_IN_STORE ? app.resources.CALL_TO_RESERVE : "";
              var stateCode = item.stateCode ? ', ' + item.stateCode : "";
              
              // list item for cart
              if(currentTemplate === 'cart') {

                listings.append('<li class="store-' +item.storeId + item.status.replace(/ /g,'-') + ' store-tile">' +
                      '<span class="store-tile-address ">' + item.address1 + '</span>' +
                      '<span class="store-tile-city ">' + item.city + ', </span>' +
                      '<span class="store-tile-state ">' + stateCode + '</span>' +
                      '<span class="store-tile-postalCode ">' + item.postalCode + '</span>' +
                      '<span class="store-tile-status ' + item.statusclass + '">' + item.status + '</span>' +
                      '</li>');
                jQuery(".store-availability").removeClass("no-results");
              }

              // list item for pdp
              else {
                var phoneElem = app.isDesktopUserAgent ? item.phone : '<a href="tel:' + item.phone + '">' + item.phone + '</a>';
                var distanceTo = Math.floor(item.distance + 1);
                if(app.constants.STORE_INVENTORY_COUNTRY == 'UK') {
                  //convert km to miles for UK only
                  distanceTo = (distanceTo*.62).toFixed(1);
                }
                var sameday = item.samedayDelivery ? '<div class="store-tile-sameday font-italic">' + item.samedayMsg + '</div>' : '';
                listings.append('<li id="' + item.storeId + '" class="store-' +item.storeId +' ' + item.status.replace(/ /g,'-') + ' store-tile">' +
                    '<div class="store-tile-avail">' + 
                      '<span class="store-nearest">' + label + '</span>' +
                      '<span class="store-tile-status ' + item.statusclass + '">' + item.status + '</span>' +
                      '<span class="makemy">' + app.resources.MAKE_MY + '</span>' +
                    '</div>' +
                    '<div class="store-tile-location">' + 
                      '<span class="store-tile-address ">' + item.storeName + '</span>' +
                      '<span class="store-tile-address ">' + item.address1 + '</span>' +
                      '<span class="store-tile-city ">' + item.city + stateCode + ' ' + item.postalCode +  '</span>' +
                      '<div class="store-tile-phone">' + phoneElem + '</div>' +
                      '<div class="store-tile-message">' + call + '</div>' + 
                      '<div class="store-distance">' + distanceTo + app.resources.DISTANCE_TO + '</div>' +
                      sameday +
                    '</div>' +
                      '</li>');
                jQuery(".store-availability").removeClass("no-results");
              }
            }

          }

          // no records
          else {
            if(app.user.query){
              listings.append("<li><div class='no-results'>" + app.resources.NO_RES + app.user.query + "</div></li>");
              jQuery(".store-availability").addClass("no-results");
              jQuery(".change-location").click();
            }
          }

          // check for preferred store id, highlight, move to top
          if(currentTemplate === 'cart'){
              var selectedButtonText = app.resources.SELECTED_STORE;
          }
          else {
            var selectedButtonText = app.resources.PREFERRED_STORE;
          }
          listings.find('li.store-'+app.user.storeId).addClass('selected').find('button.select-store-button ').text(selectedButtonText);

          app.storeinventory.bubbleStoreUp(listings,app.user.storeId);
          
          // if the preferred store is not in the search results,
          // make the first store visible
          if( listings.find('li.store-'+app.user.storeId).length < 1 ) {
            listings.first().find('li').removeClass('extended-list');
          }
          
          // if there is a block to show results on page (pdp)
          // this is the slide effect
          if( currentTemplate !== 'cart' ) {

            var onPageList = listings.clone();
              var thisDiv = jQuery('div#' + pid);

              thisDiv.find('ul.store-list').remove();
              thisDiv.append(onPageList);
              
              if(onPageList.find('.no-results').length > 0 || onPageList.find('li').size() == 1) {
                jQuery('.more-stores').remove();
              }

              if( onPageList.find('li').size() > 1 ){
                thisDiv.find('li:gt(0)').each(function() {
                  jQuery(this).addClass('extended-list');
                });
                jQuery('.more-stores').remove();
                thisDiv.after('<span class="more-stores">' + app.resources.SEE_MORE + '</span>');
                thisDiv.parent().find('.more-stores').click(function() {
                  if( jQuery(this).text() ===  app.resources.SEE_MORE) {
                    jQuery(this).text(app.resources.SEE_LESS).addClass('active');
                    jQuery('.store-list li').slideDown();
                  }
                  else {
                    jQuery(this).text(app.resources.SEE_MORE).removeClass('active');
                    jQuery('.store-list li:gt(0)').slideUp();
                  }
                  //thisDiv.find(' ul.store-list').toggleClass('expanded');
                });
              }

          };

          // update panel with new list
          // initialize event handlers for this list
            // activate the location changer
            jQuery("#location-input").on('click', function(e) {
              jQuery(this).val('').off('click');
            });
            
          //disable form submission when enter key pressed
          $('#location-input').on('keypress keydown keyup', function(e){
	            if(e.keyCode == 13) { 
	              e.preventDefault(); 
	              jQuery("#change-location").click();
	            }
            });
          
            jQuery("#change-location").off('click').on('click', function(e) {
            	e.preventDefault();
              	//clear out error message and hide search form
              	jQuery('.store-availability').find('.error-message').remove();
              	jQuery('#retail-search-form').fadeOut();
	
	            checkAllVal = jQuery("#location-input").val();
	            app.user.query = checkAllVal;
	            
	            if (checkAllVal) {
	            	jQuery("#change-location").off('click');
		        	  app.storeinventory.getLocationFromAddress(checkAllVal);
		          } else {
		            jQuery('.store-availability #location-input').before('<div class="error-message">' + app.resources.PLEASE_ENTER + '</div>');
		        };
              
            });
            
          jQuery("ul.store-list li .makemy").each( function(i) {
              //if( $(this).hasClass("In-Stock") ) {
                $(this).on('click', function(e) {
                  e.preventDefault();
                  var storeId = $(this).closest('li').attr("id");
                  app.storeinventory.setPreferredStore(storeId);
                });
              //};
          });
          //$('.product-col-1').append( $('.availability-results') ).append( $('.more-stores') );
          
          // set up 'set preferred store' action on new elements
          listings.find('button.select-store-button').click(function(e){

            var selectedStoreId = jQuery(this).val();

            if(currentTemplate === 'cart') {

              //update selected store and set the lineitem
              var liuuid = jQuery('#preferred-store-panel').find('.srcitem').attr('value');
              jQuery('div[name="'+liuuid+'-sp"] .selected-store-address').html(jQuery(this).siblings('.store-tile-address').text()+' <br />'+jQuery(this).siblings('.store-tile-city').text()+' , '+jQuery(this).siblings('.store-tile-state').text()+' '+jQuery(this).siblings('.store-tile-postalCode').text());
              jQuery('div[name="'+liuuid+'-sp"] .storeid').val(jQuery(this).val());
              jQuery('div[name="'+liuuid+'-sp"] .selected-store-availability').html(jQuery(this).siblings('.store-tile-status'));
              jQuery('div[name="'+liuuid+'-sp"] .radio-url').removeAttr('disabled');
              jQuery('div[name="'+liuuid+'-sp"] .radio-url').click();
              $cache.preferredStorePanel.dialog("close");

            }else{

              if( app.user.storeId !== selectedStoreId ) {

                // set as selected
                app.storeinventory.setPreferredStore(selectedStoreId);
                app.storeinventory.bubbleStoreUp (onPageList, selectedStoreId);
                jQuery('.store-list li.selected').removeClass('selected').find('button.select-store-button').text(app.resources.SELECT_STORE);
                jQuery('.store-list li.store-'+selectedStoreId+' button.select-store-button').text(app.resources.PREFERRED_STORE).parent().addClass('selected');
              }

            }
            //if there is a dialog box open in the cart for editing a pli and the user selected a new store
            //add an event to for a page refresh on the cart page if the update button has not been clicked
            //reason - the pli has been updated but the update button was not clicked, leaving the cart visually in accurate.  
            //when the update button is clicked it forces a refresh.
            if(jQuery('#cart-table').length > 0 && jQuery('.select-store-button').length > 0){
              jQuery('.ui-dialog .ui-icon-closethick:first').on( "click", function() {
                window.location.reload();             
              });
            }

          });

        } // end ajax callback
      });
    },

    bubbleStoreUp : function(list, id) {

      var preferredEntry = list.find('li.store-'+id).clone();
      preferredEntry.removeClass('extended-list');
      list.find('.store-tile').not('extended-list').addClass('extended-list');
      list.find('li.store-'+id).remove();
      list.prepend(preferredEntry);
      preferredEntry.find('.makemy').remove();
      if(preferredEntry.find('span.store-tile-status').hasClass('store-error')) {
        preferredEntry.find('span.store-tile-status').html(app.resources.NOT_AVAIL).after('<span class="makemy">' + app.resources.MY_STORE + '</span>');
      } else {        
        preferredEntry.find('span.store-tile-status').html(app.resources.AVAIL_IN_STORE).after('<span class="makemy">' + app.resources.MY_STORE + '</span>');
      }

    },

    setSessionLatLong : function(lat,long) {
      //for current session only
      jQuery.ajax({
        type: "POST",
        url: app.util.getPipeUrl('StoreInventory-SetLatLong'),
        data: { lat:lat,long:long }
      }).fail(function() {

      });

    },

    setPreferredStore : function(id) {
      app.user.storeId = id;
      jQuery.post(app.util.getPipeUrl('StoreInventory-SetPreferredStore'), { storeId : id }, function(data) {
        jQuery('.selected-store-availability').html(data);
        app.storeinventory.showStoreInventory();
      });

    },

    shippingLoad : function() {
      $cache.checkoutForm = jQuery("form.address");
      $cache.checkoutForm.off("click");
      $cache.checkoutForm.on("click", ".is-gift-yes, .is-gift-no", function (e) {
        jQuery(this).parent().siblings(".gift-message-text").toggle(jQuery(this).checked);
      });
      return null;
    }

  };
} (window.app = window.app || {}, jQuery));



//jquery extensions
(function ($) {
  // params
  // toggleClass - required
  // triggerSelector - optional. the selector for the element that triggers the event handler. defaults to the child elements of the list.
  // eventName - optional. defaults to 'click'
  $.fn.toggledList = function (options) {
    if (!options.toggleClass) { return this; }

    var list = this;
    function handleToggle(e) {
      e.preventDefault();
      var classTarget = options.triggerSelector ? $(this).parent() : $(this);
      classTarget.toggleClass(options.toggleClass);
      // execute callback if exists
      if (options.callback) { options.callback(); }
    }

    return list.on(options.eventName || "click", options.triggerSelector || list.children(), handleToggle);
  };

}(jQuery));


// SyncHeight Plugin - Typically used on the productgrid
// https://github.com/alexkravets/jquery.sync-height
(function() {

  (function($, window) {
    return $.extend($.fn, {
      syncHeight: function(options) {
        var get_height, set_heights, settings,
          _this = this;
        this.defaultOptions = {};
        settings = $.extend({}, this.defaultOptions, options);
        get_height = function() {
          var max_height;
          if (settings.heightFunc) return settings.heightFunc();
          _this.height('');
          max_height = 0;
          _this.each(function(i, el) {
            var el_height;
            el_height = $(el).outerHeight();
            if (el_height > max_height) return max_height = el_height;
          });
          return max_height;
        };
        set_heights = function() {
          var height;
          _this.css({
            '-webkit-transition': 'height 0s',
            '-webkit-transition-delay': 0,
            '-moz-transition': 'height 0s',
            '-o-transition': 'height 0s',
            'transition': 'height 0s'
          });
          height = get_height();
          return _this.height(height);
        };
        set_heights();
        return this;
      }
    });
  })(this.jQuery, this);

}).call(this);

//general extension functions
(function () {
  String.format = function() {
    var s = arguments[0];
    var i,len=arguments.length - 1;
    for (i = 0; i < len; i++) {
      var reg = new RegExp("\\{" + i + "\\}", "gm");
      s = s.replace(reg, arguments[i + 1]);
    }
    return s;
  };
})();

//Check if Object.keys is supported
//and if not use property method

(function () {
  if (!Object.keys) {
    Object.keys = function (obj) {
      var arr = [],
        key;
       
      for (key in obj) {
        if (obj.hasOwnProperty(key)) {
          arr.push(key);
        }
      }
       
      return arr;
    };
  }
})();

//fieldValidationErrors box plugin

(function($) {
  $.fn.fieldValidationErrors = function() {
    $(this).on('change', function() {
      var formfield = $(this),
      formrow = formfield.parent();
      if (formfield.value !== "" || "Select...") {
        formrow.removeClass('error');
        formrow.find('.form-caption.error').remove();
      }
    });
  };

  $('select, input').fieldValidationErrors();
})(jQuery);

//Store Lookup Widget Validation

(function(app, $) {

  var $storeswidget = {};

  $storeswidget.lookupForm = $('#dwfrm_storelookup');
  $storeswidget.lookupInput = $storeswidget.lookupForm.find('#dwfrm_storelookup_storelookupbyzip');
  $storeswidget.buttonZip = $storeswidget.lookupForm.find('button.use-zip');
  $storeswidget.zipErrors = $storeswidget.lookupForm.find('.zip-errors');
  
  $storeswidget.zipErrors.hide();

  $storeswidget.buttonZip.on('click', function() {
    var validZip = app.util.validateMyZip($storeswidget.lookupInput.val());

    if (validZip !== true) {
      $storeswidget.zipErrors.show();
      $storeswidget.zipErrors.find('span.error').html(validZip);
      $storeswidget.lookupInput.removeClass('valid');
    } else {
      $storeswidget.zipErrors.hide();
      $storeswidget.zipErrors.find('span.error').empty();
      $storeswidget.lookupInput.addClass('valid');
      $storeswidget.lookupForm.trigger('submit');
    }
  });

}(window.app = window.app || {}, jQuery));

// BISN extension
(function(app, $) {
  app.bisnLoad = {
    // configuration parameters and required object instances
    init : function(bisnForm) {
      // initialize vars
      var submitURL = app.util.getPipeUrl('BISNSave-Bisn');
      
      $("#bisnLink").on('click', function() {
        var dataWidth = $(this).data('width') !== undefined || $(this).data('width') !== '' ? $(this).data('width') : 495;
        $.dwPopup.create($(bisnForm).parent().html(), {
          width: dataWidth,
          height: 'auto',
          title: this.title,
          onOpen: function() {
            $('.bisn-cancel').on("click", function (e) {
              e.preventDefault();
              $.dwPopup.close();
            });
            
            $('.popup-content form').on('submit', function() {
              var emailaddressVal = $(".popup-content #bisnemail").val();
              if (/(.+)@(.+){2,}\.(.+){2,}/.test(emailaddressVal)) {
                var post = $(this).serialize();
                
                $.ajax({
                  type:'POST',
                  url: submitURL,
                  data: post,
                  dataType: 'html',
                  success: function(data) {
                    $('.bisn-notify').hide();
                    $('.bisn-response').show();
                    $('.bisn-response').empty().html(data);
                    $.dwPopup.close();
                  },
                  failure: function(data) {
                    alert("${Resource.msg('global.serverconnection','locale',null)}");    
                  }
                });
              }
              
              return false;
            });
          }
        });
        
        $('.popup-content form').show();
      });
    }
  };
}(window.app = window.app || {}, jQuery));

//initialize app
jQuery(document).ready(function () {
  app.init();
});