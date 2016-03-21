<?php
$top_page_id = get_top_parent( $post->ID );
$parent_page = get_post( $top_page_id );
?>

<h2><?php echo $parent_page->post_title ?></h2>
<?php echo get_page_sidebar_menu( $post->ID, "row" ) ?>
