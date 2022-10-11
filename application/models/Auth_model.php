<?php
class Auth_model extends CI_Model {
	private $table = 'user';

    public function __construct(){
            $this->load->database();
    }    

    public function login($username, $password){

    	$return = array();
    	$return['status'] = false;
    	$this->load->library('encryption');

    	$query = $this->db->get_where($this->table, array('username' => $username));
        $data =  $query->row_array();

        if(isset($data) && !empty($data)){
        	$pass = $this->encryption->decrypt($data['password']);

        	//print_r($data);
        	if($password==$pass){
        		$return['status'] =  true;
        		$return['data']	= $data;
        	} 

        }

    	return $return;
    }


    public function update($data, $id_user){
    	$this->db->where('id_user', $id_user);
        $this->db->update($this->table, $data);
    }


    public function get_by_cookie($cookie){
        $this->db->where('cookie', $cookie);
        return $this->db->get($this->table);
    }

}