<?php get_header() ?>

<div class="row">
  <div class="large-12 columns">
    <div class="logo"></div>
  </div>
</div>
<div class="row">
  <div class="small-12 large-6 columns">
    <?php
    $args = array(
      'menu' => 'home-nav',
      'menu-class' => 'home-menu',
      'container' => '',
    );
    wp_nav_menu($args);
    ?>
  </div>
  <div class="small-12 large-6 columns">
  </div>
</div>

<?php get_footer() ?>
