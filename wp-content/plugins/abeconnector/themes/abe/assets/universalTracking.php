<script type="text/javascript">
    ga('require', 'ecommerce');
    ga('ecommerce:addTransaction', {
      'id': '<?php echo esc_js( $data->thebooking->BookingNumber ); ?>',                     // Transaction ID. Required.
      'affiliation': '',   // Affiliation or store name.
      'revenue': '<?php echo esc_js( $data->TotalCost ); ?>',               // Grand Total.
      'shipping': '',                  // Shipping.
      'tax': ''                     // Tax.
    });
    ga('ecommerce:addItem', {
      'id': '<?php echo esc_js( $data->thebooking->BookingNumber ); ?>',                     // Transaction ID. Required.
      'name': '<?php echo esc_js( $data->Name ); ?>',    // Product name. Required.
      'sku': '',                 // SKU/code.
      'category': 'Online Bookings',         // Category or variation.
      'price': '<?php echo esc_js( $data->TotalCost ); ?>',                 // Unit price.
      'quantity': '1'                   // Quantity.
    });
    ga('ecommerce:send');
</script>