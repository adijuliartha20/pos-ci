<?php 
class Report_model extends CI_Model{
	private $table = 'transaction';
	private $table_detail = 'transaction_detail';
	private $id = 'id_transaction';
	private $fold = 1;

	public $start_date = '';
	public $end_date = '';
	public $id_store = '';



	public function __construct(){
		$this->load->database();
		$this->load->model('option_model');
	}

	public function set_fold(){
		$opt = $this->option_model->get_single_option('fold');
        if(!empty($opt)){
            $this->fold = $opt['option_value'];
        }
	}

	public function data_yearly(){
		$data = array();
		$where_store = ($this->id_store!='all'? "and b.id_store=$this->id_store":"");

		$query = $this->db->query("SELECT a.id_transaction, a.date,
									b.sub_total, b.sub_total_profit FROM transaction a
									inner join transaction_detail b on a.id_transaction = b.id_transaction
									inner join user c on a.id_user=c.id_user
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									AND a.status_transaction = '2'
									".$where_store."
									order by a.date
									");
		$transactions = $query->result_array();
		if(!empty($transactions)){
			$old_year = '';
			$old_month = '';
			$this->set_fold();

			foreach ($transactions as $key => $transaction) {
				//print_r($transaction);
				$curr_year = date('Y',strtotime($transaction['date']));
				if($old_year!=$curr_year){
					$old_year = $curr_year;
					$data[$curr_year] = array();
				} 
				$month_year = date('F-Y',strtotime($transaction['date']));
				if(!isset($data[$curr_year][$month_year])) $data[$curr_year][$month_year] = array('total'=>0,'total_profit'=>0);
				//print_r($transaction);

				$data[$curr_year][$month_year]['total'] = $data[$curr_year][$month_year]['total'] + ($transaction['sub_total'] * $this->fold);
				$data[$curr_year][$month_year]['total_profit'] = $data[$curr_year][$month_year]['total_profit'] + ($transaction['sub_total_profit'] * $this->fold);
			}
		}

		//validate manual discount
		//get manual_discount per date
		foreach ($data as $key => $value) {
			foreach ($value as $my => $mdt) {
				$sd =  date('Y-m-d',strtotime($my));
				$ed = new DateTime($sd);
	            $ed->modify('last day of this month');
	            $ed = $ed->format('Y-m-d').' 23:59:59';

	            $disc = $this->get_manual_discount($sd,$ed);
	            $data[$key][$my]['total'] -= $disc;
	            $data[$key][$my]['total_profit'] -= $disc;
			}	
		}
		return $data;
	}

	/*public function data_monthly(){
		$this->load->model('events_model');
		$data = array();
		$where_store = ($this->id_store!='all'? "and b.id_store=$this->id_store":"");

		$query = $this->db->query("SELECT a.id_transaction, a.date, a.manual_discount,
									b.sub_total, b.sub_total_profit FROM transaction a
									inner join transaction_detail b on a.id_transaction = b.id_transaction
									inner join user c on a.id_user=c.id_user
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									".$where_store."
									order by a.date
									");
		$transactions = $query->result_array();
		//print_r($transactions);
		if(!empty($transactions)){
			$old_month = '';

			$this->set_fold();

			foreach ($transactions as $key => $transaction) {//print_r($transaction);
				$curr_month = date('F-Y',strtotime($transaction['date']));
				if($old_month!=$curr_month){
					$old_month = $curr_month;
					$data[$curr_month] = array();
				} 
				$date = date('d-m-Y',strtotime($transaction['date']));

				if(!isset($data[$curr_month][$date])){//set per date
					$data[$curr_month][$date] = array('total'=>0,'total_profit'=>0);	

					//find event
					$date_db = date('Y-m-d',strtotime($transaction['date'])).' 00:00:00';
					$dt_event = $this->events_model->get_data_by_date($date_db);
					$data[$curr_month][$date]['events'] = '';
					if(!empty($dt_event)){
						$txt_event = '';
						foreach ($dt_event as $key => $event) {
							$txt_event .= ($txt_event!=''?', ':'').$event['event'];
						}
						$data[$curr_month][$date]['events'] = $txt_event;
					}

				} 
				$data[$curr_month][$date]['total'] = $data[$curr_month][$date]['total'] + ($transaction['sub_total'] * $this->fold);
				$data[$curr_month][$date]['total_profit'] = $data[$curr_month][$date]['total_profit'] + ($transaction['sub_total_profit'] * $this->fold);
			}
		}
		//print_r($data);
		return $data;
	}*/

	public function old_data_monthly_old(){
		$this->load->model('events_model');
		$data = array();
		$where_store = ($this->id_store!='all'? "and b.id_store=$this->id_store":"");

		$query = $this->db->query("SELECT a.id_transaction, a.date,
									sum(b.capital_price * b.qty) as sub_total_capital,
									sum(b.sub_total) as total, sum(b.sub_total_profit) as profit 
									FROM transaction a
									inner join transaction_detail b on a.id_transaction = b.id_transaction
									inner join user c on a.id_user=c.id_user
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									".$where_store."
									group by CAST(a.date AS DATE)
									order by a.date
									");
		$transactions = $query->result_array();

		//print_r($transactions);
		//return;
		if(!empty($transactions)){
			$old_month = '';
			$this->set_fold();


			//set table data each day by range
			$nMonths = $this->count_month($this->start_date, $this->end_date);
			$start_month = date('m',strtotime($this->start_date));
			$start_year = date('Y',strtotime($this->start_date));

			//echo $start_month.'#';
			$cMo = $start_month;
			$cYo = $start_year;


			

			for($i=0; $i<=$nMonths; $i++){
				if($cMo==13){
					$cMo = 1;
					$cYo = $cYo +1;	
				}
				$monthName = date('F', mktime(0, 0, 0, $cMo, 10));
				$data[$monthName.'-'.$cYo]= array();
				
				//set data date on each month
				$date = new DateTime("$cYo-$cMo-01");
	            $date->modify('last day of this month');
	            $eD = $date->format('d');




	            for($ii=1;$ii<=$eD;$ii++){
	            	$cDate = ($ii<10? '0':'').$ii.'-'.$cMo.'-'.$cYo;
	            	//get event
					$event = $this->get_text_event("$cYo-$cMo-$ii 00:00:00");
	            	$arr = array(
	            				'total' => 0,
	            				'total_capital'=> 0,
	            				'total_profit'=>0,
	            				'events'=>$event
	            			);
	            	$data[$monthName.'-'.$cYo][$cDate] = $arr;
	            }
				$time = strtotime("$cYo-$cMo-1");
				//echo "$end_date #";
				//$final = date("Y-m-d", strtotime("+1 month", $time));
				//echo $final.'#';
				$cMo = $cMo + 1;
			}

			//print_r($data);
			//echo $this->start_date;

			foreach ($transactions as $key => $transaction) {
				$curr_month = date('F-Y',strtotime($transaction['date']));
				/*if($old_month!=$curr_month){
					$old_month = $curr_month;
					$data[$curr_month] = array();
				} */

				$date = date('d-m-Y',strtotime($transaction['date']));




				//if(!isset($data[$curr_month][$date])){//set per date
					//get manual_discount per date
					$sd = date('Y-m-d',strtotime($transaction['date'])).' 00:00:00';
					$ed = date('Y-m-d',strtotime($transaction['date'])).' 23:59:59';
					$discount = $this->get_manual_discount($sd,$ed);
					//print_r($dt_discount);
					//echo $discount.'#';
					

					$data[$curr_month][$date]['total'] = ($transaction['total'] - $discount) * $this->fold;
					$data[$curr_month][$date]['total_capital'] = $transaction['sub_total_capital'] * $this->fold;
					$data[$curr_month][$date]['total_profit'] = ($transaction['profit']  - $discount) * $this->fold;

					/*//find event
					$date_db = date('Y-m-d',strtotime($transaction['date'])).' 00:00:00';
					$dt_event = $this->events_model->get_data_by_date($date_db);
					$data[$curr_month][$date]['events'] = '';
					if(!empty($dt_event)){
						$txt_event = '';
						foreach ($dt_event as $key => $event) {
							$txt_event .= ($txt_event!=''?', ':'').$event['event'];
						}
						$data[$curr_month][$date]['events'] = $txt_event;
					}*/
					//print_r($dt_event);
				//} 

			}



			/*
			foreach ($transactions as $key => $transaction) {
				$curr_month = date('F-Y',strtotime($transaction['date']));
				if($old_month!=$curr_month){
					$old_month = $curr_month;
					$data[$curr_month] = array();
				} 

				$date = date('d-m-Y',strtotime($transaction['date']));




				//if(!isset($data[$curr_month][$date])){//set per date
					//get manual_discount per date
					$sd = date('Y-m-d',strtotime($transaction['date'])).' 00:00:00';
					$ed = date('Y-m-d',strtotime($transaction['date'])).' 23:59:59';
					$discount = $this->get_manual_discount($sd,$ed);
					//print_r($dt_discount);
					//echo $discount.'#';
					

					$data[$curr_month][$date]['total'] = ($transaction['total'] - $discount) * $this->fold;
					$data[$curr_month][$date]['total_capital'] = $transaction['sub_total_capital'] * $this->fold;
					$data[$curr_month][$date]['total_profit'] = ($transaction['profit']  - $discount) * $this->fold;

					//find event
					$date_db = date('Y-m-d',strtotime($transaction['date'])).' 00:00:00';
					$dt_event = $this->events_model->get_data_by_date($date_db);
					$data[$curr_month][$date]['events'] = '';
					if(!empty($dt_event)){
						$txt_event = '';
						foreach ($dt_event as $key => $event) {
							$txt_event .= ($txt_event!=''?', ':'').$event['event'];
						}
						$data[$curr_month][$date]['events'] = $txt_event;
					}
					//print_r($dt_event);
				//} 

			}*/
		}

		//print_r($data);
		return $data;
	}



	public function data_monthly(){
		$this->load->model('events_model');
		$data = array();
		$where_store = ($this->id_store!='all'? "and b.id_store=$this->id_store":"");

		$query = $this->db->query("SELECT a.id_transaction, a.date,
									sum(b.capital_price * b.qty) as sub_total_capital,
									sum(b.sub_total) as total, sum(b.sub_total_profit) as profit 
									FROM transaction a
									inner join transaction_detail b on a.id_transaction = b.id_transaction
									inner join user c on a.id_user=c.id_user
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									AND a.status_transaction = '2'
									".$where_store."
									group by CAST(a.date AS DATE)
									order by a.date
									");
		$transactions = $query->result_array();

		//print_r($transactions);
		//return;
		if(!empty($transactions)){
			$old_month = '';
			$this->set_fold();


			//set table data each day by range
			$nMonths = $this->count_month($this->start_date, $this->end_date);
			$start_month = date('m',strtotime($this->start_date));
			$start_year = date('Y',strtotime($this->start_date));

			//echo $start_month.'#';
			$cMo = $start_month;
			$cYo = $start_year;


			

			for($i=0; $i<=$nMonths; $i++){
				if($cMo==13){
					$cMo = 1;
					$cYo = $cYo +1;	
				}
				$monthName = date('F', mktime(0, 0, 0, $cMo, 10));
				$data[$monthName.'-'.$cYo]= array();
				
				//set data date on each month
				$date = new DateTime("$cYo-$cMo-01");
	            $date->modify('last day of this month');
	            $eD = $date->format('d');




	            for($ii=1;$ii<=$eD;$ii++){
	            	$cDate = ($ii<10? '0':'').$ii.'-'.$cMo.'-'.$cYo;
	            	//get event
					$event = $this->get_text_event("$cYo-$cMo-$ii 00:00:00");
	            	$arr = array(
	            				'total' => 0,
	            				'total_capital'=> 0,
	            				'total_profit'=>0,
	            				'events'=>$event
	            			);
	            	$data[$monthName.'-'.$cYo][$cDate] = $arr;
	            }
				$time = strtotime("$cYo-$cMo-1");
				$cMo = $cMo + 1;
			}

			//print_r($data);
			//echo $this->start_date;

			foreach ($transactions as $key => $transaction) {
				$curr_month = date('F-Y',strtotime($transaction['date']));
				$date = date('d-m-Y',strtotime($transaction['date']));

				//get manual_discount per date
				$sd = date('Y-m-d',strtotime($transaction['date'])).' 00:00:00';
				$ed = date('Y-m-d',strtotime($transaction['date'])).' 23:59:59';
				$discount = $this->get_manual_discount($sd,$ed);
				
				$data[$curr_month][$date]['total'] = ($transaction['total'] - $discount) * $this->fold;
				$data[$curr_month][$date]['total_capital'] = $transaction['sub_total_capital'] * $this->fold;
				$data[$curr_month][$date]['total_profit'] = ($transaction['profit']  - $discount) * $this->fold;
			}

		}

		return $data;
	}



	function get_text_event($date){
		$txt_event = '';
		$dt_event = $this->events_model->get_data_by_date($date);
		if(!empty($dt_event)){
			$txt_event = '';
			foreach ($dt_event as $key => $event) {
				$txt_event .= ($txt_event!=''?', ':'').$event['event'];
			}
		}
		return $txt_event;
	}



	public function count_month($d1, $d2){
		$d1 = strtotime($d1);
		$d2 = strtotime($d2);
		$min_date = min($d1, $d2);
		$max_date = max($d1, $d2);
		$i = 0;

		while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
		    $i++;
		}
		return $i;
	}


	public function get_manual_discount($start_date,$end_date){
		$discount = 0;
		$query = $this->db->query('select a.id_transaction, a.manual_discount as discount from transaction a 
									inner join transaction_detail b on a.id_transaction=b.id_transaction
								   	where
								   	b.id_store = '.$this->id_store.' and
								    a.date >= "'.$start_date.'" and a.date<= "'.$end_date.'"
								    group by a.id_transaction');
		
		$result = $query->result_array();
		if(!empty($result)){
			foreach ($result as $key => $dt){
				$discount += $dt['discount'];
			}
		}
		return $discount;
	}


	public function data_item_record(){
		$data = array();
		$where_store = ($this->id_store!='all'? "and (a.id_store_old=$this->id_store or a.id_store_new=$this->id_store)":"");


		$sql = "SELECT a.*, b.first_name, b.last_name from record_items a
									inner join user b on a.id_user=b.id_user
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									".$where_store."
									order by a.date
									";
		//echo $sql; return;									
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(!empty($result)){//print_r($result);
			$data = $result;
		}

		return $data;
	}

	public function data_daily($start, $end, $id_store, $status=''){
		$data = array();
		$start = date('Y-m-d', strtotime($start)).' 00:00:00';
		$end = date('Y-m-d', strtotime($end)).' 23:59:59';

		$where_store = ($id_store!='all'? "and b.id_store=$id_store":"");

		$this->set_fold();

		if($status == 'all') $where_status = "";
		else $where_status = ($status=='not-paid'? "AND a.status_transaction <> '2'" : "AND a.status_transaction = '2'");
		//get list transaction
		$query = $this->db->query("SELECT a.id_transaction, a.date, a.manual_discount, a.date_transaction, a.status_transaction, a.id_customer, a.name,
									a.handphone, a.date_of_birth, a.gender, a.address, a.name_sub_district, a.name_district, a.name_province, a.name_country, a.total, a.status_package,

									a.reseller_mode, a.id_user, c.first_name, c.last_name, b.* FROM transaction a
									inner join transaction_detail b on a.id_transaction = b.id_transaction
									inner join user c on a.id_user=c.id_user
									WHERE a.date >=".$this->db->escape($start)." AND a.date <= ".$this->db->escape($end)."
									$where_status
									".$where_store."
									order by a.date, a.id_user
									");
		$transactions = $query->result_array();
		//print_r($transactions);
		if(!empty($transactions)){
			foreach ($transactions as $key => $transaction) {//get detail
				if(!isset($data[$transaction['id_transaction']])) {
					$data[$transaction['id_transaction']] = array();
					$data[$transaction['id_transaction']]['id_transaction'] = $transaction['id_transaction'];
					$data[$transaction['id_transaction']]['date'] = $transaction['date'];
					$data[$transaction['id_transaction']]['reseller_mode'] = $transaction['reseller_mode'];
					$data[$transaction['id_transaction']]['cashier'] = $transaction['first_name'].' '.$transaction['last_name'];
					$data[$transaction['id_transaction']]['id_cashier'] = $transaction['id_user'];
					$data[$transaction['id_transaction']]['manual_discount'] = $transaction['manual_discount'];

					$data[$transaction['id_transaction']]['total'] = $transaction['total'];
					$data[$transaction['id_transaction']]['transaction_status_package'] = $transaction['status_package'];
					$data[$transaction['id_transaction']]['date_transaction'] = $transaction['date_transaction'];
					$data[$transaction['id_transaction']]['status_transaction'] = $transaction['status_transaction'];

					$data[$transaction['id_transaction']]['id_customer'] = $transaction['id_customer'];
					$data[$transaction['id_transaction']]['name'] = $transaction['name'];
					$data[$transaction['id_transaction']]['handphone'] = $transaction['handphone'];
					$data[$transaction['id_transaction']]['date_of_birth'] = $transaction['date_of_birth'];
					$data[$transaction['id_transaction']]['gender'] = $transaction['gender'];

					$data[$transaction['id_transaction']]['address'] = $transaction['address'];
					$data[$transaction['id_transaction']]['name_sub_district'] = $transaction['name_sub_district'];
					$data[$transaction['id_transaction']]['name_district'] = $transaction['name_district'];
					$data[$transaction['id_transaction']]['name_province'] = $transaction['name_province'];
					$data[$transaction['id_transaction']]['name_country'] = $transaction['name_country'];
				}

				$data[$transaction['id_transaction']]['detail'][$transaction['id_transaction_detail']] =  array(
								'id_item'=>$transaction['id_item'],
								'mid'=>$transaction['mid'],
								'item'=>$transaction['item'],
								'category'=>$transaction['category'],
								'capital_price'=>$transaction['capital_price'],

								'price'=>$transaction['price'],
								'type_discount'=>$transaction['type_discount'],
								'discount'=>$transaction['discount'],
								'plus_discount'=>$transaction['plus_discount'],
								'text_discount'=>$transaction['text_discount'],

								'qty'=>$transaction['qty'] * $this->fold,
								'sub_total'=>$transaction['sub_total'] * $this->fold,
								'sub_total_profit'=>$transaction['sub_total_profit'] * $this->fold,
								'id_store'=>$transaction['id_store']
							);





				$q = $this->db->query("select * from payments where id_transaction=".$transaction['id_transaction']." order by date");
				$dt = $q->result_array();

				$data[$transaction['id_transaction']]['payment'] = array();
				if(!empty($dt)){
					foreach ($dt as $key => $vdt) {
						array_push($data[$transaction['id_transaction']]['payment'], $vdt);
					}
				}

				/*$q = $this->db->query("select a.date, a.status, b.first_name, b.last_name from transaction_status a
										inner join user b on a.id_user = b.id_user
										where id_transaction=".$transaction['id_transaction']." order by date");
				$dt = $q->result_array();*/
				$dt = $this->get_list_transaction_status($transaction['id_transaction']);
				$data[$transaction['id_transaction']]['status_package'] = array();
				if(!empty($dt)){
					foreach ($dt as $key => $vdt) {
						array_push($data[$transaction['id_transaction']]['status_package'], $vdt);
					}
				}



				ksort($data[$transaction['id_transaction']]['detail']);
			}
		}

		return $data;
	}

	public function get_list_transaction_status($id){
		$q = $this->db->query("select a.date, a.status, b.first_name, b.last_name from transaction_status a
										inner join user b on a.id_user = b.id_user
										where id_transaction=".$id." order by date");
		$dt = $q->result_array();
		return $dt;
	}




	public function data_bestseller(){
		$data = array();

		$start = date('Y-m-d', strtotime($this->start_date)).' 00:00:00';
		$end = date('Y-m-d', strtotime( $this->end_date)).' 23:59:59';

		$where_store = ($this->id_store!='all'? "and a.id_store=$this->id_store":"");
		$this->set_fold();
		//get list transaction
		$query = $this->db->query("SELECT a.id_item, a.mid, a.item, a.category, a.capital_price, a.price, sum(qty) sell,

			((a.price - a.capital_price)/a.capital_price)*100 profit
		 FROM transaction_detail a
									inner join transaction b on a.id_transaction = b.id_transaction
									WHERE b.date BETWEEN ".$this->db->escape($start)." and ".$this->db->escape($end)."
									".$where_store."
									group by a.id_item
									order by sell desc
									LIMIT 100
									");

		
		$transactions = $query->result_array();
		if(!empty($transactions)){
			$data = $transactions;

			//print_r($data);

			/*//find event
			$date_db = date('Y-m-d',strtotime($transaction['date'])).' 00:00:00';
			$dt_event = $this->events_model->get_data_by_date($date_db);
			$data[$curr_month][$date]['events'] = '';
			if(!empty($dt_event)){
				$txt_event = '';
				foreach ($dt_event as $key => $event) {
					$txt_event .= ($txt_event!=''?', ':'').$event['event'];
				}
				$data[$curr_month][$date]['events'] = $txt_event;
			}	*/
		} 
		return $data;
	}


	public function data_buy_items(){
		$this->load->model('events_model');
		$data = array();
		$where_store = ($this->id_store!='all'? "and b.id_store=$this->id_store":"");


		$query = $this->db->query("SELECT a.id_buy_items, a.date, a.total, c.first_name, c.last_name, b.* FROM buy_items a
									inner join buy_items_detail b on a.id_buy_items = b.id_buy_items
									inner join user c on a.id_user=c.id_user
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									".$where_store."
									order by a.date
									");

		$dts = $query->result_array();
		if(!empty($dts)){
			foreach ($dts as $key => $dt) {//get detail
				if(!isset($data[$dt['id_buy_items']])) {
					$data[$dt['id_buy_items']] = array();
					$data[$dt['id_buy_items']]['date'] = $dt['date'];
					$data[$dt['id_buy_items']]['total'] = $dt['total'];
					$data[$dt['id_buy_items']]['edited'] = $dt['first_name'].' '.$dt['last_name'];
				}
				//print_r($dt);
				$data[$dt['id_buy_items']]['detail'][$dt['id_buy_items_detail']] =  array(
								'id_item'=>$dt['id_item'],
								'mid'=>$dt['mid'],
								'item'=>$dt['item'],
								'category'=>$dt['category'],								

								'price'=>$dt['price'],
								'capital_price'=>$dt['capital_price'],
								'qty'=>$dt['qty'] * $this->fold,
								'sub_total'=>$dt['sub_total'] * $this->fold,
								'id_store'=>$dt['id_store']
							);


				ksort($data[$dt['id_buy_items']]['detail']);
			}
		}

		return $data;
	}

	public function data_check_stock(){
		$data = array();
		$where_store = ($this->id_store!='all'? "and b.id_store=$this->id_store":"");

		$query = $this->db->query("select a.id_stock, a.date, a.name, b.* from check_stock a 
									inner join check_stock_detail b on a.id_stock = b.id_stock
									WHERE a.date >=".$this->db->escape($this->start_date)." AND a.date <= ".$this->db->escape($this->end_date)."
									".$where_store."
									order by a.date
								");
		//echo $query;
		$dts = $query->result_array();
		if(!empty($dts)){ //print_r($dts);
			
			foreach ($dts as $key => $dt) {//get detail
				if(!isset($data[$dt['id_stock']])) {
					$data[$dt['id_stock']] = array();
					$data[$dt['id_stock']]['date'] = $dt['date'];
					$data[$dt['id_stock']]['edited'] = $dt['name'];

					$data[$dt['id_stock']]['total_minus'] = 0;
					$data[$dt['id_stock']]['total_plus'] = 0;
				}
				//print_r($dt);
				$data[$dt['id_stock']]['detail'][$dt['id_stock_detail']] =  array(
								'id_item'=>$dt['id_item'],
								'mid'=>$dt['mid'],
								'item'=>$dt['item'],
								'category'=>$dt['category'],								

								'capital_price'=>$dt['capital_price'],
								'price'=>$dt['price'],								
								'qty_comp'=>$dt['qty_comp'] * $this->fold,
								'qty_store'=>$dt['qty_store'] * $this->fold,

								'margin_qty'=>$dt['margin_qty'],
								'minus_stock'=>$dt['minus_stock'],
								'plus_stock'=>$dt['plus_stock'],
								'id_store'=>$dt['id_store']
							);

				$data[$dt['id_stock']]['total_minus'] += $dt['minus_stock'];
				$data[$dt['id_stock']]['total_plus'] += $dt['plus_stock'];


				ksort($data[$dt['id_stock']]['detail']);
			}
		}

		return $data;
	}


	public function data_not_check_stock(){
		$data = array();
		$where_store = ($this->id_store!='all'? "and a.id_store=$this->id_store":"");
		$query = $this->db->query("select id_item, mid, item, category, capital_price, qty, price, (qty * price) sub_total from items 
									inner join category_item on items.id_cat = category_item.id_cat
									where qty > 0 and id_store=$this->id_store
									and not exists 
									(select a.item from check_stock_detail a inner join check_stock b on a.id_stock=b.id_stock     
								     where b.date >=".$this->db->escape($this->start_date)." 
								     AND b.date <= ".$this->db->escape($this->end_date)." and
								     a.id_item=items.id_item and a.id_store=$this->id_store)

								     order by mid	
								");						
		//echo $query;
		$dts = $query->result_array();
		if(!empty($dts)){ //print_r($dts);
			$data = $dts;			
		}

		return $data;
	}
}

/*
select id_item from items where exists (select a.item from check_stock_detail a where a.id_item=items.id_item)


select id_item from items where exists (select a.item from check_stock_detail a where a.id_item=items.id_item and a.id_store=1)

select id_item, mid, item, qty from items where qty > 0 
	and not exists 
	(select a.item from check_stock_detail a inner join check_stock b on a.id_stock=b.id_stock     
     where b.date >='2019-2-1 00:00:00' AND b.date <= '2019-02-28 23:59:59' and
     a.id_item=items.id_item and a.id_store=1)

*/

?>	