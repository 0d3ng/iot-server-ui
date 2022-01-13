<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class schema_form_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}
    
    function form_int($field,$title,$value){
        return '
            <div class="form-group form-material ">
                <label class="form-control-label" for="inputInt-'.$field.'">'.$title.'</label>
                <input type="number" class="form-control" id="inputInt-'.$field.'" name="'.$field.'" value="'.$value.'" autocomplete="off">
            </div>
        ';
    }

    function form_float($field,$title,$value){
        return '
            <div class="form-group form-material ">
                <label class="form-control-label" for="inputFloat-'.$field.'">'.$title.'</label>
                <input type="number" class="form-control" id="inputFloat-'.$field.'" name="'.$field.'" value="'.$value.'" step="any" autocomplete="off">
            </div>
        ';
    }

    function form_string($field,$title,$value){
        return '
            <div class="form-group form-material ">
                <label class="form-control-label" for="inputString-'.$field.'">'.$title.'</label>
                <input type="text" class="form-control" id="inputString-'.$field.'" name="'.$field.'" value="'.$value.'" autocomplete="off">
            </div>
        ';
    }

    function form_boolean($field,$title,$value){
        return '
            <div class="form-group form-material ">
                <label class="form-control-label" for="inputBoolean-'.$field.'">'.$title.'</label>
                <select class="form-control" id="inputBoolean-'.$field.'" name="'.$field.'">
                    <option value="">Choose Value</option>
                    <option '.( ($value == "true")?'selected':'').' value="true" >True</option>
                    <option '.( ($value == "false")?'selected':'').' value="false" >False</option>
                </select>
            </div>
        ';
    }
    
    function form_date($field,$title,$value){
        return '
            <div class="form-group form-material ">
                <label class="form-control-label" for="inputDate-'.$field.'">'.$title.'</label>
                <input type="text" class="form-control" data-plugin="datepicker" id="inputDate-'.$field.'" name="'.$field.'" value="'.$value.'" autocomplete="off">
            </div>
        ';
    }

    function form_time($field,$title,$value){
        return '
            <div class="form-group form-material ">
                <label class="form-control-label" for="inputDate-'.$field.'">'.$title.'</label>
                <input type="text" class="form-control" data-plugin="clockpicker" data-autoclose="true"  id="inputDate-'.$field.'" name="'.$field.'" value="'.$value.'" autocomplete="off">
            </div>
        ';
    }

    function form_datetime($field,$title,$value){
        $value = explode(' ',$value);
        $date_val = !empty($value[0])?$value[0]:'';
        $time_val = !empty($value[1])?$value[1]:'';
        return '
            <div class="form-group form-material ">
                <label class="form-control-label" for="inputDate-'.$field.'">'.$title.'</label>
                <div class="form-group form-material row">
                    <div class="col-6">
                        <input type="text" class="form-control" data-plugin="datepicker" id="inputDate-'.$field.'-date" name="'.$field.'-date" value="'.$date_val.'" autocomplete="off">
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control " data-autoclose="true"  data-plugin="clockpicker" id="inputDate-'.$field.'-time" name="'.$field.'-time" value="'.$time_val.'" autocomplete="off">
                    </div>
                </div>
            </div>
        ';
    }

    function save_form($field_list,$value_list){
        $data = array();
        for ($i = 0; $i < count($field_list); $i++) {
            $item = $field_list[$i];
            foreach($item as $key=>$value) {
                if($value != "datetime"){
                    $data[$key] = (!empty($value_list[$key]))?$value_list[$key]:"";
                } else {
                    $date = (!empty($value_list[$key.'-date']))?$value_list[$key.'-date']:"";
                    $time = (!empty($value_list[$key.'-time']))?$value_list[$key.'-time']:"";
                    $data[$key] = $date.' '.$time;
                }
            }
        }
        return $data;
    }
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */
