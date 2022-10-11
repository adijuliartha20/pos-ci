<?php
class General_option extends CI_Controller {
    private $title = 'General Option';
    private $app = 'general-option';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('option_model');

        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

    public function index($slug='publish'){
        $options = $this->list_options();
        foreach ($options as $key => $value) {
            $opt = $this->option_model->get_single_option($key);
            if(!empty($opt)){
                $data[$key] = $opt['option_value'];
            }
        }

        $data['title'] = $this->title;
        $data['state'] = $slug;
        $data['app'] = $this->app;


        add_footer_js(array('main-admin.js','admin-option.js'));
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/form', $data);
        $this->load->view('admin/templates/footer');
    }

    public function list_options(){
        $options = array(
                            'manual_code'=>'',
                            'manual_date'=>'',
                            'manual_date_value'=>'',
                            'type_discount'=>'',
                            'discount'=>'',
                            'fold'=>'',
                            'limit_month'=>'',
                            'limit_year'=>'',
                            'discount_per_item' =>''
                        );
                   
        return $options;
    }

    public function save(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $return = array();
        $return['status'] = 'error';

        $data = $this->list_options();

        foreach ($data as $key => $value) {
            $old = $this->option_model->get_single_option($key);
            if(empty($old)){
                $this->option_model->add_new($key,$_POST[$key]);
            }else{
                $this->option_model->update($key,$_POST[$key]);
            }
        }

        $return = array();
        $return['status'] = 'success';
        $return['msg'] = 'Success update Options';
        echo json_encode($return);
    }
}    
?>    