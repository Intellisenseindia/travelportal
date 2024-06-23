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

            <?php if (isset($client)) { ?>
            <div class="col-md-3">
                <?php $this->load->view('admin/clients/tabs'); ?>
            </div>
            <?php } ?>

            <div class="tw-mt-12 sm:tw-mt-0 <?php echo isset($client) ? 'col-md-9' : 'col-md-8 col-md-offset-2'; ?>">
            
            <h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-text-neutral-700"><?php echo $title . '(' . $locationcode . ')'; ?></h4>
                <div class="panel_s">
                    <div class="panel-body">                         
                        <div>
                            <div class="tab-content">
                                <div class="row">									
								<?php echo form_open($this->uri->uri_string(), ['class' => 'package-form', 'autocomplete' => 'off']); ?>											                                  <div class="col-md-12">										
                                   <?php

										$countries                = get_all_countries();
										$customer_default_country = get_option('customer_default_country');
										$selected                 = (isset($lead) ? $country_id : $customer_default_country);
										echo render_select('country', $countries, [ 'country_id', [ 'short_name']], 'lead_country', $selected, ['data-none-selected-text' => _l('dropdown_non_selected_tex')]);

								   ?>																		
                                  <div class="form-group" app-field-wrapper="company">										
									<label for="company" class="control-label">State</label>										
									<input type="text" id="state" name="state" class="form-control" value="<?php echo $state; ?>">
                                  </div>
								  <div class="form-group" app-field-wrapper="company">										
									<label for="company" class="control-label">City</label>										
									<input type="text" id="city" name="city" class="form-control" value="<?php echo $city; ?>">
                                  </div>
								  <div class="form-group" app-field-wrapper="company">										
									<label for="company" class="control-label">Location Name</label>										
									<input type="text" id="location_name" name="location_name" class="form-control" value="<?php echo $location_name; ?>">
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