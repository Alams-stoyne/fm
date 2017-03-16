<div class="container">
    <div class="row">
        <div class="col-md-offset-5 col-md-3">
			<? echo form_open(base_url().'user/login.html'); ?>
            <div class="form-login">
				<h4>Добро Пожаловать!</h4>
					<input type="text" name="login" class="form-control input-sm chat-input" placeholder="Введите Логин" value="<? echo set_value('login'); ?>" />
					<small class="text-center"><? echo form_error('login'); ?></small></br>
					<input type="text" name="password" class="form-control input-sm chat-input" placeholder="Введите Пароль" value="<? echo set_value('password'); ?>" />
					<small class="text-center"><? echo form_error('password'); ?></small></br>
				<div class="wrapper">
					<span class="group-btn">   
						<? echo form_submit('send', 'Войти','class="btn btn-primary btn-md"'); ?>					
					</span>
				</div>
            </div>   
			<? echo form_close(''); ?>			
        </div>
    </div>
</div>