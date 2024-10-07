<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class device_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get_detail($id){
		$data = array(
			"device_code" => $id
		);
		$url = $this->config->item('url_node')."device/detail/";
        $result =  $this->sendPost($url,$data);
        log_message('debug',"result ". static::class."= $result");
		return json_decode($result);
	}

	function add($data){
		$url = $this->config->item('url_node')."device/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."device/edit/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."device/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."device/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = array();
		return $result;
	}

	function search_count($data){
		$url = $this->config->item('url_node')."device/count/";				
		return json_decode($this->sendPost($url,$data));
	}

	function datasensor($device,$data){
		$url = $this->config->item('url_node')."device/data/".$device."/";
        $result =  $this->sendPost($url,$data);
        log_message('debug',"result ". static::class."= $result");
        $decode_json = json_decode($result);
        if(!$decode_json->status)
            $decode_json->data = array();
		return $decode_json;
	}

	function count_datasensor($device,$data){
		$url = $this->config->item('url_node')."device/data/".$device."/count/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = 0;
		return $result;
	}

	function add_other($data){
		$url = $this->config->item('url_node')."device/add/other/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit_other($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."device/edit/other/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del_other($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."device/delete/other/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function get_com_chanel($data){
		$url = $this->config->item('url_node')."comchannel/detail/";				
		return json_decode($this->sendPost($url,$data));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
