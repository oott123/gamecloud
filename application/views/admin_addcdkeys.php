	<div id="body">
		<h2>CDKEY生成</h2>
		<?=$this->table->generate($dataset);?>
		<?=form_open('',array('target'=>'_self'));?>
		<p><?=form_label('CDKEY数量<br />','cdknum');?>
		<?=form_input('cdknum','30');?> 要生成的CDKEY的数量。
		</p>
		<p><?=form_label('CDKEY类型<br />','type');?>
		<?=form_dropdown('type',array('gold'=>'金币','item'=>'物品'),'item');?> CDK对应的类型
		</p>
		<p><?=form_label('物品<br />','tid');?>
		<?=form_dropdown('tid',$itemlist);?> 若为物品请选择；否则请忽略
		</p>
		<p><?=form_label('数目<br />','amount');?>
		<?=form_input('amount','1');?> 一个CDK获取对应物品的数量，若为负则不限制CDK使用次数，若为正则仅可使用一次。
		</p>
		<p><?=form_label('备注<br />','comment');?>
		<?=form_input('comment',date('Y-m-d 生成的').'CDKEY');?>
		</p>
		<p><?=form_submit('submit','提交');?></p>
	</div>