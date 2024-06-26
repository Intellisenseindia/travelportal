<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo form_open($this->uri->uri_string() . ($this->input->get('project_id') ? '?project_id=' . $this->input->get('project_id') : '')); ?>
                <div class="row">
                    <div class="col-md-2">
                        <?php if (!$this->input->get('project_id')) { ?>
                        <a href="<?php echo admin_url('tasks'); ?>"
                            class="btn btn-default tw-mt-0.5"><?php echo _l('back_to_tasks_list'); ?></a>
                        <?php } else { ?>
                        <a href="<?php echo admin_url('projects/view/' . $this->input->get('project_id') . '?group=project_tasks'); ?>"
                            class="btn btn-default tw-mt-0.5"><?php echo _l('back_to_project'); ?></a>
                        <?php } ?>
                    </div>
                    <?php echo form_hidden('project_id', $this->input->get('project_id')); ?>
                    <?php if (staff_can('view',  'tasks')) { ?>
                    <div class="col-md-2 border-right">
                        <?php
                           echo render_select('member', $members, ['staffid', ['firstname', 'lastname']], '', $staff_id, ['data-none-selected-text' => _l('all_staff_members')], [], 'no-margin'); ?>
                    </div>
                    <?php } ?>
                    <div class="col-md-2 border-right">
                        <?php
                           $months = [];

                           for ($m = 1; $m <= 12; $m++) {
                               $data          = [];
                               $data['month'] = $m;
                               $data['name']  = _l(date('F', mktime(0, 0, 0, $m, 1)));
                               $months[]      = $data;
                           }
                           $selected = ($this->input->post('month') ? $this->input->post('month') : date('m'));
                           if ($this->input->post() && $this->input->post('month') == '') {
                               $selected = '';
                           }
                           echo render_select('month', $months, ['month', ['name']], '', $selected, ['data-none-selected-text' => _l('task_filter_detailed_all_months')], [], 'no-margin');
                           ?>
                    </div>
                    <div class="col-md-2 text-center border-right">
                        <div class="form-group no-margin select-placeholder">
                            <select name="status" id="status" class="selectpicker no-margin" data-width="100%"
                                data-title="<?php echo _l('task_status'); ?>">
                                <option value="" selected><?php echo _l('task_list_all'); ?></option>
                                <?php foreach ($task_statuses as $status) { ?>
                                <option value="<?php echo e($status['id']); ?>" <?php if ($this->input->post('status') == $status['id']) {
                               echo 'selected';
                           } ?>><?php echo e($status['name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 border-right select-placeholder">
                        <select name="year" id="year" class="selectpicker no-margin" data-width="100%">
                            <?php foreach ($years as $data) { ?>
                            <option value="<?php echo e($data['year']); ?>" <?php if ($this->input->post('year') == $data['year'] || date('Y') == $data['year']) {
                               echo 'selected';
                           } ?>><?php echo e($data['year']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block"
                            style="margin-top:3px;"><?php echo _l('filter'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <div class="panel_s tw-mt-8">
                    <div class="panel-body panel-table-full">
                        <?php foreach ($overview as $month => $data) {
                               if (count($data) == 0) {
                                   continue;
                               } ?>
                        <h4 class="bold tw-mb-6 text-success"><?php echo  _l(date('F', mktime(0, 0, 0, $month, 1))); ?>
                            <?php if ($this->input->get('project_id')) {
                                   echo ' - ' . e(get_project_name_by_id($this->input->get('project_id')));
                               } ?>
                            <?php if (is_numeric($staff_id) && staff_can('view',  'tasks')) {
                                   echo ' (' . e(get_staff_full_name($staff_id)) . ')';
                               } ?>
                        </h4>
                        <table class="table tasks-overview dt-table">
                            <thead>
                                <tr>
                                    <th><?php echo _l('tasks_dt_name'); ?></th>
                                    <th><?php echo _l('tasks_dt_datestart'); ?></th>
                                    <th><?php echo _l('task_duedate'); ?></th>
                                    <th><?php echo _l('task_status'); ?></th>
                                    <th><?php echo _l('tasks_total_added_attachments'); ?></th>
                                    <th><?php echo _l('tasks_total_comments'); ?></th>
                                    <th><?php echo _l('task_checklist_items'); ?></th>
                                    <th><?php echo _l('staff_stats_total_logged_time'); ?></th>
                                    <th><?php echo _l('task_finished_on_time'); ?></th>
                                    <th><?php echo _l('task_assigned'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                           foreach ($data as $task) { ?>
                                <tr>
                                    <td data-order="<?php echo htmlentities($task['name']); ?>"><a
                                            href="<?php echo admin_url('tasks/view/' . $task['id']); ?>"
                                            onclick="init_task_modal(<?php echo e($task['id']); ?>); return false;">
                                            <?php echo e($task['name']); ?>
                                </a>
                                <?php
                                    if (!empty($task['rel_id'])) {
                                        echo '<br />' . _l('task_related_to') . ': <a class="text-muted" href="' . e(task_rel_link($task['rel_id'], $task['rel_type'])) . '">' . e(task_rel_name($task['rel_name'], $task['rel_id'], $task['rel_type'])) . '</a>';
                                    }
                                 ?>
                                    </td>
                                    <td data-order="<?php echo e($task['startdate']); ?>">
                                        <?php echo e(_d($task['startdate'])); ?></td>
                                    <td data-order="<?php echo e($task['duedate']); ?>">
                                        <?php echo e(_d($task['duedate'])); ?>
                                    </td>
                                    <td><?php echo format_task_status($task['status']); ?></td>
                                    <td data-order="<?php echo e($task['total_files']); ?>">
                                        <span class="label label-default" data-toggle="tooltip"
                                            data-title="<?php echo _l('tasks_total_added_attachments'); ?>">
                                            <i class="fa fa-paperclip tw-mr-1"></i>
                                            <?php
                                                if (!is_numeric($staff_id)) {
                                                    echo e($task['total_files']);
                                                } else {
                                                    echo e($task['total_files_staff'] . '/' . $task['total_files']);
                                                }
                                            ?>
                                        </span>
                                    </td>
                                    <td data-order="<?php echo e($task['total_comments']); ?>">
                                        <span class="label label-default" data-toggle="tooltip"
                                            data-title="<?php echo _l('tasks_total_comments'); ?>">
                                            <i class="fa-regular fa-comments tw-mr-1"></i>
                                            <?php
                                                if (!is_numeric($staff_id)) {
                                                    echo e($task['total_comments']);
                                                } else {
                                                    echo e($task['total_comments_staff']) . '/' . e($task['total_comments']);
                                                }
                                            ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="label <?php if ($task['total_checklist_items'] == '0') {
                                  echo 'label-default';
                              } elseif (($task['total_finished_checklist_items'] != $task['total_checklist_items'])) {
                                  echo 'label-danger';
                              } elseif ($task['total_checklist_items'] == $task['total_finished_checklist_items']) {
                                  echo 'label-success';
                              } ?> pull-left mright5" data-toggle="tooltip"
                                            data-title="<?php echo _l('tasks_total_checklists_finished'); ?>">
                                            <?php echo e($task['total_finished_checklist_items']); ?>/<?php echo e($task['total_checklist_items']); ?>
                                        </span>
                                    </td>
                                    <td data-order="<?php echo e($task['total_logged_time']); ?>">
                                        <span class="label label-default pull-left mright5" data-toggle="tooltip"
                                            data-title="<?php echo _l('staff_stats_total_logged_time'); ?>">
                                            <i class="fa-regular fa-clock tw-mr-1"></i>
                                            <?php echo e(seconds_to_time_format($task['total_logged_time'])); ?>
                                        </span>
                                    </td>
                                    <?php
                              $finished_on_time_class = '';
                              $finishedOrder          = 0;
                              if ($task['datefinished'] && date('Y-m-d', strtotime($task['datefinished'])) > $task['duedate'] && $task['status'] == Tasks_model::STATUS_COMPLETE && is_date($task['duedate'])) {
                                  $finished_on_time_class = 'text-danger';
                                  $finished_showcase      = _l('task_not_finished_on_time_indicator');
                              } elseif ($task['datefinished'] && date('Y-m-d', strtotime($task['datefinished'])) <= $task['duedate'] && $task['status'] == Tasks_model::STATUS_COMPLETE && is_date($task['duedate'])) {
                                  $finishedOrder     = 1;
                                  $finished_showcase = _l('task_finished_on_time_indicator');
                              } else {
                                  $finished_on_time_class = '';
                                  $finished_showcase      = '';
                              }
                              ?>
                                    <td data-order="<?php echo e($finishedOrder); ?>">
                                        <span class="<?php echo e($finished_on_time_class); ?>">
                                            <?php echo e($finished_showcase); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                            echo format_members_by_ids_and_names($task['assignees_ids'], $task['assignees']);
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <hr />
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
</body>

</html>