<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search_model extends CI_Model {
	public function __construct()
	{
		//$this->load->database();
		parent::__construct();		
	}
	
	function getRides($params = array()) {
		$jsonData = array();
		$this->load->model('vendor_ride_model');
		$this->load->model('distance_model');
			
		$distance = LOCAL_DEFAULT_KM;
		if ($params['type'] == 'outstation') {
			$this->load->model('city_model');
			$pickupLatLong = $this->city_model->getCity('', array('city_id' => $params['pickup']));
			$dropLatLong   = $this->city_model->getCity('', array('city_id' => $params['drop']));
			if(isset($pickupLatLong['rows']) && isset($dropLatLong['rows'])) {
				$pickupLatLong = $pickupLatLong['rows'];
				$dropLatLong   = $dropLatLong['rows'];
				//print_r($pickupLatLong);				
				//$distance 	   = round(distance($pickupLatLong->city_lat, $pickupLatLong->city_long, $dropLatLong->city_lat, $dropLatLong->city_long, "K"), 2);
				//Google API to cache distance
				$distance = $this->distance_model->getDrivingDistance($pickupLatLong, $dropLatLong);
				//as its always a round trip so multiply by 2
				$distance = $distance * 2;
				//$distance = OUTSTATION_DEFAULT_KM;
			}
		}
		$rides = $this->vendor_ride_model->getAllVendorRides(array('pickup' => $params['pickup']));
		if(!empty($rides['num_rows'])) {
			//set  the session
		
			if($params['step'] == 1) {
				$rideData = array( 'ride' => array(
								'type'  => $params['type'],
								'pickup'=> $params['pickup'],
								'drop' => $params['drop'],
								'date' => $params['date'],
								'time' => $params['time'],
								'step' => 1
						)
						);
				$this->session->set_userdata($rideData);
			}
		
		
			$percent  = ADVANCE_PAY_PERC;
			foreach ($rides['rows'] as $key => $val) {
                                if ($params['type'] == 'local') {
                                    $full_pay = $val->local_rent;
                                }else {
                                    $full_pay = round($distance * $val->per_km);
                                }
				$adv_pay  = round(($full_pay / 100) * $percent);
				/*$jsonData[] = array('ride_name' => $val->ride_name, 'ride_id' => $val->ride_id, 'vr_id' => $val->vr_id
						, 'per_km' => $val->per_km, 'seats' => $val->seats, 'full' => $full_pay, 'advance' => $adv_pay);
				*/
				$jsonData[] = array('ride_name' => $val->ride_name, 'ride_id' => $val->ride_id, 'vr_id' => $val->vr_id
						, 'seats' => $val->seats, 'full' => $full_pay, 'advance' => $adv_pay, 'distance' => $distance,
							'url' => $val->url, 'per_km' => $val->per_km);
			}
			//sort an multideminsional array
			$cmp = function($a,$b) {return $a['full'] - $b['full'];};
			usort($jsonData, $cmp);
		}
		
		return $jsonData;
	}
}