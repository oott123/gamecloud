	<div id="body">
		<h2>CDKEY 验证</h2>
		<?=form_open();?>
		<?=$tips;?>
		<p><?=form_label('8位数CDKEY<br />','key');?><?=form_input('key');?></p>
		<p><?=form_label('6位数CDK密码（可以留空）<br />','pwd');?><?=form_password('pwd');?></p>
		<p><?=form_submit('submit','验证CDK');?></p>
	</div>