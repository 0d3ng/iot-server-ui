<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class authuser extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_m');
    }

    public function login() {
        if ($this->session->userdata('easy_admin')) {
            redirect(base_url());
        }
        $data['error'] = FALSE;
        $this->load->view('customer_login_v',$data);
    }

    public function dologin() {
        if ($this->session->userdata('easy_admin')) {
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $data['error'] = FALSE;
        $data['role'] = "Customer";
        //#1 Set Form Validation
        $this->form_validation->set_rules('email', 'Username', 'xss_clean|required|trim');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|required|trim');                       
        if ($this->form_validation->run($this) == FALSE) {
            //#2 Display Error Message
            $data['error'] = validation_errors();
        } else {
            $email = $this->input->post("email");
            $pass = $this->input->post('password');
            $respo = $this->customer_m->login($email, $pass);
            $role = "Customer";
            if($respo->code == "00"){
                $array = (array) $respo->data[0]; 
                $array["user_role"] = "Customer";
                $respo->data = (object) $array;
                $this->session->set_userdata('easy_admin',$respo->data);              
                redirect(base_url('user'));                           
            } else {
                $data['error'] = $respo->message;                
            }
        }
        $this->load->view('customer_login_v', $data);
    }

    public function forgotpass() {
        if ($this->session->userdata('easy_admin')) {
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $data['error'] = FALSE;
        $data['success'] = FALSE;
        if($this->input->post('save')){
            $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|trim');               
            if ($this->form_validation->run($this) == FALSE) {
                $data['error'] = validation_errors();
            } else {
                $email = $this->input->post('email');
                $role = $this->input->post('role');
                $updates = array('email'=> $email, 'url'=>base_url().'authuser/resetpass');                                                
                $respo = $this->customer_m->reset_password($updates);                
                if($respo->code == "00"){                                       
                    $data['success'] = $respo->message;
                }else{
                    $data['error'] =  $respo->message;
                }
            }            
        }
        $this->load->view('customer_forgotpass_v', $data);            
    }
    
    public function resetpass($email='', $token=''){      
        if ($this->session->userdata('easy_admin')) {
            redirect(base_url());
        }              
        $data['success'] = false;
        $data['error'] =  false;   
        $email = str_replace( md5('@'),"@", $email);
        $data['email'] = $email;
        $data['token'] = $token;
        if( ! ($email) && ($token)){             
            $data['error'] = "Your Activation Link was Wrong";
        }        
        if($this->input->post('save')){            
            $this->load->library('form_validation');            
            $this->form_validation->set_rules('password', 'New Password', 'required|matches[passconf]|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Confirmation password', 'required');
            if ($this->form_validation->run() == FALSE){
                $data['error'] = validation_errors();
            }
            else{
                $input=array(
                    'password' => $this->input->post('password'),
                    'email'=> $email, 
                    'otp'=>$token                    
                );              
                $respo = $this->customer_m->reset_password($input);          
                if($respo->code == "00" ){             
                    $data['success']=$respo->message;                  
                } else {                
                    $data['error']=$respo->message;
                }                       
            }
        }
        $data['role'] = 'Customer'; 
        $this->load->view('user_resetpass_v', $data);
    }

    public function logout(){       
         $this->session->set_userdata('easy_admin');
         $this->session->set_userdata('easy_admin_role');
         redirect(base_url('authuser/login'));
    }

    public function register() {
        $this->load->library('form_validation');
        $data['error'] = FALSE;
        $data['success'] = FALSE;
        //#1 Set Form Validation
        // $this->form_validation->set_rules('username', 'Username', 'xss_clean|required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Confirmation password', 'required');               
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|trim');  
        if ($this->form_validation->run($this) == FALSE) {
            //#2 Display Error Message
            $data['error'] = validation_errors();
        } else {
            $input = array(
                'password' => $this->input->post('password'),
                'email' => $this->input->post('email'),
                'name' => $this->input->post('name'),
                'url' => base_url().'authuser/activation'
            );
            $respo = $this->customer_m->add($input);
            if($respo->code == 'E00'){       
                $data['success']  = "Registration Succes, please check your email for verification process.";                        
            } else{
                $data['error'] = $respo->message;
            }
            
      
        }        
        $this->load->view('customer_register_v', $data);
    }

     public function activation($email='', $token=''){      
        if ($this->session->userdata('easy_admin')) {
            redirect(base_url());
        }              
        $data['success'] = false;
        $data['error'] =  false;  
        $email = str_replace( md5('@'),"@", $email);
        $data['email'] = $email;
        $data['token'] = $token;
        if( ! ($email) && ($token)){             
            $data['error'] = "Your Activation Link was Wrong";
        }
                      
        if($this->input->post('save')){           
            $this->load->library('form_validation');            
            $this->form_validation->set_rules('ktp', 'KTP', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            if ($this->form_validation->run() == FALSE){
                $data['error'] = trim(validation_errors());
            }else{
                $input=array(
                    'phone'=> $this->input->post('phone'), 
                    'ktp'=>$this->input->post('ktp') ,
                    'status' => 1                   
                );
                $s = $this->customer_m->search(array('email'=>$email))->data[0];
                $respo = $this->customer_m->edit(number_format($s->customer_id,0,'',''),$input);          
                if($respo->code == "E00" ){             
                    $data['success']="Activation account successfully";
                    $respo = $this->customer_m->search(array('email'=>$data['email'])); 
                    $array = (array) $respo->data[0]; 
                    $array["user_role"] = "Customer";
                    $respo->data = (object) $array;
                    $this->session->set_userdata('easy_admin',$respo->data);             
                    redirect(base_url('user'));                   
                } else {                
                    $data['error']=$respo->message;
                }                        
            }
        } else {
            $input=array(
                'email'=> $email, 
                'token'=>$token,
                'check'=> true                    
            );
            $respo = $this->customer_m->activation($input);          
            if($respo->code == "E00" ){             
                $data['success']="Activation Link Valid";                  
            } else {                
                $data['error']=$respo->message;
                $data['invalid'] = True;
            }
        }    
        $this->load->view('customer_activation_v', $data);
    }

}

/* End of file  */
/* Location: ./application/controllers/ */
