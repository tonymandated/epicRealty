<?php
/**
 * VRP Search Form Template
 *
 * @package VRPConnector
 * @since 1.3.0
 */

global $vrp;

$sleeps=esc_attr( $vrp->search->sleeps);
$searchoptions=$vrp->searchoptions();
?>

<div class="abe">
    <div class="abe-container">
        <form method="GET" action="<?php bloginfo('url'); ?>/vrp/search/results/">
        
            <div class="abe-row">

                <div class="abe-column">
                    <input type="text" id="arrival" name="search[arrival]" placeholder="Check In" value="">
                </div>

                <div class="abe-column">
                    <input type="text" id="depart" name="search[departure]" placeholder="Check Out"  value="">
                </div>

                <div class="abe-column">
                    <select name="search[Adults]" >
                        <option selected="selected" value="">Guests</option>
                        <?php foreach ( range(1, ($searchoptions->maxsleeps)) as $v ) : ?>
                            <option value="<?= $v; ?>">
                                <?= $v; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="abe-column">
                    <select name="search[type]" >
                        <option selected="selected" value="">Type</option>
                        <?php foreach ( $searchoptions->types as $type ) : ?>
                            <option value="<?= $type; ?>">
                                <?= ucfirst($type); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="abe-column">
                    <button type="submit" class="button button-outline" name="propSearch" value="Search">Search</button>
                </div>

            </div>

            <input type="hidden" name="search[showmax]" value="true">
            <input type="hidden" name="search[show]" value="12">
            <input type="hidden" name="search[sort]" value="Name">
            <input type="hidden" name="search[order]" value="ASC">

        </form>
    </div>
</div>
