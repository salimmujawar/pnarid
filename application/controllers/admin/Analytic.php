<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Analytic extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library(array('ion_auth', 'form_validation'));
    }

    function index() {
        $page = 'analytics';
        $user_type = '';
        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        $this->load->model('analytic_model');
        
        $user = $this->ion_auth->user()->row();
        $user_groups = $this->ion_auth->get_users_groups($user->id)->row();
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $bookList = array();
        $data['group_id'] = $user_groups->id;
        $user_type = 'admin';
        $per_page = 10;
        $where = array();
        $like = array();
        if (!empty($_GET['campainge'])) {
            $like['referer'] = $_GET['campainge'];
        }
        if (!empty($_GET['cdate'])) {
            $like['cdate'] = date('Y-m-d', strtotime($_GET['cdate']));
        }
        $analyticList = $this->analytic_model->getAllAnalytics("", $where, $like, "cdate", "desc", $per_page, $data['page']);
        $config['total_rows'] = $this->analytic_model->getAnalyticCount($where, $like);


        if (!file_exists(APPPATH . '/views/' . $user_type . '/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }
        $this->load->library("pagination");
        //pagination settings
        $config['base_url'] = site_url('admin/analytic/index');
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");

        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        //print_r($config);
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['current_date'] = date('m/d/Y', strtotime('now'));
        $data['total_rows'] = $config['total_rows'];
        $data['analytic_list'] = $analyticList;
        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['js_files'] = array('analytics', 'bootstrap-select.min');
	$data['css_files'] = array('bootstrap-select.min');
        $this->load->view('templates/header', $data);
        $this->load->view($user_type . '/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

}
