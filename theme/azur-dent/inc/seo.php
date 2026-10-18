<?php
/** Basic metadata and verified local business structured data. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function azur_dent_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

function azur_dent_page_description() {
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post && has_excerpt( $post ) ) {
			return wp_strip_all_tags( get_the_excerpt( $post ) );
		}
		if ( $post instanceof WP_Post ) {
			return wp_trim_words( wp_strip_all_tags( $post->post_content ), 28, '…' );
		}
	}
	return __( 'Azur Dent, cabinet stomatologic în Apahida, județul Cluj. Află informații despre servicii și trimite o solicitare de programare.', 'azur-dent' );
}

function azur_dent_output_seo_metadata() {
	if ( azur_dent_seo_plugin_active() ) {
		return;
	}
	$title       = wp_get_document_title();
	$description = azur_dent_page_description();
	$url         = is_singular() ? get_permalink() : home_url( '/' );
	$image       = azur_dent_image_url( 'chair-room', 1280 );
	echo "\n" . '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	echo '<meta property="og:locale" content="ro_RO">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Azur Dent' ) . '">' . "\n";
	if ( $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta property="og:image:alt" content="' . esc_attr__( 'Fotografie ilustrativă de cabinet stomatologic, nu reprezintă Azur Dent', 'azur-dent' ) . '">' . "\n";
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
}
add_action( 'wp_head', 'azur_dent_output_seo_metadata', 2 );

function azur_dent_output_local_business_schema() {
	if ( azur_dent_seo_plugin_active() ) {
		return;
	}
	$contact = azur_dent_contact_settings();
	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Dentist',
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
		'address'  => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $contact['address'],
			'addressCountry'  => 'RO',
		),
		'hasMap'   => azur_dent_directions_url(),
	);
	if ( ! empty( $contact['email'] ) && is_email( $contact['email'] ) ) {
		$schema['email'] = $contact['email'];
	}
	if ( ! empty( $contact['phone'] ) ) {
		$schema['telephone'] = $contact['phone'];
	}
	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $schema, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . '</script>' . "\n";
}
add_action( 'wp_head', 'azur_dent_output_local_business_schema', 3 );
