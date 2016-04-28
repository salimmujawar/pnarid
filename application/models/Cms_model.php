<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms_model extends CI_Model {
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
	public function add($params = array()) {
		$Id = 0;
		if (sizeof($params) > 0) {
			$cms_id = (!empty($params['cms_id']))?$params['cms_id']:0;
			
			if ($cms_id > 0) {
				$Id = $cms_id;
				$fields = array(
						'slug' => $params['slug'], 'title' => $params['title'], 
						'content' => $params['content'], 'page_title' => $params['seo_title'],
						'page_description' => $params['seo_desc'], 'page_keywords' => $params['seo_keywords']
				);
				
				$this->db->where('cms_id', $Id);
				$this->db->update('cms', $fields);
			}else{
				$fields = array('slug' => $params['slug'], 'title' => $params['title'], 
							'content' => $params['content'], 'page_title' => $params['seo_title'],
							'page_description' => $params['seo_desc'], 'page_keywords' => $params['seo_keywords'],
							'create_date' => date('Y-m-d H:i:s'));
				$this->db->set($fields);
				$this->db->insert('cms');
				$Id = $this->db->insert_id();
			}
			
				
		}
		return $Id;
	}
	
	/**
	 *
	 */
	
	public function getCms($select = "",  $where = "", $orderBy = "", $order="", $limit = 0, $offset = 0) {
		$data = array();
		$select = (empty($select))?"*":$select;
		$this->db->select($select);
		$this->db->from('cms');
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
	
			//$data['num_rows'] = sizeof($data['rows']);
			$query->free_result();
		}
		return $data;
	}
	
	/**
	 * 
	 */
	
	public function getAllCms($select = "",  $where = "", $orderBy = "cms_id", $order="desc", $limit = 0, $offset = 0, $filters = array()) {
		$data = array();
		$select = (empty($select))?"*":$select;
		$this->db->select($select);
		$this->db->from('cms');
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
				$data['rows'][] = $row;
			}
	
			$data['num_rows'] = sizeof($data['rows']);
			$query->free_result();
		}
		return $data;
	}
	
	
}