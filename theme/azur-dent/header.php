<?php
/** Header template. */
$contact = azur_dent_contact_settings();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Sari la conținut', 'azur-dent' ); ?></a>
<div class="site-utility">
	<div class="site-utility__inner">
		<div class="site-utility__left">
			<p><span class="site-utility__role"><?php esc_html_e( 'Cabinet stomatologic · ', 'azur-dent' ); ?></span><?php esc_html_e( 'Apahida, jud. Cluj', 'azur-dent' ); ?></p>
			<?php if ( ! empty( $contact['address'] ) ) : ?>
				<span class="site-utility__sep" aria-hidden="true">·</span>
				<span class="site-utility__address"><?php echo esc_html( $contact['address'] ); ?></span>
			<?php endif; ?>
		</div>
		<div class="site-utility__actions">
			<?php if ( ! empty( $contact['email'] ) && is_email( $contact['email'] ) ) : ?>
				<a class="site-utility__email" href="mailto:<?php echo esc_attr( antispambot( $contact['email'] ) ); ?>"><?php echo esc_html( antispambot( $contact['email'] ) ); ?></a>
			<?php endif; ?>
			<?php if ( ! empty( $contact['phone'] ) ) : ?>
				<a class="site-utility__phone" href="tel:<?php echo esc_attr( azur_dent_phone_uri( $contact['phone'] ) ); ?>"><?php echo esc_html( $contact['phone'] ); ?></a>
			<?php endif; ?>
			<a class="site-utility__link" href="<?php echo esc_url( azur_dent_directions_url() ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Traseu Google Maps', 'azur-dent' ); ?> <span aria-hidden="true">↗</span>
			</a>
		</div>
	</div>
</div>
<header class="site-header" data-sticky-header>
	<div class="site-header__inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="azur-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Azur Dent — Acasă">
					<span class="azur-wordmark__name">Azur <em>Dent</em></span>
					<span class="azur-wordmark__place"><?php esc_html_e( 'APAHIDA · CLUJ', 'azur-dent' ); ?></span>
				</a>
			<?php endif; ?>
		</div>
		<button class="menu-toggle" type="button" aria-controls="primary-navigation" aria-expanded="false">
			<span class="menu-toggle__text"><?php esc_html_e( 'Meniu', 'azur-dent' ); ?></span>
			<span class="menu-toggle__lines" aria-hidden="true"><i></i><i></i></span>
		</button>
		<nav class="site-navigation" id="primary-navigation" aria-label="<?php esc_attr_e( 'Navigare principală', 'azur-dent' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-navigation__list',
					'fallback_cb'    => 'azur_dent_fallback_menu',
				)
			);
			?>
		</nav>
		<a class="button button--dark site-header__cta" href="<?php echo esc_url( azur_dent_page_url( 'programare' ) ); ?>">
			<span><?php esc_html_e( 'Solicită o programare', 'azur-dent' ); ?></span><span class="button__arrow" aria-hidden="true">↗</span>
		</a>
	</div>
	<div class="site-header__progress" aria-hidden="true"><span class="site-header__progress-bar"></span></div>
</header>
