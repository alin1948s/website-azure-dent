<?php
/** Starter Gutenberg pages and service information. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function azur_dent_service_options() {
	return array(
		'general'      => __( 'Stomatologie generală', 'azur-dent' ),
		'caries'       => __( 'Tratamentul cariilor', 'azur-dent' ),
		'prevention'   => __( 'Profilaxie', 'azur-dent' ),
		'endodontics'  => __( 'Endodonție', 'azur-dent' ),
		'prosthetics'  => __( 'Protetică dentară', 'azur-dent' ),
		'surgery'      => __( 'Chirurgie dento-alveolară', 'azur-dent' ),
		'implantology' => __( 'Implantologie', 'azur-dent' ),
		'orthodontics' => __( 'Ortodonție', 'azur-dent' ),
		'pediatric'    => __( 'Pedodonție', 'azur-dent' ),
		'esthetics'    => __( 'Estetică dentară', 'azur-dent' ),
		'periodontics' => __( 'Parodontologie', 'azur-dent' ),
		'unsure'       => __( 'Nu sunt sigur(ă) încă', 'azur-dent' ),
	);
}

function azur_dent_service_descriptions() {
	return array(
		'general'      => __( 'Evaluarea situației dentare și o discuție despre opțiunile potrivite după consultație.', 'azur-dent' ),
		'caries'       => __( 'Medicul examinează dintele și stabilește pașii potriviți în funcție de evaluarea clinică.', 'azur-dent' ),
		'prevention'   => __( 'Îngrijire orientată spre prevenție și recomandări adaptate după consultație.', 'azur-dent' ),
		'endodontics'  => __( 'Evaluarea și îngrijirea structurii interne a dintelui, când acest serviciu este indicat.', 'azur-dent' ),
		'prosthetics'  => __( 'Discuție despre soluții protetice, stabilite în funcție de consultație și de situația individuală.', 'azur-dent' ),
		'surgery'      => __( 'Evaluare pentru proceduri dentare chirurgicale, cu pașii explicați de medic înainte de tratament.', 'azur-dent' ),
		'implantology' => __( 'Consultație pentru a discuta opțiunile de implantologie și dacă sunt potrivite situației individuale.', 'azur-dent' ),
		'orthodontics' => __( 'Evaluare și discuție despre opțiuni ortodontice, în funcție de nevoile fiecărui pacient.', 'azur-dent' ),
		'pediatric'    => __( 'Consultație stomatologică pentru copii, cu recomandări stabilite după evaluare.', 'azur-dent' ),
		'esthetics'    => __( 'Discuție despre opțiunile de estetică dentară și limitele lor, după consultație.', 'azur-dent' ),
		'periodontics' => __( 'Evaluarea gingiilor și discutarea opțiunilor de îngrijire potrivite cazului.', 'azur-dent' ),
		'unsure'       => __( 'Poți alege această variantă dacă dorești o consultație inițială în care medicul să îți recomande pașii potriviți.', 'azur-dent' ),
	);
}

function azur_dent_service_category_info( $slug ) {
	$map = array(
		'general'      => array( 'key' => 'consult', 'label' => __( 'Consultație & Prevenție', 'azur-dent' ) ),
		'caries'       => array( 'key' => 'consult', 'label' => __( 'Consultație & Prevenție', 'azur-dent' ) ),
		'prevention'   => array( 'key' => 'consult', 'label' => __( 'Consultație & Prevenție', 'azur-dent' ) ),
		'endodontics'  => array( 'key' => 'restorative', 'label' => __( 'Tratamente & Restaurare', 'azur-dent' ) ),
		'prosthetics'  => array( 'key' => 'restorative', 'label' => __( 'Tratamente & Restaurare', 'azur-dent' ) ),
		'esthetics'    => array( 'key' => 'restorative', 'label' => __( 'Tratamente & Restaurare', 'azur-dent' ) ),
		'periodontics' => array( 'key' => 'restorative', 'label' => __( 'Tratamente & Restaurare', 'azur-dent' ) ),
		'surgery'      => array( 'key' => 'surgical', 'label' => __( 'Chirurgie & Implantologie', 'azur-dent' ) ),
		'implantology' => array( 'key' => 'surgical', 'label' => __( 'Chirurgie & Implantologie', 'azur-dent' ) ),
		'orthodontics' => array( 'key' => 'ortho', 'label' => __( 'Ortodonție & Copii', 'azur-dent' ) ),
		'pediatric'    => array( 'key' => 'ortho', 'label' => __( 'Ortodonție & Copii', 'azur-dent' ) ),
	);
	return isset( $map[ $slug ] ) ? $map[ $slug ] : array( 'key' => 'consult', 'label' => __( 'Consultație', 'azur-dent' ) );
}

function azur_dent_sanitize_classes( $class ) {
	$class = trim( (string) $class );
	if ( '' === $class ) {
		return '';
	}
	return implode( ' ', array_filter( array_map( 'sanitize_html_class', preg_split( '/\s+/', $class ) ) ) );
}

function azur_dent_heading_block( $level, $text, $class = '' ) {
	$level         = min( 6, max( 1, absint( $level ) ) );
	$block_classes = azur_dent_sanitize_classes( $class );
	$attrs         = array( 'level' => $level );
	if ( $block_classes ) {
		$attrs['className'] = $block_classes;
	}
	$html_class = 'wp-block-heading' . ( $block_classes ? ' ' . $block_classes : '' );
	return '<!-- wp:heading ' . wp_json_encode( $attrs ) . ' -->'
		. '<h' . $level . ' class="' . esc_attr( $html_class ) . '">' . esc_html( $text ) . '</h' . $level . '><!-- /wp:heading -->';
}

function azur_dent_paragraph_block( $text, $class = '' ) {
	$block_classes = azur_dent_sanitize_classes( $class );
	$class_attr    = $block_classes ? ' class="' . esc_attr( $block_classes ) . '"' : '';
	$attrs         = $block_classes ? ' {"className":"' . esc_attr( $block_classes ) . '"}' : '';
	return '<!-- wp:paragraph' . $attrs . ' --><p' . $class_attr . '>' . wp_kses_post( $text ) . '</p><!-- /wp:paragraph -->';
}

function azur_dent_group_open( $class, $tag = 'section', $align = '' ) {
	$block_classes = azur_dent_sanitize_classes( $class );
	$attrs         = array(
		'tagName'   => $tag,
		'className' => $block_classes,
	);
	if ( $align ) {
		$attrs['align'] = $align;
	}
	$classes = 'wp-block-group ' . ( 'wide' === $align ? 'alignwide ' : ( 'full' === $align ? 'alignfull ' : '' ) ) . $block_classes;
	return '<!-- wp:group ' . wp_json_encode( $attrs ) . ' --><' . tag_escape( $tag ) . ' class="' . esc_attr( trim( $classes ) ) . '">';
}

function azur_dent_group_close( $tag = 'section' ) {
	return '</' . tag_escape( $tag ) . '><!-- /wp:group -->';
}

function azur_dent_column_open( $class = '', $vertical_alignment = '' ) {
	$block_classes = azur_dent_sanitize_classes( $class );
	$attrs         = array();
	if ( $block_classes ) {
		$attrs['className'] = $block_classes;
	}
	if ( $vertical_alignment ) {
		$attrs['verticalAlignment'] = $vertical_alignment;
	}
	$classes = 'wp-block-column';
	if ( 'center' === $vertical_alignment ) {
		$classes .= ' is-vertically-aligned-center';
	}
	if ( $block_classes ) {
		$classes .= ' ' . $block_classes;
	}
	return '<!-- wp:column ' . wp_json_encode( $attrs ) . ' --><div class="' . esc_attr( $classes ) . '">';
}

function azur_dent_column_close() {
	return '</div><!-- /wp:column -->';
}

function azur_dent_html_block( $html ) {
	return '<!-- wp:html -->' . $html . '<!-- /wp:html -->';
}

function azur_dent_button_block( $url, $label, $style = '' ) {
	$clean_style = azur_dent_sanitize_classes( $style );
	$class       = $clean_style ? ' ' . $clean_style : '';
	return '<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"' . esc_attr( $clean_style ) . '"} -->'
		. '<div class="wp-block-button' . esc_attr( $class ) . '"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></div>'
		. '<!-- /wp:button --></div><!-- /wp:buttons -->';
}

function azur_dent_appointment_band( $eyebrow, $title, $text, $button_label, $url ) {
	$content  = azur_dent_group_open( 'azur-appointment-band', 'section', 'wide' );
	$content .= azur_dent_group_open( 'azur-appointment-band__inner', 'div' );
	$content .= azur_dent_group_open( 'azur-appointment-band__copy', 'div' );
	$content .= azur_dent_paragraph_block( $eyebrow, 'eyebrow' );
	$content .= azur_dent_heading_block( 2, $title );
	$content .= azur_dent_paragraph_block( $text );
	$content .= azur_dent_group_close( 'div' );
	$content .= azur_dent_group_open( 'azur-appointment-band__action', 'div' );
	$content .= azur_dent_button_block( $url, $button_label );
	$content .= azur_dent_group_close( 'div' );
	$content .= azur_dent_group_close( 'div' );
	$content .= azur_dent_group_close();
	return $content;
}

function azur_dent_home_content() {
	$booking  = azur_dent_page_url( 'programare' );
	$services = azur_dent_page_url( 'servicii' );
	$about    = azur_dent_page_url( 'cabinet-si-echipa' );
	$contact  = azur_dent_page_url( 'contact' );
	$content  = '';

	$content .= azur_dent_group_open( 'azur-home-hero', 'section', 'full' );
	$content .= '<!-- wp:columns {"verticalAlignment":"center","className":"azur-home-hero__grid"} --><div class="wp-block-columns are-vertically-aligned-center azur-home-hero__grid">';
	$content .= azur_dent_column_open( 'azur-home-hero__copy', 'center' );
	$content .= azur_dent_paragraph_block( 'CABINET STOMATOLOGIC ÎN APAHIDA', 'eyebrow' );
	$content .= azur_dent_heading_block( 1, 'Îngrijire stomatologică atentă, aproape de casă.', 'azur-display' );
	$content .= azur_dent_paragraph_block( 'Azur Dent este cabinetul stomatologic din Apahida, situat pe Strada Pietroasa 2D. Aici găsești informații despre tratamentele și consultațiile disponibile, precum și formularul online pentru solicitarea unei programări.' );
	$content .= azur_dent_html_block(
		'<div class="azur-hero-actions">'
		. '<a class="button button--dark" href="' . esc_url( $booking ) . '"><span>Solicită o programare</span><span class="button__arrow" aria-hidden="true">↗</span></a>'
		. '<a class="button button--outline" href="' . esc_url( $services ) . '"><span>Vezi serviciile</span><span class="button__arrow" aria-hidden="true">→</span></a>'
		. '</div>'
		. '<dl class="azur-hero-meta">'
		. '<div class="azur-hero-meta__item"><dt>Locație</dt><dd>Str. Pietroasa 2D, Apahida</dd></div>'
		. '<div class="azur-hero-meta__item"><dt>Pacienți</dt><dd>Adulți și copii</dd></div>'
		. '<div class="azur-hero-meta__item"><dt>Programări</dt><dd>Confirmate de cabinet</dd></div>'
		. '</dl>'
	);
	$content .= azur_dent_column_close();
	$content .= azur_dent_column_open( 'azur-home-hero__visual', 'center' );
	$content .= azur_dent_image_block( 'chair-room', azur_dent_get_image_alt( 'chair-room' ), 'Sală de tratament stomatologic și unit dentar (imagine cu titlu ilustrativ).', 'eager', 'azur-home-hero__photo' );
	$content .= azur_dent_html_block(
		'<div class="azur-home-hero__caption">'
		. '<div><strong>Azur Dent · Apahida, jud. Cluj</strong><span>Programările se stabilesc în funcție de disponibilitatea confirmată de cabinet.</span></div>'
		. '<a class="azur-home-hero__caption-link" href="' . esc_url( $contact ) . '">Harta și contact <span aria-hidden="true">→</span></a>'
		. '</div>'
	);
	$content .= azur_dent_column_close();
	$content .= '</div><!-- /wp:columns -->';
	$content .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-location-strip', 'section', 'wide' );
	$content .= azur_dent_paragraph_block( '<strong>Azur Dent</strong> <span aria-hidden="true">·</span> <span>Cabinet stomatologic în Apahida</span>', 'azur-location-strip__label' );
	$content .= '<!-- wp:shortcode -->[azur_dent_contact_address show_label="true"]<!-- /wp:shortcode -->';
	$content .= azur_dent_paragraph_block( '<a href="' . esc_url( azur_dent_directions_url() ) . '" target="_blank" rel="noopener noreferrer" class="text-link">Deschide traseul în Google Maps <span aria-hidden="true">↗</span></a>', 'azur-location-strip__directions' );
	$content .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-home-intro', 'section', 'wide' );
	$content .= '<!-- wp:columns {"verticalAlignment":"center","className":"azur-editorial-split"} --><div class="wp-block-columns are-vertically-aligned-center azur-editorial-split">';
	$content .= azur_dent_column_open( 'azur-editorial-split__image', 'center' );
	$content .= azur_dent_image_block( 'consultation-tablet', azur_dent_get_image_alt( 'consultation-tablet' ), 'Discuție medic–pacient și prezentarea opțiunilor de tratament (imagine cu titlu ilustrativ).', 'lazy' );
	$content .= azur_dent_column_close();
	$content .= azur_dent_column_open( 'azur-editorial-split__copy', 'center' );
	$content .= azur_dent_paragraph_block( 'CUM FUNCȚIONEAZĂ', 'eyebrow' );
	$content .= azur_dent_heading_block( 2, 'Cum te programezi la cabinet.', 'azur-section-title' );
	$content .= azur_dent_paragraph_block( 'Completezi datele tale de contact și perioada preferată în formularul online. Solicitarea ajunge pe email la cabinet, iar echipa te contactează pentru a stabili ora exactă.' );
	$content .= azur_dent_html_block(
		'<div class="azur-process-interactive" data-process-stepper>'
		. '<div class="azur-process-tabs" role="tablist" aria-label="Etapele programării">'
		. '<button type="button" class="azur-process-tab is-active" role="tab" aria-selected="true" data-step-target="0">Alegerea serviciului</button>'
		. '<button type="button" class="azur-process-tab" role="tab" aria-selected="false" data-step-target="1">Trimiterea cererii</button>'
		. '<button type="button" class="azur-process-tab" role="tab" aria-selected="false" data-step-target="2">Confirmarea orei</button>'
		. '</div>'
		. '<div class="azur-process-panels">'
		. '<div class="azur-process-panel is-active" role="tabpanel" data-step-panel="0"><h3>Alegi categoria și intervalul dorit</h3><p>Poți selecta serviciul stomatologic de care ai nevoie sau opțiunea „Nu sunt sigur(ă) încă”, împreună cu ziua și momentul zilei în care îți este mai comod să vii.</p></div>'
		. '<div class="azur-process-panel" role="tabpanel" data-step-panel="1" hidden><h3>Verifici datele și trimiți solicitarea</h3><p>Înainte de expediere poți revedea pe scurt toate informațiile completate. Formularul nu îți cere detalii medicale sau istoric clinic.</p></div>'
		. '<div class="azur-process-panel" role="tabpanel" data-step-panel="2" hidden><h3>Primești confirmarea de la cabinet</h3><p>Personalul Azur Dent verifică programul cabinetului și te contactează telefonic sau pe email pentru a stabili împreună ziua și ora programării.</p></div>'
		. '</div>'
		. '</div>'
	);
	$content .= azur_dent_paragraph_block( '<a class="text-link" href="' . esc_url( $about ) . '">Informații despre cabinet și galerie foto <span aria-hidden="true">→</span></a>' );
	$content .= azur_dent_column_close();
	$content .= '</div><!-- /wp:columns -->';
	$content .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-home-services', 'section', 'full' );
	$content .= azur_dent_group_open( 'azur-section-head', 'div' );
	$content .= azur_dent_group_open( 'azur-section-head__copy', 'div' );
	$content .= azur_dent_paragraph_block( 'TRATAMENTE ȘI CONSULTAȚII', 'eyebrow' );
	$content .= azur_dent_heading_block( 2, 'Principalele categorii stomatologice.' );
	$content .= azur_dent_group_close( 'div' );
	$content .= azur_dent_paragraph_block( '<a class="button button--outline" href="' . esc_url( $services ) . '"><span>Toate serviciile</span><span class="button__arrow" aria-hidden="true">→</span></a>', 'azur-section-head__link' );
	$content .= azur_dent_group_close( 'div' );
	$content .= '<!-- wp:columns {"className":"azur-service-columns"} --><div class="wp-block-columns azur-service-columns">';
	$content .= azur_dent_column_open( 'azur-service-card' );
	$content .= azur_dent_paragraph_block( 'Consultație și evaluare', 'azur-service-number' )
		. azur_dent_heading_block( 3, 'Stomatologie generală' )
		. azur_dent_paragraph_block( 'Evaluarea sănătății orale și stabilirea planului de îngrijire potrivit în urma consultației.' )
		. azur_dent_paragraph_block( '<a class="azur-service-card__cta" href="' . esc_url( add_query_arg( 'serviciu', 'general', $booking ) . '#request-form' ) . '">Solicită programare <span aria-hidden="true">→</span></a>', 'azur-service-card__action' );
	$content .= azur_dent_column_close();
	$content .= azur_dent_column_open( 'azur-service-card' );
	$content .= azur_dent_paragraph_block( 'Prevenție dentară', 'azur-service-number' )
		. azur_dent_heading_block( 3, 'Profilaxie' )
		. azur_dent_paragraph_block( 'Îngrijire orientată spre prevenție, igienizare profesională și recomandări adaptate fiecărui pacient.' )
		. azur_dent_paragraph_block( '<a class="azur-service-card__cta" href="' . esc_url( add_query_arg( 'serviciu', 'prevention', $booking ) . '#request-form' ) . '">Solicită programare <span aria-hidden="true">→</span></a>', 'azur-service-card__action' );
	$content .= azur_dent_column_close();
	$content .= azur_dent_column_open( 'azur-service-card' );
	$content .= azur_dent_paragraph_block( 'Restaurare dentară', 'azur-service-number' )
		. azur_dent_heading_block( 3, 'Protetică dentară' )
		. azur_dent_paragraph_block( 'Consultație și opțiuni protetice discutate cu medicul în funcție de situația fiecărui caz.' )
		. azur_dent_paragraph_block( '<a class="azur-service-card__cta" href="' . esc_url( add_query_arg( 'serviciu', 'prosthetics', $booking ) . '#request-form' ) . '">Solicită programare <span aria-hidden="true">→</span></a>', 'azur-service-card__action' );
	$content .= azur_dent_column_close();
	$content .= '</div><!-- /wp:columns -->';
	$content .= azur_dent_paragraph_block( 'Lista completă cuprinde 11 arii stomatologice. Disponibilitatea fiecărei proceduri se confirmă direct cu cabinetul.', 'azur-directory-note' );
	$content .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-home-faq', 'section', 'wide' );
	$content .= azur_dent_html_block(
		'<div class="azur-faq-header">'
		. '<div class="azur-faq-header__copy">'
		. '<p class="eyebrow">ÎNTREBĂRI FRECVENTE</p>'
		. '<h2 class="wp-block-heading">Detalii utile despre programări.</h2>'
		. '</div>'
		. '<button type="button" class="button button--outline azur-faq-toggle-all" data-faq-toggle-all aria-expanded="false">Afișează toate răspunsurile</button>'
		. '</div>'
		. '<div class="azur-faq-list">'
		. '<details><summary>Trimiterea formularului confirmă pe loc programarea?</summary><p>Nu. Formularul transmite solicitarea ta către cabinet, iar personalul te va contacta pentru a confirma disponibilitatea și ora exactă.</p></details>'
		. '<details><summary>Ce informații trebuie să completez?</summary><p>Numele, numărul de telefon, categoria de serviciu și ziua sau perioada zilei preferată. Adresa de email este opțională.</p></details>'
		. '<details><summary>Trebuie să descriu simptome sau probleme medicale?</summary><p>Nu. Formularul este destinat exclusiv contactului pentru programare; evaluarea medicală are loc direct la cabinet.</p></details>'
		. '<details><summary>Ce aleg dacă nu știu exact ce procedură îmi trebuie?</summary><p>Poți selecta „Stomatologie generală” sau „Nu sunt sigur(ă) încă”, iar la consultație medicul îți va explica opțiunile potrivite.</p></details>'
		. '</div>'
	);
	$content .= azur_dent_group_close();

	$content .= azur_dent_appointment_band( 'PROGRAMARE', 'Dorești să soliciți o vizită la cabinet?', 'Completează formularul online cu ziua preferată, iar echipa Azur Dent va reveni pentru confirmare.', 'Deschide formularul', $booking );

	return $content;
}

function azur_dent_services_content() {
	$services     = azur_dent_service_options();
	$descriptions = azur_dent_service_descriptions();
	$booking      = azur_dent_page_url( 'programare' );
	$content      = azur_dent_group_open( 'azur-page-intro', 'section', 'wide' );
	$content     .= azur_dent_paragraph_block( 'ARII DE TRATAMENT ȘI CONSULTAȚIE', 'eyebrow' );
	$content     .= azur_dent_heading_block( 1, 'Servicii stomatologice', 'azur-page-title' );
	$content     .= azur_dent_paragraph_block( 'Găsești mai jos principalele servicii și tratamente stomatologice disponibile la Azur Dent, organizate pe specialități. Planul de tratament și costurile se stabilesc în urma consultației la cabinet.' );
	$content     .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-service-rows', 'section', 'wide' );
	$content .= azur_dent_html_block(
		'<div class="azur-services-toolbar" data-services-filter>'
		. '<div class="azur-filter-pills" role="toolbar" aria-label="Filtrează categoriile de servicii">'
		. '<button type="button" class="azur-filter-pill is-active" data-filter="all">Toate serviciile</button>'
		. '<button type="button" class="azur-filter-pill" data-filter="consult">Consultație &amp; Prevenție</button>'
		. '<button type="button" class="azur-filter-pill" data-filter="restorative">Tratamente &amp; Restaurare</button>'
		. '<button type="button" class="azur-filter-pill" data-filter="surgical">Chirurgie &amp; Implantologie</button>'
		. '<button type="button" class="azur-filter-pill" data-filter="ortho">Ortodonție &amp; Copii</button>'
		. '</div>'
		. '<div class="azur-services-search">'
		. '<label class="screen-reader-text" for="azur-service-search-input">Caută un serviciu</label>'
		. '<input type="search" id="azur-service-search-input" class="azur-services-search__input" placeholder="Caută un serviciu (ex. profilaxie, protetică, copii)..." autocomplete="off" data-service-search>'
		. '<span class="azur-services-search__count" data-service-count aria-live="polite">11 categorii</span>'
		. '</div>'
		. '</div>'
	);

	$content .= azur_dent_group_open( 'azur-services-list', 'div' );
	foreach ( $services as $slug => $label ) {
		if ( 'unsure' === $slug ) {
			continue;
		}
		$cat_info   = azur_dent_service_category_info( $slug );
		$target_url = add_query_arg( 'serviciu', $slug, $booking ) . '#request-form';
		$row_class  = 'azur-service-row azur-service-cat-' . $cat_info['key'];
		$content   .= azur_dent_group_open( $row_class, 'div' );
		$content   .= azur_dent_group_open( 'azur-service-row__content', 'div' );
		$content   .= azur_dent_paragraph_block( $cat_info['label'], 'azur-service-row__tag' );
		$content   .= azur_dent_heading_block( 2, $label ) . azur_dent_paragraph_block( $descriptions[ $slug ] );
		$content   .= azur_dent_group_close( 'div' );
		$content   .= azur_dent_paragraph_block(
			'<a class="azur-service-row__btn" href="' . esc_url( $target_url ) . '" aria-label="Solicită programare pentru ' . esc_attr( $label ) . '"><span class="azur-service-row__btn-text">Solicită programare</span><span aria-hidden="true">→</span></a>',
			'azur-service-row__action'
		);
		$content   .= azur_dent_group_close( 'div' );
	}
	$content .= azur_dent_group_close( 'div' );
	$content .= azur_dent_html_block( '<p class="azur-services-empty" data-services-empty hidden>Niciun serviciu nu corespunde căutării. Încearcă un alt termen sau selectează „Toate serviciile”.</p>' );
	$content .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-service-visual', 'section', 'wide' );
	$content .= '<!-- wp:columns {"className":"azur-photo-pair"} --><div class="wp-block-columns azur-photo-pair">';
	$content .= azur_dent_column_open();
	$content .= azur_dent_image_block( 'instrument-drawer', azur_dent_get_image_alt( 'instrument-drawer' ), 'Instrumentar stomatologic pregătit pentru tratament (imagine cu titlu ilustrativ).' );
	$content .= azur_dent_column_close();
	$content .= azur_dent_column_open();
	$content .= azur_dent_image_block( 'tools-teal', azur_dent_get_image_alt( 'tools-teal' ), 'Instrumente pentru consultație și profilaxie dentară (imagine cu titlu ilustrativ).' );
	$content .= azur_dent_column_close();
	$content .= '</div><!-- /wp:columns -->';
	$content .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-note-panel', 'section', 'wide' );
	$content .= azur_dent_heading_block( 2, 'Ce urmează după trimiterea solicitării?' );
	$content .= azur_dent_paragraph_block( 'Echipa cabinetului te contactează pentru a discuta disponibilitatea și pentru a confirma programarea. Formularul online nu înlocuiește consultația medicală.' );
	$content .= azur_dent_button_block( $booking, 'Solicită o programare' );
	$content .= azur_dent_group_close();
	return $content;
}

function azur_dent_about_content() {
	$contact  = azur_dent_page_url( 'contact' );
	$booking  = azur_dent_page_url( 'programare' );
	$content  = azur_dent_group_open( 'azur-page-intro', 'section', 'wide' );
	$content .= azur_dent_paragraph_block( 'DESPRE CABINET', 'eyebrow' );
	$content .= azur_dent_heading_block( 1, 'Cabinet și echipă', 'azur-page-title' );
	$content .= azur_dent_paragraph_block( 'Azur Dent este cabinetul stomatologic din Apahida, situat pe Strada Pietroasa 2D. Punem accent pe explicații clare la fiecare consultație, un mediu curat și o comunicare deschisă cu fiecare pacient, adult sau copil.' );
	$content .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-stock-note', 'section', 'wide' );
	$content .= azur_dent_html_block( '<div class="azur-stock-note__mark" aria-hidden="true">i</div>' );
	$content .= azur_dent_group_open( 'azur-stock-note__body', 'div' );
	$content .= azur_dent_heading_block( 2, 'Notă privind fotografiile din pagină' );
	$content .= azur_dent_paragraph_block( azur_dent_image_credits_note() );
	$content .= azur_dent_group_close( 'div' );
	$content .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-gallery-section', 'section', 'wide' );
	$content .= azur_dent_html_block(
		'<div class="azur-gallery-header">'
		. '<div class="azur-gallery-header__copy">'
		. '<p class="eyebrow">GALERIE FOTO</p>'
		. '<h2 class="wp-block-heading">Spațiul cabinetului și dotările.</h2>'
		. '</div>'
		. '<div class="azur-filter-pills" role="toolbar" aria-label="Filtrează galeria foto" data-gallery-filter>'
		. '<button type="button" class="azur-filter-pill is-active" data-filter="all">Toate fotografiile</button>'
		. '<button type="button" class="azur-filter-pill" data-filter="space">Recepție și cabinet</button>'
		. '<button type="button" class="azur-filter-pill" data-filter="consult">Consultație</button>'
		. '<button type="button" class="azur-filter-pill" data-filter="tools">Instrumentar</button>'
		. '</div>'
		. '</div>'
	);
	$content .= azur_dent_group_open( 'azur-gallery', 'div' );
	$content .= azur_dent_image_block( 'reception', azur_dent_get_image_alt( 'reception' ), 'Zonă de recepție și primire pacienți (imagine cu titlu ilustrativ).', 'lazy', 'azur-gallery__item azur-gallery__item--wide azur-gallery__cat-space' );
	$content .= azur_dent_image_block( 'treatment-chair', azur_dent_get_image_alt( 'treatment-chair' ), 'Unit dentar și sală de tratament (imagine cu titlu ilustrativ).', 'lazy', 'azur-gallery__item azur-gallery__cat-space' );
	$content .= azur_dent_image_block( 'consultation-model', azur_dent_get_image_alt( 'consultation-model' ), 'Discuție medic–pacient și planificarea tratamentului (imagine cu titlu ilustrativ).', 'lazy', 'azur-gallery__item azur-gallery__cat-consult' );
	$content .= azur_dent_image_block( 'patient-checkup', azur_dent_get_image_alt( 'patient-checkup' ), 'Consultație stomatologică și verificare clinică (imagine cu titlu ilustrativ).', 'lazy', 'azur-gallery__item azur-gallery__item--wide azur-gallery__cat-consult' );
	$content .= azur_dent_image_block( 'instrument-drawer', azur_dent_get_image_alt( 'instrument-drawer' ), 'Instrumentar stomatologic pregătit pentru tratament (imagine cu titlu ilustrativ).', 'lazy', 'azur-gallery__item azur-gallery__cat-tools' );
	$content .= azur_dent_image_block( 'tools-teal', azur_dent_get_image_alt( 'tools-teal' ), 'Instrumente pentru consultație și profilaxie (imagine cu titlu ilustrativ).', 'lazy', 'azur-gallery__item azur-gallery__cat-tools' );
	$content .= azur_dent_group_close( 'div' );
	$content .= azur_dent_group_close();

	$content .= azur_dent_appointment_band( 'CONTACT ȘI PROGRAMĂRI', 'Ai o întrebare pentru cabinet?', 'Trimite o solicitare de programare sau consultă harta și datele de contact.', 'Solicită o programare', $booking );
	$content .= azur_dent_group_open( 'azur-page-footer-link', 'div', 'wide' );
	$content .= azur_dent_paragraph_block( '<a class="text-link" href="' . esc_url( $contact ) . '">Vezi harta și datele de contact <span aria-hidden="true">→</span></a>' );
	$content .= azur_dent_group_close( 'div' );
	return $content;
}

function azur_dent_booking_content() {
	$services = azur_dent_page_url( 'servicii' );
	$content  = azur_dent_group_open( 'azur-page-intro azur-booking-intro', 'section', 'wide' );
	$content .= azur_dent_paragraph_block( 'PROGRAMARE ONLINE', 'eyebrow' );
	$content .= azur_dent_heading_block( 1, 'Solicită o programare la cabinet.', 'azur-page-title' );
	$content .= azur_dent_paragraph_block( 'Completează formularul cu ziua și perioada zilei în care îți este mai ușor să ajungi. După primirea solicitării, cabinetul te va contacta pentru confirmarea orei disponibile.' );
	$content .= azur_dent_paragraph_block( 'Te rugăm să nu introduci diagnostice, simptome sau istoric medical în formular. Pentru informații despre proceduri, poți consulta <a href="' . esc_url( $services ) . '">pagina Servicii</a>.' );
	$content .= azur_dent_group_close();

	$content .= '<!-- wp:columns {"align":"wide","className":"azur-booking-layout"} --><div class="wp-block-columns alignwide azur-booking-layout">';
	$content .= azur_dent_column_open( 'azur-booking-layout__aside' );
	$content .= azur_dent_paragraph_block( 'CUM DECURGE PROGRAMAREA', 'eyebrow' );
	$content .= azur_dent_group_open( 'azur-step-list', 'div' );
	$content .= azur_dent_group_open( 'azur-step-list__item is-active', 'div' ) . azur_dent_html_block( '<span class="azur-step-list__dot" aria-hidden="true"></span>' ) . azur_dent_group_open( 'azur-step-list__copy', 'div' ) . azur_dent_heading_block( 3, 'Completezi formularul' ) . azur_dent_paragraph_block( 'Alegi categoria dorită, ziua și intervalul orientativ.' ) . azur_dent_group_close( 'div' ) . azur_dent_group_close( 'div' );
	$content .= azur_dent_group_open( 'azur-step-list__item', 'div' ) . azur_dent_html_block( '<span class="azur-step-list__dot" aria-hidden="true"></span>' ) . azur_dent_group_open( 'azur-step-list__copy', 'div' ) . azur_dent_heading_block( 3, 'Verificarea disponibilității' ) . azur_dent_paragraph_block( 'Personalul cabinetului preia cererea și verifică orarul.' ) . azur_dent_group_close( 'div' ) . azur_dent_group_close( 'div' );
	$content .= azur_dent_group_open( 'azur-step-list__item', 'div' ) . azur_dent_html_block( '<span class="azur-step-list__dot" aria-hidden="true"></span>' ) . azur_dent_group_open( 'azur-step-list__copy', 'div' ) . azur_dent_heading_block( 3, 'Confirmarea telefonică' ) . azur_dent_paragraph_block( 'Stabilim împreună ziua și ora exactă a programării.' ) . azur_dent_group_close( 'div' ) . azur_dent_group_close( 'div' );
	$content .= azur_dent_group_close( 'div' );
	$content .= azur_dent_column_close();
	$content .= azur_dent_column_open( 'azur-booking-layout__form' );
	$content .= '<!-- wp:shortcode -->[azur_dent_appointment_form]<!-- /wp:shortcode -->';
	$content .= azur_dent_column_close();
	$content .= '</div><!-- /wp:columns -->';
	return $content;
}

function azur_dent_contact_content() {
	$booking  = azur_dent_page_url( 'programare' );
	$content  = azur_dent_group_open( 'azur-page-intro', 'section', 'wide' );
	$content .= azur_dent_paragraph_block( 'CONTACT ȘI LOCALIZARE', 'eyebrow' );
	$content .= azur_dent_heading_block( 1, 'Unde ne găsești în Apahida.', 'azur-page-title' );
	$content .= azur_dent_paragraph_block( 'Cabinetul Azur Dent se află pe Strada Pietroasa 2D, în Apahida, județul Cluj. Mai jos găsești datele de contact și harta cu localizarea sediului.' );
	$content .= azur_dent_group_close();

	$content .= '<!-- wp:columns {"align":"wide","className":"azur-contact-layout"} --><div class="wp-block-columns alignwide azur-contact-layout">';
	$content .= azur_dent_column_open( 'azur-contact-layout__details' );
	$content .= '<!-- wp:shortcode -->[azur_dent_contact_details]<!-- /wp:shortcode -->';
	$content .= azur_dent_column_close();
	$content .= azur_dent_column_open( 'azur-contact-layout__map' );
	$content .= '<!-- wp:shortcode -->[azur_dent_interactive_map]<!-- /wp:shortcode -->';
	$content .= azur_dent_column_close();
	$content .= '</div><!-- /wp:columns -->';

	$content .= azur_dent_appointment_band( 'PROGRAMARE', 'Preferi să soliciți programarea online?', 'Completează formularul în mai puțin de un minut, iar cabinetul va reveni pentru confirmare.', 'Mergi la formular', $booking );
	return $content;
}

function azur_dent_privacy_content() {
	$content  = azur_dent_group_open( 'azur-page-intro', 'section', 'wide' );
	$content .= azur_dent_paragraph_block( 'CONFIDENȚIALITATE', 'eyebrow' );
	$content .= azur_dent_heading_block( 1, 'Informare privind confidențialitatea', 'azur-page-title' );
	$content .= azur_dent_paragraph_block( 'Această pagină descrie modul în care funcționează formularul de programare al site-ului. Identitatea juridică a operatorului și perioada de păstrare a mesajelor trebuie completate și verificate de cabinet înainte de publicarea site-ului.' );
	$content .= azur_dent_group_close();

	$content .= azur_dent_group_open( 'azur-privacy-content', 'section', 'wide' );
	$content .= azur_dent_heading_block( 2, 'Operatorul și datele de contact' );
	$content .= '<!-- wp:shortcode -->[azur_dent_privacy_contact]<!-- /wp:shortcode -->';
	$content .= azur_dent_heading_block( 2, 'Ce date colectează formularul' );
	$content .= azur_dent_paragraph_block( 'Formularul solicită numele, numărul de telefon, serviciul dorit și ziua sau intervalul preferat. Adresa de email este opțională. Nu cere informații despre diagnostic, simptome sau istoric medical.' );
	$content .= azur_dent_heading_block( 2, 'De ce sunt folosite datele' );
	$content .= azur_dent_paragraph_block( 'Datele sunt folosite pentru a răspunde solicitării și pentru ca personalul cabinetului să poată discuta o posibilă programare. Trimiterea formularului nu confirmă automat o programare.' );
	$content .= azur_dent_heading_block( 2, 'Cum ajung datele la cabinet' );
	$content .= azur_dent_paragraph_block( 'Site-ul transmite formularul prin email cu ajutorul sistemului standard de mesagerie al platformei WordPress. Tema nu salvează solicitarea în baza de date a site-ului. Pentru limitarea spamului, site-ul păstrează temporar, cel mult 30 de minute, o amprentă criptografică derivată din adresa IP; nu păstrează adresa IP în acest marcaj. Mesajul poate fi prelucrat de furnizorul de găzduire și de furnizorul căsuței de email. Cabinetul trebuie să configureze transmiterea securizată și să stabilească perioada de păstrare a mesajelor.' );
	$content .= azur_dent_heading_block( 2, 'Drepturile persoanei' );
	$content .= azur_dent_paragraph_block( 'Pentru solicitări privind accesul, corectarea sau ștergerea datelor, contactează operatorul la adresa de email afișată pe pagina Contact. Operatorul trebuie să completeze informațiile juridice și să răspundă în termenele aplicabile.' );
	$content .= azur_dent_heading_block( 2, 'Cookie-uri și hartă' );
	$content .= azur_dent_paragraph_block( 'Tema nu adaugă instrumente de analiză, publicitate sau profilare. Pagina Contact afișează o hartă Google Maps pentru localizarea sediului din Apahida și include un link direct pentru deschiderea traseului în Google Maps.' );
	$content .= azur_dent_heading_block( 2, 'Actualizarea informării' );
	$content .= azur_dent_paragraph_block( 'Operatorul trebuie să revizuiască această informare atunci când se schimbă formularul, furnizorii de email sau modul de păstrare a mesajelor. Data ultimei revizuiri: de completat de cabinet.' );
	$content .= azur_dent_group_close();
	return $content;
}

function azur_dent_starter_pages() {
	return array(
		'acasa'             => array( 'title' => __( 'Acasă', 'azur-dent' ), 'excerpt' => __( 'Cabinet stomatologic Azur Dent în Apahida, județul Cluj.', 'azur-dent' ) ),
		'servicii'          => array( 'title' => __( 'Servicii', 'azur-dent' ), 'excerpt' => __( 'Categorii de servicii stomatologice disponibile la Azur Dent.', 'azur-dent' ) ),
		'cabinet-si-echipa' => array( 'title' => __( 'Cabinet și echipă', 'azur-dent' ), 'excerpt' => __( 'Informații despre cabinetul Azur Dent din Apahida și galerie foto.', 'azur-dent' ) ),
		'programare'        => array( 'title' => __( 'Programare', 'azur-dent' ), 'excerpt' => __( 'Trimite o solicitare de programare către Azur Dent; cabinetul va confirma ulterior.', 'azur-dent' ) ),
		'contact'           => array( 'title' => __( 'Contact', 'azur-dent' ), 'excerpt' => __( 'Date de contact, hartă și adresă pentru cabinetul Azur Dent din Apahida.', 'azur-dent' ) ),
		'confidentialitate' => array( 'title' => __( 'Confidențialitate', 'azur-dent' ), 'excerpt' => __( 'Informații despre datele trimise prin formularul de programare.', 'azur-dent' ) ),
	);
}

function azur_dent_contact_address_shortcode( $atts = array() ) {
	$atts    = shortcode_atts( array( 'show_label' => 'false' ), $atts, 'azur_dent_contact_address' );
	$contact = azur_dent_contact_settings();
	$address = isset( $contact['address'] ) ? trim( $contact['address'] ) : '';
	if ( '' === $address ) {
		return '';
	}
	if ( 'true' === $atts['show_label'] ) {
		return '<span class="azur-location-strip__address">'
			. '<span class="azur-location-strip__address-label">' . esc_html__( 'Adresă:', 'azur-dent' ) . '</span> '
			. '<strong>' . esc_html( $address ) . '</strong>'
			. '</span>';
	}
	return '<address class="azur-contact-address">' . esc_html( $address ) . '</address>';
}
add_shortcode( 'azur_dent_contact_address', 'azur_dent_contact_address_shortcode' );

function azur_dent_interactive_map_shortcode() {
	$contact    = azur_dent_contact_settings();
	$address    = ! empty( $contact['address'] ) ? $contact['address'] : 'Strada Pietroasa 2D, Apahida, județul Cluj';
	$map_target = ( false !== stripos( $address, 'Pietroasa' ) ) ? 'Azur Dent, Strada Pietroasa 2D, 407035 Apahida' : 'Azur Dent, ' . $address;
	$query      = rawurlencode( $map_target );
	$embed_road = 'https://maps.google.com/maps?q=' . $query . '&t=m&z=17&hl=ro&ie=UTF8&iwloc=A&output=embed';
	$embed_sat  = 'https://maps.google.com/maps?q=' . $query . '&t=k&z=18&hl=ro&ie=UTF8&iwloc=A&output=embed';
	$dir_url    = azur_dent_directions_url();

	ob_start();
	?>
	<div class="azur-map-widget" data-map-widget>
		<div class="azur-map-widget__header">
			<div class="azur-map-widget__titles">
				<span class="eyebrow"><?php esc_html_e( 'LOCALIZARE PE HARTĂ', 'azur-dent' ); ?></span>
				<h2><?php esc_html_e( 'Sediul Azur Dent', 'azur-dent' ); ?></h2>
			</div>
			<div class="azur-map-mode-switch" role="group" aria-label="<?php esc_attr_e( 'Tip afișare hartă', 'azur-dent' ); ?>">
				<button type="button" class="azur-map-mode-btn is-active" data-map-src="<?php echo esc_url( $embed_road ); ?>"><?php esc_html_e( 'Hartă', 'azur-dent' ); ?></button>
				<button type="button" class="azur-map-mode-btn" data-map-src="<?php echo esc_url( $embed_sat ); ?>"><?php esc_html_e( 'Satelit', 'azur-dent' ); ?></button>
			</div>
		</div>
		<div class="azur-map-frame-wrap">
			<div class="azur-map-pin-badge">
				<span class="azur-map-pin-badge__pin" aria-hidden="true"><span class="azur-map-pin-badge__dot"></span></span>
				<div class="azur-map-pin-badge__text">
					<strong><?php esc_html_e( 'Azur Dent · Apahida', 'azur-dent' ); ?></strong>
					<span><?php echo esc_html( $address ); ?></span>
				</div>
			</div>
			<iframe
				class="azur-map-iframe"
				data-map-iframe
				src="<?php echo esc_url( $embed_road ); ?>"
				title="<?php echo esc_attr( sprintf( __( 'Harta sediului Azur Dent — %s', 'azur-dent' ), $address ) ); ?>"
				referrerpolicy="no-referrer-when-downgrade"
				allowfullscreen>
			</iframe>
		</div>
		<div class="azur-map-widget__footer">
			<p class="azur-map-widget__address"><?php echo esc_html( $address ); ?></p>
			<a class="button button--outline" href="<?php echo esc_url( $dir_url ); ?>" target="_blank" rel="noopener noreferrer">
				<span><?php esc_html_e( 'Deschide traseul în Google Maps', 'azur-dent' ); ?></span><span class="button__arrow" aria-hidden="true">↗</span>
			</a>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'azur_dent_interactive_map', 'azur_dent_interactive_map_shortcode' );

function azur_dent_get_starter_content( $slug ) {
	$builders = array(
		'acasa'             => 'azur_dent_home_content',
		'servicii'          => 'azur_dent_services_content',
		'cabinet-si-echipa' => 'azur_dent_about_content',
		'programare'        => 'azur_dent_booking_content',
		'contact'           => 'azur_dent_contact_content',
		'confidentialitate' => 'azur_dent_privacy_content',
	);
	return isset( $builders[ $slug ] ) ? call_user_func( $builders[ $slug ] ) : '';
}

function azur_dent_create_default_menu( $location, $label, $slugs ) {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations[ $location ] ) ) {
		return;
	}
	$menu_id = wp_create_nav_menu( $label );
	if ( is_wp_error( $menu_id ) ) {
		return;
	}
	$pages = azur_dent_starter_pages();
	foreach ( $slugs as $slug ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page ) {
			continue;
		}
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $pages[ $slug ]['title'],
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $page->ID,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

function azur_dent_install_starter_content( $force_update_starter = false ) {
	$current_name = get_option( 'blogname' );
	if ( in_array( $current_name, array( '', 'My WordPress Site', 'My WordPress Website' ), true ) ) {
		update_option( 'blogname', 'Azur Dent' );
	}
	$current_tagline = get_option( 'blogdescription' );
	if ( '' === $current_tagline || 'Just another WordPress site' === $current_tagline ) {
		update_option( 'blogdescription', __( 'Cabinet stomatologic în Apahida, județul Cluj', 'azur-dent' ) );
	}
	$pages   = azur_dent_starter_pages();
	$created = array();
	foreach ( $pages as $slug => $page_data ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page ) {
			$created[ $slug ] = (bool) $force_update_starter;
			continue;
		}
		$page_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page_data['title'],
				'post_name'    => $slug,
				'post_excerpt' => $page_data['excerpt'],
				'post_content' => '',
				'menu_order'   => count( $created ),
			),
			true
		);
		if ( ! is_wp_error( $page_id ) ) {
			$created[ $slug ] = true;
		}
	}

	foreach ( $created as $slug => $should_populate ) {
		if ( ! $should_populate ) {
			continue;
		}
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page ) {
			wp_update_post(
				array(
					'ID'           => $page->ID,
					'post_content' => azur_dent_get_starter_content( $slug ),
				)
			);
		}
	}

	$sample = get_page_by_path( 'sample-page', OBJECT, 'page' );
	if ( $sample ) {
		wp_delete_post( $sample->ID, true );
	}
	$default_privacy = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( $default_privacy ) {
		wp_delete_post( $default_privacy->ID, true );
	}

	$home = get_page_by_path( 'acasa', OBJECT, 'page' );
	if ( $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );
	}
	$privacy = get_page_by_path( 'confidentialitate', OBJECT, 'page' );
	if ( $privacy ) {
		update_option( 'wp_page_for_privacy_policy', $privacy->ID );
	}

	azur_dent_create_default_menu( 'primary', __( 'Meniu principal Azur Dent', 'azur-dent' ), array( 'acasa', 'servicii', 'cabinet-si-echipa', 'contact', 'programare' ) );
	azur_dent_create_default_menu( 'footer', __( 'Meniu footer Azur Dent', 'azur-dent' ), array( 'contact', 'confidentialitate' ) );
	update_option( 'azur_dent_starter_version', AZUR_DENT_VERSION );
}
add_action( 'after_switch_theme', 'azur_dent_install_starter_content' );

function azur_dent_maybe_sync_starter_content() {
	if ( get_option( 'azur_dent_starter_version' ) !== AZUR_DENT_VERSION ) {
		azur_dent_install_starter_content( true );
	}
}
add_action( 'init', 'azur_dent_maybe_sync_starter_content', 20 );

function azur_dent_contact_details_shortcode() {
	$contact = azur_dent_contact_settings();
	$booking = azur_dent_page_url( 'programare' );
	$output  = '<div class="azur-contact-details">';
	$output .= '<span class="eyebrow">' . esc_html__( 'DATE DE CONTACT', 'azur-dent' ) . '</span>';
	$output .= '<h2 class="azur-contact-details__heading">' . esc_html__( 'Cabinetul Azur Dent', 'azur-dent' ) . '</h2>';
	$output .= '<div class="azur-contact-item">'
		. '<div class="azur-contact-item__top">'
		. '<span class="azur-contact-item__label">' . esc_html__( 'Adresă sediu', 'azur-dent' ) . '</span>'
		. '<button type="button" class="azur-inline-copy" data-copy-text="' . esc_attr( $contact['address'] ) . '">' . esc_html__( 'Copiază adresa', 'azur-dent' ) . '</button>'
		. '</div>'
		. '<address>' . esc_html( $contact['address'] ) . '</address>'
		. '</div>';
	if ( ! empty( $contact['email'] ) && is_email( $contact['email'] ) ) {
		$output .= '<div class="azur-contact-item">'
			. '<div class="azur-contact-item__top">'
			. '<span class="azur-contact-item__label">' . esc_html__( 'Email', 'azur-dent' ) . '</span>'
			. '<button type="button" class="azur-inline-copy" data-copy-text="' . esc_attr( $contact['email'] ) . '">' . esc_html__( 'Copiază emailul', 'azur-dent' ) . '</button>'
			. '</div>'
			. '<a href="mailto:' . esc_attr( antispambot( $contact['email'] ) ) . '">' . esc_html( antispambot( $contact['email'] ) ) . '</a>'
			. '</div>';
	}
	if ( ! empty( $contact['phone'] ) ) {
		$output .= '<div class="azur-contact-item">'
			. '<div class="azur-contact-item__top">'
			. '<span class="azur-contact-item__label">' . esc_html__( 'Telefon', 'azur-dent' ) . '</span>'
			. '<button type="button" class="azur-inline-copy" data-copy-text="' . esc_attr( $contact['phone'] ) . '">' . esc_html__( 'Copiază numărul', 'azur-dent' ) . '</button>'
			. '</div>'
			. '<a href="tel:' . esc_attr( azur_dent_phone_uri( $contact['phone'] ) ) . '">' . esc_html( $contact['phone'] ) . '</a>'
			. '</div>';
	}
	$output .= '<div class="azur-contact-item">'
		. '<span class="azur-contact-item__label">' . esc_html__( 'Cum te programezi', 'azur-dent' ) . '</span>'
		. '<p class="azur-contact-item__note">' . esc_html__( 'Poți trimite o solicitare prin formularul online sau pe email. Data și ora exactă sunt confirmate ulterior de cabinet.', 'azur-dent' ) . '</p>'
		. '</div>';
	$output .= '<div class="azur-contact-actions">';
	$output .= '<a class="button button--dark" href="' . esc_url( $booking ) . '"><span>' . esc_html__( 'Solicită o programare', 'azur-dent' ) . '</span><span class="button__arrow" aria-hidden="true">↗</span></a>';
	if ( ! empty( $contact['email'] ) && is_email( $contact['email'] ) ) {
		$output .= '<a class="button button--outline" href="mailto:' . esc_attr( antispambot( $contact['email'] ) ) . '"><span>' . esc_html__( 'Scrie un email', 'azur-dent' ) . '</span><span class="button__arrow" aria-hidden="true">↗</span></a>';
	}
	if ( ! empty( $contact['phone'] ) ) {
		$output .= '<a class="button button--outline" href="tel:' . esc_attr( azur_dent_phone_uri( $contact['phone'] ) ) . '">' . esc_html__( 'Sună la cabinet', 'azur-dent' ) . '</a>';
	}
	$output .= '</div></div>';
	return $output;
}
add_shortcode( 'azur_dent_contact_details', 'azur_dent_contact_details_shortcode' );

function azur_dent_directions_shortcode() {
	return '<a class="button button--outline" href="' . esc_url( azur_dent_directions_url() ) . '" target="_blank" rel="noopener noreferrer"><span>' . esc_html__( 'Deschide traseul în Google Maps', 'azur-dent' ) . '</span><span class="button__arrow" aria-hidden="true">↗</span></a>';
}
add_shortcode( 'azur_dent_directions_link', 'azur_dent_directions_shortcode' );

function azur_dent_privacy_contact_shortcode() {
	$contact  = azur_dent_contact_settings();
	$operator = trim( $contact['operator_name'] );
	if ( '' === $operator ) {
		$operator = __( 'Identitatea juridică a operatorului trebuie completată de cabinet în Setări Azur Dent.', 'azur-dent' );
	}
	$output  = '<div class="azur-privacy-contact"><p><strong>' . esc_html__( 'Operator:', 'azur-dent' ) . '</strong> ' . esc_html( $operator ) . '</p>';
	$output .= '<p><strong>' . esc_html__( 'Adresă:', 'azur-dent' ) . '</strong> ' . esc_html( $contact['address'] ) . '</p>';
	if ( ! empty( $contact['email'] ) && is_email( $contact['email'] ) ) {
		$output .= '<p><strong>' . esc_html__( 'Email:', 'azur-dent' ) . '</strong> <a href="mailto:' . esc_attr( antispambot( $contact['email'] ) ) . '">' . esc_html( antispambot( $contact['email'] ) ) . '</a></p>';
	}
	$output .= '</div>';
	return $output;
}
add_shortcode( 'azur_dent_privacy_contact', 'azur_dent_privacy_contact_shortcode' );
