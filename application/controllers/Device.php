<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
        $this->load->model('groupsensor_m');
		$this->load->model('device_m');
        $this->limit_data = 1000;
        $this->limit_table = 25;
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
    }

	public function index(){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete device successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete device";	
		$data['title']='Device List';
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
            $or = array();
            $or[] = array("group_code_name" =>$device_groupcode);
            $or[] = array("add_by" => $data['user_now']->id);
            $query = array(
                '$or' => $or
            );
        } else if($type == "other"){            
            $query = array(
                "add_by" => $data['user_now']->id
            );
        } else {
            $query = array(
                "group_code_name" =>$type
            );
        }
        $data["data"] =  $this->device_m->search($query)->data;
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
            $group_code = $this->input->post('group');    	
            $input = array(
        		"name" => $this->input->post('name'),
				"add_by" => $data['user_now']->id,
        	    "active" => true,
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
            if($group_code == "other"){
                if(empty($this->input->post('http_post')))
                    $http_post = false;
                else 
                    $http_post = true;
                if(empty($this->input->post('mqtt')))
                    $mqtt = false;
                else 
                    $mqtt = true;
                $input["communication"] = array(
                    "http-post" => $http_post,
                    "mqtt" => $mqtt,
                    "server" => $this->input->post('server'),
                    "port" => $this->input->post('port'),
                    "topic" => $this->input->post('topic')
                );
                $respo = $this->device_m->add_other($input);
            } else {
                $input["group_code_name"]=$group_code;
                $respo = $this->device_m->add($input);
            } 
        	
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
            $group_code = $this->input->post('group');         
            $input = array(
                "name" => $this->input->post('name'),
                "updated_by" => $data['user_now']->id,                
                "information" => array(
                        "location" => $this->input->post('location'),
                        "detail" => $this->input->post('detail'),
                        "purpose" => $this->input->post('purpose'),
                    ),
                "field" => $field
            );
            if($group_code == "other"){
                if(empty($this->input->post('http_post')))
                    $http_post = false;
                else 
                    $http_post = true;
                if(empty($this->input->post('mqtt')))
                    $mqtt = false;
                else 
                    $mqtt = true;
                $input["communication"] = array(
                    "http-post" => $http_post,
                    "mqtt" => $mqtt,
                    "server" => $this->input->post('server'),
                    "port" => $this->input->post('port'),
                    "topic" => $this->input->post('topic')
                );
                $respo = $this->device_m->edit_other($iddevice,$input);
            } else {
                $input["group_code_name"]=$group_code;
                $respo = $this->device_m->edit($iddevice,$input);
            } 
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

	public function delete($id,$other=""){       
		if($id){
            if($other){
                $respo = $this->device_m->del_other($id);
            } else {
        	    $respo = $this->device_m->del($id);
            } 
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
        $data['group'] = $this->groupsensor_m->get_detail($data['data']->group_code_name);
        if(!$data['group']->status)
            $data['group'] = [];
        else
            $data['group'] = $data['group']->data;
        $data['extract'] = $this->extract($data['data']->field);
        $data["date_str"] = date("Y-m-d");
        $data["date_end"] = date("Y-m-d");
        if($this->input->get('start'))
            $data["date_str"] = $this->input->get('start');
        if($this->input->get('end'))
            $data["date_end"] = $this->input->get('end');
        $data["search"] = $this->input->get('search');
        $query = array(
            'limit' => $this->limit_data
        );
        if($data["search"]){
            $query["date_start"] =  $data["date_str"];
            $query["date_end"] =  $data["date_end"];
        }
        $data['limit_data'] = $this->limit_data;
        $data['sensor'] = $this->device_m->datasensor($data['data']->device_code,$query)->data;
        if($data["search"]){
            $query = array(
                'limit' => 1
            );
            $last = $this->device_m->datasensor($data['data']->device_code,$query)->data;
            $data['lastdata'] = (!empty($last))?$last[0]:"";
        } else {
            $data['lastdata'] = (!empty($data['sensor']))?$data['sensor'][0]:"";
        } 
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

    public function table($id){       
        $data=array();
        $data['success']='';
        $data['error']='';
        $data['title']= 'Device Data - Table View';       
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $data['data'] = $this->device_m->get_detail($id)->data; 
        $data['group'] = $this->groupsensor_m->get_detail($data['data']->group_code_name);  
        if(!$data['group']->status)
            $data['group'] = [];
        else
            $data['group'] = $data['group']->data;
        $data['extract'] = $this->extract($data['data']->field);
        $data["date_str"] = date("Y-m-d");
        $data["date_end"] = date("Y-m-d");
        if($this->input->get('start'))
            $data["date_str"] = $this->input->get('start');
        if($this->input->get('end'))
            $data["date_end"] = $this->input->get('end');
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $this->load->view('device_data_table_v', $data);
    }  

    public function datatable($id){
        $device = $this->device_m->get_detail($id)->data; 
        $extract = $this->extract($device->field);
        $limit=$this->input->get('limit');
        $offset = $this->input->get('offset');
        $date_str = date("Y-m-d");
        $date_end = date("Y-m-d");
        if($this->input->get('start'))
            $date_str = $this->input->get('start');
        if($this->input->get('end'))
            $date_end = $this->input->get('end');

        $query = array(
            "date_start" => $date_str,
            "date_end" => $date_end
        );
        $count_data = $this->device_m->count_datasensor($device->device_code,$query)->data;
        $query["limit"] = intval($limit);
        $query["skip"] = intval($offset);
		$list = $this->device_m->datasensor($device->device_code,$query)->data;
        $data = array();
        foreach($list as $d){
            $item = array();
            foreach($extract as $k){
                if (strpos($k, '-') !== false) {
                    $nested_k = explode("-",$k);
                    $val = $this->dataget_nested($nested_k,$d);
                } else {
                    $val = (empty($d->{$k}))?"-":$d->{$k};
                }
                $item[$k] = $val;
            }
            $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_server_unix"}/1000);
            $data[] = $item;
        }
        $response = array(
            "total" => $count_data,
            "rows" =>  $data
        );     
        header('Content-Type: application/json; charset=utf-8');   
        echo json_encode($response);
    }

    function dataget_nested($key,$value){
        foreach($key as $d){
            if(empty($value->{$d})){
                $value = "-";
                break;    
            }
            $value = $value->{$d}; 
        }
        return $value;
    }

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
