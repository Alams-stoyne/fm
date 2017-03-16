<div class="container">
    <div class="row">
		<p class="text-left">
			<a href="<? echo base_url(); ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-chevron-left"></span> Вернуться Назад </a>
		</p>	
		<legend><? echo $legend; ?></legend>
		<table class="table table-hover table-bordered table_files_history" border="0" cellpadding="0" cellspacing="1" width="100%">
			<thead> 
				<tr>
					<th width="5%" class="text-center">id:</th>
					<th width="10%" class="text-center">id Файла:</th>				
					<th width="23%" class="text-center">Событие:</th>	
					<th width="12%" class="text-center">Дата:</th>						
					<th width="10%" class="text-center">Автор:</th>
					<th width="40%" class="text-center">Значения Название / Описание:</th>		
				</tr>
			</thead>
			<tbody>
		<?	if(isset($query) && $query->num_rows() > 0){
			foreach ($query->result() as $row){
				if($row->type_action == 8){ echo '<tr class="danger">'; }else{ echo '<tr>';}
		?>
					<td class="vertical-middle text-center"><? echo $row->id; ?></td>
					<td class="vertical-middle text-center"><? echo $row->id_file; ?></td>	
					<td class="vertical-middle text-center"><? echo $this->this_component->get_title_action($row->type_action); ?></td>	
					<td class="vertical-middle text-center"><? echo date('Y-m-d H:i',$row->date_action); ?></td>
					<td class="vertical-middle text-center"><? echo $this->this_component->get_user($row->id_user); ?></td>
					<td class="vertical-middle">
						<a href="<? echo base_url('fm/view/'.$row->id.'/history.html'); ?>" class="btn btn-default" data-type="file" data-title="<? echo $row->name; ?>" data-width="1000" data-toggle="lightbox"><span class="glyphicon glyphicon-eye-open"></span></a>
						<? echo $row->name.' / '.$row->description; ?>
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
		$(".table_files_history").DataTable({"order":[[3,"desc"]]});
	}); 
	$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
		event.preventDefault();
		$(this).ekkoLightbox();
	}); 
</script>

