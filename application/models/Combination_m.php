<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class combination_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get_detail($id){
		$data = array(
			"combi_code" => $id
		);
		$url = $this->config->item('url_node')."combination/detail/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."combination/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."combination/edit/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."combination/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."combination/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = array();
		return $result;
	}

	function search_count($data){
		$url = $this->config->item('url_node')."combination/count/";				
		return json_decode($this->sendPost($url,$data));
	}

	function datasensor($combination,$data){
		$url = $this->config->item('url_node')."combination/data/".$combination."/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = array();
		return $result;
	}

	function count_datasensor($combination,$data){
		$url = $this->config->item('url_node')."combination/data/".$combination."/count/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = 0;
		return $result;
	}
	
	function batch_process($combination,$data){
		$url = $this->config->item('url_node')."combination/batch/".$combination."/";			
		return json_decode($this->sendPost($url,$data));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
