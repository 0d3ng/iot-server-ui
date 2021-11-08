<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class operational extends CI_Controller {

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
		$data['title']='Operational Page';
		//$data['menu_sensor'] = $this->sensor_m->get_detail($this->session->userdata('semar_admin')->username)->data;	
		//$data['user_now'] = $this->session->userdata('semar_admin');		
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");

		////Hapus INI////
		$data['end_date'] = date("2020-05-27");
		$data['str_date'] = $data['end_date'] ;
		/////////////////

		///--------------- Only Active Car -------------///
		$data['car'] = $this->cardriver_m->search( 
			array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"detail" => true
		))->data;
		$data['total_car'] = count($data['car']);
		
		///-----Car Income----///
		$car_income = $this->transaction_m->search_group(array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"groupby" => "car",
			"status" => 1
		))->data;
		$data['car_income'] = array();
		foreach ($car_income as $value) {
			$data['car_income'][number_format($value->car_id,0,'','')] = $value;
		}

		$data['user_now'] = $this->session->userdata('easy_admin');
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('operational_v', $data);
	}	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
