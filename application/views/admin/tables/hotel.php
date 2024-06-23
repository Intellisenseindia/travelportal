<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns         = ['hotelid', 'hotelname', 'phone', 'loc.location_name', 'loc.city'];
$sIndexColumn     = 'id';
$sTable           = db_prefix() . 'hotel';

$additionalSelect = [db_prefix() . 'hotel.id'];

$join             = [];
	array_push($join, 'LEFT JOIN ' . db_prefix() . 'location as loc ON ' . db_prefix() . 'hotel.locationid = loc.id');
$where    = [];


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);

$output  = $result['output'];
$rResult = $result['rResult'];
//die(print_r($result));
foreach ($rResult as $aRow) {
    $row = [];
	
	$row[] = $aRow['hotelid'];
	$row[] = $aRow['hotelname'];
	$row[] = $aRow['phone'];
	$row[] = $aRow['city'];
	$row[] = $aRow['location_name'];
	
	
	$link = '<a href="' . admin_url('packages/addhotel/' . $aRow['id']) . '">Edit</a> | <a href="' . admin_url('packages/deletehotel/' . $aRow['id']) . '">Delete</a>';
	$row[] = $link;
		
    $output['aaData'][] = $row;

}