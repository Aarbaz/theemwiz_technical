<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('id')) {
            redirect('Home');
        }
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->model('login_model');
    }

    function index()
{       $user_id = $this->session->userdata('user_id');
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $this->load->view('layouts/profile',$data);
    }

    function home()
    {
        $this->form_validation->set_rules('user_email', 'Email Address', 'required|trim|valid_email');
        $this->form_validation->set_rules('user_password', 'Password', 'required');
        if ($this->form_validation->run()) {
            $result = $this->login_model->can_login($this->input->post('user_email'), $this->input->post('user_password'));
           
            if ($result == '') {
                redirect('Home');
            } else {
                $this->session->set_flashdata('message', $result);
                redirect('home');
            }
        } else {
            $result = $this->login_model->can_login($this->input->post('user_email'), $this->input->post('user_password'));
            // $response['results'] = 'Sorry! no record found';
			$response['status'] = 'Error';
            $response['results'] = $result;
            header('Content-type: application/json');
            exit(json_encode($response));
            // print_r($result);die();
            // $this->load->view('layouts/profile',$data);
        }
    }

}

?>