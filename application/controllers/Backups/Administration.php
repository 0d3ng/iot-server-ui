<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class administration extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('car_m');
		$this->load->model('cardriver_m');
		$this->load->model('customer_m');
		$this->load->model('transaction_m');
		$this->load->model('driver_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['title']='Administration Page';	
		$data['user_now'] = $this->session->userdata('easy_admin');
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('administration_v', $data);
	}	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
