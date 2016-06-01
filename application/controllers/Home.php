<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->library(array('ion_auth','form_validation'));		
	}

	public function index()
	{	
		$page  = 'home';
		$cms = '';
		$current_url =  uri_string();
		$category_page = FALSE;
		$ride_sess = array();		
		$url_arr = explode('/', $current_url);
		
		if (!empty($url_arr[0]) && !empty($url_arr[1])) {			
			if ($url_arr[0] == 'car-on-rent') {
				$current_url = $url_arr[1];
				$category_page = TRUE;
			}elseif($url_arr[1] == 'car-search') {
				$ride_sess = $this->session->userdata('ride');
			}			
			
		}elseif(!empty($url_arr[0]) && $url_arr[0] == 'checkout') {
			$ride_sess = $this->session->userdata('ride');			
		}else{
			$this->session->unset_userdata('ride');
		}		
		
		//print_r($ride_sess);		
			
		if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
		{
				// Whoops, we don't have a page for that!
				show_404();
		}	
		/*$start = date("h:i",strtotime('now') + RIDE_INTERVAL);
		$end = RIDE_END_TIME;
		
		$tStart = strtotime($start);
		$tEnd = strtotime($end);
		$tNow = $tStart;*/
		
		$this->load->model('city_model');
		$this->load->model('cms_model');
		$pickup_cities = $this->city_model->getAllCity("", array('city_status' => 1, 'pickup' => 1));
		$drop_cities = $this->city_model->getAllCity("", array('city_status' => 1, 'droploc' => 1), 'city_name', 'asc');
		if (!empty($current_url)) {
			$cms = $this->cms_model->getCms("", array('slug' => $current_url));
			//var_dump($cms);
		}
		
		$rideData = array();
		$valid_ride = array();
                
		if(!empty($ride_sess['step'])) {						
			$this->load->model('search_model');
			$params = array('type'  => $ride_sess['type'],
                                        'trip'=> $ride_sess['trip'],
                                        'pickup'=> $ride_sess['pickup'],
                                        'drop' => $ride_sess['drop'],
                                        'date' => $ride_sess['date'],
                                        'time' => $ride_sess['time'],
                                        'step' => $ride_sess['step']
                                    );
			$rideData = $this->search_model->getRides($params);
			//print_r($rideData);
			if(!empty($ride_sess['vr_id'])) {
				$this->load->model('booking_model');
				$valid_ride = $this->booking_model->validate_booking($ride_sess);
				//print_r($valid_ride);
			}
		}
		
		if(!empty($ride_sess['step']) && !empty($ride_sess['code'])
			&& $ride_sess['step'] >= 2) {
				$this->load->model('coupon_model');
				$coupon = $this->coupon_model->applyCoupon($ride_sess['code']);
		}
		
		//print_r($rideData);
		$h1Tag = 'Car Rental';
		
		switch($current_url) {
			case 'car-rental-navi-mumbai':
				$h1Tag = 'Car Rental in Navi Mumbai';
				break;
			case 'car-rental-mumbai':
				$h1Tag = 'Car Rental in Mumbai';
				break;
			case 'mumbai-darshan':
				$h1Tag = 'Car Rental for Mumbai Darshan';
				break;				
			case 'mumbai-darshan':
				$h1Tag = 'Car Rental for Mumbai Darshan';
			break;
			default:
				break;
		}
		if ($category_page) {			
			$toFromArr = explode('to', $current_url);			
			$ride_sess['type'] = 'local';
			if (!empty($toFromArr[0]) && !empty($toFromArr[1])) {
				$ride_sess['type'] = 'outstation';				
				$ride_sess['pickup'] = ucwords(trim($toFromArr[0], '-'));
				$ride_sess['drop'] = ucwords(trim($toFromArr[1], '-'));
			}
			if ($current_url == 'mumbai-darshan') {
				$ride_sess['pickup'] = 'Mumbai';
			}
		} 	
		if(!empty($cms->page_title) && !empty($cms->page_description)) {
			$data['seo_title']  = $cms->page_title;
			$data['seo_desc']  = $cms->page_description;
		}else{
			$data['seo_title']  = 'Car Rental Services| Cab Services | Mumbai to Shirdi Taxi | Mumbai Pune Taxi Fare';
			$data['seo_desc']  = 'Are You looking for Car and Cab Rental Services in Mumbai? Pin A Ride is one the best taxi services provider in Mumbai, Shirdi, Pune and more.';
		}
		$data['h1_tag'] = $h1Tag;  
		$data['ride_data'] = $rideData;
		$data['ride_sess'] = $ride_sess;
		$data['valid_ride'] = $valid_ride;
		$data['category_page'] = $category_page;
		$data['cms'] = $cms;
		$data['current_date'] = date('m/d/Y', strtotime('+1 days'));
		$hour = date('h', strtotime('+2 hours'));
		$minute = (date('i')>30)?'30':'00';
		$meridiem = date('A');
		$data['valid_time'] = "$hour:$minute $meridiem"; 
		$data['current_time'] = date('h:i A', strtotime('+2 hours'));
		$data['time'] = getTime();
		/*$data['tNow'] = $tNow;
		$data['tEnd'] = $tEnd;*/
		$data['pickup_cities'] = $pickup_cities['rows'];
		$data['drop_cities'] = $drop_cities['rows'];
		$data['title'] = ucfirst($page); // Capitalize the first letter		
		$data['js_files'] = array('home', 'bootstrap-select.min');
		$data['css_files'] = array('bootstrap-select.min');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);			
	}
}
