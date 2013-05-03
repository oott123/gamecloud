<?php
	//static url for cdn or else use
	$config['static_enable']=false;
	$config['static_url'][]='http://static1/';
	$config['static_url'][]='http://static2/';
	
	//config database and do NOT change unless you know what you are doing
	$config['dconf_db']='config';
	
	$config['dconf_cacheall']=true;	//cache all config in one time request.
	