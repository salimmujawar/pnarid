<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Booking extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->library(array('ion_auth','form_validation'));		
	}
	
	
	public function index()
	{
		$config = array(
				array(
						'field' => 'pay',
						'label' => 'Payment Type',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'days',
						'label' => 'Number of Days',
						'rules' => 'trim|required'
				)	
				,
				array(
						'field' => 'ride_id',
						'label' => 'Ride',
						'rules' => 'trim|required'
				)
		);
			
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array( 'result' => 'error', 'error_msg' => $this->form_validation->error_array()));
		}
		else
		{
			$this->load->model('booking_model');
			
			$ride_sess = $this->session->userdata('ride');
			$jsonData = array();
			$valid_ride = array();
			//$distance = DEFAULT_KM;
			$ride_id  = $this->input->post('ride_id');
			$vr_id    = $this->input->post('vr');
			$days     = $this->input->post('days');
			$pay      = $this->input->post('pay');
			$ride_sess = $ride_sess + array('pay' => $pay, 'vr_id' => $vr_id, 'ride_id' => $ride_id, 'days' => $days);
			$valid_ride = $this->booking_model->validate_booking($ride_sess);
			//print_r($valid_ride);	
			if($valid_ride['valid']) {
				$rideData = array( 'ride' => array(
						'type'  => $ride_sess['type'],
						'pickup'=> $ride_sess['pickup'],
						'drop' => $ride_sess['drop'],
						'date' => $ride_sess['date'],
						'time' => $ride_sess['time'],
						'days' => $days,
						'pay' => $pay,
						'ride_id' => $ride_id,
						'vr_id' => $vr_id,
						'step' => 2
				)
				);
				$this->session->set_userdata($rideData);
					
				$jsonData = array('type' => $ride_sess['type'], 'pickup' => $valid_ride['pickup'], 'drop' => $valid_ride['drop'],
						'date' => $ride_sess['date'], 'time' => $ride_sess['time'], 'ride_name' => $valid_ride['ride_name'],
						'tax' => $valid_ride['tax'], 'basic' => $valid_ride['basic'], 'total' => $valid_ride['total'],
						'advance' => $valid_ride['advance'], 'balance' => $valid_ride['balance'], 'days' => $days
				);
				echo json_encode(array( 'result' => 'success', 'json_data' => $jsonData));
			}else{
				echo json_encode(array( 'result' => 'error', 'error_resp' => 'Invalid request'));
			}		
			
		}
				
	}
	
	
	function paynow() {
		
		if ($this->ion_auth->logged_in())
		{
			$config = array(
					array(
							'field' => 'total',
							'label' => 'Total',
							'rules' => 'trim|required'
					),
					array(
							'field' => 'advance',
							'label' => 'Advance',
							'rules' => 'trim|required'
					)
					,
					array(
							'field' => 'basic',
							'label' => 'Basic',
							'rules' => 'trim|required'
					)
					,
					array(
							'field' => 'bal',
							'label' => 'Balance',
							'rules' => 'trim|required'
					)
			);
			
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array( 'result' => 'error', 'error_msg' => $this->form_validation->error_array()));
			}
			else
			{
				$total   = $this->input->post('total');
				$advance = $this->input->post('advance');
				$basic   = $this->input->post('basic');
				$bal     = $this->input->post('bal');
				$user    = $this->ion_auth->user()->row();
				
				$ride_sess = $this->session->userdata('ride');
				$ride_sess  = $ride_sess;
				$this->load->model('booking_model');				
				$valid_ride = $this->booking_model->validate_booking($ride_sess);
				
				if($valid_ride['valid']) { //&& $total == $valid_ride['total']) {
					$bookData = array();					
					$bookData = $ride_sess + $valid_ride + array('user_id' => $user->id);
					$result = FALSE;
					$this->db->trans_start();
					$bookingId = $this->booking_model->addBooking($bookData);
					if($bookingId) {
						$orderId = 'PAR-'.$bookingId .'-'. $ride_sess['vr_id'] .'-'. $ride_sess['pickup'] .'-' . $ride_sess['ride_id'];
						$this->booking_model->updateOrder($bookingId, array('order_id' => $orderId));
						$result = true;
						$rideData = array();						
						$rideData =  array( 'ride' => $ride_sess + array('order_id' => $orderId));
						$this->session->set_userdata($rideData);
					}
					if($result) {
						$this->db->trans_complete();
					}else{
						$this->db->trans_rollback();
					}
					
					if($bookingId) {	
						$this->load->model('sendemails_model');
						$email_data = array('username' => $user->first_name, 'order_id' => $bookingId, 'order_date' => '',
								'ride_name' => $valid_ride['ride_name'], 'ride_type' => $ride_sess['type'],
								'ride_from' => $valid_ride['pickup'], 'ride_to' => $valid_ride['drop'],
								'pickup_date' => $ride_sess['date'],'pickup_time' => $ride_sess['time'],
								'numbers_days' => $ride_sess['days'], 'numbers_ride' => 1,
								'basic_fare' => $valid_ride['basic'], 'advance_fare' => $valid_ride['advance'],
								'balance_fare' => $valid_ride['balance'],	'total_fare' => $valid_ride['total']
						);
						$this->sendemails_model->htmlmail($user->email, 'Your Order place with Pin A ride', 'order', $email_data);
						echo json_encode(array( 'result' => 'success'));
						die;
					}else{
						echo json_encode(array( 'result' => 'error', 'error_resp' => 'Try later'));
						die;
					}
				}else{
					echo json_encode(array( 'result' => 'error', 'error_resp' => 'Invalid request'));
					die;
				}
			
			}
		}else{
			echo json_encode(array( 'result' => 'error', 'error_resp' => 'Login required'));
			die;
		}
		
	}
	
	function thankyou() {
		$ride_sess = $this->session->userdata('ride');		
		$page  = 'thankyou';
		
		if (! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
		{
				// Whoops, we don't have a page for that!
				show_404();
		}
		if(empty($ride_sess['order_id'])) {
			redirect('/', 'refresh');
		}	
		$this->session->unset_userdata('ride');
		$this->load->model('booking_model');
		$bookData = $this->booking_model->getBookingDetails($ride_sess['order_id']);
		$data['book_data'] = $bookData;
		$user = $this->ion_auth->user()->row();		
		$data['user'] = $user;
		$data['js_files'] = array('thankyou');
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
			
		
	}
	
	function cancel_order() {
		$config = array(
						array(
								'field' => 'email',
								'label' => 'Email',
								'rules' => 'trim|required|valid_email'
						),
						array(
								'field' => 'orderid',
								'label' => 'Order ID',
								'rules' => 'trim|required'
						),
						array(
								'field' => 'reason',
								'label' => 'Reason',
								'rules' => 'trim|required'
						)					
				);
			
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array( 'result' => 'error', 'error_msg' => $this->form_validation->error_array()));
		}else{
			$orderId  = $this->input->post('orderid');
			$email    = $this->input->post('email');
			$reason   = $this->input->post('reason');
			$bookData = array();
			
			$this->load->model('booking_model');
			
			$bookData = $this->booking_model->getBookingDetails($orderId);
			//check if the users is same and the cancelation is not passed the booking date
			if(!empty($bookData->pickup_datetime)) {
				$pickupDate = strtotime($bookData->pickup_datetime);
				if($bookData->email != $email) {
					echo json_encode(array( 'result' => 'error', 'error_resp' => "Invalid email"));
					return false;
				}
				if($pickupDate < strtotime('now')){
					echo json_encode(array( 'result' => 'error', 'error_resp' => "Orders has been completed"));
					return false;
				}				
				//update booking table
				$this->booking_model->updateBooking($orderId, array('reason' => $reason, 'cancelled_date' => date('Y-m-d h:i:s', strtotime('now'))));
				echo json_encode(array( 'result' => 'success'));
			}else {
				echo json_encode(array( 'result' => 'error', 'error_resp' => "Invalid orderId"));
			}
			
		}
	}
	
	function cancellation () {
		
		$page  = 'cancellation';
		
		if (! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
	
		$data['js_files'] = array('cancellation');
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['seo_title']  = 'Car and Cab Rental Services in Mumbai | Mumbai to Pune';
		$data['seo_desc']  = 'If you have any genuine Reason for Cancelling your trip then Pin A ride give you that facility. Get Car and Cab Rental Services in Mumbai, Pune.';
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
	
	function history() {
		$page      = 'history';
		$user_type = '';		
		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('booking_model');
		$user = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($user->id)->row();
		$data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$bookList = array();		
		$data['group_id'] = $user_groups->id;
		switch($user_groups->id) {			
			case 2:
				$user_type = 'users';
				$bookList = $this->booking_model->getAllBooking("", array('user_id' => $user->id), "cdate", "desc", PER_PAGE, $data['page']);
				$config['total_rows'] = $this->booking_model->getBookingCount(array('user_id' => $user->id));
				break;
			case 3:
				$user_type = 'vendors';
				$bookList = $this->booking_model->getAllBooking("", array('vendor_id' => $user->id), "cdate", "desc", PER_PAGE, $data['page']);
				$config['total_rows'] = $this->booking_model->getBookingCount(array('user_id' => $user->id));
				break;
			default:
				show_404();
				break;
				
		}	
		if (! file_exists(APPPATH.'/views/'.$user_type.'/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		$this->load->library("pagination");
		//pagination settings
		$config['base_url'] = site_url('history');		
		$config['per_page'] = PER_PAGE;
		$config["uri_segment"] = 2;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = floor($choice);
		//print_r($config);
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['js_files'] = array('history');
		$data['total_rows'] = $config['total_rows'];
		$data['book_list'] = $bookList;
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$this->load->view('templates/header', $data);
		$this->load->view($user_type.'/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
}
