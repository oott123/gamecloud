	<div id="body">
		<h2>神秘的登录入口</h2>
		<?=form_open('',array('target'=>'_self'));?>
		<p><?=form_label('用户名<br />','u');?><?=form_input('u');?></p>
		<p><?=form_label('密码<br />','p');?><?=form_password('p');?></p>
		<p><?=form_submit('','登录');?></p>
	</div>