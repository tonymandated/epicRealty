<div class="share-form-wrapper">
    <div class="abe-share-close text-right">
        <i class="fas fa-times"></i>
    </div>

    <form method="POST" id="shareForm">
        <div class="abe-row">
            <div class="abe-column">
                <label>Your Name:</label>
                <input type="text" name="share[name]" class="input" value="" placeholder="Your Name">
            </div>
            <div class="abe-column">
                <label>Your Email:</label>
                <input type="text" name="share[email]" value="" placeholder="Your Email">
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <label>Recipients Email:</label>
                <input type="text" name="share[recipient_email]" value="" placeholder="Recipient Email">
                <div class="disclaimer"><span>Enter one or more recipient email addresses separated by comma</span></div>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <label>Message:</label>
                <textarea name="share[message]" value="<?php echo esc_attr($_SESSION['packagecode']); ?>" placeholder="Message"></textarea>
            </div>

            <input type="hidden" name="share[link]" value="<?= get_site_url() . $_SERVER['REQUEST_URI']?>">
        </div>

        <div id="share-response"></div>

        <input type="submit" value="Share Now" id="shareNow">
    </form>
</div>
<script>
jQuery(document).ready(function(){

    // Share activator 
    if (jQuery('.abe-share').length > 0) {
        jQuery('.abe-share').on('click', function() {
            jQuery('.share-form-wrapper').toggle();
        });

        jQuery('.abe-share-close').on('click', function(){
            jQuery('.share-form-wrapper').toggle();
        });
    }

    // Share Results
    jQuery(document).on('click', '#shareNow', function () {
        jQuery.post('?vrpjax=1&act=shareResults', jQuery('#shareForm').serialize(), function(response){

            var r = jQuery.parseJSON(response);
            var infoBox = jQuery("#share-response");
            infoBox.html('');
            infoBox.removeClass();

            if (r.errors) {
                infoBox.addClass('alert').addClass('alert-danger');
                var errors = "";

                jQuery.each(r.errors, function (i, error) {

                    if (i == 'recipient_emails') {
                        errors += `<p>Emails containing errors:</p>`;

                        if (jQuery.isArray(error)) {
                            error.forEach(function(e, i){
                                errors += `<p>${error[i]}</p>`;
                            });
                        } else {
                            errors += `<p>${error}</p>`;
                        }
                        
                    } else {
                        errors += `<p>${error}</p>`;
                    }
                });

                infoBox.html(errors);

            } else {
                if (r.success) {
                    infoBox.addClass('alert').addClass('alert-primary');
                    infoBox.html("This link was shared.");
                }
            }
        });
        return false;
    });
});
</script>
