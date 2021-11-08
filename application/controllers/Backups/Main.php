<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

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
		$data['title']='Business Page';
		//$data['menu_sensor'] = $this->sensor_m->get_detail($this->session->userdata('semar_admin')->username)->data;	
		//$data['user_now'] = $this->session->userdata('semar_admin');		
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");

		////Hapus INI////
		$data['end_date'] = date("2020-05-27");
		$data['str_date'] = $data['end_date'] ;
		/////////////////

		$data['end_week'] = date( 'Y-m-d', strtotime( 'saturday this week' ) );
		$data['str_week'] = date( 'Y-m-d', strtotime("-6 days",strtotime($data['end_week'])));
		
		///--------------- Only Active Car -------------///
		$data['car'] = $this->cardriver_m->search( 
			array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"detail" => true
		))->data;
		$data['total_car'] = count($data['car']);
		$data['allcar'] = $this->car_m->search_count( 
			array(
			"status" => 1
		))->data;
		if(!$data['allcar']) 
			$data['allcar'] = 0;
		else
			$data['allcar'] = $data['allcar']->total_users;
		///---------------  All Car --------------- ///
		//$data['car'] = $this->car_m->search(array())->data;

		$data['new_customer'] = $this->customer_m->search_count(array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date']
		))->data->total_users;

		$data['hours_income'] = $this->transaction_m->search_group(array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"groupby" => "hours",
			"status" => 1
		))->data;

		if($data['hours_income']) $data['hours_income'] = $data['hours_income'][0];

		$data['fuel_today'] = $this->transaction_m->search_group(array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"groupby" => "fuel_type",
			"status" => 1
		))->data;

		$data['booked'] = $this->transaction_m->search_count(array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date']
		))->data->total;

		$data['trans_today'] = $this->transaction_m->search(array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"status" => 1,
			"detail" => true
		))->data;


		$data['today'] = $this->transaction_m->search_group(array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"groupby" => "date",
			"status" => 1
		))->data;

		if($data['today'])
			$data['today'] = $data['today'][0]->total_income;
		else
			$data['today'] = 0;
		
		$data['cardriver_m'] = $this->cardriver_m;
        $data['user_now'] = $this->session->userdata('easy_admin');
  //       echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('index', $data);
	}	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
