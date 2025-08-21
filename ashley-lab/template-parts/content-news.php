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

<?php astra_entry_before(); ?>

<article
<?php
		echo astra_attr(
			'article-content',
			array(
				'id'    => 'post-' . get_the_id(),
				'class' => join( ' ', get_post_class() ),
			)
		);
		?>
>
	<?php astra_entry_top(); ?>

	<div class="news">
		<?php if(get_field('type') == 'Article' || get_field('type') == 'Audio'): ?>
			<div class="news-thumbnail">
				<img src="<?php echo get_field('image')['sizes']['thumbnail']; ?>" />
			</div>
			<div>
				<h3><?php the_title(); ?></h3>
				<p class="source"><?php the_field('source');?>,&nbsp;<?php the_field('date'); ?></p>
				<a target="_blank" href="<?php the_field('link'); ?>">Read More </a>
			</div>
		<?php endif; ?>
		<?php if(get_field('type') == 'Video'):
			the_field('embed');
		endif;
		?>

	</div>

	<footer class="entry-footer">
		<?php astra_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php astra_entry_bottom(); ?>

</article><!-- #post-## -->

<?php astra_entry_after(); ?>
