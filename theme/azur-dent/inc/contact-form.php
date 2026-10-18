<?php
/** Appointment request form. Requests are mailed and are not stored in WordPress. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function azur_dent_form_status_notice() {
	if ( ! isset( $_GET['azur_status'] ) ) {
		return '';
	}
	$status = sanitize_key( wp_unslash( $_GET['azur_status'] ) );
	$messages = array(
		'success' => __( 'Solicitarea a fost transmisă către serviciul de email. Programarea nu este confirmată; cabinetul va reveni cu un răspuns.', 'azur-dent' ),
		'invalid' => __( 'Verifică datele completate și acordul de prelucrare, apoi încearcă din nou.', 'azur-dent' ),
		'error'   => __( 'Solicitarea nu a putut fi transmisă. Folosește adresa de email din pagina Contact sau încearcă mai târziu.', 'azur-dent' ),
		'rate'    => __( 'Ai trimis mai multe solicitări într-un interval scurt. Așteaptă puțin și încearcă din nou.', 'azur-dent' ),
	);
	if ( ! isset( $messages[ $status ] ) ) {
		return '';
	}
	$class = 'success' === $status ? 'is-success' : 'is-error';
	return '<p class="azur-form-notice ' . esc_attr( $class ) . '" role="status" aria-live="polite">' . esc_html( $messages[ $status ] ) . '</p>';
}

function azur_dent_appointment_form_shortcode() {
	$contact       = azur_dent_contact_settings();
	$services      = azur_dent_service_options();
	$descriptions  = function_exists( 'azur_dent_service_descriptions' ) ? azur_dent_service_descriptions() : array();
	$preselected   = isset( $_GET['serviciu'] ) ? sanitize_key( wp_unslash( $_GET['serviciu'] ) ) : '';
	if ( ! isset( $services[ $preselected ] ) ) {
		$preselected = '';
	}
	$form_id       = function_exists( 'wp_unique_id' ) ? wp_unique_id( 'azur-booking-' ) : 'azur-booking-' . wp_rand( 100, 9999 );
	$privacy_url   = azur_dent_page_url( 'confidentialitate' );
	$preview_text  = ( $preselected && isset( $descriptions[ $preselected ] ) ) ? $descriptions[ $preselected ] : '';
	ob_start();
	?>
	<div class="azur-form-shell" id="request-form">
		<div class="azur-form-header">
			<div class="azur-form-header__copy">
				<span class="eyebrow"><?php esc_html_e( 'FORMULAR DE PROGRAMARE', 'azur-dent' ); ?></span>
				<h2 class="azur-form-header__title"><?php esc_html_e( 'Date de contact și preferințe', 'azur-dent' ); ?></h2>
			</div>
			<div class="azur-form-progress" aria-live="polite">
				<div class="azur-form-progress__meta">
					<span><?php esc_html_e( 'Completare formular', 'azur-dent' ); ?></span>
					<strong data-progress-text>0%</strong>
				</div>
				<div class="azur-form-progress__track" aria-hidden="true">
					<span class="azur-form-progress__fill" data-progress-bar></span>
				</div>
			</div>
		</div>
		<?php echo wp_kses_post( azur_dent_form_status_notice() ); ?>
		<form class="azur-booking-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
			<input type="hidden" name="action" value="azur_dent_booking">
			<?php wp_nonce_field( 'azur_dent_booking', 'azur_booking_nonce' ); ?>
			<div class="azur-form-grid">
				<div class="azur-field azur-field--wide">
					<label for="<?php echo esc_attr( $form_id ); ?>-name"><?php esc_html_e( 'Nume și prenume', 'azur-dent' ); ?> <span aria-hidden="true">*</span></label>
					<input id="<?php echo esc_attr( $form_id ); ?>-name" name="azur_name" type="text" autocomplete="name" placeholder="<?php esc_attr_e( 'Ex. Maria Popescu', 'azur-dent' ); ?>" maxlength="100" required>
				</div>
				<div class="azur-field">
					<label for="<?php echo esc_attr( $form_id ); ?>-phone"><?php esc_html_e( 'Telefon', 'azur-dent' ); ?> <span aria-hidden="true">*</span></label>
					<input id="<?php echo esc_attr( $form_id ); ?>-phone" name="azur_phone" type="tel" autocomplete="tel" inputmode="tel" placeholder="<?php esc_attr_e( '07xx xxx xxx', 'azur-dent' ); ?>" maxlength="28" required>
				</div>
				<div class="azur-field">
					<label for="<?php echo esc_attr( $form_id ); ?>-email"><?php esc_html_e( 'Email (opțional)', 'azur-dent' ); ?></label>
					<input id="<?php echo esc_attr( $form_id ); ?>-email" name="azur_email" type="email" autocomplete="email" placeholder="<?php esc_attr_e( 'nume@exemplu.ro', 'azur-dent' ); ?>" maxlength="160">
				</div>
				<div class="azur-field azur-field--wide">
					<label for="<?php echo esc_attr( $form_id ); ?>-service"><?php esc_html_e( 'Serviciul dorit', 'azur-dent' ); ?> <span aria-hidden="true">*</span></label>
					<select id="<?php echo esc_attr( $form_id ); ?>-service" name="azur_service" required>
						<option value=""><?php esc_html_e( 'Alege o categorie', 'azur-dent' ); ?></option>
						<?php foreach ( $services as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $preselected, $key ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<div class="azur-service-preview" data-service-preview <?php echo '' === $preview_text ? 'hidden' : ''; ?>>
						<span class="azur-service-preview__badge" aria-hidden="true">i</span>
						<p class="azur-service-preview__text" data-service-preview-text><?php echo esc_html( $preview_text ); ?></p>
					</div>
					<p class="azur-field__hint"><?php esc_html_e( 'Disponibilitatea serviciului se confirmă de către cabinet.', 'azur-dent' ); ?></p>
				</div>
				<div class="azur-field">
					<label for="<?php echo esc_attr( $form_id ); ?>-date"><?php esc_html_e( 'Ziua preferată', 'azur-dent' ); ?> <span aria-hidden="true">*</span></label>
					<input id="<?php echo esc_attr( $form_id ); ?>-date" name="azur_date" type="date" min="<?php echo esc_attr( current_time( 'Y-m-d' ) ); ?>" required>
					<div class="azur-date-shortcuts" role="group" aria-label="<?php esc_attr_e( 'Scurtături pentru alegerea zilei', 'azur-dent' ); ?>">
						<button type="button" class="azur-chip" data-date-offset="1"><?php esc_html_e( 'Mâine', 'azur-dent' ); ?></button>
						<button type="button" class="azur-chip" data-date-offset="2"><?php esc_html_e( 'Peste 2 zile', 'azur-dent' ); ?></button>
						<button type="button" class="azur-chip" data-date-offset="7"><?php esc_html_e( 'Săptămâna viitoare', 'azur-dent' ); ?></button>
					</div>
				</div>
				<div class="azur-field">
					<label for="<?php echo esc_attr( $form_id ); ?>-time"><?php esc_html_e( 'Interval preferat', 'azur-dent' ); ?> <span aria-hidden="true">*</span></label>
					<select id="<?php echo esc_attr( $form_id ); ?>-time" name="azur_time" required>
						<option value=""><?php esc_html_e( 'Alege un interval', 'azur-dent' ); ?></option>
						<option value="morning"><?php esc_html_e( 'Dimineața', 'azur-dent' ); ?></option>
						<option value="afternoon"><?php esc_html_e( 'După-amiaza', 'azur-dent' ); ?></option>
						<option value="anytime"><?php esc_html_e( 'Oricând', 'azur-dent' ); ?></option>
					</select>
					<div class="azur-time-pills" role="group" aria-label="<?php esc_attr_e( 'Alegere rapidă interval', 'azur-dent' ); ?>">
						<button type="button" class="azur-time-pill" data-time-value="morning"><?php esc_html_e( 'Dimineața', 'azur-dent' ); ?></button>
						<button type="button" class="azur-time-pill" data-time-value="afternoon"><?php esc_html_e( 'După-amiaza', 'azur-dent' ); ?></button>
						<button type="button" class="azur-time-pill" data-time-value="anytime"><?php esc_html_e( 'Oricând', 'azur-dent' ); ?></button>
					</div>
					<p class="azur-field__hint"><?php esc_html_e( 'Intervalul este orientativ, nu reprezintă un orar disponibil confirmat.', 'azur-dent' ); ?></p>
				</div>
			</div>
			<div class="azur-honeypot" aria-hidden="true">
				<label for="<?php echo esc_attr( $form_id ); ?>-website"><?php esc_html_e( 'Lasă acest câmp necompletat', 'azur-dent' ); ?></label>
				<input id="<?php echo esc_attr( $form_id ); ?>-website" name="azur_website" type="text" tabindex="-1" autocomplete="off">
			</div>
			<label class="azur-consent" for="<?php echo esc_attr( $form_id ); ?>-consent">
				<input id="<?php echo esc_attr( $form_id ); ?>-consent" name="azur_consent" type="checkbox" value="1" required>
				<span><?php esc_html_e( 'Sunt de acord ca datele introduse să fie folosite pentru a răspunde solicitării mele, conform', 'azur-dent' ); ?> <a href="<?php echo esc_url( $privacy_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Informării privind confidențialitatea', 'azur-dent' ); ?></a>. <span aria-hidden="true">*</span></span>
			</label>
			<p class="azur-form-privacy-note"><?php esc_html_e( 'Nu include informații despre diagnostic, simptome sau istoric medical. Solicitarea nu rezervă automat o oră.', 'azur-dent' ); ?></p>
			<div class="azur-form-summary" hidden tabindex="-1" aria-live="polite"></div>
			<div class="azur-form-actions">
				<button class="button button--dark" type="submit">
					<span><?php esc_html_e( 'Verifică și trimite solicitarea', 'azur-dent' ); ?></span><span class="button__arrow" aria-hidden="true">↗</span>
				</button>
				<p><?php esc_html_e( 'Câmpurile marcate cu * sunt obligatorii.', 'azur-dent' ); ?></p>
			</div>
		</form>
		<?php if ( empty( $contact['email'] ) || ! is_email( $contact['email'] ) ) : ?>
			<p class="azur-form-notice is-error"><?php esc_html_e( 'Emailul cabinetului trebuie configurat în Setări Azur Dent pentru ca formularul să poată trimite solicitări.', 'azur-dent' ); ?></p>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'azur_dent_appointment_form', 'azur_dent_appointment_form_shortcode' );

function azur_dent_booking_redirect( $status ) {
	$url = azur_dent_page_url( 'programare' );
	$url = add_query_arg( 'azur_status', sanitize_key( $status ), $url );
	wp_safe_redirect( $url . '#request-form' );
	exit;
}

function azur_dent_booking_rate_key() {
	$remote_ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	return 'azur_dent_rate_' . substr( hash_hmac( 'sha256', $remote_ip, wp_salt( 'auth' ) ), 0, 40 );
}

function azur_dent_handle_booking_submission() {
	if ( 'POST' !== strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) ) {
		azur_dent_booking_redirect( 'invalid' );
	}
	$nonce = isset( $_POST['azur_booking_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['azur_booking_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'azur_dent_booking' ) ) {
		azur_dent_booking_redirect( 'invalid' );
	}
	if ( ! empty( $_POST['azur_website'] ) ) {
		azur_dent_booking_redirect( 'success' );
	}

	$rate_key = azur_dent_booking_rate_key();
	$attempts = absint( get_transient( $rate_key ) );
	if ( $attempts >= 3 ) {
		azur_dent_booking_redirect( 'rate' );
	}
	set_transient( $rate_key, $attempts + 1, 30 * MINUTE_IN_SECONDS );

	$name    = isset( $_POST['azur_name'] ) ? sanitize_text_field( wp_unslash( $_POST['azur_name'] ) ) : '';
	$phone   = isset( $_POST['azur_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['azur_phone'] ) ) : '';
	$email_raw = isset( $_POST['azur_email'] ) ? sanitize_text_field( wp_unslash( $_POST['azur_email'] ) ) : '';
	$email   = '' !== $email_raw ? sanitize_email( $email_raw ) : '';
	$service = isset( $_POST['azur_service'] ) ? sanitize_key( wp_unslash( $_POST['azur_service'] ) ) : '';
	$date    = isset( $_POST['azur_date'] ) ? sanitize_text_field( wp_unslash( $_POST['azur_date'] ) ) : '';
	$time    = isset( $_POST['azur_time'] ) ? sanitize_key( wp_unslash( $_POST['azur_time'] ) ) : '';
	$consent = isset( $_POST['azur_consent'] ) && '1' === sanitize_text_field( wp_unslash( $_POST['azur_consent'] ) );
	$digits  = preg_replace( '/\D+/', '', $phone );
	$name_length = preg_match_all( '/./us', $name );
	$services = azur_dent_service_options();
	$valid_times = array( 'morning', 'afternoon', 'anytime' );
	$valid_date = (bool) preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date );
	$date_object = $valid_date ? DateTime::createFromFormat( '!Y-m-d', $date, wp_timezone() ) : false;
	$valid_date = $date_object && $date_object->format( 'Y-m-d' ) === $date && $date >= current_time( 'Y-m-d' );

	if ( false === $name_length || $name_length < 2 || $name_length > 100 || strlen( $digits ) < 8 || strlen( $digits ) > 15 || ( '' !== $email_raw && ! is_email( $email ) ) || ! isset( $services[ $service ] ) || ! $valid_date || ! in_array( $time, $valid_times, true ) || ! $consent ) {
		azur_dent_booking_redirect( 'invalid' );
	}

	$contact = azur_dent_contact_settings();
	$recipient = isset( $contact['email'] ) ? sanitize_email( $contact['email'] ) : '';
	if ( ! is_email( $recipient ) ) {
		azur_dent_booking_redirect( 'error' );
	}
	$time_labels = array(
		'morning'   => __( 'Dimineața', 'azur-dent' ),
		'afternoon' => __( 'După-amiaza', 'azur-dent' ),
		'anytime'   => __( 'Oricând', 'azur-dent' ),
	);
	$body  = __( 'Solicitare de programare Azur Dent', 'azur-dent' ) . "\n\n";
	$body .= __( 'Nume:', 'azur-dent' ) . ' ' . $name . "\n";
	$body .= __( 'Telefon:', 'azur-dent' ) . ' ' . $phone . "\n";
	$body .= __( 'Email:', 'azur-dent' ) . ' ' . ( $email ? $email : __( 'Necompletat', 'azur-dent' ) ) . "\n";
	$body .= __( 'Serviciu:', 'azur-dent' ) . ' ' . $services[ $service ] . "\n";
	$body .= __( 'Zi preferată:', 'azur-dent' ) . ' ' . $date . "\n";
	$body .= __( 'Interval preferat:', 'azur-dent' ) . ' ' . $time_labels[ $time ] . "\n\n";
	$body .= __( 'Solicitarea nu reprezintă o programare confirmată.', 'azur-dent' );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $email && is_email( $email ) ) {
		$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
	}
	$sent = wp_mail( $recipient, __( 'Solicitare de programare — Azur Dent', 'azur-dent' ), $body, $headers );
	azur_dent_booking_redirect( $sent ? 'success' : 'error' );
}
add_action( 'admin_post_azur_dent_booking', 'azur_dent_handle_booking_submission' );
add_action( 'admin_post_nopriv_azur_dent_booking', 'azur_dent_handle_booking_submission' );
