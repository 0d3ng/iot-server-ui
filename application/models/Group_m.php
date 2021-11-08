<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class group_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get_detail($id){
		$data = array(
			"group_code" => $id
		);
		$url = $this->config->item('url_node')."group/detail/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."group/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."group/edit/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."group/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."group/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."group/count/";				
		return json_decode($this->sendPost($url,$data));
	}

	function addMember($data){
		$url = $this->config->item('url_node')."group/member/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function editMember($data){
		$url = $this->config->item('url_node')."group/member/edit/";				
		return json_decode($this->sendPost($url,$data));
	}

	function removeMember($data){
		$url = $this->config->item('url_node')."group/member/delete/";				
		return json_decode($this->sendPost($url,$data));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
