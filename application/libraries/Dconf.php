<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	//Dconf class
	//database-based config class
	//used only when active record and db auto connect is powered on
	class Dconf{
		var $CI = false;	//the CI instance
		var $dconf_db = 'config';	//the dconf_db . it should be set in the config/advance.php
		var $fastcache = array();	//fastcache array. it will store all the config which is selected from the database in oreder to fasten the same config request in one time.
		public function __construct(){
			//construct : set $this->CI to the CI instance.
			if(!$this->CI){
				$this->CI =& get_instance();
				$this->dconf_db=$this->CI->config->item('dconf_db');
			}
			if($this->CI->config->item('dconf_cacheall')){
				$query = $this->CI->db->get($this->dconf_db);
				foreach ($query->result() as $row){
					$this->fastcache[$row->name]=$row->value;
				}
			}
		}
		public function get($name,$default=false){
			//get : get the config from the fast cache if existed,
			//	or get it from the database.
			if(isset($this->fastcache[$name])){
				return $this->fastcache[$name];
			}
			$query = $this->CI->db->get_where(
				$this->dconf_db,
				array(
					'name' => $name,
				)
			);
			if($query->num_rows() > 0){
				$row = $query->row();
				$this->fastcache[$name]=$row->value;
				return $row->value;
			}else{
				return $default;
			}
		}
		public function set($name,$value){
			//set : update (or set if it has not exist) the fast cache and set the value to the database.
			//returns the value has been set.
			if(isset($this->fastcache[$name])){
				unset($this->fastcache[$name]);
			}
			$this->CI->db->where('name' , $name);
			$this->CI->db->update(
				$this->dconf_db,
				array(
					'value' => $value,
				)
			);
			$this->fastcache[$name]=$value;
			return $value;
		}
		public function flushcache($val=false){
			//flush cache.
			//when val = false, flush all cache.
			if($val){
				//clean the cache if is set
				if(isset($this->fastcache[$val])){
					unset($this->fastcache[$val]);
				}else{
					return false;
				}
				//Dont do below : unset cannot get a return value
				//isset($this->fastcache[$val]) && unset($this->fastcache[$val])
				//isset($this->fastcache[$val]) ? unset($this->fastcache[$val]) : return false;
			}else{
				//clean all the fastcache.
				$this->fastcache=array();
			}
			return true;
		}
	}
/* End of file Dconf.php */