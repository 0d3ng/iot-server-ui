<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ebtransaction_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function get_detail($id){
		$data = array(
			"id" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."ebtransaction/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."ebtransaction/insert/";				
		return json_decode($this->sendPost($url,$data));
	}

	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."ebtransaction/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."ebtransaction/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."ebtransaction/total/";				
		return json_decode($this->sendPost($url,$data));
	}
	
}

/* End of file ebtransaction_model.php */
/* Location: ./application/models/ebtransaction_Model.php */
