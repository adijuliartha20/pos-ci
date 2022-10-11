<?php
class Backup extends CI_Controller {

	public function index(){
		$name = date('d-m-y').'_'.date('H-i-s').'_'.$_SESSION['username'];
		//echo $name;
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup();

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file('/path/to/'.$name.'.gz', $backup);


		//save first
		$this->save($name);


		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download(''.$name.'.gz', $backup);

		//print_r($_SESSION);

	}


	function save($file){
		$data = array(
		        'date' => date('d-m-y H-i-s'),
		        'name' => $_SESSION['name'],
		        'file' => $file.'.gz'
		);

		$this->db->insert('backup', $data);
	}
}

?>