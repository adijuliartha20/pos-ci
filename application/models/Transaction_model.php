<?php 
class Transaction_model extends CI_Model{
	private $table = 'transaction';
	private $table_detail = 'transaction_detail';
	private $id = 'id_transaction';
	public function __construct(){
		$this->load->database();
	}


	public function save_detail($id_transaction, $dt, $qty, $price, $sub_total, $sub_total_profit, $reseller_mode, $order){
		$type_discount = '';
		$discount = '';
		$text_discount = '';
		$plus_discount = '';
		if($reseller_mode=='no'){
			$type_discount = $dt['type_discount'];

			$discount = number_format($dt['discount']);
	        $text_discount = ($type_discount=='percent'? $discount.'%': $discount);
	        $plus_discount = number_format($dt['plus_discount']);
	        if(!empty($plus_discount)){
	            $plus_discount = ($type_discount=='percent'? $plus_discount.'%': $plus_discount);
	            $text_discount = ''.$text_discount.' + '.$plus_discount.'';
	        }	
		}
		


		$data = array(
					'id_transaction_detail' => $order,
			        'id_transaction' => $id_transaction,
			        'id_item' => $dt['id_item'],
			        'mid' => $dt['mid'],
			        'item' => $dt['item'],

					'category' => $dt['category'],
					'capital_price' => $dt['capital_price'],
					'price' => $price,
					'type_discount' => $type_discount,
					'discount' => $discount,

					'plus_discount' => $plus_discount,
					'text_discount' => $text_discount,
					'qty' => $qty,
					'sub_total' => $sub_total,
					'sub_total_profit' => $sub_total_profit,
					'id_store' => $dt['id_store']
		    	);
		//print_r($data);
		return $this->db->insert($this->table_detail, $data);
		//if(){
		//	return $this->update_qty($dt['id_item'],$qty);
		//}
	}


	public function update_qty($id,$qty,$mode_code){
		//get qty
		$id_key = 'id_item';
		$this->db->select('qty');
	    $this->db->from('items');
	    if($mode_code!='barcode') $id_key = 'mid';
	    $this->db->where($id_key,$id);
	    
        $old_qty = $this->db->get()->row()->qty;        
        //echo $old_qty.'#';
        $new_qty = $old_qty - $qty;

        $data = array('qty' => $new_qty);
		$this->db->where($id_key,$id);
		return $this->db->update('items', $data);
	}

	public function save_new($id_transaction, $date, $manual_discount, $total, $total_before_discount, $total_profit, $total_profit_before_discount, $reseller_mode, $dtCust, $status_transaction, $status_package){

		//save transaction
		$data = array(
				'id_transaction'=>$id_transaction,
		        'date' => $date,
		        'date_transaction' => $date,
		        'manual_discount' => $manual_discount,
		        'total' => $total,
		        'total_before_discount' => $total_before_discount,
		        'total_profit' => $total_profit,
		        'total_profit_before_discount' => $total_profit_before_discount,
		        'reseller_mode' => $reseller_mode,



		        'id_customer' => $dtCust['id_customer'],
		        'name' => $dtCust['name'],
		        'handphone' => $dtCust['handphone'],
		        'date_of_birth' => $dtCust['date_of_birth'],
		        'gender' => $dtCust['gender'],
		        'address' => $dtCust['address'],
		        'id_sub_district' => $dtCust['id_sub_district'],
		        'name_sub_district' => $dtCust['name_sub_district'],
		        'id_district' => $dtCust['id_district'],
		        'name_district' => $dtCust['name_district'],
		        'id_province' => $dtCust['id_province'],
		        'name_province' => $dtCust['name_province'],
		        'id_country' => $dtCust['id_country'],
		        'name_country' => $dtCust['name_country'],
		        'status_transaction' => $status_transaction,
		        'status_package' => $status_package,

		        'id_user' => $_SESSION['id']
		    );
		
		return $this->db->insert($this->table, $data);
	}


	public function save_payemnts($date, $payment, $payment_type, $id_transaction){
		$this->db->select_max('id_payment');
		$query = $this->db->get('payments');
		$dt  = $query->row();
		$id = $dt->id_payment+1;


		$data = array(
				'id_payment'	=> $id,
				'date' 			=> $date,
				'payment' 		=> $payment,
				'payment_type' 	=> $payment_type,
				'id_transaction'=> $id_transaction,
				'id_user' 		=> $_SESSION['id']
				);

		return $this->db->insert('payments', $data);
	}

	public function save_status($id_transaction, $status, $date){
		$data = array('id_transaction'=> $id_transaction, 'status'=> $status, 'date'=>$date, 'id_user'=>$_SESSION['id']);
		return $this->db->insert('transaction_status', $data);
	}


	public function update_status_package($id,$status){
		$data = array('status_package' => $status);
		$this->db->where($this->id, $id);
		return $this->db->update($this->table, $data);
	}

