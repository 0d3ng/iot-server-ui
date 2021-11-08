<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class admin_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function get_detail($id){
		$data = array(
			"id" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."admin/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."admin/insert/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."admin/update/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."admin/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."admin/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."admin/total/";				
		return json_decode($this->sendPost($url,$data));
	}

	function status($id,$status){
		$data = array(
			"id" => $id,
			"status" => $status
		);
		$url = $this->config->item('url_node')."admin/status/";				
		return json_decode($this->sendPost($url,$data));
	}

	function login($username, $pass){
		$data = array(
			"username" => $username,
			"password" => $pass,
			'business_access'=>1
		);
		$url = $this->config->item('url_node')."admin/login/";				
		return json_decode($this->sendPost($url,$data));
	}

	function reset_password($data){
		$url = $this->config->item('url_node')."admin/resetpassword/";				
		return json_decode($this->sendPost($url,$data));
	}

	function update_pass($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."admin/updatepass/";				
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

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
