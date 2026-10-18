<?php
/** Theme settings visible to site administrators. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function azur_dent_sanitize_settings( $input ) {
	$input    = is_array( $input ) ? $input : array();
	$defaults = azur_dent_contact_settings();
	$clean    = array();
	$email    = isset( $input['email'] ) ? sanitize_email( wp_unslash( $input['email'] ) ) : '';
	$phone    = isset( $input['phone'] ) ? sanitize_text_field( wp_unslash( $input['phone'] ) ) : '';

	$clean['email'] = is_email( $email ) ? $email : '';
	$clean['phone'] = preg_match( '/^[0-9+() .-]{7,28}$/', $phone ) ? $phone : '';
	$clean['address'] = isset( $input['address'] ) ? sanitize_text_field( wp_unslash( $input['address'] ) ) : $defaults['address'];
	$clean['operator_name'] = isset( $input['operator_name'] ) ? sanitize_text_field( wp_unslash( $input['operator_name'] ) ) : '';

	if ( '' === $clean['email'] ) {
		add_settings_error( 'azur_dent_settings', 'azur_dent_email', __( 'Adresa de email nu este validă. Solicitările nu vor fi trimise până când nu este completată o adresă validă.', 'azur-dent' ), 'error' );
	}
	if ( '' !== $phone && '' === $clean['phone'] ) {
		add_settings_error( 'azur_dent_settings', 'azur_dent_phone', __( 'Telefonul trebuie să conțină doar cifre, spații, paranteze, puncte, cratime și simbolul +.', 'azur-dent' ), 'error' );
	}
	return $clean;
}

function azur_dent_register_settings() {
	register_setting(
		'azur_dent_settings_group',
		'azur_dent_settings',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'azur_dent_sanitize_settings',
			'default'           => azur_dent_contact_settings(),
		)
	);
	add_settings_section( 'azur_dent_contact_section', __( 'Date de contact și confidențialitate', 'azur-dent' ), '__return_false', 'azur-dent-settings' );
	add_settings_field( 'azur_dent_email', __( 'Email pentru contact și solicitări', 'azur-dent' ), 'azur_dent_email_field', 'azur-dent-settings', 'azur_dent_contact_section' );
	add_settings_field( 'azur_dent_phone', __( 'Telefon', 'azur-dent' ), 'azur_dent_phone_field', 'azur-dent-settings', 'azur_dent_contact_section' );
	add_settings_field( 'azur_dent_address', __( 'Adresă', 'azur-dent' ), 'azur_dent_address_field', 'azur-dent-settings', 'azur_dent_contact_section' );
	add_settings_field( 'azur_dent_operator', __( 'Denumirea juridică a operatorului', 'azur-dent' ), 'azur_dent_operator_field', 'azur-dent-settings', 'azur_dent_contact_section' );
}
add_action( 'admin_init', 'azur_dent_register_settings' );

function azur_dent_add_settings_page() {
	add_theme_page( __( 'Setări Azur Dent', 'azur-dent' ), __( 'Setări Azur Dent', 'azur-dent' ), 'manage_options', 'azur-dent-settings', 'azur_dent_render_settings_page' );
}
add_action( 'admin_menu', 'azur_dent_add_settings_page' );

function azur_dent_field_value( $key ) {
	$settings = azur_dent_contact_settings();
	return isset( $settings[ $key ] ) ? $settings[ $key ] : '';
}

function azur_dent_email_field() {
	printf( '<input class="regular-text" type="email" id="azur-dent-email" name="azur_dent_settings[email]" value="%s" autocomplete="email">', esc_attr( azur_dent_field_value( 'email' ) ) );
	echo '<p class="description">' . esc_html__( 'Această adresă este afișată pe site și primește solicitările formularului. Verifică inboxul și configurația emailului înainte de lansare.', 'azur-dent' ) . '</p>';
}

function azur_dent_phone_field() {
	printf( '<input class="regular-text" type="tel" id="azur-dent-phone" name="azur_dent_settings[phone]" value="%s" autocomplete="tel">', esc_attr( azur_dent_field_value( 'phone' ) ) );
	echo '<p class="description">' . esc_html__( 'Lasă câmpul gol până când cabinetul confirmă numărul actual. Butonul de apel apare automat după completare.', 'azur-dent' ) . '</p>';
}

function azur_dent_address_field() {
	printf( '<input class="regular-text" type="text" id="azur-dent-address" name="azur_dent_settings[address]" value="%s" autocomplete="street-address">', esc_attr( azur_dent_field_value( 'address' ) ) );
	echo '<p class="description">' . esc_html__( 'Adresa este folosită în pagina Contact și în linkul de traseu.', 'azur-dent' ) . '</p>';
}

function azur_dent_operator_field() {
	printf( '<input class="regular-text" type="text" id="azur-dent-operator" name="azur_dent_settings[operator_name]" value="%s">', esc_attr( azur_dent_field_value( 'operator_name' ) ) );
	echo '<p class="description">' . esc_html__( 'Completează denumirea juridică exactă care operează cabinetul. Valoarea apare în informarea de confidențialitate.', 'azur-dent' ) . '</p>';
}

function azur_dent_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap" style="max-width: 960px; margin-top: 20px;">
		<div style="background: linear-gradient(135deg, #122630 0%, #1e3b49 100%); color: #fff; padding: 24px 28px; border-radius: 14px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; gap: 20px;">
			<div>
				<span style="display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: #9fe0d6; margin-bottom: 6px;">Panou de Administrare Cabinet</span>
				<h1 style="color: #fff; font-family: Georgia, serif; font-size: 26px; margin: 0 0 6px; padding: 0;">Setări Azur Dent · Apahida</h1>
				<p style="color: rgba(255,255,255,0.84); margin: 0; font-size: 14px;">Modifică rapid datele de contact care apar automat în antet, subsol, pagina Contact, hartă și formularul de programare.</p>
			</div>
			<a class="button button-secondary" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" style="white-space: nowrap;">Vezi site-ul live ↗</a>
		</div>

		<div style="display: grid; grid-template-columns: 1.55fr 1fr; gap: 20px; align-items: start;">
			<div style="background: #fff; border: 1px solid #d7dedc; border-radius: 14px; padding: 22px 26px; box-shadow: 0 4px 14px rgba(18,38,48,0.04);">
				<form action="options.php" method="post">
					<?php
					settings_fields( 'azur_dent_settings_group' );
					do_settings_sections( 'azur-dent-settings' );
					submit_button( __( 'Salvează setările cabinetului', 'azur-dent' ), 'primary large' );
					?>
				</form>
			</div>

			<div style="display: grid; gap: 16px;">
				<div style="background: #f6f4ee; border: 1px solid #d7dedc; border-left: 4px solid #2b6762; border-radius: 12px; padding: 18px 20px;">
					<h2 style="margin: 0 0 8px; font-size: 16px; color: #122630;">Personalizare pagini și secțiuni</h2>
					<p style="margin: 0 0 12px; color: #4e6068; font-size: 13px; line-height: 1.5;">Toate cele 6 pagini ale site-ului sunt construite modular cu blocuri WordPress (Gutenberg). Poți oricând adăuga secțiuni noi, șterge sau reordona secțiuni și înlocui fotografiile.</p>
					<a class="button" href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">Administrează cele 6 pagini →</a>
				</div>

				<div style="background: #fff; border: 1px solid #d7dedc; border-radius: 12px; padding: 18px 20px;">
					<h2 style="margin: 0 0 8px; font-size: 16px; color: #122630;">Paletă de culori activă</h2>
					<p style="margin: 0 0 12px; color: #4e6068; font-size: 13px; line-height: 1.5;">Culorile sunt definite centralizat și pot fi schimbate la cerere în orice altă paletă de brand:</p>
					<div style="display: flex; gap: 10px;">
						<span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600;"><span style="width: 16px; height: 16px; border-radius: 50%; background: #122630; display: inline-block;"></span>#122630</span>
						<span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600;"><span style="width: 16px; height: 16px; border-radius: 50%; background: #2b6762; display: inline-block;"></span>#2b6762</span>
						<span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600;"><span style="width: 16px; height: 16px; border-radius: 50%; background: #f6f4ee; border: 1px solid #ccc; display: inline-block;"></span>#f6f4ee</span>
					</div>
				</div>

				<div style="background: #fff; border: 1px solid #d7dedc; border-radius: 12px; padding: 18px 20px;">
					<h2 style="margin: 0 0 6px; font-size: 16px; color: #122630;">Notificări pe email</h2>
					<p style="margin: 0; color: #4e6068; font-size: 13px; line-height: 1.5;">Formularul trimite solicitările direct pe adresa de email setată în stânga și nu stochează date medicale pe server.</p>
				</div>
			</div>
		</div>
	</div>
	<?php
}
