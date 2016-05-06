<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Booking_model extends CI_Model {
	public function __construct()
	{
		//$this->load->database();
		parent::__construct();		
	}
	
	
	public function validate_booking($params = array()) {
		$data     = array();
		$data['valid']    = FALSE;
		//$distance = DEFAULT_KM;
		
		if (!empty($params['type'])) {
			$this->load->model('city_model');
			$this->load->model('ride_model');
			$this->load->model('vendor_ride_model');
			$this->load->model('distance_model');
				
			if(empty($params['pickup']) || empty($params['drop']) || empty($params['ride_id'])) {
				return $data;
			}
			$pickupLatLong = $this->city_model->getCity('', array('city_id' => $params['pickup']));
			$dropLatLong   = $this->city_model->getCity('', array('city_id' => $params['drop']));
			$ride_details = $this->ride_model->getRide('', array('ride_id' =>$params['ride_id']));
			
			$pickupLatLong = $pickupLatLong['rows'];
			$dropLatLong   = $dropLatLong['rows'];
			$ride_details = $ride_details['rows'];
			
			if(empty($params['vr_id'])) {
				return $data;
			}
			$vendor_ride  = $this->vendor_ride_model->getVendorRide('', array('vr_id' => $params['vr_id']));
			$vendor_ride  = $vendor_ride['rows'];
                        
			if(!empty($pickupLatLong->city_lat) && !empty($dropLatLong->city_lat) && $params['type'] != 'local') {				
				//print_r($pickupLatLong);
				//$distance 	   = round(distance($pickupLatLong->city_lat, $pickupLatLong->city_long, $dropLatLong->city_lat, $dropLatLong->city_long, "K"), 2);
				//Google API to cache distance
				$distance = $this->distance_model->getDrivingDistance($pickupLatLong, $dropLatLong);
				//as its always a round trip so multiply by 2
				$distance = $distance * 2;
				//For outstation, per day 300km on an average
				//$distance = OUTSTATION_DEFAULT_KM;
				
			}elseif($params['type'] == 'local'){
				$distance = LOCAL_DEFAULT_KM;
			}else{
				return $data;
			}
				
			if(!empty($vendor_ride->per_km)) {
				// Ohhhhh Calculation!!!
				$percent  = ADVANCE_PAY_PERC;
				$adv_pay  = '';
				$balance  = 0;
				$total    = 0;
				$code     = 0;
				$days     = $params['days'];
				
				
                                if ($params['type'] == 'local') {
                                    $full_pay = $vendor_ride->local_rent;
                                }else {
                                    $full_pay = round(($distance * $vendor_ride->per_km) * $days, 2);
                                }
                                
				if($params['pay'] == 'advance') {
					$adv_pay  = round(($full_pay / 100) * $percent, 2);
					$balance  = round($full_pay - $adv_pay, 2);
				}else{
					$adv_pay  = $full_pay;
				}
                                
				if($balance > 0 && APPLY_SERVICE_TAX) {
					$balance = round($balance + SERVICE_TAX);
				}
				//print_r($params);
				if(!empty($params['code'])) {
					$this->load->model('coupon_model');
						
					$coupon = $this->coupon_model->applyCoupon($params['code']);
					//print_r($coupon);
					if(empty($coupon->amount)) {
						return $data;
					}
					$code = $coupon->amount;
				}
				if(APPLY_SERVICE_TAX) {
					$total = round(($full_pay - $code) + SERVICE_TAX, 2);
				}else{
					$total = round(($full_pay - $code), 2);
				}
				//Ohhhhh Calculation!!!
			}else{
				return $data;
			}
			$data['distance'] = $distance;
			$data['ride_name'] = $ride_details->ride_name;
			$data['pickup']   = $pickupLatLong->city_name;
			$data['drop']     = $dropLatLong->city_name;
			$data['total']	  = $total;
			$data['tax']	  = 0;
			if(APPLY_SERVICE_TAX) {
				$data['tax']	  = SERVICE_TAX;
			}
			$data['basic']	  = $full_pay;
			$data['advance']  = $adv_pay;
			$data['balance']  = $balance;
			$data['valid']    = TRUE;
		}
	
		return $data;
	}
	
	function getBookingCount($where = array()) {
		$count = 0;
		
		$this->db->select('count(*) as count');
		$this->db->from('booking b');
		$this->db->join('master_city f', 'f.city_id = b.ride_from');
		$this->db->join('master_city t', 't.city_id = b.ride_to');
		$this->db->join('users u', 'u.id = b.user_id');
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
	
	function getAllBooking($select = "",  $where = "all", $orderBy = "cdate", $order="desc", $limit = 0, $offset = 0) {
		$data = array();
		
		$this->db->select('b.*, f.city_name as from_city, t.city_name as to_city, u.first_name as cust_name, u.email, u.phone cust_phone');
		if($where == 'all') {
			$this->db->select(', v.first_name as vend_name, v.phone as vend_phone');
		}
		$this->db->from('booking b');
		$this->db->join('master_city f', 'f.city_id = b.ride_from', 'left');
		$this->db->join('master_city t', 't.city_id = b.ride_to', 'left');
		$this->db->join('users u', 'u.id = b.user_id', 'left');
		
		if($where == "all") {
			$this->db->join('users v', 'v.id = b.vendor_id');
		}
		
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
	
	function getBookingDetails($orderId, $bookId = 0 ) {
		$data = array();
		if(!empty($orderId) || !empty($bookId)) {
			$this->db->select('b.*, f.city_name as from_city, t.city_name as to_city, u.email, u.phone, u.first_name');
			$this->db->from('booking b');
			$this->db->join('master_city f', 'f.city_id = b.ride_from');
			$this->db->join('master_city t', 't.city_id = b.ride_to');
			$this->db->join('users u', 'u.id = b.user_id');
			if(!empty($orderId)) {
                            $this->db->where('b.order_id', $orderId);			
                        }elseif(!empty($bookId)) {
                            $this->db->where('b.b_id', $bookId);			
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
		}
		return $data;
	}
	
	public function addBooking($params) {
		$bookId = 0;
		if (sizeof($params) > 0) {			
			$code = '';
			if(!empty($params['code'])){
				$code = $params['code'];
			}
			
			$time = explode(' ', $params['time']);
			$time = explode(':', $time['0']);
			//print_r($time);					
			$fields = array('vendor_id' => $params['vr_id'], 'user_id' => $params['user_id'], 
							 'coupon' => $code,'rent_type' => $params['type'], 
							 'pay_type' => $params['pay'],'ride_id' => $params['ride_id'],
							 'ride_from' => $params['pickup'],'ride_to' => $params['drop'],
							 'paid' => $params['advance'],'due' => $params['balance'], 'total' => $params['total'], 
							 'payment_status' => 'Pending','sms_notified' => 0, 'basic' => $params['basic'],
							 'email_notified' => 0,'status' => 1, 'rides' => 1, 'days' => $params['days'],
							 'pickup_datetime' => date('Y-m-d', strtotime($params['date'])) .' '. $time[0].':'.$time[1].':00',
							 'cdate' => date('Y-m-d H:i:s'), 'distance' => $params['distance'],
							 'ride_name' => $params['ride_name'], 'tax' => $params['tax']
						);
			//print_r($fields);die;
			$this->db->set($fields);
			$this->db->insert('booking');
			$bookId = $this->db->insert_id();
				
		}
		return $bookId;
	}
	
	
	function updateOrder($bookId, $order) {		
		if(!empty($bookId)) {			
			$this->db->where('b_id', $bookId);
			$this->db->update('booking', $order);
			return TRUE;
		}
		return FALSE;
	}
	
	function updateBooking($orderId, $param) {
		if(!empty($orderId)) {
			$this->db->where('order_id', $orderId);
			$this->db->update('booking', $param);
			return TRUE;
		}
		return FALSE;
	}
}