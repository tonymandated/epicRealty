<?php
/**
 * VRPConnector Search Results Template
 *
 * @package VRPConnector
 * @since 1.3.1
 */
global $vrp;
require 'assets/setupvars.php';
?>

<div class="abe">

<?php if ( empty( $data->count ) ) : ?>
    <div class="abe-container abe-jumbo">
        <div class="abe-row abe-form-wrapper">
            <?php echo do_shortcode('[vrpResultsSearchForm]');?>
        </div>
    </div>
    <div class="abe-container abe-sort-wrapper">
        <div class="abe-row">
            <p><strong>No Results Found</strong>

                <?php if ( ! empty( $data->Error ) ) : ?>
                    <?php echo $data->Error; ?>
                <?php else : ?>
                    <br>
                    Please revise your search criteria.
                <?php endif; ?>
            </p>
            
        </div>
    </div>

<?php else : ?>
    <div class="abe-container abe-jumbo">
        <div class="abe-row abe-form-wrapper">
            <?php echo do_shortcode('[vrpResultsSearchForm]');?>
        </div>
    </div>

    <div class="abe-container abe-sort-wrapper">
        <div class="abe-row">
            <div class="abe-column no-padding">                
                <div class="abe-row abe-sort"> 
                    <div class="abe-column">
                        <div class="abe-results-info"><?= getPageCountInfo($data); ?></div>
                    </div>
                    <div class="abe-column">             
                        <?php vrp_resultsperpage(); ?>
                    </div>
                    <div class="abe-column">
                        <?php vrpsortlinks( $data->results[0] ); ?>
                    </div>
                    
                </div>
                
                
            </div>
            <div class="abe-column no-padding">
                <div class="abe-row flex-switch">                    
                    <div class="abe-column">
                        <span data-unit="<?= $data->id; ?>" class="abe-favorite-show"><a href="/vrp/favorites/show"><i class="fas fa-heart"></i> Favorites</a></span>
                    </div>
                    <div class="abe-column">
                        <?php require 'assets/shareForm.php'; ?>
                        <span data-unit="<?= $data->id; ?>" class="abe-share"><i class="fas fa-share-alt"></i></i> Share</span>
                    </div>

                    <div class="abe-column">
                        <div class="abe-map-activator map-active float-right">
                            <span class="heading">MAP</span>
                            <label class="switch">
                                <input type="checkbox" data-on="ON" data-off="OFF" class="map-toggle map-active" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        
                    </div>

                </div>
                
            </div>

            
        </div>
    </div>

    <div class="abe-row abe-results map-active">
        <div class="abe-row abe-column-50" data-vrp-arrival="<?php echo $_SESSION['arrival'] ?>" data-vrp-depart="<?php echo $_SESSION['depart']?>">

            <?php foreach ( $data->results as $index => $unit ) : ?>
                
                <div class="abe-item"
                    data-vrp-index="<?php echo $index; ?>"
                    data-vrp-address="<?php echo $unit->Address1; ?> <?php echo $unit->City; ?>, <?php echo $unit->State; ?>"
                    data-vrp-property-code="<?php echo esc_html($unit->PropertyCode); ?>"
                    data-vrp-name="<?php echo esc_html($unit->Name); ?>"
                    data-vrp-type="<?php echo esc_html($unit->Type); ?>"
                    data-vrp-url="<?php echo site_url() . "/vrp/unit/" . $unit->page_slug; ?>"
                    data-vrp-thumbnail="<?php echo $unit->Thumb; ?>"
                    data-vrp-latitude="<?php echo $unit->lat; ?>"
                    data-vrp-longitude="<?php echo $unit->long; ?>"
                    data-vrp-beds="<?php echo $unit->Bedrooms; ?>"
                    data-vrp-baths="<?php echo $unit->Bathrooms; ?>"
                    data-vrp-sleeps="<?php echo $unit->Sleeps; ?>"
                >

                    <div class="abe-image-container">
                        <div data-unit="<?= $unit->id; ?>" class="abe-favorite"><i class="fas fa-heart" title="Favorite"></i></div>
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

                    <div class="abe-rate"> 
                        <?php if (!empty($unit->Rate)) : ?>
                            <div>$<?php echo esc_html( number_format(($unit->Rate / $nights), 2) ); ?>/night</div>
                        <?php else: ?>
                            <div>From <strong>$<?= esc_html(number_format($unit->MinDaily, 2)); ?></strong>/night</div>
                        <?php endif; ?>
                    </div>

                    <div class="stars">
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
        </div>

        <div id="abe-map-results" class="abe-column abe-column-50">
        </div>

    </div>

    <?php echo vrp_pagination( $data->totalpages, $data->page ); ?>

<?php endif; ?>
</div>

<script>
jQuery(document).ready(function(){

    // Filters toggle
    if (jQuery('#abe-filters-activator').length > 0) {
        var a = jQuery('#abe-filters-activator');
        var c = jQuery('.abe-filter-close');
        a.on('click', function(){
            jQuery('.abe-filters-wrapper').toggle();
        });

        c.on('click', function(){
            jQuery('.abe-filters-wrapper').toggle();
        });
    }

    // Map toggle
    jQuery( ".map-toggle" ).change(function() {
        jQuery(this).toggleClass('map-active');
        jQuery('.abe-results').toggleClass('map-active');

        if(jQuery(this).is(':checked')) {
            window.setTimeout(function () {
                for (i in markers) {
                    bounds.extend(markers[i].position);
                    map.fitBounds(bounds);
                }
            }, 100);
            jQuery('#abe-map-results').addClass('abe-column abe-column-50');
        } else {
            jQuery('#abe-map-results').removeClass('abe-column abe-column-50');
        }
    });

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