<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library(array('ion_auth', 'form_validation'));
    }
    
    
    public function start() {
        $page = 'startbooking';
        if (!file_exists(APPPATH . '/views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }
       
        //print_r($_POST);
        if ($this->input->post('ride_details') || $this->input->post('custom_package')) {
            
            if ($this->input->post('custom_package')) {
                $this->load->model('product_model');
                $ride = $this->product_model->getProduct("", array('p_id' => $this->input->post('ride_id')));
                $ride = $ride['rows'];
                $numberDays = 1;               
                $payment = ($ride->amount * COMMISSION);
                $ride_details = array ( 'car_model' => $ride->description, 'category' => $ride->category . $ride->seats .' Seater AC', 'base_fare' => $ride->amount, 'advance' => $payment, 'url' => $ride->url, 'distance' => 120, 'ride_id' => $ride->p_id, 'journey' => $ride->journey );
                $cust_query = array('journeyRoute' => 'local', 'journeySaddr' => 'Mumbai Darshan', 'journeyDaddr' => '', 'journeyDate' => $this->input->post('journeyDate'));
                $product = $ride->p_id;
                $this->session->set_userdata('cust_query', $cust_query);
                //print_r($ride); die;
            }else{
               $cust_query = $this->session->userdata('cust_query');
               $ride_details = json_decode(stripslashes($this->input->post('ride_details')), true);
               $numberDays = number_days($cust_query['journeyDate'], $cust_query['journeyReturndt']);
               $payment = $this->input->post('fare'); 
               $product = $this->input->post('product');
               
            }
            $data['cust_query'] = $cust_query;
            //echo 'cust';
            /*print_r($ride_details);
            print_r($cust_query); die;*/
           

            
            $ride_details = array_merge($ride_details, array('days' => $numberDays, 'payment' => $payment));
            $data['current_date'] = date('m/d/Y', strtotime('+1 days'));
            $hour = date('h', strtotime('+2 hours'));
            $minute = (date('i') > 30) ? '30' : '00';
            $meridiem = date('A');
            $data['valid_time'] = "$hour:$minute $meridiem";
            $data['current_time'] = date('h:i A', strtotime('+2 hours'));
            $data['time'] = getTime();
            $data['product'] = $product;
            $data['ride_details'] = $ride_details;
            $data['title'] = ucfirst('start booking'); // Capitalize the first letter	
            $data['js_files'] = array('booking', 'bootstrap-select.min');
            $data['css_files'] = array('bootstrap-select.min');
            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer', $data);
        }else{
            redirect('/');
        }
    }

    public function index() {
        $config = array(
            array(
                'field' => 'pay',
                'label' => 'Payment Type',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'days',
                'label' => 'Number of Days',
                'rules' => 'trim|required'
            )
            ,
            array(
                'field' => 'ride_id',
                'label' => 'Ride',
                'rules' => 'trim|required'
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('result' => 'error', 'error_msg' => $this->form_validation->error_array()));
        } else {
            $this->load->model('booking_model');

            $ride_sess = $this->session->userdata('ride');
            $jsonData = array();
            $valid_ride = array();
            //$distance = DEFAULT_KM;
            $ride_id = $this->input->post('ride_id');
            $vr_id = $this->input->post('vr');
            $days = $this->input->post('days');
            $pay = $this->input->post('pay');

            $ride_sess = $ride_sess + array('pay' => $pay, 'vr_id' => $vr_id, 'ride_id' => $ride_id, 'days' => $days);
            $valid_ride = $this->booking_model->validate_booking($ride_sess);
            //print_r($valid_ride);	
            if ($valid_ride['valid']) {
                $rideData = array('ride' => array(
                        'type' => $ride_sess['type'],
                        'trip' => $ride_sess['trip'],
                        'pickup' => $ride_sess['pickup'],
                        'drop' => $ride_sess['drop'],
                        'date' => $ride_sess['date'],
                        'time' => $ride_sess['time'],
                        'days' => $days,
                        'pay' => $pay,
                        'ride_id' => $ride_id,
                        'vr_id' => $vr_id,
                        'step' => 2
                    )
                );
                $this->session->set_userdata($rideData);

                $jsonData = array('type' => $ride_sess['type'], 'pickup' => $valid_ride['pickup'], 'drop' => $valid_ride['drop'],
                    'date' => $ride_sess['date'], 'time' => $ride_sess['time'], 'ride_name' => $valid_ride['ride_name'],
                    'tax' => $valid_ride['tax'], 'basic' => $valid_ride['basic'], 'total' => $valid_ride['total'],
                    'advance' => $valid_ride['advance'], 'balance' => $valid_ride['balance'], 'days' => $days
                );
                echo json_encode(array('result' => 'success', 'json_data' => $jsonData));
            } else {
                echo json_encode(array('result' => 'error', 'error_resp' => 'Invalid request'));
            }
        }
    }

    function paynow() {

        if ($this->ion_auth->logged_in()) {
            $config = array(
                array(
                    'field' => 'total',
                    'label' => 'Total',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'advance',
                    'label' => 'Advance',
                    'rules' => 'trim|required'
                )
                ,
                array(
                    'field' => 'basic',
                    'label' => 'Basic',
                    'rules' => 'trim|required'
                )
                ,
                array(
                    'field' => 'bal',
                    'label' => 'Balance',
                    'rules' => 'trim|required'
                )
                ,
                array(
                    'field' => 'pickuptime',
                    'label' => 'Pickup Time',
                    'rules' => 'trim|required'
                )
                ,
                array(
                    'field' => 'product',
                    'label' => 'Product',
                    'rules' => 'trim|required'
                )
            );
            $cust_query = $this->session->userdata('cust_query');
            //print_r($cust_query);
            //print_r($_POST);die;
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('result' => 'error', 'error_msg' => $this->form_validation->error_array()));
            } else {
                $total = $this->input->post('total');
                $advance = $this->input->post('advance');
                $basic = $this->input->post('basic');
                $bal = $this->input->post('bal');
                $pickup = $this->input->post('pickup');
                $pickup_time = $this->input->post('pickuptime');
                $user = $this->ion_auth->user()->row();
                //$numberDays = number_days($cust_query['journeyDate'], $cust_query['journeyReturndt']);
                
                //validate query
                $this->load->model('search_model');
                if($cust_query['journeyRoute'] == 'local') {
                    $this->load->model('product_model');
                    $ride = $this->product_model->getProduct("", array('p_id' => $this->input->post('product')));
                    $ride = $ride['rows']; 
                    $ride_details = array ( 'car_model' => $ride->description, 'category' => $ride->category . $ride->seats .' Seater AC', 'base_fare' => $ride->amount, 'advance' => ($ride->amount * COMMISSION), 'url' => $ride->url, 'distance' => 120, 'ride_id' => $ride->p_id, 'journey' => $ride->journey );                    
                   
                }else{
                    $distance = $this->search_model->getDrivingDistance($cust_query['saddrLat'], $cust_query['daddrLat'], $cust_query['saddrLng'], $cust_query['daddrLng']);
                    $product = $this->input->post('product');
                    $ride_details = $this->search_model->getRideDetails($cust_query['journeyRoute'], $distance['distance'], $product); 
                }
                
                
                 
                /*print_r($cust_query);
                print_r($ride_details);   die;*/
                
                //die('In paynow');
                /*$ride_sess = $this->session->userdata('ride');
                $ride_sess = $ride_sess;
                $this->load->model('booking_model');
                $valid_ride = $this->booking_model->validate_booking($ride_sess);*/

                //if ($valid_ride['valid']) { //&& $total == $valid_ride['total']) {
                if (!empty($ride_details['base_fare']) && $ride_details['base_fare'] == $basic) {
                    $bookData = array();
                    if (!empty($cust_query['journeyReturndt'])) {
                       $numberDays = number_days($cust_query['journeyDate'], $cust_query['journeyReturndt']); 
                    }else {
                        $numberDays = 1;
                    }
                    
                    $bookData = array('user_id' => $user->id, 'pickup_addr' => $pickup, 'days' => $numberDays, 'type' => $ride_details['journey'],
                                     'pay' => 'advance', 'trip' => $cust_query['journeyRoute'], 'ride_id' => $ride_details['ride_id'],
                                     'pickup' => $cust_query['journeySaddr'],'pickup_addr' => $pickup,'drop' => $cust_query['journeyDaddr'],
                                     'advance' => $advance,'balance' => ($basic - $advance), 'total' => $basic, 'days' => $numberDays,
                                     'basic' => $basic, 'date' => $cust_query['journeyDate'], 'time' => $pickup_time,
                                     'distance' => $ride_details['distance'],'ride_name' => $ride_details['car_model'], 'tax' => 0
                                     
                                    );
                    
                    //print_r($bookData);die;
                    $result = FALSE;
                     $this->load->model('booking_model');
                    $this->db->trans_start();
                    $bookingId = $this->booking_model->addBooking($bookData);    
                   

                    if ($bookingId) {
                        //$orderId = 'PAR-'.$bookingId .'-'. $ride_sess['vr_id'] .'-'. $ride_sess['pickup'] .'-' . $ride_sess['ride_id'];
                        $orderId = 'PAR-' . $bookingId;
                        $this->booking_model->updateOrder($bookingId, array('order_id' => $orderId));
                        $result = true;
                        $rideData = array();
                        $rideData = array('ride' => $cust_query + array('order_id' => $orderId, 'basic' => $bookData['basic'],
                            'amount' => $advance, 'ride_name' => $bookData['ride_name'], 'type' => $bookData['type']
                            )
                        );
                        $this->session->set_userdata($rideData);
                    }
                    if ($result) {
                        $this->db->trans_complete();
                    } else {
                        $this->db->trans_rollback();
                    }

                    if ($bookingId) {
                        echo json_encode(array('result' => 'success'));
                        die;
                    } else {
                        echo json_encode(array('result' => 'error', 'error_resp' => 'Try later'));
                        die;
                    }
                } else {
                    echo json_encode(array('result' => 'error', 'error_resp' => 'Invalid request'));
                    die;
                }
            }
        } else {
            echo json_encode(array('result' => 'error', 'error_resp' => 'Login required'));
            die;
        }
    }

    function failure() {
        $this->config->load('payu');
        $SALT = $this->config->item('salt');

        $status = $_POST["status"];
        $firstname = $_POST["firstname"];
        $amount = $_POST["amount"];
        $txnid = $_POST["txnid"];

        $posted_hash = $_POST["hash"];
        $key = $_POST["key"];
        $productinfo = $_POST["productinfo"];
        $email = $_POST["email"];


        $retHashSeq = $SALT . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        $hash = hash("sha512", $retHashSeq);

        $this->load->model('booking_model');
        $book_ids = explode('-', $txnid);
        $this->booking_model->updateOrder($book_ids[1], array('payment_status' => $status));

        $page = 'failure';
        $data = array();
        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    function pg_post() {
        $ride_sess = $this->session->userdata('ride');
        $page = 'pg_post';
        //print_r($ride_sess);
        if(!empty($ride_sess['order_id']) && $this->ion_auth->logged_in()) {
            $user = $this->ion_auth->user()->row();
            $this->load->model('payu_model');
            $post_data = array('txnid' => $ride_sess['order_id'], 'amount' => $ride_sess['amount'],
                'firstname' => $user->first_name, 'email' => $user->email,
                'phone' => $user->phone, 'productinfo' => $ride_sess['type'] . ' ' . $ride_sess['ride_name']
            );
            $pg_form_data = $this->payu_model->post_data($post_data);

            $data['posted'] = $pg_form_data;
            $data['title'] = ucfirst($page); // Capitalize the first letter
            $this->load->view('templates/header', $data);
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer', $data);
        }else{
            $this->session->unset_userdata('ride');
            redirect('/faliure');
        }
        //die('here');
        /*if ($ride_sess['step'] == 2 && $this->ion_auth->logged_in()) {
            $user = $this->ion_auth->user()->row();
            $this->load->model('payu_model');
            $post_data = array('txnid' => $ride_sess['order_id'], 'amount' => $ride_sess['basic'],
                'firstname' => $user->first_name, 'email' => $user->email,
                'phone' => $user->phone, 'productinfo' => $ride_sess['type'] . ' ' . $ride_sess['ride_name']
            );
            $pg_form_data = $this->payu_model->post_data($post_data);

            $data['posted'] = $pg_form_data;
            $data['title'] = ucfirst($page); // Capitalize the first letter
            $this->load->view('templates/header', $data);
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->unset_userdata('ride');
            redirect('/faliure');
        }*/
    }

    function thankyou() {
        $ride_sess = $this->session->userdata('ride');
        $page = 'thankyou';
        //print_r($_POST);                

        if (!file_exists(APPPATH . '/views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }
        $this->config->load('payu');
        $SALT = $this->config->item('salt');

        $status = $_POST["status"];
        $firstname = $_POST["firstname"];
        $amount = $_POST["amount"];
        $txnid = $_POST["txnid"];
        $posted_hash = $_POST["hash"];
        $key = $_POST["key"];
        $productinfo = $_POST["productinfo"];
        $email = $_POST["email"];
        $retHashSeq = $SALT . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        $hash = hash("sha512", $retHashSeq);
        $this->load->model('booking_model');
        $book_ids = explode('-', $txnid);
        $this->booking_model->updateOrder($book_ids[1], array('payment_status' => $status));

        if (empty($ride_sess['order_id'])) {
            redirect('/', 'refresh');
        }

        $bookData = $this->booking_model->getBookingDetails($ride_sess['order_id']);
        $data['book_data'] = $bookData;
        $user = $this->ion_auth->user()->row();

        $this->load->model('sendemails_model');
        $this->load->model('sendsms_model');
        $email_data = array('username' => $user->first_name, 'order_id' => $bookData->order_id, 'order_date' => date('d-n-Y h:i a', strtotime($bookData->cdate)),
            'ride_name' => $bookData->ride_name, 'ride_type' => $bookData->rent_type,
            'ride_from' => $bookData->from_city, 'ride_to' => $bookData->to_city,
            'pickup_date' => date('d-n-Y', strtotime($bookData->pickup_datetime)), 'pickup_time' => date('h:i a', strtotime($bookData->pickup_datetime)),
            'numbers_days' => $bookData->days, 'numbers_ride' => $bookData->rides,
            'basic_fare' => $bookData->basic, 'advance_fare' => $bookData->basic,
            'balance_fare' => $bookData->due, 'total_fare' => $bookData->total
        );

        //user notify email
        $this->sendemails_model->htmlmail($user->email, 'Your Order place with Pin A Ride', 'order', $email_data);
        //admin notify
        $this->sendemails_model->htmlmail(NOTIFY_EMAIL, 'Order place with Pin A Ride', 'order', $email_data);
        $sms_data = array('order_id' => $bookData->order_id);
        $this->sendsms_model->sendmsg($user->phone, 'order_thanks', $sms_data);
        $this->session->unset_userdata('ride');
        $data['user'] = $user;
        $data['js_files'] = array('thankyou');
        $data['title'] = ucfirst($page); // Capitalize the first letter
        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }
    
    function cancel_order() {
        $config = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email'
            ),
            array(
                'field' => 'orderid',
                'label' => 'Order ID',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'reason',
                'label' => 'Reason',
                'rules' => 'trim|required'
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('result' => 'error', 'error_msg' => $this->form_validation->error_array()));
        } else {
            $orderId = $this->input->post('orderid');
            $email = $this->input->post('email');
            $reason = $this->input->post('reason');
            $bookData = array();

            $this->load->model('booking_model');

            $bookData = $this->booking_model->getBookingDetails($orderId);
            //check if the users is same and the cancelation is not passed the booking date
            if (!empty($bookData->pickup_datetime) && $bookData->status != 0) {
                $pickupDate = strtotime($bookData->pickup_datetime);
                if ($bookData->email != $email) {
                    echo json_encode(array('result' => 'error', 'error_resp' => "Invalid email"));
                    return false;
                }
                if ($pickupDate < strtotime('now')) {
                    echo json_encode(array('result' => 'error', 'error_resp' => "Orders has been completed"));
                    return false;
                }
                //update booking table
                $this->booking_model->updateBooking($orderId, array('status' => 'Cancelled', 'reason' => $reason, 'cancelled_date' => date('Y-m-d h:i:s', strtotime('now'))));
                //send an email about order cancellation
                $this->load->model('sendemails_model');
                $email_data = array('username' => $bookData->first_name, 'order_id' => $orderId);
                $this->sendemails_model->htmlmail($bookData->email, 'Pin A Ride, Order ' . $orderId . ' Cancelled', 'cancellation', $email_data);
                echo json_encode(array('result' => 'success'));
            } else {
                echo json_encode(array('result' => 'error', 'error_resp' => "Invalid Order please check history"));
            }
        }
    }

    function cancellation() {

        $page = 'cancellation';

        if (!file_exists(APPPATH . '/views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }
        $email = '';
        if ($this->ion_auth->logged_in()) {
            $user = $this->ion_auth->user()->row();
            $email = $user->email;
        }

        $data['email'] = $email;
        $data['js_files'] = array('cancellation');
        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['seo_title'] = 'Car and Cab Rental Services in Mumbai | Mumbai to Pune';
        $data['seo_desc'] = 'If you have any genuine Reason for Cancelling your trip then Pin A ride give you that facility. Get Car and Cab Rental Services in Mumbai, Pune.';
        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    function history() {
        $page = 'history';
        $user_type = '';
        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }
        $this->load->model('booking_model');
        $user = $this->ion_auth->user()->row();
        $user_groups = $this->ion_auth->get_users_groups($user->id)->row();
        $data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $bookList = array();
        $data['group_id'] = $user_groups->id;
        switch ($user_groups->id) {
            case 2:
                $user_type = 'users';
                $bookList = $this->booking_model->getAllBooking("", array('user_id' => $user->id), "cdate", "desc", PER_PAGE, $data['page']);
                $config['total_rows'] = $this->booking_model->getBookingCount(array('user_id' => $user->id));
                break;
            case 3:
                $user_type = 'vendors';
                $bookList = $this->booking_model->getAllBooking("", array('vendor_id' => $user->id), "cdate", "desc", PER_PAGE, $data['page']);
                $config['total_rows'] = $this->booking_model->getBookingCount(array('user_id' => $user->id));
                break;
            default:
                show_404();
                break;
        }
        if (!file_exists(APPPATH . '/views/' . $user_type . '/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }
        $this->load->library("pagination");
        //pagination settings
        $config['base_url'] = site_url('history');
        $config['per_page'] = PER_PAGE;
        $config["uri_segment"] = 2;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        //print_r($config);
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();

        $data['js_files'] = array('history');
        $data['total_rows'] = $config['total_rows'];
        $data['book_list'] = $bookList;
        $data['title'] = ucfirst($page); // Capitalize the first letter
        $this->load->view('templates/header', $data);
        $this->load->view($user_type . '/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

}
