	<div id="body">
		<h2>CDKEY列表 <?=anchor(site_url('modify/addcdkeys/'),'[生成]');?></h2>
		<?php
			echo form_open();
			$js = "<input type='checkbox' onclick='checkall(this)' />";
			$js.= <<<JS
<script>
	function checkall(box){
		var boxs = document.getElementsByTagName('input');
		for (x in boxs){
			if(boxs[x].type == 'checkbox'){
				boxs[x].checked = box.checked;
			}
		}
	}
</script>

JS;
			$this->table->set_heading(array('序号','CDKEY','CDK密码','类别','对应ID','数量','备注',$js));
		?>
		<?=$this->table->generate($all);?>
		<?=form_submit('delthis','删除选中的CDK');?>
		<?=$pages;?>
	</div>