<?php get_header() ?>
<?php include_once( get_template_directory() . '/includes/top-nav.php' ); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <?php if ( $post_type === "chapter" ) : ?>
    <div class="large-12 row">
      <div class="medium-4 large-3 columns sidebar chapter-sidebar">
        <?php include_once( get_template_directory() . '/includes/chapter-hierarchy.php' ) ?>
      </div>
      <span class="chapter-sidebar-toggle">
        <?php echo __( 'Phụ lục >', 'bobon' ) ?>
      </span>
      <article class="medium-8 large-9 columns medium-offset-4 large-offset-3">
        <h1 class="chapter-title row"><?php the_title() ?></h1>
        <?php the_content() ?>
      </article>
    </div>
  <?php endif; ?>
<?php endwhile; endif; ?>
<?php get_footer() ?>
