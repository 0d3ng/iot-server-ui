<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

	public function __construct() {
        parent::__construct();  
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
        $this->load->model('groupsensor_m');
    }

	public function index()
	{        
		$data=array();
		$data['title']='Home';
		$data['max_panel']= 2;
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $group = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "view_dashboard"=>true));
        $panel = array(); $i = 0;
   		if($group->status){
   			if(!empty($group->data)){
	        	foreach ($group->data as $d) {
		        	$panel[$i++] = $d;
		        }	
		    }
        } 	        
		$data['panel']= $panel;
		$this->load->view('index', $data);
	}	
	/* 
	LIST MENU
	Home	
	Group Device
	Device
	*/

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
