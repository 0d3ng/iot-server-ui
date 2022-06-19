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

    public function simulation(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Filter Simulation - Device Data';	
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        
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
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
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
            )
        );
        $data["method"] = json_decode(json_encode($data["method"]));
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
        $search = array(); //$this->input->post("search");
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
            $data["variance"] =  $process->variance;                
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
            $data["variance"] =  $process->variance;                
            $data["sample_time"] =  $process->sample_time;             
        }
        header("Content-Type: application/json");
        echo json_encode($data);
    } 

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
