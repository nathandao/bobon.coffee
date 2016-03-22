<?php
/*
 * Template Name: Library Listing
 */
?>

<?php get_header() ?>
<?php include_once( get_template_directory() . '/includes/top-nav.php' ) ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <div class="small-12 columns row">
    <h1 class="page-title"><?php the_title() ?></h1>
  </div>
  <div class="row">
    <article class="small-12 large-5 columns border-bottom">
      <?php echo the_content() ?>
    </article>
  </div>

  <?php $top_pages = get_post_type_parents( 'chapter' ); ?>
  <?php if ( !empty( $top_pages ) ) : ?>
    <?php foreach ( $top_pages as $top_page ) : ?>
      <div class="small-12 columns row hierarchy-toggle" data-toggle="hierarchy-drawer-<?php echo $top_page->ID ?>">
        <div class="small-12 large-5 columns">
          <h2 class="side-padding btn btn-primary"><?php echo $top_page->post_title ?></h2>
        </div>
        <div class="large-5 small-12 columns hierarchy-list border-left">
          <?php echo $top_page->post_content ?>
        </div>
      </div>
      <div class="small-12 large-7 columns hierarchy-drawer hierarchy-list" id="hierarchy-drawer-<?php echo $top_page->ID ?>">
        <h1><?php echo $top_page->post_title ?></h1>
        <?php echo get_page_hierarchy_html( $top_page->ID, $top_page->ID, "row" ) ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
