<?php
class Transaction extends CI_Controller {
    private $title = 'Transaksi';
    private $app = 'transaction';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('option_model');
        $this->load->model('transaction_model');

        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

    public function index($slug='publish'){
        $opt =  $this->option_model->get_single_option('manual_code');
        $data['min_length_id'] = 10;
        if(!empty($opt)){
            $data['is_manual_code'] = $opt['option_value'];
            if($data['is_manual_code']=='yes') $data['min_length_id'] = 5;
        }


        //opt discount
        $opt =  $this->option_model->get_single_option('discount_per_item');
        $discount_per_item = 'disable';
        if(!empty($opt)){
            $discount_per_item = $opt['option_value'];
        }
        $data['dpi'] = $discount_per_item;



        $data['title'] = $this->title;
        $data['state'] = $slug;
        $data['app'] = $this->app;

        $data['num_transaction'] = $this->transaction_model->get_transaction_num();
        $date=date_create($this->option_model->get_current_date());
        $data['date'] = date_format($date,"d F Y");
        
        add_footer_js(array('main-admin.js','admin-transaction.js'));
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/form-2', $data);
        $this->load->view('admin/templates/footer');
    }

    public function get_data_item(){
        $this->load->model('items_model');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $return = array();
        $return['status'] = 'error';
        $return['msg'] = 'Item not found';    

        $id = $this->input->post('id'); 
        $reseller_mode = $this->input->post('reseller_mode');

        $opt =  $this->option_model->get_single_option('manual_code');
        $mode_code = 'barcode';
        if(!empty($opt) && $opt['option_value']=='yes'){
            $mode_code = 'manual_code';
        }
        
        //get data
        $dt = $this->items_model->get_single_data($id,$mode_code);
        //print_r($dt);
        if(!empty($dt)){
            if($dt['qty']==0){
                $return['msg'] = 'Item is empty';
            }else{
                $data = array();
                $return['item'] = $dt['item'];
                $return['max'] = $dt['qty'];
                $return['id_store'] = $dt['id_store'];

                if($reseller_mode=='yes'){
                    $return['text_price'] = number_format($dt['reseller_price']);
                    $return['true_price'] = $dt['reseller_price'];
                }else{
                    if(empty($dt['type_discount'])){//check general discount
                        $return['text_price'] = number_format($dt['price']);
                        $return['true_price'] = $dt['price'];
                        $opt_type_disc =  $this->option_model->get_single_option('type_discount');
                        //print_r($opt_type_disc);
                        if(!empty($opt_type_disc)){
                            $opt_disc = $this->option_model->get_single_option('discount');                     
                            $disc = $opt_disc['option_value'];

                            $type_discount = $opt_type_disc['option_value'];
                            $discount = number_format($disc);
                            $text_discount = ($type_discount=='percent'? $discount.'%': $discount);
                            $return['text_discount'] = $text_discount;

                            $return['true_price'] = $dt['price'] - ($type_discount=='percent'? ($dt['price'] * $disc/100) : $disc );
                        }


                        //print_r($dt);
                    }else{
                        $return['text_price'] = number_format($dt['price']);
                        $return['true_price'] = $dt['true_price'];

                        $type_discount = $dt['type_discount'];
                        $discount = number_format($dt['discount']);
                        $text_discount = ($type_discount=='percent'? $discount.'%': $discount);
                        $plus_discount = number_format($dt['plus_discount']);
                        if(!empty($plus_discount)){
                            $plus_discount = ($type_discount=='percent'? $plus_discount.'%': $plus_discount);
                            $text_discount = ''.$text_discount.' + '.$plus_discount.'';
                        }
                        $return['text_discount'] = $text_discount;
                    }
                    
                }
                
                $return['status'] = 'success';
                $return['msg'] = '';
            }

        }
        echo json_encode($return);
    }


    public function list_options(){
        $options = array(
                            'manual_code'=>'',
                            'type_discount'=>'',
                            'discount'=>''
                        );
                   
        return $options;
    }


