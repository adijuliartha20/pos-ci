<?php 
class Buy_item_model extends CI_Model{
	private $table = 'buy_items';
	private $table_detail = 'buy_items_detail';
	//private $id = 'id_buy_items';
	//private $id_detail = 'id_buy_items_detail';
	public function __construct(){
		$this->load->database();
	}


	public function save_detail($id_buy_items_detail, $id_buy_items, $id_item, $mid, $item, $category, $price, $capital_price, $qty, $sub_total, $id_store){

		$data = array(
						'id_buy_items_detail' => $id_buy_items_detail,
						'id_buy_items' => $id_buy_items,
						'id_item' => $id_item,
						'mid' => $mid,
						'item' => $item,

						'category' => $category,
						'price' => $price,
						'capital_price' => $capital_price,
						'qty' => $qty,
						'sub_total' => $sub_total,

						'id_store' => $id_store
				);

		return $this->db->insert($this->table_detail, $data);
	}

	public function save($id_buy_items, $date, $total){
		$data = array(
						'id_buy_items' => $id_buy_items,
						'date' => $date,
						'total' => $total,
						'id_user' =>  $_SESSION['id']
					);
		return $this->db->insert($this->table, $data);
	}

	public function update_qty($id, $qty_add){
		$this->db->set('qty', 'qty+'.$qty_add, FALSE);
		$this->db->where('id_item', $id);
		return $this->db->update('items');
	}



	public function record_item_update($id, $qty_add, $mode){
		$this->load->model('items_model');
		$dt_old = $this->items_model->get_single_data($id,$mode);

		if(!empty($dt_old)){//print_r($dt_old);
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
					'id_item' => $dt_old['id_item'],
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
					'stock_new' 			=> $dt_old['qty'] + $qty_add,
					'id_store_new' 			=> $dt_old['id_store'],
					'store_new' 			=> $dt_store_old['store'],
					'state_new'				=> $dt_old['state'],

					'id_user' => $_SESSION['id']
				);

			if($this->db->insert('record_items', $data)){
				return $this->update_qty($dt_old['id_item'], $qty_add);
			}			
		}

	}




	


}
