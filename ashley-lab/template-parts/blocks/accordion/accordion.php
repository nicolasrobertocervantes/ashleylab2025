<?php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'acccordion-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'accordion';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
// $header = get_field('header') ?: 'Your testimonial here...';
// $image = get_field('image');
// $content = get_field('content');
?>
<div class="accordion <?php echo esc_attr($classes); ?>" id="<?php echo $id; ?>">
    <?php
    $itemcount = 0;
    while ( the_repeater_field('accordion_item') ) { 
        $image = get_sub_field('image');
        ?>
        <div class="accordion-item">
            <input type="checkbox" id="item<?php echo $itemcount; ?>">
            <label class="accordion-item-title" for="item<?php echo $itemcount; ?>">
                <div class="accordion-item-image">
                <?php echo $image ? '<img src="'.$image['sizes']['thumbnail'].'"/>' : '<img />';?>
                </div>
                <h3>
                <?php echo get_sub_field('header'); ?>
                </h3>
                </label>
            <div class="accordion-item-content">
                <?php echo $image ? '<img src="'.$image['sizes']['medium'].'"/>' : '<img />';?>
                <div>
                <?php echo get_sub_field('content'); ?>
                </div>
            </div>
        </div>
    <?php
    $itemcount++;
    }
    ?>
</div>
