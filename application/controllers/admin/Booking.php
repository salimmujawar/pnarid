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
}
