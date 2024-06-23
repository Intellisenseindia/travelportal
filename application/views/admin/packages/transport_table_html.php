<?php

defined('BASEPATH') or exit('No direct script access allowed');
	$table_data = [	 	   "Transport Name",
	   "Vehicles",	   "Phone",
	    "City",		   "Location",	     
	   "Action"
	];
	render_datatable($table_data, 'all-transport');
