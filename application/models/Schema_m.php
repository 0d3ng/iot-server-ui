<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class schema_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get_detail($id){
		$data = array(
			"schema_code" => $id
		);
		$url = $this->config->item('url_node')."schema/detail/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."schema/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."schema/edit/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."schema/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."schema/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = array();
		return $result;
	}

	function search_count($data){
		$url = $this->config->item('url_node')."schema/count/";				
		return json_decode($this->sendPost($url,$data));
	}

	function datasensor($schema,$data){
		$url = $this->config->item('url_node')."schema/data/".$schema."/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = array();
		return $result;
	}

	function count_datasensor($schema,$data){
		$url = $this->config->item('url_node')."schema/data/".$schema."/count/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = 0;
		return $result;
	}

	function add_data($schema,$data){
		$url = $this->config->item('url_node')."schema/data/".$schema."/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit_data($schema,$id,$data){
		$data+=["_id" => $id];
		$url = $this->config->item('url_node')."schema/data/".$schema."/edit/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del_data($schema,$id){
		$data = array(
			"_id" => $id
		);
		$url = $this->config->item('url_node')."schema/data/".$schema."/delete/";				
		return json_decode($this->sendPost($url,$data));
	}

	function get_detail_data($schema,$id){
		$data = array(
			"_id" => $id
		);
		$url = $this->config->item('url_node')."schema/data/".$schema."/detail/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function findone_data($schema,$query){
		$url = $this->config->item('url_node')."schema/data/".$schema."/detail/";				
		return json_decode($this->sendPost($url,$query));
	}

	function findone_data2($url,$schema,$query){
		if(empty($url)){
			$url = $this->config->item('url_node');
		}
		$url = $url."schema/data/".$schema."/detail/";				
		return json_decode($this->sendPost($url,$query));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
