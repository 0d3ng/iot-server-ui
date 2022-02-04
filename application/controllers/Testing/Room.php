<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class room extends CI_Controller {

	public function __construct() {
        parent::__construct();  
		$this->load->model('schema_m');
    }

	public function index()
	{        
		$data=array();
		$data['title']='Home';
		$data['id']= ["1","2","3","4","5","6","7","8","9","10"];        
		$this->load->view('testing/room_v', $data);
	}
    
    public function getroom(){
        $id = $this->input->post("id");
        $schema = "u834oe";
        $query = array(
            "id" => $id,
            '$and' => [
                array("room"=>array('$ne'=>null)),
                array("room"=>array('$ne'=>""))
            ]
        );
        $data= $this->schema_m->findone_data($schema,$query);
        if($data->status){
            $data = $data->data;
            $room = $data->room;
            $date = date('Y-m-d H:i:s', $data->{"date_add_auto"}->{'$date'}/1000);
            $response = array(
                "id" => $id,
                "room" => $room,
                "lastdate" => $date
            );
        } else {
            $response = array();      
        }
        header('Content-Type: application/json; charset=utf-8');   
        echo json_encode($response);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
