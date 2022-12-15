<?php
/**
 * VRPConnector booking confirmation template
 *
 * @package VRPConnector
 */
$tracking = get_option("vrpConfirmation");
?>
	<div class="abe-row">
		<div class="abe-column">
  		<h3>Congratulations!</h3>
			<b>Reservation Confirmation Number:</b> <?php echo esc_html( $data->thebooking->BookingNumber ); ?><br><br>
			You have successfully booked <b><?php echo esc_html( $data->Name ); ?></b> from
			<b><?php echo esc_html( $data->thebooking->Arrival ); ?></b> for
			<b><?php echo esc_html( floor( $data->thebooking->Nights ) ); ?></b> nights.
			<br/><br/>
			You will receive an email confirmation shortly with additional information.
		</div>
	</div>

<?php if (!empty($tracking) || $tracking == 'ga4') : ?>
  <?php require "assets/{$tracking}Tracking.php" ?>
<?php endif; ?>