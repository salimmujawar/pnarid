<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));		
	}
	
	
	/**
	 * User signup
	 */
	public function signup()
	{	
		$tables = $this->config->item('tables','ion_auth');
		$identity_column = $this->config->item('identity','ion_auth');
		$this->data['identity_column'] = $identity_column;		
		$config = array(
				array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'trim|required|min_length[5]'
				),
				array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]'
				),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']',
				),
				array(
						'field' => 'mobile',
						'label' => 'Mobile',
						'rules' => 'trim|required|numeric|min_length[10]|max_length[12]'
				),				
				array(
						'field' => 'address',
						'label' => 'Address',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'city',
						'label' => 'City',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'ride[]',
						'label' => 'Ride',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'number[]',
						'label' => 'Number',
						'rules' => 'trim|required'
				)
					
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array( 'result' => 'error', 'error_msg' => $this->form_validation->error_array()));
			//$this->session->set_flashdata('error', $this->form_validation->error_array());
		}
		else
		{
			$email    = strtolower($this->input->post('email'));
			$identity = ($identity_column==='email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');
			$name     = explode(' ', $this->input->post('name'));
			$additional_data = array(
					'first_name' => (!empty($name[0]))?$name[0]:'',
					'last_name'  => (!empty($name[1]))?$name[1]:'',
					'phone'      => $this->input->post('mobile'),
			);
			$result = false;
			$this->db->trans_start();
			try{
				$userId = $this->ion_auth->register($identity, $password, $email, $additional_data, array(3));
				if($userId) {
					$vendor_data = array('vendor_id' => $userId, 'address' => $this->input->post('address'), 'city_id' => $this->input->post('city'));
					$this->load->model('vendor_model');
					$this->load->model('vendor_ride_model');
					if($this->vendor_model->addVendor($vendor_data)){
						$rides = $this->input->post('ride');
						$ride_number  = $this->input->post('number');
						$vendor_rides = array();
						if(is_array($rides) && sizeof($rides) > 0) {
							foreach($rides as $key => $val) {
								//$this->vendor_ride_model->addVendorRide(array('ride_id' => $val, 'vendor_id' => $userId, 'number' => $ride_number[$key]));
								$vendor_rides[] = array('ride_id' => $val, 'city_id' => $this->input->post('city'), 'vendor_id' => $userId, 'number' => $ride_number[$key]);
							}
							$this->vendor_ride_model->addVendorRides($vendor_rides);
							$result = true;
						}						
					}
					
				}
				
				
			}catch (Exception $e){
				echo json_encode(array( 'resp' => 'DB ERROR'));
			}
			
			if($result) {
				$this->db->trans_complete();
			}else{
				$this->db->trans_rollback();
			}			
			
			if($this->db->trans_status() === FALSE || !$result )
			{
				// do something if it fails
				//$this->session->set_flashdata('resp', 'Transaction failed');
				//$this->db->trans_rollback();
				echo json_encode(array( 'resp' => 'Transaction failed'));
			}else {
				//$this->db->trans_commit();
				echo json_encode(array( 'result' => 'success'));
				//$this->session->set_flashdata('success', "Success");
			}			
		}		
		//redirect('join-us');
	}
	
	/**
	 * 
	 */
	function joinUs() {
		$page = 'join-us';
		$error    = $this->session->flashdata('error');
		$resp     = $this->session->flashdata('resp');
		$success  = $this->session->flashdata('success');
		if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		$this->load->model('city_model');
		$this->load->model('ride_model');
		$cities = $this->city_model->getAllCity("", array('city_status' => 1));
		$rides  = $this->ride_model->getAllRides("", array('status' => 1));	
		$data['error']    = $error;
		$data['resp']     = $resp;
		$data['success']  = $success;
		$data['cities'] = $cities['rows'];
		$data['rides']  = $rides['rows'];
		$data['title']  = ucfirst($page); // Capitalize the first letter
		$data['seo_title']  = 'Mumbai to Pune Cab Services | Mumbai Pune Taxi Fare';
		$data['seo_desc']  = 'For best Car and Cab on rent Services from Mumbai to Pune, Shirdi, Khandala, Imagica, Alibaug, Kolad, Mahabaleshwar Join Pin A Ride.';
		$data['js_files'] = array('joinus');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
	

}
