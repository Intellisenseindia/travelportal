<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div id="vueApp">
            <div class="row">
                <div class="col-md-12">
                    <div class="_buttons tw-mb-2 sm:tw-mb-4">
                        <?php if (staff_can('create',  'projects')) { ?>
                        <a href="<?php echo admin_url('packages/Package'); ?>"
                            class="btn btn-primary pull-left display-block mright5">
                            <i class="fa-regular fa-plus tw-mr-1"></i>
                            <?php echo 'New Package'; ?>
                        </a>
                        <?php } ?>
                        
                     
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel_s tw-mt-2 sm:tw-mt-4">
                        <div class="panel-body">                            
                            <hr class="hr-panel-separator" />
                            <div class="panel-table-full">
                                <?php $this->load->view('admin/packages/table_html'); ?>
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
$(function() {	var optionsHeading = [];    var allContactsServerParams = {        "custom_view": "[name='custom_view']",    }
    initDataTable('.table-all-package', admin_url + 'packages/table', optionsHeading, optionsHeading, allContactsServerParams, [0, 'asc'] );

    //init_ajax_search('customer', '#clientid_copy_project.ajax-search');
});
</script>
</body>
</html>