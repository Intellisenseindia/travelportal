<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	/**
	 * Get all countries stored in database
	 * @return array
	 */
	function get_all_locations()
	{	
		
		$locations = get_instance()->db->get(db_prefix().'location')->result_array();
		$data = [];
		foreach($locations as $location){
			$data[] = array('location_id'=> $location['id'], 'location_name'=> $location['locationcode'] . ',' . $location['state'] . '->' .$location['city'] . '->' . $location['location_name']);
		}
		return $data;
	}
	/**
	 * Get country row from database based on passed country id
	 * @param  mixed $id
	 * @return object
	 */
	function get_location($id)
	{
		$CI = & get_instance();   
		$CI->db->where('id ', $id);
		$location = $CI->db->get(db_prefix().'location')->row();

		return $location;
	}

	function get_vehicles($ids)
	{
		$CI = & get_instance();  
		
		$sql = "SELECT GROUP_CONCAT(vehicletype SEPARATOR ', ') vaicle FROM " . db_prefix() . "vehicletype WHERE id in (" . $ids . ")" ;	
		$query = $CI->db->query($sql);
		
		$vaicle = $query->result_array();	
		
		return $vaicle[0]['vaicle'];
	}
	
	function get_all_vehicles()
	{		
		$vaicles = get_instance()->db->get(db_prefix().'vehicletype')->result_array();
		$data = [];
		
		foreach($vaicles as $vaicle){
			$data[] = array('vaicle_id'=> $vaicle['id'], 'vaicle_name'=> $vaicle['vehicletype']);
		}
		
		return $data;
	}
	
	function getCurrency(){
		$CI = & get_instance();
		$CI->load->model('currencies_model');
		return $CI->currencies_model->get_base_currency();
	}
	
	function get_all_packages(){
		$CI = & get_instance(); 
		return $CI->db->order_by('package_name	', 'asc')->get(db_prefix().'packages')->result_array();
	}
	
	function get_package($id)
	{
		$CI = & get_instance();

		$package = $CI->app_object_cache->get('db-package-' . $id);

		if (!$package) {
			$CI->db->where('id', $id);
			$package = $CI->db->get(db_prefix().'packages')->row();
			$CI->app_object_cache->add('db-package-' . $id, $package);
		}

		return $package;
	}
