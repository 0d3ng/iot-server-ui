<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class datasync_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get_detail($id){
		$data = array(
			"datasync_code" => $id
		);
		$url = $this->config->item('url_node')."datasync/detail/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."datasync/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."datasync/edit/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."datasync/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."datasync/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = array();
		return $result;
	}

	function search_count($data){
		$url = $this->config->item('url_node')."datasync/count/";				
		return json_decode($this->sendPost($url,$data));
	}

	function datasensor($datasync,$data){
		$url = $this->config->item('url_node')."datasync/data/".$datasync."/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = array();
		return $result;
	}

	function count_datasensor($datasync,$data){
		$url = $this->config->item('url_node')."datasync/data/".$datasync."/count/";				
		$result =  json_decode($this->sendPost($url,$data));
		if(!$result->status)
			$result->data = 0;
		return $result;
	}
	
	function batch_process($datasync,$data){
		$url = $this->config->item('url_node')."datasync/batch/".$datasync."/";			
		return json_decode($this->sendPost($url,$data));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