    public function search_customer(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('customer_model');
        //$this->load->model('transaction_model');
        
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = '<p><strong>Error!!</strong> sistem is error, please contact the administrator</p>';


        $config =   array(
                            array('field' => 'search_by','label' => 'Tipe Cari','rules' => 'trim|required', 'errors'=> array('required' => 'Tipe cari wajib diisi')),
                            array('field' => 'search','label' => 'Keyword','rules' => 'trim|required', 'errors'=> array('required' => 'Keyword wajib diisi'))
                        );

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        }else{
            $search_by = $this->input->post('search_by');
            $search = $this->input->post('search');

            $data = $this->customer_model->get_list_customer_by($search_by,$search);
            $return['status'] = 'success';
            $return['data'] = $data;
        }//form validation
        echo json_encode($return);

    }


    public function save(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');
        //$this->load->model('transaction_model');
        
        $return = array();
        $return['status'] = 'error';

        //print_r($_POST);
        $opt =  $this->option_model->get_single_option('manual_code');
        $mode_code = 'barcode';
        if(!empty($opt) && $opt['option_value']=='yes'){
            $mode_code = 'manual_code';
        }

        $opt =  $this->option_model->get_single_option('discount_per_item');
        $dpi = 'disable';
        if(!empty($opt)){
            $dpi = $opt['option_value'];
        }

        $items = $this->input->post('items');
        $discounts = $this->input->post('discounts');
        $quantity = $this->input->post('qty');
        $error = 0;
        foreach($items as $ind=>$val) {//validate if field require
            $item  = $items[$ind];
            $qty = $quantity[$ind];
            if($item=='' || $qty=='') {
                $return['msg'] = 'Data Tidak benar, silahkan cek kode barang yang anda masukkan';
                $error++;
                break;
            }else{ //cek all item is available
                $dt = $this->items_model->get_single_data_with_category($item,$mode_code);
                //print_r($dt);
                $qty_available = $dt['qty'];
                if($qty_available < $qty){
                    $return['msg'] = 'Stok '.$dt['item'].' kosong, tolomh pastikan transaksi anda benar ';
                    $error++;
                    break;
                }

            }
        }

        if ($error==0){
            $id_transaction = time();

            //$this->load->model('option_model');
            $date = $this->option_model->get_current_date('datetime');

            $total = 0;
            $total_profit = 0;
            $reseller_mode = $this->input->post('reseller_mode');

            //save to detail transaction
            foreach ($items as $key => $item) {
                $order = $key+1;
                //get data
                $dt = $this->items_model->get_single_data_with_category($item,$mode_code);
                $qty_available = $dt['qty'];
                $qty = $quantity[$key];
                
                if($qty_available==0){
                    $return['msg'] = 'Item is empty';
                    $error++;
                }else{
                    $capital_price = $dt['capital_price'];

                    if($reseller_mode=='yes'){//no discount
                        $price = $dt['reseller_price'];//price text

                        $true_price = $dt['reseller_price']; 
                        $sub_total = $true_price * $qty;
                        $sub_total_profit = ($true_price - $capital_price) * $qty;

                        $total += $sub_total;
                        $total_profit += $sub_total_profit;
                    }else{
                        $price = $dt['price'];//price text
                        $true_price = $dt['true_price'];   

                        //jika discount per item tidak di set
                        if(empty($dt['type_discount'])){
                            if($dpi=='enable'){//check discount per item manual on form
                                $disc = (int)$discounts[$key];

                                $true_price = $dt['price'] - $disc;
                                $dt['type_discount'] = 'value';
                                $dt['discount'] = $disc;
                            }else{
                                //check general discount
                                $opt_type_disc =  $this->option_model->get_single_option('type_discount');
                                if(!empty($opt_type_disc)){
                                    $opt_disc = $this->option_model->get_single_option('discount');                     
                                    $disc = $opt_disc['option_value'];
                                    $type_discount = $opt_type_disc['option_value'];

                                    $true_price = $dt['price'] - ($type_discount=='percent'? ($dt['price'] * $disc/100) : $disc );

                                    $dt['type_discount'] = $type_discount;
                                    $dt['discount'] = $disc;
                                }
                            }
                        }


                        $sub_total = $true_price * $qty;
                        $sub_total_profit = ($true_price - $capital_price) * $qty;

                        $total += $sub_total;
                        $total_profit += $sub_total_profit;
                    }
                                        
                    //save_detail($id_transaction, $dt, $qty, $price, $sub_total, $sub_total_profit, $reseller_mode, $order)
                    if(!$this->transaction_model->save_detail($id_transaction, $dt, $qty, $price, $sub_total, $sub_total_profit, $reseller_mode, $order)){
                        $error++;
                    }
                }   
            }

            //save to transaction
            if($error==0){
                //validate manual discount
                $manual_discount = $this->input->post('manual_discount');

                $total_before_discount          = $total;
                $total                          = $total - $manual_discount;
                $total_profit_before_discount   = $total_profit;
                $total_profit                   = $total_profit - $manual_discount;

                $id_customer = $this->input->post('id_customer');
                $this->load->model('customer_model');
                $customer = $this->customer_model->get_single_data($id_customer);
                $payment = (int)str_replace(',','', $this->input->post('payment') );
                $payment_type = $this->input->post('payment_type');
                $status_package = $this->input->post('status_transcation');

                $remaining_pay = $total - $payment;
                //echo "remaining_pay $remaining_pay";
                if($remaining_pay<=0){
                    $status_transaction = 2;
                }else if($remaining_pay > 0 && $payment !=0){
                    $status_transaction = 1;
                }else if($remaining_pay == $total){
                    $status_transaction = 0;
                }
                //echo "status_transaction $status_transaction";

                //save payment                
                $this->transaction_model->save_payemnts($date, $payment, $payment_type, $id_transaction);

                //save status
                $this->transaction_model->save_status($id_transaction, $status_package, $date);



                if(!$this->transaction_model->save_new($id_transaction, $date, $manual_discount, $total, $total_before_discount, $total_profit, $total_profit_before_discount, $reseller_mode, $customer, $status_transaction, $status_package)){
                    $error++;
                }

                /*if(!$this->transaction_model->save($id_transaction, $date, $manual_discount, $total, $total_before_discount, $total_profit, $total_profit_before_discount, $reseller_mode,
                    $name_consumen, $phone, $sub_district, $district, $province, $address)){
                    $error++;
                }*/
            }

            //update each item
            
            if($error==0){
                $return['status'] = 'success';
                $return['msg'] = 'Transaction is success';
                $return['num_transaction'] = $this->transaction_model->get_transaction_num();
            }


        }
        echo json_encode($return);
    }
}    
?>    