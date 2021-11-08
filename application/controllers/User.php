<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_m');
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
	}
	
	public function index(){        
		$data=array();
		$data['title']='Main Page';
		$data['user_now'] = $this->session->userdata('dasboard_iot');
		$this->load->view('index', $data);
	}	

	 public function profile(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Profile Setting';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');				
		if($this->input->post('save')){        	
        	$input = array(
        		"name" => $this->input->post('name'),
				"email" => $this->input->post('email')
        	);
        	$respo = $this->user_m->edit($data['user_now']->id,$input);
            if($respo->status){
            	$data['user_now'] = $this->user_m->get_detail($data['user_now']->id)->data;
                $this->session->set_userdata('dasboard_iot',$data['user_now']);             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }                
		$this->load->view('user_profile_v', $data);
	}

	public function setting(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Password Setting';
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
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
				$respo = $this->user_m->edit_pass($data['user_now']->id,$input);
				if($respo->status){				
					$data['success']=$respo->message;					
				} else {				
					$data['error']=$respo->message;
				}						
		    }
		}
		$this->load->view('user_setting_v', $data);
	}	

	function upload_file($file,$path = "assets/img/tmp/"){
		$fcpath = FCPATH;
		$fcpath = str_replace('\\', '/', $fcpath);
		$file_path = $path.basename($_FILES[$file]['name']);
        $cfile = curl_file_create($file_path,'image/jpeg',$_FILES[$file]['name']);
        if(move_uploaded_file($_FILES[$file]['tmp_name'], $file_path)) {
        	return $fcpath.$file_path;
        } else {
        	return false;
        }
	}
}

/* End of file  */
/* Location: ./application/controllers/ */
