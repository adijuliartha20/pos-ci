<?php 
class User_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		$this->load->library('encryption');
	}


	public function get_user($slug = FALSE){
		if ($slug === FALSE){
            $query = $this->db->get('user');
            return $query->result_array();
        }
        $query = $this->db->get_where('user', array('state' => $slug));
        return $query->result_array();
        //return $query->row_array();
	}


	function get_single_user($id){
		$query = $this->db->get_where('user', array('id_user' => $id));
        return $query->row_array();
	}



	public function set_user(){
		$picture = '';
		$pic = array('upload_data' => $this->upload->data());
		if(!empty($pic['upload_data'])) $picture = $pic['upload_data']['file_name'];

		$qi = $this->db->query("select id_user from user");
		$id = $qi->num_rows() + 1;		
		$start_active = date("Y-m-d H:i:s");
        $plain_text = $this->input->post('password');
        $password = $this->encryption->encrypt($plain_text);
        // Outputs: This is a plain-text message!
        //echo $this->encryption->decrypt($ciphertext);

		$data = array(
				'id_user' => $id,
		        'user_tipe' => $this->input->post('user_tipe'),
		        'username' => $this->input->post('username'),
		        'password' => $password,

		        'first_name' => $this->input->post('first_name'),
		        'last_name' => $this->input->post('last_name'),
		        'gender' => $this->input->post('gender'),
		        'address' => $this->input->post('address'),

		        'email' => $this->input->post('email'),
		        'phone' => $this->input->post('phone'),
		        'picture' => $picture,
		        'start_active' => $start_active,
		        'status' => 1,
		        'state' => 'publish',
		    );
		return $this->db->insert('user', $data);
	}


	public function update_user($id){
		$data = array(
			       //'user_tipe' => $this->input->post('user_tipe'),
			        'first_name' => $this->input->post('first_name'),
			        'last_name' => $this->input->post('last_name'),
			        'gender' => $this->input->post('gender'),
			        'address' => $this->input->post('address'),
			        'email' => $this->input->post('email'),
			        'phone' => $this->input->post('phone')
			    );

		if($_SESSION['access'] == 'admin'){
			$data['user_tipe'] = $this->input->post('user_tipe');
		}

		if(!empty($_FILES['picture']['name'])) {
			$pic = array('upload_data' => $this->upload->data());
			if(!empty($pic['upload_data'])) {
				$data['picture'] = $pic['upload_data']['file_name'];
			}	
		}

		if(!empty($this->input->post('password'))  ){
			$plain_text = $this->input->post('password');
			$data['password'] = $this->encryption->encrypt($plain_text);
		}

		$this->db->where('id_user', $id);
		return $this->db->update('user', $data);
	}


	public function update_state(){
		if(isset($_POST['ids']) && !empty($_POST['ids'])){
			$data = array();
			$state = ($_POST['action-table'] == 'untrash'? 'publish' : 'trash');


			foreach ($_POST['ids'] as $key => $id) {
				$item = array(	
								'id_user'=>$id,
								'state'=>$state
							);
				array_push($data, $item);
			}

			$this->db->update_batch('user', $data, 'id_user');
		}
	}

	public function update_state_single($id, $state){
		$data = array(
		        'state' => $state
				);

		$this->db->where('id_user', $id);
		return $this->db->update('user', $data);
	}

	public function delete_user($id){
		$this->db->where('id_user', $id);
		$this->db->delete('user');
	}

}
?>