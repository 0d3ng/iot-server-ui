<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
        $this->load->model('groupsensor_m');
		$this->load->model('device_m');
        $this->limit_data = 50;
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
    }

	public function index(){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete device successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete device";	
		$data['title']='Device Group List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');
        $device_groupcode = array();

        $type = $this->input->get('type');
        if(empty($type))
            $type = 'all';
        $data['device_group'] = [];
        ////get goup////
        $data['group'] = [];        
        $group = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
        $groupcode = array();
        foreach ($group as $key) {
            $groupcode[] = $key->group_code;
            $data['group'][$key->group_code] = $key;
        }        
        ///end get goup////
        ////get device from group///
        $groupcode = array(
            '$in' => $groupcode
        );
        $data_group = $this->groupsensor_m->search(array("group_code"=>$groupcode, "group_type"=>"group"));     
        if($data_group->status){
            $data_group = $data_group->data;
            foreach ($data_group as $key) {
                $device_groupcode[] = $key->code_name;
                $data['device_group'][$key->code_name] = $key;
            }
        }
        //end get device from group///
        ////get device from personal ///
        $data_personal = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "group_type"=>"personal"));
        if($data_personal->status){
            $data_personal = $data_personal->data;
            foreach ($data_personal as $key) {
                $device_groupcode[] = $key->code_name;
                $data['device_group'][$key->code_name] = $key;
            }
        }            
        ////end get device from personal ///
        if($type == "all"){            
            $device_groupcode = array(
                '$in' => $device_groupcode
            );
        } else {
            $device_groupcode = $type;
        }
        $data["data"] =  $this->device_m->search(array("group_code_name"=>$device_groupcode))->data;
        $data['type'] = $type;
  //       echo "<pre>";
  //       print_r($device_groupcode);
  //       print_r($data);
  //       echo "</pre>";
		// exit();
        $this->load->view('device_v', $data);
	}

	public function add(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Device Add';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        $data['device_group'] = array();
        ////get goup////
        $data['group'] = [];        
        $group = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
        $groupcode = array();
        foreach ($group as $key) {
            $groupcode[] = $key->group_code;
            $data['group'][$key->group_code] = $key;
        }        
        ///end get goup////
        ////get device from group///
        $groupcode = array(
            '$in' => $groupcode
        );
        $data_group = $this->groupsensor_m->search(array("group_code"=>$groupcode, "group_type"=>"group"));     
        if($data_group->status){
            $data_group = $data_group->data;
            $data['device_group'] = array_merge($data['device_group'],$data_group);
        }
        //end get device from group///
        ////get device from personal ///
        $data_personal = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "group_type"=>"personal"));
        if($data_personal->status){
            $data_personal = $data_personal->data;
            $data['device_group'] = array_merge($data['device_group'],$data_personal);
        } 
		if($this->input->post('save')){  
            $field = json_decode($this->input->post('field'));      	
            $input = array(
        		"name" => $this->input->post('name'),
				"add_by" => $data['user_now']->id,
        	    "active" => true,
                "group_code_name"=>$this->input->post('group'),
                "information" => array(
                        "location" => $this->input->post('location'),
                        "detail" => $this->input->post('detail'),
                        "purpose" => $this->input->post('purpose'),
                    ),
                "field" => $field
            );
            // echo "<pre>";
            // print_r($input);
            // echo "</pre>";
            // exit();
        	$respo = $this->device_m->add($input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('device_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Device Edit';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        $data['device_group'] = array();
        ////get goup////
        $data['group'] = [];        
        $group = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
        $groupcode = array();
        foreach ($group as $key) {
            $groupcode[] = $key->group_code;
            $data['group'][$key->group_code] = $key;
        }        
        ///end get goup////
        ////get device from group///
        $groupcode = array(
            '$in' => $groupcode
        );
        $data_group = $this->groupsensor_m->search(array("group_code"=>$groupcode, "group_type"=>"group"));     
        if($data_group->status){
            $data_group = $data_group->data;
            $data['device_group'] = array_merge($data['device_group'],$data_group);
        }
        //end get device from group///
        ////get device from personal ///
        $data_personal = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "group_type"=>"personal"));
        if($data_personal->status){
            $data_personal = $data_personal->data;
            $data['device_group'] = array_merge($data['device_group'],$data_personal);
        } 
		if($this->input->post('save')){    
            $iddevice = $this->input->post('id');
            $field = json_decode($this->input->post('field'));          
            $input = array(
                "name" => $this->input->post('name'),
                "updated_by" => $data['user_now']->id,
                "group_code_name"=>$this->input->post('group'),
                "information" => array(
                        "location" => $this->input->post('location'),
                        "detail" => $this->input->post('detail'),
                        "purpose" => $this->input->post('purpose'),
                    ),
                "field" => $field
            ); 
            $respo = $this->device_m->edit($iddevice,$input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                     
        }
        $data['data'] = $this->device_m->get_detail($id)->data;        
		$data['id'] = $id;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
		$this->load->view('device_edit_v', $data);
	}		

	public function delete($id){       
		if($id){  
        	$respo = $this->device_m->del($id);
            if($respo->status){             
				redirect(base_url().'device/?alert=success') ; 			
            } else {                
				redirect(base_url().'device/?alert=failed') ; 			
            }                       
        }        
		redirect(base_url().'device/?alert=failed') ; 			
	}	

    public function data($id){       
        $data=array();
        $data['success']='';
        $data['error']='';
        $data['title']= 'Device Data';       
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $data['data'] = $this->device_m->get_detail($id)->data; 
        $data['group'] = $this->groupsensor_m->get_detail($data['data']->group_code_name)->data;  
        $data['extract'] = $this->extract($data['data']->field);
        $query = array(
            'limit' => $this->limit_data
        );
        $data['limit_data'] = $this->limit_data;
        $data['sensor'] = $this->device_m->datasensor($data['data']->device_code,$query)->data;
        $data['sensor'] = array_reverse((array)$data['sensor']);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $this->load->view('device_data_v', $data);
    }   

    function extract($list,$prefix=''){
        $return = array();
        for ($i = 0; $i < count($list); $i++) {
            $item = $list[$i];
            if(is_object($item)){
                foreach($item as $key=>$value) {
                    $listitem = $this->extract($value,$key);
                    $return = array_merge($return,$listitem); 
                }
            } else {
               $return[] = (!empty($prefix))?$prefix."-".$item:$item;
            }
        }
        return $return;
    }
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
