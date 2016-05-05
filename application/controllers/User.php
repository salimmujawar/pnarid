<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
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
					
			);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array( 'result' => 'error', 'error_msg' => $this->form_validation->error_array()));
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
            		'address'    => (isset($_POST['address']))?$this->input->post('address'):'',
            ); 
            $id = $this->ion_auth->register($identity, $password, $email, $additional_data);
            if($id) {                
            	//maintain the session            	
            	$ride_sess = $this->session->userdata('ride');
            	if(sizeof($ride_sess) > 0 && $this->input->post('book')) {
            		$ride_sess['step'] = 3;
            		$this->session->set_userdata($ride_sess);
            	}
                
            	//login user after signup
            	if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password')))
            	{
                        $user = $this->ion_auth->user()->row();
                        $username = (!empty($user->username)) ? $user->username : $user->first_name;                      
                        
                        //send an welcome email
                        $this->load->model('sendemails_model');
                        $user_data = array('username' => $username);
                        $this->sendemails_model->htmlmail($user->email, 'Welcome, ' . $username . ' to Pin A Ride', 'welcome', $user_data);
                        
            		echo json_encode(array('result' => 'success'));
                        exit;
            	}				
            }else{
            	echo json_encode(array( 'result' => 'error', 'error_res' => 'Transaction failed.'));
                exit;
            }
		}
	}
	
	function login_page() {
		$page      = 'login';
		$user_type = '';
		if($this->ion_auth->logged_in()) {
			redirect('/');
		}
		if (! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}	
		$data['js_files'] = array('login');		
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
	
	/**
	 * User login
	 */
	public function login()
	{
		$tables = $this->config->item('tables','ion_auth');
		$identity_column = $this->config->item('identity','ion_auth');
		$this->data['identity_column'] = $identity_column;
		$config = array(				
					array(
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'trim|required|valid_email'
					),
					array(
							'field' => 'password',
							'label' => 'Password',
							'rules' => 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']',
					),
					
						
			);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array( 'result' => 'error', 'error_msg' => $this->form_validation->error_array()));
		}
		else
		{
			if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password')))
			{	
				//maintain the session
				$ride_sess = $this->session->userdata('ride');
				if(sizeof($ride_sess) > 0 && $this->input->post('book')) {
					$ride_sess['step'] = 3;
					$this->session->set_userdata($ride_sess);
				}			
				echo json_encode(array('result' => 'success'));
			}
			else
			{
				echo json_encode(array( 'result' => 'error', 'error_res' => strip_tags($this->ion_auth->errors())));					
			}
		}
	}
	
	/**
	 * 
	 */
	function logout() {
		// log the user out
		$logout = $this->ion_auth->logout();		
		redirect('/', 'refresh');
	}	
	
	function enquiry_submit() {
		$config = array(
				array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'trim|required|min_length[5]'
				),
				array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'trim|required|valid_email'
				),
				array(
						'field' => 'mobile',
						'label' => 'Mobile',
						'rules' => 'trim|required|numeric|min_length[10]|max_length[12]',
				),
				array(
						'field' => 'text',
						'label' => 'Enquiry',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'campange',
						'label' => 'Campaign',
						'rules' => 'trim|required'
				),
					
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array( 'result' => 'error', 'error_msg' => $this->form_validation->error_array()));
                        exit;
		}
		else
		{
			$name     = $this->input->post('name');
			$email    = $this->input->post('email');
			$mobile   = $this->input->post('mobile');
			$enquiry  = $this->input->post('text');
			$campange = $this->input->post('campange');
			$this->load->model('user_model');
			if($this->user_model->add_enquiry(array('name' => $name, 'email' => $email, 'phone' => $mobile, 'enquiry' => $enquiry, 'campaign' => $campange))) {
                                
                                //send an welcome email
                                $this->load->model('sendemails_model');
                                $user_data = array('name' => $name, 'provider' => $campange,
                                					'phone' => $mobile, 'email' => $email,
                                					'content' => $enquiry
                                				);
                                $this->sendemails_model->htmlmail('pinaride@gmail.com', 'Enquiry for Pin A Ride by ' . ucwords($name), 'enquiry', $user_data);
				echo json_encode(array('result' => 'success'));
                                exit;
			}
			else
			{
				echo json_encode(array( 'result' => 'error', 'error_res' => 'Transaction error'));
                                exit;
			}
		}	
	}
	
	function enquiry() {		
		$page  = 'enquiry';
		if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['seo_title']  = 'Enquiry About Car and Rental Services Mumbai to Pune, Shirdi Fare';
		$data['seo_desc']  = 'If you want online enquiry about Car and Cab Rental Services Mumbai to Pune, Mumbai to Shirdi Taxi, Mumbai Pune Taxi Fare, then Pin A Ride is one stop Solution.';
		$data['js_files'] = array('enquiry');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}

	
	function feedback_submit() {
		$config = array(
				array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'trim|required|min_length[5]'
				),
				array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'trim|required|valid_email'
				),
				array(
						'field' => 'mobile',
						'label' => 'Mobile',
						'rules' => 'trim|required|numeric|min_length[10]|max_length[12]',
				),
				array(
						'field' => 'score',
						'label' => 'Score',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'category',
						'label' => 'Category',
						'rules' => 'trim|required'
				),				
					
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array( 'result' => 'error', 'error_msg' => $this->form_validation->error_array()));
		}
		else
		{
			$name     = $this->input->post('name');
			$email    = $this->input->post('email');
			$mobile   = $this->input->post('mobile');
			$score    = $this->input->post('score');
			$category = $this->input->post('category');
			$message  = $this->input->post('message');
			
			$this->load->model('user_model');
			if($this->user_model->add_feedback(array('name' => $name, 'email' => $email, 'phone' => $mobile, 
						'score' => $score, 'category' => $category, 'message' => $message))) {
				echo json_encode(array('result' => 'success'));
			}
			else
			{
				echo json_encode(array( 'result' => 'error', 'error_res' => 'Transaction error'));
			}
		}
	}
	
	function feedback() {
		$page  = 'feedback';
		if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
	
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['seo_title']  = 'Cab Services in Mumbai | Mumbai Pune Taxi Fare | Car Rental Services';
		$data['seo_desc']  = 'Have Take Car and Cab Services in Pin A ride? Then give your feedback how you feel for Cab Services in Mumbai, Mumbai Pune Taxi Fare, Car Rental Services.';
		$data['js_files'] = array('feedback');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
}
