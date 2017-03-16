<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function loginform(){
		$info['title'] = 'Авторизация в системе';
		$info['content'] = $this->load->view('components/user/loginform','',true);		
		return $info; 
	}
	function login(){
		$this->form_validation->set_rules('login', 'Логин',  'required');
		$this->form_validation->set_rules('password', 'Пароль',  'required');	
		$this->form_validation->set_message('required', 'Поле обязательно для заполнения!');

		if ($this->form_validation->run() == FALSE){ 
			$info = $this->loginform();		
			return $info;			
		}else{	
			$login = $_POST['login'];
			$password = $_POST['password'];
			$this->db->select('id,name,role');			
			$this->db->where('password', $password);
			$this->db->where('login', $login);					
			$query = $this->db->get('user');
			if ($query->num_rows() == 1){ 			
				$row = $query->row_array();
				$this->session->set_userdata($row);				
				$this->session->set_userdata('logon', 1);
			}else{ 
				$this->session->set_flashdata('error_message','Внимание! Неверный Логин или Пароль!');		
			} 
			redirect(base_url(), 'refresh');
		}

	}
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}
}