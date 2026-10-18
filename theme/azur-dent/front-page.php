<?php
/** Front page uses the editable Gutenberg page content. */
get_header();
?>
<main id="main-content" class="site-main site-main--front">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'page-entry page-entry--home' ); ?> id="post-<?php the_ID(); ?>">
			<div class="entry-content"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
