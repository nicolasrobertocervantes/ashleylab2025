<?php
/*
Template Name: Staff Accordion Page
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
        <header class="entry-header ast-no-thumbnail ast-no-meta">
            <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
        </header>
    <?php
        // Display editable content at the top of the page
        while (have_posts()) : the_post();
            the_content();
        endwhile;
        ?>

        <!-- Custom Accordion for Featured Team Members -->
        <div class="team-accordion tax-team">
            <?php
            // Query to get featured Team members
            $args = array(
                'post_type'      => 'people',
                'posts_per_page' => -1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'team',           // Custom taxonomy name
                        'field'    => 'slug',          // Use the term slug
                        'terms'    => 'field-scholarship', // Slug of the term in the 'team' taxonomy
                    ),
                ),
            );

            $team_query = new WP_Query($args);

            if ($team_query->have_posts()) :
                while ($team_query->have_posts()) : $team_query->the_post();
                    $team_image = get_field('photo'); // ACF image field
                    $team_bio   = get_field('bio');   // ACF bio field
                    ?>

                    <div class="accordion-item">
                        <input type="checkbox" id="item-<?php the_id(); ?>">
                        <label class="accordion-item-title" for="item-<?php the_id(); ?>">
                            <div class="accordion-item-image">
                            <?php echo $team_image ? '<img src="'.$team_image['sizes']['thumbnail'].'"/>' : '<img />';?>
                            </div>
                            <h3>
                            <?php echo get_the_title(); ?>
                            </h3>
                            </label>
                        <div class="accordion-item-content">
                            <?php echo $team_image ? '<img src="'.$team_image['sizes']['medium'].'"/>' : '<img />';?>
                            <div class="acccordion-bio">
                            <?php echo $team_bio; ?>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '';
            endif;
            ?>
        </div>
    
</div> <!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

    <?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>