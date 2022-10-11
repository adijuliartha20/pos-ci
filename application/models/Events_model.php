<?php 
class Events_model extends CI_Model{
	private $table = 'events';
	private $id = 'id_event';
	public function __construct(){
		$this->load->database();
	}


	public function get_data($slug = FALSE){
		if ($slug === FALSE){
            $query = $this->db->get($this->table);
            return $query->result_array();
        }
        $query = $this->db->order_by('date', 'ASC')->get_where($this->table, array('state' => $slug));

        return $query->result_array();
        //return $query->row_array();
	}

	function get_single_data($id){
		$query = $this->db->get_where($this->table, array($this->id => $id));
        return $query->row_array();
	}

	function get_data_by_date($date){
		$query = $this->db->get_where($this->table, array('date' => $date,'state'=>'publish'));
		return $query->result_array();
        //return $query->row_array();
	}

	function get_data_by_name_date($event,$date, $id_event=''){
		if($id_event!=''){
			$query = $this->db->get_where($this->table, array('event' => $event,'date' => $date, 'id_event !=' => $id_event));
		}else{
			$query = $this->db->get_where($this->table, array('event' => $event,'date' => $date));	
		}
		return $query->result_array();
	}

	function get_data_by_range_date($start, $end){
		//$this->db->where('state="publish" and date between '.$start.' and '.$end);
		//$this->db->group_by('event');
		//$this->db->group_by('event');
		$this->db->order_by('date');
		$query = $this->db->get_where($this->table, array('date >=' => $start, 'date <=' => $end, 'state'=>'publish'));


		//$query = $this->db->get($this->table);
		return $query->result_array();
	}

	function get_data_by_name_date_id($event,$date, $id){
		
	}


	public function single_add($event, $date){
		$this->db->select_max($this->id);
		$query = $this->db->get($this->table);
		$dt  = $query->row();
		$id = $dt->id_event+1;

		$data = array(
				$this->id => $id,
		        'event' => $event,
		        'date' => $date,
		        'order' => $id,
		        'state' => 'publish'
		    );
		return $this->db->insert($this->table, $data);
	}


	public function add_new(){		
		$this->db->select_max($this->id);
		$query = $this->db->get($this->table);
		$dt  = $query->row();
		$id = $dt->id_event+1;

		$date = date('Y-m-d', strtotime($this->input->post('date')));

		$data = array(
				$this->id => $id,
		        'event' => $this->input->post('event'),
		        'date' => $date,
		        'order' => $id,
		        'state' => 'publish'
		    );
		//print_r($data);
		return $this->db->insert($this->table, $data);
	}


	public function update($id_event, $date, $event){
		$date = date('Y-m-d', strtotime($date));
		$data = array(
			        'event' => $event,
			        'date' => $date
			    );

		$this->db->where($this->id, $id_event);
		return $this->db->update($this->table, $data);
	}


	public function update_state(){
		if(isset($_POST['ids']) && !empty($_POST['ids'])){
			$data = array();
			$state = ($_POST['action-table'] == 'untrash'? 'publish' : 'trash');


			foreach ($_POST['ids'] as $key => $id) {
				$item = array(	
								$this->id=>$id,
								'state'=>$state
							);
				array_push($data, $item);
			}

			$this->db->update_batch($this->table, $data, $this->id);
		}
	}

	public function update_state_single($id, $state){
		$data = array(
		        'state' => $state
				);

		$this->db->where($this->id, $id);
		return $this->db->update($this->table, $data);
	}

	public function delete($id){
		$this->db->where($this->id, $id);
		$this->db->delete($this->table);
	}

}
?>	