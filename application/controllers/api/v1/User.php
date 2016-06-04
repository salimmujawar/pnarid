<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->library(array('ion_auth','form_validation'));		
	}
        
        /**
	 * User login API
	 */
	public function login()
	{
		/*$users = $this->ion_auth->users()->result();
                foreach ($users as $k => $user) {
                        $data['unique_id'] = uniqid('', true);
                        $this->ion_auth->update($user->id, $data);
                }
                die;*/
                $tables = $this->config->item('tables','ion_auth');
                $response = array();
		$identity_column = $this->config->item('identity','ion_auth');
		$this->data['identity_column'] = $identity_column;
		$config = array(				
					array(
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'trim|required|valid_email'
					),
					array(
							'field' => 'password',
							'label' => 'Password',
							'rules' => 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']',
					),
					
						
			);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
		{
                    $response["error"] = TRUE;
                    $response["error_msg"] = $this->form_validation->error_array();                         
		}
		else
		{
			if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password')))
			{	
				
                                $user = $this->ion_auth->user()->row();
                                $response["error"] = FALSE;
                                $response["uid"] = $user->unique_id;
                                $response["user"]["name"] = $user->first_name;
                                $response["user"]["email"] = $user->email;
                                $response["user"]["created_at"] = date('Y-m-d h:i:s', $user->created_on );
                                $response["user"]["updated_at"] = NULL;				
			}
			else
			{
                            $response["tag"] = 'login';
                            $response["error"] = TRUE;
                            $response["success"] = FALSE;
                            $response["error_msg"] = 'Login credentials are incorrect. Please try again!'; 				
			}
		}
            header('Content-Type: application/json');
            echo json_encode($response);    
            die;
	}
        
        /**
	 * User register API
	 */
	public function register()
	{
		$tables = $this->config->item('tables','ion_auth');
		$identity_column = $this->config->item('identity','ion_auth');
		$this->data['identity_column'] = $identity_column;
		$config = array(
					array(
							'field' => 'name',
							'label' => 'Name',
							'rules' => 'trim|required|min_length[5]'
					),
					array(
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'trim|required|valid_email'
					),
					array(
							'field' => 'password',
							'label' => 'Password',
							'rules' => 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']',						
					),
					array(
							'field' => 'mobile',
							'label' => 'Mobile',
							'rules' => 'trim|required|numeric|min_length[10]|max_length[12]'
					),
					
			);
		$this->form_validation->set_rules($config);
                $response = array();
		if ($this->form_validation->run() == FALSE)
		{			
                        $response["error"] = 1;                        
                        $response["error_msg"] = 'Unknown error occurred in registration!!';	
		}
		else
		{
                    $email    = strtolower($this->input->post('email'));
                    $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
                    $password = $this->input->post('password');
                    $name     = explode(' ', $this->input->post('name'));            
                    $additional_data = array(
                                'first_name' => (!empty($name[0]))?$name[0]:'',
                                'last_name'  => (!empty($name[1]))?$name[1]:'',            		
                                'phone'      => $this->input->post('mobile'),
                                'address'    => (isset($_POST['address']))?$this->input->post('address'):'',
                    ); 
                    if($this->ion_auth->check_email_exist($email)) {
                        $response["error"] = 2;
                        $response["success"] = FALSE;
                        $response["error_msg"] = "User already existed with $email";	  
                    }else {
                        $id = $this->ion_auth->register($identity, $password, $email, $additional_data);
                        if($id) {                                       

                            //login user after signup                        
                            $user = $this->ion_auth->user($id)->row();
                            $response["error"] = FALSE;
                            $response["uid"] = $user->unique_id;
                            $response["user"]["name"] = $user->first_name;
                            $response["user"]["email"] = $user->email;
                            $response["user"]["created_at"] = date('Y-m-d h:i:s', $user->created_on );
                            $response["user"]["updated_at"] = NULL;	                        

                        }else{
                            $response["error"] = 1;                        
                            $response["error_msg"] = 'Unknown error occurred in registration!';
                        }
                    }
                    
		}
                
                header('Content-Type: application/json');
                echo json_encode($response);    
                die;
	}
}