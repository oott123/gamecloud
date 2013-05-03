	<div id="body">
		<h2>单页列表 <?=anchor(site_url('modify/pages/add/'.$id),'[新建]');?></h2>
		<?=$this->table->generate($list);?>
	</div>