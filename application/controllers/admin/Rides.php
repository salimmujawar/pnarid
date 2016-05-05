<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rides extends CI_Controller {
	
	private $_redirect_url;
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('ion_auth','form_validation'));
		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}	
		if (!$this->ion_auth->is_admin()) {
			redirect('/');
		}
		$this->load->database();
		$this->load->library('session');
		
		// set constants
		define('REFERRER', "referrer");
		define('THIS_URL', base_url('admin/rides'));
		define('DEFAULT_LIMIT', PER_PAGE);
		define('DEFAULT_OFFSET', 0);
		define('DEFAULT_SORT', "r.ride_id");
		define('DEFAULT_DIR', "desc");
		
		// use the url in session (if available) to return to the previous filter/sorted/paginated list
		if ($this->session->userdata(REFERRER))
		{
			$this->_redirect_url = $this->session->userdata(REFERRER);
		}
		else
		{
			$this->_redirect_url = THIS_URL;
		}
	}

	public function index()
	{	
		$page = 'rides_list';
			if ( ! file_exists(APPPATH.'/views/admin/'.$page.'.php'))
			{
					// Whoops, we don't have a page for that!
					show_404();
			}
			$this->load->model('vendor_ride_model');
			$this->load->library("pagination");
			// get parameters
			$limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
			$offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
			$sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
			$dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;
			
			// get filters
			$filters = array();
			
			if ($this->input->get('ride_name'))
			{
				$filters['ride_name'] = $this->input->get('ride_name', TRUE);
			}
			
			if ($this->input->get('first_name'))
			{
				$filters['first_name'] = $this->input->get('first_name', TRUE);
			}
			
			if ($this->input->get('per_km'))
			{
				$filters['per_km'] = $this->input->get('per_km', TRUE);
			}
                        if ($this->input->get('actual_per_km'))
			{
				$filters['actual_per_km'] = $this->input->get('actual_per_km', TRUE);
			}
                        if ($this->input->get('seats'))
			{
				$filters['seats'] = $this->input->get('seats', TRUE);
			}
                        if ($this->input->get('city_name'))
			{
				$filters['city_name'] = $this->input->get('city_name', TRUE);
			}
			
			// build filter string
			$filter = "";
			foreach ($filters as $key => $value)
			{
				$filter .= "&{$key}={$value}";
			}
			
			// save the current url to session for returning
			$this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
			
			// are filters being submitted?
			if ($this->input->post())
			{       
				if ($this->input->post('clear'))
				{
					// reset button clicked
					redirect(THIS_URL);
				}
				else
				{   
					// apply the filter(s)
					$filter = "";
			
					if ($this->input->post('ride_name'))
					{
						$filter .= "&ride_name=" . $this->input->post('ride_name', TRUE);
					}
			
					if ($this->input->post('per_km'))
					{
						$filter .= "&per_km=" . $this->input->post('per_km', TRUE);
					}
                                        if ($this->input->post('actual_per_km'))
					{
						$filter .= "&actual_per_km=" . $this->input->post('actual_per_km', TRUE);
					}
			
					if ($this->input->post('seats'))
					{
						$filter .= "&seats=" . $this->input->post('seats', TRUE);
					}
                                        
                                        if ($this->input->post('first_name'))
					{
						$filter .= "&first_name=" . $this->input->post('first_name', TRUE);
					}
                                        
                                        if ($this->input->post('city_name'))
					{
						$filter .= "&city_name=" . $this->input->post('city_name', TRUE);
					}
                                        echo $filter;
					// redirect using new filter(s)
					redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
				}
			}
			
			// get list			                        
                        $rides = $this->vendor_ride_model->getAllVendorRidesList("", "", $sort, $dir, $limit, $offset, $filters);
			
			// build pagination
			$this->pagination->initialize(array(
					'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
					'total_rows' => (isset($rides['num_rows']))?$rides['num_rows']:0,
					'per_page'   => $limit
			));
			
						
			// set content data
			$content_data = array(
					'this_url'   => THIS_URL,
					'pages'      => (isset($rides['rows']))?$rides['rows']:0,
					'total'      => (isset($rides['num_rows']))?$rides['num_rows']:0,
					'filters'    => $filters,
					'filter'     => $filter,
					'pagination' => $this->pagination->create_links(),
					'limit'      => $limit,
					'offset'     => $offset,
					'sort'       => $sort,
					'dir'        => $dir,
                                        'error'      => $this->session->flashdata('error'),
                                        'message'    => $this->session->flashdata('message'),
                                        'title'      => ucfirst($page)
			);
			
			
			$this->load->view('templates/header', $content_data);
			$this->load->view('admin/'.$page, $content_data);
			$this->load->view('templates/footer', $content_data);
	}
	
	public function add($id = 0)
	{
		$page = 'cms_add';		
		if ( ! file_exists(APPPATH.'/views/admin/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		$cms = array();
		if	(!empty($id)) {
			$this->load->model('cms_model');
			$cms = $this->cms_model->getCms("", array('cms_id' => $id));
			
		}
		$data['cms_id']	= $id;
		$data['cms'] = $cms;
		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['cancel_url'] = base_url('admin/cms');
		$data['action_url'] = base_url('admin/cms/submit');		
		$data['js_files'] = array('ckeditor/ckeditor', 'admin/cms');
		$this->load->view('templates/header', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function submit()
	{
		
		$this->form_validation->set_rules('slug', 'Slug', 'required|trim|min_length[5]|max_length[50]');
		$this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[5]|max_length[50]');
		$this->form_validation->set_rules('content', 'Content', 'required|trim');
		$config = array(
				array(
						'field' => 'slug',
						'label' => 'Slug',
						'rules' => 'required|trim|min_length[5]|max_length[50]'
				),
				array(
						'field' => 'title',
						'label' => 'Title',
						'rules' => 'required|trim|min_length[5]|max_length[50]'
				)
				,
				array(
						'field' => 'content',
						'label' => 'Content',
						'rules' => 'trim|required'
				)				
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == TRUE)	{
			// save the new user
			$this->load->model('cms_model');
			$saved = $this->cms_model->add($this->input->post());
			
			if ($saved)
			{
				$this->session->set_flashdata('message', 'CMS added data succesfully');
			}
			else
			{
				$this->session->set_flashdata('error', 'CMS add data error');
			}
			
			// return to list and display message
			redirect(base_url('admin/cms'));
		}
	}
	
	public function delete()
	{
		$page = 'cms_list';
		if ( ! file_exists(APPPATH.'/views/admin/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
	
		$data['title'] = ucfirst($page); // Capitalize the first letter
			
		$this->load->view('templates/header', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
        
        
        function sms_partner($vendor, $booking = NULL) {
            $page = 'sms_partner';
            $data = array();
            //echo $vendor, $booking; die;
            if  (!empty($vendor) && !empty($booking)) {
                $this->load->model('sendsms_model');
                $this->load->model('booking_model');
                $this->load->model('vendor_ride_model');
                $booking_details = $this->booking_model->getBookingDetails(0, $booking);
                $vendor_details = $this->vendor_ride_model->getVendorDetails($vendor);   
                $data['booking_details'] =  $booking_details;
                $data['vendor_details'] =  $vendor_details;
                //print_r($booking_details);die;
                if ($this->input->post()) { 
                    $vendor_phone = $this->input->post('vendor_phone');
                    $sms_data = array('book_id' => $booking_details->b_id, 'pickup_date' => date('d/m/Y', strtotime($booking_details->pickup_datetime)),
                            'pickup_time' => date('h:i a', strtotime($booking_details->pickup_datetime)),
                            'client_name' => ucfirst($booking_details->first_name), 'client_mobile' => $booking_details->phone,
                            'pickup_address' => $booking_details->from_city, 'ride_name' => $booking_details->ride_name,
                            'destination' => $booking_details->to_city
                            );                    
                    $json_response = $this->sendsms_model->sendmsg($vendor_phone, 'partner_pickup_return', $sms_data);
                    $response = json_decode($json_response, TRUE);                    
                    $this->session->set_flashdata('message', 'SMS send to partner succesfully');
                    // return to list and display message
                    redirect(base_url('admin/rides'));
                }
                
             
            }else{
                $this->session->set_flashdata('error', 'No booking ID');
            }            
            $data['error']  = $this->session->flashdata('error');         
            $this->load->view('templates/header', $data);
            $this->load->view('admin/'.$page, $data);
            $this->load->view('templates/footer', $data);  
        }
        
        
}