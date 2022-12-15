<?php
/**
 * [vrpFeaturedUnit] Shortcode Template
 *
 * This template is used when only one featured unit is displayed.
 *
 * @package VRPConnector
 * @var $data
 */
?>
<div class="abe">

<?php if (!empty($data)) : ?>

    <div class="abe-container">
        <div class="abe-row abe-favorites">
            
            <div class="abe-item"
                data-vrp-address="<?php echo $data->Address1; ?> <?php echo $data->City; ?>, <?php echo $data->State; ?>"
                data-vrp-name="<?php echo esc_html($data->Name); ?>"
                data-vrp-url="<?php echo site_url() . "/vrp/unit/" . $data->page_slug; ?>"
                data-vrp-thumbnail="<?php echo $data->Photo; ?>"
                data-vrp-latitude="<?php echo $data->lat; ?>"
                data-vrp-longitude="<?php echo $data->long; ?>"
            >

                <div class="abe-image-container">
                    <div data-unit="<?= $data->id; ?>" class="abe-favorite"><i class="fas fa-heart"></i></div>
                    <div class="abe-image">
                        <a href="/vrp/unit/<?php echo $data->page_slug ?>"><img src="<?php echo $data->Photo; ?>" alt="<?php echo $data->Name ?>"></a>
                    </div>
                </div>

                <h2><a href="/vrp/unit/<?php echo $data->page_slug ?>"><?= $data->Name ?></a></h2>

                <div> 
                    <?= $data->Bedrooms; ?> <i class="fas fa-bed"></i> |  
                    <?= $data->Bathrooms; ?> <i class="fas fa-bath"></i> |
                    <?= $data->Sleeps; ?> <i class="fas fa-user-friends"></i> |
                    <?= $data->City; ?>
                </div>

                <div>
                    <?php if ($data->rating !== null) : ?>
                        <a href="/vrp/unit/<?= $data->page_slug ?>#reviews">
                            <div class="star-rating mt-2 mb-2" title="<?= $data->rating ?>">
                                <div class="back-stars">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    
                                    <div class="front-stars" style="width: <?= stars($data->rating) ?>%">
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

            <div id="abe-map-results" class="abe-column abe-column-50">
            </div>

        </div>
    </div>

<?php else: ?>

<?php endif; ?>


</div>