<?php get_header() ?>
<?php include_once( get_template_directory() . '/includes/top-nav.php' ); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <?php if ( $post_type === "chapter" ) : ?>
    <?php $parent_id = wp_get_post_parent_id( $post->ID ) ?>
    <div class="large-12 row">
      <?php include_once( get_template_directory() . '/includes/chapter-sidebar.php' ) ?>
      <article class="large-9 columns large-offset-3 chapter-content">
        <h1 class="page-title"><?php the_title() ?></h1>
        <?php the_content() ?>
      </article>
    </div>
  <?php endif; ?>
<?php endwhile; endif; ?>
<?php get_footer() ?>
