<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AllParent extends CI_Controller {

	function __construct() { 

        parent::__construct();
 		$this->load->database();
        $this->load->library('form_validation');
        $this->load->library('upload');

        $login_id = $this->session->userdata('login_id');

		$this->db->from('all_payments_tbl');
		$this->db->where('EXPIRE_DATE <', date('Y-m-d'));
		$this->db->where('ALERT', 0);
		$this->db->join('student', 'all_payments_tbl.STUDENT = student.ID');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {

				$student_id = $row->STUDENT;

              $this->db->where('PARENT', $login_id);
              $this->db->where('ID', $student_id);
              $students = $this->db->get('student');
              if ($students->num_rows() > 0){
              	$this->session->set_flashdata('enroll_id_due', $row->STUDENT);
				$this->session->set_flashdata('due_payment', 'Payment Due');
              }
			}
		}
    }

	public function index() {
		if ($this->session->userdata('login_check') != 'go@parent')
            redirect(base_url(), 'refresh'); 

		$this->dashboard();
	}

	public function dashboard() {
		if ($this->session->userdata('login_check') != 'go@parent')
            redirect(base_url(), 'refresh'); 

		$page_data['page_name'] = 'dashboard';
		$page_data['page_title'] = 'Dashboard';
		$page_data['page_s_name'] = '';

		$this->load->view('parent/dashboard', $page_data);
	}

	function payment($param1='',$param2='',$param3='')
	{
		if ($this->session->userdata('login_check') != 'go@parent')
            redirect(base_url(), 'refresh'); 
        
		$page_data['page_name'] = 'payment';
		$page_data['class_id'] = $param1;
		$page_data['page_title'] = 'Manage Payment';
		$page_data['page_s_name'] = $param2;
		$page_data['student_id'] = $param2;

		$this->load->view('parent/payment', $page_data);
	}

}
