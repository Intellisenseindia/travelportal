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
            <input type="hidden" id="packageid" value="<?php echo $package_id; ?>" />
            <h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-text-neutral-700"><?php echo $title; ?></h4>
                <div class="panel_s">
                    <div class="panel-body">                         
                        <div>
                            <div class="tab-content">
                                <div class="row">									
								<?php echo form_open($this->uri->uri_string(), ['class' => 'package-form', 'autocomplete' => 'off']); ?>											                                  <div class="col-md-12">										
                                  <div class="form-group" app-field-wrapper="company">										
                                  <label for="company" class="control-label">Package name</label>										
                                  <input type="text" id="packagename" name="package_name" class="form-control" value="<?php echo $package_name; ?>">
                                  </div>																		
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
					
					<?php if($title == "Update package"){ ?>
					<div>
						<div class="form-group" app-field-wrapper="company">										
                           <label for="company" class="control-label">Pickup</label>										
                           <input type="text" id="pickupname" name="pickupname" class="form-control" value="">
                        </div>
						<div class="panel-footer text-right tw-space-x-1" id="pickup-save-section">                        
							<button class="btn btn-primary only-save pickup-form-submiter">
								<?php echo _l('submit'); ?>
							</button>
						</div>
					</div>
					
					<div>
						<div class="form-group" app-field-wrapper="company">										
                           <label for="company" class="control-label">Drop</label>										
                           <input type="text" id="dropname" name="dropname" class="form-control" value="">
                        </div>
						<div class="panel-footer text-right tw-space-x-1" id="drop-save-section">                        
							<button class="btn btn-primary only-save drop-form-submiter">
								<?php echo _l('submit'); ?>
							</button>
						</div>
					</div>
					
					<div>
						<div class="form-group" app-field-wrapper="company">										
                           <label for="company" class="control-label">Sight seening</label>										
                           <input type="text" id="sightname" name="sightname" class="form-control" value="">
                        </div>
						<div class="panel-footer text-right tw-space-x-1" id="sight-save-section">                        
							<button class="btn btn-primary only-save sight-form-submiter">
								<?php echo _l('submit'); ?>
							</button>
						</div>
					</div>
					<?php } ?>
                  
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
	
	$('.pickup-form-submiter').on('click', function() {
         $.ajax({
			type: 'POST',
			url: admin_url + 'packages/addpickup',
			data: {packageid:$('#packageid').val(), pickupname:$('#pickupname').val()},
			mimeType: "multipart/form-data",
			success: function(comment) {
				alert('Pickup Added..');
				location.reload();
			}        
		});
    });
	
	$('.drop-form-submiter').on('click', function() {
        $.ajax({
			type: 'POST',
			url: admin_url + 'packages/adddrop',
			data: {packageid:$('#packageid').val(), dropname:$('#dropname').val()},
			mimeType: "multipart/form-data",
			success: function(comment) {
				alert('Drop Added..');
				location.reload();
			}        
		});
    });
	
	$('.sight-form-submiter').on('click', function() {
        $.ajax({
			type: 'POST',
			url: admin_url + 'packages/addsight',
			data: {packageid:$('#packageid').val(), sightname:$('#sightname').val()},
			mimeType: "multipart/form-data",
			success: function(comment) {
				alert('Sight Added..');
				location.reload();
			}        
		});
    });

});



</script>

</body>

</html>