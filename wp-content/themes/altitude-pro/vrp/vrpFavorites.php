<?php
/**
 * View Favorites Template
 *
 * @package VRPConnector
 * @since 1.3.1
 */
?>

<div class="abe">

<?php if ( empty( $data->results ) ) : ?>
    <div class="abe-container">
        <div class="abe-row">
            <h2>No Favorites Found</h2>
            <p>
                <?php if ( ! empty( $data->Error ) ) : ?>
                    <?php echo $data->Error; ?>
                <?php else : ?>
                    Please revise your search criteria.
                <?php endif; ?>
            </p>
        </div>
    </div>

<?php else : ?>

    <div class="abe-container">
        <div class="abe-row abe-favorites">
        <?php foreach ( $data->results as $index => $unit ) : ?>
            
            <div class="abe-item"
                data-vrp-address="<?php echo $unit->Address1; ?> <?php echo $unit->City; ?>, <?php echo $unit->State; ?>"
                data-vrp-name="<?php echo esc_html($unit->Name); ?>"
                data-vrp-url="<?php echo site_url() . "/vrp/unit/" . $unit->page_slug; ?>"
                data-vrp-thumbnail="<?php echo $unit->Thumb; ?>"
                data-vrp-latitude="<?php echo $unit->lat; ?>"
                data-vrp-longitude="<?php echo $unit->long; ?>"
            >

                <div class="abe-image-container">
                    <div data-unit="<?= $unit->id; ?>" class="abe-favorite"><i class="fas fa-heart"></i></div>
                    <div class="abe-image">
                        <a href="/vrp/unit/<?php echo $unit->page_slug ?>"><img src="<?php echo $unit->Photo; ?>" alt="<?php echo $unit->Name ?>"></a>
                    </div>
                </div>

                <h2><a href="/vrp/unit/<?php echo $unit->page_slug ?>"><?= $unit->Name ?></a></h2>

                <div class="icons-info"> 
                    <span><i class="fas fa-bed"></i> <?= $unit->Bedrooms; ?></span>
                    <span><i class="fas fa-bath"></i> <?= $unit->Bathrooms; ?></span>
                    <span><i class="fas fa-user-friends"></i> <?= $unit->Sleeps; ?></span>
                    <span><i class="fas fa-map-marker-alt"></i> <?= $unit->City; ?></span>
                </div>

                <div>
                    <?php if ($unit->rating !== null) : ?>
                        <a href="/vrp/unit/<?= $unit->page_slug ?>#reviews">
                            <div class="star-rating mt-2 mb-2" title="<?= $unit->rating ?>">
                                <div class="back-stars">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    
                                    <div class="front-stars" style="width: <?= stars($unit->rating) ?>%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>

            </div>

        <?php endforeach; ?>

            <!-- <div id="abe-map-results" class="abe-column abe-column-50">
            </div> -->

        </div>
    </div>

<?php endif; ?>
</div>
<script>
jQuery(document).ready(function(){
    // Favorites
    if(jQuery('.abe-favorite').length) {
        
        jQuery.getJSON(url_paths.site_url + '/vrp/favorites/json').done(function (data) {
            jQuery('.abe-favorite').each(function () {
                var favButton = jQuery(this);
                var unitId = favButton.data('unit');
                var isActiveFavorite = jQuery.inArray(unitId, data);

                if (isActiveFavorite != -1) {
                    favButton.addClass('active');
                } else {
                    favButton.removeClass('active');
                }
            });
        });

        jQuery('.abe-favorite').on('click',function () {

            var favButton = jQuery(this);
            var unitId = favButton.data('unit');

            if (jQuery(this).hasClass('active')) {
                jQuery.get(url_paths.site_url + '/vrp/favorites/remove',{unit: unitId}).done(function () {
                        favButton.removeClass('active');
                    });
            } else {
                jQuery.get(url_paths.site_url + '/vrp/favorites/add',{unit: unitId}).done(function () {
                    favButton.addClass('active');
                });
            }
        });
    }
});
</script>
