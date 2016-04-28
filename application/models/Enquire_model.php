<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Enquire_model extends CI_Model {
	public function __construct()
	{
			parent::__construct();		
	}
	
	
	function getEnquireCount($where = array()) {
		$count = 0;
		
		$this->db->select('count(*) as count');
		$this->db->from('enquiries');		
		if(is_array($where) && sizeof($where) > 0) {
			foreach($where as $key => $val) {
				$this->db->where($key, $val);
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
	
	function getAllEnquire($select = "",  $where = "all", $orderBy = "udate", $order="desc", $limit = 0, $offset = 0) {
		$data = array();
		
		$this->db->select('*');		
		$this->db->from('enquiries');		
		
				
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
				$data[] = $row;
			}
			$query->free_result();
		}
		
		return $data;
	}
	
	
}