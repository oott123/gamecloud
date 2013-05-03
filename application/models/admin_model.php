<?php
	class Admin_model extends CI_Model {
		var $u;
		function __construct(){
			parent::__construct();
			$this->load->model('admin_check');
			$this->u = $this->session->userdata('u');
		}
		function change_password($p){
			if($this->u == 'demo'){
				die('Cannot change the password for demo user. :)');
			}
			$salt_password = $this->admin_check->_saltpassword($p);
			$this->db->where('username',$this->u);
			$this->db->update('adminauth',array(
				'username' => $this->u,
				'password' => $salt_password,
			));
		}
	}