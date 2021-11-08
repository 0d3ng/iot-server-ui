<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ebmoney_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function get_detail($id){
		$data = array(
			"id" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."ebmoney/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."ebmoney/insert/";				
		return json_decode($this->sendPost($url,$data));
	}

	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."ebmoney/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."ebmoney/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."ebmoney/total/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function topup($data){
		$url = $this->config->item('url_node')."ebmoney/topup/";				
		return json_decode($this->sendPost($url,$data));
	}

	function topup_upload($data){
		$url = $this->config->item('url_node')."ebmoney/topup/upload/";				
		return json_decode($this->sendCurl($url,$data));
	}

	function topup_approve($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."ebmoney/topup/approve/";				
		return json_decode($this->sendPost($url,$data));
	}
}

/* End of file ebmoney_model.php */
/* Location: ./application/models/ebmoney_Model.php */
