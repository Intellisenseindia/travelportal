<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $_announcements = get_announcements_for_user();
if (sizeof($_announcements) > 0 && isset($dashboard) && is_staff_member()) { ?>
<div class="col-lg-12">
    <div class="panel_s">
        <?php foreach ($_announcements as $__announcement) { ?>
        <div class="panel-body announcement mbot15 tc-content">
            <div class="text-info alert-dismissible" role="alert">
                <h4 class="no-margin pull-left">
                    <?php echo _l('announcement'); ?>! <?php if ($__announcement['showname'] == 1) {
    echo '<br /><small class="font-medium-xs">' . e(_l('announcement_from') . ' ' . $__announcement['userid']);
} ?></small><br />
                    <small><?php echo e(_l('announcement_date', _dt($__announcement['dateadded']))); ?></small>
                </h4>
                <a href="<?php echo admin_url('misc/dismiss_announcement/' . $__announcement['announcementid']); ?>"
                    class="close">
                    <span aria-hidden="true">&times;</span>
                </a>
                <?php if (is_admin()) { ?>
                <a href="<?php echo admin_url('announcements/announcement/' . $__announcement['announcementid']); ?>">
                    <i class="fa-regular fa-pen-to-square pull-right"></i>
                </a>
                <?php } ?>
                <div class="clearfix"></div>
            </div>
            <hr class="hr-panel-separator" />
            <h4 class="tw-mb-0 tw-mt-5 tw-font-semibold"><?php echo e($__announcement['name']); ?></h4>
            <div class="[&>p:last-child]:tw-mb-0">
                <?php echo check_for_links($__announcement['message']); ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php hooks()->do_action('before_start_render_content'); ?>
