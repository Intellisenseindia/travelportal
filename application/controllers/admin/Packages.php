<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Packages extends AdminController
{
	 public function __construct()
    {
        parent::__construct();
 
        $this->load->model('packages_model');
    }
	
	public function index()
    {
        close_setup_menu();
        $data['title']    = 'Packages'; 		
        $this->load->view('admin/packages/manage', $data);
    }
	
	public function table()
    {
       		
		$this->app->get_table_data('packages');

    }
	
	/* Edit package or add new package*/

    public function package($id = '')
    {
		if ($this->input->post()){			
			 if ($id == '') {
				 $data = $this->input->post();				 
				 $id = $this->packages_model->add($data);
				 
				 if ($id) {
                    set_alert('success', _l('added_successfully', 'Package'));                 

                    redirect(admin_url('packages/'));                  

                }
			 }
			 else{
				 $success = $this->packages_model->update($this->input->post(), $id);
                if ($success == true) {
                    set_alert('success', _l('updated_successfully', 'package'));
                }
                redirect(admin_url('packages/'));
			 }
		}
		
		if ($id == '') {
            $title = "Create package";
			$data['package_name'] = "";
        } else {
			 $title = "Update package";
            $package = $this->packages_model->get($id);
			//die(print_r($package));
			$data['package_name'] = $package->package_name;
		}
		$data['bodyclass'] = 'package dynamic-create-groups';

        $data['title']     = $title;



        $this->load->view('admin/packages/package', $data);
	}
	
	/* Delete client */

    public function delete($id)
    {       

        if (!$id) {
            redirect(admin_url('packages'));
        }

        $response = $this->packages_model->delete($id);

        if ($response == true) {

            set_alert('success', _l('deleted', 'Package'));

        } else {

            set_alert('warning', _l('problem_deleting', 'Package'));

        }

        redirect(admin_url('packages'));

    }
	
	public function hotel()
    {
        close_setup_menu();
        $data['title']    = 'All Hotels'; 		
        $this->load->view('admin/packages/hotel', $data);
    }
	
}