<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Distance_model extends CI_Model {
	
	public function __construct()
	{		
		parent::__construct();		
	}
	/**
	 * Get the driving distance
	 * 
	 * @param unknown $pickupLatLong
	 * @param unknown $dropLatLong
	 * @return number|unknown
	 */
	function getDrivingDistance($pickupLatLong, $dropLatLong) {
		$distance = 0;
		
		$cachedDistance = $this->getCacheDistance($pickupLatLong->city_name, $dropLatLong->city_name);
		if(!empty($cachedDistance->kilometers)) {
			return $cachedDistance->kilometers;
		}
		$inLatitude = $pickupLatLong->city_lat;
		$inLongitude = $pickupLatLong->city_long;
		$outLatitude = $dropLatLong->city_lat;
		$outLongitude = $dropLatLong->city_long;
		if(empty($inLatitude) || empty($inLongitude) ||empty($outLatitude) ||empty($outLongitude))
			return $distance;
		
		// Generate URL
		$url = "http://maps.googleapis.com/maps/api/directions/json?origin=$inLatitude,$inLongitude&destination=$outLatitude,$outLongitude&sensor=false";
		
		// Retrieve the URL contents
		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $url);
		$jsonResponse = curl_exec($c);
		curl_close($c);
		
		$dataset = json_decode($jsonResponse);
		if(!$dataset)
			return $distance;
		if(!isset($dataset->routes[0]->legs[0]->distance->value))
			return $distance;
		//replace char and keep number
		$distanceArr = explode(" ", $dataset->routes[0]->legs[0]->distance->text);
		if(!empty($distanceArr[0])){
			$distance = $distanceArr[0];
		}
		
		//cache the distance
		$this->addDistance($distance, $pickupLatLong->city_name, $dropLatLong->city_name);
		return $distance;
	}
	
	/**
	 * get Cached distance in DB to avoid multiple calls to API
	 * 
	 * @param unknown $fromCity
	 * @param unknown $toCity
	 */
	function getCacheDistance($fromCity, $toCity){
		
		$data = array();
		if(!empty($fromCity) && !empty($toCity)) {
			$this->db->select('*');
			$this->db->from('driving_distance');			
			$this->db->where('origin', $fromCity);
			$this->db->where('destination', $toCity);
				
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
	
	/**
	 * Cache distance in DB
	 * 
	 * @param unknown $distance
	 * @param unknown $fromCity
	 * @param unknown $toCity
	 * @return number
	 */
	public function addDistance($distance, $fromCity, $toCity) {
		
		$cacheId = 0;
		if (!empty($distance) && !empty($fromCity) && !empty($toCity)) {
			
			$fields = array(
						'kilometers' => $distance, 'origin' => $fromCity,'destination' => $toCity
						);
			//print_r($fields);die;
			$this->db->set($fields);
			$this->db->insert('driving_distance');
			$cacheId = $this->db->insert_id();
	
		}
		return $cacheId;
	}
}