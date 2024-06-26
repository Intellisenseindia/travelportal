<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<table class="table dt-table table-timesheets" data-order-col="3" data-order-type="desc">
    <thead>
        <tr>
            <th><?php echo _l('project_timesheet_user'); ?></th>
            <th><?php echo _l('project_timesheet_task'); ?></th>
            <th><?php echo _l('project_timesheet_start_time'); ?></th>
            <th><?php echo _l('project_timesheet_end_time'); ?></th>
            <th><?php echo _l('project_timesheet_time_spend'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($timesheets as $timesheet){ ?>
            <tr>
                <td>
                    <?php echo staff_profile_image($timesheet['staff_id'],array('staff-profile-image-small')) .' ' .  e($timesheet['staff_name']); ?>
                </td>
                <td>
                    <a href="<?php echo site_url('clients/project/'.$project->id.'?group=project_tasks&taskid='.$timesheet['task_data']->id); ?>">
                        <?php echo e($timesheet['task_data']->name); ?>
                    </a>
                </td>
                <td data-order="<?php echo date('Y-m-d H:i:s', $timesheet['start_time']); ?>">
                    <?php echo e(_dt($timesheet['start_time'], true)); ?>
                </td>
                <td data-order="<?php if(!is_null($timesheet['end_time'])){echo date('Y-m-d H:i:s', $timesheet['end_time']);} ?>">
                <?php
                    if(!is_null($timesheet['end_time'])){
                        echo e(_dt($timesheet['end_time'], true));
                    } else {
                        echo '-';
                    }
                ?>
            </td>
            <td><?php echo e(seconds_to_time_format($timesheet['total_spent'])); ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>

