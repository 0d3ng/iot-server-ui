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
        
        if(isset($data['user_now']->role)){
            $data['role'] = $data['user_now']->role;    
        }else{
            $data['role'] = "user";
        }
        $type = $this->input->get('type');
        if(empty($type))
            $type = 'all';
        $data['device_group'] = [];

        if($data['role'] == "user"){
            $device_groupcode = array();                    
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
            
        }else{
            $query = array();   
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
        $query = array();
        if($data["search"]){
            $query["date_start"] =  $data["date_str"];
            $query["date_end"] =  $data["date_end"];
        }else {
            $data['limit_data'] = $this->limit_data;
            $query['limit']  = $this->limit_data;
        }
        
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
        $offset=$this->input->get('offset');
        $order = $this->input->get('order');
        $sort = $this->input->get('sort');
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

        $query2 = array(
            "device" => $id
        );
        $filter_field = array();
        $filter =  $this->filter_m->search($query2);
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
                $this->edge_download($data,$id,$code);
            }else{
                $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
            }                            
        } else if($method=="deploy"){
            $this->edge_deploy_device($id,$code);
        } else {
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        }
    }

    function edge_list($id,$data){
        $data['title']= 'Edge Computing Configuration List';
        $data['success_deploy'] = "";
        $data['error_deploy'] = "";
        if($this->input->get('alert')=='success') $data['success']='Delete edge configuration successfully';	
        if($this->input->get('alert')=='failed') $data['error']="Failed to delete edge configuration";
        if($this->input->get('alert')=='success_deploy') $data['success_deploy']='Update edge configuration remotely successfully';	
        if($this->input->get('alert')=='failed_deploy') $data['error_deploy']="Failed to update edge configuration remotely";
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
            ##Extract Interface
            $type = $this->input->post('interface'); 
            $item_interface = array();
            if($type == "usb_serial"){
                $item_interface = array(
                    "type" => $type,
                    "config"=>array(
                        "port"=>$this->input->post('config_port'),
                        "baudrate"=>(int)$this->input->post('config_baudrate'),
                        "timeout"=>(int)$this->input->post('config_timeout')
                    ),
                    "method" => $this->input->post('method'),
                    "string_sample" => $this->input->post('string_sample'),
                    "string_pattern" => $this->input->post('string_pattern'), 
                );
                if($this->input->post('method') == "array_list"){
                    $item_interface["delimeter"] = [$this->input->post('delimeter')[0]];    
                } else if($this->input->post('method') == "json_object"){
                    $item_interface["delimeter"] = $this->input->post('delimeter');
                }
            }else if($type=="wlan"){
                $item_interface = array(
                    "type"=>$type,
                    "config"=>array(
                        "url"=>$this->input->post('config_url'),
                        "timeout"=>(int)$this->input->post('config_timeout')
                    ),
                    "method"=>$this->input->post('method'),
                    "web_scrapping_result"=>$this->input->post('web_scrapping_result'),
                    "index_name"=>(int)$this->input->post('index_name'),
                    "index_value"=>(int)$this->input->post('index_value'),
                    "max_sequence"=>(int)$this->input->post('max_sequence'),
                );
            }
            ##Extract Data Resource
            $object_used =  array();                    
            $object_pattern = $this->input->post('object_pattern'); 
            foreach($object_pattern as $i => $item){                
                $field = $this->input->post('field_'.$item);
                $pattern = $this->input->post('pattern_'.$item);
                $object_used[$field] = $pattern;
            } 
            $item_interface["object_used"] = $object_used;
            
            $interface = [$item_interface];

            ##Extract Data Transmitted
            $data_transmitted = array();
            $item_transmitted= $this->input->post('data_transmitted'); 
            foreach($item_transmitted as $i => $field){   
                $value = $this->input->post('field_'.$field);
                $data_transmitted[$field] = $value;
            } 

            ##Extract Local Data 
            $data_local = array();
            $item_local= $this->input->post('local_data'); 
            foreach($item_transmitted as $i => $item){   
                $field = $this->input->post('ld_field_'.$item);
                $value = $this->input->post('ld_value_'.$item);
                $type = $this->input->post('ld_type_'.$item);
                $data_local[$field] = [$value,$type];
            } 

            ##Extract Visualization
            
            
            $table = array();
            $item_table = $this->input->post('table_data'); 
            foreach($item_table as $i => $item){   
                $value = $this->input->post('table_value_'.$item);
                $table[] = $value;
            } 

            $graph = array();
            $list_graph = $this->input->post('graph_list'); 
            foreach($list_graph as $i => $listID){  
                $list_graph_object = array("value"=>array()); 
                $item_graph = $this->input->post('graph_item_'.$listID); 
                foreach($item_transmitted as $i => $listID){
                    $label = $this->input->post('graph_label_'.$item);
                    $value = $this->input->post('graph_value_'.$item);
                    $list_graph_object["value"][] = array(
                        "title" =>$label,
                        "value" =>$value

                    );
                }
                $graph[] = $list_graph_object;
            } 

            $visualization = array(
                "table" => $table,
                "grapgh" => $graph
            );

            $input = array(
                "device_code" => $id,
                "resource" => $this->input->post('resource'),
                "interface" => $interface,
                "data_transmitted" => $data_transmitted,
                "time_interval" => floatval($this->input->post('time_interval')),
                "comm_service" =>  $this->input->post('comeservice'),
                "local_data" => $data_local,
                "visualization" => $visualization,
                "add_by" => $data['user_now']->id,
                "active" => true,
            );
            // print("<pre>");                
            // print_r($input);
            // print("</pre>");                      
            // exit();
            
            $respo = $this->edge_m->add($input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data["id"] = $id;
        $data["resource"] = array("USB Mono Stick","USB Serial","Data Logger [GL240]");
        $data['field'] = $this->extract($data['data']->field);

        $data["commservice"] = array();
        $data["commservice"]["list"] = array();
        if($data['data']->communication->{'http-post'}){
            $data["commservice"]["list"][] = (object) array("type"=>"http_post","label"=>"HTTP-POST Service"); 
            $data["commservice"]["http_url"] = $this->config->item('url_node')."comdata/sensor/".$data['data']->key_access;
        }
        if($data['data']->communication->{'mqtt'}){
            $data["commservice"]["list"][] = (object) array("type"=>"mqtt","label"=>"MQTT Service");
            $data["commservice"]["mqtt"] = (object) array(
                "server" => str_replace($data['data']->communication->{'server'},"localhost",$this->config->item('host_mqtt')),
                "port" => $data['data']->communication->{'port'},
                "topic" => $data['data']->communication->{'topic'} 
            );
        }
        $cek = $this->input->get("test");
        if($cek){
            $this->load->view('device_edge_add_v_old', $data);
        } else {
            $this->load->view('device_edge_add_v', $data);
        }
    }
    
    function edge_edit($data,$id){       
        $data['title']= 'Edge Computing Configuration Edit';		
        $data['user_now'] = $this->session->userdata('dasboard_iot');	
        
        if($this->input->post('save')){ 
            // print("<pre>");                
            ##Extract Interface
            $type = $this->input->post('interface'); 
            $item_interface = array();
            if($type == "usb_serial"){
                $item_interface = array(
                    "type" => $type,
                    "config"=>array(
                        "port"=>$this->input->post('config_port'),
                        "baudrate"=>(int)$this->input->post('config_baudrate'),
                        "timeout"=>(int)$this->input->post('config_timeout')
                    ),
                    "method" => $this->input->post('method'),
                    "string_sample" => $this->input->post('string_sample'),
                    "string_pattern" => $this->input->post('string_pattern'), 
                );
                if($this->input->post('method') == "array_list"){
                    $item_interface["delimeter"] = [$this->input->post('delimeter')[0]];    
                } else if($this->input->post('method') == "json_object"){
                    $item_interface["delimeter"] = $this->input->post('delimeter');
                }
            }else if($type=="wlan"){
                $item_interface = array(
                    "type"=>$type,
                    "config"=>array(
                        "url"=>$this->input->post('config_url'),
                        "timeout"=>(int)$this->input->post('config_timeout')
                    ),
                    "method"=>$this->input->post('method'),
                    "web_scrapping_result"=>$this->input->post('web_scrapping_result'),
                    "index_name"=>(int)$this->input->post('index_name'),
                    "index_value"=>(int)$this->input->post('index_value'),
                    "max_sequence"=>(int)$this->input->post('max_sequence'),
                );
            }
            ##Extract Data Resource
            $object_used =  array();                    
            $object_pattern = $this->input->post('object_pattern'); 
            foreach($object_pattern as $i => $item){                
                $field = $this->input->post('field_'.$item);
                $pattern = $this->input->post('pattern_'.$item);
                $object_used[$field] = $pattern;
            } 
            $item_interface["object_used"] = $object_used;
            
            $interface = [$item_interface];

            ##Extract Data Transmitted
            $data_transmitted = array();
            $item_transmitted= $this->input->post('data_transmitted'); 
            foreach($item_transmitted as $i => $field){   
                $value = $this->input->post('field_'.$field);
                $data_transmitted[$field] = $value;
            } 
            $input = array(
                "device_code" => $id,
                "resource" => $this->input->post('resource'),
                "interface" => $interface,
                "data_transmitted" => $data_transmitted,
                "time_interval" => floatval($this->input->post('time_interval')),
                "comm_service" =>  $this->input->post('comeservice'),
                "add_by" => $data['user_now']->id,
                "active" => true,
            );
            // print_r($input);
            // print("</pre>");                      
            // exit(); 
            
            
            $respo = $this->edge_m->edit($data["edge"]->id, $input);
            if($respo->status){             
                $data['success']=$respo->message;   
                $data['edge'] = $this->edge_m->get_detail($data['edge']->edgeconfig_code)->data;               
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        
        $data["id"] = $id;
                   
        $data["resource"] = array("USB Mono Stick","USB Serial","Data Logger [GL240]");
        $data['field'] = $this->extract($data['data']->field);

        $data["commservice"] = array();
        $data["commservice"]["list"] = array();
        if($data['data']->communication->{'http-post'}){
            $data["commservice"]["list"][] = (object) array("type"=>"http_post","label"=>"HTTP-POST Service"); 
            $data["commservice"]["http_url"] = $this->config->item('url_node')."comdata/sensor/".$data['data']->key_access;
        }
        if($data['data']->communication->{'mqtt'}){
            $data["commservice"]["list"][] = (object) array("type"=>"mqtt","label"=>"MQTT Service");
            $data["commservice"]["mqtt"] = (object) array(
                "server" => str_replace($data['data']->communication->{'server'},"localhost",$this->config->item('host_mqtt')),
                "port" => $data['data']->communication->{'port'},
                "topic" => $data['data']->communication->{'topic'} 
            );
        }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $cek = $this->input->get("test");
        if($cek){
            $this->load->view('device_edge_edit_v_old', $data);
        } else {        
            $this->load->view('device_edge_edit_v', $data);
        }
    }

    function resource($id=""){
        $data = array();
        $resource =  $this->input->post("resource");        

        ##Interface List
        $usb_serial = array("type"=>"usb_serial","label"=>"USB Serial");
        $wlan = array("type"=>"wlan","label"=>"Wireless Network");
        ##END-----------

        

        if($resource == "USB Mono Stick"){
            $data["data"]= (object) array(
                "type"=>"usb_serial",
                "method"=>"json_object",
                "config"=>(object) array(
                    "port"=>"/dev/ttyUSB0",
                    "baudrate"=>115200,
                    "timeout" => 1
                ),
                "string_sample"=> "rc=80000000:lq=51:ct=0001:ed=810DCBDD:id=10:ba=2810:a1=0935:a2=0535:x=0000:y=0000:z=0000",
			    "delimeter"=> [":", "="],
                "string_pattern"=> "rc=[rc-value]:lq=[lq-value]:ct=[ct-value]:ed=[ed-value]:id=[id-value]:ba=[ba-value]:a1=[a1-value]:a2=[a2-value]:x=[x-value]:y=[y-value]:z=[z-value]"
            );    
        } 
        
        if($resource == "Data Logger [GL240]"){
            $data["data"]= (object) array(
                "type"=>"wlan",
                "method"=>"web_scrapping",
                "config"=>(object) array(
                    "url"=>"http://192.168.230.1/digital.cgi?chgrp=0",
                    "timeout" => 8
                ),
                "web_scrapping_result"=> "['CH 1', '-  34.9', 'degC', 'CH 2', 'Off', '-', 'CH 3', 'Off', '-', 'CH 4', 'Off', '-', 'CH 5', 'Off', '-', 'CH 6', 'Off', '-', 'CH 7', 'BURNOUT', '-', 'CH 8', 'Off', '-', 'CH 9', 'Off', '-', 'CH 10', 'Off', '-']",
                "index_name"=>0,
                "index_value"=>1,
                "max_sequence"=>3
            );    
        }
        
        
        if($id){
            $edge = $this->edge_m->get_detail($id)->data;
            $interface = $edge->interface[0];
            if($edge->resource == $resource){
                $data["data"] =  $interface;
            }
        }

        if($resource == "USB Mono Stick" or $resource == "USB Serial"){
            ##Method
            $method_array = array("type"=>"array_list", "label"=>"Covert to Array List");
            $method_json = array("type"=>"json_object", "label"=>"Covert to JSON Object");
            ##----------------
            if(empty($data["data"])){
                $data["data"]= (object) array(
                    "type"=>"",
                    "method"=>"",
                    "config"=>(object) array(
                        "baudrate"=>0
                    ),
                    "delimeter"=> [],
                    "string_pattern"=> ""
                );      
            }
            $data["forms"] = (object) array(
                "interface"=>[$usb_serial],
                "method"=>[$method_array,$method_json],
                "baudrate" => [110, 300, 600, 1200, 2400, 4800, 9600, 14400, 19200, 38400, 57600, 115200, 128000,256000]
            );
            $this->load->view("edge_interface/usb_serial",$data);
        }

        if($resource == "Data Logger [GL240]"){
            ##Method
            $method_webscrap = array("type"=>"web_scrapping", "label"=>"Web Scrapping");
            ##----------------
            if(empty($data["data"])){
                $data["data"]= (object) array(
                    "type"=>"",
                    "method"=>"",
                    "config"=>(object) array(),
                    "web_scrapping_result"=> "",
                    "index_name"=>"",
                    "index_value"=>"",
                    "max_sequence"=>""
                );      
            }
            $data["forms"] = (object) array(
                "interface"=>[$wlan],
                "method"=>[$method_webscrap]
            );
            $this->load->view("edge_interface/datalog",$data);    
        }
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

    function edge_deploy_device($id,$code){       
        if($id){
            $data= $this->edge_m->get_detail($code);
            if($data->status){
                $edge_id = $data->data->id;
                $params = array(
                    "edgeconfig_code"=>$code
                );               
                $respo = $this->edge_m->device_remote_update($params);
                if($respo->status){             
                    redirect(base_url().'device/edge/'.$id.'/?alert=success_deploy') ; 			
                } else {                
                    redirect(base_url().'device/edge/'.$id.'/?alert=failed_deploy') ; 			
                } 
            }else{
                redirect(base_url().'device/edge/'.$id.'/?alert=failed_deploy') ; 			
            }
        }        
        redirect(base_url().'device/edge/'.$id.'/?alert=failed_udeploy') ;		
    }

    function edge_process($id,$field){
        if($this->input->post('method')){
            $method = $this->input->post('method');
            
            if($method == "web_scrapping"){
                $list = $this->input->post('webresult');
                $list = str_replace("['","",$list);
                $list = str_replace("']","",$list);
                $list = explode("', '",$list);
                $result = array();
                $i = 0;
                $index_name = $this->input->post('indexname');
                $index_value = $this->input->post('indexvalue');
                $max_sequence = $this->input->post('maxsequence');
                foreach($list as $l){
                    if($i == $index_name){
                        $item_name = $l;
                    }
                    if($i == $index_value){
                        $item_val = $l;
                    }    
                    $i++;
                    if($i == $max_sequence){
                        $result[$item_name] = $item_val;
                        $i=0;     
                    }
                }
                $response = array(
                    "status" => true,
                    "data" => $result
                );
            }else{
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
            }
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
        $filename = strtolower($filename, mb_detect_encoding($filename));
        // ".file-name.-" becomes "file-name"
        $filename = trim($filename, '.-');
        return $filename;
    }

    function edge_download($data,$id,$code){  
        $name =  $data['data']->name;        
        $filename = 'configuration_'.$data["edge"]->edgeconfig_code.'_device_'.$name.'['.$id.']';
        // $filename = $this->beautify_filename($filename);
        $params = array(
            "edgeconfig_code"=>$code
        );               
        $respo = $this->edge_m->device_config_download($params);
        if($respo->status){      
            $response = $respo->data;      
            header("Content-type: application/vnd.ms-excel");
            header("Content-Type: application/force-download");
            header("Content-Type: application/download");
            header("Content-disposition: " . $filename . ".json");
            header("Content-disposition: filename=" . $filename . ".json");

            $response = stripslashes(json_encode($response));
            echo $response;
            exit;
        } else {                
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));			
        } 

        // $comm = array();        
        // if($data['data']->communication->{"http-post"}){
        //     if($data['data']->group_code_name == "other"){
        //         $http_qerry = array(
        //             "device_code" => $data['data']->device_code,
        //             "channel_type" => "http-post"
        //         );
        //         $comm2 = $this->device_m->get_com_chanel($http_qerry);
        //         if($comm2->status)
        //             $comm["http_post"] =   $this->config->item('url_node').'comdata/sensor/'.$comm2->data->token_access;            
        //     }
        // }
        // if($data['data']->communication->mqtt){
        //     $server = $data['data']->communication->server;
        //     if($server == 'localhost'){
        //         $server = $this->config->item('host_mqtt');
        //     }
        //     $comm["mqtt"] = array(
        //         "server" => $server,
        //         "port" => $data['data']->communication->port,
        //         "topic" => $data['data']->communication->topic
        //     );
        // }
        // $response = array(
        //     "device_code" =>$id,
        //     "interface" => array(),
        //     "device_info" => array(
        //         "name" => $data["data"]->name,
        //         "field" => $data["data"]->field,                              
        //     ),
        //     "communication_protocol" => $comm,  
        // );

        // if($data["edge"]->interface == "USB Serial"){
        //     $interface = array(        
        //         "method" => $data["edge"]->method,
        //         "string_sample" => $data["edge"]->string_sample,
        //         "delimeter" => $data["edge"]->delimeter,
        //         "string_pattern" => $data["edge"]->string_pattern,
        //         "object_used" =>$data["edge"]->object_used,                
        //     );
        //     $response["interface"]["usb_serial"] = $interface;
        // }


        // echo "<pre>";
        // print_r($response);
        // echo "</pre>";
        // exit();
        // Force download .json file with JSON in it
        
    }

    
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
