<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-text-neutral-700 section-text section-heading-announcements">
    <?php echo _l('announcements'); ?>
</h4>
<div class="panel_s">
    <div class="panel-body">
        <?php if (count($announcements) > 0) { ?>
        <table class="table dt-table table-announcements" data-order-col="1" data-order-type="desc">
            <thead>
                <tr>
                    <th class="th-announcement-name"><?php echo _l('announcement_name'); ?></th>
                    <th class="th-announcement-date"><?php echo _l('announcement_date_list'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($announcements as $announcement) { ?>
                <tr>
                    <td>
                        <a
                            href="<?php echo site_url('clients/announcement/' . $announcement['announcementid']); ?>">
                            <?php echo e($announcement['name']); ?>
                        </a>
                    </td>
                    <td data-order="<?php echo e($announcement['dateadded']); ?>">
                        <?php echo e(_dt($announcement['dateadded'])); ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            <p class="no-margin"><?php echo _l('no_announcements'); ?></p>
        <?php } ?>
    </div>
</div>