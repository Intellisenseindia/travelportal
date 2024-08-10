<?php

defined('BASEPATH') or exit('No direct script access allowed');
	$table_data = [	
	   "Trip Code",	   "Trip Name",	   "Start Date",	   "End Date",	   "Duration",	   "Package Price",
	   "Status",
		"Action",
	];
	render_datatable($table_data, 'all-trip');
