<?php if(ENVIRONMENT == 'development'){$this->output->enable_profiler(TRUE);}?>
<!DOCTYPE html>
<html lang="zh-CN">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
	<meta charset="utf-8">
	<title><?=(isset($title)?($title).' - ':'').$this->dconf->get('site_name','无标题');?></title>
	<link rel='stylesheet' href='<?=static_url("common.css");?>' />
</head>
<body>

<div id="container">
	<h1 style="cursor:pointer;" onclick="window.location='<?=site_url('/');?>'"><?=$this->dconf->get('site_name','无标题');?></h1>
	<?php if(isset($nav)):?>
	<div class="nav">
		<ul>
			<?php foreach($nav as $item):?>
			<li style="width:<?=100/(count($nav));?>%"><?=$item;?></a></li>
			<?php endforeach;?>
		</ul>
	</div>
	<?php endif; //for nav ?>
	<?php if(isset($info) && $info):?>
	<div class="flash <?=isset($infoclass)?$infoclass:'info';?>" id="the_tip">
		<?=$info;?>
	</div>
	<script>
		setTimeout('document.getElementById("the_tip").style.display="none"',5000);
	</script>
	<?php endif; //for flash info ?>