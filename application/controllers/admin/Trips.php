<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Trips extends AdminController
{
	 public function __construct()
    {
        parent::__construct();
 
        $this->load->model('trips_model');
    }
	
	public function index()
    {			
        close_setup_menu();
        $data['title']    = 'All Trips'; 		
        $this->load->view('admin/trips/manage', $data);
    }
	
	public function table()
    {  			
		$this->app->get_table_data('alltrips');
    }
	
	public function addtrip($id = '')
    {
		if ($this->input->post()){			
			 if ($id == '') {
				 $data = $this->input->post();				 
				 $id = $this->trips_model->addTrip($data);
				 
				 if ($id) {
                    set_alert('success', _l('added_successfully', 'Trip'));
                    redirect(admin_url('trips/'));   
                }
			 }
			 else{
				 $success = $this->trips_model->updateTrip($this->input->post(), $id);
                if ($success == true) {
                    set_alert('success', _l('updated_successfully', 'Trip'));
                }
                redirect(admin_url('trips/'));
			 }
		}
		
		if ($id == '') {
            $title = "Create Trip";			
        } else {
			$title = "Update Trip";
            $TripData = $this->trips_model->getTrip($id);
			//die(print_r($package));
			$data['package_id'] = $TripData->package_id;
			$data['trip_name'] = $TripData->trip_name;
			$data['startdate'] = $TripData->startdate;
			$data['enddate'] = $TripData->enddate;
			$data['package_price'] = $TripData->package_price;
			
		}
		$data['bodyclass'] = 'trip dynamic-create-groups';

        $data['title']     = $title;

        $this->load->view('admin/trips/addtrip', $data);
	}	
	
	public function viewtrip($id){
		close_setup_menu();
        $data['title']    = 'View Trips'; 	
		$data['trip'] = $this->trips_model->getTrip($id);
		
		$this->load->model('clients_model');
		$data['customers'] = $this->clients_model->get_customer();
		
		$data['trip_id'] = $id;
		$data['tabs']['overview'] = 'Overview';
		$data['tabs']['customers'] = 'Customers';
		$data['tabs']['trainticket'] = 'Train Ticket';
		$data['tabs']['flightticket'] = 'Flight Ticket';
		$data['tabs']['hotel'] = 'Hotel';
		$data['tabs']['transport'] = 'Transport';
		$data['tabs']['sidesceen'] = 'Side sceen';
		
        $this->load->view('admin/trips/viewtrip', $data);
		
	}
	
	public function deletetrip($id)
    {
        if (!$id) {
            redirect(admin_url('trips/'));
        }
        $response = $this->trips_model->deletetrip($id);
		
        if ($response == true) {
            set_alert('success', _l('deleted', 'Trip'));
        } else {
            set_alert('warning', _l('problem_deleting', 'Trip'));
        }
        redirect(admin_url('trips/'));
    }
	
	public function customerAdd($tripid,$customerid){
		$TripData = $this->trips_model->getTrip($tripid);
		$data['tripcustomer'] = $TripData->tripcustomer;
		$success = $this->trips_model->updateTripCustomer($customerid, $tripid);
		if ($success == true) {
			redirect(admin_url('trips/viewtrip/$tripid'));
       }
		
	}
}
	
	