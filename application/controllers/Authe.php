<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authe extends CI_Controller
{

    function index()
    {
        if ($this->session->userdata('login_check') == 'go@parent')
            redirect(base_url() . 'allparent', 'refresh');


        if ($this->session->userdata('login_check') == 'go@yes')
            redirect(base_url() . 'admin', 'refresh');


        $this->login();
    }

    function login()
    {
        $this->load->view('login');
    }

    function valafclog()
    {
        $email = $this->input->post('email');
        $pwd = $this->input->post('pwd');

        $check = $this->checklogin($email, $pwd);
        if ($check == 'active_staff') {
            redirect(base_url() . 'admin', 'refresh');
        } elseif ($check == 'active_parent') {
            redirect(base_url() . 'allparent', 'refresh');
        } else {
            $this->session->set_flashdata('invalid_cred', 'Correo o Contraseña, Inválidas');
            redirect(base_url(), 'refresh');
        }
    }

    function checklogin($email, $pwd)
    {
        $this->db->where('PASSWORD', md5($pwd));
        $this->db->where('EMAIL', $email);
        $query = $this->db->get('users_tbl');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('login_id', $row->ID);
            $this->session->set_userdata('login_email', $row->EMAIL);
            $this->session->set_userdata('login_name', $row->NAME);
            $this->session->set_userdata('login_priv', $row->PRIV);
            $this->session->set_userdata('login_check', 'go@yes');
            return 'active_staff';
        }

        $this->db->where('PASSWORD', md5($pwd));
        $this->db->where('EMAIL', $email);
        $query = $this->db->get('parent_tbl');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('login_id', $row->ID);
            $this->session->set_userdata('login_email', $row->EMAIL);
            $this->session->set_userdata('login_name', $row->NAME);
            $this->session->set_userdata('login_phone', $row->PHONE);
            $this->session->set_userdata('login_check', 'go@parent');
            return 'active_parent';
        }

        return 'inactive';
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'Cerrando Sesión en el Sistema');
        redirect(base_url(), 'refresh');
    }
}
