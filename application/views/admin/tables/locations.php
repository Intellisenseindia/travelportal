<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns         = ['locationcode', 'country', 'state', 'city', 'location_name'];
$sIndexColumn     = 'id';
$sTable           = db_prefix() . 'location';

$additionalSelect = ['id'];

$join             = [];
$where    = [];


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0 ; $i < count($aColumns) ; $i++) {
        $_data = $aRow[ $aColumns[$i] ];

     /*  if ($aColumns[$i] == 'package_name') {
            $_data =  e($_data);
        }  */

        $row[] = $_data;
		
		
    }
	
	$link = '<a href="' . admin_url('packages/addlocation/' . $aRow['id']) . '">Edit</a> | <a href="' . admin_url('packages/deletelocation/' . $aRow['id']) . '">Delete</a>';
	$row[] = $link;
		
    $output['aaData'][] = $row;

}