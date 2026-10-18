<?php
/** Footer template. */
$contact = azur_dent_contact_settings();
?>
<footer class="site-footer">
	<div class="site-footer__main">
		<div class="site-footer__brand">
			<a class="azur-wordmark azur-wordmark--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="azur-wordmark__name">Azur <em>Dent</em></span>
				<span class="azur-wordmark__place"><?php esc_html_e( 'APAHIDA · CLUJ', 'azur-dent' ); ?></span>
			</a>
			<p><?php esc_html_e( 'Cabinet stomatologic în Apahida, județul Cluj. Informații despre servicii și solicitări de programare.', 'azur-dent' ); ?></p>
		</div>
		<div class="site-footer__column">
			<h2><?php esc_html_e( 'Pagini utile', 'azur-dent' ); ?></h2>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'fallback_cb'    => 'azur_dent_fallback_menu',
				)
			);
			?>
			<div class="site-footer__quick-links">
				<a href="<?php echo esc_url( azur_dent_page_url( 'servicii' ) ); ?>"><?php esc_html_e( 'Servicii stomatologice', 'azur-dent' ); ?></a>
				<a href="<?php echo esc_url( azur_dent_page_url( 'programare' ) ); ?>"><?php esc_html_e( 'Formular de programare', 'azur-dent' ); ?></a>
			</div>
		</div>
		<div class="site-footer__column">
			<h2><?php esc_html_e( 'Contact și adresă', 'azur-dent' ); ?></h2>
			<p class="site-footer__address"><?php echo esc_html( $contact['address'] ); ?></p>
			<?php if ( ! empty( $contact['email'] ) && is_email( $contact['email'] ) ) : ?>
				<p><a href="mailto:<?php echo esc_attr( antispambot( $contact['email'] ) ); ?>"><?php echo esc_html( antispambot( $contact['email'] ) ); ?></a></p>
			<?php endif; ?>
			<?php if ( ! empty( $contact['phone'] ) ) : ?>
				<p><a href="tel:<?php echo esc_attr( azur_dent_phone_uri( $contact['phone'] ) ); ?>"><?php echo esc_html( $contact['phone'] ); ?></a></p>
			<?php endif; ?>
			<div class="site-footer__actions">
				<a class="footer-directions" href="<?php echo esc_url( azur_dent_directions_url() ); ?>" target="_blank" rel="noopener noreferrer">
					<span><?php esc_html_e( 'Deschide traseul în Google Maps', 'azur-dent' ); ?></span><span aria-hidden="true">↗</span>
				</a>
			</div>
		</div>
	</div>
	<div class="site-footer__bottom">
		<p>© <?php echo esc_html( wp_date( 'Y' ) ); ?> Azur Dent · Apahida, jud. Cluj</p>
		<div class="site-footer__bottom-links">
			<a href="<?php echo esc_url( azur_dent_page_url( 'confidentialitate' ) ); ?>"><?php esc_html_e( 'Informare privind confidențialitatea', 'azur-dent' ); ?></a>
			<button type="button" class="site-footer__top-btn" data-scroll-top><?php esc_html_e( 'Înapoi sus ↑', 'azur-dent' ); ?></button>
		</div>
	</div>
</footer>
<div class="azur-floating-bar" data-floating-bar hidden>
	<a class="azur-floating-bar__cta" href="<?php echo esc_url( azur_dent_page_url( 'programare' ) ); ?>">
		<span><?php esc_html_e( 'Programare', 'azur-dent' ); ?></span><span aria-hidden="true">↗</span>
	</a>
	<button type="button" class="azur-floating-bar__top" data-scroll-top aria-label="<?php esc_attr_e( 'Înapoi la începutul paginii', 'azur-dent' ); ?>">↑</button>
</div>
<dialog class="azur-lightbox" aria-label="<?php esc_attr_e( 'Galerie foto', 'azur-dent' ); ?>">
	<div class="azur-lightbox__top">
		<div class="azur-lightbox__meta">
			<span class="azur-lightbox__counter" aria-live="polite"></span>
			<p class="azur-lightbox__caption" aria-live="polite"></p>
		</div>
		<button class="azur-lightbox__close" type="button" aria-label="<?php esc_attr_e( 'Închide galeria', 'azur-dent' ); ?>">×</button>
	</div>
	<div class="azur-lightbox__image-wrap">
		<button class="azur-lightbox__nav azur-lightbox__nav--previous" type="button" aria-label="<?php esc_attr_e( 'Imaginea anterioară', 'azur-dent' ); ?>">←</button>
		<img class="azur-lightbox__image" src="" alt="" decoding="async">
		<button class="azur-lightbox__nav azur-lightbox__nav--next" type="button" aria-label="<?php esc_attr_e( 'Imaginea următoare', 'azur-dent' ); ?>">→</button>
	</div>
	<div class="azur-lightbox__bottom">
		<div class="azur-lightbox__dots" role="tablist" aria-label="<?php esc_attr_e( 'Selectează o imagine', 'azur-dent' ); ?>"></div>
		<p class="azur-lightbox__hint"><?php esc_html_e( 'Folosește săgețile ← → pentru navigare sau Esc pentru închidere', 'azur-dent' ); ?></p>
	</div>
</dialog>
<?php wp_footer(); ?>
</body>
</html>
