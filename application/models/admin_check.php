<?php
	//admin check model
	//do admin checks and login/logout
	class Admin_check extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->library('session');
			$this->load->database();
		}
		public function is_login(){
			$u = $this->session->userdata('u');
			$p = $this->session->userdata('p');
			if($u && $p){
				if($this->_checklogin($u,$p)){
					return true;
				}
			}
			return false;
		}
		public function is_login_or_die(){
			if($this->is_login()){
				return true;
			}else{
				show_error(
					'You have to login before access to this page.'
						.anchor(site_url(),'Back to main','target=_self'),
					400,'Not Authorized.'
				);
			}
		}
		public function login($username,$password){
			if($this->_checklogin($username,$password)){
				$this->session->set_userdata(array(
					'u'=>$username,
					'p'=>$password,
				));
				return true;
			}
			return false;
		}
		public function logout(){
			$this->session->sess_destroy();
		}
		private function _checklogin($username,$password){
			$salt_password = $this->_saltpassword($password);
			$query = $this->db->get_where('adminauth',array(
				'username' => $username,
				'password' => $salt_password
			));
			if($query->num_rows() < 1){
				return false;
			}else{
				return $query->row_array();
			}
		}
		public function _saltpassword($password){
			return md5('Hello'.md5($password).'33');
		}
	}