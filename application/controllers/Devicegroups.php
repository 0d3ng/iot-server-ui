<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Devicegroups extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
        $this->load->model('groupsensor_m');
		$this->load->model('device_m');
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
    }

	public function index(){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete device group sensor successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete device group";	
		$data['title']='Device Group List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');
        $data['group'] = [];
		$group = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
        $groupcode = array();
        foreach ($group as $key) {
            $groupcode[] = $key->group_code;
            $data['group'][$key->group_code] = $key;
        }
        $groupcode = array(
            '$in' => $groupcode
        );
        $data["data_personal"] = array();
        $data["data_group"] = array();
        $data_personal = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "group_type"=>"personal"));
        $data_group = $this->groupsensor_m->search(array("group_code"=>$groupcode, "group_type"=>"group"));
		if($data_personal->status){
            $data["data_personal"] = $data_personal->data;
        }
        if($data_group->status){
            $data["data_group"] = $data_group->data;
        }
        $data['device_m'] = $this->device_m;
  //       echo "<pre>";
  //       print_r($groupcode);
  //       print_r($data);
  //       echo "</pre>";
		// exit();
        $this->load->view('device_group_v', $data);
	}

	public function add(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Device Group Add';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        $data['group'] = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
		if($this->input->post('save')){        	
        	$type = $this->input->post('type');
            $groupcode = '';
            if($type == "group"){
                $groupcode = $this->input->post('group');
            } 
            if(empty($this->input->post('http_post')))
                $http_post = false;
            else 
                $http_post = true;
            if(empty($this->input->post('mqtt')))
                $mqtt = false;
            else 
                $mqtt = true;
            if(empty($this->input->post('nats')))
                $nats = false;
            else 
                $nats = true;
            if(empty($this->input->post('kafka')))
                $kafka = false;
            else 
                $kafka = true;
            
            $input = array(
        		"name" => $this->input->post('name'),
				"add_by" => $data['user_now']->id,
        	    "active" => true,
                "group_type"=>$type,
                "group_code"=>$groupcode,
                "information" => array(
                        "location" => $this->input->post('location'),
                        "detail" => $this->input->post('detail'),
                        "purpose" => $this->input->post('purpose'),
                    ),
                "communication" => array(
                        "http-post" => $http_post,
                        "mqtt" => $mqtt,
                        "nats" => $nats,
                        "kafka" => $kafka
                    )
            );
        	$respo = $this->groupsensor_m->add($input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }   
        }
		$this->load->view('device_group_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Group Edit';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        $data['group'] = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
		if($this->input->post('save')){    
            $idgrup = $this->input->post('id');
        	$type = $this->input->post('type');
            $groupcode = '';
            if($type == "group"){
                $groupcode = $this->input->post('group');
            } 
            if(empty($this->input->post('http_post')))
                $http_post = false;
            else 
                $http_post = true;
            if(empty($this->input->post('mqtt')))
                $mqtt = false;
            else 
                $mqtt = true;
            if(empty($this->input->post('nats')))
                $nats = false;
            else 
                $nats = true;
            if(empty($this->input->post('kafka')))
                $kafka = false;
            else 
                $kafka = true;
            $input = array(
                "name" => $this->input->post('name'),
                "updated_by" => $data['user_now']->id,
                "group_type"=>$type,
                "group_code"=>$groupcode,
                "information" => array(
                        "location" => $this->input->post('location'),
                        "detail" => $this->input->post('detail'),
                        "purpose" => $this->input->post('purpose'),
                    ),
                "communication" => array(
                        "http-post" => $http_post,
                        "mqtt" => $mqtt,
                        "nats" => $nats,
                        "kafka" => $kafka
                    )
            );
        	$respo = $this->groupsensor_m->edit($idgrup,$input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->groupsensor_m->get_detail($id)->data;        
		$data['id'] = $id;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
		$this->load->view('device_group_edit_v', $data);
	}		

	public function delete($id){       
		if($id){  
        	$respo = $this->groupsensor_m->del($id);
            if($respo->status){             
				redirect(base_url().'devicegroups/?alert=success') ; 			
            } else {                
				redirect(base_url().'devicegroups/?alert=failed') ; 			
            }                       
        }        
		redirect(base_url().'devicegroups/?alert=failed') ; 			
	}	

    public function groups($group_code){        
        $data=array();
        $data['success']='';
        $data['error']='';
        if($this->input->get('alert')=='success') $data['success']='Delete group sensor successfully';  
        if($this->input->get('alert')=='failed') $data['error']="Failed to delete Group Sensor";    
        $data['title']='Device Group List';
        $data['user_now'] = $this->session->userdata('dasboard_iot');
        $data['group'] = $this->group_m->get_detail($group_code)->data;
        $data["data_group"] = array();
        $data_group = $this->groupsensor_m->search(array("group_code"=>$group_code, "group_type"=>"group"));
        if($data_group->status){
            $data["data_group"] = $data_group->data;
        }
        $data['device_m'] = $this->device_m;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $this->load->view('device_group_group_v', $data);
    }

    public function data($id){       
        $data=array();
        $data['success']='';
        $data['error']='';
        $data['title']= 'Group Edit';       
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $data['group'] = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
        $data['data'] = $this->groupsensor_m->get_detail($id)->data;        
        $this->load->view('device_group_data_v', $data);
    }

    public function list($index){        
        $data=array();
        $data['user_now'] = $this->session->userdata('dasboard_iot');
        $data['group'] = [];
        $group = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
        $groupcode = array();
        foreach ($group as $key) {
            $groupcode[] = $key->group_code;
            $data['group'][$key->group_code] = $key;
        }
        $groupcode = array(
            '$in' => $groupcode
        );
        $data["data_personal"] = array();
        $data["data_group"] = array();
        $data_personal = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "group_type"=>"personal"));
        $data_group = $this->groupsensor_m->search(array("group_code"=>$groupcode, "group_type"=>"group"));
        if($data_personal->status){
            $data["data_personal"] = $data_personal->data;
        }
        if($data_group->status){
            $data["data_group"] = $data_group->data;
        }
        $data['index'] = $index;
        $this->load->view('device_group_list_v', $data);
    }

    public function addIndex($id){       
        $data=array();
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $data['data'] = $this->groupsensor_m->get_detail($id);   
        if($data['data']->status){
            $idgrup = $data['data']->data->id; 
            $input = array(
                "view_dashboard" => true,
            );
            $respo = $this->groupsensor_m->edit($idgrup,$input);
            if($respo->status){             
                echo true;
            } else {                
                echo false;
            }      
        } else {
            echo false;
        }
    }   

    public function removeIndex($id){       
        $data=array();
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $data['data'] = $this->groupsensor_m->get_detail($id);        
        if($data['data']->status){
            $idgrup = $data['data']->data->id; 
            $input = array(
                "view_dashboard" => false,
            );
            $respo = $this->groupsensor_m->edit($idgrup,$input);
            if($respo->status){             
                echo true;
            } else {                
                echo false;
            }      
        } else {
            echo false;
        }
    }
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
