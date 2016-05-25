<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payu_model extends CI_Model {
	public function __construct()
	{
		//$this->load->database();
		parent::__construct();		
	}
        
        public function post_data($posted) {
            $pg_data = array();
            $this->config->load('payu');
            $MERCHANT_KEY = $this->config->item('merchant_key');
            $SALT = $this->config->item('salt');
            $BASE_URL = $this->config->item('pg_base_url');
            $SURL = $this->config->item('surl');
            $FURL = $this->config->item('furl');
            $PROVIDER = $this->config->item('service_provider');
            $hash = '';
            // Hash Sequence
            $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
            $posted['key'] = $MERCHANT_KEY;
            $posted['surl'] = $SURL;
            $posted['furl'] = $FURL;
            $posted['service_provider'] = $PROVIDER;
            
            if( empty($posted['txnid']) || empty($posted['amount']) 
                || empty($posted['email'])  || empty($posted['phone'])
                || empty($posted['productinfo']) || empty($posted['firstname'])) {
                
                return false;
                
            } else {
                $hashVarsSeq = explode('|', $hashSequence);
                $hash_string = '';	
                foreach($hashVarsSeq as $hash_var) {
                  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                  $hash_string .= '|';
                }
                
                $hash_string .= $SALT;
                $hash = strtolower(hash('sha512', $hash_string));
                $action = $BASE_URL . '/_payment';
            }
            
            $pg_data['key'] = $posted['key'];
            $pg_data['hash'] = $hash;
            $pg_data['txnid'] = $posted['txnid'];
            $pg_data['amount'] = $posted['amount'];
            $pg_data['firstname'] = $posted['firstname'];
            $pg_data['email'] = $posted['email'];
            $pg_data['phone'] = $posted['phone'];
            $pg_data['productinfo'] = $posted['productinfo'];
            $pg_data['surl'] = $posted['surl'];
            $pg_data['furl'] = $posted['furl'];
            $pg_data['pg'] = $posted['service_provider'];
            $pg_data['action'] = $action;
            
            return $pg_data;
        }        
        
}
	