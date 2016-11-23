<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search_model extends CI_Model {

    public function __construct() {
        //$this->load->database();
        parent::__construct();
    }

    function getDrivingDistance($lat1, $lat2, $long1, $long2) {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

        return array('distance' => $dist, 'time' => $time);
    }
    
    public function getRideDetails($route, $distance, $ride_id =0, $days = 1) {
        $rideData = array();  
        //echo $distance;
            if ($route == 'round' && $days = 1) {
                $distance = $distance * 2;
            }
            if ($distance > 80 && $distance < 250 ) {
                $distance = 250;
                $rideData = $this->getOutstationRides($distance, $ride_id);
            }elseif ($distance > 250) {
                //$distance = $distance;   
                $rideData = $this->getOutstationRides($distance, $ride_id);
            } 
            $rideData = $rideData + array('total_distance' => $distance);
            return $rideData;
    }
    
    private function getOutstationRides ($totalDistance, $ride_id = 0) {
        $rideData = array();
            $this->load->model('product_model');
                if (empty($ride_id)) {
                    $products = $this->product_model->getAllProducts("", array('journey' => 'out'));
                    //print_r($products);
                    foreach($products['rows'] as $key => $val) {
                       $rideData[$val->name] = array('car_model' => $val->description, 
                                                   'category'  => $val->category . ', ' . $val->seats . ' Seater AC, Rs. ' . $val->per_km . ' per km',
                                                   'base_fare' => round($totalDistance * $val->per_km),
                                                   'advance'   => round(($totalDistance * $val->per_km) * COMMISSION),
                                                   'url'       => $val->url,
                                                   'distance'  => $totalDistance,
                                                   'ride_id'   => $val->p_id,
                                                   'journey'   => 'out'
                                                ); 
                    }
                }else{
                    $products = $this->product_model->getProduct("", array('p_id' => $ride_id));
                    $product= $products['rows'];
                    
                    
                    $rideData = array('car_model' => $product->description, 
                                                'category'  => $product->category . ', ' . $product->seats . ' Seater AC, Rs. ' . $product->per_km . ' per km',
                                                'base_fare' => round($totalDistance * $product->per_km),
                                                'advance'   => round(($totalDistance * $product->per_km) * COMMISSION),
                                                'url'       => $product->url,
                                                'distance'  => $totalDistance,
                                                'ride_id'   => $product->p_id,
                                                'journey'   => 'out'
                                             ); 
                    
                }
                
                 
                
                return $rideData;
            
    }
    
    function addSearchLog() {
        if (LOG_SEARCH == 1) {
          $campainge = (!empty($_GET['cmp']))?$_GET['cmp']:'organic';
            $forw_for =  (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))?$_SERVER['HTTP_X_FORWARDED_FOR']:'';
            $data = array('post' => json_encode($_POST), 'frw_client_ip' => $forw_for, 
                'remote_ip' => $_SERVER['REMOTE_ADDR'], 'campainge' => $campainge);
            $this->db->set($data);
            $this->db->insert('search_log');  
        }
               
    }

    function getRides($params = array()) {
        $jsonData = array();
        //$this->load->model('vendor_ride_model');
        $this->load->model('product_model');
        $this->load->model('distance_model');

        $distance = LOCAL_DEFAULT_KM;
        if ($params['type'] == 'outstation') {
            $this->load->model('city_model');
            $pickupLatLong = $this->city_model->getCity('', array('city_id' => $params['pickup']));
            $dropLatLong = $this->city_model->getCity('', array('city_id' => $params['drop']));
            if (isset($pickupLatLong['rows']) && isset($dropLatLong['rows'])) {
                $pickupLatLong = $pickupLatLong['rows'];
                $dropLatLong = $dropLatLong['rows'];
                //print_r($pickupLatLong);				
                //$distance 	   = round(distance($pickupLatLong->city_lat, $pickupLatLong->city_long, $dropLatLong->city_lat, $dropLatLong->city_long, "K"), 2);
                //Google API to cache distance
                //$distance = $this->distance_model->getDrivingDistance($pickupLatLong, $dropLatLong);
                //as its always a round trip so multiply by 2
                //$distance = $distance * 2;
                $distance = OUTSTATION_DEFAULT_KM;
            }
        }
        //$rides = $this->vendor_ride_model->getAllVendorRides(array('pickup' => $params['pickup']));
        $rides = $this->product_model->getAllProducts("", array('journey' => $params['type']));
        //print_r($rides);
        if (!empty($rides['num_rows'])) {
            //set  the session

            if ($params['step'] == 1) {
                $rideData = array('ride' => array(
                        'type' => $params['type'],
                        'trip' => $params['trip'],
                        'pickup' => $params['pickup'],
                        'drop' => $params['drop'],
                        'date' => $params['date'],
                        'time' => $params['time'],
                        'step' => 1
                    )
                );
                $this->session->set_userdata($rideData);
            }


            $percent = ADVANCE_PAY_PERC;
            foreach ($rides['rows'] as $key => $val) {
                if ($params['type'] == 'local') {
                    $full_pay = $val->amount;
                } else {
                    $full_pay = round($distance * $val->per_km);
                }
                $adv_pay = round(($full_pay / 100) * $percent);
                /* $jsonData[] = array('ride_name' => $val->ride_name, 'ride_id' => $val->ride_id, 'vr_id' => $val->vr_id
                  , 'per_km' => $val->per_km, 'seats' => $val->seats, 'full' => $full_pay, 'advance' => $adv_pay);
                 */
                $jsonData[] = array('ride_name' => $val->name, 'ride_id' => $val->p_id, 'vr_id' => $val->p_id, 'desc' => $val->description
                    , 'seats' => $val->seats, 'full' => $full_pay, 'advance' => $adv_pay, 'distance' => $distance,
                    'url' => $val->url, 'per_km' => $val->per_km);
            }
            //sort an multideminsional array
            $cmp = function($a, $b) {
                return $a['full'] - $b['full'];
            };
            usort($jsonData, $cmp);
        }

        return $jsonData;
    }

}
