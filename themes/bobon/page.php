<?php get_header() ?>

<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <div class="row">
      <div class="small-12 columns">
        <h1 class="text-center single-page-title"><?php echo get_the_title() ?></h1>
      </div>
      <div class="small-12 columns page-content">
        <?php the_content() ?>
      </div>
    </div>
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer() ?>
