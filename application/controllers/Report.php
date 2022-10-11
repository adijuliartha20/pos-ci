<?php
class Report extends CI_Controller {
    private $title = 'Report';
    private $app = 'report';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('store_model');
        $this->load->model('report_model');
        $this->load->library('temp_report');

        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

    public function index($type=''){
        $data = array();

        $data['title'] = $this->set_title($type);
        $data['type'] = ucfirst($type);
        


        $data['app'] = $this->app;
        $data['store'] = $this->store_model->get_data('publish');

        $temp = 'index';
        if($type!='' && $type!='daily') $temp = $type;

        $data['months'] = $this->arr_month();
        $data['years'] = $this->arr_year();


        add_footer_js(array('main-admin.js','admin-reports.js'));
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/'.$this->app.'/'.$temp, $data);
        $this->load->view('admin/templates/footer');
    }


    public function set_title($type){
        $title = '';

        if($type=='daily') $title='Laporan Penjualan Harian';
        if($type=='monthly') $title='Laporan Penjualan Bulanan';
        if($type=='yearly') $title='Laporan Penjualan Tahunan';
        if($type=='buy') $title='Laporan Belanja Barang';
        if($type=='item-record') $title='Laporan Rekam Barang';
        if($type=='bestsellers') $title='Laporan Barang Terlaris';
        if($type=='check-stock') $title='Laporan Cek Stok Barang';
        if($type=='not-check-stock') $title='Laporan Barang Belum Dicek';
        if($type=='sales-not-paid') $title='Laporan Penjualan Belum Lunas';
        if($type=='package-status') $title='Laporan Status Paket';

        return $title;
    }

