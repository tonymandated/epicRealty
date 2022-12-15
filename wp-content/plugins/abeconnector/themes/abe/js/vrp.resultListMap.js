let map, bounds, markers = [];
(function ($, global, undefined) {

    var marker;
    var geocoder = new google.maps.Geocoder();
    bounds = new google.maps.LatLngBounds();
    var infowindow = new google.maps.InfoWindow();

    function initializeResultListMap() {
        var myOptions = {
            zoom: 13,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("abe-map-results"), myOptions);
    }

    function mapAddress(address,unitInfo) {
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                bounds.extend(results[0].geometry.location);
                //map.setCenter(results[0].geometry.location);

            marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });

            map.fitBounds(bounds);

            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    infowindow.setContent(unitInfo);
                    infowindow.open(map, marker);
                }
            })(marker));
            } else {
                console.log('Internal error: ' + status + address)


            }
        });
    }

    function mapAddressL(Lat, Long, address, unitInfo) {
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(Lat, Long)
        });

        bounds.extend(marker.position);
        map.fitBounds(bounds);

        google.maps.event.addListener(marker, 'click', (function (marker) {
            return function () {
                infowindow.setContent(unitInfo);
                infowindow.open(map, marker);
            }
        })(marker));
    }

    $(document).ready(function () {
        var vrpUnits = $('.abe-item');

if(vrpUnits.length > 0) {

    initializeResultListMap();

    function normalIcon() {
        return {
          url: url_paths.stylesheet_dir_url + '/vrp/images/ico-pin.png'
        };
    }
    
    function highlightedIcon() {
        return {
          url: url_paths.stylesheet_dir_url + '/vrp/images/ico-pin-2.png'
        };
    }

    $('.abe-item').hover(
        // mouse in
        function () {
        // first we need to know which <div class="marker"></div> we hovered
        var index = $('.abe-item').index(this);
        markers[index].setIcon(highlightedIcon());
        },
        // mouse out
        function () {
        // first we need to know which <div class="marker"></div> we hovered
        var index = $('.abe-item').index(this);
        markers[index].setIcon(normalIcon());
        }
    );

        vrpUnits.each(function () {
            var that = $(this);
            var icon_base = url_paths.stylesheet_dir_url + '/vrp/images/';

            if (that.data('vrp-latitude') == '') {
                geocoder.geocode({'address': that.data('vrp-address1')}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        bounds.extend(results[0].geometry.location);

                        marker = new google.maps.Marker({
                            map: map,
                            position: new google.maps.LatLng(Lat, Long),
                            icon: icon_base + 'ico-pin.png'
                        });
                    }
                });
            } else {
                marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(parseFloat(that.data('vrp-latitude')), parseFloat(that.data('vrp-longitude'))),
                    icon: icon_base + 'ico-pin.png'
                });
            }

            var unitInfoWindowContent = `
            <div class="container-fluid" style="max-width: 200px;">
                <div class="row marker-infobox">
                    <div class="col-12"><a href="${that.data('vrp-url')}"><img src="${that.data('vrp-thumbnail')}"></a></div>                    
                    <div class="col-12 text-center"><h5><a href="${that.data('vrp-url')}">${that.data('vrp-name')}</a></h5></div>`

                    console.log(that.data);

                    if(that.data('vrp-rating')) {
                        unitInfoWindowContent += `
                        <div class="col-12 pt-2">
                            <div class="star-rating d-flex justify-content-center" title="">
                                <div class="back-stars">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    
                                    <div class="front-stars" style="width: ${that.data('vrp-rating')}%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    }
                    unitInfoWindowContent += `
                    <div class="col-12 icons-map">
                        <span><i class="fas fa-bed"></i> ${that.data('vrp-beds')}</span> 
                        <span><i class="fas fa-bath"></i> ${that.data('vrp-baths')}</span> 
                        <span><i class="fas fa-user-friends"></i> ${that.data('vrp-sleeps')}</span> 
                    </div>                       
                </div>
            </div>
            `;

            bounds.extend(marker.position);
            map.fitBounds(bounds, 0);

            markers.push(marker);

            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    infowindow.setContent(unitInfoWindowContent);
                    infowindow.open(map, marker);
                }
            })(marker));
        });
        }
    });

}(jQuery, window));
