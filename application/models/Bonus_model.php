<?php 
class Bonus_model extends CI_Model{
	private $table = 'bonus';
	private $id = 'id_bonus';

	public $start_date = '';
	public $end_date = '';
	public $id_store = '';


	public function __construct(){
		$this->load->database();
	}

	public function get_data($slug = FALSE){
		/*if ($slug === FALSE){
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->join('category_item', $this->table.'.id_cat = category_item.id_cat');
			$query = $this->db->get();
			return $query->result_array();
        }*/
        
        $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('store', $this->table.'.id_store = store.id_store');
		$this->db->where($this->table.'.state', $slug);
		$this->db->order_by("store.store", "asc");
		$this->db->order_by("bonus.start", "asc"); 
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
		$id = $dt->id_bonus+1;

		$data = array(
				$this->id => $id,
		        'start' => $this->input->post('start'),
		        'end' => $this->input->post('end'),
		        'bonus' => $this->input->post('bonus'),
		        'state' => 'publish',
		        'order' => $id,
		        'id_store' => $this->input->post('id_store'),
		        'id_user' => $_SESSION['id']
		        
		    );
		return $this->db->insert($this->table, $data);
	}


	public function update($id){
		$data = array(
			        'start' => $this->input->post('start'),
			        'end' => $this->input->post('end'),
			        'bonus' => $this->input->post('bonus'),
			        'id_store' => $this->input->post('id_store'),
			        'id_user' => $_SESSION['id']
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

	public function set_fold(){
		$this->load->model('option_model');
		$opt = $this->option_model->get_single_option('fold');
        if(!empty($opt)){
            $this->fold = $opt['option_value'];
        }
	}

	public function data_my_sell(){
		$data = array();
		$where_store = ($this->id_store!='all'? "and b.id_store=$this->id_store":"");

		$query = $this->db->query("SELECT a.id_transaction, a.date, b.sub_total, b.sub_total_profit FROM transaction a
									inner join transaction_detail b on a.id_transaction = b.id_transaction
									inner join user c on a.id_user=c.id_user
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									and a.id_user=".$_SESSION['id']."
									".$where_store."
									order by a.date
									");
		$transactions = $query->result_array();
		if(!empty($transactions)){
			$old_year = '';
			$old_month = '';
			$this->set_fold();

			//get array range bonus
			$arr_bonus = $this->get_data_bonus_by_store($this->id_store);
			//print_r($arr_bonus);


			foreach ($transactions as $key => $transaction) {
				$curr_year = date('Y',strtotime($transaction['date']));
				if($old_year!=$curr_year){
					$old_year = $curr_year;
					$data[$curr_year] = array();
				} 
				$month_year = date('F-Y',strtotime($transaction['date']));
				if(!isset($data[$curr_year][$month_year])) $data[$curr_year][$month_year] = array('total'=>0,'total_profit'=>0);

				$total = $data[$curr_year][$month_year]['total'] + ($transaction['sub_total'] * $this->fold);
				$bonus = 0;
				foreach ($arr_bonus as $key => $range) {
					if($total >=$range['start'] && $total <= $range['end']) $bonus = $range['bonus'];
				}


				$data[$curr_year][$month_year]['total'] = $total;
				$data[$curr_year][$month_year]['total_profit'] = $data[$curr_year][$month_year]['total_profit'] + ($transaction['sub_total_profit'] * $this->fold);
				$data[$curr_year][$month_year]['bonus'] = $bonus;


			}
		}
		return $data;
	}


	public function get_data_bonus_by_store($id){
        $this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->table.'.id_store', $id);
		$this->db->where($this->table.'.state', 'publish');
		$this->db->order_by("bonus.start", "asc"); 
		$query = $this->db->get();
		return $query->result_array();
	}

}
?>	