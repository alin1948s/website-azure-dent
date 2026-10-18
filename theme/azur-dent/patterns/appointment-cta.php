<?php
/**
 * Title: Solicită o programare
 * Slug: azur-dent/appointment-cta
 * Categories: azur-dent
 * Description: O secțiune simplă care conduce la formularul de programare.
 * Inserter: true
 */
$booking_url = function_exists( 'azur_dent_page_url' ) ? azur_dent_page_url( 'programare' ) : home_url( '/' );
?>
<!-- wp:group {"tagName":"section","align":"wide","className":"azur-appointment-band"} -->
<section class="wp-block-group alignwide azur-appointment-band">
	<!-- wp:group {"tagName":"div","className":"azur-appointment-band__inner"} -->
	<div class="wp-block-group azur-appointment-band__inner">
		<!-- wp:group {"tagName":"div","className":"azur-appointment-band__copy"} -->
		<div class="wp-block-group azur-appointment-band__copy">
			<!-- wp:paragraph {"className":"eyebrow"} -->
			<p class="eyebrow">PROGRAMARE</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2,"className":"azur-section-title"} -->
			<h2 class="wp-block-heading azur-section-title">Trimite o solicitare de programare.</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Cabinetul va reveni pentru a confirma disponibilitatea. Trimiterea formularului nu rezervă automat o oră.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:group {"tagName":"div","className":"azur-appointment-band__action"} -->
		<div class="wp-block-group azur-appointment-band__action">
			<!-- wp:buttons -->
			<div class="wp-block-buttons"><!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $booking_url ); ?>">Deschide formularul</a></div>
			<!-- /wp:button --></div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
