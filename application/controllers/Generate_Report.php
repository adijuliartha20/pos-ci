<?php
class Generate_Report extends CI_Controller {
    private $title = '';
    private $app = 'generate_report';

    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->helper('function');
        $this->load->library('session');
        $this->load->model('store_model');
        $this->load->model('report_model');
        $this->load->library('temp_report');
        $this->load->library('pdfgenerator');


        if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
    }

    public function index($type=''){

    }


    public function generate_daily_report($data=''){
        if(!empty($data)){
           
            $data = json_decode(base64_decode($data));

            if(!empty($data)){
                
                $report = $this->report_model->data_daily($data->start, $data->end, $data->id_store);
                $store = $this->store_model->get_single_data($data->id_store);
                $temp = $this->temp_report->daily($report,$store);
                $style = $this->temp_report->style_report_daily();
                $name = 'daily-'.time();
                $this->pdfgenerator->generate_view($temp, $style, $name);
            }
        }else{
            redirect('locoadmin'); 
        }
    }



    public function generate_monthly_report($data=''){
        if(!empty($data)){
            $data = json_decode(base64_decode($data));

            if(!empty($data)){                
                $this->report_model->start_date = $data->start;
                $this->report_model->end_date = $data->end;
                $this->report_model->id_store = $data->id_store;


                $report = $this->report_model->data_monthly();
                $store = $this->store_model->get_single_data($data->id_store);
                $temp = $this->temp_report->monthly($report,$store);
                $style = $this->temp_report->style_report_monthly();
                $name = 'monthly-'.time();
                $this->pdfgenerator->generate_view($temp, $style, $name);
                
            }
        }else{
            redirect('locoadmin'); 
        }
    }


    public function generate_yearly_report($data=''){
        if(!empty($data)){
            $data = json_decode(base64_decode($data));

            if(!empty($data)){
                //print_r($data);/*
                $this->report_model->start_date = $data->start;
                $this->report_model->end_date = $data->end;
                $this->report_model->id_store = $data->id_store;


                $report = $this->report_model->data_yearly();
                
                $store = $this->store_model->get_single_data($data->id_store);
                $temp = $this->temp_report->yearly($report,$store);
                $style = $this->temp_report->style_report_monthly();
                $name = 'yearly-'.time();
                $this->pdfgenerator->generate_view($temp, $style, $name);                
            }
        }else{
            redirect('locoadmin'); 
        }
    }

    public function buy_item($data=''){
        if(!empty($data)){
            $data = json_decode(base64_decode($data));

            if(!empty($data)){
                $this->report_model->start_date = $data->start;
                $this->report_model->end_date = $data->end;
                $this->report_model->id_store = $data->id_store;
                $report = $this->report_model->data_buy_items();
                
                $store = $this->store_model->get_single_data($data->id_store);
                $temp = $this->temp_report->buy_item($report,$store);
                $style = $this->temp_report->style_report_monthly();
                $name = 'buy-item-'.time();
                $this->pdfgenerator->generate_view($temp, $style, $name); 
            }
        }else{
            redirect('locoadmin'); 
        }
    }


    public function check_stock($data=''){
        if(!empty($data)){
            $data = json_decode(base64_decode($data));

            if(!empty($data)){
                $this->report_model->start_date = $data->start;
                $this->report_model->end_date = $data->end;
                $this->report_model->id_store = $data->id_store;
                $report = $this->report_model->data_check_stock();
                
                $store = $this->store_model->get_single_data($data->id_store);
                $temp = $this->temp_report->check_stock($report,$store);
                $style = $this->temp_report->style_report_monthly();
                $name = 'check-stock-item-'.time();
                $this->pdfgenerator->generate_view($temp, $style, $name, TRUE, 'A4', 'landscape'); 
            }
        }else{
            redirect('locoadmin'); 
        }
    }


    public function not_check_stock($data=''){
        if(!empty($data)){
            $data = json_decode(base64_decode($data));

            if(!empty($data)){
                $this->report_model->start_date = $data->start;
                $this->report_model->end_date = $data->end;
                $this->report_model->id_store = $data->id_store;
                $report = $this->report_model->data_not_check_stock();
                
                //print_r($report);
                $store = $this->store_model->get_single_data($data->id_store);
                $temp = $this->temp_report->not_check_stock($report,$store);
                $style = $this->temp_report->style_report_monthly();
                $name = 'not-check-stock-item-'.time();
                $this->pdfgenerator->generate_view($temp, $style, $name, TRUE, 'A4', 'landscape');
            }
        }else{
            redirect('locoadmin'); 
        }
    }


    public function record_item($data=''){
        if(!empty($data)){
            $data = json_decode(base64_decode($data));

            if(!empty($data)){
                $this->report_model->start_date = $data->start;
                $this->report_model->end_date = $data->end;
                $this->report_model->id_store = $data->id_store;
                $report = $this->report_model->data_item_record();//print_r($report);
                    
                $store = $this->store_model->get_single_data($data->id_store);
                $temp = $this->temp_report->item_record($report,$store,$data->start,$data->end);
                //echo $temp;
                $style = $this->temp_report->style_report_item();//echo $style;
                $name = 'item-record-'.time();
                $this->pdfgenerator->generate_view($temp, $style, $name, TRUE, 'A4', 'landscape');
            }
        }else{
            redirect('locoadmin'); 
        }
    }

    public function bestseller($data=''){
        if(!empty($data)){
            $data = json_decode(base64_decode($data));

            if(!empty($data)){
                $this->load->model('events_model');
                $this->report_model->start_date = $data->start;
                $this->report_model->end_date = $data->end;
                $this->report_model->id_store = $data->id_store;
                $report = $this->report_model->data_bestseller();
                    
                $store = $this->store_model->get_single_data($data->id_store);
                $dtes = date('Y-m-d',strtotime($data->start)).' 00:00:00';
                $dtee = date('Y-m-d',strtotime($data->end)).' 23:59:59';
                $events = $this->events_model->get_data_by_range_date($dtes, $dtee);


                $temp = $this->temp_report->bestseller($report,$store,$data->start,$data->end, $events);
                //echo $temp;
                $style = $this->temp_report->style_report_monthly();//echo $style;
                $name = 'bestseller-'.time();
                $this->pdfgenerator->generate_view($temp, $style, $name);
            }
        }else{
            redirect('locoadmin'); 
        }
    }


}    