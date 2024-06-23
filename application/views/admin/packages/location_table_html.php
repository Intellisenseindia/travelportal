<?php

defined('BASEPATH') or exit('No direct script access allowed');
	$table_data = [	 	   "Location Code",	   "Country",	   "State",	   "City",
	   "Location Name",
	   "Action"
	];
	render_datatable($table_data, 'all-location');
