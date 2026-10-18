<?php
/** Page template. */
get_header();
?>
<main id="main-content" class="site-main site-main--page">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'page-entry' ); ?> id="post-<?php the_ID(); ?>">
			<div class="entry-content"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
