<?php

defined('BASEPATH') or exit('No direct script access allowed');

class trips_model extends App_Model

{

    public function __construct()
    {
        parent::__construct();
    }
	
	public function getTrip($id){
		$this->db->where('id', $id);
		return $this->db->get(db_prefix() . 'tripdetails')->row();
	}
	
	public function addTrip($data){
		$data['dateadded'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();
		
		$data['package_name'] = get_package($data['package_id'])->package_name;
		$date1 = DateTime::createFromFormat('d-m-Y', $data['startdate']);
		$data['startdate'] = $date1->format('Y-m-d');
		
		$date2 = DateTime::createFromFormat('d-m-Y', $data['enddate']);
		$data['enddate'] = $date2->format('Y-m-d');
		 
		//die(print_r($data));
        $this->db->insert(db_prefix() . 'tripdetails', $data);

        $insert_id = $this->db->insert_id();
		
		$data['tripcode'] = 'TR' . str_pad($insert_id, 10, 0, STR_PAD_LEFT);
		$this->db->where('id', $insert_id);
        $this->db->update(db_prefix() . 'tripdetails', $data);

        if ($insert_id) {           
            return $insert_id;
        }

        return false;
	}
	
	public function updateTrip($data, $id){
		$data['package_name'] = get_package($data['package_id'])->package_name;
		$date1 = DateTime::createFromFormat('d-m-Y', $data['startdate']);
		$data['startdate'] = $date1->format('Y-m-d');
		
		$date2 = DateTime::createFromFormat('d-m-Y', $data['enddate']);
		$data['enddate'] = $date2->format('Y-m-d');
		$this->db->where('id', $id);
        $this->db->update(db_prefix() . 'tripdetails', $data);

        if ($insert_id) {           
            return true;
        }

        return false;
	}
	
	public function deletetrip($id){
		$this->db->where('id', $id);
        $this->db->delete(db_prefix().'tripdetails');
        if ($this->db->affected_rows() > 0) {
            log_activity('Contract Deleted [' . $id . ']');
            return true;
        }
        return false;
	}
	
	/*
	public function checkcustomer_exist($tripid, $customerid){
     $this->db->wehre('id',tripid);
     $this->db->wehre('tripcustomer',$customerid);
     $query =  $this->db->get(db_prefix() . 'tripdetails')->row();
     if($query->num_rows() > 0){
      return true;
      }else{
		  return false;
	  }
    }*/
	
	public function updateTripCustomer($data, $id){
		$data['tripcustomer'] = $data['customerid'];
		$this->db->where('id', $id);
        $this->db->update(db_prefix() . 'tripdetails', $data);

        if ($id) {           
            return true;
        }

        return false;
	}
}