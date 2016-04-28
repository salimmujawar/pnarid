<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sendemails_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();		
	}

	public function htmlmail($userEmail, $subject, $template, $data){
        $config = Array(        
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
        	//'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
        	//'smtp_port' => 587,
            'smtp_user' => 'salim685@gmail.com',
            'smtp_pass' => 'Simple@123',            
            'mailtype'  => 'html', 
            'charset'   => 'utf-8'
        );
        $userEmail = 'salim685@gmail.com';
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        
        //$this->email->from('pinaride@gmail.com', 'Pin A Ride');
        $this->email->from($userEmail, 'Pin A Ride');
        $this->email->to($userEmail);  // replace it with receiver mail id
        $this->email->subject($subject); // replace it with relevant subject
        
        $body = $this->load->view('emails/' . $template . '.php',$data,TRUE);
        $this->email->message($body);
        $this->email->send();
        echo $this->email->print_debugger();
    }
}