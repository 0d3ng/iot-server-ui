<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class transaction_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function get_detail($id){
		$data = array(
			"id" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."transaction/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."transaction/insert/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."transaction/update/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."transaction/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."transaction/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."transaction/total/";				
		return json_decode($this->sendPost($url,$data));
	}

	function status($id,$status){
		$data = array(
			"id" => $id,
			"status" => $status
		);
		$url = $this->config->item('url_node')."transaction/status/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_group($data){
		$url = $this->config->item('url_node')."transaction/getgroup/";				
		return json_decode($this->sendPost($url,$data));
	}

	// function activation($user,$data){
	// 	$url = $this->config->item('url_node')."user/activation/".$user;				
	// 	return json_decode($this->sendPost($url,$data));
	// }

	// function resetpass($user,$data){
	// 	$url = $this->config->item('url_node')."user/resetpass/".$user;				
	// 	return json_decode($this->sendPost($url,$data));
	// }
}

/* End of file transaction_model.php */
/* Location: ./application/models/transaction_Model.php */
