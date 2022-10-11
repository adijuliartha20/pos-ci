<?php
class Buy extends CI_Controller {
    private $title = 'Belanja Barang';
    private $app = 'buy';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('option_model');

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

        add_footer_js(array('main-admin.js','admin-buy.js'));
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
            /*if($dt['qty']==0){
                $return['msg'] = 'Item is empty';
            }else{*/
                $data = array();                
                $return['item'] = $dt['item'];
                $return['price'] = number_format($dt['price']);
                $return['capital_price'] = number_format($dt['capital_price']);
                $return['true_price'] = $dt['capital_price'];                               
                $return['status'] = 'success';
                $return['msg'] = '';
            //}

        }
        echo json_encode($return);
    }



    public function save(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');
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
            $id_Buy = time();

            $error = 0;
            $this->load->model('buy_item_model');
            foreach ($items as $key => $item) {
                $id_Buy_detail = $key+1;
                $dt = $this->items_model->get_single_data_with_category($item,$mode_code);//get data

                if(!empty($dt)){
                    $id_item = $dt['id_item'];
                    $mid = $dt['mid'];
                    $item = $dt['item'];
                    $category = $dt['category'];
                    $price = $dt['price'];

                    $capital_price = $dt['capital_price'];
                    $id_store = $dt['id_store'];
                    $qty = $quantity[$key];
                    $sub_total = $qty * $capital_price;
                    $total += $sub_total;

                    if(!$this->buy_item_model->save_detail($id_Buy_detail, $id_Buy, $id_item, $mid, $item, $category,
                                                             $price, $capital_price, $qty, $sub_total, $id_store)) $error++;
                }else{
                    $error++;
                }
            }


            if($error==0){//save buy_item
                if(!$this->buy_item_model->save($id_Buy, $date, $total)) $error++;
            }


            if($error==0){//update item & record    
                foreach ($items as $key => $item) {
                    if(!$this->buy_item_model->record_item_update($item, $quantity[$key], $mode_code))$error++;
                }
            }

            if($error==0){
                $return['status'] = 'success';
                $return['msg'] ='<p><strong>Sukses simpan belanja barang!!</strong></p>';
            }

        }    

        echo json_encode($return);
    }

}    


