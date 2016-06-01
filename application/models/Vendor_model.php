<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vendor_model extends CI_Model {
	public function __construct()
	{
		//$this->load->database();
		parent::__construct();		
	}
	
	/**
	 * 
	 * @param unknown $params
	 * @return number
	 */
	public function addVendor($params = array()) {
		$vendorId = 0;
		if (sizeof($params) > 0) {
			$fields = array('vendor_id' => $params['vendor_id'], 'address' => $params['address'], 'city_id' => $params['city_id'], 'cdate' => date('Y-m-d H:i:s'));
			$this->db->set($params);
			$this->db->insert('vendors');		
			$vendorId = $this->db->insert_id();
			
		}
		return $vendorId;
	}
        
        public function getAllVendors($select = "",  $where = "", $like = "", $orderBy = "created_on", $order="desc", $limit = 0, $offset = 0) {
		$data = array();
		
		$this->db->select('*');		
		$this->db->from('users u');
		$this->db->join('users_groups ug', 'u.id = ug.user_id');
                $this->db->join('vendors v', 'u.id = v.vendor_id');
                $this->db->join('master_city c', 'v.city_id = c.city_id');
				
		if(is_array($where) && sizeof($where) > 0) {
			foreach($where as $key => $val) {
                                if(!empty($val)) {
                                    $this->db->where($key, $val);
                                }
			}
		}
                if(is_array($like) && sizeof($like) > 0) {
			foreach($like as $key => $val) {
                            if(!empty($val)) {
				 $this->db->like($key, $val);
                            }
			}
		}
		if(!empty($limit)){
			$this->db->limit($limit);
		}
		if(!empty($limit) && empty($offset )){
			$this->db->limit($limit);
		}
		
		if(!empty($limit) && !empty($offset)){
			$this->db->limit($limit, $offset);
		}
		if(!empty($orderBy) && !empty($order)) {
			$this->db->order_by($orderBy, $order);
		}					
			
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->result()){
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			$query->free_result();
		}
		
		return $data;
        }
        
        
        
        function getVendorCount($where = array(), $like = array()) {
		$count = 0;
		
		$this->db->select('count(*) as count');		
		$this->db->from('users u');
		$this->db->join('users_groups ug', 'u.id = ug.user_id');
                $this->db->join('vendors v', 'u.id = v.vendor_id');
                $this->db->join('master_city c', 'v.city_id = c.city_id');
                
		if(is_array($where) && sizeof($where) > 0) {
			foreach($where as $key => $val) {
                            if(!empty($val)) {
				$this->db->where($key, $val);
                            }
			}
		}
                
                if(is_array($like) && sizeof($like) > 0) {
			foreach($like as $key => $val) {
                            if(!empty($val)) {
				 $this->db->like($key, $val);
                            }
			}
		}
               
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->result()){
			foreach ($query->result() as $row)
			{
				$count = $row->count;
			}
			$query->free_result();
		}
		//echo $this->db->last_query();
		return $count;
	}
}