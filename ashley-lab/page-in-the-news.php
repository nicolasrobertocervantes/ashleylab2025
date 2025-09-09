<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
        <header class="entry-header ast-no-thumbnail ast-no-meta">
            <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
        </header>
            <?php
            $news = get_posts(array(
                'post_type' => 'news',
                'meta_key'          => 'date',
                'orderby'           => 'meta_value',
                'order'             => 'DESC',
                'posts_per_page'    => -1,
            ) );

            if($news):

                $sorted_news = array();

                foreach($news as $news_item):
                    $type = get_field('type', $news_item->ID);
                    $date = get_field('date', $news_item->ID);
                    $year = date('Y', strtotime($date));
                    $sorted_news[$type][$year][] = $news_item;
                endforeach;

                if(is_array($sorted_news['Article'])): ?>

                <div class="accordion-item">
                    <input type="checkbox" id="articles" checked="true">
                    <label class="accordion-item-title" for="articles">
                        <h2>Articles</h2>
                    </label>
                    
                    <div class="accordion-item-content">
    <?php
    // Get current year
    $current_year = date("Y");
    
    // First, organize all posts by year based on the ACF date field
    $posts_by_year = array();
    $earlier_posts = array();
    
    // Loop through all news items and organize by year from the ACF date field
    foreach($sorted_news['Article'] as $year => $news_items):
        foreach($news_items as $post):
            // Get the ACF date field for this post
            $post_date = get_field('date', $post->ID);
            
            // Extract year from the date
            $post_year = $post_date ? date('Y', strtotime($post_date)) : $year;
            
            // Separate recent years (2020-current) from earlier years (2019 and earlier)
            if ($post_year >= 2020 && $post_year <= $current_year) {
                if (!isset($posts_by_year[$post_year])) {
                    $posts_by_year[$post_year] = array();
                }
                $posts_by_year[$post_year][] = $post;
            } elseif ($post_year <= 2019 && $post_year > 2010) {
                if (!isset($earlier_posts[$post_year])) {
                    $earlier_posts[$post_year] = array();
                }
                $earlier_posts[$post_year][] = $post;
            }
        endforeach;
    endforeach;
    
    // Sort recent years in descending order (newest first)
    krsort($posts_by_year);
    
    // Display years from current year down to 2020 with thumbnails
    foreach($posts_by_year as $year => $year_posts): ?>
        <div class="accordion-item">
            <input type="checkbox" id="year-<?php echo $year; ?>"<?php echo $year == $current_year ? ' checked="true"' : ''; ?>>
            <label class="accordion-item-title" for="year-<?php echo $year; ?>">
                <?php echo '<h2 class="year">'.$year.'</h2>'; ?>
            </label>
            <div class="accordion-item-content">
                <?php 
                foreach($year_posts as $post):
                    setup_postdata($post);
                    get_template_part('template-parts/content', get_post_type());
                endforeach;
                wp_reset_postdata();?>
            </div>
        </div>
    <?php endforeach; ?>
    
    <!-- 2019 and earlier section -->
    <?php if (!empty($earlier_posts)): ?>
    <div class="accordion-item">
        <input type="checkbox" id="year-2019-and-earlier">
        <label class="accordion-item-title" for="year-2019-and-earlier"><h2 class="year">2019 and earlier</h2></label>
        <div class="accordion-item-content">
            <?php 
            // Sort earlier years in descending order
            krsort($earlier_posts);
            
            echo '<div class="earlier-years-container">';
            
            foreach($earlier_posts as $year => $year_posts):
                echo '<div class="earlier-year-group">';
                echo '<p class="earlier-year"><strong>' . $year . '</strong></p>';
                echo '<ul class="earlier-posts-list">';
                
                
                foreach($year_posts as $post):
                    setup_postdata($post);
                    // Get the ACF link field
                    $acf_link = get_field('link', $post->ID);
                    
                    echo '<li class="earlier-post-item">';
                    // Use ACF link field if available, otherwise use permalink
                    if ($acf_link) {
                        echo '<a href="' . esc_url($acf_link) . '" target="_blank">' . get_the_title() . '</a>';
                    } else {
                        echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
                    }
                    echo '</li>';
                endforeach;
                
                echo '</ul>';
                echo '</div>';
            endforeach;
            
            echo '</div>';
            wp_reset_postdata();
            ?>
        </div>
        <div class="accordion-item-content">
            <?php 
                $earlier = get_post(1520); 
                echo $earlier->post_content;
                ?>
        </div>
    </div>
    <?php endif; ?>
</div>

                </div> <!-- accordion-item -->

                    
                <?php
                endif;

                if(is_array($sorted_news['Video'])): ?>
                    <div class="accordion-item">
                        <input type="checkbox" id="videos">
                        <label class="accordion-item-title" for="videos">
                            <h2>Video</h2>
                        </label>
                        <div class="accordion-item-content">
                        <?php
                        foreach($sorted_news['Video'] as $year => $news_items):
                            // echo '<h2 class="year">'.$year.'</h2>';
                            foreach($news_items as $post):
                                setup_postdata( $post );
                                get_template_part( 'template-parts/content', get_post_type() );
                            endforeach;

                            wp_reset_postdata();
                        endforeach;
                        ?>
                        </div>
                    </div>
                <?php endif;

                if(is_array($sorted_news['Audio'])): ?>
                    <div class="accordion-item">
                        <input type="checkbox" id="audio">
                        <label class="accordion-item-title" for="audio">
                            <h2>Audio</h2>
                        </label>
                        <div class="accordion-item-content">
                        <?php
                        foreach($sorted_news['Audio'] as $year => $news_items):
                            // echo '<h2 class="year">'.$year.'</h2>';
                            foreach($news_items as $post):
                                setup_postdata( $post );
                                get_template_part( 'template-parts/content', get_post_type() );
                            endforeach;

                            wp_reset_postdata();
                        endforeach;
                        ?>
                        </div>
                    </div>
                <?php endif;

            endif;

            ?>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
