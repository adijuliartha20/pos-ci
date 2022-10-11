<?php 
class Sub_district_model extends CI_Model{
	private $table = 'sub_district';
	private $id = 'id_sub_district';
	public function __construct(){
		$this->load->database();
	}

	public function get_data($slug = FALSE, $order='order'){
		if ($slug === FALSE){
            $this->db->select('*');
			$this->db->from($this->table);
			$this->db->join('districts', $this->table.'.id_district = districts.id_district');
			$this->db->join('province', $this->table.'.id_province = province.id_province');
			$this->db->join('country', $this->table.'.id_country = country.id_country');
	       	$query = $this->db->get();
			return $query->result_array();
        }

        $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('districts', $this->table.'.id_district = districts.id_district');
		$this->db->join('province', $this->table.'.id_province = province.id_province');
		$this->db->join('country', $this->table.'.id_country = country.id_country');		
		$this->db->where($this->table.'.state', $slug);

       	$query = $this->db->get();
		return $query->result_array();
	}

	function get_single_data($id){
		$query = $this->db->get_where($this->table, array($this->id => $id));
        return $query->row_array();
	}




	function get_detail_sub(){
		$this->db->select('districts.name_district, province.name_province, country.name_country');    
		$this->db->from('districts');
		$this->db->join('province', 'districts.id_province = province.id_province');
		$this->db->join('country', 'districts.id_country = country.id_country');
		$this->db->where('districts.id_district', $this->input->post('id_district'));


		$query = $this->db->get();
		return $query->result_array();
	}


	function get_same_name(){
		$query = $this->db->get_where($this->table, array('id_district' => $this->input->post('id_district'), 'name_sub_district' => $this->input->post('name_subdistrict') ));
        return $query->row_array();
	}

	function get_list_sub_district($id_district){
		$this->db->select('id_sub_district, name_sub_district');
		$this->db->from('sub_district');
		$this->db->where('id_district', $id_district);

		$query = $this->db->get();
		return $query->result_array();
	}


	function get_list_district($id_province){
		$this->db->select('id_district, name_district');
		$this->db->from('districts');
		$this->db->where('id_province', $id_province);

		$query = $this->db->get();
		return $query->result_array();
	}


	function get_list_province($id_country){
		$this->db->select('id_province, name_province');
		$this->db->from('province');
		$this->db->where('id_country', $id_country);

		$query = $this->db->get();
		return $query->result_array();
	}








	public function add_new(){		
		$this->db->select_max($this->id);
		$query = $this->db->get($this->table);
		$dt  = $query->row();
		$id = $dt->id_sub_district+1;



		$detail = $this->get_detail_sub();
		//print_r($detail);

		$data = array(
				$this->id => $id,
		        'name_sub_district' => $this->input->post('name_subdistrict'),
				'name_district' => $detail[0]['name_district'],		        
				'name_province' => $detail[0]['name_province'],
				'name_country' => $detail[0]['name_country'],
		        'id_country' => $this->input->post('id_country'),
		        'id_province' => $this->input->post('id_province'),
		        'id_district' => $this->input->post('id_district'),
		        'order' => $id,
		        'state' => 'publish',
		        'id_user' => $_SESSION['id']
		    );
		return $this->db->insert($this->table, $data);
	}


	public function update($id){
		$detail = $this->get_detail_sub();
		//print_r($detail);

		$data = array(
			        'name_sub_district' => $this->input->post('name_subdistrict'),
					'name_district' => $detail[0]['name_district'],		        
					'name_province' => $detail[0]['name_province'],
					'name_country' => $detail[0]['name_country'],
			        'id_country' => $this->input->post('id_country'),
			        'id_province' => $this->input->post('id_province'),
			        'id_district' => $this->input->post('id_district')
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