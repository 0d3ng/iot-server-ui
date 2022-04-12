<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demo extends CI_Controller {

	public function __construct() {
        parent::__construct();  
		$this->load->model('schema_m');
    }

	public function index()
	{        
		$data=array();
		$data['title']='Home';
		$data['id']= ["1","2","3","4","5","6","7","8","9","10"];     
        $data['room']=["D207","D206","D208","Toilet3M","Toilet3F","Corr3B","Corr3A","RC3","D306","D307","D308","D308","Toilet2M","Toilet2F","Corr2A","RC2"];   
		// $this->load->view('testing/room_v', $data);
		$this->load->view('testing/room_v2', $data);
	}
    
    public function getroom(){
        $url = "http://103.106.72.188:3001/";
        $id = $this->input->post("id");
        $schema = "5y76py";
        $query = array(
            "id" => $id,
            '$and' => [
                array("room"=>array('$ne'=>null)),
                array("room"=>array('$ne'=>""))
            ]
        );
        $data= $this->schema_m->findone_data2($url,$schema,$query);
        if($data->status && !empty($data->data) ){
            $data = $data->data;
            $room = $data->room;
            $date = date('Y-m-d H:i:s', $data->{"date_add_auto"}->{'$date'}/1000);
            $response = array(
                "id" => $id,
                "room" => $room,
                "lastdate" => $date
            );
        } else {
            $response = array(
                "id" => $id,
                "room" => "no data",
                "lastdate" => "-"
            );      
        }
        header('Content-Type: application/json; charset=utf-8');   
        echo json_encode($response);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
