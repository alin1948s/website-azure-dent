<?php
/** Fallback template. */
get_header();
?>
<main id="main-content" class="site-main site-main--archive">
	<div class="content-wrap">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'entry' ); ?> id="post-<?php the_ID(); ?>">
					<header class="entry-header"><h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1></header>
					<div class="entry-content"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<h1><?php esc_html_e( 'Nu există articole publicate.', 'azur-dent' ); ?></h1>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
