<?php
	//add the static url helper functions
	function static_url($uri=''){
		$CI =& get_instance();
		$surls = $CI->config->item('static_url');
		if($CI->config->item('static_enable') && count($surls)>0){
			return $surls[array_rand($surls)].$uri;
		}else{
			return $CI->config->base_url('static/'.$uri);
		}
	}