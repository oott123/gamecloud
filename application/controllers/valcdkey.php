<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Valcdkey extends CI_Controller {
		function __construct(){
			parent::__construct();
			$this->load->model('Nav_model', 'nm');
			$this->load->helper('form');
		}
		public function index(){
			$p = $this->input->post(NULL, TRUE);
			$tips = '';
			if(isset($p['submit'])){
				$this->load->model('Cdkeys_model', 'cm');
				$this->load->model('Items_model', 'im');
				$res = $this->cm->validate_cdkeys($p['key']);
				if(isset($res['key'])){
					if($p['pwd'] && $res['pwd'] != $p['pwd']){
						$tips.="<div class='flash error'>您输入的CDK密码与CDKEY不匹配，请注意验证。</div>";
					}
					$tips.="<div class='flash info'>";
					$tips.="您查询的CDKEY所含内容为：";
					if($res['type']=='gold'){
						$tips .= "金币";
					}else{
						$rs = $this->im->get_item($res['tid']);
						$tips .= (isset($rs['name']) && $rs['name'])?$rs['name']:'神秘的物品';
					}
					$tips.=" x ".abs($res['amount'])."</div>";
				}else{
					$tips.="<div class='flash error'>您输入的CDKEY不存在，请注意验证。</div>";
				}
			}
			$this->load->view('common/header',array(
				'nav'=>$this->nm->get_main_nav(),
				'title'=>'验证CDKEY',
				'tips'=>$tips,
			));
			$this->load->view('valcdkey');
			$this->load->view('common/footer');
		}
		public function api($key,$pwd,$del = 1){
			$this->load->model('Cdkeys_model', 'cm');
			$this->load->model('Items_model', 'im');
			$res = $this->cm->validate_cdkeys($key,$pwd,$del);
			if(isset($res['pwd']) && $res['pwd'] == $pwd){
				echo 'ok|'.$res['type'].'|'.$res['tid'].'|'.abs($res['amount']);
			}else{
				echo 'error';
			}
		}
	}
//EOF