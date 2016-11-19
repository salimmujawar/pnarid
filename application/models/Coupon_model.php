<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Coupon_model extends CI_Model {
	
	public function __construct()
	{
		//$this->load->database();
		parent::__construct();		
	}
	
	function applyCoupon($code) {
		$coupon = $this->getCoupon('', array('coupon' => $code,
				'use_limit >=' => 'used',
				'CURDATE() between start_date and end_date',
		)
		);
		
		return $coupon;
	}
	
	function getCoupon($select = "",  $where = "", $orderBy = "", $order="", $limit = 0, $offset = 0) {
		$data = array();
		$select = (empty($select))?"*":$select;
		$this->db->select($select);
		$this->db->from('coupons');
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
				$data = $row;
			}			
			$query->free_result();
		}
		return $data;
	}
	
	function updateUsage($code) {
		if(!empty($code)) {
			$this->db->set('used', 'used+1', FALSE);			
			$this->db->where('coupon', $code);
			$this->db->update('coupons');
		}
		
	}
	
}