<script>
  jQuery(document).ready(function(){
    gtag('event', 'purchase', {
      'transaction_id': '<?php echo esc_js( $data->thebooking->BookingNumber ); ?>',
      'affiliation': 'Reservations',
      'value': '<?php echo esc_js( $data->TotalCost ); ?>',
      'currency': 'USD',
      'tax': '<?php echo esc_js( $data->TotalTax ); ?>',
      'shipping': 0,
      'items': [
        {
          'id': '<?php echo esc_js( $data->thebooking->BookingNumber ); ?>',
          'name': '<?php echo esc_js( $data->Name ); ?>',
          'list_name': 'Reservations',
          'category': 'Units',
          'quantity': 1
        }
      ]
    });
  });
</script>