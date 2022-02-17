<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class schema extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('group_m');
        $this->load->model('groupsensor_m');
		$this->load->model('schema_m');
		$this->load->model('schema_form_m');
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
        $data["data"] =  $this->schema_m->search($query);
        if($data["data"]->status){
            $data["data"] = $data["data"]->data;
        } else {
            $data['data'] = array();
        }
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
        
        $data['data'] = $this->schema_m->get_detail($id);       
        if($data['data']->status){
            $data['data'] = $data['data']->data;
            $data['id'] = $id;
		    $this->load->view('schema_edit_v', $data);
        } else {
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        }
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

    public function data($id,$action="",$data_id=""){       
        $schema = $this->schema_m->get_detail($id);
        if(!$schema->status){
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        } else if(empty($action)){
            $this->list($id,$schema->data);
        } else if($action=="add"){
            $this->data_add($id,$schema->data);
        } else if($action=="edit"){
            $this->data_edit($id,$schema->data,$data_id);
        } else if($action=="delete"){
            $this->data_delete($id,$schema->data,$data_id);
        } else if($action=="import"){
            $this->data_import($id,$schema->data);
        } else {
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        } 

    }   

    function list($id,$schema){       
        $data=array();
        $data['success']='';
        $data['error']='';
        $data['title']= 'Schema Data '.$id.' - Table View';       
		if($this->input->get('alert')=='success') $data['success']='Delete data successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Failed to delete data";	
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $data['data'] = $schema; 
        $data['extract'] = $this->extract($data['data']->field);
        $data["date_str"] = date("Y-m-d");
        $data["date_end"] = date("Y-m-d");
        if($this->input->get('start'))
            $data["date_str"] = $this->input->get('start');
        if($this->input->get('end'))
            $data["date_end"] = $this->input->get('end');
        $this->load->view('schema_data_v', $data);
    }

    function data_add($id,$schema){       
		$data=array();
		$data['success']='';
		$data['error']='';
        $data['title']= 'Schema Data '.$id.' - Add New Data';       
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
		if($this->input->post('save')){    
            $input = $this->input->post();
            $input = $this->schema_form_m->save_form($schema->field,$input);            
            $respo = $this->schema_m->add_data($id,$input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                     
        }
		$data['id'] = $id;
        $form=array();
        $form[0] = array();
        $form[1] = array();
        for ($i = 0; $i < count($schema->field); $i++) {
            $item = $schema->field[$i];
            foreach($item as $key=>$value) {
                if($value == "datetime"){
                    $item_form = $this->schema_form_m->form_datetime($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),date("Y-m-d H:i:s"));
                } else if($value == "date"){
                    $item_form = $this->schema_form_m->form_date($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),date("Y-m-d"));
                } else if($value == "time"){
                    $item_form = $this->schema_form_m->form_time($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),date("H:i:s"));
                } else if($value == "int"){
                    $item_form = $this->schema_form_m->form_int($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),"");
                } else if($value == "float"){
                    $item_form = $this->schema_form_m->form_float($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),"");
                } else if($value == "boolean"){
                    $item_form = $this->schema_form_m->form_boolean($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),"");
                } else {
                    $item_form = $this->schema_form_m->form_string($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),"");
                }
                if($i < ceil(count($schema->field) / 2) ){
                    $form[0][] = $item_form;
                }else {
                    $form[1][] = $item_form;
                }
            }
        }
        $data['form'] = $form;
        
		$this->load->view('schema_data_add_v', $data);
	}		
    
    public function data_edit($id,$schema,$data_id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Schema Data '.$id.' - Add New Data';		
		$data['user_now'] = $this->session->userdata('dasboard_iot');	
		if($this->input->post('save')){    
            $input = $this->input->post();
            $input = $this->schema_form_m->save_form($schema->field,$input);   
            $respo = $this->schema_m->edit_data($id,$data_id,$input);
            if($respo->status){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                     
        }
        $data['data'] = $this->schema_m->get_detail_data($id,$data_id);       
        if($data['data']->status){
            $data['data'] = $data['data']->data;
            $data['id'] = $id;
            $form=array();
            $form[0] = array();
            $form[1] = array();
            for ($i = 0; $i < count($schema->field); $i++) {
                $item = $schema->field[$i];
                foreach($item as $key=>$value) {
                    $dataval = !(empty($data['data']->{$key}))?$data['data']->{$key}:"";
                    if($value == "datetime"){
                        $item_form = $this->schema_form_m->form_datetime($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),$dataval);
                    } else if($value == "date"){
                        $item_form = $this->schema_form_m->form_date($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),$dataval);
                    } else if($value == "time"){
                        $item_form = $this->schema_form_m->form_time($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),$dataval);
                    } else if($value == "int"){
                        $item_form = $this->schema_form_m->form_int($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),$dataval);
                    } else if($value == "float"){
                        $item_form = $this->schema_form_m->form_float($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),$dataval);
                    } else if($value == "boolean"){
                        $item_form = $this->schema_form_m->form_boolean($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),$dataval);
                    } else {
                        $item_form = $this->schema_form_m->form_string($key,strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ),$dataval);
                    }
                    if($i < ceil(count($schema->field) / 2) ){
                        $form[0][] = $item_form;
                    }else {
                        $form[1][] = $item_form;
                    }
                }
            }
            $data['form'] = $form;
		    $this->load->view('schema_data_edit_v', $data);
        } else {
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        }
	}	

    public function data_delete($id,$schema,$data_id){       
		if($id){
            $respo = $this->schema_m->del_data($id,$data_id);
            if($respo->status){             
				redirect(base_url().'schema/data/'.$id.'/?alert=success') ; 			
            } else {                
				redirect(base_url().'schema/data/'.$id.'/?alert=failed') ; 			
            }                       
        }        
		redirect(base_url().'schema/data/'.$id.'/?alert=failed') ; 			
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
        if(!empty($limit))
            $query["limit"] = intval($limit);
        if(!empty($offset))
            $query["skip"] = intval($offset);
        if(empty($offset) && empty($limit))
            $export = true;
        else
            $export = false;
        $list = $this->schema_m->datasensor($schema->schema_code,$query)->data;
        $data = array();
        foreach($list as $d){
            $item = array();
            foreach($extract as $k){
                if (strpos($k, '-') !== false) {
                    $nested_k = explode("-",$k);
                    $val = $this->dataget_nested($nested_k,$d,$export);
                } else {
                    $val = (empty($d->{$k}))?((!$export)?"-":""):$d->{$k};
                }
                $item[$k] = $val;
            }
            $item["date"] = date('Y-m-d H:i:s', $d->{"date_add_auto"}->{'$date'}/1000);
            if(!empty($d->_id))
                $iddata = $d->_id;
            else
                $iddata = $d->id;
            $item["action-form"] = '
                <a href="'.base_url().'schema/data/'.$id.'/edit/'.$iddata.'" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                <a onclick="del('."'".base_url().'schema/data/'.$id.'/delete/'.$iddata."'".')" class="btn btn-sm btn-icon btn-pure btn-default btn-leave on-default remove-row"
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

    function dataget_nested($key,$value,$export){
        foreach($key as $d){
            if(empty($value->{$d})){
                if(!$export)
                    $value = "-";
                else
                    $value = "";
                break;    
            }
            $value = $value->{$d}; 
        }
        return $value;
    }

    public function data_import($id,$schema){
		$data=array();
		$data['success']='';
		$data['error']='';
        $data['title']= 'Schema Data '.$id.' - Import Data';
        $data['user_now'] = $this->session->userdata('dasboard_iot');   
        $data['data'] = $schema; 
        $data['id'] = $id;
		if($this->input->post('save')){
			
	    }
   		$this->load->view('schema_data_import_v', $data);	
	}

    function import_excel(){
        include APPPATH.'libraries/PHPExcel/PHPExcel.php';
        $config['upload_path'] = 'assets/excel';
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            $data['error']= $this->upload->display_errors();//'Import gagal';
        } else {
            $data_upload = $this->upload->data();
            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('assets/excel/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $index = $this->input->post('index');
            if($index) $index = 0;
            $sheet             = $loadexcel->getActiveSheet($index)->toArray(null, true, true ,true);
            $lat = $this->input->post('lat');
            $lng = $this->input->post('lng');
            $str = $this->input->post('start_line');
            $end = $this->input->post('end_line');
            $kec = $this->input->post('kecamatan');
            $kode_import = date("dhis");
            $data_excel = $this->excel_format_puskesmas($sheet,$str,$end,$kode_import,$lat,$lng);

            //delete file from server
            unlink(realpath('assets/excel/'.$data_upload['file_name']));
            //upload success
            // echo "<pre>";
            // print_r($data_excel);
            // echo "</pre>";
            // exit();
            $data['import'] = $kode_import;
            $data['import_count'] = count($data_excel);
            $data['success']='Process Import';         
        }
    }

    public function template($type,$id){
        $schema = $this->schema_m->get_detail($id);
        if(!$schema->status){
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
            return;
        }
        if($type == "csv"){
            $this->csvtemplate($schema->data);
        }else if($type == "excel"){
            $this->exceltemplate($schema->data);
        }else{
            $this->load->view('errors/html/error_404.php',array("heading"=>"Page Not Found","message"=>"The page you were looking for doesn't exists"));
        }
    }

    function csvtemplate($schema){
        $filename = "schema_".$schema->schema_code."_template.csv";
        $f = fopen('php://memory', 'w'); 
        $field = $this->extract($schema->field);
        fputcsv($f, $field); 
        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        fpassthru($f);
    }

    function exceltemplate($schema){
        $filename = "schema_".$schema->schema_code."_template.xlsx";
        include APPPATH.'libraries/PHPExcel/PHPExcel.php';
        $objPHPExcel    =   new PHPExcel();
        $field = $this->extract($schema->field);
        $objPHPExcel->setActiveSheetIndex(0);
        $letter = 'A';
        $letterAscii = ord($letter);
        foreach($field as $item){
            $objPHPExcel->getActiveSheet()->SetCellValue(chr($letterAscii).'1', $item);
            $letterAscii++;
        }
        $objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
        $objWriter->save('php://output');
    }


}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
