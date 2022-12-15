<?php
  $arrival = new DateTime($data->thebooking->Arrival);
  $departure = new DateTime($data->thebooking->Departure);
  $dateRange = $arrival->format('Y-m-d') . ':' . $departure->format('Y-m-d');
?>
<script>
  dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
  dataLayer.push({
    event: "purchase",
    ecommerce: {
      transaction_id: "<?php echo esc_js( $data->thebooking->BookingNumber ); ?>",
      affiliation: "Reservations",
      value: "<?php echo esc_js( $data->TotalCost ); ?>",
      tax: "<?php echo esc_js( $data->TotalTax ); ?>",
      currency: "USD",
      items: [
        {
          item_id: "<?php echo $data->unit->PropertyCode; ?>",
          item_name: "<?php echo $data->unit->Name; ?>",
          affiliation: "Reservations",
          currency: "USD",
          item_brand: "<?php echo $data->unit->Type; ?>",
          item_category: "<?php echo $data->unit->Bedrooms; ?> Bedrooms",
          item_category2: "<?php echo $data->unit->Bathrooms; ?> Bathrooms",
          item_category3: "Sleeps <?php echo $data->unit->Sleeps; ?>",
          item_category4: "<?php echo $dateRange; ?>",
          item_category5: "<?php echo $data->thebooking->Nights; ?> Nights",
          // item_list_id: "related_products",
          // item_list_name: "Related Products",
          price: "<?php echo esc_js( round(floatval($data->TotalCost) / intval($data->thebooking->Nights), 2) ); ?>",
          quantity: "<?php echo esc_js( $data->thebooking->Nights ); ?>"
        }
      ]
    }
  });

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
          'id': '<?php echo esc_js( $data->unit->PropertyCode ); ?>',
          'name': '<?php echo esc_js( $data->Name ); ?>',
          'list_name': 'Reservations',
          'currency': "USD",
          'brand': "<?php echo $data->unit->Type; ?>",
          'category': "<?php echo $data->unit->Bedrooms; ?> Bedrooms/<?php echo $data->unit->Bathrooms; ?> Bathrooms/Sleeps <?php echo $data->unit->Sleeps; ?>/<?php echo $dateRange; ?>/<?php echo $data->thebooking->Nights; ?>",
          'price': "<?php echo esc_js( round(floatval($data->TotalCost) / intval($data->thebooking->Nights), 2) ); ?>",
          'quantity': "<?php echo esc_js( $data->thebooking->Nights ); ?> Nights"
        }
      ]
    });
  });
</script>