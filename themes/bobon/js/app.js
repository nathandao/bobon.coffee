/*
 * debouncedresize: special jQuery event that happens once after a window resize
 */
(function($) {

var $event = $.event,
	$special,
	resizeTimeout;

$special = $event.special.debouncedresize = {
	setup: function() {
		$( this ).on( "resize", $special.handler );
	},
	teardown: function() {
		$( this ).off( "resize", $special.handler );
	},
	handler: function( event, execAsap ) {
		// Save the context
		var context = this,
			args = arguments,
			dispatch = function() {
				// set correct event type
				event.type = "debouncedresize";
				$event.dispatch.apply( context, args );
			};

		if ( resizeTimeout ) {
			clearTimeout( resizeTimeout );
		}

		execAsap ?
			dispatch() :
			resizeTimeout = setTimeout( dispatch, $special.threshold );
	},
	threshold: 150
};

})(jQuery);

// Product grid behaviours.
var ProductGrid = (function($) {
  var $productCell = $('.product-cell');
  // Product result cache.
  var productInfoCache = {};
  // Screen break points.
  var screenSizes = {
    large: 1024,
    medium: 640
  };

  function init() {
    // Append product info to the product grid when clicked.
    $productCell.on('click', function(e) {
      if (!$(this).hasClass('active')) {
        $('.product-cell.active').removeClass('active');
        // Append new info div to the DOM.
        var $this = $(this),
            productId = $this.attr('product-id');
        if (productInfoCache[productId]) {
          appendProductInfo($this);
        } else {
          queryProductContent($this);
        }
        scrollTop($this);
      }
    });
    // On window resize get the window´s size again
    // reset some values..
    $(window).on( 'debouncedresize', function() {
      $('.product-cell.active').removeClass('active');
      $('.product-info-expand').remove();
    });
  }

  // Send ajax request to get the product post conent.
  function queryProductContent($productCell) {
    var productId = $productCell.attr('product-id');
    var url = "/wp-json/wp/v2/product/" + productId;
    var lang = $('html').attr('lang').slice(0, 2);
    if (lang != 'en') {
      url = '/' + lang + url;
    }
    $.ajax({
      url: url,
      method: 'get',
      success: function(data) {
        // Set cache
        productInfoCache[productId] = data;
        // Append the result to DOM.
        appendProductInfo($productCell);
      }
    });
  }

  // Append the product info expand div to the correct location.
  function appendProductInfo($productCell) {
    var cellPosition = $productCell.attr('position'),
        appendingPosition = getAppendingPosition($productCell),
        $container = $productCell.closest('.product-list-container');
    if ($container.length > 0) {
      var $appendingDiv = $container.find('.product-cell[position=' + appendingPosition +']');
      if ($appendingDiv.length > 0) {
        var $productInfo = productInfoDiv($productCell);
        // Remove existing info div.
        $('.product-info-expand').remove();
        $productInfo.insertAfter($appendingDiv).animate({
          dummyProp: 100
        }, {
          step: function(now, fx) {
            $(this).css('-webkit-transform', "scale(1, 1)");
            $(this).css('transform', "scale(1, 1)");
            $(this).css('opacity', 1);
          },
          duration: "slow"
        }, 'ease');
        $productCell.addClass('active');
        $('.product-info-expand .close-btn').on('click', function() {
          $(this).closest('.product-info-expand').remove();
          $('.product-cell.active').removeClass('active');
        });
      }
    }
  }

  // Create the product info div.
  function productInfoDiv($productCell) {
    var productId = $productCell.attr('product-id');
    // Product info div html.
    var $infoWrapper = $('<div class="small-12 columns product-info-expand"></div>');
    var $infoRow = $('<div class="row"></div>');
    var $infoContent = $('<div class="medium-12 large-6 columns"></div>');
    // Product's html content.
    var productTitle = '<div class="product-title"><h2>' + productInfoCache[productId].title.rendered + '</h2></div>';
    var price = '<div class="price">' + $productCell.attr('price') + '</div>';
    var productContent = '<div class="product-info-content">' + productInfoCache[productId].content.rendered + price + '</div>';
    var closeBtn = '<div class="close-btn"></div>';
    var $productImage = $productCell.find('.product-listing-image');
    // Append content to container div elements.
    if ($productImage.length > 0) {
      $infoRow.append('<div class="show-for-large medium-12 large-6 columns"><div class="product-image-expanded">' + $productImage.html() + '</div></div>');
    }
    $infoContent.html(productTitle + productContent + closeBtn);
    $infoRow.append($infoContent);
    $infoWrapper.append($infoRow);
    return $infoWrapper;
  }

  // Get the position of the cell after which we can append the info div to.
  function getAppendingPosition($productCell) {
    var windowWidth = $(window).width();
    var cellPosition  = $productCell.attr('position');
    var cellsPerRow = 0;
    if (windowWidth >= screenSizes.large) {
      cellsPerRow = 4;
    } else if (windowWidth >= screenSizes.medium) {
      cellsPerRow = 2;
    } else {
      cellsPerRow = 1;
    }
    var appendingPos = Math.ceil(cellPosition / cellsPerRow) * cellsPerRow;
    var cellCount = $productCell.closest('.product-list-container').find('.product-cell').length;
    if (appendingPos > cellCount) {
      appendingPos = cellCount;
    }
    return appendingPos;
  }

  // Scroll window to the assigned productCell.
  function scrollTop($productCell) {
    $('html, body').animate({
      scrollTop: $productCell.offset().top - 60
    }, 300);
  }

  return {
    init: init
  };
})(jQuery);

// Mobile menu behaviours.
var MobileMenu = (function($) {
  $mobileMenu = $('.mobile-menu');
  $mainMenu = $('#menu-main-menu');

  function init() {
    $mobileMenu.click(function() {
      if ($(this).hasClass('active')) {
        closeMobileMenu();
      } else {
        openMobileMenu();
      }
    });
  }

  function closeMobileMenu() {
    $mobileMenu.removeClass('active');
    $mainMenu.removeClass('active');
  }

  function openMobileMenu() {
    $mobileMenu.addClass('active');
    $mainMenu.addClass('active');
  }

  return {
    init: init
  };
})(jQuery);

(function($) {
  $(document).foundation();
  ProductGrid.init();
  MobileMenu.init();
})(jQuery);
