<?php
/** Not found template. */
get_header();
?>
<main id="main-content" class="site-main site-main--404 content-wrap">
	<p class="eyebrow">404 · Azur Dent</p>
	<h1><?php esc_html_e( 'Pagina nu a fost găsită.', 'azur-dent' ); ?></h1>
	<p><?php esc_html_e( 'Folosește navigarea pentru a ajunge la serviciile cabinetului sau la pagina de contact.', 'azur-dent' ); ?></p>
	<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Înapoi la pagina principală', 'azur-dent' ); ?></a>
</main>
<?php get_footer(); ?>
