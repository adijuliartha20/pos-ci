<?php 
class Customer_model extends CI_Model{
	private $table = 'customer';
	private $id = 'id_customer';
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
		/*$this->db->join('districts', $this->table.'.id_district = districts.id_district');
		$this->db->join('province', $this->table.'.id_province = province.id_province');
		$this->db->join('country', $this->table.'.id_country = country.id_country');*/		
		$this->db->where($this->table.'.state', $slug);

       	$query = $this->db->get();
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
		$id = $dt->id_customer+1;



		$detail = $this->get_detail_sub();
		//print_r($detail);

		$dob = explode('/', $this->input->post('date_of_birth'));
		//print_r($dob);


		$data = array(
				$this->id => $id,
				'name' =>$this->input->post('name'),
				'handphone' =>$this->input->post('handphone'),
				'gender' =>$this->input->post('gender'),
				'date_of_birth' => "$dob[2]-$dob[0]-$dob[1]",
				'id_sub_district' 	=> $detail[0]['id_sub_district'],	
		        'name_sub_district' => $detail[0]['name_sub_district'],
		        'id_district' 		=> $detail[0]['id_district'],
				'name_district' 	=> $detail[0]['name_district'],		        
				'id_province' 		=> $detail[0]['id_province'],
				'name_province' 	=> $detail[0]['name_province'],
				'id_country' 		=> $detail[0]['id_country'],
				'name_country' 		=> $detail[0]['name_country'],
				'address' => $this->input->post('address'),
		        'order' => $id,
		        'state' => 'publish',
		        'id_user' => $_SESSION['id']
		    );

		//print_r($data);
		return $this->db->insert($this->table, $data);
	}

	public function update($id){
		/*$detail = $this->get_detail_sub();
		$data = array(
			        'name_sub_district' => $this->input->post('name_subdistrict'),
					'name_district' => $detail[0]['name_district'],		        
					'name_province' => $detail[0]['name_province'],
					'name_country' => $detail[0]['name_country'],
			        'id_country' => $this->input->post('id_country'),
			        'id_province' => $this->input->post('id_province'),
			        'id_district' => $this->input->post('id_district')
			    );

		
		//print_r($dob);*/
		$detail = $this->get_detail_sub();
		$dob = explode('/', $this->input->post('date_of_birth'));
		$data = array(
				$this->id => $id,
				'name' =>$this->input->post('name'),
				'handphone' =>$this->input->post('handphone'),
				'gender' =>$this->input->post('gender'),
				'date_of_birth' => "$dob[2]-$dob[0]-$dob[1]",
				'id_sub_district' 	=> $detail[0]['id_sub_district'],	
		        'name_sub_district' => $detail[0]['name_sub_district'],
		        'id_district' 		=> $detail[0]['id_district'],
				'name_district' 	=> $detail[0]['name_district'],		        
				'id_province' 		=> $detail[0]['id_province'],
				'name_province' 	=> $detail[0]['name_province'],
				'id_country' 		=> $detail[0]['id_country'],
				'name_country' 		=> $detail[0]['name_country'],
				'address' => $this->input->post('address'),
		        'id_user' => $_SESSION['id']
		    );
		$this->db->where($this->id, $id);
		return $this->db->update($this->table, $data);
	}



	function get_detail_sub(){
		$this->db->select('*');
		$this->db->from('sub_district');
		$this->db->where('id_sub_district', $this->input->post('id_sub_district'));

		$query = $this->db->get();
		return $query->result_array();
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


	function get_list_customer_by($type,$key){
		$this->db->select('id_customer, name, handphone, address, name_sub_district, name_district, name_province, name_country,date_of_birth');
		$this->db->from('customer');
		$this->db->like($type, $key);
		$this->db->where('state', 'publish');

		$query = $this->db->get();
		return $query->result_array();
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