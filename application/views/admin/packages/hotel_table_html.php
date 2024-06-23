<?php

defined('BASEPATH') or exit('No direct script access allowed');
	$table_data = [	 	   "Hotel Code",
	   "Hotel Name",	   "Phone",
	    "City",		   "Location",	     
	   "Action"
	];
	render_datatable($table_data, 'all-hotel');
