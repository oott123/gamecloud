<script charset="utf-8" src="<?=static_url('kindeditor/kindeditor.js');?>"></script>
<script charset="utf-8" src="<?=static_url('kindeditor/lang/zh_CN.js');?>"></script>
<script>
	<?php foreach($editor as $name):?>
	var editor<?=$name;?>;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="<?=$name;?>"]', {
			allowFileManager : true,
			uploadJson : '<?=site_url("upload/");?>',
			fileManagerJson : '<?=site_url("upload/fileman/");?>',
			extraFileUploadParams: {
        "<?php echo $this->security->get_csrf_token_name();?>" : "<?php echo $this->security->get_csrf_hash(); ?>"
},
			langType:'en',
		});
	});
	<?php endforeach;?>
</script>