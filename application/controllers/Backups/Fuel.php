<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fuel extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('fuel_m');
		//$this->load->model('aes_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Fuel data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Fuel data deleted failed";	
		$data['title']='Fuel List';
		$data['data'] = $this->fuel_m->search(array())->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		
		$this->load->view('fuel_v', $data);
	}

	public function add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Fuel Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"fuel" => $this->input->post('fuel'),
				"price" => $this->input->post('price'),
				"information" => $this->input->post('information'),
				"update_by" => $data['user_now']->admin_id
        	);
        	$respo = $this->fuel_m->add($input);
        	
        	
            if($respo->code == "F00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('fuel_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Fuel Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"fuel" => $this->input->post('fuel'),
				"price" => $this->input->post('price'),
				"information" => $this->input->post('information'),
				"update_by" => $data['user_now']->admin_id
        	);
        	$respo = $this->fuel_m->edit($id,$input);
            if($respo->code == "F00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->fuel_m->get_detail($id)->data[0];        
		$data['id'] = $id;
		$this->load->view('fuel_edit_v', $data);
	}			

	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->fuel_m->del($id);
			if($del->code == "F00"){
				redirect(base_url().'fuel/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'fuel/?alert=failed') ; 			
	}
	

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
