<div class="container">
    <div class="row">	
		<? if($this->session->role == 1){ ?>
		<p class="text-left col-md-6">
			<a href="<? echo base_url('fm/history'); ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-calendar"></span> События </a>
		</p>	
		<?	}	?>	
		<p class="text-right">
			<a href="<? echo base_url('fm/add.html'); ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus-sign"></span> Добавить файл </a>
		</p>
		<legend><? echo $legend; ?></legend>		
		<table class="table table-hover table-bordered table_files" border="0" cellpadding="0" cellspacing="1" width="100%">
			<thead> 
				<tr>
					<th width="5%" class="text-center">id:</th>							
					<th width="45%" class="text-center">Название / Описание:</th>	
					<th width="6%" class="text-center">Добавил:</th>	
					<th width="12%" class="text-center">Создано:</th>	
					<th width="12%" class="text-center">Обновлено:</th>						
					<th width="20%" class="text-center">Действия:</th>						
				</tr>
			</thead>
			<tbody>
		<?	if(isset($query) && $query->num_rows() > 0){
			foreach ($query->result() as $row){
				if($row->delete == 1){ echo '<tr class="danger">'; }else{ echo '<tr>';}
		?>
					<td class="vertical-middle text-center"><? echo $row->id; ?></td>
					<td class="vertical-middle"><? echo $row->name.'/'.$row->description; ?></td>
					<td class="vertical-middle text-center"><? echo $this->this_component->get_user($row->id_user); ?></td>
					<td class="vertical-middle text-center"><? echo date('Y-m-d H:i',$row->date_create); ?></td>
					<td class="vertical-middle text-center"><? echo date('Y-m-d H:i',$row->date_last_action); ?></td>
					<td class="vertical-middle text-center">
					<? if($row->delete == 0){	?>
						<a href="<? echo base_url('fm/view/'.$row->id.'.html'); ?>" class="btn btn-default" data-type="file" data-title="<? echo $row->name; ?>" data-width="1000" data-toggle="lightbox"><span class="glyphicon glyphicon-eye-open"></span></a>
						<a href="<? echo base_url('fm/download/'.$row->id.'.html'); ?>" class="btn btn-success" data-type="dfile" data-title="Загрузка файла" data-width="400" data-toggle="lightbox"><span class="glyphicon glyphicon-cloud-download"></span></a>
					<?	}	?>	
						<a href="<? echo base_url('fm/history/'.$row->id.'.html'); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-calendar"></span></a>
					<? if($row->delete == 0){	?>
						<a href="<? echo base_url('fm/edit/'.$row->id.'.html'); ?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
						<a href="<? echo base_url('fm/delete/'.$row->id.'.html'); ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
					<?	}	?>						
					</td>					
				</tr>		
		<?
			}}
		?>		
			</tbody>	
		</table>
	</div>
</div>

<script type="text/javascript" src="<? echo base_url('core/datatables/datatables.min.js'); ?>"></script>
<script type="text/javascript" src="<? echo base_url('core/ekko/ekko-lightbox.js'); ?>"></script>	
<link href="<? echo base_url('core/ekko/ekko-lightbox.css'); ?>" rel="stylesheet">
<script type="text/javascript"> 
	$(document).ready(function(){ 
		$(".table_files").DataTable({"order":[[4,"desc"]]}); 
	}); 
	$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
		event.preventDefault();
		$(this).ekkoLightbox();
	}); 
</script>

