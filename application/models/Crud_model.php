<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model { 
  
	function __construct() 
    { 
        parent::__construct(); 
    }

    function add_class()
    {
    	$fees = str_replace(',', '', $this->input->post('cfees'));
        $class_data = array(
            'NAME' => $this->input->post('cname'),
            'FEES' => $fees,
            'SESSION' => $this->db->get_where('settings_tbl',array('ID'=>1))->row()->SESSION,
        );

        $this->db->insert('class_tbl', $class_data);
        $class_id = $this->db->insert_id();

        return array(
            'inserted' => 'done',
            'class_id' => $class_id
        );
    }

    function add_term()
    {
    	$fees = str_replace(',', '', $this->input->post('tfees'));
        $term_data = array(
        	'CLASS_ID' => $this->input->post('class'),
            'NAME' => $this->input->post('tname'),
            'FEES' => $fees,
            'SESSION' => $this->db->get_where('settings_tbl',array('ID'=>1))->row()->SESSION,
        );

        $this->db->insert('term_tbl', $term_data);
        $term_id = $this->db->insert_id();

        return array(
            'inserted' => 'done',
            'term_id' => $term_id
        );
    }

    function add_user()
    {
    	$email = $this->input->post("email");
    	if ($email != ''){
	        if ($this->check_email($email)) {
	            return FALSE;
	            die();
	        }
    	}

        $pwd = md5($this->input->post("pwd"));
        $user_data = array(
            'NAME' => $this->input->post("name"),
            'EMAIL' => $email,
            'PASSWORD' => $pwd,
            'PRIV' => $this->input->post("priv"),
        );

        $this->db->insert('users_tbl', $user_data);
        $user_id = $this->db->insert_id();

        return array(
            'inserted' => 'done',
            'user_id' => $user_id
        );
    }

    function add_parent()
    {
        $email = $this->input->post("email");
        if ($email != ''){
            if ($this->check_email($email)) {
                return FALSE;
                die();
            }
        }

        $pwd = md5($this->input->post("password"));
        $parent_data = array(
            'NAME' => $this->input->post("name"),
            'PHONE' => $this->input->post("phone"),
            'ADDRESS' => $this->input->post("address"),
            'EMAIL' => $email,
            'PASSWORD' => $pwd,
        );

        $this->db->insert('parent_tbl', $parent_data);
        $parent_id = $this->db->insert_id();

        return array(
            'inserted' => 'done',
            'parent_id' => $parent_id
        );
    }

    function add_student($class_id)
    {
        $student_data = array(
            'NAME' => $this->input->post("name"),
            'PARENT' => $this->input->post("parent"),
            'CLASS' => $class_id,
            'SESSION' => $this->db->get_where('settings_tbl',array('ID'=>1))->row()->SESSION,
        );

        $this->db->insert('student', $student_data);
        $student_id = $this->db->insert_id();

        // Payment data
        $payment_data = array(
            'STUDENT' => $student_id,
            'TOTAL_AMOUNT' => $this->db->get_where('class_tbl',array('ID'=>$class_id))->row()->FEES,
            'AMOUNT_PENDING' => $this->db->get_where('class_tbl',array('ID'=>$class_id))->row()->FEES,
            'SESSION' => $this->db->get_where('settings_tbl',array('ID'=>1))->row()->SESSION,
        );
        $this->db->insert('payment_tbl', $payment_data);

        return array(
            'inserted' => 'done',
            'student_id' => $student_id
        );
    }

    // Edit functionalities
    function edit_student($student_id)
    {
        $student_data = array(
            'NAME' => $this->input->post("name"),
            'PARENT' => $this->input->post("parent")
        );

        $this->db->where('ID', $student_id);
        $this->db->update('student', $student_data);

        return array(
            'edited' => 'done',
            'student_id' => $student_id
        );
    }

    function edit_class($class_id)
    {
    	$fees = str_replace(',', '', $this->input->post('cfees'));
        $class_data = array(
            'NAME' => $this->input->post('cname'),
            'FEES' => $fees,
        );

        $this->db->where('ID', $class_id);
		$this->db->update('class_tbl', $class_data);

        return array(
            'edited' => 'done',
        );
    }

    function edit_term($term_id)
    {
    	$fees = str_replace(',', '', $this->input->post('tfees'));
        $term_data = array(
        	'CLASS_ID' => $this->input->post('class'),
            'NAME' => $this->input->post('tname'),
            'FEES' => $fees,
        );

        $this->db->where('ID', $term_id);
		$this->db->update('term_tbl', $term_data);

        return array(
            'edited' => 'done',
        );
    }

    function main_settings($id=1)
    {
    	$settings_data = array(
        	'NAME' => $this->input->post('name'),
        	'ADDRESS' => $this->input->post('address'),
        	'PHONE' => $this->input->post('phone'),
        	'SESSION' => $this->input->post('session'),
            'BANK' => $this->input->post('bank'),
        	'ACC_NAME' => $this->input->post('acc_name'),
        	'ACC_NUMBER' => $this->input->post('acc_number'),
        );

        $this->db->where('ID', $id);
		$this->db->update('settings_tbl', $settings_data);

        return array(
            'edited' => 'done',
        );
    }

    // Delete Functionalities
    function del_user($user_id)
    {
        $this->db->where('ID', $user_id);
		$this->db->delete('users_tbl');

        return array(
            'deleted' => 'done',
        );
    }

    //check if email exist
    function check_email($email='')
    {
    	$email1 = $this->db->get_where('users_tbl', array('EMAIL' => $email));
        $email2 = $this->db->get_where('parent_tbl', array('EMAIL' => $email));

        if ($email1->num_rows() > 0 || $email2->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    //////////////// PAYMENT ////////////////////////
    function new_payment($class_id='',$student_id='',$term_id='')
    {
        $new_pay = str_replace(',', '', $this->input->post('new_pay'));
        $session = $this->db->get_where('settings_tbl',array('ID'=>1))->row()->SESSION;
        // payment data
        $all_payment_data = array(
            'STUDENT' => $student_id,
            'AMOUNT_PAID' => $new_pay,
            'EXPIRE_DATE' => $this->input->post('ex_date'),
            'SESSION' => $session,
            'CLASS' => $class_id,
            'TERM' => $term_id,
        );
        $this->db->insert('all_payments_tbl', $all_payment_data);
        $payment_id = $this->db->insert_id();
        
        // payment_table
        $tamount_paid = $this->db->get_where('payment_tbl', array('STUDENT'=>$student_id,'SESSION'=>$session))->row()->AMOUNT_PAID;
        $total_amount = $this->db->get_where('payment_tbl', array('STUDENT'=>$student_id,'SESSION'=>$session))->row()->TOTAL_AMOUNT;

        $present_t_pay = $new_pay + $tamount_paid;
        $amount_pending = $total_amount - $present_t_pay;

        $payment_data = array(
            'AMOUNT_PAID' => $present_t_pay,
            'AMOUNT_PENDING' => $amount_pending,
        );
        $this->db->where('STUDENT',$student_id);
        $this->db->where('SESSION',$session);
        $this->db->update('payment_tbl', $payment_data);
        

        //return $event_code;
        return array(
            'inserted' => 'done',
            'payment_id' => $payment_id,
        );
    }
    function delete_class($class_id)
    {
        $this->db->where('ID', $class_id);
		$this->db->delete('class_tbl');

        return array(
            'deleted' => 'done',
        );
    }
    function delete_term($term_id)
    {
        $this->db->where('ID', $term_id);
		$this->db->delete('term_tbl');

        return array(
            'deleted' => 'done',
        );
    }
}