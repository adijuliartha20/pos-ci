<?php
class Dashboard extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->helper('function');

                if(!$user = $this->session->userdata('logged')) redirect('locoadmin'); 
        }

        public function index()
        {
                $this->load->model('store_model');
                $data['title'] = 'Dashboard';

                $data['months'] = $this->arr_month();
                $data['years'] = $this->arr_year();
                $data['store'] = $this->store_model->get_data('publish');

                add_footer_js(array('admin-dashboard.js'));
                $this->load->view('admin/templates/header', $data);
                $this->load->view('admin/templates/sidebar', $data);
                $this->load->view('admin/dashboard/index', $data);
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


        public function get_monthly_sales(){
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->load->model('transaction_model');
                $this->load->model('option_model');

                $return = array('status'=>'error');

                $config =   array(
                                    array('field' => 'month','label' => 'Month','rules' => 'trim|required'),
                                    array('field' => 'year','label' => 'Year','rules' => 'trim|required'),
                                    array('field' => 'id_store','label' => 'Store','rules' => 'trim|required')
                                ); 
                

                $this->form_validation->set_rules($config);
                //$return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();

                if ($this->form_validation->run() == FALSE){
                    $return['msg'] = '<h4 class="alert-heading">Error!!</h4>'.validation_errors();
                }else{
                        $start_date = $this->input->post('year').'-'.$this->input->post('month').'-1 00:00:00';
                        $date = new DateTime($this->input->post('year').'-'.$this->input->post('month').'-01');
                        $date->modify('last day of this month');
                        $end_date = $date->format('Y-m-d').' 23:59:59';
                    
                        $this->transaction_model->start_date = $start_date;
                        $this->transaction_model->end_date = $end_date;
                        $this->transaction_model->id_store = $this->input->post('id_store');
                        
                        $data = $this->transaction_model->get_monthly_statistic();
                        if(!empty($data)){
                                $date = array();
                                $total = array();
                                $total_profit = array();


                                foreach ($data as $key => $dt) {
                                        array_push($date, $key);
                                        array_push($total, $dt['total']);
                                        array_push($total_profit, $dt['total_profit']);
                                }
                                $return['div'] = $this->input->post('div');
                                $return['date'] = $date;
                                $return['total'] = $total;
                                $return['total_profit'] = $total_profit;
                                $return['status'] = 'success';
                                $return['access'] = $_SESSION['access'];
                                
                                $opt = $this->option_model->get_single_option('limit_month');
                                $return['limit'] = $opt['option_value'];
                        }
                                
                }
                echo json_encode($return);
             
        }


        public function get_yearly_sales(){
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->load->model('transaction_model');

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
                    
                    $this->transaction_model->start_date = $start_date;
                    $this->transaction_model->end_date = $end_date;
                    $this->transaction_model->id_store = $this->input->post('id_store');


                    $data = $this->transaction_model->get_yearly_statistic();
                    //print_r($data);
                    if(!empty($data)){
                        $list_value = $this->set_list_month_chart($this->input->post('start-year'),$this->input->post('end-year'));
                        //insert data on list value
                        foreach ($list_value as $month => $dt) {
                                //validate data database
                                foreach ($data as $key => $sales) {
                                        foreach ($sales as $key => $sale) {
                                                if($month==$key){
                                                        $list_value[$month] = $sale;
                                                }
                                        }
                                }
                        }

                        //split data
                        $month = array();
                        $total = array();
                        $total_profit = array();
                        foreach ($list_value as $mth => $dt) {
                                array_push($month, $mth);
                                array_push($total, $dt['total']);
                                array_push($total_profit, $dt['total_profit']);
                        }
                       
                        $return['div'] = $this->input->post('div');
                        $return['date'] = $month;
                        $return['total'] = $total;
                        $return['total_profit'] = $total_profit;
                        $return['status'] = 'success';
                        $return['access'] = $_SESSION['access'];
                        $opt = $this->option_model->get_single_option('limit_year');
                        $return['limit'] = $opt['option_value'];
                    }
                }
                echo json_encode($return);
                        
        }

        function set_list_month_chart($start, $end){
                //echo "$start, $end";
                $data = array();
                $arr_month = $this->arr_month_new();
                $arr_year = array();
                for($i=$start; $i<= $end; $i++){
                        array_push($arr_year, $i);
                }

                foreach ($arr_year as $key => $year) {
                        $item_data = array('total'=>0,'total_profit'=>0);
                        foreach ($arr_month as $key => $month) {
                                $data[$month.'-'.$year]= $item_data;
                        }
                }
                return $data;
        }

        private function arr_month_new(){
                $arr = array('January', 'Feburary', 'March', 'April', 'May', 'June',
                                'July', 'August', 'September', 'October', 'November','December',
                            );
                return $arr;
        }   





        function get_months($startstring, $endstring){
                $time1 = strtotime($startstring);//absolute date comparison needs to be done here, because PHP doesn't do date comparisons
                $time2 = strtotime($endstring);
                $my1   = date('mY', $time1); //need these to compare dates at 'month' granularity
                $my2   = date('mY', $time2);
                $year1 = date('Y', $time1);
                $year2 = date('Y', $time2);
                $years = range($year1, $year2);
                 
                foreach($years as $year){
                        $months[$year] = array();
                        while($time1 < $time2){
                                if(date('Y',$time1) == $year){
                                        $months[$year][] = date('F', $time1);
                                        $time1 = strtotime(date('Y-m-d', $time1).' +1 month');
                                }else{
                                        break;
                                }
                        }
                        continue;
                }
                 
                return $months;
        }


        
 }       