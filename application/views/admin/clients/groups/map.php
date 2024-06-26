<?php defined('BASEPATH') or exit('No direct script access allowed');
if (isset($client)) { ?>
<?php if (staff_can('edit',  'customers')) { ?>
<div class="row" data-address="<?php echo htmlentities($client->address); ?>" data-city="<?php echo htmlentities($client->city); ?>" data-country="<?php echo htmlentities(get_country_name($client->country)); ?>" id="long_lat_wrapper">
    <div class="col-md-4">
      <div class="form-group">
          <label for="website"><?php echo _l('customer_latitude'); ?></label>
          <div class="input-group">
           <input type="text" name="latitude" id="latitude" value="<?php echo e($client->latitude); ?>" class="form-control">
           <div class="input-group-addon">
            <span><a href="#" tabindex="-1" class="pull-left mright5" onclick="fetch_lat_long_from_google_cprofile(); return false;" data-toggle="tooltip" data-title="<?php echo _l('fetch_from_google') . ' - ' . _l('customer_fetch_lat_lng_usage'); ?>"><i id="gmaps-search-icon" class="fa-brands fa-google" aria-hidden="true"></i></a></span>
        </div>
    </div>
</div>
</div>
<div class="col-md-4">
    <?php echo render_input('longitude', 'customer_longitude', $client->longitude); ?>
</div>
<div class="col-md-4">
    <button class="btn btn-primary label-margin" onclick="save_longitude_and_latitude(<?php echo e($client->userid); ?>); return false;"><?php echo _l('submit'); ?></button>
    <?php if (!empty($client->latitude) && !empty($client->longitude)) { ?>
        <a class="btn btn-default label-margin" target="_blank" href="<?php echo 'https://www.google.com/maps/search/?api=1&query=' . urlencode($client->latitude . ', ' . $client->longitude); ?>"><?php echo _l('open_google_map'); ?></a>
    <?php } ?>
</div>
</div>
<hr />
<?php } ?>
<?php
if (get_option('google_api_key') !== '') {
    if ($client->longitude == '' && $client->latitude == '') {
        echo _l('customer_map_notice');
    } else {
        echo '<div id="map" class="customer_map"></div>';
    }
} else {
    echo _l('setup_google_api_key_customer_map');
}
}
