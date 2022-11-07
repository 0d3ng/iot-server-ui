<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {

	public function __construct() {
        parent::__construct();  
		$this->load->model('schema_m');
		$this->load->model('device_m');
        $this->device_code = "xs46";
        $this->mqtt_realtime = "sensor/logger";
    }

	public function index()
	{        
		$data=array();
        $data['success']='';
        $data['error']='';
        $data['mqtt']=$this->mqtt_realtime;
		$data['title']='Home';
		$data['channel_list']= ["1","2","3","4","5","6","7","8","9","10"];     
        $data["date"] = date("Y-m-d");
		$data['channel']= "1";
        if($this->input->get('date')){
            $data["date"] = $this->input->get('date');
        }
        if($this->input->get('channel')){
            $data['channel'] = $this->input->get('channel');   
        }
        $query = array(
            "date_start"=> $data["date"],
            "date_end"=> $data["date"]
        );
        $data['sensor'] = $this->device_m->datasensor($this->device_code,$query)->data;
        $data['lastdata'] = 0;
        if(!empty($data['sensor'])){
            $data['sensor'] = array_reverse((array)$data['sensor']);
            $data['lastdata'] = $data['sensor'][count($data['sensor'])-1];
        }
        // print("<pre>");
        // print_r($data);
        // print("</pre>");
        // exit();
		$this->load->view('logger/home_v', $data);
	}
    
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
