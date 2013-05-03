<?php
	class Pages extends CI_Controller {
		function __construct(){
			parent::__construct();
			$this->load->model('Pages_model', 'pgm');
			$this->load->model('Nav_model', 'nm');
		}
		function view($pageid){
			$page = $this->pgm->get_page($pageid);
			$this->load->view('common/header',array(
				'title'=>$page['title'],
				'nav'=>$this->nm->get_main_nav(),
			));
			$this->load->view('common/page',$page);
			$this->load->view('common/footer');
			
		}
	}