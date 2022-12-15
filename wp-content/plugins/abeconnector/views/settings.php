<?php
/**
 * VRPConnector WP Admin Settings Template
 *
 * @package VRPConnector
 */

global $vrp;
$vrp_user = get_option( 'vrpUser' );
$vrp_pass = get_option( 'vrpPass' );
$trackingSettings = [
    'legacy' => 'GA Legacy Tracking',
    'universal' => 'GA Tracking',
    'gtag' => 'GTAG Tracking',
    'ga4' => 'GA4',
    'ga4gtag' => 'GA4 + Universal GTAG Tracking'
];
$data = $vrp->testAPI();
?>

<div id="abe-plugin">
    <div id="abeTabs">
        <ul>
            <li class="ui-tabs-active "><a href="#settings">Settings</a></li>
            <li><a href="#wiki">Wiki</a></li>
            <li><a href="#faq">FAQ</a></li>
        </ul>

        <div id="settings">
           <?php require 'admin/settings.php' ?>
        </div>

        <div id="wiki">
            <?php require 'admin/wiki.php' ?>
        </div>

        <div id="faq">
            <?php require 'admin/faq.php' ?>
        </div>

    </div>
</div>
<script>
jQuery(document).ready(function(){
    jQuery( "#abeTabs" ).tabs();
});
</script>
