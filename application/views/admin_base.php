	<div id="body">
		<h2>站点基本设置</h2>
		<?=form_open('',array('target'=>'_self'));?>
		<p><?=form_label('站点名字<br />','site_name');?>
		<?=form_input('site_name',$this->dconf->get('site_name',''));?> 站点的名字。
		</p>
		<p><?=form_label('版权信息<br />','copyright');?>
		<?=form_input('copyright',$this->dconf->get('copyright',''));?> 页脚版权信息。
		</p>
		<p><?=form_label('欢迎页面信息<br />','copyright');?>
		<?=form_textarea('index',$this->dconf->get('index',''));?>
		</p>
		<p><?=form_submit('','提交');?></p>
	</div>