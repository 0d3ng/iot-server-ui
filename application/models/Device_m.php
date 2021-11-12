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
		return json_decode($this->sendPost($url,$data));
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
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = array();
		return $result;
	}

	function count_datasensor($device,$data){
		$url = $this->config->item('url_node')."device/data/".$device."/count/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = 0;
		return $result;
	}

	
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
