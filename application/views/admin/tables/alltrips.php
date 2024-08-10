<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns         = ['tripcode', 'package_name', 'trip_name', 'startdate', 'enddate', 'package_price'];
$sIndexColumn     = 'id';
$sTable           = db_prefix() . 'tripdetails';

$additionalSelect = ['id'];

$join             = [];
	
$where    = [];


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);

$output  = $result['output'];
$rResult = $result['rResult'];
//die(print_r($result));
	$currency = getCurrency();
foreach ($rResult as $aRow) {
    $row = [];
	
	$row[] = '<a href="' . admin_url('trips/viewtrip/' . $aRow['id']) . '">' . $aRow['tripcode'] . '</a>';
	$row[] = '<a href="' . admin_url('trips/viewtrip/' . $aRow['id']) . '">' . $aRow['package_name'] . ' ' . $aRow['trip_name'] . '</a>';
	$row[] = e(_d($aRow['startdate']));
	$row[] = e(_d($aRow['enddate']));
	
	$dateFrom = new DateTime($aRow['startdate']);
	$dateTo = new DateTime($aRow['enddate']);
	
	$row[] = $dateFrom->diff($dateTo)->days . ' days';
	$row[] = e(app_format_money($aRow['package_price'],$currency));
	
	$today = new DateTime();
	$status = "";
	if(date_diff($today,$dateFrom)->format('%R') == "+"){
		$status = "Not Started";
	}
	if(date_diff($today,$dateFrom)->format('%R') == "-" && date_diff($today,$dateTo)->format('%R') == "+"){
		$status = "Runing";
	}
	if(date_diff($today,$dateTo)->format('%R') == "-"){
		$status = "Complited";
	}
	
	$row[] = $status;
	
	$link = '<a href="' . admin_url('trips/addtrip/' . $aRow['id']) . '">Edit</a> | <a href="' . admin_url('trips/deletetrip/' . $aRow['id']) . '">Delete</a>';
	$row[] = $link;
		
    $output['aaData'][] = $row;
	
}