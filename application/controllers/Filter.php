<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filter extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
        $this->load->model('groupsensor_m');
		$this->load->model('device_m');
		$this->load->model('filter_m');
        $this->limit_data = 3000;
        $this->limit_table = 25;
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
    }

    public function index(){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete data filter successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete data filter";	
		$data['title']='Data Filter List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');

        $query = array(
            "add_by" => $data['user_now']->id
        );
        $data["device"] = $this->input->get('device');
        if(!empty($data["device"]))
            $query["device"] =  $data["device"];

        $data["data"] =  $this->filter_m->search($query);
        if($data["data"]->status){
            $data["data"] = $data["data"]->data;
        } else {
            $data['data'] = array();
        }

        $data['device_group'] = [];
        ////get goup////
        $data['group'] = []; 
        $device_groupcode = [];
        $group = $this->group_m->search(array("user_id"=>$data['user_now']->id));
        if(!empty($group->status)){
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
        $device_groupcode = array(
            '$in' => $device_groupcode
        );
        $or = array();
        $or[] = array("group_code_name" =>$device_groupcode);
        $or[] = array("add_by" => $data['user_now']->id);
        $query = array(
            '$or' => $or
        );
        $data["device_list"] =  $this->device_m->search($query)->data;
        $data["method"] = array(
            "lowpass" => array(
                "name" => "lowpass",
                "label" => "Low Pass Filter",
                "params" => array(
                    array(
                        "name" => "cutoff",
                        "label" => "Cutoff frequency",
                        "type" => "float"
                    )
                )
            ),
            "highpass" => array(
                "name" => "highpass",
                "label" => "High Pass Filter",
                "params" => array(
                    array(
                        "name" => "cutoff",
                        "label" => "Cutoff Frequency",
                        "type" => "float"
                    )
                )
            ),
            "bandpass" => array(
                "name" => "bandpass",
                "label" => "Band Pass Filter",
                "params" => array(
                    array(
                        "name" => "low_cutoff",
                        "label" => "Low Cutoff Frequency",
                        "type" => "float"
                    ),
                    array(
                        "name" => "high_cutoff",
                        "label" => "High Cutoff Frequency",
                        "type" => "float"
                    )
                )
            ),
            "kalmanbasic" => array(
                "name" => "kalmanbasic",
                "label" => "Kalman Filter",
                "params" => array(
                    array(
                        "name" => "R",
                        "label" => "Noise Covariance", //Meaning Covariance????
                        "type" => "float"
                    ),
                    array(
                        "name" => "Q",
                        "label" => "Estimated Covariance", //Meaning Covariance????
                        "type" => "float"
                    )
                )
            )
        );
        $this->load->view('filter_v', $data);
	}

	public function add(){   
             
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Data Filter Add';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
		
        $data['device_group'] = [];
        ////get goup////
        $data['group'] = []; 
        $device_groupcode = [];
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
        $device_groupcode = array(
            '$in' => $device_groupcode
        );
        $or = array();
        $or[] = array("group_code_name" =>$device_groupcode);
        $or[] = array("add_by" => $data['user_now']->id);
        $query = array(
            '$or' => $or
        );
        $data["data"] =  $this->device_m->search($query)->data;
        
        $data["method"] = array(
            array(
                "name" => "lowpass",
                "label" => "Low Pass Filter",
                "params" => array(
                    array(
                        "name" => "cutoff",
                        "label" => "Cutoff frequency",
                        "type" => "float"
                    )
                )
            ),
            array(
                "name" => "highpass",
                "label" => "High Pass Filter",
                "params" => array(
                    array(
                        "name" => "cutoff",
                        "label" => "Cutoff Frequency",
                        "type" => "float"
                    )
                )
            ),
            array(
                "name" => "bandpass",
                "label" => "Band Pass Filter",
                "params" => array(
                    array(
                        "name" => "low_cutoff",
                        "label" => "Low Cutoff Frequency",
                        "type" => "float"
                    ),
                    array(
                        "name" => "high_cutoff",
                        "label" => "High Cutoff Frequency",
                        "type" => "float"
                    )
                )
            ),
            array(
                "name" => "kalmanbasic",
                "label" => "Kalman Filter",
                "params" => array(
                    array(
                        "name" => "R",
                        "label" => "Noise Covariance", //Meaning Covariance????
                        "type" => "float"
                    ),
                    array(
                        "name" => "Q",
                        "label" => "Estimated Covariance", //Meaning Covariance????
                        "type" => "float"
                    )
                )
            )
        );
        $data["method"] = json_decode(json_encode($data["method"]));

        if($this->input->post('save')){  
            // echo "<pre>";
            // print_r($this->input->post());
            // echo "</pre>";
            // exit();
            $device = $this->input->post("device");
            $field = $this->input->post("field");
            $save_to = $this->input->post("save_to");
            $method = $this->input->post("method");
            $params = $this->input->post("params");

            foreach($data["method"] as $item){
                $method_item = $item->name;
                if($method_item == $method){
                    foreach($item->params as $item_params){
                        if($item_params->type == "float")
                            $params[$item_params->name] = floatval($params[$item_params->name]);
                    }
                    break;
                }
            }

            $group_process = $this->input->post("group");
            $waiting_time = intval($this->input->post("waiting"));
            if(empty($this->input->post('stream')))
                $stream = false;
            else 
                $stream = true;      	
            $input = array(
        		"device"=> $device,
                "field"=> $field,
                "save_to"=> $save_to,
                "stream"=> $stream,
                "add_by"=> $data['user_now']->id,
                "waiting_time"=> $waiting_time,
                "method"=> array(
                    "name"=> $method,
                    "parameter"=>$params 
                ),
                "group_data"=> $group_process
            );
            
            $respo = $this->filter_m->add($input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }

        $data["setting"]=array(
            "device"=> "",
            "list_field"=>[],
            "field"=> "",
            "method"=> "",
            "parameter" =>[],
            "group"=>[]
        );

        if($this->input->post('back')){  
            $device = $this->input->post("device");
            $field = $this->input->post("field");
            $method = $this->input->post("method");
            $params = array();
            $item_method = array();
            foreach($data["method"] as $d){
                if($d->name==$method){
                    $item_method = $d;
                    break;
                }
            }
            if(!empty($item_method)){
                foreach($item_method->params as $d){
                    $params[$d->name]=$this->input->post($d->name);
                }
            }
            $group_process = $this->input->post("query");
            if(empty($group_process))
                $group_process = [];
            $device_data = $this->device_m->get_detail($device);
            $listfield = [];
            if($device_data->status){
                $device_data = $device_data->data;
                $listfield = $this->extract($device_data->field);
            }

            $data["setting"] = array(
        		"device"=> $device,
                "list_field"=>$listfield,
                "field"=> $field,
                "method"=> $method,
                "parameter" => $params,
                "group"=> $group_process
            );
        }        
		$this->load->view('filter_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Data Filter Edit';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        $query = array(
            "add_by" => $data['user_now']->id
        );
        
        $data['device_group'] = [];
        ////get goup////
        $data['group'] = []; 
        $device_groupcode = [];
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
        $device_groupcode = array(
            '$in' => $device_groupcode
        );
        $or = array();
        $or[] = array("group_code_name" =>$device_groupcode);
        $or[] = array("add_by" => $data['user_now']->id);
        $query = array(
            '$or' => $or
        );
        $data["data"] =  $this->device_m->search($query)->data;
        
        $data["method"] = array(
            array(
                "name" => "lowpass",
                "label" => "Low Pass Filter",
                "params" => array(
                    array(
                        "name" => "cutoff",
                        "label" => "Cutoff frequency",
                        "type" => "float"
                    )
                )
            ),
            array(
                "name" => "highpass",
                "label" => "High Pass Filter",
                "params" => array(
                    array(
                        "name" => "cutoff",
                        "label" => "Cutoff Frequency",
                        "type" => "float"
                    )
                )
            ),
            array(
                "name" => "bandpass",
                "label" => "Band Pass Filter",
                "params" => array(
                    array(
                        "name" => "low_cutoff",
                        "label" => "Low Cutoff Frequency",
                        "type" => "float"
                    ),
                    array(
                        "name" => "high_cutoff",
                        "label" => "High Cutoff Frequency",
                        "type" => "float"
                    )
                )
            ),
            array(
                "name" => "kalmanbasic",
                "label" => "Kalman Filter",
                "params" => array(
                    array(
                        "name" => "R",
                        "label" => "Noise Covariance", //Meaning Covariance????
                        "type" => "float"
                    ),
                    array(
                        "name" => "Q",
                        "label" => "Estimated Covariance", //Meaning Covariance????
                        "type" => "float"
                    )
                )
            )
        );
        $data["method"] = json_decode(json_encode($data["method"]));

        if($this->input->post('save')){  
            $idfilter = $this->input->post('id');
            // echo "<pre>";
            // print_r($this->input->post());
            // echo "</pre>";
            // exit();
            $device = $this->input->post("device");
            $field = $this->input->post("field");
            $save_to = $this->input->post("save_to");
            $method = $this->input->post("method");
            $params = $this->input->post("params");

            foreach($data["method"] as $item){
                $method_item = $item->name;
                if($method_item == $method){
                    foreach($item->params as $item_params){
                        if($item_params->type == "float")
                            $params[$item_params->name] = floatval($params[$item_params->name]);
                    }
                    break;
                }
            }

            $group_process = $this->input->post("group");
            $waiting_time = intval($this->input->post("waiting"));
            if(empty($this->input->post('stream')))
                $stream = false;
            else 
                $stream = true;      	
            $input = array(
        		"device"=> $device,
                "field"=> $field,
                "save_to"=> $save_to,
                "stream"=> $stream,
                "add_by"=> $data['user_now']->id,
                "waiting_time"=> $waiting_time,
                "method"=> array(
                    "name"=> $method,
                    "parameter"=>$params 
                ),
                "group_data"=> $group_process
            );
            
            $respo = $this->filter_m->edit($idfilter,$input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                         
        }
        
        $detail = $this->filter_m->get_detail($id);       
        if($detail->status){
            $detail = $detail->data;
            $data["filter_code"] = $detail->filter_code;
            $device_data = $this->device_m->get_detail($detail->device);
            $listfield = [];
            if($device_data->status){
                $device_data = $device_data->data;
                $listfield = $this->extract($device_data->field);
            }
            $group_data = $detail->group_data;
            if(empty($group_data))
                $group_data = array();
            $data["setting"]=array(
                "device"=> $detail->device,
                "list_field"=>$listfield,
                "field"=> $detail->field,
                "save_to"=> $detail->save_to,
                "method"=> $detail->method->name,
                "parameter" =>$detail->method->parameter,
                "waiting_time"=> $detail->waiting_time,
                "stream"=>$detail->stream,
                "group"=>$group_data
            );
            $data['id'] = $detail->id;
            if($this->input->post('back')){  
                $data["setting"][ "device"] = $this->input->post("device");
                $data["setting"]["field"]= $this->input->post("field");
                $data["setting"]["method"] = $this->input->post("method");
                $params = array();
                $item_method = array();
                foreach($data["method"] as $d){
                    if($d->name==$data["setting"]["method"]){
                        $item_method = $d;
                        break;
                    }
                }
                if(!empty($item_method)){
                    foreach($item_method->params as $d){
                        $params[$d->name]=$this->input->post($d->name);
                    }
                }
                $data["setting"]["params"] = $params;
                $group_process = $this->input->post("query");
                if(empty($group_process))
                    $group_process = [];
                $data["setting"]["group"] = $group_process;
                $device_data = $this->device_m->get_detail($data["setting"][ "device"]);
                if($device_data->status){
                    $device_data = $device_data->data;
                    $data["setting"]["list_field"] = $this->extract($device_data->field);
                }
            }  
		    $this->load->view('filter_edit_v', $data);
        } else {
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        }
	}		

	public function delete($id,$other=""){       
		if($id){
            $respo = $this->filter_m->del($id);
            if($respo->status){             
				redirect(base_url().'filter/?alert=success') ; 			
            } else {                
				redirect(base_url().'filter/?alert=failed') ; 			
            }                       
        }        
		redirect(base_url().'filter/?alert=failed') ; 			
	}

    public function simulation(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Filter Simulation - Device Data';	
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        
        $data['device_group'] = [];
        ////get goup////
        $data['group'] = []; 
        $device_groupcode = [];
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
        $device_groupcode = array(
            '$in' => $device_groupcode
        );
        $or = array();
        $or[] = array("group_code_name" =>$device_groupcode);
        $or[] = array("add_by" => $data['user_now']->id);
        $query = array(
            '$or' => $or
        );
        $data["data"] =  $this->device_m->search($query)->data;
        
        $data["method"] = array(
            array(
                "name" => "lowpass",
                "label" => "Low Pass Filter",
                "params" => array(
                    array(
                        "name" => "cutoff",
                        "label" => "Cutoff frequency",
                        "type" => "float"
                    )
                )
            ),
            array(
                "name" => "highpass",
                "label" => "High Pass Filter",
                "params" => array(
                    array(
                        "name" => "cutoff",
                        "label" => "Cutoff Frequency",
                        "type" => "float"
                    )
                )
            ),
            array(
                "name" => "bandpass",
                "label" => "Band Pass Filter",
                "params" => array(
                    array(
                        "name" => "low_cutoff",
                        "label" => "Low Cutoff Frequency",
                        "type" => "float"
                    ),
                    array(
                        "name" => "high_cutoff",
                        "label" => "High Cutoff Frequency",
                        "type" => "float"
                    )
                )
            ),
            array(
                "name" => "kalmanbasic",
                "label" => "Kalman Filter",
                "params" => array(
                    array(
                        "name" => "R",
                        "label" => "Noise Covariance", //Meaning Covariance????
                        "type" => "float"
                    ),
                    array(
                        "name" => "Q",
                        "label" => "Estimated Covariance", //Meaning Covariance????
                        "type" => "float"
                    )
                )
            )
        );
        $data["method"] = json_decode(json_encode($data["method"]));
        
        $data["setting"]=array(
            "device"=> "",
            "list_field"=>[],
            "field"=> "",
            "method"=> "",
            "parameter" =>[],
            "rollback"=>"add",
            "query"=>[]
        );
        if($this->input->post('save')){  
            if($this->input->post('save')=="add"){
                $rollback = "add";
            }else{
                $rollback = "edit";
            }
            $device = $this->input->post("device");
            $field = $this->input->post("field");
            $method = $this->input->post("method");
            $params = $this->input->post("params");
            $code = $this->input->post("filtercode");
            $group_process = $this->input->post("group");
            if(empty($group_process))
                $group_process = [];
            $device_data = $this->device_m->get_detail($device);
            $listfield = [];
            if($device_data->status){
                $device_data = $device_data->data;
                $listfield = $this->extract($device_data->field);
            }
            $data["setting"] = array(
        		"device"=> $device,
                "list_field"=>$listfield,
                "field"=> $field,
                "method"=> $method,
                "parameter" => $params,
                "rollback"=> $rollback,
                "query"=> $group_process
            );
            if(!empty($code)){
                $data["setting"]["code"] = $code;
            }
        }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
		$this->load->view('filter_simulation_v', $data);
	}

    public function process($id){       
        $data=array();
        $field = $this->input->post("field");
        $method = $this->input->post("method");
        $params = json_decode($this->input->post("params"), true);
        $date_start = $this->input->post("date_start");
        $time_start = $this->input->post("time_start").":00";
        $date_end = $this->input->post("date_end");
        $time_end = $this->input->post("time_end").":00";
        $search = json_decode($this->input->post("search"), true);
        $data = array(
            "field"=>strtoupper($field),
            "data"=>array(),
            "filter"=>array()
        );
        if(!empty($method) && !empty($params) ){
            $query = array(
                "date_start"=>  $date_start,
                "date_end"=>  $date_end,
                "time_start" => $time_start,
                "time_end" =>  $time_end,
                "method"=> $method,
                "field"=> $field,
                "parameters"=> $params
            );       
            if(!empty($search))
                $query["search"] = $search;
            $process = $this->filter_m->simulation($id,$query);
            $list = $process->data;          
            foreach($list as $d){
                if(!isset($d->{$field}))
                    continue;
                $data["data"][] = [$d->{'date_add_server'}->{'$date'},$d->{$field}];
                $data["filter"][] = [$d->{'date_add_server'}->{'$date'},$d->{"filter_".$field}];
            }
            if(isset($process->variance))
                $data["variance"] =  $process->variance;                
            if(isset($process->sample_time))
                $data["sample_time"] =  $process->sample_time;   
        } else {
            $query = array(
                "date_start"=>  $date_start,
                "date_end"=>  $date_end,
                "time_start" => $time_start,
                "time_end" =>  $time_end,
                "field"=> $field
            );   
            if(!empty($search))
                $query["search"] = $search;
            $process = $this->filter_m->summary($id,$query);
            $list = $process->data;          
            foreach($list as $d){
                if(!isset($d->{$field}))
                    continue;
                $data["data"][] = [$d->{'date_add_server'}->{'$date'},$d->{$field}];
            }
            $data["variance"] =  (!empty($process->variance))?$process->variance:array();                
            $data["sample_time"] =  (!empty($process->sample_time))?$process->sample_time:array();
        }
        header("Content-Type: application/json");
        echo json_encode($data);
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
