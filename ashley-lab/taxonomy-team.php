<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php
			$team = get_queried_object();
			$current_team =  $team->name;

			$people_query = new WP_Query( array(
			    'post_type' => 'people',
			    'posts_per_page' => -1,
			    'tax_query' => array(
			        array (
			            'taxonomy' => 'team',
			            'field' => 'slug',
			            'terms' => $current_team,
			        )
			    ),
			) );
			$people = $people_query->posts;
			?>
			<header class="entry-header ast-no-thumbnail ast-no-meta">
				<h1 class="entry-title" itemprop="headline" style="font-size: 2.5rem;"><?php echo $current_team; ?></h1>
			</header>
			<div class="accordion people">
			<?php 
			if(is_array($people)):
				foreach ($people as $person) {
					$parts     = explode(" ", $person->post_title);
				    $lastname  = array_pop($parts);
				    $person->last_name = $lastname;  				
				}
			function cmp($a, $b) {
			    return strcmp($a->last_name, $b->last_name);
			}

			usort($people, "cmp");
			foreach($people as $post):
                setup_postdata( $post );
                get_template_part( 'template-parts/content', get_post_type() );
            endforeach;
            wp_reset_postdata();
            endif;
			?>
			</div>


		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
