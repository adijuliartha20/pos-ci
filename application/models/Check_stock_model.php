<?php 
class Check_stock_model extends CI_Model{
	private $table = 'check_stock';
	private $table_detail = 'check_stock_detail';
	private $id = 'id_stock';
	public function __construct(){
		$this->load->database();
	}


	public function save_detail($id_detail, $id, $id_item, $mid, $item, $category, $capital_price, 
                                $price, $qty_comp, $qty_store, $margin_qty, $minus_stock, $plus_stock, $id_store){

		$data = array(
						'id_stock_detail' => $id_detail,
						'id_stock' => $id,
						'id_item' => $id_item,
						'mid' => $mid,
						'item' => $item,

						'category' => $category,
						'capital_price' => $capital_price,
						'price' => $price,						
						'qty_comp' => $qty_comp,
						'qty_store' => $qty_store,

						'margin_qty' => $margin_qty,
						'minus_stock' => $minus_stock,
						'plus_stock' => $plus_stock,
						'id_store' => $id_store
				);

		return $this->db->insert($this->table_detail, $data);
	}

	public function save($id_stock, $date){
		$data = array(
						'id_stock' => $id_stock,
						'date' => $date,
						'id_user' =>  $_SESSION['id'],
						'name' =>  $_SESSION['name']
					);
		return $this->db->insert($this->table, $data);
	}
}
?>