<?php
class Sub_district extends CI_Controller {
    private $title = 'Kecamatan';
    private $app = 'sub-district';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('sub_district_model');


        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

     public function index($slug='publish'){
        if(isset($_POST['action-table']) && !empty($_POST['action-table']) ){
            if ($_POST['action-table']=='trash' || $_POST['action-table']=='untrash'){
                $this->sub_district_model->update_state();    
            } else if($_POST['action-table']=='delete'){
                $this->delete();
            }
        }

        $data['data'] = $this->sub_district_model->get_data($slug);
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
            $detail_sub = $this->sub_district_model->get_single_data($id);
            $data['data'] = $detail_sub;
            $data['districts'] =  $this->sub_district_model->get_list_district($detail_sub['id_province']);
            $data['province'] =  $this->sub_district_model->get_list_province($detail_sub['id_country']);
            $data['mode'] = 'edit';
            $data['title'] = 'Ubah '.$this->title;
            $data['action'] = '';
        }

        //get country        
        $this->load->model('country_model');
        $this->load->model('province_model');
        $this->load->model('districts_model');

        $data['country'] =  $this->country_model->get_data('publish');

        add_footer_js('admin-sub-district.js');
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
                            array('field' => 'name_subdistrict','label' => 'Kecamatan','rules' => 'trim|required', 'errors' => array('required' => 'Kecamatan harus diisi'))
                        );
        }else{
            $config =   array(
                            array('field' => 'name_subdistrict','label' => 'Kecamatan','rules' => 'trim|required',
                                  'errors' => array('required' => 'Kecamatan harus diisi', 'is_unique' => 'Nama Kecamatan sudah ada')
                                ),
                            array('field' => 'id_district','label' => 'Kabupaten','rules' => 'trim|required', 'errors'=> array('required' => 'Kabupaten wajib diisi')),
                            array('field' => 'id_province','label' => 'Provinsi','rules' => 'trim|required', 'errors'=> array('required' => 'Provinsi wajib diisi')),
                            array('field' => 'id_country','label' => 'Negara','rules' => 'trim|required', 'errors'=> array('required' => 'Negara wajib diisi'))
                        );   
        }

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        }else{
            $data = $this->sub_district_model->get_same_name();
            //print_r($data);


            if(empty($data)){
                //return TRUE;  MODE DATA BARU
                if($mode=='edit'){//update
                    $this->sub_district_model->update($this->input->post('id_sub_district'));
                    $return['status'] = 'success';
                    $return['msg'] = '<p><strong>Berhasil!!!</strong> '.strtolower($this->title).'</p>';
                }else{
                    $this->sub_district_model->add_new();  
                    $return['status'] = 'success';
                    $return['msg'] = '<p><strong>Berhasil!!!</strong> simpan  '.strtolower($this->title).'</p>';
                } 

            }else{
                $id = $this->input->post('id_sub_district');
                if($id==$data['id_sub_district']){
                    //return TRUE;  MODE EDIT DIRI SENDIRI
                    if($mode=='edit'){//update
                        //$this->sub_district_model->update($this->input->post('id_sub_district'));
                        $return['status'] = 'success';
                        $return['msg'] = '<p><strong>Berhasil!!!</strong> ubah '.strtolower($this->title).'</p>';
                    }/*else{
                        $this->sub_district_model->add_new();  
                        $return['status'] = 'success';
                        $return['msg'] = '<p><strong>Berhasil!!!</strong> simpan  '.strtolower($this->title).'</p>';
                    } */

                }else{
                    $return['msg'] = '<p><strong>Error!!</strong></p> Kecamatan dengan nama tersebut sudah tercatat.';
                }
            } 


            /*if($this->is_unique_sub_district()){
                if($mode=='edit'){//update
                    $this->sub_district_model->update($this->input->post('id_sub_district'));
                    $return['status'] = 'success';
                    $return['msg'] = '<p><strong>Berhasil!!!</strong> '.strtolower($this->title).'</p>';
                }else{
                    $this->sub_district_model->add_new();  
                    $return['status'] = 'success';
                    $return['msg'] = '<p><strong>Berhasil!!!</strong> simpan  '.strtolower($this->title).'</p>';
                } 
            }else{
                $return['msg'] = '<p><strong>Error!!</strong></p> Kecamatan dengan nama tersebut sudah tercatat.';
            }*/
        }//form validation
        echo json_encode($return);
    }


    function is_unique_sub_district(){
        $data = $this->sub_district_model->get_same_name();

        if(empty($data)) return TRUE;
        else{
          $id = $this->input->post('id_sub_district');
          if($id==$data['id_sub_district']) return TRUE;  
          else return FALSE;
        } 
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
                if($this->sub_district_model->update_state_single($id, $action)){
                    $return['msg'] = 'Success update state';
                    $return['status'] = 'success';
                }
            }
        }        
        echo json_encode($return);
    }

    public function get_list_sub_district(){
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
            $id_district = $this->input->post('id');
            $districts = $this->sub_district_model->get_list_sub_district($id_district);


            //print_r($districts);
            $dts =  array();
            foreach ($districts as $key => $value) {
                $dts[$key]['id'] = $value['id_sub_district'];
                $dts[$key]['name'] = $value['name_sub_district'];
            }
            $return['sub_districts'] = $dts;
            $return['status'] = 'success';
        }


        echo json_encode($return);
    }

}
?>    