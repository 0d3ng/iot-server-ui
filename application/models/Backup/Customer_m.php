<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class customer_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function get_detail($id){
		$data = array(
			"id" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."customer/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."customer/insert/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."customer/update/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."customer/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."customer/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."customer/total/";				
		return json_decode($this->sendPost($url,$data));
	}

	function status($id,$status){
		$data = array(
			"id" => $id,
			"status" => $status
		);
		$url = $this->config->item('url_node')."customer/status/";				
		return json_decode($this->sendPost($url,$data));
	}

	function login($email, $pass){
		$data = array(
			"email" => $email,
			"password" => $pass
		);
		$url = $this->config->item('url_node')."customer/login/";				
		return json_decode($this->sendPost($url,$data));
	}

	function reset_password($data){
		$url = $this->config->item('url_node')."customer/resetpassword/";				
		return json_decode($this->sendPost($url,$data));
	}

	function activation($data){
		$url = $this->config->item('url_node')."customer/activation/";				
		return json_decode($this->sendPost($url,$data));
	}

	function update_pass($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."customer/updatepass/";				
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

/* End of file customer_model.php */
/* Location: ./application/models/customer_Model.php */
