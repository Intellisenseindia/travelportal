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
                                   <?php

										$packages                = get_all_packages();										
										$selected                 = $package_id;
										echo render_select('package_id', $packages, [ 'id', [ 'package_name']], 'Package', $selected, ['data-none-selected-text' => _l('dropdown_non_selected_tex')]);

								   ?>	

								  <div class="form-group" app-field-wrapper="trip_name">										
									<label for="trip_name" class="control-label">Trip Name</label>										
									<input type="text" id="trip_name" name="trip_name" class="form-control" value="<?php echo $trip_name; ?>">
                                  </div>
                                  <div class="form-group" app-field-wrapper="startdate">
									<?php echo render_date_input('startdate', 'project_start_date', e(_d($startdate)) ); ?>
                                  </div>
								  <div class="form-group" app-field-wrapper="enddate">										
									<?php echo render_date_input('enddate', 'End Date', e(_d($enddate)) ); ?>
                                  </div>
								  <div class="form-group" app-field-wrapper="package_price">										
									<label for="package_price" class="control-label">Package Price</label>										
									<input type="text" id="package_price" name="package_price" class="form-control" value="<?php echo $package_price; ?>">
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