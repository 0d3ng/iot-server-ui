<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get_detail($id){
		$data = array(
			'id'=>$id	
		);
		$url = $this->config->item('url_node')."user/detail/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data['id'] = $id;
		$url = $this->config->item('url_node')."user/edit/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit_pass($id,$data){
		$data['id'] = $id;
		$url = $this->config->item('url_node')."user/pass/";				
		return json_decode($this->sendPost($url,$data));
	}

	function login($email, $pass){
		$data = array(
			"email" => $email,
			"password" => $pass
		);
		$url = $this->config->item('url_node')."user/login/";				
		return json_decode($this->sendPost($url,$data));
	}

	function activation($email, $token){
		$data = array(
			"email" => $email,
			"otp" => $token,
			"sendlink" => true
		);
		
		$url = $this->config->item('url_node')."user/activation/";	
		return json_decode($this->sendPost($url,$data));
	}

	function register($email, $pass, $name){
		$data = array(
			"email" => $email,
			"name" => $name,
			"password" => $pass,
			"sendlink" => true,
			"link" => $this->config->item('index_page').'auth/activation/'
		);
		$url = $this->config->item('url_node')."user/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function reset_password($data){
		$url = $this->config->item('url_node')."user/forgetpassword/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search($data){
		$url = $this->config->item('url_node')."user/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."user/count/";				
		return json_decode($this->sendPost($url,$data));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
