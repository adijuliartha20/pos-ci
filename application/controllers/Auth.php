<?php 
class Auth extends CI_Controller{
	
    private $cookie_name = 'locoadmin';

	public function __construct(){
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->helper(array('url_helper', 'Form', 'Cookie', 'String', 'function'));

        
    }

    public function index(){
        $cookie = get_cookie($this->cookie_name);
        
        if($this->session->userdata('logged')){//view dashboard
            $this->set_dashboard();
        }else if($cookie <> ''){
            $row = $this->auth_model->get_by_cookie($cookie)->row_array();
            if ($row) {
                $this->record_session($row);
                $this->set_dashboard();
            } else {
                $this->set_login_form();
            }
        }else{
            $this->set_login_form();
        }        
    }



    public function set_login_form(){
        $data = array();
        add_footer_js(array('admin-login.js'));
        $this->load->view('admin/login/index', $data);
    }

    public function set_dashboard(){
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



    public function login(){
        $return = array();
        $return['status'] = 'failed';

        $username = $this->input->get('username');
        $password = $this->input->get('password');
        $remember = $this->input->get('remember');
        
        $row = $this->auth_model->login($username, $password);
        
        if ($row['status']==true){
            $data = $row['data'];
            if(isset($_POST['remember']) && $_POST['remember']=='on'){
                $key = random_string('alnum', 64);
                set_cookie($this->cookie_name, $key, 3600*24*30); // set expired 30 hari kedepan
                
                // simpan key di database
                $update_key = array('cookie' => $key);
                $this->auth_model->update($update_key, $data['id_user']);
            }
            $this->record_session($data);
            $return['status'] = 'success';
            $return['msg'] = 'go to dashboard';

            redirect(ADMIN_URL);
        }else{
            $this->session->set_flashdata('message','Login Gagal');
            $return['msg'] = 'User not found';


        }
        //echo ;
        echo json_encode($return);
    }


    public function record_session($data){
        $log = array(
                    'logged' => 'TRUE',
                    'username' => $data['username'],
                    'id' => $data['id_user'],
                    'image' => $data['picture'],
                    'name' => $data['first_name'].' '.$data['last_name'],
                    'access' => $data['user_tipe'],
                );

        $this->session->set_userdata($log);
    }

    public function logout(){
        delete_cookie($this->cookie_name);
        $this->session->sess_destroy();
        redirect('locoadmin');
    }

}
?>