<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_m');
		$this->load->model('car_m');
		$this->load->model('driver_m');
		$this->load->model('transaction_m');		
		$this->load->model('ebtransaction_m');
		$this->load->model('fuel_m');
		$this->load->model('ebmoney_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "authuser/login");
	}
	
	public function index(){        
		$data=array();
		$data['title']='Main Page';
		//$data['menu_sensor'] = $this->sensor_m->get_detail($this->session->userdata('semar_admin')->username)->data;	
		//$data['user_now'] = $this->session->userdata('semar_admin');		
        $data['user_now'] = $this->session->userdata('easy_admin');
		$this->load->view('index', $data);
	}	

	 public function myprofile(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'My Profile Setting';		
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
        	$respo = $this->customer_m->edit(number_format($data['user_now']->customer_id,0,'',''),$input);
            if($respo->code == "E00"){
            	$role = $data['user_now']->user_role;
            	$data['user_now'] = $this->customer_m->get_detail(number_format($data['user_now']->customer_id,0,'',''))->data[0];
            	$array = (array) $data['user_now']; 
                $array["user_role"] = $role;
                $data['user_now'] = (object) $array;
                $this->session->set_userdata('easy_admin',$data['user_now']);             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }                
		$this->load->view('customer_profile_v', $data);
	}

	public function setting(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Password Setting';
		$data['user_now'] = $this->session->userdata('easy_admin');	
		if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('old_password', 'Old Password', 'required');
			$this->form_validation->set_rules('password', 'New Password', 'required|matches[passconf]|min_length[6]');
			$this->form_validation->set_rules('passconf', 'Konfirmasi password', 'required');
			if ($this->form_validation->run() == FALSE){
				$data['error'] = trim(validation_errors());
			}
		    else{
		    	$input=array(
					'password' => $this->input->post('password'),
					'oldpassword' => $this->input->post('old_password')
				);
				$respo = $this->customer_m->update_pass(number_format($data['user_now']->customer_id,0,'',''),$input);
				if($respo->code == "E00"){				
					$data['success']=$respo->message;					
				} else {				
					$data['error']=$respo->message;
				}						
		    }
		}
		$this->load->view('user_setting_v', $data);
	}	

	public function transaction($index="",$id=""){        
		if(empty($index)){
			$this->trans_index();
		} else if($index == 'cancel'){
			$this->trans_delete($id);
		} else if($index == 'add'){
			$this->trans_add();
		} else if($index == 'detail'){
			$this->trans_detail($id);
		}	
	}

	function trans_index(){
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Transaction data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Transaction data deleted failed";	
		if($this->input->get('alert')=='success2') $data['success']='Transaction paid successfully';	
		if($this->input->get('alert')=='failed2') $data['error']="Transaction paid failed";
		$data['title']='My Transaction';
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
		if($data['all'] == 'date'){	
			$query = array(
				"str_date" => $data['str_date'],
				"end_date" => $data['end_date'],
				"detail" => true,
				"customer_id" => number_format($data['user_now']->customer_id,0,'','')
			);
		} else {
			$query = array(
				"detail" => true,
				"customer_id" => number_format($data['user_now']->customer_id,0,'','')
			);
		}
		$data['data'] = $this->transaction_m->search($query)->data;
		$this->load->view('user_transaction_v', $data);
	}

	function trans_delete($id=''){					
		if(!empty($id)){
			$del=$this->transaction_m->del($id);
			if($del->code == "E00"){
				redirect(base_url('user').'/transaction/?alert=success') ; 			
			} 
		}
		redirect(base_url('user').'/transaction/?alert=failed') ; 			
	}

	public function trans_add(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'New Order Transaction';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"customer_id" => number_format($data['user_now']->customer_id,0,'',''),
				"total_fuel" => $this->input->post('fuel-total'),
				"fuel_type" => $this->input->post('fuel-type'),
				"price" => $this->input->post('price'),
				"pay" => $this->input->post('pay'),
				"location_lat" => $this->input->post('location-lat'),
				"location_lng" => $this->input->post('location-lng'),
				"location_address" => $this->input->post('address'),
				"note" => $this->input->post('note'),
				"date_add" => $this->input->post('date-add'),
				"customer_add"=>true
        	);
        	
        	if($this->input->post('paid')){
        		$input+=['status'=>1,'date_finish'=>$this->input->post('date-add')];
        	}
        	$respo = $this->transaction_m->add($input);    	
            if($respo->code == "E00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$data['fuel'] = $this->fuel_m->search(array("status" => 1))->data;	
		$data['ebmoney'] = 	$this->ebmoney_m->search(array("customer_id" => number_format($data['user_now']->customer_id,0,'','')))->data[0];	
		$this->load->view('user_transaction_add_v', $data);
	}

	public function trans_detail($id){       
		if(!empty($id)){
			$data=array();
			$data['success']='';
			$data['error']='';
			$data['title']= 'Detail Transaction';		
			$data['user_now'] = $this->session->userdata('easy_admin');
			$query = array(
				"id" => $id,
				"detail" => true,
				"take" => 1
			);
			$data['data'] = $this->transaction_m->search($query)->data[0];    	
			$data['ebmoney'] = 	$this->ebmoney_m->search(array("customer_id" => number_format($data['user_now']->customer_id,0,'','')))->data[0];	
			$this->load->view('user_transaction_detail_v', $data);
		} else {
			redirect(base_url('user').'/transaction') ; 
		}
	}

	public function ebmoney(){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='EB Money Transaction data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="EB Money Transaction data deleted failed";	
		if($this->input->get('alert')=='success2') $data['success']='EB Money Transaction paid successfully';	
		if($this->input->get('alert')=='failed2') $data['error']="EB Money Transaction paid failed";
		$data['title']='My EB Money Transaction';
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
		if($data['all'] == 'date'){	
			$query = array(
				"str_date" => $data['str_date'],
				"end_date" => $data['end_date'],
				"detail" => true,
				"customer_id" => number_format($data['user_now']->customer_id,0,'','')
			);
		} else {
			$query = array(
				"detail" => true,
				"customer_id" => number_format($data['user_now']->customer_id,0,'','')
			);
		}
		$data['data'] = $this->ebtransaction_m->search($query)->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		$data['ebmoney'] = 	$this->ebmoney_m->search(array("customer_id" => number_format($data['user_now']->customer_id,0,'','')))->data[0];	
		
		$this->load->view('user_ebtransaction_v', $data);
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
		if($data['all'] == 'date'){	
			$query = array(
				"str_date" => $data['str_date'],
				"end_date" => $data['end_date'],
				"detail" => true,
				"account" => 'TOP-UP',
				"customer_id" => number_format($data['user_now']->customer_id,0,'','')
			);
		} else {
			$query = array(
				"detail" => true,
				"account" => 'TOP-UP',
				"customer_id" => number_format($data['user_now']->customer_id,0,'','')
			);
		}
		$data['data'] = $this->ebtransaction_m->search($query)->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		$data['ebmoney'] = 	$this->ebmoney_m->search(array("customer_id" => number_format($data['user_now']->customer_id,0,'','')))->data[0];	
		
		$this->load->view('user_topup_v', $data);
	}

	public function topup_add(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'EB Money - New Topup';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){
			if(!empty($_FILES['photo']['name'])){
				$file = $this->upload_file('photo');	
	        	if($file){
	        		$input = array(
		        		"customer_id" => number_format($data['user_now']->customer_id,0,'',''),
						"amount" => $this->input->post('amount'),
						'status' => '2',
						'information' => 'Request Top-up',
						'photo' => curl_file_create($file,'image/jpeg',$_FILES['photo']['name'])
		        	);	
		        	$respo = $this->ebmoney_m->topup_upload($input);        	        	
		            if($respo->code == "E00"){             
		                $data['success']=$respo->message;                  
		            } else {                
		                $data['error']=$respo->message;
		            }
	        	} else {
	        		$data['error']="Failed upload file";
	        	}	
			} else {
				$input = array(
	        		"customer_id" => number_format($data['user_now']->customer_id,0,'',''),
					"amount" => $this->input->post('amount'),
					'information' => 'Request Top-up',
					'status' => '0'						
	        	);	        	
	        	$respo = $this->ebmoney_m->topup($input);        	        	
	            if($respo->code == "E00"){             
	                $data['success']=$respo->message;                  
	            } else {                
	                $data['error']=$respo->message;
	            }    
			}        	 	
        }
		$this->load->view('user_topup_add_v', $data);
	}

	public function topup_pay($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'EB Money - Pay Topup';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){
			if(!empty($_FILES['photo']['name'])){
				$file = $this->upload_file('photo');	
	        	if($file){
	        		$input = array(
		        		"id" => $id, 
						'status' => '2',
						'photo' => curl_file_create($file,'image/jpeg',$_FILES['photo']['name'])
		        	);	
		        	$respo = $this->ebmoney_m->topup_upload($input);        	        	
		            if($respo->code == "E00"){             
		                $data['success']=$respo->message;                  
		            } else {                
		                $data['error']=$respo->message;
		            }
	        	} else {
	        		$data['error']="Failed upload file";
	        	}	
			} else {
				$data['error']="Failed upload file";
			}        	 	
        }
        $data['data'] = $this->ebtransaction_m->get_detail($id)->data[0];
		$this->load->view('user_topup_pay_v', $data);
	}

	public function topup_detail($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'EB Money - Detail Topup';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
        $data['data'] = $this->ebtransaction_m->get_detail($id)->data[0];
		$this->load->view('user_topup_detail_v', $data);
	}

	function upload_file($file,$path = "assets/img/tmp/"){
		$fcpath = FCPATH;
		$fcpath = str_replace('\\', '/', $fcpath);
		$file_path = $path.basename($_FILES[$file]['name']);
        $cfile = curl_file_create($file_path,'image/jpeg',$_FILES[$file]['name']);
        if(move_uploaded_file($_FILES[$file]['tmp_name'], $file_path)) {
        	return $fcpath.$file_path;
        } else {
        	return false;
        }
	}
}

/* End of file  */
/* Location: ./application/controllers/ */
