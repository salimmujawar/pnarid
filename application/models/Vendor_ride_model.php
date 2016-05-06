<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vendor_ride_model extends CI_Model {
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
	public function addVendorRides($params = array()) {				
		if (sizeof($params) > 0) {
			//this check is not needed as we r doing bulk insert			
			//if(!empty($params['ride_id']) && !empty($params['city_id']) 
			  // && !empty($params['vendor_id']) && !empty($params['number'])) {
			   	if($this->db->insert_batch('vendor_rides', $params)){
			   		$this->db->affected_rows();
			   		//echo $this->db->last_query();
			   		return TRUE;
			   	}
			   
			//}						
		}
		return FALSE;
	}
	
	public function getAllVendorRides($params = array()) {
		$data = array();
		if(!empty($params['pickup'])) {
			$this->db->select('r.ride_name, r.ride_id, r.seats, r.url, vr.per_km, vr.vr_id, vr.local_rent');
			$this->db->from('rides r');
			$this->db->join('vendor_rides vr', 'r.ride_id = vr.ride_id');			
			$this->db->where('vr.city_id', $params['pickup']);
			$this->db->where('r.status', 1);
			$this->db->where('vr.status', 1);
                        $this->db->group_by('vr.ride_id'); 
			$query = $this->db->get();
			//echo $this->db->last_query();
			if($query->result()){
				foreach ($query->result() as $row)
				{
					$data['rows'][] = $row;
				}
			
				$data['num_rows'] = sizeof($data['rows']);
				$query->free_result();
			}
		}

		return $data;
	}
	
        
        function getVendorDetails($vendorId ) {
		$data = array();
		if(!empty($vendorId)) {
			$this->db->select('v.vendor_id, u.email, u.phone');
			$this->db->from('vendors v');			
			$this->db->join('users u', 'u.id = v.vendor_id');
			$this->db->where('v.vendor_id', $vendorId);			
                        
                        
					
			$query = $this->db->get();
			//echo $this->db->last_query();
			if($query->result()){
				foreach ($query->result() as $row)
				{
					$data = $row;
				}				
				$query->free_result();
			}
		}
		return $data;
	}
	
	public function getVendorRide($select = "",  $where = "", $orderBy = "", $order="", $limit = 0, $offset = 0) {
		$data = array();
		$select = (empty($select))?"*":$select;
		$this->db->select($select);
		$this->db->from('vendor_rides');
		if(is_array($where) && sizeof($where) > 0) {
			foreach($where as $key => $val) {
				$this->db->where($key, $val);
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
				$data['rows'] = $row;
			}
	
			$data['num_rows'] = sizeof($data['rows']);
			$query->free_result();
		}
		return $data;
	}
        
        
        /**
	 * 
	 */
	
	public function getAllVendorRidesList($select = "",  $where = "", $orderBy = "ride_id", $order="desc", $limit = 0, $offset = 0, $filters = array()) {
		$data = array();
		//$select = (empty($select))?"*":$select;
		//$this->db->select($select);
		$this->db->select('`r`.`ride_name`, `r`.`ride_id`, `r`.`seats`, `r`.`url`, `vr`.`per_km`, `vr`.`vr_id`, `u`.`first_name`, `u`.`last_name`, `u`.`phone`,  `vr`.`actual_per_km`, `b`.`b_id`, `b`.`order_id`, `c`.`city_name`, `vr`.`vendor_id`');
                $this->db->from('rides r');
                $this->db->join('vendor_rides vr', 'r.ride_id = vr.ride_id');			                                
                $this->db->join('users u', 'u.id = vr.vendor_id');
                $this->db->join('master_city c', 'c.city_id = vr.city_id');
                $this->db->join('booking b', 'b.vendor_id = u.id', 'left');
                
		if(is_array($filters) && sizeof($filters) > 0) {
			foreach($filters as $key => $val) {
				$this->db->where($key, $val);
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
				$data['rows'][] = $row;
			}
	
			$data['num_rows'] = sizeof($data['rows']);
			$query->free_result();
		}
		return $data;
	}
	
	
}