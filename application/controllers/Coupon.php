<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Coupon extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->library(array('ion_auth','form_validation'));		
	}
	
	function apply() {
		if ($this->ion_auth->logged_in())
		{
			$config = array(
					array(
							'field' => 'code',
							'label' => 'Coupon',
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
				$ride_sess = $this->session->userdata('ride');
				$code = $this->input->post('code');
				$this->load->model('coupon_model');
				if(empty($ride_sess['code'])) {					
					$coupon = $this->coupon_model->applyCoupon($code);
					$reduce = 0;
					if(!empty($coupon->amount)) {
						$reduce = $coupon->amount;
						$this->coupon_model->updateUsage($code);
					}
					if(isset($coupon->coupon)) {
						$rideData = array();
						$rideData =  array( 'ride' => $ride_sess + array('code' => $code, 'reduce' => $reduce));
						$this->session->set_userdata($rideData);
						echo json_encode(array( 'result' => 'success', 'json_data' => array('reduce' => $reduce)));
					}else{
						echo json_encode(array( 'result' => 'error', 'err_resp' => 'Invalid coupon'));
					}
				}else{
					echo json_encode(array( 'result' => 'error', 'err_resp' => 'Coupon already applied'));
				}				
			}
			
		}else{
			echo json_encode(array( 'result' => 'success', 'err_resp' => 'Invalid user'));
		}
	
	}
}