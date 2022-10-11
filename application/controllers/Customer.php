<?php
class Customer extends CI_Controller {
    private $title = 'Konsumen';
    private $app = 'customer';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('customer_model');


        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

     public function index($slug='publish'){
        if(isset($_POST['action-table']) && !empty($_POST['action-table']) ){
            if ($_POST['action-table']=='trash' || $_POST['action-table']=='untrash'){
                $this->customer_model->update_state();    
            } else if($_POST['action-table']=='delete'){
                $this->delete();
            }
        }

        $data['data'] = $this->customer_model->get_data($slug);
        //print_r($data['data']);
       
        $data['title'] = $this->title;
        $data['state'] = $slug;
        $data['app'] = $this->app;


        add_footer_js(array('admin-no-delete.js','admin-items.js'));
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function create($id=''){
        $data['title'] = $this->title.' Baru';
        $data['action'] = '';
        $data['mode'] = 'create';
        $data['app'] = $this->app;
        //$data['id_country'] = '';

        if(!empty($id)){
            $detail_sub = $this->customer_model->get_single_data($id);
            $dob = explode('-', $detail_sub['date_of_birth']);
            $detail_sub['date_of_birth'] = "$dob[1]/$dob[2]/$dob[0]";
            //print_r($detail_sub);

            $data['data'] = $detail_sub;
            $data['sub_district'] =  $this->customer_model->get_list_sub_district($detail_sub['id_district']);
            $data['districts'] =  $this->customer_model->get_list_district($detail_sub['id_province']);
            $data['province'] =  $this->customer_model->get_list_province($detail_sub['id_country']);

            $data['mode'] = 'edit';
            $data['title'] = 'Ubah '.$this->title;
            $data['action'] = '';
        }

        //get country        
        $this->load->model('country_model');

        $data['country'] =  $this->country_model->get_data('publish');

        add_footer_js('admin-customer.js');
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/form', $data);
        $this->load->view('admin/templates/footer');
    }


    public function save(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $error = 0;
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = '<p><strong>Error!!</strong> sistem is error, please contact the administrator</p>';
        $mode = $_POST['mode'];


        $config =   array(
                            array('field' => 'name','label' => 'Address','rules' => 'trim|required', 'errors'=> array('required' => 'Nama wajib diisi')),
                            array('field' => 'handphone','label' => 'Provinsi','rules' => 'trim|required'.($mode!='edit'?'|is_unique[customer.handphone]':'').'', 'errors'=> array('required' => 'Handphone wajib diisi','is_unique' => 'Handphone sudah ada')
                                ),

                            array('field' => 'id_sub_district','label' => 'Kecamatan','rules' => 'trim|required', 'errors'=> array('required' => 'Kecamatan wajib diisi')),
                            array('field' => 'id_district','label' => 'Kabupaten','rules' => 'trim|required', 'errors'=> array('required' => 'Kabupaten wajib diisi')),
                            array('field' => 'id_province','label' => 'Provinsi','rules' => 'trim|required', 'errors'=> array('required' => 'Provinsi wajib diisi')),
                            array('field' => 'id_country','label' => 'Negara','rules' => 'trim|required', 'errors'=> array('required' => 'Negara wajib diisi')),

                            array('field' => 'address','label' => 'Address','rules' => 'trim|required', 'errors'=> array('required' => 'Address wajib diisi')),
                            array('field' => 'gender','label' => 'gender','rules' => 'trim|required', 'errors'=> array('required' => 'Jenis Kelamin wajib diisi')),
                            array('field' => 'date_of_birth','label' => 'date_of_birth','rules' => 'trim|required', 'errors'=> array('required' => 'Tanggal lahir wajib diisi'))
                        );

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        }else{
            //echo 'proses';
            if($mode=='edit'){//update
                $this->customer_model->update($this->input->post('id_customer'));
                $return['status'] = 'success';
                $return['msg'] = '<p><strong>Berhasil!!!</strong> '.strtolower($this->title).'</p>';
            }else{
                $this->customer_model->add_new();  
                $return['status'] = 'success';
                $return['msg'] = '<p><strong>Berhasil!!!</strong> simpan  '.strtolower($this->title).'</p>';
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
                        array('field' => 'id','label' => 'ID','rules' => 'required')
                    );    
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE){
            $return['msg'] = 'Error field cannot empty';
        }else{
            $id = $this->input->post('id');
            $action = $this->input->post('action');
            if($action=='delete'){
                /*$this->single_delete($id);
                $return['msg'] = 'Success delete category item';
                $return['status'] = 'success';*/
            }else if($action == 'trash' || $action == 'publish') {
                if($this->customer_model->update_state_single($id, $action)){
                    $return['msg'] = 'Success update state';
                    $return['status'] = 'success';
                }
            }
        }        
        echo json_encode($return);
    }







}    