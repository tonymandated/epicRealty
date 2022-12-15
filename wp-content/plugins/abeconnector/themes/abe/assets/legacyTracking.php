
  <script type="text/javascript">

  var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

  document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));

  </script>
      <script type="text/javascript">

  try {

    var pageTracker = _gat._getTracker("<?php echo get_option("vrpUaCode") ?>");


    pageTracker._trackPageview();


    pageTracker._addTrans(

      "<?php echo esc_js( $data->thebooking->BookingNumber ) ?>",                                     // Order ID

      "",                                                                       // Affiliation

      "<?php echo esc_js( $data->TotalCost ) ?>",                                     // Total

      "",                                     // Tax

      "",                                        // Shipping

      "",                                 // City

      "",                               // State

      ""                                       // Country

    );

  pageTracker._addItem(

      "<?php echo esc_js( $data->thebooking->BookingNumber ) ?>",                                     // Order ID

      "",                                     // SKU

      "<?php echo esc_js( $data->Name ) ?>",                                  // Product Name

      "",                             // Category

      "<?php echo esc_js( $data->TotalCost ) ?>",       // Price

      "1"                                         // Quantity

    );



    pageTracker._trackTrans();

  } catch(err) {}
  </script>
