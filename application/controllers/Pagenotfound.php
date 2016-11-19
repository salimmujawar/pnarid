<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Pagenotfound extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
    { 
    	$data = array();
    	$this->output->set_status_header('404'); 
        $this->load->view('templates/header', $data);
		$this->load->view('pages/404', $data);
		$this->load->view('templates/footer', $data);
    } 
} 
?> 