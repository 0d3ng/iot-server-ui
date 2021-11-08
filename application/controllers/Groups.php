<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
		$this->load->model('groupsensor_m');
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
    }

	public function index(){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Leave groups successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to leave groups";	
		$data['title']='Group List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');		        
		$group = $this->group_m->search(array("user_id"=>$data['user_now']->id));
		$data['data'] = array();
		if($group->status){
			$data['data'] = $group->data;
		}
		$data['groupsensor_m'] = $this->groupsensor_m;
		$this->load->view('group_v', $data);
	}

	public function add(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Group Add';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');		
		if($this->input->post('save')){        	
        	$input = array(
        		"name" => $this->input->post('name'),
				"email" => $this->input->post('email'),
				"add_by" => $data['user_now']->id
        	);
        	$respo = $this->group_m->add($input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('group_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Group Edit';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
		if($this->input->post('save')){        	
        	$idgrup = $this->input->post('id');
        	$input = array(
        		"name" => $this->input->post('name'),
				"email" => $this->input->post('email'),
        	);
        	$respo = $this->group_m->edit($idgrup,$input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->group_m->get_detail($id)->data;        
		$data['id'] = $id;
		$this->load->view('group_edit_v', $data);
	}		

	public function member($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Group Member';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        $data['data'] = $this->group_m->get_detail($id)->data;   
        $list = array();
        $data['role'] = array();
        foreach ($data['data']->member as $key) {
            $list[] = $key->user_id;
            $data['role'][$key->user_id] = $key->role;
        }  
        $data['member'] = $this->user_m->search(array("list"=>$list))->data;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();  
		$data['id'] = $id;
		$this->load->view('group_member_v', $data);
	}	

	public function ajax_member($id){       
		$data=array();
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        $data['data'] = $this->group_m->get_detail($id)->data;   
        $list = array();
        $data['role'] = array();
        foreach ($data['data']->member as $key) {
            $list[] = $key->user_id;
            $data['role'][$key->user_id] = $key->role;
        }  
        $data['member'] = $this->user_m->search(array("list"=>$list))->data;
		$data['id'] = $id;
		$this->load->view('group_member_ajax_v', $data);
	}	

	public function leave($id){       
		if($id){  
			$data = $this->session->userdata('dasboard_iot');	
        	$input = array(
        		"id" => $id,
				"user_id" => $data->id,
        	);
        	$respo = $this->group_m->removeMember($input);
            if($respo->status){             
				redirect(base_url().'groups/?alert=success') ; 			
            } else {                
				redirect(base_url().'groups/?alert=failed') ; 			
            }                       
        }        
		redirect(base_url().'groups/?alert=failed') ; 			
	}	

	public function ajax_remove_member(){       
		if($this->input->post('group')){   
        	$input = array(
        		"user_id" => $this->input->post('id'),
				"id" => $this->input->post('group')
        	);
        	$respo = $this->group_m->removeMember($input);
            if($respo->status){             
                echo 'success';                  
            } else {                
                echo 'error';
            }                       
        } else {
        	echo "error";
        }			
	}

	public function ajax_search_member(){       
		if($this->input->post('email')){   
			$data = $this->session->userdata('dasboard_iot');	
        	$input = array(
				"email" => $this->input->post('email')
        	);
        	$respo = $this->user_m->search($input);
            if($respo->status){             
				echo json_encode(
					array(
						'name' => $respo->data[0]->name,
						'id' =>  $respo->data[0]->id
					)
				);			
            }                    
        }         			
	}

	public function ajax_add_member(){ 
		if($this->input->post('group')){   
        	$input = array(
        		"user_id" => $this->input->post('id'),
				"id" => $this->input->post('group')
        	);
        	$respo = $this->group_m->addMember($input);
            if($respo->status){             
                echo 'success';                  
            } else {                
                echo 'error';
            }                       
        } else {
        	echo "error";
        }
	}			

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
