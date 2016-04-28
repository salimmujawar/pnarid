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
}