<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Car extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('cardriver_m');
		$this->load->model('car_m');
		//$this->load->model('aes_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Car data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Car data deleted failed";	
		$data['title']='Car List';
		$data['data'] = $this->car_m->search(array())->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		
		$this->load->view('car_v', $data);
	}

	public function add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Car Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"capacity" => $this->input->post('capacity'),
				"vehicle_number" => $this->input->post('vnumber'),
				"model" => $this->input->post('model'),
				"body_machine" => $this->input->post('body-machine'),
				"stnk" => $this->input->post('stnk'),
				"owner" => $this->input->post('owner'),
				"add_by" => $data['user_now']->admin_id
        	);
        	$respo = $this->car_m->add($input);
        	
        	
            if($respo->code == "C00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('car_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Car Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"capacity" => $this->input->post('capacity'),
				"vehicle_number" => $this->input->post('vnumber'),
				"model" => $this->input->post('model'),
				"body_machine" => $this->input->post('body-machine'),
				"stnk" => $this->input->post('stnk'),
				"owner" => $this->input->post('owner')
        	);
        	$respo = $this->car_m->edit($id,$input);
            if($respo->code == "C00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->car_m->get_detail($id)->data[0];        
		$data['id'] = $id;
		$this->load->view('car_edit_v', $data);
	}		

	public function maps()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Car data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Car data deleted failed";	
		$data['title']='Car Maps';
		$data['data'] = $this->car_m->search(array())->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		
		$data['cardriver_m'] = $this->cardriver_m;        
		$this->load->view('car_maps_v', $data);
	}

	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->car_m->del($id);
			if($del->code == "C00"){
				redirect(base_url().'car/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'car/?alert=failed') ; 			
	}
	

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
