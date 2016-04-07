<?php

// Register stuff during init.
function bobon_init() {
    add_theme_support( 'post-thumbnails' );
    register_nav_menu('main-nav',__( 'Main Menu' ));
    register_nav_menu('home-nav',__( 'Home Menu' ));
}
add_action( 'init', 'bobon_init' );

// Queue custom css and js files.
function add_theme_scripts() {
    wp_enqueue_style( 'app', get_template_directory_uri() . "/css/app.css" );

    // Register foundation.js dependency.
    wp_register_script( 'foundation', get_template_directory_uri() . '/bower_components/foundation-sites/dist/foundation.min.js', array ( 'jquery' ), 1.1, true);

    // App js file.
    wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js', array ( 'foundation' ), 1.1, true);
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

// Register Custom Post Types
function custom_post_type() {
    $labels = array(
        'name'                  => _x( 'Chapters', 'Chapter', 'bobon' ),
        'singular_name'         => _x( 'Chapter', 'Chapter', 'bobon' ),
        'menu_name'             => __( 'Farmer\'s Library', 'bobon' ),
        'name_admin_bar'        => __( 'Chapter', 'bobon' ),
        'archives'              => __( 'Item Archives', 'bobon' ),
        'parent_item_colon'     => __( 'Parent Item:', 'bobon' ),
        'all_items'             => __( 'All Chapters', 'bobon' ),
        'add_new_item'          => __( 'Add New Chapter', 'bobon' ),
        'add_new'               => __( 'Add New', 'bobon' ),
        'new_item'              => __( 'New Item', 'bobon' ),
        'edit_item'             => __( 'Edit Item', 'bobon' ),
        'update_item'           => __( 'Update Item', 'bobon' ),
        'view_item'             => __( 'View Item', 'bobon' ),
        'search_items'          => __( 'Search Item', 'bobon' ),
        'not_found'             => __( 'Not found', 'bobon' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'bobon' ),
        'featured_image'        => __( 'Featured Image', 'bobon' ),
        'set_featured_image'    => __( 'Set featured image', 'bobon' ),
        'remove_featured_image' => __( 'Remove featured image', 'bobon' ),
        'use_featured_image'    => __( 'Use as featured image', 'bobon' ),
        'insert_into_item'      => __( 'Insert into item', 'bobon' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'bobon' ),
        'items_list'            => __( 'Items list', 'bobon' ),
        'items_list_navigation' => __( 'Items list navigation', 'bobon' ),
        'filter_items_list'     => __( 'Filter items list', 'bobon' ),
    );
    $args = array(
        'label'                 => __( 'Chapter', 'bobon' ),
        'description'           => __( 'All chapters', 'bobon' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'custom-fields', 'revisions', 'thumbnail', 'page-attributes', 'author', 'excerpt' ),
        'taxonomies'            => array( 'chapter_type' ),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'rest_base'             => 'farmer_library',
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'chapter', $args );
}
add_action( 'init', 'custom_post_type', 0 );

// Register Custom Chapter Category
function custom_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Chapter Categories', 'Chapter Categories', 'bobon' ),
        'singular_name'              => _x( 'Chapter Category', 'Chapter Category', 'bobon' ),
        'menu_name'                  => __( 'Chapter Categories', 'bobon' ),
        'all_items'                  => __( 'All Items', 'bobon' ),
        'parent_item'                => __( 'Parent Item', 'bobon' ),
        'parent_item_colon'          => __( 'Parent Item:', 'bobon' ),
        'new_item_name'              => __( 'New Item Name', 'bobon' ),
        'add_new_item'               => __( 'Add New Item', 'bobon' ),
        'edit_item'                  => __( 'Edit Item', 'bobon' ),
        'update_item'                => __( 'Update Item', 'bobon' ),
        'view_item'                  => __( 'View Item', 'bobon' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'bobon' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'bobon' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'bobon' ),
        'popular_items'              => __( 'Popular Items', 'bobon' ),
        'search_items'               => __( 'Search Items', 'bobon' ),
        'not_found'                  => __( 'Not Found', 'bobon' ),
        'no_terms'                   => __( 'No items', 'bobon' ),
        'items_list'                 => __( 'Items list', 'bobon' ),
        'items_list_navigation'      => __( 'Items list navigation', 'bobon' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'chapter_category', array( 'chapter' ), $args );

}
add_action( 'init', 'custom_taxonomy', 0 );

// Display a custom taxonomy dropdown in admin.
add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy');
function tsm_filter_post_type_by_taxonomy() {
    global $typenow;
    $post_type = 'product'; // change to your post type
    $taxonomy  = 'product_type'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All {$info_taxonomy->label}"),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}

// Filter posts by taxonomy in admin.
function tsm_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'product'; // change to your post type
	$taxonomy  = 'product_type'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}
add_filter('parse_query', 'tsm_convert_id_to_term_in_query');

function allowed_post_types($allowed_post_types) {
    $allowed_post_types[] = 'chapter';
    return $allowed_post_types;
}
add_filter( 'rest_api_allowed_post_types', 'allowed_post_types');

// Get the top parent page of the current page.
// Used for library chapters on sidebar.
function get_top_parent( $post_id ) {
  $top_post_id = false;
  $parent_post_id = wp_get_post_parent_id( $post_id );
  while ( $parent_post_id != false ) {
    $top_post_id = $parent_post_id;
    $parent_post_id = wp_get_post_parent_id( $parent_post_id );
  }
  if ( $top_post_id === false ) {
    $top_post_id = $parent_post_id;
  }
  return $top_post_id;
}

// Get the hierachy array that contains all the children posts of a post
function get_page_hierarchy_html( $top_page_id, $post_id, $class = "" ) {
  $output = "";
  $args = array(
    'hierarchical' => 1,
    'offset' => 0,
    'order'=>'ASC',
    'sort_column' => 'menu_order',
    'parent' => $top_page_id,
    'post_status' => 'publish',
    'post_type' => 'chapter'
  ); 
  $pages = get_pages( $args );
  // Return nothing if there is no child page
  if ( empty( $pages ) ) {
    return "";
  }
  $output = "<ul>";
  if ( $class !== "" ) {
    $output = "<ul class='" . $class . "'>";
  }
  // Loop through the pages
  foreach ( $pages as $page ) {
    $permalink = get_the_permalink( $page->ID );
    $link_class = "";
    if ( $page->ID === $post_id ) {
      $link_class = "class = 'active'";
    }
    $output .= "<li class='small-12 columns row'><a href='" . $permalink . "' " . $link_class . ">" . $page->post_title . "</a>";
    $output .= get_page_hierarchy_html( $page->ID, $post_id );
    $output .= "</li>";
  }
  $output .= "</ul>";
  return $output;
}

function get_page_sidebar_menu( $post_id, $class = "" ) {
  $top_page_id = get_top_parent( $post_id );
  return get_page_hierarchy_html( $top_page_id, $post_id, $class );
}

function get_post_type_parents( $post_type ) {
  $top_pages = array();
  $args = array(
    'hierarchical' => -1,
    'offset' => 0,
    'order' => 'ASC',
    'post_status' => 'publish',
    'post_type' => $post_type,
    'sort_column' => 'menu_order'
  );
  $pages = get_pages( $args );
  foreach ( $pages as $page ) {
    $parent_id = wp_get_post_parent_id( $page->ID );
    if ($parent_id == 0) {
      $top_pages[] = $page;
    }
  }
  return $top_pages;
}

function bobon_get_page_title() {
  $title = get_the_title();
  if ( !is_home() ) {
    $title = "Bobon | " . $title;
  }
  return $title;
}
