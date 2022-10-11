<?php
class Events extends CI_Controller {
    private $title = 'Hari Penting';
    private $app = 'events';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('events_model');

        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

    public function index($slug='publish'){
        if(isset($_POST['action-table']) && !empty($_POST['action-table']) ){
            if ($_POST['action-table']=='trash' || $_POST['action-table']=='untrash'){
                $this->events_model->update_state();    
            } else if($_POST['action-table']=='delete'){
                $this->delete();
            }
        }

        $data['data'] = $this->events_model->get_data($slug);
        $data['title'] = $this->title;
        $data['state'] = $slug;
        $data['app'] = $this->app;


        add_footer_js(array('main-admin.js','admin-user.js'));
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/index', $data);
        $this->load->view('admin/templates/footer');
    }


     public function create($id=''){
        $data['title'] = 'Tambah '.$this->title;
        $data['action'] = '';
        $data['mode'] = 'create';
        $data['app'] = $this->app;
        $data['date'] = '';

        if(!empty($id)){
            $data['title'] = 'Ubah '.$this->title;
            $dt = $this->events_model->get_single_data($id);
            $data['data'] = $dt;
            $data['date'] = date('m/d/Y', strtotime($dt['date']));
            $data['mode'] = 'edit';
        }

        add_css('simple-line-icons.css');
        add_footer_js('admin-events.js');
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
                        array('field' => 'event','label' => 'Event','rules' => 'trim|required','errors' => array('required' => 'Event wajib diisi'))
                        //array('field' => 'date','label' => 'Date','rules' => 'trim|required','errors' => array('required' => 'Date wajib diisi'))
                    );   
        
        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        }else{
            $return['msg'] = '<p><strong>Error!!</strong></p>';

            $event = $this->input->post('event');
            $dates = $this->input->post('date');
            //validate tanggal sama
            $count_date = array_count_values($dates);
            foreach ($count_date as $key => $value) {
                if($value>1){
                    $return['msg'] .= '<p>Tanggal '.date('d F Y',strtotime($key)).' duplikat</p>';
                    $error++;
                }
            }

            if($error==0){
                if($mode=='edit'){//update
                    //validate with other date
                    $date = $dates[0];
                    $id_event = $this->input->post('id');
                    $dt = $this->events_model->get_data_by_name_date($event, date('Y-m-d',strtotime($date)).' 00:00:00', $id_event);
                    //print_r($dt);
                    if(!empty($dt)){
                        $return['msg'] .= '<p>Tanggal '.date('d F Y',strtotime($date)).' sudah ada</p>';
                        $error++;
                    }else{
                        //echo 'update';
                        $this->events_model->update($id_event, $date, $event);
                        $return['status'] = 'success';
                        $return['msg'] = '<p><strong>Berhasil!!!</strong> ubah '.strtolower($this->title).'</p>';
                    }
                    

                    /*
                    */
                }else{
                    //validate semua tanggal
                    foreach ($dates as $key => $date) {
                        $date = date('Y-m-d',strtotime($date)).' 00:00:00';
                        $dt = $this->events_model->get_data_by_name_date($event, $date);
                        if(!empty($dt)){
                            $return['msg'] .= '<p>Tanggal '.date('d F Y',strtotime($dt[0]['date'])).' sudah ada</p>';
                            $error++;
                        }
                    }

                    if($error==0){
                        foreach ($dates as $key => $date) {//save single
                            $date = date('Y-m-d', strtotime($date));
                            if(!$this->events_model->single_add($event, $date)){
                                $error++;
                            }
                        }

                        if($error==0){
                            $return['status'] = 'success';
                            $return['msg'] = '<p><strong>Berhasil!!!</strong> tambah '.$event.'</p>';
                        }
                    }
                } 
            }


            /*if($mode=='edit'){//update
                $this->events_model->update($this->input->post('id'));
                $return['status'] = 'success';
                $return['msg'] = '<p><strong>Berhasil!!!</strong> ubah '.strtolower($this->title).'</p>';
            }else{
                
                
                
                
                //validate semua tanggal
                foreach ($dates as $key => $date) {
                    $date = date('Y-m-d',strtotime($date)).' 00:00:00';
                    $dt = $this->events_model->get_data_by_name_date($event, $date);
                    if(!empty($dt)){
                        $return['msg'] .= '<p>Tanggal '.date('d F Y',strtotime($dt[0]['date'])).' sudah ada</p>';
                        $error++;
                    }
                }

                if($error==0){
                    foreach ($dates as $key => $date) {//save single
                        $date = date('Y-m-d', strtotime($date));
                        if(!$this->events_model->single_add($event, $date)){
                            $error++;
                        }
                    }

                    if($error==0){
                        $return['status'] = 'success';
                        $return['msg'] = '<p><strong>Berhasil!!!</strong> tambah '.$event.'</p>';
                    }
                }
            }  */  
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
                $this->single_delete($id);
                $return['msg'] = 'Success delete category item';
                $return['status'] = 'success';
            }else if($action == 'trash' || $action == 'publish') {
                if($this->events_model->update_state_single($id, $action)){
                    $return['msg'] = 'Success update state';
                    $return['status'] = 'success';
                }
            }
        }        
        echo json_encode($return);
    }

    public function delete(){
        foreach ($_POST['ids'] as $key => $id) {
            $this->single_delete($id);
        }
    }

    public function single_delete($id){
       $this->events_model->delete($id);
    }

}