	<div id="body">
		<h2>修改密码</h2>
		<?=form_open('',array('target'=>'_self'));?>
		<p><?=form_label('新密码<br />','p');?><?=form_password('p');?></p>
		<p><?=form_label('你觉得这个空是干嘛的呢？<br />','p2');?><?=form_password('p2');?></p>
		<p><?=form_submit('','提交');?></p>
	</div>