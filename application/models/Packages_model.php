<?php



defined('BASEPATH') or exit('No direct script access allowed');

class packages_model extends App_Model

{

    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @param   array $_POST data
     * @return  integer Insert ID
     * Add new contract
     */

    public function add($data)
    {		
        $data['dateadded'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();

        $this->db->insert(db_prefix() . 'packages', $data);

        $insert_id = $this->db->insert_id();

        if ($insert_id) {           
            return $insert_id;
        }

        return false;

    }
	
	/**
     * @param  integer ID
     * @return mixed
     * Delete contract type from database, if used return array with key referenced
     */

    public function delete($id)
    {

        $this->db->where('id', $id);

        $this->db->delete(db_prefix().'packages');

        if ($this->db->affected_rows() > 0) {

            log_activity('Contract Deleted [' . $id . ']');
            return true;

        }
        return false;
    }
	
	public function get($id = '')
    {
		if (is_numeric($id)) {		

			$this->db->where('id', $id);
			return $this->db->get(db_prefix() . 'packages')->row();
		}
		return array();
	}
	
	public function update($data, $id)
    {
        $affectedRows = 0;
        $contract = $this->db->where('id', $id)->get(db_prefix() . 'packages')->row();
		
		$this->db->where('id', $id);
        $this->db->update(db_prefix() . 'packages', $data);	
		return true;
	}
	
	
	public function getlocation($id = ''){
		if (is_numeric($id)) {	
			$this->db->where('id', $id);
			return $this->db->get(db_prefix() . 'location')->row();
		}
		return array();
	}
	
	public function addlocation($data){
		$data['dateadded'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();
		$data['country_id'] = $data['country'];
		$data['country'] = get_country($data['country_id'])->short_name;
		//die(print_r($data));
        $this->db->insert(db_prefix() . 'location', $data);

        $insert_id = $this->db->insert_id();
		
		$data['locationcode'] = 'L' . str_pad($insert_id, 8, 0, STR_PAD_LEFT);
		$this->db->where('id', $insert_id);
        $this->db->update(db_prefix() . 'location', $data);

        if ($insert_id) {           
            return $insert_id;
        }

        return false;
	}
	
	public function updatelocation($data, $id){
		
		$data['country_id'] = $data['country'];
		$data['country'] = get_country($data['country_id'])->short_name;				
		
		$this->db->where('id', $id);
        $this->db->update(db_prefix() . 'location', $data);

        if ($insert_id) {           
            return true;
        }

        return false;
	}
	
	public function deletelocation($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix().'location');
        if ($this->db->affected_rows() > 0) {
            log_activity('Contract Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
	
	public function gettransport($id = ''){
		if (is_numeric($id)) {	
			$this->db->where('id', $id);
			return $this->db->get(db_prefix() . 'transport')->row();
		}
		return array();
	}		
	
	public function addtransport($data){
		$data['dateadded'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();	
	
		$data['location'] = get_location($data['locationid'])->location_name;
		$data['vehicles'] = implode(',', $data['vehicles']);
		//die(print_r($data));
        $this->db->insert(db_prefix() . 'transport', $data);
        $insert_id = $this->db->insert_id();		
		
        if ($insert_id) {           
            return $insert_id;
        }

        return false;
	}	
	
	public function updatetransport($data, $id){
		$data['location'] = get_location($data['locationid'])->location_name;			
		$data['vehicles'] = implode(',', $data['vehicles']);
		
		$this->db->where('id', $id);
        $this->db->update(db_prefix() . 'transport', $data);

        if ($insert_id) {           
            return true;
        }

        return false;
	}
	
	public function deletetransport($id){
		$this->db->where('id', $id);
        $this->db->delete(db_prefix().'transport');
        if ($this->db->affected_rows() > 0) {
            log_activity('Contract Deleted [' . $id . ']');
            return true;
        }
        return false;
	}
	
	
	
	public function gethotel($id = ''){
		if (is_numeric($id)) {	
			$this->db->where('id', $id);
			return $this->db->get(db_prefix() . 'hotel')->row();
		}
		return array();
	}
	
	public function addhotel($data){
		$data['dateadded'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();	
	
		$data['location'] = get_location($data['locationid'])->location_name;
		//die(print_r($data));
        $this->db->insert(db_prefix() . 'hotel', $data);
        $insert_id = $this->db->insert_id();		
		$data['hotelid'] = 'H' . str_pad($insert_id, 9, 0, STR_PAD_LEFT);
		$this->db->where('id', $insert_id);
        $this->db->update(db_prefix() . 'hotel', $data);

        if ($insert_id) {           
            return $insert_id;
        }

        return false;
	}
	
	public function updatehotel($data, $id){
		$data['location'] = get_location($data['locationid'])->location_name;			
		
		$this->db->where('id', $id);
        $this->db->update(db_prefix() . 'hotel', $data);

        if ($insert_id) {           
            return true;
        }

        return false;
	}
	
	public function deletehotel($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix().'hotel');
        if ($this->db->affected_rows() > 0) {
            log_activity('Contract Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
	
	public function addpickup($data){
		$this->db->where('id', $data['packageid']);
		$this->db->select('pickup');
		$pickup = $this->db->get(db_prefix() . 'packages')->row();		
		$all_pickup = explode(',', $pickup->pickup);		
		$all_pickup[] = $data['pickupname'];
		
		$pickup = implode(',', $all_pickup);
		$rowupdate['pickup'] = $pickup;
		
		$this->db->where('id', $data['packageid']);
        $this->db->update(db_prefix() . 'packages', $rowupdate);
	}
	
	public function adddrop($data){
		$this->db->where('id', $data['packageid']);
		$this->db->select('droplo');
		$result = $this->db->get(db_prefix() . 'packages')->row();		
		$all_pickup = explode(',', $result->droplo);		
		$all_pickup[] = $data['dropname'];
		
		$result = implode(',', $all_pickup);
		$rowupdate['droplo'] = $result;
		
		$this->db->where('id', $data['packageid']);
        $this->db->update(db_prefix() . 'packages', $rowupdate);
	}
	
	public function addsight($data){
		$this->db->where('id', $data['packageid']);
		$this->db->select('sightseeing');
		$result = $this->db->get(db_prefix() . 'packages')->row();		
		$all_pickup = explode(',', $result->sightseeing);		
		$all_pickup[] = $data['sightname'];
		
		$result = implode(',', $all_pickup);
		$rowupdate['sightseeing'] = $result;
		
		$this->db->where('id', $data['packageid']);
        $this->db->update(db_prefix() . 'packages', $rowupdate);
	}
	
}
