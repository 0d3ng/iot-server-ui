<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ebtransaction extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('ebtransaction_m');       
		$this->load->model('ebmoney_m');
		$this->load->model('customer_m');
		$this->load->model('driver_m');
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
		if($this->input->get('alert')=='success') $data['success']='EB Money Transaction data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="EB Money Transaction data deleted failed";	
		if($this->input->get('alert')=='success2') $data['success']='EB Money Transaction paid successfully';	
		if($this->input->get('alert')=='failed2') $data['error']="EB Money Transaction paid failed";
		$data['title']='EB Money Transaction List';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		$query = array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"detail" => true
		);
		$data['data'] = $this->ebtransaction_m->search($query)->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		
		$this->load->view('ebtransaction_v', $data);
	}

	public function customer($id="")
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']='EB Money Transaction Customer';
		if(!$id){
			if($this->input->get('alert')=='success') $data['success']='EB Money Transaction data deleted successfully';	
			if($this->input->get('alert')=='failed') $data['error']="EB Money Transaction data deleted failed";	
			if($this->input->get('alert')=='success2') $data['success']='EB Money Transaction paid successfully';	
			if($this->input->get('alert')=='failed2') $data['error']="EB Money Transaction paid failed";
			$data['str_date'] = date("Y-m-d");
			$data['end_date'] = date("Y-m-d");
			if($this->input->get('str')){
				$data['str_date'] = $this->input->get('str');
			}
			if($this->input->get('end')){
				$data['end_date'] = $this->input->get('end');
			}
			$query = array(
				"detail" => true
			);
			$data['data'] = $this->ebmoney_m->search($query)->data;
			$data['user_now'] = $this->session->userdata('easy_admin');		        
			
			$this->load->view('ebtransaction_customer_v', $data);	
		} else {
			$query = array(
				"customer_id" => $id,
				"detail" => true
			);
			$data['data'] = $this->ebtransaction_m->search($query)->data;
			$data['user_now'] = $this->session->userdata('easy_admin');		        
			
			$this->load->view('ebtransaction_customer_detail_v', $data);
		}		
	}

	public function topup($index="",$id=""){
		if(empty($index)){
			$this->topup_index();
		} else if($index == 'add'){
			$this->topup_add();
		} else if($index == 'pay'){
			$this->topup_pay($id);
		} else if($index == 'detail'){
			$this->topup_detail($id);
		} 
	}

	public function topup_index(){        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='EB Money Transaction data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="EB Money Transaction data deleted failed";	
		if($this->input->get('alert')=='success2') $data['success']='EB Money Transaction paid successfully';	
		if($this->input->get('alert')=='failed2') $data['error']="EB Money Transaction paid failed";
		$data['title']='EB Money Topup';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		$data['all'] = 'date';
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		if($this->input->get('filter')){
			$data['all'] = $this->input->get('filter');
		}
		$data['user_now'] = $this->session->userdata('easy_admin');	
		$query = array(
				"str_date" => $data['str_date'],
				"end_date" => $data['end_date'],
				"detail" => true,
				"account" => 'TOP-UP'
			);
		$data['data'] = $this->ebtransaction_m->search($query)->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		$this->load->view('ebtransaction_topup_v', $data);
	}

	public function topup_add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Add New EB Money Topup';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"customer_id" => $this->input->post('customer'),
				"amount" => $this->input->post('amount')
        	);
        	$respo = $this->ebmoney_m->topup($input);        	        	
            if($respo->code == "E00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$data['customer'] = $this->customer_m->search(array("status" => 1))->data;
		$this->load->view('ebtransaction_topup_add_v', $data);
	}

	public function topup_detail($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'EB Money - Pay Topup';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){
	    	$respo = $this->ebmoney_m->topup_approve($id);        	        	
	        if($respo->code == "E00"){             
	            $data['success']=$respo->message;                  
	        } else {                
	            $data['error']=$respo->message;
	        }
        }
        $data['data'] = $this->ebtransaction_m->get_detail($id)->data[0];
		$this->load->view('ebtransaction_topup_pay_v', $data);
	}			

	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->ebtransaction_m->del($id);
			if($del->code == "E00"){
				redirect(base_url().'ebtransaction/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'ebtransaction/?alert=failed') ; 			
	}
	
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
