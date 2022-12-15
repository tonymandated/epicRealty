<h1>ABE Connector Settings</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'VRPConnector' ); ?>

    <div class="abe-tiles">

        <div class="tile">
            <h3>ABE API key Management</h3>
            <p>Your API Key can be found in the settings section after logging in to <a href='https://www.gueststream.net'>Gueststream.net</a>.</p>
            <p>Don't have an account? <a href='http://www.gueststream.com/apps-and-tools/vrpconnector-sign-up-page/'>Click Here</a> to learn more about getting a <a href='https://www.gueststream.net'>Gueststream.net</a> account.</p>
            <p>Demo API Key: <pre><strong>1533020d1121b9fea8c965cd2c978296</strong></pre> The Demo API Key does not contain bookable units therfor availability searches will not work.</p>
            <p>ABE API key:</p>
            <input type="text" name="vrpAPI" value="<?php echo esc_attr(get_option('vrpAPI')) ?>" placeholder="Your ABE API key"/>
        </div>

        <div class="tile">
            <h3>Google Map API key Management</h3>
            <p>To use Google Maps with the plugin, you must have a active Google Map Api key. More about the Google Map Api and billing click <a href="https://developers.google.com/maps/gmp-get-started">here</a>.</p>
            <p>Google Map API key:</p>
            <input type="text" name="vrpMapKey" value="<?php echo esc_attr(get_option('vrpMapKey')) ?>" placeholder="Your Google Map API key"/>
        </div>

        <div class="tile">
            <h3>ABE Template Management</h3>
            <p>ABE Connector plugin template selector allows you to quickly change templates for you vacation rental pages.</p>
            <p><strong>IMPORTANT NOTICE</strong>: Any custom changes to the template files in active Wordpress theme will be lost on change.</p>
            <p>Select your template:</p>
            <select name="vrpTheme">
                <?php foreach ($vrp->available_themes as $theme => $name) : ?>
                    <?php $selection = $name == get_option('vrpTheme') ? "selected='selected'" : "" ?>
                    <option value="<?= trim($theme) ?>" <?= $selection ?>><?= ucfirst($name) ?> Template</option>';
                <?php endforeach; ?>
            </select>
        </div>

        <div class="tile">
            <h3>ABE Revenue Tracking Management</h3>
            <p>ABE Connector plugin theme offers revenue tracking using one of the following methods.</p>
            <p>Select your Tracking method:</p>
            <select name="vrpConfirmation">
                <?php foreach ($trackingSettings as $name => $description) : ?>
                    <?php $selection = $name == get_option('vrpConfirmation') ? "selected='selected'" : "" ?>
                    <option value="<?= $name ?>" <?= $selection ?>><?= $description ?></option>
                <?php endforeach; ?>
            </select>

            <p>Add your UA code:</p>
            <input type="text" name="vrpUaCode" value="<?php echo esc_attr(get_option('vrpUaCode')) ?>" placeholder="Your Google UA code"/>
        </div>

        <div class="tile">
            <h3>Google Recaptcha V3</h3>
            <p>Google Recaptcha protects booking page from fraudulent activities, spam, and abuse.</p>
            <p>Get your API keys here <a href='https://www.google.com/recaptcha/'>here</a>.</p>

            <p>Site Key:</p>
            <input type="text" name="vrpRecaptchaSiteKey" value="<?php echo esc_attr(get_option('vrpRecaptchaSiteKey')) ?>" placeholder="Site Key"/>

            <p>Secret Key:</p>
            <input type="text" name="vrpRecaptchaSecretKey" value="<?php echo esc_attr(get_option('vrpRecaptchaSecretKey')) ?>" placeholder="Secret Key"/>

            <p>Minimum Score <small>(Default: 0.6)</small>:</p>
            <input type="number" step="0.1" min="0.0" max="1" name="vrpRecaptchaScore" value="<?php echo esc_attr(get_option('vrpRecaptchaScore', 0.6)) ?>" placeholder="Score"/>

            <p>Custom Error Message:</p>
            <input type="text" name="vrpRecaptchaCustomError" value="<?php echo esc_attr(get_option('vrpRecaptchaCustomError', 'Unfortunately, Recaptcha verification failed. Please call our office for assistance or try again.')) ?>" placeholder="Custom error message"/>

        </div>

        <div class="tile">
            <h3>ABE Server Connection Status</h3>
            <span class="abeStatus">
                <?php if ($data->Status == 'Online') : ?>
                    <span class="success"><i class="fas fa-check"></i> Connection Successfull</span>
                <?php else : ?>
                    <span class="error"><i class="fas fa-times"></i> Error Establishing Connection</span>
                <?php endif; ?>
            </span>

            <p>Here you can check the server status of your ABE account connection.</p>
        </div>

    </div>

    <?php submit_button(); ?>
</form>