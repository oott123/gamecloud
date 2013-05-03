<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Modify extends CI_Controller {
		var $info;
		var $u;
		function __construct(){
			parent::__construct();
			$this->load->model('admin_check');
			if(!$this->admin_check->is_login() && uri_string()!='modify/login' ){
				//header("HTTP/1.1 301 Moved Permanently");
				//header("Location:".site_url('modify/login'));
				$loginurl=site_url('modify/login');
				die('<a href="'.$loginurl.'">登录</a>失败。<script>window.location="'.$loginurl.'";</script>');
			}
			$this->load->helper('form');
			$this->load->model('admin_model','am');
			$this->info=array('class'=>'ok','info'=>'');
			$this->u = $this->session->userdata('u');
		}
		private function _getnav(){
			return array(
				anchor(site_url('modify/logout'),'登出'),
				anchor(site_url('modify/password'),'修改密码'),
				anchor(site_url('modify/base'),'基本设定'),
				anchor(site_url('modify/listcdkeys'),'CD-KEY管理'),
				anchor(site_url('modify/items'),'物品管理'),
				anchor(site_url('modify/pages'),'单页管理'),
			);
		}
		public function index(){
			$this->load->view('common/header',array(
				'nav'=>$this->_getnav(),
				'title'=>'管理中心',
			));
			$this->load->view('admin_index');
			$this->load->view('common/footer');
		}
		public function login(){
			$u = $this->input->post('u');
			$p = $this->input->post('p');
			if($u && $p){
				$this->admin_check->login($u,$p);
				$loginurl=site_url('modify/index');
				die('请稍等…… <a href="'.$loginurl.'">如果你的浏览器没有跳转，请点击这里。</a> <script>window.location="'.$loginurl.'";</script>');
			}
			if($this->admin_check->is_login()){
				$loginurl=site_url('modify/index');
				die('您已登录。<a href="'.$loginurl.'">如果您的浏览器没有跳转，请点击这里。</a> <script>window.location="'.$loginurl.'";</script>');
			}
			$this->load->view('common/header',array(
				'nav'=>array(),
				'title'=>'登录',
			));
			$this->load->view('admin_login');
			$this->load->view('common/footer');
		}
		public function logout(){
			$this->admin_check->logout();
			$loginurl=site_url('/');
			die('您已退出。<a href="'.$loginurl.'">返回首页</a> <script>window.location="'.$loginurl.'";</script>');
		}
		public function password(){
			$p = $this->input->post('p');
			$p2 = $this->input->post('p2');
			if($p !== FALSE){
				if($p == $p2){
					$this->am->change_password($p);
					$this->info['info']='密码修改成功。您可能需要重新登录才能进行其它操作。';
				}else{
					$this->info['info']='两次输入的密码不一致，请重试。';
					$this->info['class']='error';
				}
			}
			$this->load->view('common/header',array(
				'nav'=>$this->_getnav(),
				'title'=>'修改密码',
				'info'=>$this->info['info'],
				'infoclass'=>$this->info['class']
			));
			$this->load->view('admin_changepassword');
			$this->load->view('common/footer');
			
		}
		public function base(){
			if($this->input->post('site_name')!==FALSE){
				$this->dconf->set('site_name',$this->input->post('site_name'));
				$this->dconf->set('copyright',$this->input->post('copyright'));
				$this->dconf->set('index',$this->input->post('index'));
				$this->info['info']='设定已保存。';
			}
			$this->load->view('common/header',array(
				'nav'=>$this->_getnav(),
				'title'=>'基础设定',
				'info'=>$this->info['info'],
				'infoclass'=>$this->info['class']
			));
			$this->load->view('admin_base');
			$this->load->view('common/editor',array(
				'editor'=>array('index'),
			));
			$this->load->view('common/footer');
		}
		public function pages($m='index',$id=0,$csrf=FALSE){
			$p = $this->input->post('title');
			$d = $this->input->post(NULL, TRUE);
			$this->load->model('pages_model','pm');
			if($m=='del'){
				if($csrf != $this->security->get_csrf_hash()){
					$this->security->csrf_show_error();
				}else{
					$this->pm->delete_page($id);
					$this->info['info']='页面删除成功。';
				}
			}elseif($m == 'edit' && $p){
				unset($d['m']);
				$this->pm->update_page($id,$d);
				$this->info['info']='页面已修改。';
			}elseif($m == 'add' && $p){
				unset($d['m']);
				$this->pm->add_page($d);
				$this->info['info']='页面已添加。';
			}
			$this->load->library('table');
			$this->load->view('common/header',array(
				'nav'=>$this->_getnav(),
				'title'=>'单页管理',
				'info'=>$this->info['info'],
				'infoclass'=>$this->info['class']
			));
			if($m == 'index'){
				$list = $this->pm->get_all_pages();
				$newlist[] = array('页面标题','顺序','编辑','删除');
				foreach($list as $row){
					$newlist[] = array(
						$row['title'],
						$row['order'],
						anchor(site_url('modify/pages/edit/'.$row['id']),'编辑'),
						anchor(site_url('modify/pages/del/'.$row['id'].'/'.$this->security->get_csrf_hash()),'删除'),
					);
				}
				$this->load->view('admin_pages',array(
					'm'=>$m,
					'id'=>$id,
					'list'=>$newlist,
				));
			}elseif($m == 'edit' || $m == 'add'){
				$data = $this->pm->get_page($id);
				$this->load->view('admin_editpages',array(
					'm'=>$m,
					'id'=>$id,
					'data'=>$data,
				));
				$this->load->view('common/editor',array(
					'editor'=>array('content'),
				));
			}
			$this->load->view('common/footer');
		}
		
		public function items($m='index',$csrf=FALSE){
			$p = $this->input->post('title');
			$d = $this->input->post(NULL, TRUE);
			$this->load->model('items_model','im');
			if($m=='mod'){
				$itemrow = explode(PHP_EOL,$d['item']);
				$items = array();
				foreach($itemrow as $t){
					$ta = explode('=',$t,2);
					if(count($ta)>1){
						$items[]=array(
							'id' => $ta[0] + 0,
							'name' => trim($ta[1]),
						);
					}
				}
				$this->im->update_items($items);
				$this->info['info']='更新成功。';
			}
			$this->load->view('common/header',array(
				'nav'=>$this->_getnav(),
				'title'=>'物品管理',
				'info'=>$this->info['info'],
				'infoclass'=>$this->info['class']
			));
			
			$all = $this->im->get_all_items();
			$all2 = '';
			foreach($all as $one){
				$all2 .= $one['id'].'='.$one['name'].PHP_EOL;
			}
			$this->load->view('admin_items',array(
				'iteminfo' => $all2,
			));
			$this->load->view('common/footer');
		}
		public function listcdkeys($page=1){
			$p = $this->input->post(NULL, TRUE);
			$this->load->model('Cdkeys_model','cm');
			if(isset($p['del']) && isset($p['delthis'])){
				$this->cm->delete_cdkeys($p['del']);
				$this->info['info'] = '删除成功。';
			}
			$this->load->view('common/header',array(
				'nav'=>$this->_getnav(),
				'title'=>'CDKEY管理',
				'info'=>$this->info['info'],
				'infoclass'=>$this->info['class']
			));
			
			$all = $this->cm->get_cdkeys($page+0);
			$this->load->library('pagination');
			$config['first_link'] = '第一页';
			$config['last_link'] = '最后页';
			$config['next_link'] = '下一页';
			$config['prev_link'] = '上一页';
			$config['num_links'] = 5;
			$config['base_url'] = site_url('modify/listcdkeys/');
			$config['total_rows'] = $this->cm->count_cdkeys();
			$config['use_page_numbers'] = TRUE;
			$config['per_page'] = 30;
			$this->pagination->initialize($config);
			$pages = $this->pagination->create_links();
			$this->load->library('table');
			$a2 = array();
			foreach($all as $a){
				if($a['type']=='gold'){
					$a['type']='金币';
					$a['tid']='-';
				}elseif($a['type']=='item'){
					$a['type']='道具';
					$this->load->model('items_model','im');
					$tid = $this->im->get_item($a['tid']);
					if(isset($tid['name'])){
						$a['tid']=$tid['name'];
					}
				}
				$a2[]=array($a['id'],$a['key'],$a['pwd'],$a['type'],$a['tid'],$a['amount'],$a['comment'],
					form_checkbox('del[]', $a['id']));
			}
			$this->load->view('admin_listcdkeys',array(
				'all' => $a2,
				'pages' => $pages,
			));
			$this->load->view('common/footer');
		}
		public function addcdkeys(){
			$p = $this->input->post(NULL, TRUE);
			$this->load->model('cdkeys_model','cm');
			$dataset = array();
			if(isset($p['submit'])){
				$dataset = $this->cm->gen_cdkey($p['type'],$p['tid']+0,$p['amount']+0,$p['comment'],$p['cdknum']+0);
				$this->info['info'] = '已生成。';
			}
			$this->load->model('items_model','im');
			$itemlist = $this->im->get_all_items();
			$itemlist2 = array();
			foreach($itemlist as $item){
				$itemlist2[$item['id']]=$item['name'];
			}
			$dataset2 = $dataset;
			$dataset = array();
			foreach($dataset2 as $data){
				$dataset[]=array($data['key'],$data['pwd']);
			}
			$this->load->library('table');
			$this->table->set_heading('CDKEY','CDKEY密码');
			$this->load->view('common/header',array(
				'nav'=>$this->_getnav(),
				'title'=>'CDKEY生成',
				'info'=>$this->info['info'],
				'infoclass'=>$this->info['class'],
			));
			$this->load->view('admin_addcdkeys',array(
				'dataset' => $dataset,
				'itemlist' => $itemlist2,
			));
			$this->load->view('common/footer');
		}
	}