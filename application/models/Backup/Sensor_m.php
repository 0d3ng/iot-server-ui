<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sensor_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get_detail($user){
		$url = $this->config->item('url_node')."sensor/user/".$user;				
		return json_decode($this->getData($url));
	}

	function get_detail_sensor($id){
		$url = $this->config->item('url_node')."sensor/detail/".$id;				
		return json_decode($this->getData($url));
	}

	function add($data){
		$url = $this->config->item('url_node')."sensor/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($user,$id,$data){
		$url = $this->config->item('url_node')."sensor/edit/".$user."/".$id;				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($user,$id){
		$url = $this->config->item('url_node')."sensor/delete/".$user."/".$id;				
		return json_decode($this->getData($url));
	}

	function makedb($id){
		$url = $this->config->item('url_node')."sensoruser/make/".$id;				
		return json_decode($this->getData($url));
	}

	function makeinflux($id){
		$url = $this->config->item('url_node')."sensoruser/makeinflux/".$id;				
		return json_decode($this->getData($url));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
