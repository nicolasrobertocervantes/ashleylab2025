<?php
/**
 * Ashley Lab Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ashley Lab
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASHLEY_LAB_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'ashley-lab-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASHLEY_LAB_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

add_action('acf/init', 'ashley_accordion');
function ashley_accordion() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'accordion',
            'title'             => __('Accordion'),
            'description'       => __('A custom accordion block.'),
            'render_template'   => 'template-parts/blocks/accordion/accordion.php',
            'enqueue_style'     => get_stylesheet_directory_uri() . '/template-parts/blocks/accordion/accordion.css',
            'category'          => 'formatting',
            // 'icon'              => 'admin-comments',
            // 'keywords'          => array( 'accordion', 'quote' ),
            // 'supports'          => array(
            //     'align' => true,
            //     'mode' => true,
            //     'jsx' => true
            // ),
        ));
    }
}

function ashley_custom_post_types() {
 
    register_post_type( 'news',
        array(
            'labels' => array(
                'name' => __( 'News' ),
                'singular_name' => __( 'News' )
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'news'),
            'show_in_rest' => true,
            'supports' => array('title'),
 
        )
    );

    register_post_type( 'people',
        array(
            'labels' => array(
                'name' => __( 'People' ),
                'singular_name' => __( 'Person' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'team'),
            'show_in_rest' => true,
            'supports' => array('title'),
            'taxonomies' => array('people'),
        )
    );

}

add_action( 'init', 'ashley_custom_post_types' );


add_action( 'init', 'create_team_taxonomy', 0 );
 
function create_team_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Team', 'taxonomy general name' ),
    'singular_name' => _x( 'Team', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Team' ),
    'all_items' => __( 'All Team Members' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Team' ), 
    'update_item' => __( 'Update Team' ),
    'add_new_item' => __( 'Add New Team' ),
    'new_item_name' => __( 'New Team Name' ),
    'separate_items_with_commas' => __( 'Separate teams with commas' ),
    'add_or_remove_items' => __( 'Add or remove teams' ),
    'choose_from_most_used' => __( 'Choose from the most used teams' ),
    'menu_name' => __( 'Team' ),
  ); 
 
// Now register the non-hierarchical taxonomy like tag
 
  register_taxonomy('team','people',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'team' ),
  ));
}

function accordion_enqueue_scripts() {
    wp_enqueue_script(
        'custom-accordion-script',
        get_template_directory_uri() . '/js/accordion-script.js',
        array('jquery'),
        '1.0.0',
        true 
    );
}
add_action('wp_enqueue_scripts', 'accordion_enqueue_scripts');

