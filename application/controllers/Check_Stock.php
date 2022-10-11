<?php
class Check_Stock extends CI_Controller {
    private $title = 'Check Stock';
    private $app = 'check-stock';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('option_model');
        //$this->load->model('check_stock_model');

        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

    public function index($slug='publish'){
        $opt =  $this->option_model->get_single_option('manual_code');
        $data['min_length_id'] = 10;
        if(!empty($opt)){
            $data['is_manual_code'] = $opt['option_value'];
            if($data['is_manual_code']=='yes') $data['min_length_id'] = 5;
        }

        $data['title'] = $this->title;
        $data['state'] = $slug;
        $data['app'] = $this->app;

       
        //echo $data['num_transaction'].'#';

        add_footer_js(array('main-admin.js','admin-check-stock.js'));
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/form', $data);
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
        if(!empty($dt)){
            //if($dt['qty']==0){
                //$return['msg'] = 'Item is empty';
            //}else{
                $data = array();
                $return['item'] = $dt['item'];
                $return['max'] = $dt['qty'];

                if($reseller_mode=='yes'){
                    $return['text_price'] = number_format($dt['reseller_price']);
                    $return['true_price'] = $dt['reseller_price'];
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
                
                $return['status'] = 'success';
                $return['msg'] = '';
            //}

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

    public function save(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');
        $this->load->model('check_stock_model');
        //$this->load->model('transaction_model');
        
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = '<p><strong>Error!!</strong> sistem is error, please contact the administrator</p>';
        $config =   array(
                        array('field' => 'items[]','label' => 'Items','rules' => 'trim|required'),
                        array('field' => 'qty[]','label' => 'Qty','rules' => 'trim|required')
                    );

        $this->form_validation->set_rules($config);
        //$return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        }else{
            $opt =  $this->option_model->get_single_option('manual_code');
            $mode_code = 'barcode';
            if(!empty($opt) && $opt['option_value']=='yes'){
                $mode_code = 'manual_code';
            }

            $items = $this->input->post('items');
            $quantity = $this->input->post('qty');


            if (function_exists( 'date_default_timezone_set' )) {
                 $ci = &get_instance();
                 date_default_timezone_set($ci->config->item('timezone'));
            }
            
            $date = date('Y-m-d H:i:s');
            $total = 0;
            $id = time();

            $error = 0;
            $this->load->model('buy_item_model');
            foreach ($items as $key => $item) {
                $id_detail = $key+1;
                $dt = $this->items_model->get_single_data_with_category($item,$mode_code);//get data
                //print_r($dt);
                if(!empty($dt)){
                    
                    $id_item = $dt['id_item'];
                    $mid = $dt['mid'];
                    $item = $dt['item'];
                    $category = $dt['category'];
                    $capital_price = $dt['capital_price'];
                    $price = $dt['price'];
                    
                    $qty_comp = $dt['qty'];
                    $qty_store = $quantity[$key];                    
                    //$margin_qty = $qty_comp - $qty_store;
                    $margin_qty = $qty_store - $qty_comp;
                    $minus_stock = 0;
                    $plus_stock = 0;

                    $margin_value = $margin_qty * $capital_price;
                    if($margin_qty<0)   $minus_stock = $margin_value;
                    if($margin_value>0) $plus_stock = $margin_value;                    
                    $id_store = $dt['id_store'];                

                    if(!$this->check_stock_model->save_detail($id_detail, $id, $id_item, $mid, $item, $category, $capital_price, 
                                                                $price, $qty_comp, $qty_store, $margin_qty, $minus_stock, 
                                                                $plus_stock, $id_store)) $error++;
                }else{
                    $error++;
                }
            }



            if($error==0){//save buy_item
                if(!$this->check_stock_model->save($id, $date)) $error++;
            }

            if($error==0){
                $return['status'] = 'success';
                $return['msg'] ='<p><strong>Sukses simpan cek stok barang!!</strong></p>';
            }
        }
        
        echo json_encode($return);
    }
}    