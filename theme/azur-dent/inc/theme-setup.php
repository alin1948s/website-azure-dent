<?php
/** Theme support, assets, and reusable helpers. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function azur_dent_setup() {
	load_theme_textdomain( 'azur-dent', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 84, 'width' => 240, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_post_type_support( 'page', 'excerpt' );
	add_editor_style( array( 'assets/css/main.css', 'assets/css/editor.css' ) );
	register_nav_menus(
		array(
			'primary' => __( 'Navigare principală', 'azur-dent' ),
			'footer'  => __( 'Navigare footer', 'azur-dent' ),
		)
	);
}
add_action( 'after_setup_theme', 'azur_dent_setup' );

function azur_dent_register_pattern_category() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category( 'azur-dent', array( 'label' => __( 'Azur Dent', 'azur-dent' ) ) );
	}
}
add_action( 'init', 'azur_dent_register_pattern_category' );

function azur_dent_enqueue_assets() {
	$css_path = get_template_directory() . '/assets/css/main.css';
	$js_path  = get_template_directory() . '/assets/js/main.js';
	wp_enqueue_style( 'azur-dent-main', get_template_directory_uri() . '/assets/css/main.css', array(), file_exists( $css_path ) ? filemtime( $css_path ) : AZUR_DENT_VERSION );
	wp_enqueue_script( 'azur-dent-main', get_template_directory_uri() . '/assets/js/main.js', array(), file_exists( $js_path ) ? filemtime( $js_path ) : AZUR_DENT_VERSION, true );
	wp_localize_script(
		'azur-dent-main',
		'azurDent',
		array(
			'today'               => current_time( 'Y-m-d' ),
			'close'               => __( 'Închide galeria', 'azur-dent' ),
			'previous'            => __( 'Imaginea anterioară', 'azur-dent' ),
			'next'                => __( 'Imaginea următoare', 'azur-dent' ),
			'copied'              => __( 'Copiat ✓', 'azur-dent' ),
			'serviceDescriptions' => function_exists( 'azur_dent_service_descriptions' ) ? azur_dent_service_descriptions() : array(),
			'bookingUrl'          => azur_dent_page_url( 'programare' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'azur_dent_enqueue_assets' );

function azur_dent_page_url( $slug ) {
	$page = get_page_by_path( sanitize_title( $slug ), OBJECT, 'page' );
	return $page ? get_permalink( $page ) : home_url( '/' );
}

function azur_dent_image_url( $name, $width = 1280 ) {
	$allowed_names = array(
		'chair-room', 'reception', 'treatment-chair', 'consultation-model',
		'patient-checkup', 'consultation-tablet', 'instrument-drawer', 'tools-teal',
	);
	$width = absint( $width );
	if ( ! in_array( $name, $allowed_names, true ) || ! in_array( $width, array( 720, 1280, 1800 ), true ) ) {
		return '';
	}
	return get_template_directory_uri() . '/assets/images/' . $name . '-' . $width . '.webp';
}

function azur_dent_image_block( $name, $alt, $caption, $loading = 'lazy', $class_name = '' ) {
	$path = get_template_directory() . '/assets/images/' . sanitize_file_name( $name ) . '-1280.webp';
	$dimensions = file_exists( $path ) ? getimagesize( $path ) : array( 1280, 850 );
	$width      = isset( $dimensions[0] ) ? absint( $dimensions[0] ) : 1280;
	$height     = isset( $dimensions[1] ) ? absint( $dimensions[1] ) : 850;
	$src720     = azur_dent_image_url( $name, 720 );
	$src1280    = azur_dent_image_url( $name, 1280 );
	$src1800    = azur_dent_image_url( $name, 1800 );
	$alt        = esc_attr( $alt );
	$caption    = esc_html( $caption );
	$class_name = trim( $class_name );
	if ( '' !== $class_name ) {
		$class_name = implode( ' ', array_filter( array_map( 'sanitize_html_class', preg_split( '/\\s+/', $class_name ) ) ) );
	}
	$class_attr = $class_name ? ' ' . $class_name : '';
	$fetch      = 'eager' === $loading ? ' fetchpriority="high"' : '';

	return '<!-- wp:html -->'
		. '<figure class="wp-block-image size-large azur-lightbox-item' . esc_attr( $class_attr ) . '"><a href="' . esc_url( $src1800 ) . '" data-azur-lightbox aria-label="' . esc_attr( sprintf( __( 'Deschide fotografia: %s', 'azur-dent' ), wp_strip_all_tags( $alt ) ) ) . '">'
		. '<img src="' . esc_url( $src1280 ) . '" srcset="' . esc_url( $src720 ) . ' 720w, ' . esc_url( $src1280 ) . ' 1280w, ' . esc_url( $src1800 ) . ' 1800w" sizes="(max-width: 760px) 100vw, (max-width: 1220px) 48vw, 580px" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" alt="' . $alt . '" loading="' . esc_attr( $loading ) . '" decoding="async"' . $fetch . ' />'
		. '</a><figcaption class="wp-element-caption">' . $caption . '</figcaption></figure><!-- /wp:html -->';
}

function azur_dent_get_image_alt( $name ) {
	$alts = array(
		'chair-room'         => __( 'Cabinet stomatologic ilustrativ, cu scaun dentar și lumină de consultație', 'azur-dent' ),
		'reception'          => __( 'Spațiu de așteptare medical generic, fotografie ilustrativă', 'azur-dent' ),
		'treatment-chair'    => __( 'Scaun dentar într-o încăpere luminoasă, fotografie ilustrativă', 'azur-dent' ),
		'consultation-model' => __( 'Medic stomatolog discută cu un pacient, fotografie ilustrativă', 'azur-dent' ),
		'patient-checkup'    => __( 'Consultație stomatologică, fotografie ilustrativă', 'azur-dent' ),
		'consultation-tablet'=> __( 'Discuție între medic și pacient, fotografie ilustrativă', 'azur-dent' ),
		'instrument-drawer'  => __( 'Instrumente stomatologice pregătite într-un sertar, fotografie ilustrativă', 'azur-dent' ),
		'tools-teal'         => __( 'Instrumente dentare pe material verde-albăstrui, fotografie ilustrativă', 'azur-dent' ),
	);
	return isset( $alts[ $name ] ) ? $alts[ $name ] : '';
}

function azur_dent_fallback_menu( $args ) {
	wp_page_menu(
		array(
			'menu_class' => isset( $args['menu_class'] ) ? $args['menu_class'] : 'site-navigation__list',
			'show_home'  => false,
		)
	);
}

function azur_dent_contact_settings() {
	$defaults = array(
		'email'        => 'azurdent@yahoo.com',
		'phone'        => '',
		'address'      => 'Strada Pietroasa 2D, Apahida, județul Cluj',
		'operator_name'=> '',
	);
	$saved = get_option( 'azur_dent_settings', array() );
	$settings = wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
	if ( '' === trim( (string) $settings['address'] ) ) {
		$settings['address'] = $defaults['address'];
	}
	return $settings;
}

function azur_dent_phone_uri( $phone ) {
	return preg_replace( '/[^0-9+]/', '', (string) $phone );
}

function azur_dent_directions_url() {
	$settings = azur_dent_contact_settings();
	$address  = ! empty( $settings['address'] ) ? $settings['address'] : 'Strada Pietroasa 2D, Apahida, județul Cluj';
	return 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( $address );
}

function azur_dent_image_credits_note() {
	return __( 'Fotografiile afișate în această secțiune au rol orientativ (imagini din arhivă foto medicală). Acestea pot fi înlocuite oricând din panoul de administrare cu fotografiile proprii ale cabinetului și echipei Azur Dent.', 'azur-dent' );
}
