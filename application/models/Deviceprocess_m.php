<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class deviceprocess_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}				

	function add($data){
		$url = $this->config->item('url_node')."deviceprocess/add/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($data){
		$url = $this->config->item('url_node')."deviceprocess/edit/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id,$field){
		$data = array(
			"device_code" => $id,
			"field" => $field
		);
		$url = $this->config->item('url_node')."deviceprocess/delete/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function batch_process($code,$data){
		$url = $this->config->item('url_node')."deviceprocess/batch/".$code."/";			
		return json_decode($this->sendPost($url,$data));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
