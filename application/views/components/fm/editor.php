<div class="container">
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
			<? echo form_open_multipart(base_url().'fm/save.html'); ?>
			<fieldset>
				<legend><? echo $legend; ?></legend>
				<div class="form-group">
					<label for="name" class="col-md-3 control-label">Название файла:</label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="name" name="name" placeholder="Название файла" value="<? echo set_value('name', $name); ?>">
						<small class="text-center"><? echo form_error('name'); ?></small>
					</div>
				</div>
				<div class="form-group">
					<label for="description" class="col-md-3 control-label">Краткое описание:</label>
					<div class="col-md-9">
						<textarea class="form-control" rows="3" id="description" name="description"><? echo set_value('description', $description); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="file" class="col-md-3 control-label">Файл:</label>
					<div class="col-md-9">
						<? if(isset($isfile)){ ?><p class="alert alert-dismissible alert-danger text-center"><small><? echo $isfile; ?></small></p><? }?>
						<input type="file" class="form-control" id="file" name="file" accept="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/pdf" value="<? echo set_value('file'); ?>">
						<small class="text-center"><? echo form_error('file'); ?></small>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-4">
						<? if(isset($id)){ echo form_hidden('id', $id); }?>
						<? echo form_submit('send', 'Сохранить','class="btn btn-primary btn-md"'); ?>	
					</div>
				</div>
			  </fieldset>
			<? echo form_close(''); ?>			
        </div>
    </div>
</div>