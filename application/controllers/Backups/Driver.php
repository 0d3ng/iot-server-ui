<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('driver_m');
		//$this->load->model('aes_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Driver data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Driver data deleted failed";	
		if($this->input->get('alert')=='success2') $data['success']='Driver activation successfully';	
		if($this->input->get('alert')=='failed2') $data['error']="Driver activation failed";
		if($this->input->get('alert')=='success3') $data['success']='Driver suspend successfully';	
		if($this->input->get('alert')=='failed3') $data['error']="Driver suspend failed";
		$data['title']='Driver List';

		$hal = $this->input->get('hal');
		if( $this->input->get('hal') == '' ) $hal = 1;
		$data['name'] = '';
		$limit = 16;
		$query = array(
			'limit' => $limit,
			'skip' => ($hal-1) * $limit
		);
		$query2 = array();
		if($this->input->get('number')){
			$data['nama'] = $this->input->get('number');
			$query['kecamatan'] = $data['kec'];
			$query2['kecamatan'] = $data['kec'];
		}


		$data['data'] = $this->driver_m->search(array())->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		
		$this->load->view('driver_v', $data);
	}

	public function add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Driver Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"name" => $this->input->post('name'),
				"phone" => $this->input->post('phone'),
				"username" => $this->input->post('username'),
				"password" => $this->input->post('password'),
				"email" => $this->input->post('email'),
				"ktp" => $this->input->post('ktp'),
				"sim" => $this->input->post('sim'),
				"birth" => $this->input->post('birth'),
				"address" => trim($this->input->post('address')),
				"gender" => $this->input->post('gender'),
				"status" => 1,
				"add_by" => $data['user_now']->admin_id
        	);
        	
        	if($this->input->post('sendmail')){
        		$input+=['sendmail'=>true];
        	}
        	$respo = $this->driver_m->add($input);
        	
        	
            if($respo->code == "D00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('driver_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Driver Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"name" => $this->input->post('name'),
				"phone" => $this->input->post('phone'),
				"email" => $this->input->post('email'),
				"ktp" => $this->input->post('ktp'),
				"sim" => $this->input->post('sim'),
				"birth" => $this->input->post('birth'),
				"address" => trim($this->input->post('address')),
				"gender" => $this->input->post('gender')
        	);
        	$respo = $this->driver_m->edit($id,$input);
            if($respo->code == "D00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->driver_m->get_detail($id)->data[0];        
		$data['id'] = $id;
		$this->load->view('driver_edit_v', $data);
	}			

	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->driver_m->del($id);
			if($del->code == "D00"){
				redirect(base_url().'driver/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'driver/?alert=failed') ; 			
	}
	
	public function active($id=''){

        $del = $this->driver_m->status($id,'active');
        if($del->code == "D00"){         
            redirect(base_url().'driver/?alert=success2');
        }
        redirect(base_url().'driver/?alert=failed2');
    }

    public function nonactive($id=''){

        $del = $this->driver_m->status($id,'not-active');
        if($del->code == "D00"){           
            redirect(base_url().'driver/?alert=success3');
        }
        redirect(base_url().'driver/?alert=failed3');
    }

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
