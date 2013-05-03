<?php
	class Nav_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->model('Pages_model', 'pgm');
		}
		function get_main_nav(){
			$nav = array(
				anchor(site_url('/'),'首页'),
				anchor(site_url('valcdkey/'),'CDKEY验证'),
			);
			foreach($this->pgm->get_all_pages() as $page){
				$nav[]=anchor(site_url('pages/view/'.$page['id']),$page['title']);
			}
			return $nav;
		}
	}