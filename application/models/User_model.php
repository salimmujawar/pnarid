<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
	public function __construct()
	{
		//$this->load->database();
		parent::__construct();		
	}
	
	function add_enquiry($params) {
		$enquiry = 0;
		if(sizeof($params) > 0) {
			$this->db->set($params);
			$enquiry = $this->db->insert('enquiries');			
		}
		return $enquiry;
	}
	
	function add_feedback($params) {
		$feedback = 0;
		if(sizeof($params) > 0) {
			$this->db->set($params);
			$feedback = $this->db->insert('feedbacks');
		}
		return $feedback;
	}
}