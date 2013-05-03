<?php
	function getinfo($key,$data){
		return isset($data[$key])?$data[$key]:'';
	}
?>
	<div id="body">
		<?=form_open('',array('target'=>'_self'));?>
		<h2>新建/编辑页面</h2>
		<?=form_hidden('m',$m);?>
		<?=form_hidden('id',$id);?>
		<p><?=form_label('页面标题<br />','name');?>
		<?=form_input('title',getinfo('title',$data));?> 页面的标题，建议不超过4个字</p>
		<p><?=form_label('页面内容<br />','content');?>
		<?=form_textarea('content',getinfo('content',$data));?>
		</p>
		<p><?=form_label('排序<br />','order');?>
		<?=form_input('order',getinfo('order',$data));?> 页面排序的顺序值，越小越考前。
		</p>
		<p><?=form_submit('','提交');?></p>
	</div>