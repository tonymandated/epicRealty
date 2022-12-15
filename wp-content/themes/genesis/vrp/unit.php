<?php
/**
 * Unit Page Template
 *
 * @package VRPConnector
 * @since 1.3.0
 */

global $vrp;
require 'assets/setupvars.php';
?>

<div class="abe abe-unit">

    <div class="abe-container">

        <div class="abe-row">
            <div class="abe-column abe-title-wrapper">
                <h1><?= $data->Name ?></h1>
                <div class="abe-icons"> 
                    <span><i class="fas fa-bed"></i> <?= $data->Bedrooms; ?> Bedrooms</span> 
                    <span><i class="fas fa-bath"></i> <?= $data->Bathrooms; ?> Bathrooms</span>
                    <span><i class="fas fa-user-friends"></i> Sleeps <?= $data->Sleeps; ?></span>
                    <span><i class="fas fa-map-marker-alt"></i> <?= $data->City; ?></span>
                </div>
            </div>

        </div>
        
        <div class="abe-row">

            <div class="abe-column abe-unit-info" id="unit-data"
                data-unit-id="<?php echo esc_attr( $data->id ); ?>"
                data-unit-property-code="<?php echo esc_html($data->PropertyCode); ?>"
                data-unit-name="<?php echo esc_html($data->Name); ?>"
                data-unit-type="<?php echo esc_html($data->Type); ?>"
                data-unit-slug="<?php echo esc_attr( $data->page_slug ); ?>"
                data-unit-address1="<?php echo esc_attr( $data->Address1 ); ?>"
                data-unit-address2="<?php echo esc_attr( $data->Address2 ); ?>"
                data-unit-city="<?php echo esc_attr( $data->City ); ?>"
                data-unit-state="<?php echo esc_attr( $data->State ); ?>"
                data-unit-zip="<?php echo esc_attr( $data->PostalCode ); ?>"
                data-unit-latitude="<?php echo esc_attr( $data->lat ); ?>"
                data-unit-longitude="<?php echo esc_attr( $data->long ); ?>"
                data-unit-beds="<?php echo $data->Bedrooms; ?>"
                data-unit-baths="<?php echo $data->Bathrooms; ?>"
                data-unit-sleeps="<?php echo $data->Sleeps; ?>"
                data-display-pageviews="<?php echo ( isset( $data->pageViews ) ) ? 'true' : 'false'; ?>"
             >

                <!-- Photo Gallery -->
                <ul id="abe-slider">
                    <?php foreach ( $data->photos as $k => $v ) : ?>
                        <li data-thumb="<?php echo esc_url( $v->url ); ?>">
                            <img src="<?php echo esc_url( $v->url ); ?>" alt="<?php echo esc_attr( $photo->caption ); ?>">
                            <?php if ( !empty($photo->caption) ) : ?>
                                <div id="caption_<?php echo esc_attr( $photo->id ); ?>" class="caption">
                                    <?php echo esc_html( $photo->caption ); ?>
                                </div>
                            <?php endif;?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div id="abe-tabs">
                    <ul>
                        <li><a href="#description">Description</a></li>
                        <li><a href="#amenities">Amenities</a></li>
                        <li><a href="#reviews">Reviews</a></li>
                        <li><a href="#calendar">Calendar</a></li>
                        <li><a href="#rates">Rates</a></li>
                        <li><a href="#location" id="gmaplink">Location</a></li>
                    </ul>

                    <!-- Description -->
                    <div id="description">
                        <p><?php echo wp_kses_post( nl2br( $data->Description ) ); ?></p>
                    </div>

                    <!-- Amenities -->
                    <div id="amenities">
                        <ul class="abe-column">
                            <?php foreach ($data->attributes as $amenity) : ?>
                                <li class="abe-amen-name">
                                    <?php echo esc_html( $amenity->name ); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Reviews -->
                    <div id="reviews">

                    <!-- Reviews modal with activator -->
                    <div class="abe-review-form">
                        <!-- <div class="btn btn-meredith text-white" id="review-form-activator">LEAVE A REVIEW</div> -->
                        <div id="abe-review-activator" class="button button-outline">LEAVE A REVIEW</div>
                        <div id="abe-review">
                            <div class="abe-container">
                                <div class="abe-row">
                                    <div class="abe-column">
                                        <p id="abe-add-review-success" style="display: none;">Thank you for submitting your review. It will be processed shortly!</p>
                                        <form id="abeSubmitReviewForm">
                                            <div class="form-group">
                                                <input type="hidden" name="review[source]" value="website">
                                                <input type="hidden" name="review[status]" value="disabled">
                                                <input type="hidden" name="review[prop_id]" id="unitIdreview" required value="<?php echo $data->id; ?>">
                                                
                                                <div class="abe-row">
                                                    <div class="abe-column">
                                                        <input type="text" placeholder="Arrival Date *" required name="review[checkin_date]" id="revArrivalDate">
                                                    </div>
                                                    <div class="abe-column">
                                                        <input type="text" placeholder="Review headline *" required name="review[title]" id="reviewName">
                                                    </div>
                                                </div>

                                                <div id="rating">
                                                    <div class="rating">
                                                        <span><input type="radio" name="review[rating]" id="str5" value="5"><label class="fa fa-star" for="str5"></label></span>
                                                        <span><input type="radio" name="review[rating]" id="str4" value="4"><label class="fa fa-star" for="str4"></label></span>
                                                        <span><input type="radio" name="review[rating]" id="str3" value="3"><label class="fa fa-star" for="str3"></label></span>
                                                        <span><input type="radio" name="review[rating]" id="str2" value="2"><label class="fa fa-star" for="str2"></label></span>
                                                        <span><input type="radio" name="review[rating]" id="str1" value="1"><label class="fa fa-star" for="str1"></label></span>
                                                    </div>
                                                </div>

                                                <div class="abe-row">
                                                    <div class="abe-column"><textarea placeholder="Comments" required name="review[review]" id="review-description" maxlength="2000" rows="50"></textarea></div>
                                                </div>

                                                <div class="abe-row">
                                                    <div class="abe-column">
                                                        <input type="email" placeholder="Guest E-mail *" required name="review[email]">
                                                    </div>
                                                    <div class="abe-column">
                                                        <input type="text" placeholder="Guest Name *" required name="review[name]">
                                                    </div>
                                                </div>
                                                
                                                <div class="abe-row">
                                                    <div class="abe-column">
                                                        <input type="text" placeholder="Location" required name="review[location]">
                                                    </div>
                                                    <div class="abe-column">
                                                        <button type="submit" class="button" id="reviewSub">SUBMIT</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of reviews modal with activator -->

                    <?php if (!empty($data->reviews)) : ?>
                        <?php foreach ($data->reviews as $review) : ?>

                            <div class="review abe-container">

                                <div class="abe-row">
                                    <div class="abe-column">
                                        <div class="review-date">
                                            <span><?= date("F j, Y", strtotime($review->review_date)) ?> - <?= ucfirst($review->source) ?></span> 
                                        </div>
                                        <?php if ($review->rating !== null) : ?>
                                            <div class="star-rating mt-2 mb-2" title="<?= $review->rating ?>">
                                                <div class="back-stars">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    
                                                    <div class="front-stars" style="width: <?= stars($review->rating) ?>%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="review-title">
                                    <h3><?= ucfirst($review->title) ?></h3> 
                                    <?php if (!empty($review->name)) : ?>
                                        <span>by <?= $review->name ?></span> 
                                    <?php endif; ?>
                                </div>

                                <div class="review-description">
                                    <?= $review->review ?>
                                </div>

                                <?php if (!empty($review->response)) : ?>
                                    <div class="review-response">
                                        <i class="fas fa-comment-dots"></i>
                                        <?= $review->response ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                        <?php endforeach; ?>
                    <?php else: ?>
                        <blockquote>
                            <p><em>We are sorry, there are no reviews for this unit. Be the first to leave a review!</em></p>
                        </blockquote>
                    <?php endif; ?>
                    </div>

                    <!-- Calendars -->
                    <div id="calendar">
                        <div class="abe-container">
                            <div class="abe-row">
                                <div class="abe-column">
                                <?php if (!empty($data->rates)) : ?>
                                    <?php echo wp_kses_post( vrp_calendar( $data->avail, 12, $data->rates ) ); ?>
                                <?php else: ?>
                                    <?php echo wp_kses_post( vrp_calendar( $data->avail, 12 ) ); ?>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rates -->
                    <div id="rates">
                        <table>
                            <thead>
                                <tr>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Amount</th>
                                <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data->rates)) : ?>
                                    <?php foreach ($data->rates as $rate) : ?>
                                    <tr>
                                        <td><?php echo $rate->start_date; ?></td>
                                        <td><?php echo $rate->end_date; ?></td>
                                        <td>$<?php echo $rate->amount; ?></td>
                                        <td><?php echo $rate->chargebasis; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Google Map -->
                    <div id="location">
                        <div id="gmap">
                            <div id="map" style="width:100%;height:500px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="abe-column abe-checkavail">
                <div class="abe-checkavail-wrapper">                   
                    <?php require 'assets/checkavailForm.php'; ?>

                    <div class="abe-row buttons-wrap">
                        <div class="abe-column">
                            <?php require 'assets/shareForm.php'; ?>

                            <div class="abe-row">
                                <div class="abe-column">
                                    <span data-unit="<?= $data->id; ?>" class="abe-favorite"><i class="fas fa-plus"></i><i class="fas fa-heart"></i> <span class="abe-fav-title">Add to Favorites</span></span>
                                </div>
                            </div>

                            <div class="abe-row abe-unit-features flex-switch">                                
                                <div class="abe-column">
                                    <span data-unit="<?= $data->id; ?>" class="abe-favorite-show"><a href="/vrp/favorites/show"><i class="fas fa-heart"></i> Favorites</a></span>
                                </div>                            
                                <div class="abe-column">
                                    <?php require 'assets/inquiryForm.php'; ?>    
                                    <span data-unit="<?= $data->id; ?>" class="abe-inquiry"><i class="fas fa-envelope"></i> Inquire</span>
                                </div>
                            </div>

                            <div class="abe-row abe-unit-features flex-switch">
                                <div class="abe-column">
                                    <span data-unit="<?= $data->id; ?>" class="abe-share"><i class="fas fa-share-alt"></i></i> Share</span>
                                </div>                                
                                <div class="abe-column">
                                    <span data-unit="<?= $data->page_slug; ?>" class="abe-print"><div id="abe-print-activator"><i class="fas fa-print"></i> Print</div></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</div>


