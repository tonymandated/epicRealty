<?php
/**
 * Payment Page Template
 *
 * @package VRPConnector
 * @since 1.3.0
 */

global $vrp;
require 'assets/setupvars.php';
?>

<?php if ( !empty($data->Error) ) : ?>

    <a href="#">Please try again.</a> <!-- TODO -->

<?php elseif ( !isset($data->Charges) ) : ?>

    <p>We're sorry, this property is not available at for the dates requested. <a href='/'>Please try again.</a></p> <!-- TODO -->

<?php endif; ?>


<div class="abe abe-payment">
    <div class="abe-container">
        <div class="abe-row abe-book">

            <div class="abe-column">
                <?php require 'step3.php'; ?>
            </div>

            <div class="abe-column abe-booking-details">

                <div class="abe-booking-background" style="background-image: url('<?php echo $data->unit->photos[0]->url; ?>')">
                    <p>Reservation Details for</p>
                    <h1><?php echo $data->Name; ?></h1>
                </div>

                <div class="abe-ratebreakdown">

                    <div class="abe-book-info">

                        <div>
                            <i class="fa fa-calendar-alt"></i><span>Arrival: <?= $data->arrival ?></span>
                        </div>

                        <div>
                            <i class="fa fa-calendar-alt"></i><span>Departure: <?= $data->departure ?></span>
                        </div>

                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th class="abe-bold">Description</th>
                                <th class="abe-bold">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data->Charges)) : ?>
                                <?php foreach($data->Charges as $charge) : ?>
                                    <?php if (strpos(strtolower($charge->Description), 'tax') == false) : ?>
                                        <tr>
                                            <td><?= $charge->Description; ?></td>
                                            <td>$<?= number_format($charge->Amount, 2); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (!empty($data->TotalTax) && $data->TotalTax != 0) : ?>
                                <tr>
                                    <td>Tax:</td>
                                    <td>$<?= number_format($data->TotalTax, 2); ?></td>
                                </tr>
                            <?php endif; ?>

                            <?php if ( ! empty( $_GET['obj']['PromoCode'] ) || ! empty( $data->promocode ) ) : ?>
                                <?php $promoCode = ( ! empty( $_GET['obj']['PromoCode'] ) ) ? $_GET['obj']['PromoCode'] : $data->promocode; ?>
                                <tr class="promo-code">
                                    <td class="abe-bold">Promo Code Discount: <span class="abe-promo-pre"><?php echo $promoCode ?></span></td>
                                    <td class="abe-bold">-$<?php echo !empty($data->PromoCodeDiscount) ? $data->PromoCodeDiscount->value : "" ; ?></td>
                                </tr>
                            <?php endif; ?>

                            <tr>
                                <td class="abe-bold">Reservation Total:</td>
                                <td class="abe-bold">$<?= number_format(($data->TotalCost), 2); ?></td>
                            </tr>

                            <tr>
                                <td class="abe-bold">Total Due Now:</td>
                                <td class="abe-bold">$<?= number_format($data->DueToday, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
           

            </div>

        </div>
    </div>
</div>