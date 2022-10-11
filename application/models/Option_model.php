<?php 
class Option_model extends CI_Model{
	private $table = 'options';
	private $id = 'option_id';
	public function __construct(){
		$this->load->database();
	}


	public function get_data($slug = FALSE){
		if ($slug === FALSE){
            $query = $this->db->get($this->table);
            return $query->result_array();
        }
        $query = $this->db->get_where($this->table, array('state' => $slug));
        return $query->result_array();
        //return $query->row_array();
	}

	function get_single_data($id){
		$query = $this->db->get_where($this->table, array($this->id => $id));
        return $query->row_array();
	}

	function get_single_option($option_name=''){
		$query = $this->db->get_where($this->table, array('option_name' => $option_name));
        return $query->row_array();	
	}


	function get_current_date($format='date'){
		if (function_exists( 'date_default_timezone_set' )) {
             $ci = &get_instance();
             date_default_timezone_set($ci->config->item('timezone'));
        }

		$this->load->model('option_model');
		$data_manual_date = $this->option_model->get_single_option('manual_date');
		//$date = date('Y-m-d');

		$date = ($format=='datetime'? date('Y-m-d H:i:s') : date('Y-m-d'));
		

		if(!empty($data_manual_date)){
			$manual_date = $data_manual_date['option_value'];
			if($manual_date=='yes'){
				$dt_mdv = $this->option_model->get_single_option('manual_date_value');
				if(!empty($dt_mdv)){
					$mdv = $dt_mdv['option_value'];
					if(!empty($mdv)){
						//$date = date("Y-m-d", strtotime($mdv));
						$date = ($format=='datetime'? date('Y-m-d H:i:s', strtotime($mdv)) : date('Y-m-d', strtotime($mdv)));
					}
				}
			}
		}

		//$date = ($format=='datetime'? $date.' 00:00:00': $date);
		return $date;
	}


	public function add_new($key,$value){
		$this->db->select_max($this->id);
		$query = $this->db->get($this->table);
		$dt  = $query->row();
		$id = $dt->option_id+1;

		$data = array(
				$this->id => $id,
				'option_name' => $key,
				'option_value' => $value
		    );
		return $this->db->insert($this->table, $data);
	}


	public function update($key,$value){
		$data = array(
			        'option_value' => $value
			    );

		$this->db->where('option_name', $key);
		return $this->db->update($this->table, $data);
	}


}
?>