<script>
jQuery(document).ready(function(){

    // Tabs
    jQuery("#abe-tabs").tabs();

    // Slick
    // jQuery('.abe-gallery').slick({
    //     lazyLoad: 'progressive',
    //     infinite: true,
    //     speed: 300,
    //     slidesToShow: 1,
    //     adaptiveHeight: true,
    //     prevArrow: "<div class='abe-gallery-prev'><i class='fas fa-chevron-left'></i></div>",
    //     nextArrow: "<div class='abe-gallery-next'><i class='fas fa-chevron-right'></i></div>",
    //     responsive: [
    //         {
    //         breakpoint: 768,
    //         settings: {
    //             slidesToShow: 1
    //         }
    //     },
    //     {
    //         breakpoint: 480,
    //         settings: {
    //             slidesToShow: 1
    //         }
    //     }
    //     ],
    //     asNavFor: '.abe-thumbnails'
    // });


    // jQuery('.abe-thumbnails').slick({
    //     slidesToShow: 9,
    //     slidesToScroll: 1,
    //     asNavFor: '.abe-gallery',
    //     centerMode: true,
    //     focusOnSelect: true,
    //     responsive: [
    //         {
    //         breakpoint: 768,
    //         settings: {
    //             slidesToShow: 3
    //         }
    //     },
    //     {
    //         breakpoint: 480,
    //         settings: {
    //             slidesToShow: 3
    //         }
    //     }
    //     ],
    // });

    // Print
    function openPrintDialogue(){
        var data = jQuery('.abe-print').data();

        jQuery.get('/vrp/print-unit/' + data.unit, function(r) {
            jQuery('<iframe>', {
                name: 'myiframe',
                class: 'printFrame'
            })
            .appendTo('body')
            .contents().find('body')
            .append(r);

            window.frames['myiframe'].focus();
            window.frames['myiframe'].print();

            setTimeout(() => { jQuery(".printFrame").remove(); }, 2000);
        });
    };

    jQuery('#abe-print-activator').on('click', openPrintDialogue);

    // Photo Gallery
    jQuery('#abe-slider').lightSlider({
        gallery:true,
        item:1,
        thumbItem:9,
        slideMargin: 0,
        adaptiveHeight: true,
        speed:300,
        loop:true,
        pager:true,
        thumbItem: 9,
        pause: 5000,
        prevHtml: '<i class="fas fa-chevron-left"></i>',
        nextHtml: '<i class="fas fa-chevron-right"></i>',
        responsive : [
            {
                breakpoint:800,
                settings: {
                    item:1,
                    slideMove:1,
                    thumbItem:6,
                    slideMargin:6,
                    }
            }, 
            {
                breakpoint:480,
                settings: {
                    item:1,
                    thumbItem:3,
                    slideMove:1
                    }
            }
        ]
    });

    // Review 
    if (jQuery("#abe-review").length > 0) {
        var r = jQuery('#abe-review-activator');
        r.on('click', function() {
            jQuery('#abe-review').toggle();
        });
    }

    // Review form
    jQuery("#reviewSub").click(function () {
        jQuery("#abe-btn-add-review").attr("disabled", "disabled");
    
        jQuery.post(url_paths.site_url + "/?vrpjax=1&act=addReview", jQuery("#abeSubmitReviewForm").serialize(), function(responseData){
            var review=jQuery.parseJSON(responseData);
    
            if (review.success == true) {
                jQuery("#abe-add-review-success").show();
                jQuery("#abeSubmitReviewForm").hide();
            }
            if (review.success == false) {
    
                review.errors.forEach(function (element, index, array) {
                    alert(element);
                });
                jQuery("#abe-btn-add-review").attr("disabled", false);
            }
        });
        return false;
    });

    jQuery("#revArrivalDate").click().datepicker();
    
    // Star Rating
    var logID = 'log',
        log = jQuery('<div id="' + logID + '"></div>');
    jQuery('body').append(log);
    jQuery('[type*="radio"]').change(function () {
        var me = jQuery(this);
        log.html(me.attr('value'));
    });

    //  Check Radio-box
    jQuery(".rating input:radio").attr("checked", false);
    jQuery('.rating input').click(function () {
        jQuery(".rating span").removeClass('checked');
        jQuery(this).parent().addClass('checked');
    });

    jQuery('.clear').click(function(){
        jQuery(".rating span").removeClass('checked');
    });

    jQuery('input:radio').change(
    function(){
        var userRating = this.value;
    });

    // Close quote
    if (jQuery('.abe-quote-close').length > 0) {
        jQuery('.abe-quote-close').click(function(){
            jQuery('.abe-detailed-quote').toggle();
        });
    }

    // Checkavail
    if (jQuery('.abe-checkavail-wrapper').length > 0) {
        var c = jQuery('.abe-checkavail-wrapper');
        var cOffset = c.offset().top;

        jQuery(window).scroll(function(){
            var scrolled = jQuery(this).scrollTop();
            if (scrolled >= cOffset) {
                c.addClass('fixed');
            } else {
                c.removeClass('fixed');
            }
        });
    }

    // Favorite
    if(jQuery('.abe-favorite').length) {
        
        jQuery.getJSON(url_paths.site_url + '/vrp/favorites/json').done(function (data) {
            jQuery('.abe-favorite').each(function () {
                var favButton = jQuery(this);
                var unitId = favButton.data('unit');
                var isActiveFavorite = jQuery.inArray(unitId, data);
                var favTitle = jQuery('.abe-fav-title');

                if (isActiveFavorite != -1) {
                    favButton.addClass('active');
                    favTitle.html('Remove from Favorites');
                } else {
                    favButton.removeClass('active');
                    favTitle.html('Add to Favorites');
                }
            });
        });

        jQuery('.abe-favorite').on('click',function () {

            var favButton = jQuery(this);
            var unitId = favButton.data('unit');
            var favTitle = jQuery('.abe-fav-title');

            if (jQuery(this).hasClass('active')) {
                jQuery.get(url_paths.site_url + '/vrp/favorites/remove',{unit: unitId}).done(function () {
                        favButton.removeClass('active');
                        favTitle.html('Add to Favorites');
                    });
            } else {
                jQuery.get(url_paths.site_url + '/vrp/favorites/add',{unit: unitId}).done(function () {
                    favButton.addClass('active');
                    favTitle.html('Remove from Favorites');
                });
            }
        });
    }
});
</script>
