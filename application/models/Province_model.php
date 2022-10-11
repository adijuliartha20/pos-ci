<?php 
class Province_model extends CI_Model{
	private $table = 'province';
	private $id = 'id_province';
	public function __construct(){
		$this->load->database();
	}



	public function get_data($slug = FALSE, $where = ''){
		if ($slug === FALSE){
            $this->db->select('*');
			$this->db->from($this->table);
			$this->db->join('country', $this->table.'.id_country = country.id_country');
	       	$query = $this->db->get();
			return $query->result_array();
        }

        $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('country', $this->table.'.id_country = country.id_country');		
		$this->db->where($this->table.'.state', $slug);
		
		if(!empty($where)){
			$this->db->where($this->table.'.id_country', $where);	
		}		

       	$query = $this->db->get();
       	//print_r($this->db->last_query());    
		return $query->result_array();
	}

	function get_single_data($id){
		$query = $this->db->get_where($this->table, array($this->id => $id));
        return $query->row_array();
	}

	public function add_new(){		
		$this->db->select_max($this->id);
		$query = $this->db->get($this->table);
		$dt  = $query->row();
		$id = $dt->id_province+1;

		$data = array(
				$this->id => $id,
		        'name_province' => $this->input->post('name_province'),
		        'id_country' => $this->input->post('id_country'),
		        'order' => $id,
		        'state' => 'publish',
		        'id_user' => $_SESSION['id']
		    );
		return $this->db->insert($this->table, $data);
	}


	public function update($id){
		$data = array(
			        'name_province' => $this->input->post('name_province'),
			        'id_country' => $this->input->post('id_country')
			    );

		$this->db->where($this->id, $id);
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