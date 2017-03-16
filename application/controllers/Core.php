<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core extends CI_Controller {
	
	public function components()
	{
		if($this->session->logon != 1 && $this->uri->total_segments() > 0 && $this->uri->segment(1, 'false') != 'user'){
			$this->session->set_flashdata('error_message','Доступ к системе только после авторизации!');
			redirect(base_url(), 'refresh');	
		} 
		
		if($this->session->logon == 1){						
			$component = $this->uri->segment(1, 'fm');			
			if($component != 'fm' && $component != 'user' ){redirect(base_url(), 'refresh');}	/* По уму тут должна быть проверка в БД на существование компонента*/			
			$function = $this->uri->segment(2, 'items');	 
			$info_data['id_content'] = $this->uri->segment(3, 0);
			$info_data['extra_content'] = $this->uri->segment(4, 0);	
		}else{
			$component = 'user';
			$function = $this->uri->segment(2, 'loginform');	
			$info_data = '';
		}	

		
		$file_component = 'components/'.$component;		
		$this->load->model($file_component,'this_component');	
		$info = $this->this_component->$function($info_data); 
		$this->load->view('template',$info);
	}
}
