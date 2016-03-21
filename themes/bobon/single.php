<?php get_header() ?>
<?php include ('nav.php'); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <?php if ( $post_type === "chapter" ) ?>
  <div class="large-12 row">
    <div class="large-3 columns sidebar">
      <?php
      $top_page_id = get_top_parent( $post_id );
      $parent_page = get_post( $top_page_id );
      ?>
      <h2><?php echo $parent_page->post_title ?></h2>
      <?php echo get_page_sidebar_menu( $post->ID ) ?>
    </div>

    <div class="large-9 columns">
      <h1><?php the_title() ?></h1>
      <?php the_content() ?>
    </div>
  </div>
  <?php endif ?>
<?php endwhile; endif; ?>

<?php get_footer() ?>
