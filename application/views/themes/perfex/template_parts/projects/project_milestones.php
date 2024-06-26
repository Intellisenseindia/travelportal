<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<table class="table dt-table table-milestones" data-order-col="0" data-order-type="asc">
    <thead>
        <tr>
            <th class="hidden"></th>
            <th width="20%"><?php echo _l('milestone_name'); ?></th>
            <th width="45%"><?php echo _l('milestone_description'); ?></th>
            <th width="10%"><?php echo _l('milestone_start_date'); ?></th>
            <th width="10%"><?php echo _l('milestone_due_date'); ?></th>
            <?php if($project->settings->view_task_total_logged_time == 1){ ?>
                <th width="25%"><?php echo _l('milestone_total_logged_time'); ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($milestones as $milestone){ ?>
            <tr>
                <td class="hide" data-order="<?php echo e($milestone['milestone_order']); ?>"></td>
                <td><?php echo e($milestone['name']); ?></td>
                <td>
                    <?php 
                        if($milestone['description_visible_to_customer'] == 1){
                            echo process_text_content_for_display($milestone['description']);
                        }
                    ?>
                </td>
                <td data-order="<?php echo e($milestone['start_date']); ?>"><?php echo e(_d($milestone['start_date'])); ?></td>
                <td data-order="<?php echo e($milestone['due_date']); ?>"><?php echo e(_d($milestone['due_date'])); ?></td>
                <?php if($project->settings->view_task_total_logged_time == 1){ ?>
                    <td><?php echo e(seconds_to_time_format($milestone['total_logged_time'])); ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
