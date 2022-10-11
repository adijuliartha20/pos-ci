<?php 
class Store_model extends CI_Model{
	private $table = 'store';
	private $id = 'id_store';
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


	public function get_data_with_modal($slug=FALSE){
		if ($slug != FALSE){
			$state = 'where a.state= "'.$slug.'"';
		}

		$query = $this->db->query('select a.id_store, a.store, a.address, a.order, (SELECT sum(b.qty * b.capital_price) modal FROM `items` b where a.id_store=b.id_store) modal from store a '.$state);

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
		$id = $dt->id_store+1;

		$data = array(
				$this->id => $id,
		        'store' => $this->input->post('store'),
		        'address' => $this->input->post('address'),
		        'order' => $id,
		        'state' => 'publish'
		    );
		return $this->db->insert($this->table, $data);
	}


	public function update($id){
		$data = array(
			        'store' => $this->input->post('store'),
			        'address' => $this->input->post('address')
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