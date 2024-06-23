<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div id="vueApp">
            <div class="row">
                <div class="col-md-12">
                    <div class="_buttons tw-mb-2 sm:tw-mb-4">
                        <?php if (staff_can('create',  'projects')) { ?>
                        <a href="<?php echo admin_url('packages/addtransport'); ?>"
                            class="btn btn-primary pull-left display-block mright5">
                            <i class="fa-regular fa-plus tw-mr-1"></i>
                            <?php echo 'New Transport Name'; ?>
                        </a>
                        <?php } ?>
                        
                     
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel_s tw-mt-2 sm:tw-mt-4">
                        <div class="panel-body">   
                        	<div class="row mbot15">
                              <div class="col-md-12">
                                <h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-flex tw-items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-w-5 tw-h-5 tw-text-neutral-500 tw-mr-1.5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                  </svg><span> <?php echo $title; ?></span></h4>
                              </div>  
                            </div>                         
                            <hr class="hr-panel-separator" />
                            <div class="panel-table-full">
                                <?php $this->load->view('admin/packages/transport_table_html'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
<script>
$(function() {	
	var optionsHeading = [];    
	var allContactsServerParams = {        "custom_view": "[name='custom_view']",    };
	
    initDataTable('.table-all-transport', admin_url + 'packages/transporttable', optionsHeading, optionsHeading, allContactsServerParams, [0, 'asc'] );

    //init_ajax_search('customer', '#clientid_copy_project.ajax-search');
});
</script>
</body>
</html>