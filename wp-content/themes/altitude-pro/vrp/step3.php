<?php
/**
 * Booking -> Step3 Page Template
 *
 * @package VRPConnector
 * @since 1.3.0
 */
?>

<form
    id="vrpbookform" method="POST" action="<?php echo site_url('/vrp/book/confirm/'); ?>?obj[Arrival]=<?php echo esc_attr( $data->Arrival ); ?>&obj[Departure]=<?php echo esc_attr( $data->Departure ); ?>&obj[PropID]=<?php echo esc_attr( $_GET['obj']['PropID'] ); ?>"
    data-unit-id="<?php echo esc_attr( $data->unit->id ); ?>"
    data-unit-property-code="<?php echo esc_html($data->unit->PropertyCode); ?>"
    data-unit-name="<?php echo esc_html($data->unit->Name); ?>"
    data-unit-type="<?php echo esc_html($data->unit->Type); ?>"
    data-unit-slug="<?php echo esc_attr( $data->unit->page_slug ); ?>"
    data-unit-address1="<?php echo esc_attr( $data->unit->Address1 ); ?>"
    data-unit-address2="<?php echo esc_attr( $data->unit->Address2 ); ?>"
    data-unit-city="<?php echo esc_attr( $data->unit->City ); ?>"
    data-unit-state="<?php echo esc_attr( $data->unit->State ); ?>"
    data-unit-zip="<?php echo esc_attr( $data->unit->PostalCode ); ?>"
    data-unit-latitude="<?php echo esc_attr( $data->unit->lat ); ?>"
    data-unit-longitude="<?php echo esc_attr( $data->unit->long ); ?>"
    data-unit-beds="<?php echo $data->unit->Bedrooms; ?>"
    data-unit-baths="<?php echo $data->unit->Bathrooms; ?>"
    data-unit-sleeps="<?php echo $data->unit->Sleeps; ?>"
    >

    <div class="">
        <h3>Personal Information</h3>

        <div class="abe-row">
            <div class="abe-column">
                <input type="text" placeholder="First Name" name="booking[fname]" value="<?= $userinfo->fname; ?>" required/>
            </div>

            <div class="abe-column">
                <input type="text" placeholder="Last Name" name="booking[lname]" value="<?= $userinfo->lname; ?>" required/>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <input type="text" name="booking[address]" placeholder="Address" value="<?= $userinfo->address; ?>" required/>
            </div>

            <div class="abe-column">
                <input type="text" name="booking[address2]" placeholder="Additional Address"value="<?= $userinfo->address2; ?>"/>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
            <input type="text" placeholder="City" name="booking[city]" value="<?= $userinfo->city; ?>" required/>
            </div>

            <div id="abe-region-wrapper" class="abe-column">
                <input type="text" name="booking[region]" value="<?= $userinfo->region; ?>" placeholder="Region"/>
            </div>

            <div id="abe-state-wrapper" class="abe-column">
                <select id="state" name="booking[state]">
                    <option value="">Select State</option>
                    <?php foreach ($data->form->states as $k => $v): ?>
                        <option value="<?php echo esc_attr($k); ?>">
                            <?php echo esc_attr($v); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="abe-province-wrapper" class="abe-column">
                <select name="booking[province]">
                    <option value="">Select Province</option>
                    <?php foreach ($data->form->provinces as $k => $v): ?>
                        <option value="<?php echo esc_attr($k); ?>">
                            <?php echo esc_attr($v); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="abe-row">
            <div id="abe-country-wrapper" class="abe-column">
                <select id="country" name="booking[country]">
                    <?php foreach ($data->form->main_countries as $k => $v): ?>
                        <option value="<?php echo esc_attr($k); ?>">
                            <?php echo esc_attr($v); ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="other">Other</option>
                </select>
            </div>

            <div id="abe-othercountry-wrapper" class="abe-column">
                <select name="booking[othercountry]">
                    <option value="">Select Country</option>
                    <?php foreach ($data->form->countries as $k => $v): ?>
                        <option value="<?php echo esc_attr($k); ?>">
                            <?php echo esc_attr($v); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <input type="text" placeholder="Postal Code" name="booking[zip]" value="<?= $userinfo->zip; ?>" required/>
            </div>

            <div class="abe-column">
                <input type="text" placeholder="Phone" name="booking[phone]" value="<?= $userinfo->phone; ?>" required/>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <input type="text" name="booking[wphone]" placeholder="Work Phone" value="<?= $userinfo->wphone; ?>"/>
            </div>

            <div class="abe-column">
                <input type="text" name="booking[mphone]" placeholder="Cell Phone" value="<?= $userinfo->mphone; ?>"/>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <input type="text" placeholder="Email" name="booking[email]" value="<?= $userinfo->email; ?>"  required/>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <label for="Adults">Adults</label>
                <select name="booking[adults]">
                    <?php foreach (range(1, $data->unit->Sleeps) as $v) {
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
                <label for="Children">Children</label>
                <select name="booking[children]">
                    <?php foreach (range(0, $data->unit->Sleeps) as $v) {
                            $sel = "";
                            if ($children == $v) {
                                $sel = "selected=\"selected\"";
                            }
                        ?>
                        <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>
                        <?php } ?>
                </select>
            </div>

            <?php if ($data->unit->ManagerID == 15 && $data->unit->additonal->petsFriendly): ?>
            <div class="abe-column">
                <label for="Pets">Pets</label>
                <select name="booking[pets]">
                    <?php foreach (range(0, $data->unit->additonal->maxPets) as $v) {
                            $sel = "";
                            if ($pets == $v) {
                                $sel = "selected=\"selected\"";
                            }
                        ?>
                        <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?> Pets</option>
                        <?php } ?>
                </select>
            </div>
            <?php endif; ?>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <label for="PromoCode">Promo Code</label>
                <?php $promoCode = ( ! empty( $_GET['obj']['PromoCode'] ) ) ? $_GET['obj']['PromoCode'] : $data->promocode; ?>
                <input type="text" name="booking[PromoCode]" value="<?php echo $promoCode ?>">
            </div>

            <div class="abe-column">
                <div class="button abe-apply-promo">Apply Promocode</div>
            </div>
        </div>
    </div>

    <?php if ( isset( $data->HasInsurance ) && $data->HasInsurance ) : ?>
    <div class="">
        <div class="abe-row">
            <div class="abe-column">
                <h3>Optional Add-ons</h3>

                <div class="abe-travel-ins">
                    <p>Travel insurance is available for your trip.</p>
                    $<span><?php echo esc_html( number_format( $data->InsuranceAmount, 2 ) ); ?></span>
                    <div>
                        <input type="radio" name="booking[acceptinsurance]" value="1" required/> Yes
                        <input type="radio" name="booking[acceptinsurance]" value="0" checked/> No
                        <input type="hidden" name="booking[InsuranceAmount]" value="<?php echo esc_attr( $data->InsuranceAmount ); ?>"/>
                    </div>
                </div>

                <?php if ( isset( $data->InsuranceID ) ) : // Escapia Insurance ID ?>
                    <input type="hidden" name="booking[InsuranceID]" value="<?php echo $data->InsuranceID; ?>" />
                <?php endif; ?>

                <?php if ( isset( $data->InsuranceTaxAmount ) ) : ?>
                    <?php
                    /**
                     * Escapia Travel Insurance Tax Amount
                     *
                     * In most cases we have seen, travel insurance is not taxed so this will not
                     * be present.  In the case that travel insurance is taxed, this value is necessary
                     * to tell the server to separate this amount from the '$data->InsuranceAmount' value as
                     * the displayed '$data->InsuranceAmount' value includes the Taxes.
                     */
                    ?>
                    <input type="hidden" name="booking[InsuranceTaxAmount]" value="<?php echo $data->InsuranceTaxAmount; ?>"/>
                <?php endif; ?>

                <div class="abe-row" id="add-ons">
                    <input type="hidden" name="booking[addOnsAdvanced]" value="1">
                    <?php
                        if (!empty($data->unit->fees)):
                            foreach ($data->unit->fees as $addOn):
                                if (empty($addOn->isRequired)):
                    ?>
                    <div class="abe-column">
                        <label for="add-on-<?php echo $addOn->id; ?>"><?php echo $addOn->name; ?></label>
                        <!--
                        <input type="number" name="booking[addOns][<?php echo $addOn->id; ?>]" id="add-on-<?php echo $addOn->id; ?>" value="0" steps="1" min="0" max="<?php echo $addOn->maxQuantity; ?>" class="addOn">
                        -->
                        <select name="booking[addOns][<?php echo $addOn->id; ?>]" id="add-on-<?php echo $addOn->id; ?>" class="addOn">
                            <option value="0">Quantity</option>
                            <?php foreach (range(1, $addOn->maxQuantity) as $quantity): ?>
                            <option value="<?php echo $quantity; ?>"><?php echo $quantity; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php
                                endif;
                            endforeach;
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <input type="hidden" name="booking[acceptinsurance]" value="0"/>
    <?php endif; ?>

    <div class="">

        <div class="abe-row">
            <div class="abe-column">
                <input placeholder="Credit Card Number" type="text" name="booking[ccNumber]" required/>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <input type="text" placeholder="CVV" name="booking[cvv]" required>
            </div>
            
            <?php if (isset($data->booksettings->Cards)) : ?>
                <div class="abe-column">
                    <select name="booking[ccType]">
                        <?php foreach ($data->booksettings->Cards as $k => $v) : ?>
                            <option value="<?= $k; ?>"><?= $v; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
                    
            <div class="abe-column">
                <select name="booking[expMonth]" required>
                    <option value>Month</option>
                    <?php foreach (range (1, 12) as $month): ?>
                        <option value="<?= sprintf ("%02d", $month) ?>"><?= sprintf ("%02d", $month) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="abe-column">
                <select name="booking[expYear]" required>
                    <option value>Year</option>
                    <?php foreach (range (date ("Y"), date ("Y") + 10) as $year): ?>
                        <option value="<?= $year; ?>"><?= $year; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <h3>Comments or Special Requests</h3>
                <textarea name="booking[comments]"></textarea>
            </div>
        </div>

        <input type="hidden" id="vrp-prop-id" name="booking[PropID]" value="<?php echo esc_attr( $data->PropID ); ?>">
        <input type="hidden" name="booking[arrival]" value="<?php echo esc_attr( $data->arrival ); ?>">
        <input type="hidden" name="booking[depart]" value="<?php echo esc_attr( $data->departure ); ?>">
        <input type="hidden" name="booking[nights]" value="<?php echo esc_attr( $data->nights ); ?>">
        <input type="hidden" name="booking[DueToday]" value="<?php echo esc_attr( $data->DueToday ); ?>">
        <input type="hidden" name="booking[TotalCost]" value="<?php echo esc_attr( $data->TotalCost ); ?>">
        <input type="hidden" name="booking[TotalBefore]" value="<?php echo esc_attr( $data->TotalCost - $data->TotalTax ); ?>">
        <input type="hidden" name="booking[TotalTax]" value="<?php echo esc_attr( $data->TotalTax ); ?>">
        <input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">

        <?php if ( ! empty( $_GET['obj']['Pets'] ) && $data->unit->ManagerID == 1 ) : // Currently, only applicable to Escapia PMS. ?>
            <input type="hidden" name="booking[Pets]" value="<?php echo esc_attr( $_GET['obj']['Pets'] ); ?>">
        <?php endif; ?>

        <div id="loadingicons">
            <p>Processing your booking ...</p>
            <svg class="loader" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                <circle class="internal-circle" cx="60" cy="60" r="30"></circle>
            </svg>
        </div>

        <?php if (!empty($data->booksettings->policies[0]->external)) : ?>
            <div class="abe-terms-input">
                <input type="checkbox" id="terms" name="terms" required><span> I have read and accept the above <a href="<?= $data->booksettings->policies[0]->external; ?>" target="_blank">terms &amp; conditions</a></span>
            </div>
        <?php else: ?>
            <div class="abe-terms">
                <div class="abe-terms-close text-right">
                    <i class="fa fa-close"></i> Close Terms
                </div>
            </div>

            <div class="abe-terms-input">
                <input type="checkbox" id="terms" name="terms" required><span> I have read and accept the above <a href="#" id="abe-terms-activator">terms &amp; conditions</a>.</span>
            </div>
        <?php endif; ?>

        <input type="submit" value="Book This Property Now" class="vrp-btn vrp-btn-success " id="bookingbuttonvrp">
    </div>

</form>
<script>
    jQuery(document).ready(function(){
        var termsActivator = jQuery('#abe-terms-activator');
        var termsClose = jQuery('.abe-terms-close');
        termsActivator.on('click', function(){
            jQuery('.abe-terms').toggle();
            return false;
        });

        termsClose.on('click', function(){
            jQuery('.abe-terms').toggle();
        });

        // Apply promocode
        if (jQuery('.abe-apply-promo').length > 0) {
            var promoActivator = jQuery('.abe-apply-promo');
            promoActivator.on('click', function(){
                getQuote();
            });
        }

        // Quote on adults/children change
        jQuery('select[name="booking[adults]"]').change(function(){
            getQuote();
        });

        jQuery('select[name="booking[pets]"]').change(function(){
            getQuote();
        });

        jQuery('select[name="booking[children]"]').change(function(){
            getQuote();
        });

        jQuery('input[type=radio][name="booking[acceptinsurance]"]').change(function(){
            getQuote();
        });

        // Any element with class addOn will trigger a new quote
        jQuery('.addOn').change(function () {
            getQuote();
        });

        function getQuote() {
            var promoCode = jQuery('input[name="booking[PromoCode]"]').val();
            jQuery.post(url_paths.site_url + "/?vrpjax=1&act=checkavailability&par=1", jQuery("#vrpbookform").serialize(), function (data) {
                var obj = jQuery.parseJSON(data);
                var response = "";
                var bookInfoTable = jQuery('.abe-ratebreakdown > table > tbody');

                if (!obj.Error) {
                    // Charges
                    jQuery.each(obj.Charges, function(c, v){
                        if (!v.Description.includes("Tax")) {
                            response += `<tr>
                                <td>${v.Description}</td>
                                <td>\$${addCommas(parseFloat(v.Amount).toFixed(2))}</td>
                            </tr>`;
                        }
                    });

                    // Taxes
                    if ('TotalTax' in obj) {
                        response += `<tr>
                            <td>Tax:</td>
                            <td>\$${addCommas(parseFloat(obj.TotalTax).toFixed(2))}</td>
                        </tr>`;
                    }

                    var insChecked = jQuery('input[type=radio][name="booking[acceptinsurance]"]:checked').val();

                    if(jQuery('input[type=radio][name="booking[acceptinsurance]"]').is(':checked')) { 

                        if ( insChecked == 1) {
                            response += `<tr>
                            <td>Travel Insurance:</td>
                            <td>\$${addCommas(parseFloat(obj.InsuranceAmount).toFixed(2))}</td>
                            </tr>`;
                        }
                    };

                    // Promocode Discount
                    if ('PromoCodeDiscount' in obj) {
                        response += `<tr class="abe-promo-cell">
                            <td class="abe-bold">Promo Code Discount: <span class="abe-promo-pre">${obj.PromoCodeDiscount.text}</span></td>
                            <td class="abe-bold">-\$${addCommas(parseFloat(obj.PromoCodeDiscount.value).toFixed(2))}</td>
                        </tr>`;
                    }

                    // Reservation Total
                    if ('TotalCost' in obj) {

                        jQuery('input[name="booking[TotalCost]"]').val(obj.TotalCost);

                        if ( insChecked == 1) { 
                            response += `<tr>
                                <td class="abe-bold">Reservation Total:</td>
                                <td class="abe-bold">\$${addCommas(parseFloat(parseFloat(obj.TotalCost) + parseFloat(obj.InsuranceAmount)).toFixed(2) )}</td>
                            </tr>`;

                            // Total Due Now
                            if ('DueToday' in obj) {
                                response += `<tr>
                                    <td class="abe-bold">Total Due Now:</td>
                                    <td class="abe-bold">\$${addCommas(parseFloat(parseFloat(obj.DueToday) + parseFloat(obj.InsuranceAmount)).toFixed(2))}</td>
                                </tr>`;
                            }

                        } else {
                            response += `<tr>
                                <td class="abe-bold">Reservation Total:</td>
                                <td class="abe-bold">\$${addCommas(parseFloat(obj.TotalCost).toFixed(2))}</td>
                            </tr>`;

                            // Total Due Now
                            if ('DueToday' in obj) {
                                response += `<tr>
                                    <td class="abe-bold">Total Due Now:</td>
                                    <td class="abe-bold">\$${addCommas(parseFloat(obj.DueToday).toFixed(2))}</td>
                                </tr>`;
                            }
                        }
                       
                    }
                    bookInfoTable.html(response);
                } else {
                    alert(`Notice: ${obj.Error}`);
                }
            });
        }
    });
</script>


