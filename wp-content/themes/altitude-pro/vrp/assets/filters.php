<div class="abe-filter-close"><i class="fas fa-times"></i></div>



<div class="abe-row">
    <div class="abe-column">
        <select name="search[bedrooms]" id="bedrooms">
            <option selected="selected" value="">Bedrooms</option>
            <?php foreach (range($searchoptions->minbeds, $searchoptions->maxbeds) as $v) : ?>
                <option value="<?= $v; ?>"><?php echo $v; ?>+</option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="abe-column">
        <select name="search[bathrooms]" id="bathrooms">
            <option selected="selected" value="">Bathrooms</option>
            <?php foreach (range($searchoptions->minbaths, $searchoptions->maxbaths) as $v) : ?>
                <option value="<?= $v; ?>"><?php echo $v; ?>+</option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="abe-column">
        <select name="search[city]">
            <option selected="selected" value="">City</option>
            <?php foreach ($searchoptions->cities as $v) : ?>
                <?php
                    $sel = "";
                    if (strtolower($city) == strtolower($v) ) {
                        $sel = "selected=\"selected\"";
                    }
                ?>
                <option value="<?= $v; ?>" <?php echo $sel; ?> ><?php echo ucwords(strtolower($v), " "); ?></option>

            <?php endforeach; ?>
        </select>
    </div>

    <div class="abe-column">
        <select name="search[area]">
            <option selected="selected" value="">Area</option>
            <?php foreach ($searchoptions->areas as $a) : ?>
                <?php    
                    $sel = "";
                    if (strtolower($area) == strtolower($a) ) {
                        $sel = "selected=\"selected\"";
                    }
                ?>

                <option value="<?= $v; ?>" <?php echo $sel; ?> ><?php echo ucwords(strtolower($a), " "); ?></option>

            <?php endforeach; ?>
        </select>
    </div>

    <div class="abe-column">
        <button class="button">Apply Filters</button>
    </div>
</div>

<div class="">
    <div class='price-range-wrapper'>
        <p>Price Range: <span class="fromRange">$<?= $priceRange[1]; ?></span> - <span class="toRange">$<?= $priceRange[2]; ?></span></p>

        <div slider id="slider-distance">
            <div>
                <div inverse-left style="width:<?= number_format( (100 - ($priceRange[1] / 100)), 2); ?>%;"></div>
                <div inverse-right style="width:<?= number_format( (100 - ($priceRange[2] / 100)), 2); ?>%;"></div>
                <div range style="left:<?= number_format( ($priceRange[1] / 100), 2); ?>%;right:<?= number_format( 100 - ($priceRange[2] / 100), 2); ?>%;"></div>
                <span thumb style="left:<?= number_format( ($priceRange[1] / 100), 2); ?>%;"></span>
                <span thumb style="left:<?= number_format( ($priceRange[2] / 100), 2); ?>%;"></span>
                <div sign style="left:0%; display: none;">
                <!-- <span id="value">0</span> -->
                </div>
                <div sign style="left:100%; display: none;">
                <!-- <span id="value">10000</span> -->
                </div>
            </div>
            <input type="range" tabindex="0" value="<?= $priceRange[1] !== 0 ? $priceRange[1] : 0; ?>" max="10000" min="0" step="1" id="abeFromRange"/>
            <input type="range" tabindex="0" value="<?= $priceRange[2] !== 10000 ? $priceRange[2] : 10000; ?>" max="10000" min="0" step="1" id="abeToRange"/>
        </div>

        <input type="hidden" name="search[price]" value="<?= implode('-', $priceRange); ?>"/>

    </div>
</div>

