<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

?>

	<?php 
	$photo = get_field('photo');
	$bio = get_field('bio');
	?>

        <div class="accordion-item">
            <input type="checkbox" id="item-<?php the_id(); ?>">
            <label class="accordion-item-title" for="item-<?php the_id(); ?>">
                <div class="accordion-item-image">
                <?php echo $photo ? '<img src="'.$photo['sizes']['thumbnail'].'"/>' : '<img />';?>
                </div>
                <h3>
                <?php echo get_the_title(); ?>
                </h3>
                </label>
            <div class="accordion-item-content">
                <?php echo $photo ? '<img src="'.$photo['sizes']['medium'].'"/>' : '<img />';?>
                <div class="acccordion-bio">
                <?php echo $bio; ?>
                </div>
            </div>
        </div>
