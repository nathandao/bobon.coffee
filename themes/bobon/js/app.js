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

(function($) {
  $(document).foundation();
  mobileSidebar.init();
})(jQuery);
