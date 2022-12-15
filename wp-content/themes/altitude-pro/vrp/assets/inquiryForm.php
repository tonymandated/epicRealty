<div class="inquiry-form-wrapper">
    <div class="abe-inquiry-close text-right">
        <i class="fas fa-times"></i>
    </div>

    <form id="vrpinquire">

        <div class="abe-row">
            <input type="hidden" name="obj[unit_id]" value="<?= $data->id; ?>">
                
            <div class="abe-column">
                <input type="text" name="obj[name]" placeholder="Name" required>
            </div>

            <div class="abe-column">
                <input type="text" name="obj[email]" placeholder="Email" required>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <input type="text" name="obj[phone]" placeholder="Phone" required>
            </div>

            <div class="abe-column">
                <input type="text" name="obj[checkin]" class="datepicker" value="<?= $_SESSION['arrival']; ?>" id="icheckinput" placeholder="Arrival">
            </div>
        </div>

        <div class="abe-row">
            
            <div class="abe-column">
                <select name="obj[nights]">
                    <option value="" selected>Nights</option>
                    <?php foreach ( range( 3, 30 ) as $v ): ?>
                        <option value="<?= $v; ?>"><?= $v; ?></option>
                    <?php endforeach; ?>
                </select>     
            </div>

            <div class="abe-column"></div>
        </div>

        <div class="abe-row">
            <div class="abe-column">
                <label>Comments</label>
                <textarea id="message" rows="20" cols="50" name="obj[comments]" placeholder="Inquiry"></textarea>
            </div>
        </div>

        <input type="submit" value="Submit Inquiry">
    </form>
</div>
<script>
jQuery(document).ready(function(){

    // Share activator 
    if (jQuery('.abe-inquiry').length > 0) {
        jQuery('.abe-inquiry').on('click', function() {
            jQuery('.inquiry-form-wrapper').toggle();
        });

        jQuery('.abe-inquiry-close').on('click', function(){
            jQuery('.inquiry-form-wrapper').toggle();
        });
    }

    // Share Results
    // jQuery(document).on('click', '#shareNow', function () {
    //     jQuery.post('?vrpjax=1&act=shareResults', jQuery('#shareForm').serialize(), function(response){

    //         var r = jQuery.parseJSON(response);
    //         var infoBox = jQuery("#share-response");
    //         infoBox.html('');
    //         infoBox.removeClass();

    //         if (r.errors) {
    //             infoBox.addClass('alert').addClass('alert-danger');
    //             var errors = "";

    //             jQuery.each(r.errors, function (i, error) {

    //                 if (i == 'recipient_emails') {
    //                     errors += `<p>Emails containing errors:</p>`;

    //                     if (jQuery.isArray(error)) {
    //                         error.forEach(function(e, i){
    //                             errors += `<p>${error[i]}</p>`;
    //                         });
    //                     } else {
    //                         errors += `<p>${error}</p>`;
    //                     }
                        
    //                 } else {
    //                     errors += `<p>${error}</p>`;
    //                 }
    //             });

    //             infoBox.html(errors);

    //         } else {
    //             if (r.success) {
    //                 infoBox.addClass('alert').addClass('alert-primary');
    //                 infoBox.html("This link was shared.");
    //             }
    //         }
    //     });
    //     return false;
    // });
});
</script>