    private function arr_month(){
        $arr = array(
                        "1"=>'Januari',
                        "2"=>'Feburari',
                        "3"=>'Maret',
                        "4"=>'April',
                        "5"=>'Mei',
                        "6"=>'Juni',

                        "7"=>'Juli',
                        "8"=>'Augustus',
                        "9"=>'September',
                        "10"=>'Oktober',
                        "11"=>'November',
                        "12"=>'Desember',
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



    public function get_daily_report(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');

        $return = array('status'=>'error');
        $config =   array(
                            array('field' => 'start','label' => 'Start date','rules' => 'trim|required', 'errors'=> array('required' => 'Mulai wajib diisi')),
                            array('field' => 'end','label' => 'End date','rules' => 'trim|required', 'errors'=> array('required' => 'Sampai wajib diisi')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        ); 
        

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start').' 00:00:00';
            $end_date = $this->input->post('end').' 23:59:59';

            if(strtotime($start_date) > strtotime($end_date)){
                $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Hari Mulai tidak boleh lebih besar dari Sampai</p>';
            }else{
                $data = $this->report_model->data_daily($this->input->post('start'), $this->input->post('end'), $this->input->post('id_store') );
                
                if(!empty($data)){
                    //print here
                    $store = $this->store_model->get_single_data($this->input->post('id_store'));
                    //print_r($store);
                    //print_r($data);
                    //$temp = $this->temp_daily_report($data,$store);
                    $temp = $this->temp_report->daily($data,$store);
                    $name = 'daily-'.time();


                    $arr_code = array(
                                        'start'=> $this->input->post('start'), 
                                        'end'=> $this->input->post('end'),
                                        'id_store'=> $this->input->post('id_store')
                                    );
                    $arr_code = base64_encode(json_encode($arr_code));
                    $link = site_url().'locoadmin/generate-report/daily/'.$arr_code;
                    $return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Tidak Ada Transaksi</p>';
                }   
            }


            
        }
        echo json_encode($return);
                
    }

    public function get_status_package_report(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');

        $return = array('status'=>'error');

        $config =   array(
                            array('field' => 'start-month','label' => 'Start Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Mulai wajib diisi')),
                            array('field' => 'start-year','label' => 'Start Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Mulai diisi')),
                            array('field' => 'end-month','label' => 'End Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Sampai wajib diisi')),
                            array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Sampai diisi')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        );        
        $this->form_validation->set_rules($config);       

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start-year').'-'.$this->input->post('start-month').'-1 00:00:00';
            $date = new DateTime($this->input->post('end-year').'-'.$this->input->post('end-month').'-01');
            $date->modify('last day of this month');
            $end_date = $date->format('Y-m-d').' 23:59:59';

            if(strtotime($start_date) > strtotime($end_date)){
                $return['msg'] = '<p>Nilai mulai tidak boleh lebih besar dari nilai sampai</p>';
            }else{
                $return['msg'] = 'woii';

                $data = $this->report_model->data_daily($start_date, $end_date, $this->input->post('id_store'),'all' );
                
                if(!empty($data)){
                    //print here
                    $store = $this->store_model->get_single_data($this->input->post('id_store'));
                    $temp = $this->temp_report->daily($data,$store,'show-update-status');
                    $name = 'daily-'.time();


                    $arr_code = array(
                                        'start'=> $start_date, 
                                        'end'=> $end_date,
                                        'id_store'=> $this->input->post('id_store')
                                    );
                    $arr_code = base64_encode(json_encode($arr_code));
                    $link = site_url().'locoadmin/generate-report/daily/'.$arr_code;
                    $return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Tidak Ada Transaksi</p>';
                }
            }            
        }
        echo json_encode($return);
    }





    public function get_sales_not_paid(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');

        $return = array('status'=>'error');

        $config =   array(
                            array('field' => 'start-month','label' => 'Start Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Mulai wajib diisi')),
                            array('field' => 'start-year','label' => 'Start Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Mulai diisi')),
                            array('field' => 'end-month','label' => 'End Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Sampai wajib diisi')),
                            array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Sampai diisi')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        );        
        $this->form_validation->set_rules($config);       

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start-year').'-'.$this->input->post('start-month').'-1 00:00:00';
            $date = new DateTime($this->input->post('end-year').'-'.$this->input->post('end-month').'-01');
            $date->modify('last day of this month');
            $end_date = $date->format('Y-m-d').' 23:59:59';

            if(strtotime($start_date) > strtotime($end_date)){
                $return['msg'] = '<p>Nilai mulai tidak boleh lebih besar dari nilai sampai</p>';
            }else{
                $return['msg'] = 'woii';

                $data = $this->report_model->data_daily($start_date, $end_date, $this->input->post('id_store'),'not-paid' );
                
                if(!empty($data)){
                    //print here
                    $store = $this->store_model->get_single_data($this->input->post('id_store'));
                    $temp = $this->temp_report->daily($data,$store,'show-update-payment');
                    $name = 'daily-'.time();


                    $arr_code = array(
                                        'start'=> $start_date, 
                                        'end'=> $end_date,
                                        'id_store'=> $this->input->post('id_store')
                                    );
                    $arr_code = base64_encode(json_encode($arr_code));
                    $link = site_url().'locoadmin/generate-report/daily/'.$arr_code;
                    $return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Tidak Ada Transaksi</p>';
                }
            }            
        }
        echo json_encode($return);
    }


    public function get_monthly_report(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');

        $return = array('status'=>'error');

        $config =   array(
                            array('field' => 'start-month','label' => 'Start Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Mulai wajib diisi')),
                            array('field' => 'start-year','label' => 'Start Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Mulai diisi')),
                            array('field' => 'end-month','label' => 'End Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Sampai wajib diisi')),
                            array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Sampai diisi')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        ); 
        

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start-year').'-'.$this->input->post('start-month').'-1 00:00:00';
            $date = new DateTime($this->input->post('end-year').'-'.$this->input->post('end-month').'-01');
            $date->modify('last day of this month');
            $end_date = $date->format('Y-m-d').' 23:59:59';

            if(strtotime($start_date) > strtotime($end_date)){
                //$return['msg'] = '<p>End month must by greater than start month</p>';
                $return['msg'] = '<p>Nilai mulai tidak boleh lebih besar dari nilai sampai</p>';
            }else{
                $this->report_model->start_date = $start_date;
                $this->report_model->end_date = $end_date;
                $this->report_model->id_store = $this->input->post('id_store');
                
                $data = $this->report_model->data_monthly();
                //print_r($data);
                if(!empty($data)){
                    $arr_code = array(
                                        'start'=> $start_date, 
                                        'end'=> $end_date,
                                        'id_store'=> $this->input->post('id_store')
                                    );
                    $arr_code = base64_encode(json_encode($arr_code));
                    $link = site_url().'locoadmin/generate-report/monthly/'.$arr_code;

                    $store = $this->store_model->get_single_data($this->input->post('id_store'));
                    $temp = $this->temp_report->monthly($data,$store);

                    $return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Tidak Ada Transaksi</p>';
                }
            }            
        }
        echo json_encode($return);
                
    }

    





    public function get_yearly_report(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');

        $return = array('status'=>'error');

        $config =   array(
                            array('field' => 'start-year','label' => 'Start Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Mulai wajib diisi')),
                            array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required|greater_than_equal_to['.$this->input->post('start-year').']'
                                , 'errors'=> array('required' => 'Tahun Sampai diisi', 'greater_than_equal_to' => 'Tahun sampai harus lebih besar atau sama dari tahun mulai')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        ); 
        

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start-year').'-1-1 00:00:00';
            $date = new DateTime($this->input->post('end-year').'-12-01');
            $date->modify('last day of this month');
            $end_date = $date->format('Y-m-d').' 23:59:59';
            
            $this->report_model->start_date = $start_date;
            $this->report_model->end_date = $end_date;
            $this->report_model->id_store = $this->input->post('id_store');


            $data = $this->report_model->data_yearly();
            if(!empty($data)){
                $arr_code = array(
                                    'start'=> $start_date, 
                                    'end'=> $end_date,
                                    'id_store'=> $this->input->post('id_store')
                                );
                $arr_code = base64_encode(json_encode($arr_code));
                $link = site_url().'locoadmin/generate-report/yearly/'.$arr_code;


                $store = $this->store_model->get_single_data($this->input->post('id_store'));
                $temp = $this->temp_report->yearly($data,$store);

                $return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                $return['status'] = 'success';
            }else{
                $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Tidak Ada Transaksi</p>';
            }
        }
        echo json_encode($return);
                
    }


    



    public function get_item_record(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');

        $return = array('status'=>'error');



        $config =   array(
                            array('field' => 'start-month','label' => 'Start Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Mulai wajib diisi')),
                            array('field' => 'start-year','label' => 'Start Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Mulai diisi')),
                            array('field' => 'end-month','label' => 'End Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Sampai wajib diisi')),
                            array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Sampai diisi')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        ); 
        

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start-year').'-'.$this->input->post('start-month').'-1 00:00:00';
            $date = new DateTime($this->input->post('end-year').'-'.$this->input->post('end-month').'-01');
            $date->modify('last day of this month');
            $end_date = $date->format('Y-m-d').' 23:59:59';

            if(strtotime($start_date) > strtotime($end_date)){
                $return['msg'] = '<p>End month must by greater than start month</p>';
            }else{
                $this->report_model->start_date = $start_date;
                $this->report_model->end_date = $end_date;
                $this->report_model->id_store = $this->input->post('id_store');
                $data = $this->report_model->data_item_record();
               
                if(!empty($data)){
                    $arr_code = array(
                                    'start'=> $start_date, 
                                    'end'=> $end_date,
                                    'id_store'=> $this->input->post('id_store')
                                );
                    $arr_code = base64_encode(json_encode($arr_code));
                    $link = site_url().'locoadmin/generate-report/record-item/'.$arr_code;

                    $store = $this->store_model->get_single_data($this->input->post('id_store'));
                    $temp = $this->temp_report->item_record($data,$store,$start_date,$end_date);

                    $return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Tidak Ada Perubahan Data Barang</p>';
                }
            }   
        }
        echo json_encode($return);
    }


    




    public function get_bestsellers_report(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('items_model');
        $this->load->model('events_model');

        $return = array('status'=>'error');
        //array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required|greater_than_equal_to['.$this->input->post('start-year').']'),
        $config =   array(
                            array('field' => 'start','label' => 'Start date','rules' => 'trim|required', 'errors'=> array('required' => 'Mulai wajib diisi')),
                            array('field' => 'end','label' => 'End date','rules' => 'trim|required', 'errors'=> array('required' => 'Sampai wajib diisi')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        ); 
        

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start = $this->input->post('start');
            $end = $this->input->post('end');

            $start_date = $start.' 00:00:00';
            $end_date = $end.' 23:59:59';

            if(strtotime($start_date) > strtotime($end_date)){
                $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>End date must by greater than start date</p>';
            }else{
                //print_r($_POST);
                $this->report_model->start_date = $start;
                $this->report_model->end_date = $end;
                $this->report_model->id_store = $this->input->post('id_store');                
                $data = $this->report_model->data_bestseller();                
                if(!empty($data)){
                    $arr_code = array(
                                        'start'=> $start, 
                                        'end'=> $end,
                                        'id_store'=> $this->input->post('id_store')
                                    );
                    $arr_code = base64_encode(json_encode($arr_code));
                    $link = site_url().'locoadmin/generate-report/bestseller/'.$arr_code;
                    $store = $this->store_model->get_single_data($this->input->post('id_store'));                   
                    

                    $dtes = date('Y-m-d',strtotime($start)).' 00:00:00';
                    $dtee = date('Y-m-d',strtotime($end)).' 23:59:59';
                    $events = $this->events_model->get_data_by_range_date($dtes, $dtee);
                    //print_r($event);


                    $temp = $this->temp_report->bestseller($data,$store,$start,$end,$events);                   
                    $return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Tidak Ada Data Barang</p>';
                } 
            }


            
        }
        echo json_encode($return);
                
    }



    






    public function get_buy_items_report(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('buy_item_model');

        $return = array('status'=>'error');

        $config =   array(
                            array('field' => 'start-month','label' => 'Start Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Mulai wajib diisi')),
                            array('field' => 'start-year','label' => 'Start Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Mulai wajib diisi')),
                            array('field' => 'end-month','label' => 'End Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Sampai wajib diisi')),
                            array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Sampai wajib diisi')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        ); 
        

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start-year').'-'.$this->input->post('start-month').'-1 00:00:00';
            $date = new DateTime($this->input->post('end-year').'-'.$this->input->post('end-month').'-01');
            $date->modify('last day of this month');
            $end_date = $date->format('Y-m-d').' 23:59:59';

            if(strtotime($start_date) > strtotime($end_date)){
                $return['msg'] = '<p>Sampai harus lebih besar atau sama dengan Mulai</p>';
            }else{
                $this->report_model->start_date = $start_date;
                $this->report_model->end_date = $end_date;
                $this->report_model->id_store = $this->input->post('id_store');
                
                $data = $this->report_model->data_buy_items();               
                
                if(!empty($data)){
                    $arr_code = array(
                                    'start'=> $start_date, 
                                    'end'=> $end_date,
                                    'id_store'=> $this->input->post('id_store')
                                );
                    $arr_code = base64_encode(json_encode($arr_code));
                    $link = site_url().'locoadmin/generate-report/buy-item/'.$arr_code;

                    $store = $this->store_model->get_single_data($this->input->post('id_store'));
                    $temp = $this->temp_report->buy_item($data,$store);
                    //$link = $this->pdfgenerator->generate($temp, $this->style_report_daily(), $name);

                    $return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Tidak Ada Belanja Barang</p>';
                }
            }            
        }
        echo json_encode($return);
                
    }


    public function get_check_stock_report(){
        $this->load->helper('form');
        $this->load->library('form_validation');

        $return = array('status'=>'error');

        $config =   array(
                            array('field' => 'start-month','label' => 'Start Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Mulai wajib diisi')),
                            array('field' => 'start-year','label' => 'Start Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Mulai wajib diisi')),
                            array('field' => 'end-month','label' => 'End Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Sampai wajib diisi')),
                            array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Sampai wajib diisi')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        ); 
        

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start-year').'-'.$this->input->post('start-month').'-1 00:00:00';
            $date = new DateTime($this->input->post('end-year').'-'.$this->input->post('end-month').'-01');
            $date->modify('last day of this month');
            $end_date = $date->format('Y-m-d').' 23:59:59';

            if(strtotime($start_date) > strtotime($end_date)){
                $return['msg'] = '<p>Sampai harus lebih besar atau sama dengan Mulai</p>';
            }else{
                $this->report_model->start_date = $start_date;
                $this->report_model->end_date = $end_date;
                $this->report_model->id_store = $this->input->post('id_store');
                
                $data = $this->report_model->data_check_stock();
                //print_r($data);
                               
                
                if(!empty($data)){
                    $arr_code = array(
                                    'start'=> $start_date, 
                                    'end'=> $end_date,
                                    'id_store'=> $this->input->post('id_store')
                                );
                    $arr_code = base64_encode(json_encode($arr_code));
                    $link = site_url().'locoadmin/generate-report/check-stock/'.$arr_code;

                    $store = $this->store_model->get_single_data($this->input->post('id_store'));
                    $temp = $this->temp_report->check_stock($data,$store);
                    //$link = $this->pdfgenerator->generate($temp, $this->style_report_daily(), $name);

                    $return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Tidak Ada Belanja Barang</p>';
                }
            }            
        }
        echo json_encode($return);
                
    }


    public function get_not_check_stock_report(){
        $this->load->helper('form');
        $this->load->library('form_validation');

        $return = array('status'=>'error');

        $config =   array(
                            array('field' => 'start-month','label' => 'Start Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Mulai wajib diisi')),
                            array('field' => 'start-year','label' => 'Start Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Mulai wajib diisi')),
                            array('field' => 'end-month','label' => 'End Month','rules' => 'trim|required', 'errors'=> array('required' => 'Bulan Sampai wajib diisi')),
                            array('field' => 'end-year','label' => 'End Year','rules' => 'trim|required', 'errors'=> array('required' => 'Tahun Sampai wajib diisi')),
                            array('field' => 'id_store','label' => 'Store','rules' => 'trim|required', 'errors'=> array('required' => 'Toko wajib diisi'))
                        ); 
        

        $this->form_validation->set_rules($config);
        

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $start_date = $this->input->post('start-year').'-'.$this->input->post('start-month').'-1 00:00:00';
            $date = new DateTime($this->input->post('end-year').'-'.$this->input->post('end-month').'-01');
            $date->modify('last day of this month');
            $end_date = $date->format('Y-m-d').' 23:59:59';

            if(strtotime($start_date) > strtotime($end_date)){
                $return['msg'] = '<p>Sampai harus lebih besar atau sama dengan Mulai</p>';
            }else{
                $this->report_model->start_date = $start_date;
                $this->report_model->end_date = $end_date;
                $this->report_model->id_store = $this->input->post('id_store');
                               
                $data = $this->report_model->data_not_check_stock();
                //print_r($data);
                               
            
                if(!empty($data)){
                    $arr_code = array(
                                    'start'=> $start_date, 
                                    'end'=> $end_date,
                                    'id_store'=> $this->input->post('id_store')
                                );
                    $arr_code = base64_encode(json_encode($arr_code));
                    $link = site_url().'locoadmin/generate-report/not-check-stock/'.$arr_code;

                    $store = $this->store_model->get_single_data($this->input->post('id_store'));
                    $temp = $this->temp_report->not_check_stock($data,$store, $start_date, $end_date);
                    //$link = $this->pdfgenerator->generate($temp, $this->style_report_daily(), $name);

                    //$return['temp'] = '<p class="download-report"><a href="'.$link.'" target="_blank">Download PDF</a></p>'.$temp;
                    $return['temp'] = $temp;
                    $return['status'] = 'success';
                }else{
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4><p>Semua Barang Sudah Dicek</p>';
                }
            }            
        }
        echo json_encode($return);
                
    }


    public function change_status_package(){
        $this->load->helper('form');
        $this->load->library('form_validation');

        $return = array('status'=>'error');
        $config =   array(
                            array('field' => 'id','label' => 'ID Transaksi','rules' => 'trim|required', 'errors'=> array('required' => 'ID Transaksi wajib diisi')),
                            array('field' => 'status','label' => 'Status','rules' => 'trim|required', 'errors'=> array('required' => 'Status wajib diisi'))
                        );         
        $this->form_validation->set_rules($config);       

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $date = $this->option_model->get_current_date('datetime');
            //echo "$id - $status - $date";

            $this->load->model('transaction_model');
            if($this->transaction_model->save_status($id, $status, $date)){//record change status
                //change status package
                if($this->transaction_model->update_status_package($id,$status)){
                    $data = $this->report_model->get_list_transaction_status($id);
                    $return['status'] = 'success';
                    $return['list'] = $data;
                }
            }
        }
        echo json_encode($return);
    }

    public function save_payment(){
        $this->load->helper('form');
        $this->load->library('form_validation');

        $return = array('status'=>'error');

        $config =   array(
                            array('field' => 'id','label' => 'ID Transaksi','rules' => 'trim|required', 'errors'=> array('required' => 'ID Transaksi wajib diisi')),
                            array('field' => 'payment','label' => 'Pembayaran','rules' => 'trim|required', 'errors'=> array('required' => 'Pembayaran wajib diisi')),
                            array('field' => 'payment_type','label' => 'Tipe Pembayaran','rules' => 'trim|required', 'errors'=> array('required' => 'Tipe Pembayaran wajib diisi'))
                        );         
        $this->form_validation->set_rules($config);       

        if ($this->form_validation->run() == FALSE){
            $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
        }else{
            $id = $this->input->post('id');
            $payment = $this->input->post('payment');
            $payment_type = $this->input->post('payment_type');

            //get transaction
            $this->load->model('transaction_model');
            $dtt = $this->transaction_model->get_transaction($id);
            $total = $dtt[0]['total'];

            $dtp = $this->transaction_model->get_payments($id);
            $remaining_payment = $total;
            foreach ($dtp as $key => $pay) {
                $remaining_payment = $remaining_payment - $pay['payment'];
            }

            if($remaining_payment <=0){
                 $return['status'] = 'transaction-is-done';
                 $return['msg'] = 'Transaksi sudah lunas';
            }else{
                $last_remaining_payment = $remaining_payment - $payment;
                //save payment
                $date = $this->option_model->get_current_date('datetime');
                $this->transaction_model->save_payemnts($date, $payment, $payment_type, $id);

                //update status transaction
                $status = 1;
                if($last_remaining_payment <=0){//jika sudah lunas //update status transaksi dan tanggal pembayaran
                    $status = 2;                
                }
                $this->transaction_model->update_transaction($id,$date,$status);           
                //get list payment
                $dtp_new = $this->transaction_model->get_payments($id);
                $return['list_payment'] = $dtp_new;
                $return['status'] = 'success';
                $return['status_payment'] = ($status==2? 'done':'not-done');
                $return['remaining_payment'] = ($status==2? 0:$last_remaining_payment);
            }
            //print_r($dtp_new);
        }
        echo json_encode($return);
    }


    function temp_list_payment(){

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

}