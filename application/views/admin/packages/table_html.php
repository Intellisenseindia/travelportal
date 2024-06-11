<?php

defined('BASEPATH') or exit('No direct script access allowed');
	$table_data = [	 
	   "Package Name",
		"Action",
	];
	render_datatable($table_data, 'all-package');
