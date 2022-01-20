<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class combination extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
		$this->load->model('device_m');
        $this->load->model('groupsensor_m');
		$this->load->model('combination_m');
		$this->load->model('schema_m');
        $this->limit_data = 1000;
        $this->limit_table = 25;
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
    }

	public function index(){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete combination successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete combination";	
		$data['title']='Combination List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');
        $query = array(
            "add_by" => $data['user_now']->id
        );
        $data["data"] =  $this->combination_m->search($query);
        if($data["data"]->status){
            $data["data"] = $data["data"]->data;
        } else {
            $data['data'] = array();
        }
        $this->load->view('combi_v', $data);
	}

	public function add(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Combination Add';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
		
        
        $query = array(
            "add_by" => $data['user_now']->id
        );
        $data["schema"] =  $this->schema_m->search($query);
        if($data["schema"]->status){
            $data["schema"] = $data["schema"]->data;
        }else{
            $data["schema"] = [];
        }
        if($this->input->post('save')){  
            $schema = $this->schema_m->get_detail($this->input->post('schema'))->data;            
            $field = array();
            for ($i = 0; $i < count($schema->field); $i++) { 
                $item = $schema->field[$i];
                foreach($item as $key=>$value) {
                    $items = array();
                    if($this->input->post("inputcheck_".$key)){
                        if($this->input->post("input_field_key") == $key){
                            $items[$key] = "key";
                        } else {
                            $items[$key] = array(
                                "data" => [$this->input->post($key."_device"),$this->input->post($key."_value_field"),$this->input->post($key."_key_field")],
                                "option" => $this->input->post($key."_method"),
                                "default" => $this->input->post($key."_default_val")
                            );
                            if( !empty($this->input->post($key."_collection")) ){
                                $items[$key]["collectid"] = $this->input->post($key."_collection");
                            }
                        }
                        array_push($field,$items);
                    }
                }
            }
            // echo "<pre>";
            // print_r($schema);
            // print_r($this->input->post());
            // print_r($field);
            // echo "</pre>";
            // exit();
            if(empty($this->input->post('stream')))
                $stream = false;
            else 
                $stream = true;      	
            $input = array(
        		"name" => $this->input->post('name'),
        		"schema_code" => $this->input->post('schema'),
				"add_by" => $data['user_now']->id,        	    
        	    "time_loop" => $this->input->post('time_loop'),
        	    "stream" => $stream,
                "information" => array(
                        "detail" => $this->input->post('detail'),
                        "purpose" => $this->input->post('purpose'),
                    ),
                "field" => $field
            );
            $respo = $this->combination_m->add($input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('combi_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Combination Edit';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        $query = array(
            "add_by" => $data['user_now']->id
        );
        $data["schema"] =  $this->schema_m->search($query);
        if($data["schema"]->status){
            $data["schema"] = $data["schema"]->data;
        }else{
            $data["schema"] = [];
        }
		if($this->input->post('save')){    
            $idcombi = $this->input->post('id');
            
            $schema = $this->schema_m->get_detail($this->input->post('schema'))->data;            
            $field = array();
            for ($i = 0; $i < count($schema->field); $i++) { 
                $item = $schema->field[$i];
                foreach($item as $key=>$value) {
                    $items = array();
                    if($this->input->post("inputcheck_".$key)){
                        if($this->input->post("input_field_key") == $key){
                            $items[$key] = "key";
                        } else {
                            $items[$key] = array(
                                "data" => [$this->input->post($key."_device"),$this->input->post($key."_value_field"),$this->input->post($key."_key_field")],
                                "option" => $this->input->post($key."_method"),
                                "default" => $this->input->post($key."_default_val")
                            );
                            if( !empty($this->input->post($key."_collection")) ){
                                $items[$key]["collectid"] = $this->input->post($key."_collection");
                            }
                        }
                        array_push($field,$items);
                    }
                }
            }
            // echo "<pre>";
            // print_r($schema);
            // print_r($this->input->post());
            // print_r($field);
            // echo "</pre>";
            // exit();    
            if(empty($this->input->post('stream')))
                $stream = false;
            else 
                $stream = true;            	
            $input = array(
        		"name" => $this->input->post('name'),
        		"schema_code" => $this->input->post('schema'),
				"add_by" => $data['user_now']->id,        	    
        	    "time_loop" => $this->input->post('time_loop'),
        	    "stream" => $stream,
                "information" => array(
                        "detail" => $this->input->post('detail'),
                        "purpose" => $this->input->post('purpose'),
                    ),
                "field" => $field
            );

            $respo = $this->combination_m->edit($idcombi,$input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }   
        }
        
        $data['data'] = $this->combination_m->get_detail($id);       
        if($data['data']->status){
            $data['data'] = $data['data']->data;
            $data['id'] = $id;
		    $this->load->view('combi_edit_v', $data);
        } else {
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        }
	}		

	public function delete($id,$other=""){       
		if($id){
            if($other){
                $respo = $this->combination_m->del_other($id);
            } else {
        	    $respo = $this->combination_m->del($id);
            } 
            if($respo->status){             
				redirect(base_url().'combination/?alert=success') ; 			
            } else {                
				redirect(base_url().'combination/?alert=failed') ; 			
            }                       
        }        
		redirect(base_url().'combination/?alert=failed') ; 			
	}	

    public function batch($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Combination Edit';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        $query = array(
            "add_by" => $data['user_now']->id
        );
        $data['data'] = $this->combination_m->get_detail($id);       
        if($data['data']->status){
            $data['data'] = $data['data']->data;
            $schema = $this->schema_m->get_detail($data['data']->schema_code);
            if($schema->status){
                $data['schema'] = $schema->data->name;
            }
            $data['id'] = $id;
		    $this->load->view('combi_batch_process_v', $data);
        } else {
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        }
	}
    
    public function batchprocess($id){ 
        // $input = array(
        //     "date_start" => $this->input->post("date_start")." ".$this->input->post("time_start"),
        //     "date_end" => $this->input->post("date_end")." ".$this->input->post("time_end")
        // );
        $input = array(
            "date_start" => $this->input->post("date_start"),
            "date_end" => $this->input->post("date_end")
        );
        $data = $this->combination_m->batch_process($id,$input);
        header("Content-Type: application/json");
        echo json_encode($data);
        exit();
    }


    public function schema($code,$idcombi=""){       
        $schema = $this->schema_m->get_detail($code);
        if($schema->status){
            $data = array();
            $data['user_now'] = $this->session->userdata('dasboard_iot');
            $data["data"] = $schema->data;
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
                if(!empty($data_group))
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
                if(!empty($data_group))
                    foreach ($data_personal as $key) {
                        $device_groupcode[] = $key->code_name;
                        $data['device_group'][$key->code_name] = $key;
                    }
            }            
            ////end get device from personal ///
            $device_groupcode = array(
                '$in' => $device_groupcode
            );
            $or = array();
            $or[] = array("group_code_name" =>$device_groupcode);
            $or[] = array("add_by" => $data['user_now']->id);
            $query = array(
                '$or' => $or
            );
            $data["device"] =  $this->device_m->search($query);
            if($data["device"]->status){
                $data["device"] = $data["device"]->data;
            }else{
                $data["device"] = [];
            }
            $data["combi"] = array();
            if($idcombi){
                $combi = $this->combination_m->get_detail($idcombi);
                if($combi->status){
                    $combi = $combi->data;
                    for ($i = 0; $i < count($combi->field); $i++) { 
                        $item = $combi->field[$i];
                        foreach($item as $key=>$value) {                               
                            $data["combi"][$key] = $value;
                            if($value=="key"){
                                continue;
                            }                                                      
                            $device_field = $this->device_m->get_detail($value->data[0])->data;                                                    
                            $data["combi"][$key]->device_field = $this->extract($device_field->field);                            
                        }                        
                    }    
                }
            }
            if($data["combi"]){                     
                $this->load->view('combi_edit_form_v', $data);
            }else{
                $this->load->view('combi_add_form_v', $data);
            }
        }
    }

    public function device($id){       
        $data = $this->device_m->get_detail($id)->data;
        $field = $this->extract($data->field);
        $collect = "";
        if($data->group_code_name !="other"){
            $group_sensor = $this->groupsensor_m->get_detail($data->group_code_name);
            if($group_sensor->status){
                $collect = $group_sensor->data->id;
            }
        }
        $result = array(
            "field" => $field,
            "collect" => $collect
        );
        header("Content-Type: application/json");
        echo json_encode($result);
        exit();
    } 


    function list($id,$combi){       
        $data=array();
        $data['success']='';
        $data['error']='';
        $data['title']= 'combi Data '.$id.' - Table View';       
		if($this->input->get('alert')=='success') $data['success']='Delete data successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete data";	
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $data['data'] = $combi; 
        $data['extract'] = $this->extract($data['data']->field);
        $data["date_str"] = date("Y-m-d");
        $data["date_end"] = date("Y-m-d");
        if($this->input->get('start'))
            $data["date_str"] = $this->input->get('start');
        if($this->input->get('end'))
            $data["date_end"] = $this->input->get('end');
        $this->load->view('combi_data_v', $data);
    }

    function extract($list,$prefix=''){
        $return = array();
        for ($i = 0; $i < count($list); $i++) {
            $item = $list[$i];
            if(is_object($item)){
                foreach($item as $key=>$value) {
                    $return[] = $key; 
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
