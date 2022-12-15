<form action="<?php echo esc_url(site_url('/vrp/book/step3/', 'https')); ?>" method="get" id="bookingform">
    <h2>Book Now</h2>
    <div class="abe-row">
        <div class="abe-column">
            <label>Check In:</label>
            <input type="text" id="check-availability-arrival-date" name="obj[Arrival]" class="input unitsearch" value="<?php echo esc_attr($arrival); ?>" placeholder="Arrival" autocomplete="off" readonly="readonly">
        
            <label>Check Out:</label>
            <input type="text" id="check-availability-departure-date" name="obj[Departure]" class="input unitsearch" value="<?php echo esc_attr($depart); ?>" placeholder="Departure" autocomplete="off" readonly="readonly">
        </div>
    </div>

    <div class="abe-row flex-switch">
        <div class="abe-column">
            <label>Adults:</label>
        <select id="searchadults"  name="obj[Adults]">
            <option value="">Adults</option>
            <?php foreach (range(1, $data->Sleeps) as $v) {
                $sel = "";
                    if ($adults == $v) {
                        $sel = "selected=\"selected\"";
                    }
            ?>

                <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>

            <?php } ?>
        </select>
        </div>
        <div class="abe-column">
            <label>Children:</label>
            <select id="searchchildren" name="obj[Children]">
                <option value="">Children</option>
                <?php foreach (range(1, $data->Sleeps) as $v) {
                    $sel = "";
                    if ($children == $v) {
                        $sel = "selected=\"selected\"";
                    }
                    ?>

                    <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>

                    <?php } ?>
            </select>
        </div>
    </div>

    <div class="abe-row flex-switch promo-pets">
        <?php /* Uncomment if someone wants promocode on the unit page
        <div class="abe-column">
            <label>Promo Code:</label>
            <input type="text" id="packagecode" name="obj[PromoCode]" class="input unitsearch" value="<?php echo esc_attr($_SESSION['packagecode']); ?>" placeholder="Promo Code">
        </div>
         */ ?>
        <?php if ( ! empty( $data->additonal->petsFriendly ) && $data->additonal->maxPets > 0) : ?>
        <div class="abe-column">
            <label>Pets:</label>
            <select name="obj[Pets]">
                <option value="">Pets</option>
                <?php foreach (range(1, $data->additonal->maxPets) as $pets) : ?>
                    <option  value="<?php echo esc_attr( $pets ) ?>">
                        <?php echo esc_attr( $pets ) ?> Pet<?php if (esc_attr( $pets ) > 1): ?>s<?php endif ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </div>

    <input type="hidden" name="obj[PropID]" value="<?php echo esc_attr($data->id); ?>">

    <div id="loadingicons">
        <svg class="loader" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
            <circle class="internal-circle" cx="60" cy="60" r="30"></circle>
        </svg>
    </div>

    <div class="abe-column no-margin">
        <div id="errormsg"></div>
    </div>

    <div class="abe-quote-info"></div>

    <div class="abe-detailed-quote">
        <div class="abe-quote-close text-right">
           <i class="fas fa-times"></i>
        </div>
        <table id="ratebreakdown"></table>

        <input type="submit" value="Book Now" id="booklink">
    </div>

    <div class="abe-column no-margin">
        <div class="button button-outline" id="abe-quote-activator">Detailed Quote</div>
        <input type="submit" value="Book Now" id="booklink">
        <input type="button" id="checkbutton" value="Get Rates">
    </div>
</form>
<script>
    jQuery(document).ready(function(){
        if (jQuery('.abe-detailed-quote').length > 0) {
            jQuery('#abe-quote-activator').on('click', function(){
                jQuery('.abe-detailed-quote').toggle();
            });
        }
    });
</script>