<?php
class Province extends CI_Controller {
    private $title = 'Provinsi';
    private $app = 'province';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('province_model');


        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

     public function index($slug='publish'){
        if(isset($_POST['action-table']) && !empty($_POST['action-table']) ){
            if ($_POST['action-table']=='trash' || $_POST['action-table']=='untrash'){
                $this->province_model->update_state();    
            } else if($_POST['action-table']=='delete'){
                $this->delete();
            }
        }

        $data['data'] = $this->province_model->get_data($slug);
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
            $data['data'] = $this->province_model->get_single_data($id);
            $data['mode'] = 'edit';
            $data['title'] = 'Ubah '.$this->title;
            $data['action'] = '';
        }

        //get country
        $this->load->model('country_model');
        $data['country'] =  $this->country_model->get_data('publish');


        add_footer_js('admin-category-item.js');
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

        if($mode=='edit') {
            $config =   array(
                            array('field' => 'name_province','label' => 'Provinsi','rules' => 'trim|required', 'errors' => array('required' => 'Provinsi harus diisi'))
                        );
        }else{
            $config =   array(
                            array('field' => 'name_province','label' => 'Provinsi','rules' => 'trim|required|is_unique[province.name_province]',
                                  'errors' => array('required' => 'Provinsi harus diisi', 'is_unique' => 'Nama Provinsi sudah ada')
                                ),
                            array('field' => 'id_country','label' => 'Negara','rules' => 'trim|required', 'errors'=> array('required' => 'Negara wajib diisi'))
                        );   
        }

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        }else{
            if($mode=='edit'){//update
                $this->province_model->update($this->input->post('id_province'));
                $return['status'] = 'success';
                $return['msg'] = '<p><strong>Berhasil!!!</strong> '.strtolower($this->title).'</p>';
            }else{
                $this->province_model->add_new();  
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
                        array('field' => 'id','label' => 'ID','rules' => 'required'),
                        array('field' => 'action','label' => 'Action','rules' => 'required'),
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
                if($this->province_model->update_state_single($id, $action)){
                    $return['msg'] = 'Success update state';
                    $return['status'] = 'success';
                }
            }
        }        
        echo json_encode($return);
    }

    public function get_list_province(){
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
            $id_country = $this->input->post('id');
            $province = $this->province_model->get_data('publish',$id_country);

            $dts =  array();
            foreach ($province as $key => $value) {
                $dts[$key]['id'] = $value['id_province'];
                $dts[$key]['name'] = $value['name_province'];
            }
            $return['province'] = $dts;
            $return['status'] = 'success';
        }


        echo json_encode($return);
    }


}

?>