<label class="abe-filter-title">Amenities</label>
<div class="abe-row">
    <?php if (!empty($customMeta)) : ?>
    <?php foreach ($customMeta as $metaKey => $metaValue) : ?>
            <div class="attr-item">
                <?php
                    $mchecked = ($_GET['search']['meta'][$metaKey]) == 1 ? "checked" : "";
                ?>
                <input type="checkbox" name="search[meta][<?= $metaKey ?>]" value="1" <?php echo $mchecked ?>>
                <label><?php echo esc_html($metaValue); ?></label>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($chunkedAmenities)) : ?>
        <?php foreach ($chunkedAmenities as $id => $chunk) : ?>
            <div class="abe-column">
            <?php foreach ($chunk as $amenity) : ?>
                <div class="attr-item">

                    <?php
                    $name = "search[attrs][]";
                    $value = $amenity;
                    if (!empty($_GET['search']['attrs'])) {
                        if (is_array($_GET['search']['attrs'])) {
                            
                            $checked = (in_array($amenity, $_GET['search']['attrs'])) ? "checked" : "";
                        } else {
                            $checked = ($amenity == $_GET['search']['attrs']) ? "checked" : "";
                        }
                    }

                    if (!empty($searchParams['attrs'])) {
                        if (is_array($searchParams['attrs'])) {
                            $checked = in_array($amenity, $searchParams['attrs']) ? "checked" : "";
                        } else {
                            $checked = $amenity == $searchParams['attrs'] ? "checked" : "";
                        }
                    }

                    ?>

                    <input type="checkbox" name="<?php echo $name ?>" value="<?php echo esc_attr($value); ?>" <?php echo $checked ?>>
                    <label><?php echo esc_html($amenity); ?></label>
                </div>
            <?php endforeach; ?>
            </div>
    <?php endforeach; ?>

<?php else : ?>
    <div class="advance-list">
        <?php foreach ($searchoptions->attrs as $amenity) : ?>
            <div class="amenity-wrapper">
                <input type="checkbox" name="search[attrs][]" value="<?php echo esc_attr($amenity); ?>"
                    <?php

                    if (!empty($_GET['search']['attrs'])) {
                        if (is_array($_GET['search']['attrs'])) {
                            echo (in_array($amenity, $_GET['search']['attrs'])) ? "checked" : "";
                        } else {
                            echo ($amenity == $_GET['search']['attrs']) ? "checked" : "";
                        }
                    }

                    ?>
                />
                <label><?php echo esc_html($amenity); ?></label>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>

<label class="abe-filter-title">Type</label>
<div class="abe-row">
    <div class="abe-column">
    <?php foreach ($searchoptions->types as $type) : ?>        
            <div class="type-item">
                <input type="checkbox" name="search[type][]" value="<?php echo esc_attr($type); ?>"
                    <?php

                    if (!empty($_GET['search']['type'])) {
                        if (is_array($_GET['search']['type'])) {
                            echo (in_array($type, $_GET['search']['type'])) ? "checked" : "";
                        } else {
                            echo ($type == $_GET['search']['type']) ? "checked" : "";
                        }
                    }

                    ?>
                >
                <label><?php echo esc_html($type); ?></label>
            </div>
        
    <?php endforeach; ?>
    </div>
</div>
<script>
 jQuery(document).ready(function () {

    jQuery(document).on('input', '#abeFromRange', function() {
        this.value=Math.min(this.value,this.parentNode.childNodes[5].value-1);
        var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
        var children = this.parentNode.childNodes[1].childNodes;
        children[1].style.width=value+'%';
        children[5].style.left=value+'%';
        children[7].style.left=value+'%';children[11].style.left=value+'%';
        jQuery('.fromRange').html(`$${this.value}`);

        var priceRange = jQuery('input[name="search[price]"]');
        var range = priceRange.val().split('-');
        range[1] = this.value;
        priceRange.val(`daily-${range[1]}-${range[2]}`);

    });

    jQuery(document).on('input', '#abeToRange', function () {
        this.value=Math.max(this.value,this.parentNode.childNodes[3].value-(-1));
        var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
        var children = this.parentNode.childNodes[1].childNodes;
        children[3].style.width = (100-value)+'%';
        children[5].style.right = (100-value)+'%';
        children[9].style.left = value+'%';children[13].style.left=value+'%';
        jQuery('.toRange').html(`$${this.value}`);

        var priceRange = jQuery('input[name="search[price]"]');
        var range = priceRange.val().split('-');
        range[2] = this.value;
        priceRange.val(`daily-${range[1]}-${range[2]}`);
    })

     function calculateFrom() {

     }
 });
</script>