	public function save($id_transaction, $date, $manual_discount, $total, $total_before_discount, $total_profit, $total_profit_before_discount, $reseller_mode, $name_consumen, $phone, $sub_district, $district, $province, $address){
		$data = array(
				'id_transaction'=>$id_transaction,
		        'date' => $date,
		        'manual_discount' => $manual_discount,
		        'total' => $total,
		        'total_before_discount' => $total_before_discount,
		        'total_profit' => $total_profit,
		        'total_profit_before_discount' => $total_profit_before_discount,
		        'reseller_mode' => $reseller_mode,

		        'name_consumen' => $name_consumen,
		        'phone' => $phone,
		        'sub_district' => $sub_district,
		        'district' => $district,
		        'province' => $province,
		        'address' => $address,

		        'id_user' => $_SESSION['id']
		    );
		
		return $this->db->insert($this->table, $data);
	}

	public function get_transaction_num(){
		$this->load->model('option_model');
		$date = $this->option_model->get_current_date();

	    $query = $this->db->query("SELECT * FROM transaction WHERE date >='".$date." 00:00:00' AND date <= '".$date." 23:59:00'");
		return number_format(($query->num_rows() + 1));
	}


	public $start_date = '';
	public $end_date = '';
	public $id_store = '';

	public function get_monthly_statistic(){
		$data = $this->arr_date();
		//print_r($data);
		$where_store = ($this->id_store!='all'? "and b.id_store=$this->id_store":"");

		$query = $this->db->query("SELECT a.id_transaction, a.date, b.sub_total, b.sub_total_profit FROM transaction a
									inner join transaction_detail b on a.id_transaction = b.id_transaction
									inner join user c on a.id_user=c.id_user
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									".$where_store." order by a.date");
		$transactions = $query->result_array();
		if(!empty($transactions)){
			$old_date = '1';

			$this->set_fold();
			$dates = $this->arr_date();
			//print_r($transactions);	
			foreach ($transactions as $key => $transaction) {
				$date = date('j',strtotime($transaction['date']));
				//echo $date.'#';
				//print_r($transaction);
				$data[$date]['date'] = date('Y-m-d',strtotime($transaction['date']));
				$data[$date]['total'] = $data[$date]['total'] + ($transaction['sub_total'] * $this->fold);
				$data[$date]['total_profit'] = $data[$date]['total_profit'] + ($transaction['sub_total_profit'] * $this->fold);
			}
			$this->load->model('report_model');
			$this->report_model->id_store = $this->id_store;
			foreach ($data as $key => $dt) {
				if(isset($dt['date'])){
					$sd = $dt['date'].' 00:00:00';
					$ed = $dt['date'].' 23:59:59';
					$discount = $this->report_model->get_manual_discount($sd,$ed);

					$data[$key]['total'] -= $discount;
					$data[$key]['total_profit'] -= $discount;
				}
				
			}
			//print_r($data);
		}
		return $data;
	}


	private function arr_date(){
		$date = new DateTime($this->input->post('year').'-'.$this->input->post('month').'-01');
        $date->modify('last day of this month');
        $end_date = $date->format('d');

        $arr = array();
        for ($i=1; $i <=$end_date ; $i++) { 
            $arr[$i] = array('total'=>0,'total_profit'=>0);
        }

        return $arr;
    }

    public function get_yearly_statistic(){
    	$data = array();
		$where_store = ($this->id_store!='all'? "and b.id_store=$this->id_store":"");

		$query = $this->db->query("SELECT a.id_transaction, a.date, b.sub_total, b.sub_total_profit FROM transaction a
									inner join transaction_detail b on a.id_transaction = b.id_transaction
									inner join user c on a.id_user=c.id_user
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									".$where_store."
									order by a.date
									");
		$transactions = $query->result_array();
		if(!empty($transactions)){
			$old_year = '';
			$old_month = '';
			$this->set_fold();

			foreach ($transactions as $key => $transaction) {
				$curr_year = date('Y',strtotime($transaction['date']));
				if($old_year!=$curr_year){
					$old_year = $curr_year;
					$data[$curr_year] = array();
				} 
				$month_year = date('F-Y',strtotime($transaction['date']));
				if(!isset($data[$curr_year][$month_year])) $data[$curr_year][$month_year] = array('total'=>0,'total_profit'=>0);
				$data[$curr_year][$month_year]['total'] = $data[$curr_year][$month_year]['total'] + ($transaction['sub_total'] * $this->fold);
				$data[$curr_year][$month_year]['total_profit'] = $data[$curr_year][$month_year]['total_profit'] + ($transaction['sub_total_profit'] * $this->fold);
			}
		}
		return $data;
    }


	public function set_fold(){
		$this->load->model('option_model');
		$opt = $this->option_model->get_single_option('fold');
        if(!empty($opt)){
            $this->fold = $opt['option_value'];
        }
	}

	public function get_transaction($id){
		$this->db->select('id_transaction, total');
		$this->db->from($this->table);		
		$this->db->where($this->table.'.id_transaction', $id);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_payments($id){
		$this->db->select('id_payment, date, payment_type, payment');
		$this->db->from('payments');		
		$this->db->where('payments.id_transaction', $id);

		$query = $this->db->get();
		return $query->result_array();
	}


	public function update_transaction($id,$date,$status){
		$data = array(
		        'date' => $date,
		        'status_transaction' => $status
				);

		$this->db->where($this->id, $id);
		return $this->db->update($this->table, $data);
	}



	





}
?>	