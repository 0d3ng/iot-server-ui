<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class schema extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
        $this->load->model('groupsensor_m');
		$this->load->model('schema_m');
        $this->limit_data = 1000;
        $this->limit_table = 25;
		if(!$this->session->userdata('dasboard_iot')) redirect(base_url() . "auth/login");
    }

	public function index(){        
		$data=array();
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Delete schema successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete schema";	
		$data['title']='Schema List';
		$data['user_now'] = $this->session->userdata('dasboard_iot');

        // $schema_groupcode = array();
        // $type = $this->input->get('type');
        // if(empty($type))
        //     $type = 'all';
        // $data['schema_group'] = [];
        // ////get goup////
        // $data['group'] = [];        
        // $group = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
        // $groupcode = array();
        // foreach ($group as $key) {
        //     $groupcode[] = $key->group_code;
        //     $data['group'][$key->group_code] = $key;
        // }        
        // ///end get goup////
        // ////get schema from group///
        // $groupcode = array(
        //     '$in' => $groupcode
        // );
        // $data_group = $this->groupsensor_m->search(array("group_code"=>$groupcode, "group_type"=>"group"));     
        // if($data_group->status){
        //     $data_group = $data_group->data;
        //     foreach ($data_group as $key) {
        //         $schema_groupcode[] = $key->code_name;
        //         $data['schema_group'][$key->code_name] = $key;
        //     }
        // }
        // //end get schema from group///
        // ////get schema from personal ///
        // $data_personal = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "group_type"=>"personal"));
        // if($data_personal->status){
        //     $data_personal = $data_personal->data;
        //     foreach ($data_personal as $key) {
        //         $schema_groupcode[] = $key->code_name;
        //         $data['schema_group'][$key->code_name] = $key;
        //     }
        // }            
        // ////end get schema from personal ///
        // if($type == "all"){            
        //     $schema_groupcode = array(
        //         '$in' => $schema_groupcode
        //     );
        //     $or = array();
        //     $or[] = array("group_code_name" =>$schema_groupcode);
        //     $or[] = array("add_by" => $data['user_now']->id);
        //     $query = array(
        //         '$or' => $or
        //     );
        // } else if($type == "other"){            
        //     $query = array(
        //         "add_by" => $data['user_now']->id
        //     );
        // } else {
        //     $query = array(
        //         "group_code_name" =>$type
        //     );
        // }
        $query = array(
            "add_by" => $data['user_now']->id
        );
        $data["data"] =  $this->schema_m->search($query)->data;
        // $data['type'] = $type;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
		// exit();
        $this->load->view('schema_v', $data);
	}

	public function add(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Schema Add';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        // $data['schema_group'] = array();
        ////get goup////
        // $data['group'] = [];        
        // $group = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
        // $groupcode = array();
        // foreach ($group as $key) {
        //     $groupcode[] = $key->group_code;
        //     $data['group'][$key->group_code] = $key;
        // }        
        ///end get goup////
        ////get schema from group///
        // $groupcode = array(
        //     '$in' => $groupcode
        // );
        // $data_group = $this->groupsensor_m->search(array("group_code"=>$groupcode, "group_type"=>"group"));     
        // if($data_group->status){
        //     $data_group = $data_group->data;
        //     $data['schema_group'] = array_merge($data['schema_group'],$data_group);
        // }
        // //end get schema from group///
        // ////get schema from personal ///
        // $data_personal = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "group_type"=>"personal"));
        // if($data_personal->status){
        //     $data_personal = $data_personal->data;
        //     $data['schema_group'] = array_merge($data['schema_group'],$data_personal);
        // } 

		if($this->input->post('save')){  
            $field = json_decode($this->input->post('field'));  
            $group_code = $this->input->post('group');    	
            $input = array(
        		"name" => $this->input->post('name'),
				"add_by" => $data['user_now']->id,
        	    "active" => true,
                "information" => array(
                        "detail" => $this->input->post('detail'),
                        "purpose" => $this->input->post('purpose'),
                    ),
                "field" => $field
            );
            $respo = $this->schema_m->add($input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('schema_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'schema Edit';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
        // $data['schema_group'] = array();
        // ////get goup////
        // $data['group'] = [];        
        // $group = $this->group_m->search(array("user_id"=>$data['user_now']->id))->data;
        // $groupcode = array();
        // foreach ($group as $key) {
        //     $groupcode[] = $key->group_code;
        //     $data['group'][$key->group_code] = $key;
        // }        
        // ///end get goup////
        // ////get schema from group///
        // $groupcode = array(
        //     '$in' => $groupcode
        // );
        // $data_group = $this->groupsensor_m->search(array("group_code"=>$groupcode, "group_type"=>"group"));     
        // if($data_group->status){
        //     $data_group = $data_group->data;
        //     $data['schema_group'] = array_merge($data['schema_group'],$data_group);
        // }
        // //end get schema from group///
        // ////get schema from personal ///
        // $data_personal = $this->groupsensor_m->search(array("add_by"=>$data['user_now']->id, "group_type"=>"personal"));
        // if($data_personal->status){
        //     $data_personal = $data_personal->data;
        //     $data['schema_group'] = array_merge($data['schema_group'],$data_personal);
        // } 
		if($this->input->post('save')){    
            $idschema = $this->input->post('id');
            $field = json_decode($this->input->post('field')); 
            $group_code = $this->input->post('group');         
            $input = array(
                "name" => $this->input->post('name'),
                "updated_by" => $data['user_now']->id,                
                "information" => array(
                        "detail" => $this->input->post('detail'),
                        "purpose" => $this->input->post('purpose'),
                    ),
                "field" => $field
            );
            $respo = $this->schema_m->edit($idschema,$input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                     
        }
        $data['data'] = $this->schema_m->get_detail($id)->data;        
		$data['id'] = $id;
		$this->load->view('schema_edit_v', $data);
	}		

	public function delete($id,$other=""){       
		if($id){
            if($other){
                $respo = $this->schema_m->del_other($id);
            } else {
        	    $respo = $this->schema_m->del($id);
            } 
            if($respo->status){             
				redirect(base_url().'schema/?alert=success') ; 			
            } else {                
				redirect(base_url().'schema/?alert=failed') ; 			
            }                       
        }        
		redirect(base_url().'schema/?alert=failed') ; 			
	}	

    public function data($id){       
        $data=array();
        $data['success']='';
        $data['error']='';
        $data['title']= 'schema Data - Table View';       
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $data['data'] = $this->schema_m->get_detail($id)->data; 
        $data['extract'] = $this->extract($data['data']->field);
        $data["date_str"] = date("Y-m-d");
        $data["date_end"] = date("Y-m-d");
        if($this->input->get('start'))
            $data["date_str"] = $this->input->get('start');
        if($this->input->get('end'))
            $data["date_end"] = $this->input->get('end');
        $this->load->view('schema_data_v', $data);
    }   

    function extract($list,$prefix=''){
        $return = array();
        for ($i = 0; $i < count($list); $i++) {
            $item = $list[$i];
            if(is_object($item)){
                foreach($item as $key=>$value) {
                    $return[] = $key; 
                }
            } else {
               $return[] = (!empty($prefix))?$prefix."-".$item:$item;
            }
        }
        return $return;
    }

    public function datatable($id){
        $schema = $this->schema_m->get_detail($id)->data; 
        $extract = $this->extract($schema->field);
        $limit=$this->input->get('limit');
        $offset = $this->input->get('offset');
        $date_str = date("Y-m-d");
        $date_end = date("Y-m-d");
        if($this->input->get('start'))
            $date_str = $this->input->get('start');
        if($this->input->get('end'))
            $date_end = $this->input->get('end');

        $query = array(
            "date_start" => $date_str,
            "date_end" => $date_end
        );
        $count_data = $this->schema_m->count_datasensor($schema->schema_code,$query)->data;
        $query["limit"] = intval($limit);
        $query["skip"] = intval($offset);
		$list = $this->schema_m->datasensor($schema->schema_code,$query)->data;
        $data = array();
        foreach($list as $d){
            $item = array();
            foreach($extract as $k){
                if (strpos($k, '-') !== false) {
                    $nested_k = explode("-",$k);
                    $val = $this->dataget_nested($nested_k,$d);
                } else {
                    $val = (empty($d->{$k}))?"-":$d->{$k};
                }
                $item[$k] = $val;
            }
            $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_server_unix"}/1000);
            $item["action-form"] = '
                <a href="<?= base_url()?>schema/action/'.$id.'/edit/'.$d->id.'" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                <a href="<?= base_url()?>schema/action/'.$id.'/delete/'.$d->id.'" class="btn btn-sm btn-icon btn-pure btn-default btn-leave on-default remove-row"
                data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
            ';
            $data[] = $item;
        }
        $response = array(
            "total" => $count_data,
            "rows" =>  $data
        );     
        header('Content-Type: application/json; charset=utf-8');   
        echo json_encode($response);
    }

    function dataget_nested($key,$value){
        foreach($key as $d){
            if(empty($value->{$d})){
                $value = "-";
                break;    
            }
            $value = $value->{$d}; 
        }
        return $value;
    }

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
