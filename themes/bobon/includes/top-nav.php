<div class="sticky-menu">
  <div class="large-12 columns row">
    <a href="/" class="nav-logo"><img src="<?php echo get_template_directory_uri() . "/images/logo_small.png" ?>"/></a>
    <?php
    $args = array(
      'menu' => 3,
      'menu-class' => 'main-menu',
      'container' => '',
    );
    wp_nav_menu($args);
    ?>
  </div>
</div>
