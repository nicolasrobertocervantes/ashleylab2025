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
                            foreach($sorted_news['Article'] as $year => $news_items): ?>
                                <div class="accordion-item">
                                    <input type="checkbox" id="year-<?php echo $year; ?>"<?php echo $year == date("Y") ? ' checked="true"' : ''; ?>>
                                    <label class="accordion-item-title" for="year-<?php echo $year; ?>">
                                        <?php echo '<h2 class="year">'.$year.'</h2>'; ?>
                                    </label>
                                    <div class="accordion-item-content">
                                        <?php 
                                        foreach($news_items as $post):
                                            setup_postdata( $post );
                                            get_template_part( 'template-parts/content', get_post_type() );
                                        endforeach;
                                        wp_reset_postdata();?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                                <div class="accordion-item">
                                    <input type="checkbox" id="year-2013">
                                    <label class="accordion-item-title" for="year-2013"><h2 class="year">2013 and earlier</h2></label>
                                    <div class="accordion-item-content">
                                        <?php 
                                        $earlier = get_post(1520); 
                                        echo $earlier->post_content;
                                        ?>
                                    </div>
                                </div>
                    </div>
                </div>

                    
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
