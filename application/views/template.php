<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content=""> 
    <meta name="author" content="">
    <title><? echo $title; ?></title>
    <script type="text/javascript" src="<? echo base_url('core/jquery/jquery.js'); ?> "></script>
	<link href="<? echo base_url('core/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<? echo base_url('core/bootstrap/css/bootstrap-theme.css'); ?>" rel="stylesheet">	

</head>
<body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="<?  echo base_url(); ?>"><? echo $title; ?></a>
		</div>
		<? if($this->session->logon == 1){ ?>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="<?  echo base_url('user/logout.html'); ?>">Выход <? echo $this->session->name; ?></a></li>
		</ul>
		<?	}	?>
	  </div>
	</nav>
	  <div class="container">	
<?
	if($this->session->flashdata('info_message') != ''){
		echo '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$this->session->flashdata('info_message').'</div>'; 
	}
	if($this->session->flashdata('error_message') != ''){
		echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$this->session->flashdata('error_message').'</div>'; 
	}
?>	
	  </div>
	<? echo $content; ?>
	    <script type="text/javascript" src="<? echo base_url('core/bootstrap/js/bootstrap.min.js'); ?>"></script>
</body>
</html>
