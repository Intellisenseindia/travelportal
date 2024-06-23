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
	
	public function location()
    {
        close_setup_menu();
        $data['title']    = 'All Location'; 		
        $this->load->view('admin/packages/location', $data);
    }
	
	public function locationtable()
    {       		
		$this->app->get_table_data('locations');
    }
	
	public function addlocation($id = '')
    {
		if ($this->input->post()){			
			 if ($id == '') {
				 $data = $this->input->post();				 
				 $id = $this->packages_model->addlocation($data);
				 
				 if ($id) {
                    set_alert('success', _l('added_successfully', 'Location'));
                    redirect(admin_url('packages/location'));   
                }
			 }
			 else{
				 $success = $this->packages_model->updatelocation($this->input->post(), $id);
                if ($success == true) {
                    set_alert('success', _l('updated_successfully', 'Location'));
                }
                redirect(admin_url('packages/location'));
			 }
		}
		
		if ($id == '') {
            $title = "Create Location";
			$data['package_name'] = "";
        } else {
			 $title = "Update Location";
            $locationData = $this->packages_model->getlocation($id);
			//die(print_r($package));
			$data['locationcode'] = $locationData->locationcode;
			$data['country_id'] = $locationData->country_id;
			$data['state'] = $locationData->state;
			$data['city'] = $locationData->city;
			$data['location_name'] = $locationData->location_name;
		}
		$data['bodyclass'] = 'location dynamic-create-groups';

        $data['title']     = $title;

        $this->load->view('admin/packages/addlocation', $data);
	}
	
	public function deletelocation($id)
    {       

        if (!$id) {
            redirect(admin_url('packages/location'));
        }

        $response = $this->packages_model->deletelocation($id);

        if ($response == true) {

            set_alert('success', _l('deleted', 'Location'));

        } else {

            set_alert('warning', _l('problem_deleting', 'Location'));

        }

        redirect(admin_url('packages/location'));

    }
	
	
	
	public function transport()
    {
        close_setup_menu();
        $data['title']    = 'All Transport'; 		
        $this->load->view('admin/packages/transport', $data);
    }
	
	public function transporttable()
    {       		
		$this->app->get_table_data('transport');
    }
	
	public function addtransport($id = ''){
		if ($this->input->post()){			
			 if ($id == '') {
				 $data = $this->input->post();				 
				 $id = $this->packages_model->addtransport($data);
				 
				 if ($id) {
                    set_alert('success', _l('added_successfully', 'Transport'));
                    redirect(admin_url('packages/transport'));   
                }
			 }
			 else{
				 $success = $this->packages_model->updatetransport($this->input->post(), $id);
                if ($success == true) {
                    set_alert('success', _l('updated_successfully', 'Transport'));
                }
                redirect(admin_url('packages/transport'));
			 }
		}
		
		if ($id == '') {
            $title = "Create Transport";
			$data['selectedvaicle'] = array();
			
        } else {
			 
            $transportData = $this->packages_model->gettransport($id);
			$title = "Update Transport";
			//die(print_r($transportData));
			$data['transport_name'] = $transportData->transport_name;
			$data['type_selected'] = $transportData->transport_type;
			$data['locationid'] = $transportData->locationid;
			$data['phone'] = $transportData->phone;
			$data['email'] = $transportData->email;
			$data['address'] = $transportData->address;			
			$data['selectedvaicle'] = explode(',', $transportData->vehicles);
		}
		$data['bodyclass'] = 'transport dynamic-create-groups';

        $data['title']     = $title;
		//die(print_r($data));
        $this->load->view('admin/packages/addtransport', $data);
	}
	
	public function deletetransport($id){
		if (!$id) {
            redirect(admin_url('packages/transport'));
        }
        $response = $this->packages_model->deletetransport($id);
		
        if ($response == true) {
            set_alert('success', _l('deleted', 'Transport'));
        } else {
            set_alert('warning', _l('problem_deleting', 'Transport'));
        }
        redirect(admin_url('packages/transport'));
	}
	
	
	public function hotel()
    {
        close_setup_menu();
        $data['title']    = 'All Hotels'; 		
        $this->load->view('admin/packages/hotel', $data);
    }
	
	public function hoteltable()
    {       		
		$this->app->get_table_data('hotel');
    }
	
	public function addhotel($id = ''){
		
		if ($this->input->post()){			
			 if ($id == '') {
				 $data = $this->input->post();				 
				 $id = $this->packages_model->addhotel($data);
				 
				 if ($id) {
                    set_alert('success', _l('added_successfully', 'Hotel'));
                    redirect(admin_url('packages/hotel'));   
                }
			 }
			 else{
				 $success = $this->packages_model->updatehotel($this->input->post(), $id);
                if ($success == true) {
                    set_alert('success', _l('updated_successfully', 'Hotel'));
                }
                redirect(admin_url('packages/hotel'));
			 }
		}
		
		if ($id == '') {
            $title = "Create Hotel";			
        } else {
			 
            $hotelData = $this->packages_model->gethotel($id);
			$title = "Update Hotel(" . $hotelData->hotelid . ")";
			//die(print_r($hotelData));
			$data['locationid'] = $hotelData->locationid;
			$data['phone'] = $hotelData->phone;
			$data['email'] = $hotelData->email;
			$data['address'] = $hotelData->address;
			$data['hotelname'] = $hotelData->hotelname;
			$data['map'] = $hotelData->map;
		}
		$data['bodyclass'] = 'hotel dynamic-create-groups';

        $data['title']     = $title;

        $this->load->view('admin/packages/addhotel', $data);
	}
	
	public function deletehotel($id)
    {
        if (!$id) {
            redirect(admin_url('packages/hotel'));
        }
        $response = $this->packages_model->deletehotel($id);
		
        if ($response == true) {
            set_alert('success', _l('deleted', 'Hotel'));
        } else {
            set_alert('warning', _l('problem_deleting', 'Hotel'));
        }
        redirect(admin_url('packages/hotel'));
    }
	
}