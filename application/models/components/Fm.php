<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fm extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	/* Вывод списока доступных файлов */
	
	
	function items($info_data){		
		$info['title'] = 'Файловый Менеджер';	
		$data['legend'] = 'Доступные Вам файлы:';			
		$data['query'] = $this->check_acess_item();
		$info['content'] = $this->load->view('components/fm/item_list',$data,true);		
		return $info; 
	}
	
	/* On-line просмотр файлов */
	
	function view($info_data = 0){	
		if(isset($info_data['id_content']) && $info_data['id_content'] != 0){			
			$this->db->select('file_path,file_ext');
			if($info_data['extra_content'] != 'history'){
				$query = $this->check_acess_item($info_data['id_content']);				
			}else{
				$this->db->where('id', $info_data['id_content']);						
				$query = $this->db->get('files_history');					
			}
			if($query->num_rows() == 1){
				$row = $query->row();
				$file = $row->file_path;				
				if(is_file($file)){
					if($row->file_ext == '.pdf'){
						header('Content-Type: application/pdf');
						readfile($file); 
					}else{
						$this->check_dir('temp');				
						$temp_path = dirname($_SERVER['SCRIPT_FILENAME']).'/temp/';
						$temp_file_name = 'temp_'.time().$row->file_ext;
						$temp_file = $temp_path.$temp_file_name;				
						if (!copy($file, $temp_file)) {
							$this->redirect_error(3);	
						}else{
							$view_info = file_get_contents('https://view.officeapps.live.com/op/view.aspx?src='.base_url('temp/'.$temp_file_name).'&embedded=true');	
							echo $view_info;	
							unlink($temp_file);						
							unset($view_info);													
						}
					}
					exit; 
				}else{
					$this->redirect_error(1);					
				}		
			}else{
				$this->redirect_error();				
			}
			exit;					
		}else{
			$this->redirect_error(2);
		}	
	}	
	function view_h($info_data = 0){
		print_r($info_data);
	}	
	/* Скачавание файлов */
	
	function download($info_data){
		if(isset($info_data['id_content']) && $info_data['id_content'] != 0){
			$query = $this->check_acess_item($info_data['id_content']);
			if($query->num_rows() == 1){	
				$row = $query->row();
				$file = $row->file_path;			
				if (file_exists($file)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($file));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					readfile($file);			
					exit;
				}else{
					echo 'NOT FILE';
				}	
			}
		}	
		exit;		
	}	
	
	/* Просмотр истории файлов */
	
	function history($info_data){
		if(isset($info_data['id_content']) && $info_data['id_content'] != 0){
			$this->db->select('id,name');	
			$query = $this->check_acess_item($info_data['id_content']);
			if($query->num_rows() == 1){	
				$row = $query->row();
				$data['legend'] = 'Файл - '.$row->name;
				$this->db->where('id_file', $info_data['id_content']);				
			}else{
				$this->redirect_error();				
			}			
		}elseif($this->session->role == 1){
			$data['legend'] = 'Все файлы';			
		}else{
			$this->redirect_error();			
		}	
		$data['query'] = $this->db->get('files_history');
		$info['title'] = 'История изменений';		
		$info['content'] = $this->load->view('components/fm/history',$data,true);
		return $info; 	
	}
		
	/* Добавление/Редактирование/Удаление файлов */
	
	function add($info_data){
		$info['title'] = 'Редактор файлов';
		$data['legend'] = 'Добавляем Новый файл';	
		$data['name'] = '';
		$data['description'] = '';
		$info['content'] = $this->load->view('components/fm/editor',$data,true);		
		return $info; 
	} 
	
	function edit($info_data){
		$this->db->select('id,name,description,file_path');	
		$query = $this->check_acess_item($info_data['id_content']);
		if($query->num_rows() == 1){
			$data = $query->row_array();
			if(is_file($data['file_path'])){
				$data['isfile'] = '<strong>Внимание!</strong> Файл уже загружен, загрузка нового файла приведет к его замене!';						
			}
			$data['legend'] = 'Редактируем файл - '.$data['name'];			
		}else{
			$this->redirect_error();					
		}
		$info['title'] = 'Редактор файлов';
		$info['content'] = $this->load->view('components/fm/editor',$data,true);	
		return $info; 	
	}	
	
	function delete($info_data){
		if($info_data['id_content'] != 0){
			$this->db->select('id,name,description,file_path,file_ext');
			$this->db->where('delete', 0);				
			$query = $this->check_acess_item($info_data['id_content']);
			if($query->num_rows() == 1){
				$row = $query->row();
				$sql_data['delete'] = 1;
				$this->db->where('id', $info_data['id_content']);
				$this->db->update('files', $sql_data);
				
				$sql_history['id_file'] = $info_data['id_content'];	
				$sql_history['type_action'] = 8;						
				$sql_history['date_action'] = time();					
				$sql_history['name'] = $row->name;
				$sql_history['description'] = $row->description;
				$sql_history['file_path'] = $row->file_path;	
				$sql_history['file_ext'] = $row->file_ext;;
				$sql_history['id_user'] = $this->session->id;
				
				$this->db->insert('files_history', $sql_history);				
				
				$this->session->set_flashdata('info_message','Успешно удалено!');
				redirect(base_url(), 'refresh');	 				
			}	
		}		
		$this->redirect_error();
	}
	
	/* Сохранение информации */
	
	function save($info_data){
		$this->form_validation->set_rules('name', 'Название файла',  'required');
		$this->form_validation->set_message('required', 'Поле обязательно для заполнения!');

		if ($this->form_validation->run() == FALSE){ 
			$info = $this->add($info_data);						
		}else{	
			$sql_data['name'] = $_POST['name'];		
			$sql_data['description'] = $_POST['description'];
			$sql_data['date_last_action'] = time();			
			if(!isset($_POST['id'])){
				if(is_uploaded_file($_FILES['file']['tmp_name'])) {
					$type_action = 0;
					$file_data = $this->do_upload_file();
					if($file_data['file_path'] == 'error'){
						$this->session->set_flashdata('error_message','Некорректный файл!');
						$info = $this->add($info_data);	
						return $info;						
					}
					$sql_data['file_path'] = $file_data['file_path'];
					$sql_data['file_url'] = $file_data['file_url'];
					$sql_data['file_ext'] = $file_data['file_ext'];			
					$sql_data['date_create'] = time();	
					$sql_data['id_user'] = $this->session->id;		
					$sql_data['user_role'] = $this->session->role;			
					$this->db->insert('files', $sql_data);
					$id_file = $this->db->insert_id();		
					$this->session->set_flashdata('info_message','Успешно добавлено!');						
				}else{
					$this->session->set_flashdata('error_message','Файл обязателен!');
					$info = $this->add($info_data);						
				}					
			}else{
				$type_action = 9; 
				$this->db->select('name,description,file_path,file_ext');	
				$query = $this->check_acess_item($_POST['id']);
				if($query->num_rows() == 1){
					$old_data = $query->row_array();					
					if($old_data['name'] != $sql_data['name']){ $type_action = 1;}
					if($old_data['description'] != $sql_data['description']){ $type_action = 2;}
					if($old_data['name'] != $sql_data['name'] && $old_data['description'] != $sql_data['description']){ $type_action = 3;}
					if(is_uploaded_file($_FILES['file']['tmp_name'])) {
						$type_action = 4;
						$file_data = $this->do_upload_file();
						if($file_data['file_path'] == 'error'){
							$this->session->set_flashdata('error_message','Некорректный файл!');
							$info = $this->add($info_data);
							return $info;
						}
						$sql_data['file_path'] = $file_data['file_path'];
						$sql_data['file_url'] = $file_data['file_url'];
						$sql_data['file_ext'] = $file_data['file_ext'];	
						if($old_data['name'] != $sql_data['name']){ $type_action = 5;}
						if($old_data['description'] != $sql_data['description']){ $type_action = 6;}
						if($old_data['name'] != $sql_data['name'] && $old_data['description'] != $sql_data['description']){ $type_action = 7;}						
					}else{
						$sql_data['file_path'] = $old_data['file_path'];
						$sql_data['file_ext'] = $old_data['file_ext'];							
					}
					$id_file = $_POST['id'];						
					$this->db->where('id', $id_file);
					$this->db->update('files', $sql_data); 		
					$this->session->set_flashdata('info_message','Успешно обновлено!');		
				}else{
					$this->redirect_error();				
				}	
			}
			if(isset($type_action)){
				if($type_action != 9){
					$sql_history['id_file'] = $id_file;	
					$sql_history['type_action'] = $type_action;						
					$sql_history['date_action'] = $sql_data['date_last_action'];					
					$sql_history['name'] = $sql_data['name'];
					$sql_history['description'] = $sql_data['description'];
					$sql_history['file_path'] = $sql_data['file_path'];	
					$sql_history['file_ext'] = $sql_data['file_ext'];
					$sql_history['id_user'] = $this->session->id;	
					$this->db->insert('files_history', $sql_history);
				}
			}
			if(!isset($info)){
				redirect(base_url(), 'refresh');					
			}		
		}
		return $info; 	
	}	
	
	function do_upload_file(){
		$this->check_dir('uploads');
		$this->check_dir('uploads/user');	
		$this->check_dir('uploads/user/'.$this->session->id);			
		$config_upload['upload_path'] = './uploads/user/'.$this->session->id.'/';			
		$config_upload['file_ext_tolower'] = TRUE;
		$config_upload['allowed_types'] = 'doc|docx|xls|xlsx|pdf';
		$config_upload['file_name'] = time();				
		$this->load->library('upload', $config_upload);
		if($this->upload->do_upload('file')){					
			$file_data['file_path'] = $this->upload->data('full_path');
			$file_data['file_url'] = base_url(str_replace($_SERVER['CONTEXT_DOCUMENT_ROOT'], '', $this->upload->data('full_path')));
			$file_data['file_ext'] = $this->upload->data('file_ext');
		}else{
			$file_data['file_path'] = 'error';					
		}
		return $file_data;		
	}	
	
	/* Вспомогательные функции:
		function check_acess_item() - Проверяем имеет ли право текущий пользователь получить доступ.
		function get_user() - Получение имени пользователя из БД
		function get_title_action() - Получение названия События
		function check_dir() - Проверка каталога для файлов
		function redirect_error() - Редирект с различными ошибками 
	*/
	function check_acess_item($id = 0){
		if($id != 0){	
			$this->db->where('id', $id);			
		}
		if($this->session->role >= 1){
			$this->db->where('delete', 0);			
		}					
		if($this->session->role == 2){
			$this->db->where('id_user', $this->session->id);				
		}
		if($this->session->role == 3){
			$this->db->where('user_role >=', 2);				
		}		
		return $this->db->get('files');			
	}	
	function get_user($id_user = 0){
		$this->db->select('name');			
		$this->db->where('id', $id_user);					
		$query = $this->db->get('user');
		if ($query->num_rows() == 1){ 			
			$row = $query->row();
			$user = '<a href="'.base_url('user/profile/'.$id_user).'">'.$row->name.'</a>';
		}else{  
			$user = 'Ошибка';
		}
		return $user; 
	}	
	function get_title_action($id_action = 0){
		switch ($id_action) {
		case 0:
			echo "Создание файла";
			break;
		case 1:
			echo "Изменено Название файла";
			break;
		case 2:
			echo "Изменено Описание файла";
			break;
		case 3:
			echo "Изменено Название и Описание файла";
			break;
		case 4:
			echo "Заменен файл";
			break;
		case 5:
			echo "Заменен файл и Изменено Название файла";
			break;
		case 6:
			echo "Заменен файл и Изменено Описание файла";
			break;
		case 7:
			echo "Заменен файл и Изменено Название и Описание файла";
			break;			
		case 8:
			echo "Файл был удален";
			break;			
		}		
	}	
	function check_dir($alias){
		$path = dirname($_SERVER['SCRIPT_FILENAME']).'/'.$alias.'/';
		$path_file = dirname($_SERVER['SCRIPT_FILENAME']).'/'.$alias.'/.htaccess';
		
		if (!is_dir($path)) { 
			mkdir($path, 0777);
		}	
		if (!file_exists($path_file) && $alias != 'temp'){ 
			$text = '<IfModule authz_core_module>Require all denied</IfModule><IfModule !authz_core_module>Deny from all</IfModule>';
			$fp = fopen($path_file, "w");
			fwrite($fp, $text);
			fclose($fp);
		}			
		return TRUE;
	}	
	function redirect_error($id_error = 0){
		switch ($id_error){
		case 0:
			$this->session->set_flashdata('error_message','Элемент не найден в Базе данных или у Вас нет доступа!');
			break;
		case 1:
			$this->session->set_flashdata('error_message','Файл не найден');
			break;
		case 2:
			$this->session->set_flashdata('error_message','Элемент не найден!');
			break;
		case 3:
			$this->session->set_flashdata('error_message','Некорректный файл!');
			break;			
		}		
		redirect(base_url(), 'refresh');
	}
}