// Mobile sidebar behaviours.
var mobileSidebar = (function($) {
  function init() {
    var $sidebar = $('.chapter-sidebar');
    var $sidebarToggle = $('.chapter-sidebar-toggle');
    $sidebarToggle.click(function(e) {
      e.preventDefault();
      $sidebar.toggleClass('active');
      $(this).toggleClass('active');
    });
  }
  return {
    init: init
  };
})(jQuery);

var footer = (function($) {
  function init() {
    var $footer = $('#footer'),
        fTop = $footer.position().top;
    console.log($('html').height());
    console.log(fTop);
    if ($('html').height() > (fTop + $footer.height())) {
      $footer.css({
        bottom: 0,
        left: 0,
        position: "fixed"
      });
    }
  }

  return {
    init: init
  };
})(jQuery);

var hierarchyDrawer = (function($) {
  function init() {
    $('.hierarchy-toggle').click(function(e) {
      e.preventDefault();
      var $this = $(this),
          $drawer = $('#' + $this.attr('data-toggle'));
      if ($this.hasClass('active')) {
        $this.removeClass('active');
        $drawer.removeClass('active');
      } else {
        $('.hierarchy-drawer.active').removeClass('active');
        $('.hierarchy-toggle.active').removeClass('active');
        $this.addClass('active');
        $drawer.addClass('active');
      }
    });
  }

  return {
    init: init
  };
})(jQuery);

(function($) {
  $(document).foundation();
  mobileSidebar.init();
  hierarchyDrawer.init();
  footer.init();
})(jQuery);
