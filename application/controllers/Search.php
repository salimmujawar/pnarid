<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->library(array('ion_auth','form_validation'));
	}
	
	public function isValidDate($date)
	{
		$current = strtotime('Today');
		$date    = strtotime($date);
		if ($current <= $date) {
			return TRUE;
		} else {
			$this->form_validation->set_message('isValidDate', "The %s date must greater than today's date.");
			return FALSE;
		}
	}
	
	public function isValidTime($time, $date)
	{		
		$result = false;		
		$givenTime =  strtotime($time);
		$date      =  date("Y-m-d", strtotime($date));
		$todatDate = date("Y-m-d", strtotime('Today'));
		$timeNow   = strtotime('now') + RIDE_INTERVAL;		
		
		if ($date >= $todatDate) {
			if($date == $todatDate) {
				//echo ($time - $timeNow);
				/*$givenTime = strtotime('21:08:00 pm');
				$timeNow = (strtotime('20:08:00 pm') + 14400);*/
				//echo $givenTime;
				//echo '<br/>' . $timeNow;
				if($givenTime > $timeNow) {
					return TRUE;
				}else {
					$this->form_validation->set_message('isValidTime', "The %s time must be alteast more than 4 hrs from current time.");
					return FALSE;
				}				
			}
			return TRUE;
		}
	}
	
	public function rides() {
		$config = array(
				array(
						'field' => 'type',
						'label' => 'Journey Type',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'pickup',
						'label' => 'Pickup Location',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'trip',
						'label' => 'Trip type',
						'rules' => 'trim|required'
				),				
				array(
						'field' => 'date',
						'label' => 'Journey Date',
						'rules' => 'trim|required|callback_isValidDate'
				),
				/*array(
						'field' => 'day',
						'label' => 'Number of Days',
						'rules' => 'trim|required|greater_than[0]'
				),*/
				array(
						'field' => 'time',
						'label' => 'Pickup time',
						'rules' => 'trim|required' //|callback_isValidTime[' . $this->input->post('date') . ']'
				),
					
		);
		if($this->input->post('type') == 'local') {
			$config = $config + array(
									'field' => 'drop',
									'label' => 'Drop Location',
									'rules' => 'trim|required',
							);
		}
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
			echo json_encode(array( 'result' => 'error', 'error_msg' => $this->form_validation->error_array()));
		}
		else
		{	
			$rideData = array();
			$jsonStr  = "";
			$this->load->model('search_model');
			$params = array('type'  => $this->input->post('type'),
							'pickup'=> $this->input->post('pickup'),
							'drop' => $this->input->post('drop'),
							'date' => $this->input->post('date'),
							'time' => $this->input->post('time'),
                                                        'trip' => $this->input->post('trip'),
							'step' => $this->input->post('step'));
                        
			$rideData = $this->search_model->getRides($params);

			if(sizeof($rideData) > 0) {
				$jsonStr = json_encode($rideData);
			}
			if (!empty($jsonStr)) {			
				echo json_encode(array( 'result' => 'success', 'json_data' => $jsonStr ));
			} else {
				echo json_encode(array( 'result' => 'not_found', 'json_data' => '' ));
			}
		}
	}
}
