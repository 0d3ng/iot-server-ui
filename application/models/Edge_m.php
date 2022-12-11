<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class edge_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get_detail($id){
		$data = array(
			"edgeconfig_code" => $id
		);
		$url = $this->config->item('url_node')."device/edge/detail/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."device/edge/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."device/edge/edit/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."device/edge/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."device/edge/list/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = array();
		return $result;
	}

	function search_count($data){
		$url = $this->config->item('url_node')."device/edge/count/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function process($data){
		$url = $this->config->item('url_node')."device/edge/config/process/";				
		return json_decode($this->sendPost($url,$data));
	}

	function device_remote_update($data){
		$url = $this->config->item('url_node')."device/edge/device/update/";				
		return json_decode($this->sendPost($url,$data));
	}

	function device_config_download($data){
		$url = $this->config->item('url_node')."device/edge/device/config/";				
		return json_decode($this->sendPost($url,$data));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
