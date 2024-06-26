<?php defined('BASEPATH') or exit('No direct script access allowed');
$len = count($templates);
$i   = 0;
?>
<div id="templates-wrapper" class="ptop15" data-total="<?php echo e($len); ?>">

    <?php foreach ($templates as $template) { ?>
    <div class="media templates-wrapper <?php if ($i == 0) {
    echo 'mtop15';
} ?>">
        <div class="media-body">
            <?php if ($template['addedfrom'] == get_staff_user_id() || is_admin()) { ?>
            <button class="btn pull-right btn-danger"
                onclick="delete_template(this,'<?php echo e($rel_type) ?>',<?php echo e($template['id']); ?>, <?php echo e($rel_id) ?>);return false;"><i
                    class="fa fa fa-times"></i></button>
            <button class="btn pull-right btn-primary mright5 "
                onclick="edit_template('<?php echo e($rel_type) ?>',<?php echo e($template['id']); ?>, <?php echo e($rel_id) ?>);return false;"><i
                    class="fa-regular fa-pen-to-square"></i></button>
            <?php } ?>
            <button class="btn pull-right btn-default mright5"
                onclick="insert_template(this,'<?php echo e($rel_type) ?>',<?php echo e($template['id']); ?>);return false;"><?php echo _l('insert_template') ?></button>
            <div data-template-content="<?php echo e($template['id']); ?>" class="bold">
                <?php echo check_for_links($template['name']); ?>
            </div>
        </div>
        <?php if ($i >= 0 && $i != $len - 1) {
    echo '<hr />';
}
    ?>
    </div>
    <?php
$i++;
} ?>
</div>