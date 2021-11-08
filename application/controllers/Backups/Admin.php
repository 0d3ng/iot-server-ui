<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('admin_m');
		//$this->load->model('aes_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Administrator data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Administrator data deleted failed";	
		if($this->input->get('alert')=='success2') $data['success']='Administrator activation successfully';	
		if($this->input->get('alert')=='failed2') $data['error']="Administrator activation failed";
		if($this->input->get('alert')=='success3') $data['success']='Administrator suspend successfully';	
		if($this->input->get('alert')=='failed3') $data['error']="Administrator suspend failed";
		$data['title']='Administrator List';
		$data['data'] = $this->admin_m->search(array())->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		
		$this->load->view('admin_v', $data);
	}

	public function add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Administrator Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"name" => $this->input->post('name'),
				"phone" => $this->input->post('phone'),
				"username" => $this->input->post('username'),
				"password" => $this->input->post('password'),
				"email" => $this->input->post('email'),
				"role" => "admin",
				"status" => 1,
				"add_by" => $data['user_now']->id,
				"business_access" => $this->input->post('business'),
				"operational_access" => $this->input->post('operational')
        	);
        	
        	if($this->input->post('sendmail')){
        		$input+=['sendmail'=>true];
        	}
        	$respo = $this->admin_m->add($input);
        	
        	
            if($respo->code == "B00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('admin_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Administrator Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){   
			$business = 0;
			if($this->input->post('business'))
				$business = $this->input->post('business');

			$operational = 0;
			if($this->input->post('business'))
				$operational = $this->input->post('operational');

        	$input = array(
        		"name" => $this->input->post('name'),
				"phone" => $this->input->post('phone'),
				"email" => $this->input->post('email'),
				"business_access" => $business,
				"operational_access" => $operational
        	);
        	$respo = $this->admin_m->edit($id,$input);
            if($respo->code == "B00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->admin_m->get_detail($id)->data[0];        
		$data['id'] = $id;
		$this->load->view('admin_edit_v', $data);
	}			

	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->admin_m->del($id);
			if($del->code == "B00"){
				redirect(base_url().'admin/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'admin/?alert=failed') ; 			
	}
	
	public function active($id=''){

        $del = $this->admin_m->status($id,'active');
        if($del->code == "B00"){         
            redirect(base_url().'admin/?alert=success2');
        }
        redirect(base_url().'admin/?alert=failed2');
    }

    public function nonactive($id=''){

        $del = $this->admin_m->status($id,'not-active');
        if($del->code == "B00"){           
            redirect(base_url().'admin/?alert=success3');
        }
        redirect(base_url().'admin/?alert=failed3');
    }

    public function myprofile(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'My Profile Setting';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"username" => $this->input->post('username'),
        		"name" => $this->input->post('name'),
				"phone" => $this->input->post('phone'),
				"email" => $this->input->post('email')
        	);
        	$respo = $this->admin_m->edit(number_format($data['user_now']->admin_id,0,'',''),$input);
            if($respo->code == "B00"){
            	$role = $data['user_now']->user_role;
            	$data['user_now'] = $this->admin_m->get_detail(number_format($data['user_now']->admin_id,0,'',''))->data[0];
            	$array = (array) $data['user_now']; 
                $array["user_role"] = $role;
                $data['user_now'] = (object) $array;
                $this->session->set_userdata('easy_admin',$data['user_now']);             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }                
		$this->load->view('profile_v', $data);
	}

	public function setting(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Password Setting';
		$data['user_now'] = $this->session->userdata('easy_admin');	
		if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('old_password', 'Old Password', 'required');
			$this->form_validation->set_rules('password', 'New Password', 'required|matches[passconf]|min_length[6]');
			$this->form_validation->set_rules('passconf', 'Konfirmasi password', 'required');
			if ($this->form_validation->run() == FALSE){
				$data['error'] = trim(validation_errors());
			}
		    else{
		    	$input=array(
					'password' => $this->input->post('password'),
					'oldpassword' => $this->input->post('old_password')
				);
				$respo = $this->admin_m->update_pass(number_format($data['user_now']->admin_id,0,'',''),$input);
				if($respo->code == "B00"){				
					$data['success']=$respo->message;					
				} else {				
					$data['error']=$respo->message;
				}						
		    }
		    // print_r($data);
		    // exit();
		}
		$this->load->view('user_setting_v', $data);
	}	
    
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
