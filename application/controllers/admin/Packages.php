<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Packages extends AdminController
{
	 public function __construct()
    {
        parent::__construct();

      //  $this->load->model('package_model');
    }
	
	 public function index()
    {

        close_setup_menu();      

        $data['title']    = 'Packages';

        //$data['table'] = $this->app->get_table_data('packages');
		
        $this->load->view('admin/packages/manage', $data);

    }
	
	 public function table()
    {
       		
		$this->app->get_table_data('packages');

    }
	
	
}