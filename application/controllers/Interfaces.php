<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interfaces extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
        $this->load->model('groupsensor_m');
		$this->load->model('device_m');
		$this->load->model('interface_m');
        $this->limit_data = 3000;
        $this->limit_table = 25;
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
    }

    public function device($code=""){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete data interface successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete data interface";	
		$data['title']='Data Interface List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');

        $query = array(
            "resource" => "device",
            "add_by" => $data['user_now']->id
        );
        if(!empty($data["type"]))
            $query["resource"] =  $data["type"];
        $data["code"] = $code;
        if(!empty($data["code"]))
            $query["resource_code"] =  $data["code"];

        $data["data"] =  $this->interface_m->search($query);
        if($data["data"]->status){
            $data["data"] = $data["data"]->data;
        } else {
            $data['data'] = array();
        }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        $this->load->view('interface_v', $data);
	}

    public function maps($id=""){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete data interface successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete data interface";	
		$data['title']='Data Interface List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');

        $data["interfaces"] = $this->interface_m->get_detail($id);
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
        
        if($data["interfaces"]->status){
            $data["interfaces"] = $data["interfaces"]->data;
            $sensor_code = $data["interfaces"]->resource_code;
            $data['data'] = $this->device_m->get_detail($sensor_code)->data; 
            $data['extract'] = $this->extract($data['data']->field);
            
        } else {
            $data["interfaces"] = array();
        }
        $this->load->view('interface_maps_v', $data);
	}

    
    public function heatmaps($id=""){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete data interface successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete data interface";	
		$data['title']='Data Interface List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');

        $data["interfaces"] = $this->interface_m->get_detail($id);
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
        
        if($data["interfaces"]->status){
            $data["interfaces"] = $data["interfaces"]->data;
            $sensor_code = $data["interfaces"]->resource_code;
            $data['data'] = $this->device_m->get_detail($sensor_code)->data; 
            $data['extract'] = $this->extract($data['data']->field);
            
        } else {
            $data["interfaces"] = array();
        }
        $this->load->view('interface_heat_maps_v', $data);
	}

    
    public function clustermaps($id=""){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete data interface successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete data interface";	
		$data['title']='Data Interface List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');

        $data["interfaces"] = $this->interface_m->get_detail($id);
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
        
        if($data["interfaces"]->status){
            $data["interfaces"] = $data["interfaces"]->data;
            $sensor_code = $data["interfaces"]->resource_code;
            $data['data'] = $this->device_m->get_detail($sensor_code)->data; 
            $data['extract'] = $this->extract($data['data']->field);
            
        } else {
            $data["interfaces"] = array();
        }
        $this->load->view('interface_cluster_maps_v', $data);
	}


    public function resource($id){
        $device = $this->device_m->get_detail($id)->data; 
        $extract = $this->extract($device->field);
        $query = array();
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
            // $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_server_unix"}/1000);
            $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_server"}->{'$date'}/1000);
            $data[] = $item;
        }    
        header('Content-Type: application/json; charset=utf-8');   
        echo json_encode($data);
    }

    public function resource_month($id){
        $device = $this->device_m->get_detail($id)->data; 
        $extract = $this->extract($device->field);        
        $query = array();
        $count_data = $this->device_m->count_datasensor($device->device_code,$query)->data;
        $year = date("Y");
        $month = date("m");
        if($this->input->get('year'))
            $year = $this->input->get('year');
        if($this->input->get('month'))
            $month = $this->input->get('month');

        $date_start = "$year-$month-1";
        $date_end = date("Y-m-t", strtotime($date_start));

        $query = array(
            "date_start"=> $date_start,
            "date_end"=> $date_end
        );

        if($this->input->get('skip'))
            $offset = $this->input->get('skip');
        if($this->input->get('limit'))
            $limit = $this->input->get('limit');
        
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
            // $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_server_unix"}/1000);
            $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_server"}->{'$date'}/1000);
            $data[] = $item;
        }    
        header('Content-Type: application/json; charset=utf-8');   
        echo json_encode($data);
    }

    public function chart($id=""){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete data interface successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete data interface";	
		$data['title']='Data Interface List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');

        $data["interfaces"] = $this->interface_m->get_detail($id);
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
        
        if($data["interfaces"]->status){
            $data["interfaces"] = $data["interfaces"]->data;
            $sensor_code = $data["interfaces"]->resource_code;
            $data['data'] = $this->device_m->get_detail($sensor_code)->data; 
            $data['extract'] = $this->extract($data['data']->field);
            $query = array(
                "date_start" => $data["date_str"],
                "date_end" => $data["date_end"]
            );
    
            if($data["with_time"]){
                $query["time_end"] = $data["time_end"].":00";
                $query["time_start"] = $data["time_str"].":00";
            }
            $data['sensor'] = $this->device_m->datasensor($data['data']->device_code,$query)->data;
            if(!empty($data['sensor'])) 
                $data['sensor'] = array_reverse((array)$data['sensor']);
        } else {
            $data["interfaces"] = array();
        }
        // echo"<pre>";
        // print_r($data);
        // echo"</pre>";
        // exit();
        $this->load->view('interface_chart_v', $data);
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
