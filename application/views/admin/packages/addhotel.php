<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper" class="customer_profile">
    <div class="content">
        
        <?php if (isset($client) && (staff_cant('view', 'customers') && is_customer_admin($client->userid))) {?>
        <div class="alert alert-info">
            <?php echo e(_l('customer_admin_login_as_client_message', get_staff_full_name(get_staff_user_id()))); ?>
        </div>
        <?php } ?>
        <div class="row">            
            <div class="clearfix"></div>

           

            <div class="tw-mt-12 sm:tw-mt-0 <?php echo isset($client) ? 'col-md-9' : 'col-md-8 col-md-offset-2'; ?>">
            
            <h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-text-neutral-700"><?php echo $title; ?></h4>
                <div class="panel_s">
                    <div class="panel-body">                         
                        <div>
                            <div class="tab-content">
                                <div class="row">
								 
								<?php echo form_open($this->uri->uri_string(), ['class' => 'package-form', 'autocomplete' => 'off']); ?>	
								<div class="col-md-12">	
								  <div class="form-group" app-field-wrapper="hotelname">										
									<label for="hotelname" class="control-label">Hotel Name</label>										
									<input type="text" id="hotelname" name="hotelname" class="form-control" value="<?php echo $hotelname; ?>">
                                  </div>
                                   <?php

										$locations                = get_all_locations();										
										$selected                 = $locationid;
										echo render_select('locationid', $locations, [ 'location_id', [ 'location_name']], 'hotel_location', $selected, ['data-none-selected-text' => _l('dropdown_non_selected_tex')]);

								   ?>																		
                                  <div class="form-group" app-field-wrapper="phone">										
									<label for="phone" class="control-label">Phone</label>										
									<input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone; ?>">
                                  </div>
								  <div class="form-group" app-field-wrapper="email">										
									<label for="email" class="control-label">Email</label>										
									<input type="text" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                                  </div>
								  <div class="form-group" app-field-wrapper="address">
									<label for="address" class="control-label">Address</label>
									<textarea id="address" name="address" class="form-control" rows="4" spellcheck="false"><?php echo $address; ?></textarea>
								  </div>
								  <div class="form-group" app-field-wrapper="map">										
									<label for="map" class="control-label">Embed Map</label>										
									<input type="text" id="map" name="map" class="form-control" value="<?php echo $map; ?>">
                                  </div>
                                  
                                  <div class="form-group" app-field-wrapper="map">
                                  
                                  <iframe src="<?php echo $map; ?>" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                  
                                  
                                  </div>
                                  
								  <?php echo form_close(); ?>
                                  </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="panel-footer text-right tw-space-x-1" id="profile-save-section">
                        
                        <button class="btn btn-primary only-save package-form-submiter">
                            <?php echo _l('submit'); ?>
                        </button>
                    </div>
                  
                </div>
            </div>
        </div>

    </div>
</div>
<?php init_tail(); ?>

<script>

$(function() {

     $('.package-form-submiter').on('click', function() {

        var form = $('.package-form');
		
		form.submit();       

    });

});

</script>

</body>

</html>