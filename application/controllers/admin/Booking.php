<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Booking extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->library(array('ion_auth','form_validation'));		
	}
		
	function index() {
		$page      = 'history';
		$user_type = '';		
		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
                
		$this->load->model('booking_model');
                $b_id  = $this->input->post('b_id');
                $vendor_id  = $this->input->post('vendor');
                if(!empty($b_id) && !empty($vendor_id)) {
                   $this->booking_model->updateOrder($b_id, array('vendor_id' => $vendor_id)); 
                }
		$user = $this->ion_auth->user()->row();
		$user_groups = $this->ion_auth->get_users_groups($user->id)->row();
		$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$bookList = array();		
		$data['group_id'] = $user_groups->id;		
		$user_type = 'admin';				
		$bookList = $this->booking_model->getAllBooking("", "all", "cdate", "desc", PER_PAGE, $data['page']);
		$config['total_rows'] = $this->booking_model->getBookingCount();
		
				
		if (! file_exists(APPPATH.'/views/'.$user_type.'/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		$this->load->library("pagination");
		//pagination settings
		$config['base_url'] = site_url('admin/booking/index');		
		$config['per_page'] = PER_PAGE;
		$config["uri_segment"] = 4;
		
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = floor($choice);
		//print_r($config);
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['total_rows'] = $config['total_rows'];
		$data['book_list'] = $bookList;
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$this->load->view('templates/header', $data);
		$this->load->view($user_type.'/'.$page, $data);
		$this->load->view('templates/footer', $data);
	} 
        
        function vendors() {
            $page      = 'vendor_list';
            $user_type = 'admin';		
            $book_id = $_GET['b_id'];
            if(!$this->ion_auth->logged_in()) {
                    redirect('login');
            }
            if(empty($book_id)) {
                redirect('admin/booking/index');
            }
            $data['book_id'] = $book_id;
            $this->load->model('vendor_model');
            $this->load->library("pagination");
            $user = $this->ion_auth->user()->row();
            $user_groups = $this->ion_auth->get_users_groups($user->id)->row();
            
            $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $vendorList = array();		
            $data['group_id'] = $user_groups->id;
            $likeArr = array();        
            $data['address'] = '';
            if(!empty($_GET['venAddress'])) {
               $likeArr['lower(v.address)']  = strtolower($_GET['venAddress']);
               $data['address'] = $_GET['venAddress'];
            }
            
            $vendorList = $this->vendor_model->getAllVendors("", array('group_id' => VENDOR_ID) , $likeArr, "created_on", "desc", PER_PAGE, $data['page']);
            
            //pagination settings
            $config['total_rows'] = $this->vendor_model->getVendorCount(array('group_id' => VENDOR_ID) , $likeArr);            
            $config['base_url'] = site_url('admin/booking/index');		
            $config['per_page'] = PER_PAGE;
            $config["uri_segment"] = 4;

            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = floor($choice);
            //print_r($config);
            $this->pagination->initialize($config);

            $data['pagination'] = $this->pagination->create_links();

            $data['total_rows'] = $config['total_rows'];
            $data['vendor_list'] = $vendorList;
            $data['title'] = ucfirst($page); // Capitalize the first letter
            
            $this->load->view('templates/header', $data);
            $this->load->view($user_type.'/'.$page, $data);
            $this->load->view('templates/footer', $data);
        }
        
        
          function notify() {            		
            $book_id = $_GET['b_id'];
            if(!$this->ion_auth->logged_in()) {
                    redirect('login');
            }
            if(empty($book_id)) {
                redirect('admin/booking/index');
            } 
            $user = $this->ion_auth->user()->row();
            $user_groups = $this->ion_auth->get_users_groups($user->id)->row();
            //print_r($user_groups);
            if(ADMIN_ID == $user_groups->id) {
                $this->load->model('sendsms_model');
                $this->load->model('booking_model');

                $bookData = $this->booking_model->getBookingDetails(0, $book_id);
                //print_r($bookData);die;
                $sms_data = array('order_id' => $bookData->b_id, 'firstname' => $bookData->first_name, 
                                    'ride_name' => $bookData->ride_name, 'vendor_contact' => $bookData->vendor_contact, 'ride_num' => 'MH-43-AN-5894');
                $response = $this->sendsms_model->sendmsg($bookData->phone, 'ride_details', $sms_data);
                $response = json_decode($response, true);
                
                if($response['status'] == 'OK') {
                    $this->booking_model->updateOrder($book_id, array('sms_notified' => 1)); 
                }
            }            
            
            redirect('admin/booking/index');
          }
        
        
}
