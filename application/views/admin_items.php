	<div id="body">
		<h2>物品管理</h2>
		<?=form_open('modify/items/mod',array('target'=>'_self'));?>
		<p><?=form_label('新物品信息<br />','item');?>
		<?=form_textarea('item',$iteminfo);?>
		<br />请从RM导出，以【1=超级药水】的格式，一行一个。
		</p>
		
		<p><?=form_submit('','提交');?></p>
	</div>