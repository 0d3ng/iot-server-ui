<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('customer_m');
		//$this->load->model('aes_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Customer data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Customer data deleted failed";	
		if($this->input->get('alert')=='success2') $data['success']='Customer activation successfully';	
		if($this->input->get('alert')=='failed2') $data['error']="Customer activation failed";
		if($this->input->get('alert')=='success3') $data['success']='Customer suspend successfully';	
		if($this->input->get('alert')=='failed3') $data['error']="Customer suspend failed";
		$data['title']='Customer List';
		$data['data'] = $this->customer_m->search(array())->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		
		$this->load->view('customer_v', $data);
	}

	public function add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Customer Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"name" => $this->input->post('name'),
				"phone" => $this->input->post('phone'),
				"username" => $this->input->post('username'),
				"password" => $this->input->post('password'),
				"email" => $this->input->post('email'),
				"ktp" => $this->input->post('ktp'),
				"birth" => $this->input->post('birth'),
				"address" => trim($this->input->post('address')),
				"gender" => $this->input->post('gender'),
				"status" => 1,
				"add_by" => $data['user_now']->admin_id
        	);
        	
        	if($this->input->post('sendmail')){
        		$input+=['sendmail'=>true];
        	}
        	$respo = $this->customer_m->add($input);
        	
        	
            if($respo->code == "E00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('customer_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Customer Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"name" => $this->input->post('name'),
				"phone" => $this->input->post('phone'),
				"email" => $this->input->post('email'),
				"ktp" => $this->input->post('ktp'),
				"birth" => $this->input->post('birth'),
				"address" => trim($this->input->post('address')),
				"gender" => $this->input->post('gender')
        	);
        	$respo = $this->customer_m->edit($id,$input);
            if($respo->code == "E00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->customer_m->get_detail($id)->data[0];        
		$data['id'] = $id;
		$this->load->view('customer_edit_v', $data);
	}			

	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->customer_m->del($id);
			if($del->code == "E00"){
				redirect(base_url().'customer/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'customer/?alert=failed') ; 			
	}
	
	public function active($id=''){

        $del = $this->customer_m->status($id,'active');
        if($del->code == "E00"){         
            redirect(base_url().'customer/?alert=success2');
        }
        redirect(base_url().'customer/?alert=failed2');
    }

    public function nonactive($id=''){

        $del = $this->customer_m->status($id,'not-active');
        if($del->code == "E00"){           
            redirect(base_url().'customer/?alert=success3');
        }
        redirect(base_url().'customer/?alert=failed3');
    }

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
