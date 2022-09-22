<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
        $this->load->model('groupsensor_m');
		$this->load->model('device_m');
		$this->load->model('deviceprocess_m');
		$this->load->model('filter_m');
		$this->load->model('edge_m');
        $this->limit_data = 3000;
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
        $group = $this->group_m->search(array("user_id"=>$data['user_now']->id));
        if($group->status){
            $group = $group->data;
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
                if(!empty($data_group))
                    foreach ($data_group as $key) {
                        $device_groupcode[] = $key->code_name;
                        $data['device_group'][$key->code_name] = $key;
                    }
            }    
        }
        //end get device from group///
        ////get device from personal ///
        $data_personal = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "group_type"=>"personal"));
        if($data_personal->status){
            $data_personal = $data_personal->data;
            if(!empty($data_group))
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
        $group = $this->group_m->search(array("user_id"=>$data['user_now']->id));
		if($group->status)
            $group = $group->data;
        else
            $group = [];
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
        $group = $this->group_m->search(array("user_id"=>$data['user_now']->id));
		if($group->status)
            $group = $group->data;
        else
            $group = [];
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
        if($data['data']->group_code_name == "other"){
            $http_qerry = array(
                "device_code" => $data['data']->device_code,
                "channel_type" => "http-post"
            );
            $comm = $this->device_m->get_com_chanel($http_qerry);
            if($comm->status)
                $data["http"] = $comm->data->token_access;            
        }
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
        if(!empty($data['sensor'])) 
            $data['sensor'] = array_reverse((array)$data['sensor']);
        
        $query = array(
            "device" => $id
        );
        $filter_field1 = array();
        $filter_field2 = array();
        $filter =  $this->filter_m->search($query);
        if($filter->status){
            $filter = $filter->data;
            foreach($filter as $d){
                $filter_field2[] =  $d->save_to;
                if( !isset($filter_field1[$d->field]) )
                    $filter_field1[$d->field] = array();
                $filter_field1[$d->field][] = $d->save_to;
            }
        }
        $data["filter"] = $filter_field1;
        $data["field_filter_list"] = $filter_field2;
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
        $data["time_str"] = date("H:i");
        $data["time_end"] = date("H:i");
        $data["with_time"] = FALSE;
        if($this->input->get('start'))
            $data["date_str"] = $this->input->get('start');
        if($this->input->get('end'))
            $data["date_end"] = $this->input->get('end');
        if($this->input->get('tstart'))
            $data["time_str"] = $this->input->get('tstart');
        if($this->input->get('tend'))
            $data["time_end"] = $this->input->get('tend');
        if($this->input->get('with_time'))
            $data["with_time"] = TRUE;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $query = array(
            "device" => $id
        );
        $filter_field = array();
        $filter =  $this->filter_m->search($query);
        if($filter->status){
            $filter = $filter->data;
            foreach($filter as $d){
                $filter_field[] = $d->save_to;
            }
        }        
        $data['extract'] = array_merge($data['extract'],$filter_field);
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

        if($this->input->get('tstart')){
            $query["time_start"] = $this->input->get('tstart').":00";
        }
        if($this->input->get('tend')){
            $query["time_end"] = $this->input->get('tend').":00";
        }

        $count_data = $this->device_m->count_datasensor($device->device_code,$query)->data;
        if(!empty($limit))
            $query["limit"] = intval($limit);
        if(!empty($offset))
            $query["skip"] = intval($offset);
        if(!empty($order) && !empty($sort) ){
            $field = $sort;
            if($sort == "date")
                $field = "date_add_server";
            if($order == "asc")
                $type = 1;
            else 
                $type = -1;
            $query["sort"] = array(
                "field" => $field,
                "type" => $type
            );
        }
        if(empty($offset) && empty($limit))
            $export = true;
        else
            $export = false;
		$list = $this->device_m->datasensor($device->device_code,$query)->data;

        $query = array(
            "device" => $id
        );
        $filter_field = array();
        $filter =  $this->filter_m->search($query);
        if($filter->status){
            $filter = $filter->data;
            foreach($filter as $d){
                $filter_field[] = $d->save_to;
            }
        }   

        $data = array();
        foreach($list as $d){
            $item = array();
            foreach($extract as $k){
                if (strpos($k, '-') !== false) {
                    $nested_k = explode("-",$k);
                    $val = $this->dataget_nested($nested_k,$d,$export);
                } else {
                    $val = (!isset($d->{$k}))?((!$export)?"-":""):$d->{$k}; //$d->{$k}; 
                }
                $item[$k] = $val;
            }
            foreach($filter_field as $ff){
                $item[$ff] = (!isset($d->{$ff}))?((!$export)?"-":""):$d->{$ff};
            }
            // $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_server_unix"}/1000);
            $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_server"}->{'$date'}/1000);
            $data[] = $item;
        }
        $response = array(
            "total" => $count_data,
            "rows" =>  $data,
            "query" =>  $query
        );     
        header('Content-Type: application/json; charset=utf-8');   
        echo json_encode($response);
    }

    function dataget_nested($key,$value,$export){
        foreach($key as $d){
            if(!isset($value->{$d})){
                if(!$export)
                    $value = "-";
                else
                    $value = "";
                break;    
            }
            $value = $value->{$d}; 
        }
        return $value;
    }

    public function process($id,$method="list",$field=""){
        $data=array();
		$data['success']='';
		$data['error']='';				
		$data['user_now'] = $this->session->userdata('dasboard_iot');	                        
        $data['data'] = $this->device_m->get_detail($id);        
		$data['id'] = $id;
        if(!$data['data']->status){
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
            return "";
        }
        $data['data'] = $data['data']->data;
        if($method=="list"){
            $this->process_list($data);
        } else if($method=="add"){
            $this->process_add($data,$id);
        } else if($method=="edit"){
            $this->process_edit($data,$id,$field);
        } else if($method=="delete"){
            $this->process_delete($id,$field);
        } else if($method=="batch"){
            $this->process_batch($data,$id);
        } else {
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        }
    }

    function process_list($data){
        $data['title']= 'Device Process List';
        if($this->input->get('alert')=='success') $data['success']='Delete device successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete device";
        $this->load->view('device_process_v', $data);
    }

    function process_add($data,$id){       
		$data['title']= 'Device Process Add';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
		if($this->input->post('save')){ 
            $input = array(
        		"device_code" => $id,
        		"field" => $this->input->post('field'),
        		"pre" => $this->input->post('pre'),
        		"process" => $this->input->post('process'),
                "var" => $this->input->post('var')
            );
            $respo = $this->deviceprocess_m->add($input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data["id"] = $id;
		$this->load->view('device_process_add_v', $data);
	}

    function process_edit($data,$id,$field){       
		$data['title']= 'Device Process Edit';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
		if($this->input->post('save')){ 
            $input = array(
        		"device_code" => $id,
        		"oldfield" => $this->input->post('oldfield'),
        		"field" => $this->input->post('field'),
        		"pre" => $this->input->post('pre'),
        		"process" => $this->input->post('process'),
                "var" => $this->input->post('var')
            );
            $respo = $this->deviceprocess_m->edit($input);
            if($respo->status){             
                $data['success']=$respo->message;   
                $data['data'] = $this->device_m->get_detail($id)->data;                
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data["id"] = $id;
        $data["field"] = $field;
        $data["item"] = $data["data"]->field_process->{$field};
		$this->load->view('device_process_edit_v', $data);
	}

    function process_delete($id,$field){       
		if($id){
            $respo = $this->deviceprocess_m->del($id,$field);
            if($respo->status){             
				redirect(base_url().'device/process/'.$id.'/?alert=success') ; 			
            } else {                
				redirect(base_url().'device/process/'.$id.'/?alert=failed') ; 			
            }                       
        }        
		redirect(base_url().'device/process/'.$id.'/?alert=failed') ;		
	}

    function process_batch($data,$id){       
		$data['title']= 'Device Process - Batch Processing';		
        $data['id'] = $id;
        $this->load->view('device_process_batch_v', $data);
        
	}
    
    public function batchprocess($id){ 
        $input = array(
            "date_start" => $this->input->post("date_start"),
            "date_end" => $this->input->post("date_end")
        );
        $data = $this->deviceprocess_m->batch_process($id,$input);
        header("Content-Type: application/json");
        echo json_encode($data);
        exit();
    }

    public function compare(){
        // $list = ["lo14","lo15","lo16"];
        // $data=array();
        // $data['success']='';
        // $data['error']='';
        // $data['title']= 'Device Data';       
        // $data['user_now'] = $this->session->userdata('dasboard_iot');   
        // foreach($list as $id){
        //     $device = array();
        //     $device["name"] = "Device 1";
        //     $device['data'] = $this->device_m->get_detail($id)->data;
        //     $query = array(
        //         'limit' => $this->limit_data
        //     );
        //     $device['sensor'] = $this->device_m->datasensor($device['data']->device_code,$query)->data;
        //     $data[$id] = $device;
        // }
        // $data["device"] = $device['data'];
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $id = "lo15";
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
        if(!empty($data['sensor'])) 
            $data['sensor'] = array_reverse((array)$data['sensor']);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $this->load->view('device_data_comp_v', $data);
    }
    

    public function edge($id,$method="list",$code=""){
        $data=array();
		$data['success']='';
		$data['error']='';				
		$data['user_now'] = $this->session->userdata('dasboard_iot');	                        
        $data['data'] = $this->device_m->get_detail($id);        
		$data['id'] = $id;
        if(!$data['data']->status){
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
            return "";
        }
        $data['data'] = $data['data']->data;
        if($method=="list"){
            $this->edge_list($id,$data);
        } else if($method=="add"){
            $this->edge_add($data,$id);
        } else if($method=="edit"){
            $edge = $this->edge_m->get_detail($code);
            if($edge->status){
                $data["edge"] = $edge->data;
                $this->edge_edit($data,$id);
            }else{
                $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
            }                            
        } else if($method=="delete"){
            $this->edge_delete($id,$code);
        } else if($method=="process"){
            $this->edge_process($data,$id);
        } else if($method=="download"){
            $edge = $this->edge_m->get_detail($code);
            if($edge->status){
                $data["edge"] = $edge->data;
                $this->edge_download($data,$id);
            }else{
                $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
            }                            
        } else {
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        }
    }

    function edge_list($id,$data){
        $data['title']= 'Edge Computing Configuration List';
        if($this->input->get('alert')=='success') $data['success']='Delete edge configuration successfully';	
        if($this->input->get('alert')=='failed') $data['error']="Failed to delete edge configuration";
        $src = array(
            "device_code"=>$id
        );
        $data["config_list"] = $this->edge_m->search($src);
        if( $data["config_list"]->status == 1)
            $data["config_list"] = $data["config_list"]->data;
        else
            $data["config_list"] = [];
        $data["id"] = $id;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $this->load->view('device_edge_v', $data);
    }
    
    function edge_add($data,$id){       
        $data['title']= 'Edge Computing Configuration Add';		
        $data['user_now'] = $this->session->userdata('dasboard_iot');	
        if($this->input->post('save')){             
            $object_used =  array();                    
            $method =  $this->input->post('method');                    
            $object_pattern = $this->input->post('object_pattern'); 
            foreach($object_pattern as $i => $item){                
                $field = $this->input->post('field_'.$item);
                $pattern = $this->input->post('pattern_'.$item);
                $object_used[$field] = $pattern;
            }            
            $input = array(
                "device_code" => $id,
                "method" => $this->input->post('method'),
                "interface" => $this->input->post('interface'),
                "string_sample" => $this->input->post('string_sample'),
                "object_used" => $object_used,
                "string_pattern" => $this->input->post('string_pattern'),
                "add_by" => $data['user_now']->id,
                "active" => $this->input->post('active')
            );
            if($method == "array_list"){
                $input["delimeter"] = [$this->input->post('delimeter')[0]];    
            } else if($method == "json_object"){
                $input["delimeter"] = $this->input->post('delimeter');
            }
            
            $respo = $this->edge_m->add($input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data["id"] = $id;
        $data["interface"] = array("USB Serial");
        $data['field'] = $this->extract($data['data']->field);
        $this->load->view('device_edge_add_v', $data);
    }
    
    function edge_edit($data,$id){       
        $data['title']= 'Edge Computing Configuration Edit';		
        $data['user_now'] = $this->session->userdata('dasboard_iot');	
        if($this->input->post('save')){ 
            $object_used =  array();                    
            $method =  $this->input->post('method');                    
            $object_pattern = $this->input->post('object_pattern'); 
            foreach($object_pattern as $i => $item){                
                $field = $this->input->post('field_'.$item);
                $pattern = $this->input->post('pattern_'.$item);
                $object_used[$field] = $pattern;
            }            
            $input = array(
                "device_code" => $id,
                "method" => $this->input->post('method'),
                "interface" => $this->input->post('interface'),
                "string_sample" => $this->input->post('string_sample'),
                "object_used" => $object_used,
                "string_pattern" => $this->input->post('string_pattern'),
                "updated_by" => $data['user_now']->id,
                "active" => $this->input->post('active')
            );
            if($method == "array_list"){
                $input["delimeter"] = [$this->input->post('delimeter')[0]];    
            } else if($method == "json_object"){
                $input["delimeter"] = $this->input->post('delimeter');
            }            
            $respo = $this->edge_m->edit($data["edge"]->id, $input);
            if($respo->status){             
                $data['success']=$respo->message;   
                $data['edge'] = $this->edge_m->get_detail($data['edge']->edgeconfig_code)->data;               
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data["id"] = $id;
        $data["interface"] = array("USB Serial");
        $data["field"] =  $this->extract($data['data']->field);    
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();           
        $this->load->view('device_edge_edit_v', $data);
    }
    
    function edge_delete($id,$code){       
        if($id){
            $data= $this->edge_m->get_detail($code);
            
            if($data->status){
                $edge_id = $data->data->id;
                $respo = $this->edge_m->del($edge_id);
                if($respo->status){             
                    redirect(base_url().'device/edge/'.$id.'/?alert=success') ; 			
                } else {                
                    redirect(base_url().'device/edge/'.$id.'/?alert=failed') ; 			
                } 
            }else{
                redirect(base_url().'device/edge/'.$id.'/?alert=failed') ; 			
            }
                                  
        }        
        redirect(base_url().'device/edge/'.$id.'/?alert=failed') ;		
    }

    function edge_process($id,$field){
        if($this->input->post('method') and $this->input->post('sample')){
            $method = $this->input->post('method');
            $input = array(
                "method" => $this->input->post('method'),
                "string_sample" => $this->input->post('sample')                
            );
            if($method == "array_list"){
                $input["delimeter"] = [$this->input->post('delimeter1')];    
            } else if($method == "json_object"){
                $input["delimeter"] = [$this->input->post('delimeter1'),$this->input->post('delimeter2')];
            }   
            $response = $this->edge_m->process($input);
        } else {
            $response = array(
                "status" => false
            );
        }
        header('Content-Type: application/json; charset=utf-8');   
        echo json_encode($response);
    }

    function beautify_filename($filename) {
        // reduce consecutive characters
        $filename = preg_replace(array(
            // "file   name.zip" becomes "file-name.zip"
            '/ +/',
            // "file___name.zip" becomes "file-name.zip"
            '/_+/',
            // "file---name.zip" becomes "file-name.zip"
            '/-+/'
        ), '_', $filename);
        $filename = preg_replace(array(
            // "file--.--.-.--name.zip" becomes "file.name.zip"
            '/-*\.-*/',
            // "file...name..zip" becomes "file.name.zip"
            '/\.{2,}/'
        ), '.', $filename);
        // lowercase for windows/unix interoperability http://support.microsoft.com/kb/100625
        $filename = mb_strtolower($filename, mb_detect_encoding($filename));
        // ".file-name.-" becomes "file-name"
        $filename = trim($filename, '.-');
        return $filename;
    }

    function edge_download($data,$id){  
        $name =  $data['data']->name;        
        $filename = 'configuration_'.$data["edge"]->edgeconfig_code.'_device_'.$name.'['.$id.']';
        $filename = $this->beautify_filename($filename);
        
        $comm = array();        
        if($data['data']->communication->{"http-post"}){
            if($data['data']->group_code_name == "other"){
                $http_qerry = array(
                    "device_code" => $data['data']->device_code,
                    "channel_type" => "http-post"
                );
                $comm2 = $this->device_m->get_com_chanel($http_qerry);
                if($comm2->status)
                    $comm["http_post"] =   $this->config->item('url_node').'comdata/sensor/'.$comm2->data->token_access;            
            }
        }
        if($data['data']->communication->mqtt){
            $server = $data['data']->communication->server;
            if($server == 'localhost'){
                $server = $this->config->item('host_mqtt');
            }
            $comm["mqtt"] = array(
                "server" => $server,
                "port" => $data['data']->communication->port,
                "topic" => $data['data']->communication->topic
            );
        }
        $response = array(
            "device_code" =>$id,
            "interface" => array(),
            "device_info" => array(
                "name" => $data["data"]->name,
                "field" => $data["data"]->field,                              
            ),
            "communication_protocol" => $comm,  
        );

        if($data["edge"]->interface == "USB Serial"){
            $interface = array(        
                "method" => $data["edge"]->method,
                "string_sample" => $data["edge"]->string_sample,
                "delimeter" => $data["edge"]->delimeter,
                "string_pattern" => $data["edge"]->string_pattern,
                "object_used" =>$data["edge"]->object_used,                
            );
            $response["interface"]["usb_serial"] = $interface;
        }


        // echo "<pre>";
        // print_r($response);
        // echo "</pre>";
        // exit();
        // Force download .json file with JSON in it
        header("Content-type: application/vnd.ms-excel");
        header("Content-Type: application/force-download");
        header("Content-Type: application/download");
        header("Content-disposition: " . $filename . ".json");
        header("Content-disposition: filename=" . $filename . ".json");


        $response = stripslashes(json_encode($response));
        echo $response;
        exit;
    }

    
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
