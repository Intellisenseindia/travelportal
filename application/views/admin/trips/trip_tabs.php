<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="horizontal-scrollable-tabs tw-bg-white tw-shadow-sm tw-rounded-lg tw-px-3 tw-min-h-0">
    <div class="scroller arrow-left !tw-py-[18px] tw-mt-px tw-border-0"><i class="fa fa-angle-left"></i></div>
    <div class="scroller arrow-right !tw-py-[18px] tw-mt-px tw-border-0"><i class="fa fa-angle-right"></i></div>
    <div class="horizontal-tabs">
        <ul class="nav nav-tabs tw-mb-0 project-tabs nav-tabs-horizontal tw-border-b-0" role="tablist">
            <?php
        foreach ($tabs as $key => $tab) {
            $dropdown = isset($tab['collapse']) ? true : false; ?>
            <li class="<?php 							if ($key == 'overview' && !$this->input->get('group')) {
					echo 'active ';				}				else if($key == $this->input->get('group')){					echo 'active ';
            } ?>project_tab_<?php echo e($key); ?> tw-py-2">
                <a data-group="<?php echo e($key); ?>" role="tab" 
                    href="<?php echo admin_url('trips/viewtrip/' . $trip_id . '?group=' . $key); ?>" >			
                    <?php echo $tab; ?>
                </a>
                
            </li>
            <?php
        } ?>
        </ul>
    </div>
</div>