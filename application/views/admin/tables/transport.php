<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns         = ['transport_name', 'phone', 'vehicles', 'loc.location_name', 'loc.city'];
$sIndexColumn     = 'id';
$sTable           = db_prefix() . 'transport';

$additionalSelect = [db_prefix() . 'transport.id'];

$join             = [];
	array_push($join, 'LEFT JOIN ' . db_prefix() . 'location as loc ON ' . db_prefix() . 'transport.locationid = loc.id');
$where    = [];


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);

	foreach($result['rResult'] as $key=>$value){		
		$vehicle = get_vehicles($value['vehicles']);
		$result['rResult'][$key]['vehicles'] = $vehicle;
	}
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
	
	$row[] = $aRow['transport_name'];
	$row[] = $aRow['vehicles'];
	$row[] = $aRow['phone'];
	$row[] = $aRow['city'];
	$row[] = $aRow['location_name'];
	
	
	$link = '<a href="' . admin_url('packages/addtransport/' . $aRow['id']) . '">Edit</a> | <a href="' . admin_url('packages/deletetransport/' . $aRow['id']) . '">Delete</a>';
	$row[] = $link;
		
    $output['aaData'][] = $row;

}