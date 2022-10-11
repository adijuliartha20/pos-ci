<?php 
class Items_model extends CI_Model{
	private $table = 'items';
	private $id = 'id_item';
	public function __construct(){
		$this->load->database();
	}


	public function get_data($slug = FALSE, $order='order'){
		if ($slug === FALSE){
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->join('category_item', $this->table.'.id_cat = category_item.id_cat');
			$query = $this->db->get();
			return $query->result_array();
        }
        
        $this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('category_item', $this->table.'.id_cat = category_item.id_cat');
		$this->db->join('store', $this->table.'.id_store = store.id_store');
		
		$this->db->where($this->table.'.state', $slug);

		$query = $this->db->get();
		return $query->result_array();
	}

	function get_single_data($id,$mode='barcode'){
		if($mode=='barcode') $query = $this->db->get_where($this->table, array($this->id => $id));
		else if($mode=='manual_code') $query = $this->db->get_where($this->table, array('mid' => $id));
        return $query->row_array();
	}



	function get_single_data_with_category($id,$mode='barcode'){
		$this->db->join('category_item', $this->table.'.id_cat = category_item.id_cat');
		if($mode=='barcode') $query = $this->db->get_where($this->table, array($this->id => $id));
		else if($mode=='manual_code') $query = $this->db->get_where($this->table, array('mid' => $id));
        return $query->row_array();
	}


	public function get_true_price_now(){
		$price = floatval($this->input->post('price'));
		$true_price = $price;

		$type_discount = $this->input->post('type_discount');
		$discount = floatval($this->input->post('discount'));
		$plus_discount = floatval($this->input->post('plus_discount'));
		if(!empty($discount)){
			$val_discount = ($type_discount=='percent'?  ($price * $discount)/100 : $discount);
			if(!empty($plus_discount)){
				$curr_price = $price - $val_discount;
				$val_plus_discount = ($type_discount=='percent'?  ($curr_price * $plus_discount)/100 : $plus_discount);

				$val_discount = $val_discount + $val_plus_discount;
			}

			$true_price = $price - $val_discount;
		}

		return $true_price;
		
	}


	public function add_new(){
		$order = $this->db->count_all($this->table) + 1;
		$true_price = $this->get_true_price_now();
		$profit = $true_price - floatval($this->input->post('capital_price'));
		$profit_reseller =  floatval($this->input->post('reseller_price')) - floatval($this->input->post('capital_price'));

		$data = array(
				$this->id => time(),
		        'mid' => $this->input->post('mid'),
		        'id_cat' => $this->input->post('id_cat'),
		        'id_store' => $this->input->post('id_store'),
		        'item' => $this->input->post('item'),
		        
		        'qty' => $this->input->post('qty'),
		        'capital_price' => $this->input->post('capital_price'),
		        'reseller_price' => $this->input->post('reseller_price'),
		        'price' => $this->input->post('price'),
		        'type_discount' => $this->input->post('type_discount'),

		        'discount' => $this->input->post('discount'),
		        'plus_discount' => $this->input->post('plus_discount'),
		        'true_price' => $true_price,
		        'profit' => $profit,
		        'profit_reseller' => $profit_reseller,

		        'order' => $order,
		        'state' => 'publish',
		        'id_user' => $_SESSION['id']
		    );
		
		return $this->db->insert($this->table, $data);
	}


	public function update($id){
		$true_price = $this->get_true_price_now();
		$profit = $true_price - floatval($this->input->post('capital_price'));
		$profit_reseller =  floatval($this->input->post('reseller_price')) - floatval($this->input->post('capital_price'));

		$data = array(
			    'mid' => $this->input->post('mid'),
		        'id_cat' => $this->input->post('id_cat'),
		        'id_store' => $this->input->post('id_store'),
		        'item' => $this->input->post('item'),		        
		        'qty' => $this->input->post('qty'),
		        
		        'capital_price' => $this->input->post('capital_price'),
		        'reseller_price' => $this->input->post('reseller_price'),
		        'price' => $this->input->post('price'),
		        'type_discount' => $this->input->post('type_discount'),
		        'discount' => $this->input->post('discount'),

		        'plus_discount' => $this->input->post('plus_discount'),
		        'true_price' => $true_price,
		        'profit' => $profit,
		        'profit_reseller' => $profit_reseller,
		        'id_user' => $_SESSION['id']
			    );

		$this->db->where($this->id, $id);
		return $this->db->update($this->table, $data);
	}


