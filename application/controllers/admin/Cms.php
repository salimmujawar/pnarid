<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cms extends CI_Controller {
	
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
		define('THIS_URL', base_url('admin/cms'));
		define('DEFAULT_LIMIT', PER_PAGE);
		define('DEFAULT_OFFSET', 0);
		define('DEFAULT_SORT', "cms_id");
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
		$page = 'cms_list';
			if ( ! file_exists(APPPATH.'/views/admin/'.$page.'.php'))
			{
					// Whoops, we don't have a page for that!
					show_404();
			}
			$this->load->model('cms_model');
			$this->load->library("pagination");
			// get parameters
			$limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
			$offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
			$sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
			$dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;
			
			// get filters
			$filters = array();
			
			if ($this->input->get('username'))
			{
				$filters['username'] = $this->input->get('username', TRUE);
			}
			
			if ($this->input->get('first_name'))
			{
				$filters['first_name'] = $this->input->get('first_name', TRUE);
			}
			
			if ($this->input->get('last_name'))
			{
				$filters['last_name'] = $this->input->get('last_name', TRUE);
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
			
					if ($this->input->post('username'))
					{
						$filter .= "&username=" . $this->input->post('username', TRUE);
					}
			
					if ($this->input->post('first_name'))
					{
						$filter .= "&first_name=" . $this->input->post('first_name', TRUE);
					}
			
					if ($this->input->post('last_name'))
					{
						$filter .= "&last_name=" . $this->input->post('last_name', TRUE);
					}
			
					// redirect using new filter(s)
					redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
				}
			}
			
			// get list
			//$users = $this->users_model->get_all($limit, $offset, $filters, $sort, $dir);			
			$cms = $this->cms_model->getAllCms("", "", $sort, $dir, $limit, $offset, $filters);
			//$data['cms'] = $cms;
			
			// build pagination
			$this->pagination->initialize(array(
					'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
					'total_rows' => $cms['num_rows'],
					'per_page'   => $limit
			));
			
						
			// set content data
			$content_data = array(
					'this_url'   => THIS_URL,
					'pages'      => $cms['rows'],
					'total'      => $cms['num_rows'],
					'filters'    => $filters,
					'filter'     => $filter,
					'pagination' => $this->pagination->create_links(),
					'limit'      => $limit,
					'offset'     => $offset,
					'sort'       => $sort,
					'dir'        => $dir
			);
			
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = ucfirst($page); // Capitalize the first letter			
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
}