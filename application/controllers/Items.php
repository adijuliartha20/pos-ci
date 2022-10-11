<?php
class Items extends CI_Controller {
    private $title = 'Stok Barang';
    private $app = 'items';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('items_model');


        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

    public function index($slug='publish'){
        if(isset($_POST['action-table']) && !empty($_POST['action-table']) ){
            if ($_POST['action-table']=='trash' || $_POST['action-table']=='untrash'){
                $this->items_model->update_state();    
            } else if($_POST['action-table']=='delete'){
                $this->delete();
            }
        }

        $data['data'] = $this->items_model->get_data($slug);
        $data['title'] = $this->title;
        $data['state'] = $slug;
        $data['app'] = $this->app;


        add_footer_js(array('main-admin.js','admin-items.js'));
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/index', $data);
        $this->load->view('admin/templates/footer');
    }


     public function create($id=''){
        $this->load->model('category_item_model');
        $this->load->model('store_model');
        $this->load->model('option_model');

        $data['title'] = 'Barang Baru';//$this->title;
        $data['action'] = '';
        $data['mode'] = 'create';
        $data['app'] = $this->app;
        $data['data']['id_item'] = time();

        $data['category'] = $this->category_item_model->get_data('publish','category');
        $data['store'] = $this->store_model->get_data('publish');
        $opt =  $this->option_model->get_single_option('manual_code');
        if(!empty($opt)){
            $data['is_manual_code'] = $opt['option_value'];
        }
        

        if(!empty($id)){
            $data['action'] = 'Ubah Barang';
            $data['data'] = $this->items_model->get_single_data($id);
            $data['mode'] = 'edit';
        }

        add_footer_js('admin-items.js');
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/form', $data);
        $this->load->view('admin/templates/footer');
    }

    public function save(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('option_model');
        
        $error = 0;
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = '<p><strong>Error!!</strong> sistem error, silahkan hubungi administrator</p>';
        $mode = $_POST['mode'];

        $config =   array(
                        array('field' => 'id','label' => 'Kode','rules' => 'trim|required'.($mode!='edit'?'|is_unique[items.id_item]':''),
                                                                                                               'errors'=> array('is_unique' => 'Kode sudah terpakai')),
                        array('field' => 'id_cat','label' => 'Kategori','rules' => 'trim|required', 'errors'=> array('required' => 'Kategori wajib diisi')),
                        array('field' => 'item','label' => 'Nama Barang','rules' => 'trim|required','errors'=> array('required' => 'Nama Barang wajib diisi')),
                        //array('field' => 'qty','label' => 'Qty','rules' => 'trim|required'),
                        array('field' => 'capital_price','label' => 'Harga Pokok','rules' => 'trim|required|greater_than[0]', 'errors'=> array('required' => 'Harga Pokok wajib diisi','greater_than'=> 'Harga Pokok tidak boleh 0')),
                        array('field' => 'price','label' => 'Harga Jual','rules' => 'trim|required|greater_than['.$this->input->post('capital_price').']'
                                                                , 'errors'=> array('required' => 'Harga Jual wajib diisi', 'greater_than' => 'Harga jual harus lebih tinggi dari harga pokok')),
                        array('field' => 'id_store','label' => 'Toko','rules' => 'trim|required', 'errors'=> array('required' => 'Nama Toko wajib diisi'))
                    );
       
        $opt =  $this->option_model->get_single_option('manual_code');
        $cc = array();
        //print_r($opt);
        if(!empty($opt) && $opt['option_value']=='yes'){
            $cc =   array(
                            //array('field' => 'mid','label' => 'Manual ID','rules' => 'trim|required'.($mode!='edit'?'|is_unique[items.mid]':''))
                            array('field' => 'mid','label' => 'Kode Manual','rules' => 'trim|required|is_unique[items.mid]', 'errors'=> array('required' => 'MID wajib diisi', 'is_unique' => 'Kode sudah terpakai'))
                        );
            //validate when mode edit
            $mid = $this->input->post('mid');
            if($mode=='edit'){
                $old = $this->items_model->get_single_data($this->input->post('id'));
                $old_mid = $old['mid'];
                if($mid==$old_mid){
                    $cc =   array(
                                array('field' => 'mid','label' => 'Kode Manual','rules' => 'trim|required', 'errors'=> array('required' => 'MID wajib diisi'))
                            );
                }
            }
        }


        $reseller_price = $this->input->post('reseller_price');
        if(!empty($reseller_price)){
            $crp = array('field' => 'reseller_price','label' => 'Harga Reseller','rules' => 'trim|greater_than['.$this->input->post('capital_price').']',
                           'errors' => array('greater_than' => 'Harga reseller harus lebih tinggi dari harga pokok')
                            );
            array_push($config, $crp);
        }
        


        foreach ($cc as $key => $c) {array_push($config, $c);}
        //print_r($config);
        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        }else{
            if($mode=='edit'){//update
                //print_r($_POST);
                $this->items_model->record_item($this->input->post('id'));

                $this->items_model->update($this->input->post('id'));
                $return['status'] = 'success';
                $return['msg'] = '<p><strong>Berhasil!!!</strong> ubah data '.strtolower($this->title).'</p>';
            }else{
                $this->items_model->add_new();  
                $return['status'] = 'success';
                $mid = $this->input->post('mid');
                $item = $this->input->post('item');

                $return['msg'] = '<p><strong>Berhasil!!!</strong> simpan data '.strtolower($this->title).': '.$mid.' - '.$item.'</p>';
                $return['new_id'] = time();
            }    
        }//form validation
        echo json_encode($return);
    }


    public function change_status(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $return = array();
        $return['status'] = 'error';

        $config =  array(
                        array('field' => 'id','label' => 'ID','rules' => 'required'),
                        array('field' => 'action','label' => 'Action','rules' => 'required'),
                    );    
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE){
            $return['msg'] = 'Error field cannot empty';
        }else{
            $id = $this->input->post('id');
            $action = $this->input->post('action');

            $this->items_model->record_item_change_status($id,$action);
            //($this->input->post('id'));
            if($action=='delete'){
                $this->single_delete($id);
                $return['msg'] = 'Success delete category item';
                $return['status'] = 'success';
            }else if($action == 'trash' || $action == 'publish') {
                if($this->items_model->update_state_single($id, $action)){
                    $return['msg'] = 'Success update state';
                    $return['status'] = 'success';
                }
            }
        }        
        echo json_encode($return);
    }

    public function delete(){
        foreach ($_POST['ids'] as $key => $id) {
            $this->items_model->record_item_change_status($id,'delete');
            $this->single_delete($id);
        }
    }

    public function single_delete($id){
       $this->items_model->delete($id);
    }

}