	public function record_item($id){
		$dt_old = $this->get_single_data($id);

		if(!empty($dt_old)){
			if (function_exists( 'date_default_timezone_set' )) {
				 $ci = &get_instance();
				 date_default_timezone_set($ci->config->item('timezone'));
			}

			$date = date('Y-m-d H:i:s');
			$this->load->model('store_model');

			$dt_store_old = $this->store_model->get_single_data($dt_old['id_store']);
			$dt_store_new = $this->store_model->get_single_data($this->input->post('id_store'));
			



			$data = array(
					'id_record_item' => time(),
					'id_item' => $id,
					'date' => $date,

					'mid_old' 				=> $dt_old['mid'],
					'name_old' 				=> $dt_old['item'],
					'capital_price_old' 	=> $dt_old['capital_price'],
					'reseller_price_old' 	=> $dt_old['reseller_price'],
					'price_old' 			=> $dt_old['price'],
					'stock_old' 			=> $dt_old['qty'],
					'id_store_old' 			=> $dt_old['id_store'],
					'store_old' 			=> $dt_store_old['store'],
					'state_old'				=> $dt_old['state'],
					

					'mid_new' 				=> $this->input->post('mid'),
					'name_new' 				=> $this->input->post('item'),
					'capital_price_new' 	=> $this->input->post('capital_price'),
					'reseller_price_new' 	=> $this->input->post('reseller_price'),
					'price_new' 			=> $this->input->post('price'),
					'stock_new' 			=> $this->input->post('qty'),
					'id_store_new' 			=> $this->input->post('id_store'),
					'store_new' 			=> $dt_store_new['store'],
					'state_new'				=> $dt_old['state'],

					'id_user' => $_SESSION['id']
				);

			return $this->db->insert('record_items', $data);
		}

	}




	public function record_item_change_status($id,$state){
		$dt_old = $this->get_single_data($id);

		if(!empty($dt_old)){
			if (function_exists( 'date_default_timezone_set' )) {
				 $ci = &get_instance();
				 date_default_timezone_set($ci->config->item('timezone'));
			}

			$date = date('Y-m-d H:i:s');
			$this->load->model('store_model');

			$dt_store_old = $this->store_model->get_single_data($dt_old['id_store']);
			//$dt_store_new = $this->store_model->get_single_data($this->input->post('id_store'));
			



			$data = array(
					'id_record_item' => time(),
					'id_item' => $id,
					'date' => $date,

					'mid_old' 				=> $dt_old['mid'],
					'name_old' 				=> $dt_old['item'],
					'capital_price_old' 	=> $dt_old['capital_price'],
					'reseller_price_old' 	=> $dt_old['reseller_price'],
					'price_old' 			=> $dt_old['price'],
					'stock_old' 			=> $dt_old['qty'],
					'id_store_old' 			=> $dt_old['id_store'],
					'store_old' 			=> $dt_store_old['store'],
					'state_old'				=> $dt_old['state'],
					

					'mid_new' 				=> $dt_old['mid'],
					'name_new' 				=> $dt_old['item'],
					'capital_price_new' 	=> $dt_old['capital_price'],
					'reseller_price_new' 	=> $dt_old['reseller_price'],
					'price_new' 			=> $dt_old['price'],
					'stock_new' 			=> $dt_old['qty'],
					'id_store_new' 			=> $dt_old['id_store'],
					'store_new' 			=> $dt_store_old['store'],
					'state_new'				=> $state,

					'id_user' => $_SESSION['id']
				);

			return $this->db->insert('record_items', $data);
		}

		//print_r($dt_old);
	}




	public function update_state(){
		if(isset($_POST['ids']) && !empty($_POST['ids'])){
			$data = array();
			$state = ($_POST['action-table'] == 'untrash'? 'publish' : 'trash');


			foreach ($_POST['ids'] as $key => $id) {
				$this->record_item_change_status($id,$state);
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