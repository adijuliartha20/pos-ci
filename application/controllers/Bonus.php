<?php
class Bonus extends CI_Controller {
    private $title = 'Bonus';
    private $app = 'bonus';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('bonus_model');

        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

    public function index($slug='publish'){
        if(isset($_POST['action-table']) && !empty($_POST['action-table']) ){
            if ($_POST['action-table']=='trash' || $_POST['action-table']=='untrash'){
                $this->bonus_model->update_state();    
            } else if($_POST['action-table']=='delete'){
                $this->delete();
            }
        }

        $temp = 'index';
        if($slug=='my-bonus'){
            $this->load->model('store_model');
            $temp = $slug;
            $data['months'] = $this->arr_month();
            $data['years'] = $this->arr_year();
            $data['store'] = $this->store_model->get_data('publish');
            add_footer_js(array('main-admin.js','admin-reports.js'));
        }else{
            add_footer_js(array('main-admin.js','admin-user.js'));
        }        

        $data['data'] = $this->bonus_model->get_data($slug);
        $data['title'] = $this->title;
        $data['state'] = $slug;
        $data['app'] = $this->app;


        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/'.$temp, $data);
        $this->load->view('admin/templates/footer');
    }


    private function arr_month(){
        $arr = array(
                        "1"=>'January',
                        "2"=>'Feburary',
                        "3"=>'March',
                        "4"=>'April',
                        "5"=>'May',
                        "6"=>'June',

                        "7"=>'July',
                        "8"=>'August',
                        "9"=>'September',
                        "10"=>'October',
                        "11"=>'November',
                        "12"=>'December',
                    );

        return $arr;
    }   


    private function arr_year(){
        $arr = array();
        for ($i=2005; $i <2300 ; $i++) { 
            $arr[$i] = $i;
        }

        return $arr;
    }



     public function create($id=''){
        $this->load->model('store_model');
        //$this->load->model('category_item_model');
        $data['title'] = 'Tambah '.$this->title;
        $data['action'] = '';
        $data['mode'] = 'create';
        $data['app'] = $this->app;

        if(!empty($id)){
            $data['data'] = $this->bonus_model->get_single_data($id);
            $data['mode'] = 'edit';
            $data['title'] = 'Edit '.$this->title;
        }
        $data['store'] = $this->store_model->get_data('publish');


        add_footer_js('admin-bonus.js');
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
                        array('field' => 'start','label' => 'Start','rules' => 'trim|required','errors'=>array('required'=>'Batas awal wajib diisi')),
                        array('field' => 'end','label' => 'End','rules' => 'trim|required|greater_than['.$this->input->post('start').']','errors'=> array('greater_than'=>'Batas akhir harus lebih besar dari batas awal')),    
                        array('field' => 'bonus','label' => 'Bonus','rules' => 'trim|required|greater_than[0]','errors'=>array('required'=>'Bonus wajib diisi','greater_than'=>'Bonus tidak boleh 0')),
                        array('field' => 'id_store','label' => 'Store','rules' => 'trim|required','errors'=>array('required'=>'Toko wajib diisi'))
                    );

        $this->form_validation->set_rules($config);
        //print_r($config);

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<p><strong>Error!!</strong></p>'.validation_errors();
        }else{
            if($mode=='edit'){//update
                $this->bonus_model->update($this->input->post('id'));
                $return['status'] = 'success';
                $return['msg'] = '<p><strong>Berhasil!!!</strong> ubah '.strtolower($this->title).'</p>';
            }else{
                $this->bonus_model->add_new();  
                $return['status'] = 'success';
                $return['msg'] = '<p><strong>Berhasil!!!</strong> tambah '.strtolower($this->title).'</p>';
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
                $this->single_delete($id);
                $return['msg'] = 'Success delete category item';
                $return['status'] = 'success';
            }else if($action == 'trash' || $action == 'publish') {
                if($this->bonus_model->update_state_single($id, $action)){
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
       $this->bonus_model->delete($id);
    }


    public function get_my_bonus(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('store_model');

        $return = array('status'=>'error');

        $config =   array(
                            array('field' => 'start-year','label' => 'Start Year','rules' => 'trim|required'),
                            array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required|greater_than_equal_to['.$this->input->post('start-year').']'),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required')
                        ); 
        

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start-year').'-1-1 00:00:00';
            $date = new DateTime($this->input->post('end-year').'-12-01');
            $date->modify('last day of this month');
            $end_date = $date->format('Y-m-d').' 23:59:59';
            
            $this->bonus_model->start_date = $start_date;
            $this->bonus_model->end_date = $end_date;
            $this->bonus_model->id_store = $this->input->post('id_store');


            $data = $this->bonus_model->data_my_sell();
            //print_r($data);
            if(!empty($data)){
                $this->load->library('pdfgenerator');
                $store = $this->store_model->get_single_data($this->input->post('id_store'));
                $temp = $this->temp_report($data,$store);
                $name = 'my-bonus-'.$_SESSION['id'].'-'.time();
                $link = $this->pdfgenerator->generate($temp, $this->style_report_monthly(), $name);


                $return['temp'] = '<p class="download-report"><a href="'.$link.'">Download PDF</a></p>'.$temp;
                $return['status'] = 'success';
            }
        }
        echo json_encode($return);
    }



    private function temp_report($data,$store){
        $temp = '<h1 class="title-report">'.$store['store'].'</h1>
                 <p class="address-report">'.$store['address'].'</p>

                 <div class="list-transaction">';
        $no = 1;
        foreach ($data as $key => $dt) {
            $temp .= '<div class="item-reports item-reports-'.$no.'">
                        <div class="info">
                            <p>Tahun: <span>'.$key.'</span></p>
                        </div>
                        <table class="table table-lightborder table-detail-transaction">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>Penjualan</th>
                                <th>Bonus</th>
                              </tr>
                            </thead>
                            <tbody>';

            $total = 0;
            $total_bonus = 0; 

            $n = 1;
            foreach ($dt as $key => $value) {
                $temp .= '<tr>
                                <td>'.$n.'</td>
                                <td>'.$key.'</td>
                                <td>'.number_format($value['total']).'</td>
                                <td>'.number_format($value['bonus']).'</td>
                            </tr>';
                $total = $total + $value['total'];
                $total_bonus = $total_bonus + $value['bonus'];     
                $n++;
            }

            $temp .=
                            '</tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th>'.number_format($total).'</th>
                                    <th>'.number_format($total_bonus).'</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                            ';
            $no++;
        }

        $temp .= '</div>';
        return $this->sanitize_output($temp);                
        
    }

    function sanitize_output($buffer) {
        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }

    private function style_report_monthly(){
        $style =    '<style>
                        body{font-family:Tahoma; font-size: 14px}
                        .title-report{text-align: center; line-height:120%; margin:0px 0px 10px 0px;padding:0px}
                        .address-report{text-align: center;margin:0px 0px 30px 0px; padding:0px}
                        .info{font-size:12px; padding:0px 0px 3px 0px;margin:0px;}
                        table {border-collapse: collapse;width:100%}                        
                        table th{text-align:left;}
                        table tbody td{border-top: 1px solid rgba(83, 101, 140, 0.08);padding:3px 8px 3px 0;}
                        table tbody td{text-align:left;}
                        table tfoot tr th {border-top: solid 1px rgba(0, 0, 0, 0.1) !important; font-size: 16px;font-weight: 500;}
                        
                        table thead tr td:first-child,
                        table tbody tr td:first-child,
                        table tfoot tr td:first-child {width: 20px;}
                    </style>';

        return $style;
    }

}