<?php defined('BASEPATH') or exit('No direct script access allowed');
$tags      = get_tags();
$totalTags = count($tags);
?>
<div class="row">
    <div class="col-md-<?php if ($totalTags > 0) {
    echo '12';
} else {
    echo '12 text-center';
}?>">
        <ul class="no-mbot">
            <?php
          foreach ($tags as $tag) { ?>
            <li class="settings-tag-wrapper tw-mb-3 last:tw-mb-0">
                <span class="settings-tag-name"></span>
                <div class="form-group no-mbot settings-tag-input">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <?php echo total_rows(db_prefix() . 'taggables', ['tag_id' => $tag['id']]); ?>
                        </div>
                        <input type="text" name="tags[<?php echo e($tag['id']); ?>]" value="<?php echo e($tag['name']); ?>"
                            class="form-control">
                        <div class="input-group-btn">
                            <a class="btn btn-danger _delete"
                                href="<?php echo admin_url('settings/delete_tag/' . $tag['id']); ?>">
                                <i class="fa fa-remove"></i></a>
                        </div>
                    </div>
                </div>
            </li>
            <?php }
      if ($totalTags == 0) { ?>
            <li class="list-group-item no-mbot"><?php echo _l('no_tags_used'); ?></li>
            <?php } ?>
        </ul>
    </div>
</div>