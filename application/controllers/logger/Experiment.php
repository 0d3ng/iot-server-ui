<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class experiment extends CI_Controller {

	public function __construct() {
        parent::__construct();  
		$this->load->model('schema_m');
		$this->load->model('device_m');
        $this->device_code = "xs46";
        $this->exp_schema_code = "n2mjlr";
        $this->expdata_schema_code = "8zl2vf";
        $this->config_schema_code = "9jb9s5";
        $this->mqtt_realtime = "sensor/logger";
    }

	public function index()
	{        
		$data=array();
        $data['success']='';
        $data['error']='';
        $data['title']= 'Experiment Data - Add New Data';
        if($this->input->get('alert')=='success') $data['success']='Delete data successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete data";	
           
        $schema = $this->schema_m->get_detail($this->exp_schema_code);
        if(!$schema->status){
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
            exit();
        } 
        $data['schema'] = $schema->data;
        $data['extract'] = $this->extract($data['schema']->field);
        $data['extract'] = array("code","temperature_target","timer","state","start","finish","duration","email target","reminder");
        $data["date_str"] = date("Y-m-d");
        $data["date_end"] = date("Y-m-d");
        $data["search"] = FALSE;
        
        if($this->input->get('start'))
            $data["date_str"] = $this->input->get('start');
        if($this->input->get('end'))
            $data["date_end"] = $this->input->get('end');
        if($this->input->get('search'))
            $data["search"] = TRUE;

        // print("<pre>");
        // print_r($data);
        // print("</pre>");
        // exit();    
        $this->load->view('logger/experiment_v', $data);
	}


    public function datatable(){
        $query = array();
        $schema = $this->schema_m->get_detail($this->exp_schema_code)->data; 
        $extract = $this->extract($schema->field);
        $limit=$this->input->get('limit');
        $offset=$this->input->get('offset');
        $order = $this->input->get('order');
        $sort = $this->input->get('sort');
        
        if($this->input->get('start'))
            $date_str = $this->input->get('start');
        if($this->input->get('end'))
            $date_end = $this->input->get('end');
        $query = array();
        if( isset($date_str) and isset($date_end) ){
            $query = array(
                "date_start" => $date_str,
                "date_end" => $date_end
            );
        }
        
        $count_data = $this->schema_m->count_datasensor($this->exp_schema_code,$query)->data;
        if(!empty($limit))
            $query["limit"] = intval($limit);
        if(!empty($offset))
            $query["skip"] = intval($offset);        

        if(!empty($order) && !empty($sort) ){
            $field = $sort;
            if($sort == "date")
                $field = "date_add_auto";
            if($order == "asc")
                $type = 1;
            else 
                $type = -1;
            $query["sort"] = array(
                "field" => $field,
                "type" => $type
            );
        }
        if(empty($offset) && empty($limit)){            
            $export = true;
            $limit=1000;
            $page = ceil($count_data / $limit);
            $data = array();
            for($x=0; $x<$page; $x++){
                $query["skip"] = $x*$limit;
                $query["limit"] = $limit;
                $list = $this->schema_m->datasensor($this->exp_schema_code,$query)->data;
                foreach($list as $d){
                    $item = array(
                        "code"=>$d->{"experiment_code"},
                        "temperature_target"=>number_format($d->{"temperature_target"}, 0, ',', '.'),
                        "timer"=>$d->{"timer"},
                        "state"=>$d->{"state"},
                        "start"=>$d->{"start"},
                        "finish"=>$d->{"finish"},
                        "duration"=>$d->{"time_total"},
                        "email target"=>$d->{"email_target"},
                        "reminder"=>$d->{"reminder"},
                    );
                    if($item["state"]){
                        $item["state"] = ' <span class="badge badge-primary">In Experiment</span> ';
                    } else {
                        $item["state"] = ' <span class="badge badge-dark">Finish</span> ';
                    }
                    $item["date"] = date('Y-m-d', $d->{"date_add_auto"}->{'$date'}/1000);
                    $item["time"] = date('H:i:s', $d->{"date_add_auto"}->{'$date'}/1000);
                    if(!empty($d->_id))
                        $iddata = $d->_id;
                    else
                        $iddata = $d->id;
                    $data[] = $item;
                }
            }
        } else{
            $export = false;
            $list = $this->schema_m->datasensor($this->exp_schema_code,$query)->data;
            $data = array();
            foreach($list as $d){
                $item = array(
                    "code"=>$d->{"experiment_code"},
                    "temperature_target"=>number_format($d->{"temperature_target"}, 0, ',', '.')."<span>&#176;</span>C",
                    "timer"=>$d->{"timer"},
                    "state"=>$d->{"state"},
                    "start"=>$d->{"start"},
                    "finish"=>$d->{"finish"},
                    "duration"=>$d->{"time_total"},
                    "email target"=>$d->{"email_target"},
                    "reminder"=>$d->{"reminder"},
                );
                $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_auto"}->{'$date'}/1000);
                if($export){
                    $item["date"] = date('Y-m-d', $d->{"date_add_auto"}->{'$date'}/1000);
                    $item["time"] = date('H:i:s', $d->{"date_add_auto"}->{'$date'}/1000);
                }
                if(!empty($d->_id))
                    $iddata = $d->_id;
                else
                    $iddata = $d->id;
                if(!$export)
                $item["action-form"] = '
                    <a href="'.base_url().'logger/detail/'.$iddata.'" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                    data-toggle="tooltip" data-original-title="Edit"><i class="icon md-search" aria-hidden="true"></i></a>';
                $data[] = $item;
            }
        }                    
        $response = array(
            "total" => $count_data,
            "rows" =>  $data,
            "export" => $export,
            "query" => $query
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
