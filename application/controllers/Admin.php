<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{

		parent::__construct();
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->library('upload');

		// check all payment and grab those that are due
		$this->db->where('EXPIRE_DATE <', date('Y-m-d'));
		$this->db->where('ALERT', 0);
		$query = $this->db->get("all_payments_tbl");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$this->session->set_flashdata('enroll_id_due', $row->STUDENT);
				$this->session->set_flashdata('due_payment', 'Payment Due');
			}
		}
	}

	public function index()
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		$this->dashboard();
	}

	public function dashboard()
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		$page_data['page_name'] = 'dashboard';
		$page_data['page_title'] = 'Dashboard';
		$page_data['page_s_name'] = '';

		$this->load->view('admin/dashboard', $page_data);
	}

	function enrollment($param1 = '', $param2 = '', $param3 = '')
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		$page_data['page_name'] = 'enrollment';
		$page_data['class_id'] = $param2;
		$page_data['page_title'] = 'Class';
		$page_data['page_s_name'] = $param2;

		$this->load->view('admin/enrollment', $page_data);
	}

	function parent()
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		$page_data['page_name'] = 'parent';
		$page_data['page_title'] = 'Manage Parents';
		$page_data['page_s_name'] = '';

		$this->load->view('admin/parent', $page_data);
	}

	function payment($param1 = '', $param2 = '', $param3 = '', $param4 = '')
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		$page_data['page_name'] = 'payment';
		$page_data['class_id'] = $param2;
		$page_data['page_title'] = 'Manage Payment';
		$page_data['page_s_name'] = 'p' . $param2;

		if ($param1 == 'class') {
			$this->load->view('admin/payment', $page_data);
		}

		if ($param1 == 'single') {
			$page_data['student_id'] = $param3;
			$this->load->view('admin/single_payment', $page_data);
		}

		if ($param1 == 'due_payment') {
			$page_data['page_s_name'] = 'due_pay';
			$this->load->view('admin/due_payment', $page_data);
		}

		if ($param1 == 'none_payment') {
			$page_data['page_s_name'] = 'none_pay';
			$this->load->view('admin/none_payment', $page_data);
		}

		if ($param1 == 'mute') {
			$payment_id = $param2;
			$student_id = $param3;
			$class_id = $param4;
			$data = array(
				'ALERT' => 1
			);
			$this->db->where('ID', $payment_id);
			$this->db->update('all_payments_tbl', $data);

			$this->session->set_flashdata('completed', 'Acción realizada correctamente');
			redirect(base_url() . 'admin/payment/single/' . $class_id . '/' . $student_id, 'refresh');
		}

		if ($param1 == 'unmute') {
			$payment_id = $param2;
			$student_id = $param3;
			$class_id = $param4;
			$data = array(
				'ALERT' => 0
			);
			$this->db->where('ID', $payment_id);
			$this->db->update('all_payments_tbl', $data);

			$this->session->set_flashdata('completed', 'Acción realizada correctamente');
			redirect(base_url() . 'admin/payment/single/' . $class_id . '/' . $student_id, 'refresh');
		}
	}

	function management($name = '')
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		$page_data['page_name'] = 'management';
		if ($name == 'class') {
			$page_data['page_title'] = 'Manage Classes';
			$page_data['page_s_name'] = 'class';

			$this->load->view('admin/class', $page_data);
		}

		if ($name == 'term') {
			$page_data['page_title'] = 'Manage Term';
			$page_data['page_s_name'] = 'term';

			$this->load->view('admin/term', $page_data);
		}

		if ($name == 'users') {
			$page_data['page_title'] = 'Manage Users';
			$page_data['page_s_name'] = 'users';

			$this->load->view('admin/users', $page_data);
		}

		if ($name == 'settings') {
			$page_data['page_title'] = 'General Settings';
			$page_data['page_s_name'] = 'settings';

			$this->load->view('admin/settings', $page_data);
		}
	}

	function action($spec = '', $param2 = '', $param3 = '')
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		if ($spec == 'new_class') {
			$add_class = $this->Crud_model->add_class();
			if ($add_class['inserted'] == 'done') {
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/management/class', 'refresh');
			}
		}
		if ($spec == 'delete_class') {
			$delete_class = $this->Crud_model->delete_class($param2);
			if ($delete_class['deleted'] == 'done') {
				$this->session->set_flashdata('completed', 'Año ha sido eliminado correctamente');
				redirect(base_url() . 'admin/management/class', 'refresh');
			}
		}

		if ($spec == 'new_term') {
			$add_term = $this->Crud_model->add_term();
			if ($add_term['inserted'] == 'done') {
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/management/term', 'refresh');
			}
		}

		if ($spec == 'delete_term') {
			$delete_term = $this->Crud_model->delete_term($param2);
			if ($delete_term['deleted'] == 'done') {
				$this->session->set_flashdata('completed', 'Term has been deleted successfully.');
				redirect(base_url() . 'admin/management/term', 'refresh');
			}
		}

		if ($spec == 'new_user') {
			$add_user = $this->Crud_model->add_user();
			if ($add_user['inserted'] == 'done') {
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/management/users', 'refresh');
			} else {
				$this->session->set_flashdata('user_exist', 'A user with that same email already exist.');
				redirect(base_url() . 'admin/management/users', 'refresh');
			}
		}

		if ($spec == 'main_settings') {
			$main_settings = $this->Crud_model->main_settings();
			if ($main_settings['edited'] == 'done') {
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/management/settings', 'refresh');
			}
		}

		if ($spec == 'add_new_parent') {
			$add_parent = $this->Crud_model->add_parent();
			if ($add_parent['inserted'] == 'done') {
				move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/parents/' . $add_parent['parent_id'] . '.png');
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/parent', 'refresh');
			} else {
				$this->session->set_flashdata('user_exist', 'A user with that same email already exist.');
				redirect(base_url() . 'admin/parent', 'refresh');
			}
		}

		if ($spec == 'add_new_student') {
			$class_id = $param2;
			$add_student = $this->Crud_model->add_student($class_id);
			if ($add_student['inserted'] == 'done') {
				//move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/students/'. $add_student['student_id'] .'.png');
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/enrollment/class/' . $class_id, 'refresh');
			}
		}

		if ($spec == 'edit_student') {
			$student_id = $param2;
			$class_id = $param3;
			$edit_student = $this->Crud_model->edit_student($student_id);
			if ($edit_student['edited'] == 'done') {
				// move_uploaded_file($_FILEeS['photo']['tmp_name'], 'uploads/students/'. $edit_student['student_id'] .'.png');
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/enrollment/class/' . $class_id, 'refresh');
			}
		}
	}

	public function options($param1 = '', $param2 = '')
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		if ($param1 == "edit_class") {
			$page_data['class_id'] = $param2;
			$page_data['page_name'] = 'management';
			$page_data['page_title'] = 'Edit Class';
			$page_data['page_s_name'] = 'class';

			$this->load->view('admin/edit-class', $page_data);
		}

		if ($param1 == "edit_term") {
			$page_data['term_id'] = $param2;
			$page_data['page_name'] = 'management';
			$page_data['page_title'] = 'Edit Term';
			$page_data['page_s_name'] = 'term';

			$this->load->view('admin/edit_term', $page_data);
		}
	}

	function sub_action($action = '', $param2 = '')
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		if ($action == 'edit_class') {
			$edit_class = $this->Crud_model->edit_class($param2);
			if ($edit_class['edited'] == 'done') {
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/management/class', 'refresh');
			}
		}
		if ($action == 'edit_term') {
			$edit_term = $this->Crud_model->edit_term($param2);
			if ($edit_term['edited'] == 'done') {
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/management/term', 'refresh');
			}
		}
		if ($action == 'del_user') {
			$del_user = $this->Crud_model->del_user($param2);
			if ($del_user['deleted'] == 'done') {
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/management/users', 'refresh');
			}
		}
		if ($action == 'update_logo') {
			move_uploaded_file($_FILES['logo']['tmp_name'], 'uploads/logo.png');

			$this->session->set_flashdata('completed', 'Acción realizada correctamente');
			redirect(base_url() . 'admin/management/settings', 'refresh');
		}
	}

	////////////////// PAYMENTS //////////////////
	function payment_actions($param1 = '', $param2 = '', $param3 = '', $param4 = '')
	{
		if ($this->session->userdata('login_check') != 'go@yes')
			redirect(base_url(), 'refresh');

		if ($param1 == 'new_pay') {
			$class_id = $param2;
			$student_id = $param3;
			$term_id = $param4;
			$new_payment = $this->Crud_model->new_payment($class_id, $student_id, $term_id);
			if ($new_payment['inserted'] == 'done') {
				$this->session->set_flashdata('completed', 'Acción realizada correctamente');
				redirect(base_url() . 'admin/payment/single/' . $class_id . '/' . $student_id, 'refresh');
			}
		}
	}

	function promote($param1 = '', $param2 = '')
	{
		$class_id = $param1;
		$student_id = $param2;
		$current_session = $this->db->get_where('settings_tbl', array('ID' => 1))->row()->SESSION;

		$new_session = $this->input->post('session');
		$new_class = $this->input->post('class');

		$parent_id = $this->db->get_where('student', array('ID' => $student_id))->row()->PARENT;
		$student_name = $this->db->get_where('student', array('ID' => $student_id))->row()->NAME;

		$student_new_data = array(
			'PARENT' => $parent_id,
			'NAME' => $student_name,
			'CLASS' => $new_class,
			'SESSION' => $new_session,
		);
		$this->db->insert('student', $student_new_data);
		$new_id = $this->db->insert_id();

		// Payment data
		$payment_data = array(
			'STUDENT' => $new_id,
			'TOTAL_AMOUNT' => $this->db->get_where('class_tbl', array('ID' => $new_class))->row()->FEES,
			'AMOUNT_PENDING' => $this->db->get_where('class_tbl', array('ID' => $new_class))->row()->FEES,
			'SESSION' => $new_session,
		);
		$this->db->insert('payment_tbl', $payment_data);

		$this->session->set_flashdata('completed', 'Acción realizada correctamente');
		redirect(base_url() . 'admin/payment/class/' . $class_id, 'refresh');
	}

	function get_class($session)
	{
		$classes = $this->db->get_where('class_tbl', array('SESSION' => $session))->result_array();
		foreach ($classes as $row) {
			echo '<option value="' . $row['ID'] . '">' . $row['NAME'] . '</option>';
		}
	}
}
