<?php
class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('user_model');

        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

    public function index($slug='publish'){
        if(isset($_POST['action-table']) && !empty($_POST['action-table']) ){
            if ($_POST['action-table']=='trash' || $_POST['action-table']=='untrash'){
                $this->user_model->update_state();    
            } else if($_POST['action-table']=='delete'){
                $this->delete_user();
            }
        }

        $data['data'] = $this->user_model->get_user($slug);
        $data['title'] = 'User';
        $data['state'] = $slug;
        $data['app'] = 'user';


        add_footer_js(array('main-admin.js','admin-user.js'));
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/user/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function create($id='',$edit_profile = 'no'){
        $data['title'] = 'Tambah User';
        $data['action'] = '';
        $data['mode'] = 'create';
        $data['is_edit_profile'] = 'no';


        if(isset($_SESSION['logged']) && $_SESSION['logged']=='TRUE' && $edit_profile == 'yes'){
            $id = $_SESSION['id'];
            $data['action'] = 'Profile';
            $data['title'] = 'Details';
            $data['is_edit_profile'] = 'yes';
            //print_r($_SESSION);
        }

        if(!empty($id)){
            $data['title'] = 'Edit User';
            $data['user'] = $this->user_model->get_single_user($id);
            $data['mode'] = 'edit';
        }

        add_footer_js('admin-user.js');
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/user/form', $data);
        $this->load->view('admin/templates/footer');
    }


    public function edit_profile(){
        return $this->create('','yes');
    }



    public function save(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $error = 0;
        $return = array();
        $return['status'] = 'error';
        $return['msg'] = '<p><strong>Error!!</strong> sistem is error, please contact the administrator</p>';
        $mode = $_POST['mode'];
        $is_edit_profile = $this->input->post('is_edit_profile');

        $config =   array(
                        
                        array('field' => 'first_name','label' => 'First Name','rules' => 'required','errors' => array('required' => 'Nama Depan wajib diisi')),
                        array('field' => 'last_name','label' => 'Last Name','rules' => 'required','errors' => array('required' => 'Nama Belakang wajib diisi')),
                        array('field' => 'gender','label' => 'Gender','rules' => 'required','errors' => array('required' => 'Jenis Kelamin wajib diisi')),
                        array('field' => 'phone','label' => 'Phone','rules' => 'required','errors' => array('required' => 'No hp wajib diisi')),
                    );

        if($_SESSION['access'] == 'admin'){
            array_push($config, array('field' => 'user_tipe','label' => 'User Tipe','rules' => 'required'));
        }

        if($mode=='create'){
            $cc =   array(
                            array('field' => 'username','label' => 'Username','rules' => 'trim|required|is_unique[user.username]','errors' => array('is_unique' => 'Username sudah dipakai')),
                            array('field' => 'password','label' => 'Password','rules' => 'trim|required|min_length[6]','errors' => array('required' => 'Panjang password minimal %s karakter.')),
                            array('field' => 'confirm_password','label' => 'Password Confirmation','trim|required|min_length[6]' => 'required','errors' => array('min_length' => 'Panjang password minimal %s karakter.')),
                            array('field' => 'email','label' => 'Email','rules' => 'trim|required|valid_email|is_unique[user.email]','errors' => array('is_unique' => 'Email sudah dipakai'))
                        );
        }else{
            $cc = array();
            if(isset($_POST['password']) && !empty($_POST['password']))  array_push($cc, array('field' => 'password','label' => 'Password','rules' => 'trim|required|min_length[6]','errors' => array('min_length' => 'Panjang password minimal %s karakter.')));

            if(isset($_POST['confirm_password']) && !empty($_POST['confirm_password']))  array_push($cc, array('field' => 'confirm_password','label' => 'Confirm Password','rules' => 'trim|required|min_length[6]','errors' => array('min_length' => 'Panjang password minimal %s karakter.')));

            if(isset($_POST['email']) && !empty($_POST['email']))  array_push($cc, array('field' => 'email','label' => 'Email','rules' => 'trim|required|valid_email'));

        }

        foreach ($cc as $key => $c) {array_push($config, $c);}
        $this->form_validation->set_rules($config);
        //print_r($config);


        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        }else{
            if(!empty($_FILES['picture']['name'])) {
                $conf['upload_path']          = './uploads/user/';
                $conf['allowed_types']        = 'gif|jpg|png|JPG';
                //$conf['max_size']             = 100;
                //$conf['max_width']            = 1440;
                //$conf['max_height']           = 768;

                $new_name = time().'-'.$_FILES["picture"]['name'];
                $conf['file_name'] = $new_name;

                $this->load->library('upload', $conf);

                if (!$this->upload->do_upload('picture')){
                    $error ++;
                    $return['msg'] = 'Failed to upload picture';
                }else{
                    if($mode=='edit'){//delete file
                        $dt = $this->user_model->get_single_user($this->input->post('id'));
                        if(!empty($dt['picture'])){
                            $path = FCPATH.'uploads/user/'.$dt['picture'];
                            unlink($path);    
                        }
                    }

                    $this->resize_image(FCPATH.'uploads/user/'.$new_name);
                    if(isset($_SESSION['image']) && $is_edit_profile=='yes'){
                        $_SESSION['image'] = $new_name;
                    }
                }
            }            
            

            if($error==0){
                if($mode=='edit'){//update
                    $this->user_model->update_user($this->input->post('id'));
                    $return['status'] = 'success';
                    $return['msg'] = '<p><strong>Berhasil!!!</strong> ubah data user</p>';
                }else{
                    $this->user_model->set_user();  
                    $return['status'] = 'success';
                    $return['msg'] = '<p><strong>Berhasil!!!</strong> tambah user</p>';
                }    
            }
        }//form validation
        echo json_encode($return);
    }


    public function resize_image($source){
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        //$config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 100;
        $config['height']       = 100;

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }

    

    public function delete_user(){
        foreach ($_POST['ids'] as $key => $id) {
            $this->single_delete($id);
        }
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
                $this->single_delete($id);
                $return['msg'] = 'Success delete user';
                $return['status'] = 'success';
            }else if($action == 'trash' || $action == 'publish') {
                if($this->user_model->update_state_single($id, $action)){
                    $return['msg'] = 'Success update state';
                    $return['status'] = 'success';
                }
            }
        }        
        echo json_encode($return);
    }

    public function single_delete($id){
        $this->load->helper('file');
        $dt = $this->user_model->get_single_user($id);
        if(!empty($dt['picture'])){
            $path = FCPATH.'uploads/user/'.$dt['picture'];
            unlink($path);    
        }

       $this->user_model->delete_user($id);
    }

}