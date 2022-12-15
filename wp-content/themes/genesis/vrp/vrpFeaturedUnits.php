<?php
/**
 * [vrpfeatured-units] Shorcode Template
 *
 * This is used to display the featured units when two or more units are displayed.
 *
 * @package VRPConnector
 */
?>

<?php if (!empty($data)) : ?>

        <div id="featured-units">
        <?php foreach ( $data->results as $unit ) : ?>
            <div>
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

                    <div class="featured-units-icons"> 
                        <?= $unit->Bedrooms; ?> <i class="fas fa-bed"></i> Beds |  
                        <?= $unit->Bathrooms; ?> <i class="fas fa-bath"></i> Baths |
                        <?= $unit->Sleeps; ?> <i class="fas fa-user-friends"></i> Sleep |
                        <?= $unit->City; ?>
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
            </div>
        <?php endforeach; ?>
        </div>

        <div id="abe-map-results" class="abe-column abe-column-50" style="display: none">
        </div>

<?php else: ?>

<?php endif; ?>

<style>
    /* Reset button */
    #featured-units button{
        background-color: #ffffff00;
        border: none;
        border-radius: 0px;
        color: #673ab7;
        cursor: pointer;
        display: inline-block;
        font-size: 30px;
        font-weight: 700;
        height: 20px;
        letter-spacing: 0px;
        line-height: 0px;
        padding: 0px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        white-space: nowrap;
        width: auto;
    }

    :focus {
        outline: none;
    }

    .slick-prev.slick-arrow {
        position: absolute;
        left: -25px;
        top: 45%;
    }

    .slick-next.slick-arrow {
        position: absolute;
        right: -25px;
        top: 45%;
    }

    #featured-units h2 {
        color: #2e004a;
        margin-top: 10px;
        margin-bottom: 10px;
        font-size: 1.3rem;
        line-height: 1.25;
    }

    #featured-units .featured-units-icons i {
        color: #606c76;
    }

    #featured-units a {
        color: #9b4dca;
        text-decoration: none;
    }

    #featured-units a:hover {
        color: #606c76;
    }

    #featured-units .abe-item {
        position: relative;
        flex-basis: 31.3333%;
        margin: 10px;
        padding: 10px;
        border-radius: 0.2rem;
        max-width: 500px;
        border: 1px solid #e2e2e2;
        box-shadow: 0px 0px 3px 3px #6d6d6d17;
    }
</style>

<script>
jQuery(document).ready(function(){
    // Slider
    jQuery('#featured-units').slick({
        dots: false,
        infinite: false,
        speed: 300,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-circle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-circle-right"></i></button>',
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
        ]
    });

    // Favorite
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