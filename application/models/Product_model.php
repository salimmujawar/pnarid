<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_model extends CI_Model {
	public function __construct()
	{
		//$this->load->database();
		parent::__construct();		
	}
	
	public function getAllProducts($select = "",  $where = "", $limit = 0, $offset = 0) {
		$data = array();		
		$select = (empty($select))?"*":$select;  
		$this->db->select($select);
		$this->db->from('products');
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
	
	
	public function getProduct($select = "",  $where = "", $orderBy = "", $order="", $limit = 0, $offset = 0) {
		$data = array();
		$select = (empty($select))?"*":$select;
		$this->db->select($select);
		$this->db->from('products');
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
}