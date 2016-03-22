<div class="sticky-menu">
  <div class="large-12 columns row full-width">
    <a href="/" class="nav-logo"><img src="<?php echo get_template_directory_uri() . "/images/logo_small.png" ?>"/></a>
    <?php
    $args = array(
      'menu' => 'main-menu',
      'menu-class' => 'main-menu',
      'container' => '',
    );
    wp_nav_menu($args);
    ?>
  </div>
</div>
