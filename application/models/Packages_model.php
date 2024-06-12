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
		
	}
	
	
	
}
