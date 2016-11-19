<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library(array('ion_auth', 'form_validation'));
    }

    public function isValidDate($date) {
        $current = strtotime('Today');
        $date = strtotime($date);
        if ($current <= $date) {
            return TRUE;
        } else {
            $this->form_validation->set_message('isValidDate', "The %s date must greater than today's date.");
            return FALSE;
        }
    }

    public function isValidTime($time, $date) {
        $result = false;
        $givenTime = strtotime($time);
        $date = date("Y-m-d", strtotime($date));
        $todatDate = date("Y-m-d", strtotime('Today'));
        $timeNow = strtotime('now') + RIDE_INTERVAL;

        if ($date >= $todatDate) {
            if ($date == $todatDate) {
                //echo ($time - $timeNow);
                /* $givenTime = strtotime('21:08:00 pm');
                  $timeNow = (strtotime('20:08:00 pm') + 14400); */
                //echo $givenTime;
                //echo '<br/>' . $timeNow;
                if ($givenTime > $timeNow) {
                    return TRUE;
                } else {
                    $this->form_validation->set_message('isValidTime', "The %s time must be alteast more than 4 hrs from current time.");
                    return FALSE;
                }
            }
            return TRUE;
        }
    }

    public function cars() {
        $page = 'cars';
        if (!file_exists(APPPATH . '/views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }
        $data['title'] = ucfirst($page); // Capitalize the first letter	
        //print_r($_POST);
        $config = array(
            array(
                'field' => 'journeyRoute',
                'label' => 'Journey Type',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'journeySaddr',
                'label' => 'Pickup Location',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'journeyDaddr',
                'label' => 'Trip type',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'journeyDate',
                'label' => 'Journey Date',
                'rules' => 'trim|required|callback_isValidDate'
            ),           
        );
        $data['ride_data'] = array();
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error',  $this->form_validation->error_array());
        } else {
            $rideData = array();
            $jsonStr = "";
            $this->load->model('search_model');
            $distance = $this->search_model->getDrivingDistance($this->input->post('saddrLat'), $this->input->post('daddrLat'), $this->input->post('saddrLng'), $this->input->post('daddrLng'));
            //print_r($distance);
            $searchData['cust_query'] = $_POST;
            $this->session->set_userdata($searchData);
            $searchQuery = array();
            
            
            //print_r($searchData);
            $totalDistance = $distance['distance'];
            $rideData = $this->search_model->getRideDetails($this->input->post('journeyRoute'), $totalDistance);
            $searchQuery['from'] = strip_tags($_GET['from']);
            $searchQuery['to'] = strip_tags($_GET['to']);
            if ($this->input->post('journeyRoute') == 'round') {
                $totalDistance = $distance['distance'] * 2;
            }
            $searchQuery['total_distance'] = $totalDistance;
            //echo $totalDistance;
            
        }
        //print_r($rideData);
        $data['searchQuery'] = $searchQuery;
        $data['ride_data'] = $rideData;
        $data['js_files'] = array('carlist');
        $data['css_files'] = array();
        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }
    
    
        private function getLocalRides ($totalDistance) {
        $rideData = array();
                 $rideData['hatchback'] = array('car_model' => 'Indica or equivalent', 
                                               'category'  => 'Economy, 4 Seater AC',
                                               'base_fare' => round($totalDistance * 10),
                                               'advance'   => round(($totalDistance * 10) * COMMISSION),
                                               'url'       => 'indica-215x127.jpg'
                                            );
                $rideData['sedan'] = array('car_model' => 'Dzire,  or equivalent', 
                                               'category'  => 'Comfort, 4 Seater AC',
                                               'base_fare' => round($totalDistance * 12),
                                               'advance'   => round(($totalDistance * 12) * COMMISSION),
                                               'url'       => 'swift-215x127.png'
                                            );
                $rideData['suv'] = array('car_model' => 'Tavera or Xylo', 
                                               'category'  => 'Power, 6 Seater AC',
                                               'base_fare' => round($totalDistance * 13),
                                               'advance'   => round(($totalDistance * 13) * COMMISSION),
                                               'url'       => 'tavera-215x127.png'
                                            );
                $rideData['mpv'] = array('car_model' => 'Innova or Ertiga', 
                                               'category'  => 'Premium, 6 Seater AC',
                                               'base_fare' => round($totalDistance * 13.5 ),
                                               'advance'   => round(($totalDistance * 13.5 ) * COMMISSION),
                                               'url'       => 'inova-215x127.png'
                                            );
                
                return $rideData;
            
    }

    /**
     * Old search function
     */
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
            /* array(
              'field' => 'day',
              'label' => 'Number of Days',
              'rules' => 'trim|required|greater_than[0]'
              ), */
            array(
                'field' => 'time',
                'label' => 'Pickup time',
                'rules' => 'trim|required' //|callback_isValidTime[' . $this->input->post('date') . ']'
            ),
        );
        if ($this->input->post('type') == 'local') {
            $config = $config + array(
                'field' => 'drop',
                'label' => 'Drop Location',
                'rules' => 'trim|required',
            );
        }
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('result' => 'error', 'error_msg' => $this->form_validation->error_array()));
        } else {
            $rideData = array();
            $jsonStr = "";
            $this->load->model('search_model');
            $params = array('type' => $this->input->post('type'),
                'pickup' => $this->input->post('pickup'),
                'drop' => $this->input->post('drop'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'trip' => $this->input->post('trip'),
                'step' => $this->input->post('step'));

            $rideData = $this->search_model->getRides($params);

            if (sizeof($rideData) > 0) {
                $jsonStr = json_encode($rideData);
            }
            if (!empty($jsonStr)) {
                echo json_encode(array('result' => 'success', 'json_data' => $jsonStr));
            } else {
                echo json_encode(array('result' => 'not_found', 'json_data' => ''));
            }
        }
    }

}
